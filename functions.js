/* ripped from phpmyadmin */

/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;

/**
 * enables highlight and marking of rows in data tables
 *
 */
function PMA_markRowsInit() {
    // for every table row ...
    var rows = document.getElementsByTagName('tr');
    for ( var i = 0; i < rows.length; i++ ) {
        // ... with the class 'dataRow' ...
        if ( 'dataRow' != rows[i].className.substr(0,7) ) {
            continue;
        }
        // ... add event listeners ...
        // ... to mark the row on click ...
        rows[i].onmousedown = function() {
            var unique_id;
            var checkbox;

            checkbox = this.getElementsByTagName( 'input' )[0];
            if ( checkbox && checkbox.type == 'checkbox' ) {
                unique_id = checkbox.name + checkbox.value;
            } else if ( this.id.length > 0 ) {
                unique_id = this.id;
            } else {
                return;
            }

            if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                marked_row[unique_id] = true;
            } else {
                marked_row[unique_id] = false;
            }

            if ( marked_row[unique_id] ) {
                this.className += '_marked';
            } else {
                this.className = this.className.replace('_marked', '');
            }

            if ( checkbox && checkbox.disabled == false ) {
                checkbox.checked = marked_row[unique_id];
            }
        }
        // .. and checkbox clicks
    }
}
window.onload=PMA_markRowsInit;

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usaly a table or a div containing the table or tables
 *
 * @param    container    DOM element
 */
function markAllRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            if ( checkbox.disabled == false ) {
                checkbox.checked = true;
                if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                    rows[i].className += '_marked';
                    marked_row[unique_id] = true;
                }
            }
        }
    }

    return true;
}

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usaly a table or a div containing the table or tables
 *
 * @param    container    DOM element
 */

function unMarkAllRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            checkbox.checked = false;
            rows[i].className = rows[i].className.replace('_marked', '');
            marked_row[unique_id] = false;
        }
    }

    return true;
}
function showHide(i){
	document.getElementById('t1').style.display='none';
	document.getElementById('t2').style.display='none';
	document.getElementById('t'+i).style.display='block';
}
function hd(){
    if(document.layers){
       document.layers['preloading'].visibility = "hide";
    }else if(document.getElementById){
        var obj = document.getElementById('preloading');
        obj.style.visibility = "hidden";
    }else if(document.all){
        document.all['preloading'].style.visibility = "hidden";
    }
}


function SelectAll(nama){
        for (var i=0;i<document.dataForm.elements.length;i++){
                	var e = document.dataForm.elements[i];
                	var namainput= e.name;  
                	regex=/stop/i;
	       	if(regex.test(namainput)){	
	      		e.checked = true;
	      	}
        }	
}

function DeselectAll(nama){
        for (var i=0;i<document.dataForm.elements.length;i++){
                var e = document.dataForm.elements[i];
                	var namainput= e.name;  
                	regex=/stop/i;
	       	if(regex.test(namainput)){	
	                e.checked = false;
	       }         
        }
}
function openNewWindows(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+''
	win = window.open(mypage,myname,settings)
	if(win.window.focus){win.window.focus();}
}
function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}
function saveRecord(data){
  randval=Math.random();
  var dataArr 	= new Array();
  var dataPassArr	= new Array();
  dataArr		= data.split('||');
  namaInput 	= dataArr[1];
  pk		= dataArr[0];
  dataPassArr	= pk.split(';;');
  var url		= '';
  var e = document.getElementById(namaInput);

  if(e.checked==true){
	url = 'simpan_hasil.php?'+pk+'&act=save&randval='+randval;
	//alert(url);
	http.open('get', url);
	http.onreadystatechange = handleResponse;
	http.send(null);

  }else{
	url = 'simpan_hasil.php?'+pk+'&act=delete&randval='+randval;
	http.open('get', url);
	http.onreadystatechange = handleResponse;
	http.send(null);

  }
	document.getElementById('floatdiv').style.backgroundColor="#FFDD00";
	document.f3.hasil.style.backgroundColor="#FFDD00";
	document.f3.hasil.value='sukses';

}

function handleResponse() {
    if(http.readyState == 4){
	var responseText =http.responseText;
	document.f3.hasil.value=responseText;
    }
}

