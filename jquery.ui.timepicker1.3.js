/*
 * timepicker - jQuery Plugin
 *
 * 
 * Copyright (c) 2010 Aaldert van Weelden
 *
 * Version: 1.2 (15/09/2010)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
(function($) {
    
	var flgBusy        = false,
		flgMode		   = '',
	    oMatrix        = {},
	    oWrap          = {},
	    oTime          = {},
	    oHour          = {},
	    oInput         = {},
	    oClose         = {},
	    oMinute        = {},
	    oOptions       = {},
		oCommonOpts	   = {},
		aSelected      = [],
		
	//Private helper methods=============================================== 
	_reset = function () {
			oMatrix.removeClass('ui-state highlight ui-state-active');
		},
	_setMinutes = function(hour){
    		    var html,
					minutes,
    		        aHtml;
    		    $('#tbl_minute a').each(function(){
    		    html=$(this).html();
    		    aHtml=html.split(':');
    		    if(hour){
    		        oMatrix.hour=hour;
    		    }
				minutes=aHtml[1];
				minutes=minutes.replace('am', '');
				minutes=minutes.replace('pm', '');
    		    $(this).html(oMatrix.hour+':'+minutes+'<i>'+flgMode+'</i>');
    		      
		    });
		    
		},
	_setTime = function(end){
		    var result,
				complete=false;
			
		    oMatrix.minute=='0'?oMatrix.minute='00':void(0);
		    result=oMatrix.hour+':'+oMatrix.minute+flgMode;
		    oTime.html(result);
		    if(end){
		      $(oInput).val(result);
			  complete=true;
		    }
			$(oWrap).trigger('onselect',[result,complete]);
		},
	_showHours = function(){
		    oHour.css({
			    'background-color'           : 'transparent'
			});
		},
    _hideHours = function(){
		    oHour.fadeTo(300,0.3);
	    },
	_showMinute = function(){
	    oMinute.slideDown(600);
	   },
	_hideMinute = function(){
	    oMinute.css('display','none');
	   },
	_getPosition = function(){
	        var left,
	            top,
	            space,
	            offset         = $(oInput).offset(),
	            input          = $(oInput).height(),
	            screen         = $(window).height(),
	            scroll         = $(document).scrollTop(),
	            panelMinute    = 80,
	            panelHour      = oWrap.outerHeight();
	               
	        space=screen-offset.top+scroll-input-panelHour-panelMinute;
	        offset.left+=oOptions[oInput.identifier].offsetLeft;
	        if(space>0){
	            offset.top+= input+oOptions[oInput.identifier].offsetTop+10;
	        }
	        else{
	            offset.top-= panelHour+oOptions[oInput.identifier].offsetTop+10;
	        }
		    return offset;
	    },
		
	_getHourHTML = function(){
			var obj=oOptions[oInput.identifier],
				hourHTML,
				cr=1,
				lengte;

			hourHTML='<tr>';
			try
			{
				if(obj.hourFormat==24){
					lengte=obj.hour24.length;
					for(var t=0;t<lengte;t++){
					
						if( typeof(obj.hour24[t]) ==='string' ){
							hourHTML+='<td><a class="ui-timepicker-unselectable ui-state-disabled">'+obj.hour24[t]+'</a></td>';
						}
						else{
							hourHTML+='<td><a rel="h_24_'+obj.hour24[t]+'">'+obj.hour24[t]+':00</a></td>';
						}
						
						if(cr==obj.hourCols){
							hourHTML+='</tr><tr>';
							cr=0;
						}
						cr++;
					}
					
				}
				
				else if(obj.hourFormat==12){
					lengte=obj.hourAM.length;
					for(var t=0;t<lengte;t++){
						if( typeof(obj.hourAM[t]) ==='string' ){
							hourHTML+='<td><a class="ui-timepicker-unselectable ui-state-disabled">'+obj.hourAM[t]+'</a></td>';
						}
						else{
							hourHTML+='<td><a rel="h_am_'+obj.hourAM[t]+'">'+obj.hourAM[t]+':00<i>am</i></a></td>';
						}
						
						if(cr==obj.hourCols){
							hourHTML+='</tr><tr>';
							cr=0;
						}
						cr++;
					}
					
					hourHTML+='</tr><tr><td colspan="'+obj.hourCols+'" class="ui-timepicker-unselectable ui-timepicker-divider ui-state-disabled">&nbsp;</td></tr><tr>';
					cr=1;
					lengte=obj.hourPM.length;
					for(var t=0;t<lengte;t++){
						if( typeof(obj.hourPM[t]) ==='string' ){
							hourHTML+='<td><a class="ui-timepicker-unselectable ui-state-disabled">'+obj.hourPM[t]+'</a></td>';
						}
						else{
							hourHTML+='<td><a rel="h_pm_'+obj.hourPM[t]+'">'+obj.hourPM[t]+':00<i>pm</i></a></td>';
						}
						if(cr==obj.hourCols){
							hourHTML+='</tr><tr>';
							cr=0;
						}
						cr++;
					}
				}
			}
			catch(e){
				hourHTML='<td>&nbsp;<td>';
			}
			hourHTML+='</tr>';
			return {'html': hourHTML, 'cols': obj.hourCols};
		},
		
	_getMinuteHTML = function(){
			var minute=[],
				minDivision,
				minuteHTML,
				lengte,
				cr=1,
				minCols;
				
			//preformatted table	
			minute[30]	= [0,30];//2
			minute[20]	= [0,20,30];//3
			minute[15]	= [0,15,30,45];//4
			minute[12]	= [0,12,24,36,48];//5
			minute[10]	= [0,10,20,30,40,50];//6
			minute[5]	= [0,5,10,15,20,25,30,35,40,45,50,55];//12
			
			minDivision=oOptions[oInput.identifier].minDivision;
			
			try
			{	
				if(typeof(minDivision) === 'number'){
					minDivision=minute[minDivision];
				}
				if(typeof(minDivision) === 'undefined'){
					minDivision=minute[$.fn.timepicker.defaults.minDivision];
				}
				if( $.isArray(minDivision) ){
					lengte = minDivision.length;
					minCols=6;
					if(lengte<7){
						minCols=lengte;
					}
					else if(lengte>6 && lengte<11){
							minCols=Math.round(lengte/2);
					}
					minuteHTML='<tr>';
					for(var t=0;t<lengte;t++){
						minDivision[t]<10?minDivision[t]='0'+minDivision[t]:void(0);
						minuteHTML+='<td><a rel="m_'+minDivision[t]+'">00:'+minDivision[t]+'</a></td>';
						
						if(cr==minCols){
							minuteHTML+='</tr><tr>';
							cr=0;
						}
						cr++;
					}
					minuteHTML+='</tr>';
					return {'html': minuteHTML, 'cols': minCols};
				}
				else{
					minuteHTML='<tr><td>&nbsp;</td></tr>';
					return {'html': minuteHTML, 'cols': minCols};
				}
			}
			catch(e){
				minuteHTML = '<tr><td>minDivision wrong format!'+e+'</td></tr>';
				return {'html': minuteHTML, 'cols': minCols};
			}
	
		},
	_drawTable = function(){
		   var obj=oOptions[oInput.identifier],
			   hour=_getHourHTML(),
			   minute=_getMinuteHTML(),
			   
	           header =     '\n<div class="ui-timepicker-header ui-widget-header ui-helper-clearfix ui-corner-all">'
                            +'<a class="ui-timepicker-close ui-corner-all" title="Close" id="btn_close"><span class="ui-icon ui-icon-circle-close">Close</span></a>'
                            +'<div class="ui-timepicker-title">'
                            +'<span class="ui-timepicker-timeresult" id="timeresult">00:00</span>'
                            +'</div></div>\n',

			    tbl    =     '<div id="hour_overlay"><table class="ui-timepicker-hourtable" id="tbl_uur">'
                           + '<thead><!-- clickhandler op td -->'
                           +    '<tr>'
                           +         '<th colspan="'+hour.cols+'" class="ui-timepicker-header"><span class="ui-timepicker-title" title="Uren">'+ obj.hourCaption +'</span></th>'
                           +     '</tr>'
                           +    '<tr>'
                           +        '<td  colspan="'+hour.cols+'" class="ui-timepicker-unselectable ui-state-disabled">&nbsp;</td>'
                           +     '</tr>'
                           +      '</thead>'     
                           +      '<tbody>'
						   + hour.html
                           +    '<tr>'
                           +        '<td  colspan="'+hour.cols+'" class="ui-timepicker-unselectable ui-state-disabled">&nbsp;</td>'
                           +     '</tr>'
                           +     '</tbody>'
                           + '</table></div>'
                           + '<div id="min_overlay"><table class="ui-timepicker-minutetable" id="tbl_minute">'
                           + '<thead><!-- clickhandler op td -->'
                           +     '<tr>'
                           +         '<th colspan="'+minute.cols+'" class="ui-timepicker-header"><span class="ui-timepicker-title" title="Minuten">'+ obj.minuteCaption +'</span></th>'
                           +    '</tr>'
                           +      '</thead>'      
                           +      '<tbody>'      
                           + minute.html
                           +    '<tr>'
                           +         '<td colspan="'+minute.cols+'" class="ui-timepicker-unselectable ui-state-disabled">&nbsp;</td>'
                           +     '</tr>'
                           +     '</tbody>'
                           + '</table></div>';
            //end html=====================================================
            return header+tbl;
	       
	    },
	
	_checkExternalClick = function(event) {
    		if (event.target.className.indexOf('ui-')==-1 ){
    			timepicker_hide();
				$('body').unbind('click.tp_hide');
    		}
	   },
	_handler = function(e){
		    
		    var btn,
    		    aSwitch=[],
				mode;
				
			if( typeof(e.target.rel) === 'undefined' ){
				btn=e.target.parentNode;
			}
			else{
				btn=e.target;
			}
			aSwitch=btn.rel.split('_');
			
    		flgBusy = true;
    		_reset();
			
    		if(aSwitch[0]=='h'){//urentabel
			
				mode=aSwitch[1];
				if(mode=='24'){
                    flgMode='';
                }
                else {
                    flgMode=' '+mode;
                }
           
				
    		    oMatrix.hour=aSwitch[2];
    		    oMatrix.minute='00';
				
    		    _setMinutes();
    		    _setTime();
    		    _hideHours();
    		    _showMinute();
    		}
    		else if(aSwitch[0]=='m'){//minutentabel
					oMatrix.minute=aSwitch[1];
					_setTime(true);
					
					if(oOptions[oInput.identifier].closeOnComplete){
						timepicker_hide();
					}
				}
				else{
					return false;//disabled hour
				}
			$(btn).addClass('ui-state highlight ui-state-active');
    		flgBusy = false;
		},
		
	_getIdentifier = function(obj){
			if(obj.id){
				obj.identifier=obj.id;
			}
			else if(obj.name){
				obj.identifier=obj.name;
				}
				else{
					obj.identifier=0; 
				}
			return obj.identifier;
		},
	_check = function(obj){
			return ( typeof(obj) !== 'undefined' && obj !== {} ); 
		},
	//private timepicker methods
	timepicker_show = function(time,force) {
		    !time?time=500:void(0);
		    var offset=_getPosition();
		    oWrap.css({
		        'left' : offset.left,
		        'top'  : offset.top
		    });
		    if(!force){
		        oWrap.trigger('beforeshow');
		    }
		    if(oOptions[oInput.identifier].openOnClick || force){
			     oWrap.show(time);
		    }
		},
	timepicker_hide = function(time){
	       !time?time=300:void(0);
	       oWrap.hide(time);
    	   oTime.html('00:00');
    	   oMatrix.minute='00';
    	   oWrap.trigger('onclose');
    	   
    	   _showHours();
    	   _reset();
    	   _setMinutes('00'); 
    	   _hideMinute();
	    
	       flgBusy = false;
	    },
	timepicker_start = function(id) {
			var obj	= oInput;
			
			oOptions[obj.identifier] = $.extend({}, $.fn.timepicker.defaults, $(oCommonOpts).data('timepicker'), $(obj).data('timepicker'));
			
			//element references
            oWrap=$('#ui-timepicker-div');
			oWrap.css('display','none');
			              
            oWrap.html(_drawTable());
            
			oTime     = $('#timeresult');
			oHour     = $('#hour_overlay');
			oClose    = $('#btn_close');
			oMinute   = $('#min_overlay');
			oMatrix   = $('#ui-timepicker-div table a');
			oMatrix.addClass('ui-state-default');
			oMinute.css('overflow', 'hidden');
			//events
			oClose.unbind('click.tp_close').bind('click.tp_close',function(event){timepicker_hide()});
			
			oMatrix.hover(function(){
			    $(this).toggleClass('ui-state-hover')  
			});
			
			if(oOptions[obj.identifier].closeOnFormclick){
				$('body').unbind('click.tp_hide').bind('click.tp_hide', _checkExternalClick);
			}
			
			oMatrix.bind('click.tp',function(e) {
				e.preventDefault();
				_handler(e);
			});
			
			oWrap.unbind('beforeshow').bind('beforeshow',function(){
				oOptions[obj.identifier].beforeShow.apply(obj,arguments);
			});
			
			oWrap.unbind('onclose').bind('onclose',function(){
				oOptions[obj.identifier].onClose.apply(obj,arguments);
			});
			
			oWrap.unbind('onselect').bind('onselect',function(){
				oOptions[obj.identifier].onSelect.apply(obj,arguments);
			});
			
			//actions
			_hideMinute();
		    _showHours();
			timepicker_show();
		},
		
	timepicker_init = function() {
			if ($("#ui-timepicker-wrap").length) {
				return;
			}
			$('body').append('\n\n<div class="ui-timepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="ui-timepicker-div"></div>\n\n');
		};

	
	//Public timepicker methods========================================================= 
	$.fn.timepicker = function(options) {

		var that={},
			oButton = $('<button class="ui-timepicker-button"></button>');
			
		
		options= typeof(options) === 'undefined'?{}:options;
		
		
		if(options.inputReadOnly){
			$(this).attr('readonly','readonly');
		}
		
		if( _check(options.button) ){
			this.after(oButton);
			
			switch (options.button){
				case 'default' :
						oButton.append('<span class="ui-icon ui-icon-clock"></span>');
						oButton.addClass('ui-timepicker-defaultbutton');
					break;
				case 'ui' :
					if( _check(options.buttonUI) ){
						//to do: integrate ui button here
						alert('development still in progress,sorry');
					}
					oButton.addClass('ui-timepicker-uibutton');
					break;
				case 'image' :
					oButton.css('background','transparent url("clock.png") no-repeat');
					oButton.addClass('ui-timepicker-imgbutton');
					break;
				default :
					oButton.html(options.button);
					break;
			
			}
			//additional custom css
			if(_check(options.buttonCSS)){
				oButton.css(options.buttonCSS);
			}
			
			$(oButton).unbind('click.tp').bind('click.tp', function(e) {
				e.preventDefault();
				that=this.previousSibling;
				flgBusy = true;
				$(that).blur();
					
				that.identifier = _getIdentifier(that);
	
				oInput=that;
				timepicker_start();
				return false;
			});	
		}
		else{
		
			$(this).unbind('click.tp').bind('click.tp', function(e) {
					e.preventDefault();
					if (flgBusy) {
						return;
					}
					flgBusy = true;
					$(this).blur();
					
					this.identifier = _getIdentifier(this);
					
					oInput=this;
					timepicker_start();
					return false;
				});
		}
		
		that.oButton=oButton[0];
		$(this).data('timepicker', $.extend({}, options, that ) );
		return this;
		
	};
	
	$.timepicker = function(opts) {
		if (typeof opts === 'object') {
			$(oCommonOpts).data('timepicker', opts);
		}
		
	};
	
	$.timepicker.close = function(time) {
	    timepicker_hide(time);
	};
	$.timepicker.open = function(id) {
	    timepicker_start(id);
	};
	$.timepicker.init = function(){
	    timepicker_init();
	};
	$.fn.timepicker.defaults = {//to do : opbouw uren,  [image]button met event maken
		'hour24'          : [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],//hours 24 format, e.g. [0,1,'skip',9,10,11,12,13,14,'-->',18,19,20,21]
		'hourAM'          : [12,1,2,3,4,5,6,7,8,9,10,11],// AM hours
		'hourPM'          : [12,1,2,3,4,5,6,7,8,9,10,11],// PM hours
		'hourFormat'	  : 24,// 12 or 24
		'hourCols'		  : 8,// 6 or 8 columns	
		'minDivision'  	  : 15,//minutebutton captions format array [12,24,36,48,52],   or preformat values  5, 10, 12, 15, 20, 30 
		'openOnClick'     : true,
		'closeOnComplete' : true,
		'inputReadOnly'	  : false,
		'beforeShow'      : function(){},//event
		'onSelect'        : function(){},//event
		'onClose'         : function(){},//event
		'hourCaption'     : 'First choose the whole hour',
		'minuteCaption'   : 'Then choose the right time',
		'button'		  : '',//string:{caption} or keyword 'custom' or 'ui' or 'default'
		'buttonObj'		  : {},//custombutton css or jqueryUI object
		'offsetLeft'      : 0,//adjust
		'offsetTop'       : 0,//adjust
		'closeOnFormclick': false
	};
	
	$(document).ready(function() {
		timepicker_init();
	});
	
})(jQuery);