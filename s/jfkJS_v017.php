<?
/*
jfkJS developed by jfkasenda@yahoo.com - part of jfKlass
Please use this class with permission
jfkJS // version 017
*/

class jfkJS {

var $jsclasscalled = false;

function GenerateSubmit($submitcaption=' Submit ',$onsubmitcaption,$formname,$disablejs=false) {
	if ($disablejs == true) {
		$button = "<input name=button_submit class=button_submit type=submit value=\"$submitcaption\" >";
	} else {
		$button = "<input name=button_submit class=button_submit type=button value=\"$submitcaption\" onClick=\"SubmitForm_$formname($formname,'$onsubmitcaption');\">";
	}
	return $button;
}

function GenerateCancel($cancelcaption=' Cancel ',$canceladdress='?act=show',$showcancelbutton=true) {
	$button = ($showcancelbutton == false) ? "" : "<input class=button_cancel type=button onClick=\"window.open('$canceladdress','_self');\" value=\" $cancelcaption \">";
	return $button;
}

function GenerateSubmitForm($formname,$confirmmessage='',$onsubmitcaption,$showconfirmation=true,$validation=array(),$isIE,$disablejs=false,$containsSPAW,$morejs='',$calldefaultjs = true) {
	if ($disablejs == true) {
		return "";
	} else {
	$confirmmessage = $this->ConfirmMessage($confirmmessage,$showconfirmation);
	$changecaption	 = ($onsubmitcaption == '') ? "" : "$formname.button_submit.value=onsubmitcaption;";
	$thumbsetting   = $this->jsThumbsetting();
	$infosetting    = $this->jsInfoSetting();
	$checkdate      = $this->jsCheckDate();
	$checkemail     = $this->jsCheckEmail();
	$validations    = $this->GenerateJsValidations($validation,$formname);
	$checkall       = $this->BuildJsCode_CheckAll($formname);
	$numberformatter= $this->jsMyNumberFormat();
	$SPAW_code      = ($isIE == true && $containsSPAW == true) ?  "SPAW_UpdateFields()" : "";

	if ($calldefaultjs == true) {
		$defaultjs	=
		"
		\n
	   $checkemail
	   $checkdate
	   $thumbsetting
	   $infosetting
	   $checkall
	   $numberformatter
		\n";
 	} else {
 		$defaultjs = '';
	}

	$jscript =
   "\n
   <script language=JavaScript>
	$defaultjs
   function SubmitForm_$formname($formname,onsubmitcaption) {
       $SPAW_code
       $validations
	    $morejs
       $confirmmessage
		 $changecaption
       $formname.submit();
   }
   </script>
   ";
   return $jscript;
   }
}

function BuildJsCode_CheckAll($formname) {
	$jscript =
	"
	function CheckAll(fieldname,ischecked) {
	var lf = document.forms['$formname'];
	var len = lf.elements.length;
	for(i=0;i<len;i++) {
		var e = lf.elements[i];
		if (e.name == fieldname+'[]') {
      	e.checked = ischecked
      }
	}
	}
	";
	return $jscript;
}

function GenerateJsValidations($validation,$formname) {
	if (count($validation)==0) return "";
	$codes = "";
	while(list($field,$config)=each($validation)) {
		$rule = @$config["validate"];

		if (!is_array($rule)) {
			$warning = @$config["warning"];
			$codes  .= $this->BuildValidationCode($field,$rule,$warning,$config,$formname);
		} else {
			$c = 0;
			foreach($rule as $r) {
				$warning = @$config["warning"][$c];
				$codes .= $this->BuildValidationCode($field,$r,$warning,$config,$formname);
				$c++;
			}
		}
	}
	return $codes;
}

function BuildValidationCode($field,$rule,$warning,$config,$formname) {
	$rule = strtolower($rule);
	$config["formname"]	= $formname;

	//print "<pre>";print_r($config);
	if (eregi("%%FIELDVALUE%%",$warning)) {
		$warning = str_replace("%%FIELDVALUE%%","'+ $formname.$field.value + '",$warning);
	}
	if ($rule == 'must_fill') {
		$jscode = $this->BuildJsCode_MustFill($field,$warning,$config);
	} elseif ($rule == 'valid_email') {
		$jscode = $this->BuildJsCode_ValidEmail($field,$warning,$config);
	} elseif ($rule == 'valid_numeric') {
		$jscode = $this->BuildJsCode_ValidNumeric($field,$warning,$config);
	} elseif (eregi("must_check",$rule)) {
		$jscode = $this->BuildJsCode_MustCheck($rule,$field,$warning,$config);
	} elseif (eregi("min_length",$rule)) {
		$jscode = $this->BuildJsCode_MinOrMaxLength($rule,$field,$warning,$config,true);
	} elseif (eregi("max_length",$rule)) {
		$jscode = $this->BuildJsCode_MinOrMaxLength($rule,$field,$warning,$config,false);
	} elseif (eregi("valid_date",$rule)) {
		$jscode = $this->BuildJsCode_ValidDate($field,$warning,$config);
	} elseif (eregi("valid_extension",$rule)) {
		$jscode = $this->BuildJsCode_ValidExtension($field,$warning,$config);
   } elseif (eregi("not_exactly",$rule)) {
      $jscode = $this->BuildJsCode_NotExactly($rule,$field,$warning,$config);
   } elseif (eregi("must_confirm",$rule)) {
		$jscode = $this->BuildJsCode_MustConfirm($field,$warning,$config);
	} else {
		$jscode = "";
	}
	return $jscode;
}

function BuildJsCode_MustConfirm($field,$warning,$config) {
	$jscript	=
	"
	ask = confirm('$warning')
	if (ask == false){
		return false;
	}
	";
	return $jscript;
}

function BuildJsCode_ValidExtension($field,$warning,$config) {
	$exts		= @$config["extensions"];
	$warning	= @$config["warning"];
	$theform	= @$config["formname"];

	if ($exts == "") $exts = "jpg,jpeg,gif";

	if ($exts != "") {

	$exts 		= split(",",$exts);
	$numexts 	= count($exts);
	$array_exts	= "\"".join("\",\"",$exts)."\"";
   $alert		= ($warning != "") ? $warning : "'Please upload only file with the extensions $array_exts for field $field'";

	$jscript =
	"
	var array_exts = new Array($array_exts);
	var filename = $theform.$field.value;
	if (filename != '') {
	postext = filename.lastIndexOf(\".\");
	namelen = filename.length;
	matchext= 0;
	if (postext != -1) {
		ext = filename.substring(postext+1,namelen).toLowerCase();
		for (i=0;i<$numexts;i++) {
			allowed_ext = array_exts[i];
			if (allowed_ext == ext) {
				matchext = matchext + 1
			}
		}
		if (matchext == 0) {
         alert($alert)
         return false;
		}
	} else {
		alert($alert);
		return false
	}
	} //if a file is uploaded
	";
	return $jscript;
	}
}

function BuildJsCode_MustCheck($rule,$field,$warning,$config) {
   $params	= split(" ","$rule 1");
	$theform	= $config["formname"];
   $atleast	= (int)$params[1];
   $clause	= ($atleast > 1) ? "at least $atleast options for" : "";
   $alert	= ($warning != "") ? $warning : "Please check $clause field $field";
   $jscript	=
   "
   numchecked = 0
   var lf = $theform
   var len = lf.elements.length;
   for (var i = 0; i < len; i++) {
       var e = lf.elements[i]
       if (e.name == \"$field"."[]\" || e.name == \"$field\") {
          if (e.checked == true) {
          numchecked++
          }
       }//if
   }//for

   if (numchecked < $atleast) {
      alert('$alert')
      return false
   }
   ";
   return $jscript;
}

function BuildJsCode_ValidDate($field,$warning,$config) {
	$alert   = ($warning != "") ? $warning : "Please enter a valid date for field $field";
	$theform	= $config["formname"];
	$jscript =
	"
	if (CheckDate($theform.$field"."_day,$theform.$field"."_month,$theform.$field"."_year)==false) {
		alert('$alert')
		return false;
	}
	";
	return $jscript;
}

function BuildJsCode_ValidEmail($field,$warning,$config) {
	$alert   = ($warning != "") ? $warning : "Please enter a valid email address for field $field";
	$theform	= $config["formname"];
	$jscript =
	"
	if (CheckEmail($theform.$field)==false) {
		alert('$alert')
		$theform.$field.focus()
		return false;
	}
	";
	return $jscript;
}

function BuildJsCode_MinOrMaxLength($rule,$field,$warning,$config,$min=true) {
	$params  = split(" ","$rule 0");
	$theform	= $config["formname"];
	$compare = ($min == true) ? "<" : ">";
	$compstr = ($min == true) ? "should be at least" : "cannot exceed";
	$limit   = (int)$params[1];
	$alert   = ($warning != "") ? $warning : "Field $field $compstr $limit chars.";
	$jscript =
	"
	if ($theform.$field.value.length $compare $limit) {
		alert('$alert')
		$theform.$field.focus()
		return false
	}
	";
	return $jscript;
}

function BuildJsCode_MustFill($field,$warning,$config) {
	$alert   = ($warning != "") ? $warning : "Please fill field $field";
	$theform	= $config["formname"];
	$jscript =
	"
	if ($theform.$field.value.length == 0) {
		alert('$alert')
		$theform.$field.focus()
		return false
	}
	";
	return $jscript;
}

function BuildJsCode_NotExactly($rule,$field,$warning,$config) {
	$theform	= $config["formname"];
	$params  = split(" ","$rule ");
	$alert   = ($warning != "") ? $warning : "Please select field $field";
	$jscript =
	"
	if ($theform.$field.value == '".trim($params[1])."') {
		alert('$alert')
		$theform.$field.focus()
		return false
	}
	";
	return $jscript;
}

function BuildJsCode_ValidNumeric($field,$warning,$config) {
	$alert   = ($warning != "") ? $warning : "Please enter a valid numeric value for field $field";
	$theform	= $config["formname"];
	$jscript =
	"
	if ($theform.$field.value != ($theform.$field.value * 1)) {
		alert('$alert')
		$theform.$field.focus()
		return false
	}
	";
	return $jscript;
}

function ConfirmMessage($message,$showconfirmation=true) {
	if ($showconfirmation == true) {
	   if ($message != '') {
	      $code = "
	      ask = confirm('$message')
	      if (ask == false) {
	         return false
	      }
	      ";
	      return $code;
	   }
   }
}

function jsCheckEmail() {
    $jscode = "
    function CheckEmail(email) {
       if (email.value.length > 0) {
       if ((email.value.indexOf('@') == -1) || (email.value.indexOf('.') == -1)) {
          return false;
       }
       if (email.value.indexOf('.') == email.value.length -1) {
          return false;
       }
       return true;
       } else {
           return true;
       }
    }
    ";
    return $jscode;
}

function jsCheckDate() {
    $jscode = "
    var daysOfMonth = [0,31,28,31,30,31,30,31,31,30,31,30,31];
    var monthOfYear = ['','Januari','Pebruari','Maret','April','Mei','Juni', 'Juli','Agustus','September','Oktober','Nopember','Desember'];

    function DateValidate(day,month,year){
        if(day > 31 || month > 13) return false;
        if(month == 2 && (year % 4) == 0) {
           if( 29 >= day)return true;
        } else {
           if(daysOfMonth[month] >= day) return true;
        }
        return false;
        }

    function CheckDate(date,month,year) {
        var dateVal = date.options[date.selectedIndex].value;
        var monthVal = month.selectedIndex;
        var yearVal = year.options[year.selectedIndex].value;
        if (yearVal == '') return false
        if (!DateValidate(parseInt(dateVal), parseInt(monthVal), parseInt(yearVal)) ) {
           return false;
        }
        return true;
    }
    ";
    return $jscode;
}

function GeneratePrintPreviewScript() {
   $script =
	"
	<script>
	function PrintPreview()
	{
	var OLECMDID = 7;
	/* OLECMDID values:
	* 6 - print
	* 7 - print preview
	* 1 - open window
	* 4 - Save As
	*/
	var PROMPT = 1; // 2 DONTPROMPTUSER
	var WebBrowser = '<OBJECT ID=\"WebBrowser1\" WIDTH=0 HEIGHT=0 ORIENTATION=portrait CLASSID=\"CLSID:8856F961-340A-11D0-A96B-00C04FD705A2\"></OBJECT>';
	document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
	WebBrowser1.ExecWB(OLECMDID, PROMPT);
	WebBrowser1.outerHTML = \"\";

	}
	</script>
	";
	return $script;
}

function GeneratePrintScript() {
	$script =
	"
	<script>
	function PrintPreview()
	{
	window.print();
	}
	</script>
	";
	return $script;
}

function jsThumbsetting() {
    $jscode =
    "
    function ShowThumbsetting(t,fieldname) {
    if (t.checked) {
       eval('divset' + fieldname + '.style.display = \'inline\'');
       eval('divthumb'+ fieldname + '.style.display = \'none\'');
    } else {
       eval('divset' + fieldname + '.style.display = \'none\'');
       eval('divthumb'+ fieldname + '.style.display = \'block\'');
    }
    }
    ";
    return $jscode;
}

function jsInfoSetting() {
	$jscode =
	"
	function ShowInfoSetting(fieldname,show) {
		if (show == true) {
			//eval('divinfo' + fieldname + '.style.display = \'none\' ');
			eval('divinfo' + fieldname + '_state = false')
			eval('divstate' + fieldname + ' = false')
			eval('document.getElementById(\'divinfo'+fieldname+'\').style.display=\'none\'');
		} else {
			//eval('divinfo' + fieldname + '.style.display = \'block\' ');
			eval('divinfo' + fieldname + '_state = true')
			eval('divstate' + fieldname + ' = true')
			eval('document.getElementById(\'divinfo'+fieldname+'\').style.display=\'block\'');
		}
	}
	";
	return $jscode;
}

function jsShowRow($functionname="ShowRow",$numitems=20,$rowname="row",$imagename="img",$img1="/i/sys/plus.gif",$img2="/i/sys/min.gif") {

	$lastrow 		= "last".$rowname;
	$lastrowstate 	= "last".$rowname."state";

	if ($rowname!="" && $img1!="" && $img2!="") {
		$rowimagejs1 = 'eval("'.$imagename.'"+i+".src=\''.$img1.'\';");';
		$rowimagejs2 = 'eval("'.$imagename.'"+i+".src=\''.$img2.'\';");';
		$lastimagejs = "if (display_state == 'inline') { img='$img2' } else { img = '$img1' }";
		$imageevaljs = 'eval("'.$imagename.'"+rownum+".src=img;");';
	} else {
		$rowimagejs1 = $rowimagejs2 = $lastimagejs = $imageevaljs = "";
	}

	$jscode = "
	<script language=javascript>
	var $lastrow = 0
	var $lastrowstate = 1

	function $functionname(rownum) {
		var current_state
		for (i = 1; i <= $numitems; i++) {
			if (i != rownum) {
				if (document.getElementById(\"$rowname\"+i)) {
					eval(\"$rowname\"+i+\".style.display='none';\");
					$rowimagejs1
				} //rowname
			} //if
		} //for

		if ($lastrow == rownum) {
			if ($lastrowstate == 1) {
				display_state = 'none'
				$lastrowstate = 0
			}else {
				display_state = 'inline'
				$lastrowstate = 1
			}
		}else {
			display_state = 'inline'
			$lastrowstate = 1
		}
		eval(\"$rowname\"+rownum+\".style.display='\"+display_state+\"';\");
		$lastimagejs
		$imageevaljs
		$lastrow = rownum
	}
	</script>";
	return $jscode;

} //ShowRowJs

function jsMyNumberFormat() {
	$jscode = '
	function MyNumberFormat(o) {
		a = o.value;
		b = a.replace(/[^\d]/g,"");
		c = "";
		l = b.length;
		j = 0;
		for (i = l; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
		  c = b.substr(i-1,1) + "." + c;
		} else {
		  c = b.substr(i-1,1) + c;
		}
	}
	o.value = c;
	}
	';
	return $jscode;
}
}
?>