function prosesData(nomor_sesi,tabel_temporer,start,total){
	randval=Math.random();

	if(start==0) {
		document.getElementById("divone").innerHTML='<img src=/i/loading.gif><table width=126 height=13 border=0 cellpadding=0 cellspacing=0><tr><td colspan=3><img src=/i/polltop.gif width=126 height=2></td></tr><tr><td width=2 height=9><img src=/i/pollleft.gif width=2 height=9></td><td width=122 height=9><table height=9 border=0 cellpadding=0 cellspacing=0 width=1%><tr><td width=1><img src=/i/pollresultleft.gif width=1 height=9></td><td background=/i/pollresultmid.gif><img src=/i/tr.gif width=1 height=9></td><td width=1><img src=/i/pollresultright.gif width=1 height=9></td></tr></table></td><td width=2><img src=/i/pollright.gif width=2 height=9></td></tr><tr><td colspan=3><img src=/i/pollbot.gif width=126 height=2></td></tr></table>(0 %)-0 of '+total+' diproses. ';
	}
	url = 'inside.php?nomor_sesi='+nomor_sesi+'&tabel_temporer='+tabel_temporer+'&start='+start+'&total='+total+'&randval='+randval;
	http.open('get', url);
	http.onreadystatechange = handleResponseData;
	http.send(null);
}

function prosesDataDesc(nomor_sesi,tabel_temporer,start,total){
	randval=Math.random();

    if(start==0) {
		document.getElementById("divone").innerHTML='<img src=/i/loading.gif><table width=126 height=13 border=0 cellpadding=0 cellspacing=0><tr><td colspan=3><img src=/i/polltop.gif width=126 height=2></td></tr><tr><td width=2 height=9><img src=/i/pollleft.gif width=2 height=9></td><td width=122 height=9><table height=9 border=0 cellpadding=0 cellspacing=0 width=1%><tr><td width=1><img src=/i/pollresultleft.gif width=1 height=9></td><td background=/i/pollresultmid.gif><img src=/i/tr.gif width=1 height=9></td><td width=1><img src=/i/pollresultright.gif width=1 height=9></td></tr></table></td><td width=2><img src=/i/pollright.gif width=2 height=9></td></tr><tr><td colspan=3><img src=/i/pollbot.gif width=126 height=2></td></tr></table>(0 %)-0 of '+total+' diproses. ';
	}

	url = 'inside.php?nomor_sesi='+nomor_sesi+'&tabel_temporer='+tabel_temporer+'&start='+start+'&total='+total+'&sort=desc&randval='+randval;
	prompt(url,url);
	http.open('get', url);
	http.onreadystatechange = handleResponseData;
	http.send(null);
	//http.send("");


}

function handleResponseData() {
    if(http.readyState == 4){
		var response 	= http.responseText;
		//alert(response);
		var subCat		= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			//reset value2 sebelumnya!
			var nomor_sesi 	= update[0];
			var tabel_temporer	= update[1];
			var start		= update[2];
			var total		= update[3];
			var num		= update[4];
			var progress	= update[5];
			var xprogres=(parseInt(start)*parseInt(num)/ parseInt(total)) * 100;
			xprogres	=String(xprogres);
			var progres=xprogres.substr(0,5);
			//progres=parseInt(progres);
			//alert('tabel_temporer:'+tabel_temporer+',nomor_sesi:'+nomor_sesi+'start:'+start+',total:'+total);
			//document.getElementById("divone").innerHTML=response;

			document.getElementById("divone").innerHTML='<img src=/i/loading.gif><table width=126 height=13 border=0 cellpadding=0 cellspacing=0><tr><td colspan=3><img src=/i/polltop.gif width=126 height=2></td></tr><tr><td width=2 height=9><img src=/i/pollleft.gif width=2 height=9></td><td width=122 height=9><table height=9 border=0 cellpadding=0 cellspacing=0 width='+parseInt(progres)+'%><tr><td width=1><img src=/i/pollresultleft.gif width=1 height=9></td><td background=/i/pollresultmid.gif><img src=/i/tr.gif width=1 height=9></td><td width=1><img src=/i/pollresultright.gif width=1 height=9></td></tr></table></td><td width=2><img src=/i/pollright.gif width=2 height=9></td></tr><tr><td colspan=3><img src=/i/pollbot.gif width=126 height=2></td></tr></table>('+progres+' %) - '+(parseInt(start)*parseInt(num))+' dr '+total+' diproses. '+progress;
			
			//alert('start:'+start+' ,total:'+total);
			start=parseInt(start);
			total=parseInt(total);
			if((parseInt(start)*parseInt(num)) <= total){
				//alert('start_awal: '+start);
				var start=parseInt(start)+ parseInt('1');
				//alert('start_akhir: '+start);
				//alert('responseText: '+response+',next: '+start);
				prosesData(nomor_sesi,tabel_temporer,start,total);
			}else{

				//alert('tabel_temporer'+tabel_temporer);
				document.getElementById("divone").innerHTML='<B><img src=/images/green.gif> Proses Normalisasi 1 Selesai (100%)</B>';
			}
		}
    }
}


var http = createRequestObject();