<?
include("$DOCUMENT_ROOT/s/jfkGlobal.php");
class jfKlass {
/*
<-jfKlass-------------------------------------------------------------------->
//Joint Features Class

WARNING!
=============================================================================
DO NOT ALTER OR MODIFY OR REMOVE ANY PART OF  SCRIPT. ALTERATION,
MODIFICATION OR REMOVAL OF ANY KIND WILL VOID THE WARRANTY AND MAY CAUSE
THE SYSTEM RELYING ON THIS SCRIPT TO FAIL COMPLETELY.

THIS CLASS IS TO BE USED ONLY BY SITES ADMINISTERED BY SPASI.COM/JFK

LICENSED ONLY TO THE SITE AS IS WRITTEN ON THE GLOBAL SITENAME' SETTING

=============================================================================
Written by: Josef F. Kasenda
version 7.87
Added Feature:
--RunSql_Log function to capture all sql statements into log file
--confirmationmessage
--RunSql_Log function default changed to false
--RELATEDFILE tag supports multiple occurences
--PICORDER supports
Update as of July 20, 2005
(p)2003-2005
<--------------------------------------------------------------------------->
*/
var $version		= "7.89";
var $dberr		= 0;
var $cmserr 		= 0;
var $safekey		= "_safekey_";
var $dblink;
var $numrecs;
var $database		= ""; //as of 721
var $formname		= "thisform";
var $varinitialized  	= false;
var $databasetype       = "mysql";
var $startyear          = 1990; //as of 745
var $tmp_message	= "";
//var $datachunk	= "d";

function jfKlass() {
	global $GS;
	$this->InitVars();
	$this->Connect();
	if ($this->_GetGS("recordvisit",false) == true) {
		$this->RecordVisit();

	}
	if ($this->GetVar("showversion",0) == 1) {
		print $this->PlainMessage("<b>SPASI::jfKlass </b> development version " . $this->version);
	}
        if ($this->GetVar("enablespaw",1) == 0) {
                $this->enablespaw = false;
        }
	//print "<title>$this->sitename</title>\n";
        //if ($this->enablespaw == true) print "USE SPAW";
} //jfKlass()


function InitVars() {
        global $GS;
        if ($this->varinitialized == false) {
	    $this->author             = "Josef F. Kasenda";
	    $this->developmentkey     = "4b8a40920acb44d405ef21f55e8dca9f"; //IMPORTANT DO NOT MODIFY
	    $this->insert_id	      = 0;
	    $this->last_article_id    = 0;
            $this->last_article_title = "";
            $this->saved_id           = 0;
	    $this->current_login      = "";
	    $this->default_w          = "120";
	    $this->default_h          = "120";
	    $this->csscalled	      = false;
	    $this->spawcalled         = false;
	    $this->calframecalled     = false;
	    $this->disablejs	      = false;
	    $this->tbl_log	      = $this->_GetGS("tbl_log","cms_log");
	    $this->tbl_picture	      = $this->_GetGS("tbl_picture","cms_picture");
	    $this->tbl_visit	      = $this->_GetGS("tbl_visit","cms_visitlog");
	    $this->tbl_uploads	      = $this->_GetGS("tbl_uploads","cms_upload");
	    $this->tbl_visitdetails   = $this->_GetGS("tbl_visitdetails","cms_visitlog");
            $this->logaction          = $this->_GetGS("logaction",false);
            $this->sitename	      = $this->_GetGS("sitename","");
            $this->logincookie        = md5($this->sitename."xcms");
            $this->sitekey	      = $this->_GetGS("sitekey","");
            $this->numitems	      = $this->_GetGS("numitems",20);
            $this->si_imgpath         = $this->_GetGS("shopinfopath","/i/shopinfo/");
            $this->gallerypath        = $this->_GetGS("gallerypath","/i/gallery/");
            $this->thumbviewsize      = $this->_GetGS("thumbviewsize",60);
            $this->imgpath            = $this->_GetGS("imgpath","/i/");
            $this->thumbpath          = $this->_GetGS("thumbpath","/i/th/");
            $this->img_sortasc        = $this->_GetGS("img_sortasc","&#8226;");
            $this->img_sortdesc       = $this->_GetGS("img_sortdesc","&#8226;");
            $this->uploadpath         = $this->_GetGS("uploadpath","/downloads/");
            $this->clr_head           = $this->_GetGS("clr_head","#ccff33");
            $this->clr_row1	      = $this->_GetGS("clr_row1","#ebebeb");
            $this->clr_row2	      = $this->_GetGS("clr_row2","#ffffff");
            $this->clr_headtext       = $this->_GetGS("clr_headtext","#ffffff");
            $this->clr_searchhead     = $this->_GetGS("clr_searchhead",$this->clr_head);
            $this->clr_searchtext     = $this->_GetGS("clr_searchtext",$this->clr_headtext);
            $this->clr_searchbody     = $this->_GetGS("clr_searchbody",$this->clr_row1);
	    $this->clr_form	      = $this->_GetGS("clr_form","#ebebeb");
	    $this->clr_formhead	      = $this->_GetGS("clr_formhead","#a7a7a7");
	    $this->clr_formheadtext   = $this->_GetGS("clr_formheadtext","#ffffff");
	    $this->clr_formsubhead    = $this->_GetGS("clr_formsubhead","#e1e1e1");
	    $this->clr_formsubtext    = $this->_GetGS("clr_formsubtext","#000000");
	    $this->clr_formcolumn1    = $this->_GetGS("clr_formcolumn1","#a7a7a7");
	    $this->clr_formcolumn2    = $this->_GetGS("clr_formcolumn2","#ebebeb");
	    $this->clr_columntext1    = $this->_GetGS("clr_columntext1","#fffff");
	    $this->clr_columntext2    = $this->_GetGS("clr_columntext2","#000000");
	    $this->clr_button 	      = $this->_GetGS("clr_button",$this->clr_formhead);
	    $this->clr_buttontext     = $this->_GetGS("clr_buttontext",$this->clr_formheadtext);
	    $this->searchlabel        = $this->_GetGS("searchlabel","Search");
	    $this->confirmmessage     = "";
	    $this->allowedtags	      = "<b><i><u><br>";
	    $this->descriptionstyle   = "";
            $this->showpicdescription = true;
            $this->enablespaw         = true;
	    $this->datachunk	      = "cmV0dXJuIChtZDUoJHRoaXMtPmRldmVsb3BtZW50a2V5LiR0aGlzLT5zaXRlbmFtZS4kdGhpcy0+YXV0aG9yKSA9PSAkdGhpcy0+c2l0ZWtleSkgPyB0cnVlIDogZXhpdDs=";
            $this->logsql	      = $this->_GetGS("logsql",false);
	}
	$this->i($this->datachunk);
        $this->varinitialized = true;
} //InitVars()

function Connect($dbserver = '',$dbuser = '',$dbpass = '') {
	global $GS;
	//if no param is set, then use default connection as spesified in the global
	if ($dbuser == '') {
		$this->dblink = mysql_pconnect($GS["dbserver"], $GS["dbuser"], $GS["dbpass"]);
	} else {
		$this->dblink = mysql_pconnect($dbserver,$dbuser,$dbpass);
	}
	if (!$this->dblink) {
		print "Error: " . mysql_error();
	}
	return;
} //Connect()


function RunSql($sqlstr,$database='') {
	global $GS;
	if ($database == '') {
	        $database = ($this->database == "") ? $GS["dbname"] : $this->database;
		//$database = $GS["dbname"];
	}
	mysql_select_db($database) or die(mysql_error());
	$rs = mysql_query($sqlstr);
	if (eregi("select ",substr($sqlstr,0,10))) {
		if ($rs) {
			$this->numrecs = mysql_num_rows($rs);
		}
	} elseif (eregi("insert ",$sqlstr)) {
		$this->numrecs = mysql_affected_rows();
		$this->insert_id = mysql_insert_id();
	} else {
		$this->numrecs = mysql_affected_rows();
	}

	if ($this->logsql == true) {
	        if ((!eregi("^insert into cms_log ",trim($sqlstr))) && 
		    (!eregi("^insert into ".$this->tbl_visitdetails,trim($sqlstr))))
		{ $this->LogRunSql($sqlstr); }
	}
	return $rs;
} //RunSql()

function LogRunSql($sqlstr) {
	 global $REMOTE_ADDR;
	 $sqlstr = addslashes(trim($sqlstr));
	 if (!eregi("^select ",$sqlstr)) {
	    	 $lastupdate = $this->CurrentTime();
		 $sql = "insert into cms_sqllog(sql_statement,remoteaddr,lastupdate) values ('$sqlstr','$REMOTE_ADDR','$lastupdate')";
		 mysql_query($sql);
	 }
}

function CountRecs($sqlstr,$database = ''){
        if (!eregi(" group by ",$sqlstr)) {
               $sqlinfo = $this->StripLimit($sqlstr,true);
      	       $table   = $sqlinfo["table"];
               $where   = $sqlinfo["where"];
               $fields  = $sqlinfo["fields"];
               $sqlstr  = "select count(*) as x from $table $where";
               $count   = $this->GetValue($sqlstr,"x");
               return $count;
        } else {
               $this->RunSql($sqlstr,$database);
               return $this->numrecs;
	}
} //CountRecs()

function GetArrayValues($sqlstr,$array_field=array(),$database = '') {
	$value 	    = array();
	$rs 	    = $this->RunSql($sqlstr,$database);
	$found 	    = $this->numrecs;
	$numfields  = count($array_field);
	$rownum	    = 0;

	if ($numfields == 0) {
		$array_field 	= $this->GetFields($sqlstr,$database);
		$numfields	= count($array_field);
	}
			  
	if ($found <> 0) {
		while ($row=mysql_fetch_array($rs,MYSQL_BOTH)) {
			for ($i=0;$i < $numfields; $i++) {
				$fieldname 	   = $array_field[$i];
				$fieldvalue 	   = $row["$fieldname"];
				$value[$i]	   = stripslashes($fieldvalue);
				$value[$fieldname] = stripslashes($fieldvalue);
			}
			$rownum++;
			if ($rownum > 0) return $value;
		};
		return $value;
	}
} //GetArrayValues()


function GetArrayRows($sqlstr,$field,$database='') {
	$array_value= array();
	$rs	= $this->RunSql($sqlstr,$database);
	$found	= $this->numrecs;
	if ($found <> 0) {
		$count = 0;
		while ($row=mysql_fetch_array($rs)) {
			if (!is_array($field)) {
				$field_value = $row[$field];
				array_push($array_value,$field_value);
			} else {
				$tmp 	   = array();
				$fieldno = 0;
				foreach($field as $fld) {
					array_push($tmp,$row[$fld]);
					$fieldno++;
				}
				array_push($array_value,$tmp);
			}
			$count++;
		}
	}
	return $array_value;
} //GetArrayRows()


function GetValue($sqlstr,$field,$database='') {
	$rownum = 0;
	$value  = "";
	//mysql_select_db($this->_GetGS("dbname"));

	$rs = $this->RunSql($sqlstr,$database);
	while ($row=mysql_fetch_array($rs)) {
		$value = $row[$field];
		$rownum++;
		if ($rownum > 0) return $value;
	}
	return $value;
} //GetValue()


function GetFields($sqlstr,$database='') {
	$i = 0;
	$array_fields = array();
	$sqlinfo 	= $this->StripLimit($sqlstr);
	$newsql		= $sqlinfo["sql"]." limit 0, 1"; //This improves performance
	$table		= $sqlinfo["table"];
	$rs 		= $this->RunSql($sqlstr,$database)
	or die("ERROR: Table <b>$table</b> not found or <br>error on: $newsql.");

	while ($i < mysql_num_fields($rs)) {
		$field = mysql_fetch_field($rs);
		array_push($array_fields,$field->name);
		$i++;
	}
	mysql_free_result($rs);
	return $array_fields;
} //GetFields()


function GetFieldsInfo($sqlstr,$database = '',$actualtype = false) {
	// this is a revised version of the GetFields function
	$i = 0;
	$array_fields = array();
        $sqlinfo    = $this->StripLimit($sqlstr);
        $newsql     = $sqlinfo["sql"]." limit 0, 1";
	$rs = $this->RunSql($newsql,$database);
	while ($i < mysql_num_fields($rs)) {
		$field = mysql_fetch_field($rs);
		$fieldname = $field->name;
		$fieldtype = $field->type;
		if ($actualtype == false) {
		   $array_fields[$fieldname] = $this->_GetInputType($fieldtype);
		} else {
                   $array_fields[$fieldname] = $fieldtype;
                }
		$i++;
	}
	mysql_free_result($rs);
	return $array_fields;	
} //GetFieldsInfo()


function StoreValuePairs($sqlstr,$field1,$field2,$addblank = false,$database = '') {
	$rs =	$this->RunSql($sqlstr,$database);

	$result = array();
	if ($addblank == true) {
		$result[""] = "";
	}

	while ($row = mysql_fetch_array($rs)) {
		$key	= $row[$field1];
		$value  = $row[$field2];
		$result[$key] = $value;
		//print "$key $value<br>";
	}
	//print "<pre>";print_r($result);
	return $result;
} //StoreValuePairs()


function debugprint($s) {
	//print $s."<br>";
} //debugprint()


function arDates() {
	$dates = array(""); for ($d = 1; $d <= 31; $d++) { array_push($dates,substr("0$d",-2)); }
	return $dates;
} //arDates()


function arMonths() {
	return array(
		"0" => "","01" => "Januari","02" => "Pebruari","03" => "Maret","04" => "April","05" => "Mei",
		"06" => "Juni","07" => "Juli","08" => "Agustus","09" => "September","10" => "Oktober","11" => "Nopember",
		"12" => "Desember"
		);
} //arMonths()


function arYears($range=array()) {
        $start = (count($range) == 0) ? $this->startyear : $range[0];
	if (count($range) < 2) {
		$range = array($start,date("Y"));
	} else {
		if (!isset($range[0])) $range[0] = $this->startyear;
		if (!isset($range[1])) $range[1] = date("Y");
	}
	$years = array(""); for ($y = $range[0]; $y <= $range[1]; $y++) { array_push($years,$y); }
	return $years;
} //arYears()


function arDays() {
	return array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
} //arDays()


function arMin() {
	$minutes = array(""); for ($d = 0; $d <= 59; $d++) { array_push($minutes,substr("0$d",-2)); }
	return $minutes;
} //arMin()


function arHours() {
	$hours = array(""); for ($d = 0; $d <= 23; $d++) { array_push($hours,substr("0$d",-2)); }
	return $hours;
} //arHours()


function ValidateFilename($filename) {
	$invalidchars 	= array("|\'|","|\"|","|\/|","|%|","|:|");
	$filename 	= eregi_replace(" ","_",$filename);
	$filename 	= preg_replace($invalidchars,"",$filename);
	$filename	= str_replace('\\',"",$filename);
	return trim(strip_tags($filename));
} //ValidateFilename()


function CurrentDate() {
	$dtime = $this->BuildDate(date("Y"),date("m"),date("d"),0,0,false);
	return $dtime;
} //CurrentDate()


function StartOfMonth() {
	$dtime = $this->BuildDate(date("Y"),date("m"),"01",0,0,false);
	return $dtime;
}


function CurrentTime($showdate=true) {
	if ($showdate == true) {
		$date = $this->BuildDate(date("Y"),date("m"),date("d"),0,0,0,false);
	} else {
		$date = "";
	}
	$time = date("H").":".date("i").":".date("s");
	$dtime = "$date $time";
	return $dtime;
} //CurrentTime()


function FormatTime($curdate, $showday = false) {
	if ($curdate=="") return "";
	$sourcedate	= $curdate;
	$arDays 	= $this->arDays();
	$arMonths	= $this->arMonths();

	if (eregi("-",$curdate)) {
		$year   = substr($curdate,0,4);
		$month  = substr($curdate,5,2)*1;
		$date   = substr($curdate,8,2);
		$hour   = substr($curdate,11,2);
		$minute = substr($curdate,14,2);
	} else {
	       	$curdate= strtotime($curdate);
		$year   = date("Y",$curdate);
		$month  = date("m",$curdate)*1;
		$date   = date("d",$curdate);
		$hour   = date("H",$curdate);
		$minute = date("i",$curdate);
	}

	//before formatting, check first if date is valid
	if (checkdate(intval($month),intval($date),intval($year))==false) {
		return "";
	}

	$imonth		= substr("0".$month,-2);
	$mname  	= $arMonths[$imonth];
	$curdate	= mktime($hour,$minute,0,$month,$date,$year);

	//if date is below 1970 no weekdays reference exists, therefore, anticipate the error
	if ($year >= 1970) {
		$wday	= date("w",$curdate);
		$d 	= $arDays[$wday].",";
	} else {
		$d 	= "";
	}

	if ($showday == false) {
		return "$date $mname $year";
   	} else {
   		return "$d $mname $date, $year";
	}
} //FormatTime()


function PrintTimeSelect($curDate,$boolShowHour = false,$prefix = '',$range=array()) {

		if ($curDate != "") {
           $timestamp   = strtotime($curDate);
           $curDate     = date("Y",$timestamp)."-".date("m",$timestamp)."-".date("d",$timestamp)." ".date("H",$timestamp).":".date("i",$timestamp);
		   $varPYear   	= substr($curDate,0,4);
		   $varPMonth  	= substr($curDate,5,2);
		   $varPDate   	= substr($curDate,8,2);
		   $varPHour   	= substr($curDate,11,2);
		   $varPMinute 	= substr($curDate,14,2);
	   } else {
		   $varPYear   	= "";
		   $varPMonth  	= "";
		   $varPDate   	= "";
		   $varPHour   	= "";
		   $varPMinute 	= "";
        }

	$years		= $this->arYears($range);
	$months		= $this->arMonths();
	$dates		= $this->arDates();

	$content	= "";
	$content 	.= $this->PrintSelect($dates,$varPDate,$prefix."_date",'value_value');
	$content 	.= $this->PrintSelect($months,$varPMonth,$prefix."_month");
	$content 	.= $this->PrintSelect($years,$varPYear,$prefix."_year",'value_value');

	if ($boolShowHour == true) {
		$content .= " Time ";
   		$content .= $this->PrintSelect($this->arHours(),$varPHour,$prefix."_hour",'value_value');
		$content .= ":";
   		$content .= $this->PrintSelect($this->arMin(),$varPMinute,$prefix."_min",'value_value');
	}
	return $content;
} //PrintTimeSelect()


function PrintMonthYearSelect($curDate,$boolShowHour = false,$prefix = '',$range=array()) {

		if ($curDate != "") {
           $timestamp   = strtotime($curDate);
           $curDate     = date("Y",$timestamp)."-".date("m",$timestamp)."-".date("d",$timestamp)." ".date("H",$timestamp).":".date("i",$timestamp);
	   $varPYear   	= substr($curDate,0,4);
	   $varPMonth  	= substr($curDate,5,2);
	   $varPDate   	= substr($curDate,8,2);
	   $varPHour   	= substr($curDate,11,2);
	   $varPMinute 	= substr($curDate,14,2);
        } else {
	   $varPYear   	= "";
	   $varPMonth  	= "";
	   $varPDate   	= "";
	   $varPHour   	= "";
	   $varPMinute 	= "";
        }

	$years		= $this->arYears($range);
	$months		= $this->arMonths();
	$dates		= $this->arDates();

	$content	= "";
	$content 	.= "<input type=hidden name=".$prefix."_date value=\"01\">";
	$content 	.= $this->PrintSelect($months,$varPMonth,$prefix."_month");
	$content 	.= $this->PrintSelect($years,$varPYear,$prefix."_year",'value_value');

	if ($boolShowHour == true) {
		$content .= " Time ";
   		$content .= $this->PrintSelect($this->arHours(),$varPHour,$prefix."_hour",'value_value');
		$content .= ":";
   		$content .= $this->PrintSelect($this->arMin(),$varPMinute,$prefix."_min",'value_value');
	}
	return $content;
} //PrintTimeSelect()


function PrintSelect($arSelect,$curSelect,$selectName,$valuepair='key_value',$height=1,$multiple=false,$jsscript='') {
	$content 	= "";
	$isMultiple = ($multiple == false) ? "" : "multiple";

	if (is_array($curSelect)) $content	.= "\n<select name=\"".$selectName."[]\" size=$height $isMultiple $jsscript>\n";
	else $content	.= "\n<select name=\"".$selectName."\" size=$height $isMultiple $jsscript>\n";

	while(list($key,$value) = each($arSelect)) {
	if ($valuepair == 'value_value') {
		if (!is_array($curSelect)) {
			if ($curSelect == $value) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		} else {
			if (in_array($value,$curSelect)) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		}
		$content .= "<option value=\"$value\" $isSelected>$value\n";
	} else {
     	if (!is_array($curSelect)) {
			if ($curSelect == $key) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		} else {
			if (in_array($key,$curSelect)) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		}
		$content .= "<option value=\"$key\" $isSelected>$value\n";
	}
	}//while
	$content .= "</select>\n";
	return $content;
} //PrintSelect()


function PrintSearchSelect($arSelect,$curSelect,$selectName,$valuepair='key_value',$height=1,$multiple=false,$jsscript='') {
	$content 	= "";
	$isMultiple = ($multiple == false) ? "" : "multiple";

	$content	.= "\n<select name=\"".$selectName."\" size=$height $isMultiple $jsscript>\n";

	while(list($key,$value) = each($arSelect)) {
	if ($valuepair == 'value_value') {
		if (!is_array($curSelect)) {
			if ($curSelect == $value) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		} else {
			if (in_array($value,$curSelect)) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		}
		$content .= "<option value=\"$value\" $isSelected>$value\n";
	} else {
     	if (!is_array($curSelect)) {
			if ($curSelect == $key) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		} else {
			if (in_array($key,$curSelect)) {
				$isSelected = "selected class=selected";
			} else {
				$isSelected = "";
			}
		}
		$content .= "<option value=\"$key\" $isSelected>$value\n";
	}
	}//while
	$content .= "</select>\n";
	return $content;
} //PrintSearchSelect()


function RadioSelect($arSelect,$curSelect,$selectName,$valuepair = 'key_value',$method="post",$layout="auto",$textcolor="black") {
        if ($layout == "auto") {
           $numcolumns = count($arSelect);
           $layout     = "multicolumn $numcolumns";
        }
	$layout    = split(" ",$layout." 1");
	if ($layout[0] == "multicolumn") {
	   $numcolumn = $layout[1];
	} else {
	   $numcolumn = 1;
	}
	$content   = "<table border=0 cellpadding=1><tr>";
	$suffix    = ($method == "post") ? "[]" : "";
	$rownum	   = 1;
	while(list($key,$value) = each($arSelect)) {
	//print "$curSelect $key<br>";
	if ($key) {
		if ($valuepair == 'value_value') {
			if ($curSelect == $value) {$isSelected = "checked"; } else { $isSelected = ""; }
			$input    = "<input class=radio type=radio value=\"$value\" name=\"$selectName$suffix\" $isSelected><font color=$textcolor>$value</font>";
			$content .= "<td>$input</td>\n";//"<input type=radio value=\"$value\" name=\"$selectName$suffix\" $isSelected>$value $separator\n";
		} else {
				if ($curSelect == $key) {$isSelected = "checked"; } else { $isSelected = ""; }
			$input 	  = "<input class=radio type=radio value=\"$key\" name=\"$selectName$suffix\" $isSelected><font color=$textcolor>$value</font>";
			$content .= "<td>$input</td>\n"; //"<input type=radio value=\"$key\" name=\"$selectName$suffix\" $isSelected>$value\n $separator";
		}

			if (($rownum % $numcolumn) == 0) $content .= "</tr>\n<tr>";
		$rownum++;
	}
	}
	$content .= "</tr></table>";
	return $content;
} //RadioSelect()


function GetURLVars($exception = array()) {
	global $HTTP_GET_VARS, $QUERY_STRING;
	$dynamicvars = array();
	reset($HTTP_GET_VARS); //this reset the array pointer to the beginning
	$urlstring = "";
	$ts = time();
	if (count($exception)==0) {
		$dynamicvars = array("start","ts","sortorder","referrer"); //these variables are changed from within other procedures.
	} else {
		if (!is_array($exception)) {
			array_push($dynamicvars,$exception);
		} else {
			$dynamicvars = $exception;
		}
	}

	//print "<pre>".print_r($dynamicvars);

	while(list($key,$value) = each($HTTP_GET_VARS)) {
		//??? strange that I once changed the letter case
		//$key = strtolower($key);

		//needs to check if some variables are actually part of an array
		if (eregi("either",$value)) {
			//if the value either is contained by a bool_$fieldname then the var is intended to be an array
			if (substr($key,0,5) == "bool_") {
				$arraykey = substr($key,5);
				$arrayval = $this->GetJSArray($QUERY_STRING,$arraykey);
				if (count($arrayval) > 0) {
					$arraystring = "&$arraykey=".join("&$arraykey=",array_unique($arrayval))."&";
					$urlstring .= $arraystring;
					array_push($dynamicvars,$arraykey);
				}
			}
		}
		//

		if (!in_array($key,$dynamicvars)) {
			if ($key != "referrer") {
				$urlstring .= "$key=".@urlencode($value)."&";
			} else {
				$urlstring .= "";
			}
		}
	}
	//print "<hr>";
	if (!in_array("ts",$dynamicvars)) {
		return $urlstring . "ts=$ts&";
	} else {
		return $urlstring;
	}
} //GetURLVars()


function GetPageList(
			$numrecs,
			$num,
			$pageName = "?",
			$curStart = 0,
			$varstartname='start',
			$norecordstr = 'No records found',
			$style = array(),
                        $maxstart = 1000000
			)
	{

	$opentag	= $this->_GetSetting($style["opentag"],"");
	$closetag	= $this->_GetSetting($style["closetag"],"");
	$firstlabel	= $this->_GetSetting($style["firstlabel"],"First");
	$lastlabel	= $this->_GetSetting($style["lastlabel"],"Last");
	$firstlabel2	= $this->_GetSetting($style["firstlabel2"],$firstlabel);
	$lastlabel2	= $this->_GetSetting($style["lastlabel2"],$lastlabel);
	$prevlabel	= $this->_GetSetting($style["prevlabel"],"&lt;");
	$nextlabel	= $this->_GetSetting($style["nextlabel"],"&gt;");
	$prevlabel2	= $this->_GetSetting($style["prevlabel2"],$prevlabel);
	$nextlabel2	= $this->_GetSetting($style["nextlabel2"],$nextlabel);

	$maxlinks	= $this->_GetSetting($style["maxlinks"],10);

	$first		= $this->_GetSetting($style["first"],"%%FIRST%%");
	$last		= $this->_GetSetting($style["last"],"%%LAST%%");
	$prev		= $this->_GetSetting($style["prev"],"%%PREV%%");
	$next		= $this->_GetSetting($style["next"],"%%NEXT%%");

	if (eregi("<table",$opentag))	{ if (!eregi("<td",$first)) 	$first= "<td>$first</td>"; }
	if (eregi("<table",$opentag)) 	{ if (!eregi("<td",$last)) 	$last	= "<td>$last</td>"; }
	if (eregi("<table",$opentag)) 	{ if (!eregi("<td",$prev)) 	$prev = "<td>$prev</td>"; }
	if (eregi("<table",$opentag)) 	{ if (!eregi("<td",$next)) 	$next = "<td>$next</td>"; }

	$pagenumber	= $this->_GetSetting($style["pagenumber"],"%%PAGENUMBER%%&nbsp;");
	$pageselected   = $this->_GetSetting($style["pageselected"],"<b>%%PAGENUMBER%%</b>&nbsp;");

	$pageName = "?".$this->GetURLVars();
	
	if (!is_numeric($num)) {
		return "[invalid pagelist]";		
	}
	$strPageList 	= "";
	if (!$numrecs	== 0) {	

        $numrecs        = ($numrecs > $maxstart) ? $maxstart : $numrecs;

	$hal		= "";
	$inum		= $maxlinks;
	$activeStart= $curStart+1;
	$left     	= $curStart % $num;
	$curPage	= ceil(($curStart + 1) / $num);

	if ($left > 0) { $curStart = $curStart - $left; }
	if ($curStart < 0) {$curStart = 0; }

	//$startlabel	= "First";
	//$endlabel		= "Last";
	//$prev      	= "&lt;";
	//$next      	= "&gt;";
	$numPages  	= ceil($numrecs / $num);
	$maxPages  	= ($numPages <= $inum) ? $numPages-1 : $inum;

	$prevStart 	= $curStart - $num;
	$nextStart 	= $curStart + $num;
	$maxStart  	= ($numPages * $num) - $num;

	$firstlabel	= ($curStart==0) 		? $firstlabel2	: "<a href=\"$pageName"."&".$varstartname."=0\">$firstlabel</a>";
	$lastlabel 	= ($curStart==$maxStart)	? $lastlabel2	: "<a href=\"$pageName"."&".$varstartname."=$maxStart\">$lastlabel</a>";
	$prevlabel 	= ($curStart < 1) 		? $prevlabel2	: "<a href=\"$pageName"."&".$varstartname."=$prevStart\">$prevlabel</a>";
	$nextlabel 	= ($nextStart >= $numrecs) 	?
            		"$nextlabel2" : "<a href=\"$pageName"."&".$varstartname."=$nextStart\">$nextlabel</a>";

	$opentag	= preg_replace(array("|%%RECORDCOUNT%%|","|%%PAGECOUNT%%|"),array($numrecs,$numPages),$opentag);
	$firstlayout	= str_replace("%%FIRST%%",$firstlabel,$first);
	$prevlayout	= str_replace("%%PREV%%",$prevlabel,$prev);
	$nextlayout	= str_replace("%%NEXT%%",$nextlabel,$next);
	$lastlayout	= str_replace("%%LAST%%",$lastlabel,$last);
	
	$strPageList = $strPageList . "$firstlayout $prevlayout ";

	$startPage 	= $curStart / $num;
	$endPage   	= $startPage + $inum;
	if ($endPage >= $numPages) { 
		$endPage = $numPages; $startPage = $numPages - ($inum - 1); 
	} elseif ($startPage == 0) {
		$endPage = $inum;
	} else {
		if ($numPages >= $inum) {
			$startPage = $curPage - ($inum / 2);
			if ($startPage < 1) $startPage = 0;
			$endPage = $startPage + $inum - 1;
		} else {
			$endPage = $endPage - 1;
		}
	}

	if ($maxlinks == 1) {
		$startPage = ($curStart / $num) + 1;
		$endPage = $startPage;
	}

	if ($startPage == 0) {
		$startPage = $startPage + 1;
	} else {
		//$startPage = $startPage + ($inum / 2);
	}

	$startPage 	= round($startPage);
	$endPage	= round($endPage);
	$diff		= ($endPage + 1) - $startPage;

	if ($diff < $inum) {
		$lack = $inum - $diff;
		if (($endPage + $lack) >= (($startPage + $inum)-1)) {
		   $endPage = $endPage;
                } else {
                   $endPage = $endPage + $lack;
                }
	}

	//print "$startPage $endPage $diff $inum";
	for ($i = $startPage; $i <= ($endPage - 0); $i++) {

		//print " $startPage - $i - $endPage<br>";
		$start	= ($num * $i) - $num;
		//$curPage	= ceil(($curStart + 1) / $num);
		if (!($start < 0)) {

		if ($i != $curPage) {
			$strPagenumber = "<a href=\"$pageName"."&".$varstartname."=$start\">$i</a>&nbsp;";
			$strPagenumber = str_replace("%%PAGENUMBER%%",$strPagenumber,$pagenumber);
		} else {
			$strPagenumber = "$i";
			$strPagenumber = str_replace("%%PAGENUMBER%%",$strPagenumber,$pageselected);
		}
		$strPageList 	= $strPageList . $strPagenumber . "\n";
		}
	} // end of for

	$strPageList = $strPageList . "$nextlayout $lastlayout";
	} //if not $numrecs
	
	else {
		$strPageList = $strPageList . $norecordstr;
	}	
	return "$opentag$strPageList$closetag";
} //GetPageList()


function SqlAnalyze($sqlstr) {
	 return $this->StripLimit($sqlstr);
} //SqlAnalyze()

function StripLimit($sql,$striporder = false) {
        $oldsql = $sql;
        $sql    = $this->ExtraSpaceRemove($sql);

        if (eregi(" where ",$sql)) {
           preg_match("/select (.*) from (.*) where (.*)/i",$sql,$match);
        } else {
           preg_match("/select (.*) from (.*)/i",$sql,$match);
        }

        $sql      = $this->_GetSetting($match[0],"");
        $fields   = $this->_GetSetting($match[1],"");
        $table    = $this->_GetSetting($match[2],"");
        $sqlwhere = $this->_GetSetting($match[3],"");
        $where    = (trim($sqlwhere)!="") ? " where $sqlwhere" : "";

        $cond   = $table . $where;

        if (eregi(" limit ",$cond)) {
           preg_match("/ limit (.*)/i",$cond,$match);
           $limit = trim($this->_GetSetting($match[0],""));
           list($start,$num) = split(",",$match[1]);
        }  else {
           $limit = $start = $num = "";
        }
        $newsql = "select $fields from ".str_replace($limit,"",$cond);

        if (eregi("order by",$table)) {
                $ord_start = strpos(strtolower($table)," order by ");
      	        $table     = substr($table,0,$ord_start);
        }

        if (eregi(" limit ",$table)) {
                $ord_start = strpos(strtolower($table)," limit ");
      	        $table     = substr($table,0,$ord_start);
        }

        if ($striporder == true) {
	if (eregi(" order by ",$newsql)) {
		$ord_start = strpos(strtolower($newsql)," order by ");
		$newsql	   = substr($newsql,0,$ord_start);
	}

        if (eregi("order by",$where)) {
                $ord_start = strpos(strtolower($where)," order by ");
      	        $where     = substr($where,0,$ord_start);
        }

	}

        $sqlinfo["sql"]     = $newsql;
        $sqlinfo["start"]   = $start;
        $sqlinfo["num"]     = $num;
        $sqlinfo["table"]   = $table;
        $sqlinfo["where"]   = $where;
        $sqlinfo["fields"]  = $fields;
        $sqlinfo["limit"]   = $limit;
        $sqlinfo["oldsql"]  = $oldsql;
        return $sqlinfo;
}

function FormatSqlData($value) {
         $value = preg_replace(array("| limit |i"),array("&nbsp;\$1&nbsp;"),$value);
         if ($this->databasetype == "mysql") {
               return "'".addslashes($value)."'";
         } elseif ($this->databasetype == "oracle") {
               if ($this->ValidDate($value)== true) {
                   return $ado->DBTimeStamp($value);
               } else {
                   return "'".str_replace("'","''",stripslashes($value))."'";
               }
         } else {
               if (is_numeric($value)) {
                   return $value;
               } else {
                   return "'".str_replace("'","''",stripslashes($value))."'";
               }
         }
} //FormatSqlData()


function _GetInputType($fieldtype) {
	$fieldtype = strtolower($fieldtype);
        if ($this->databasetype == "mysql") {
      	   if ($fieldtype == 'blob') { return "spaw";
      	      } elseif ($fieldtype == 'date') { return "dateselect";
      	      } elseif ($fieldtype == 'datetime') { return "datetimeselect";
      	      } else { return "text";
              }
        } elseif ($this->databasetype == "mssql") {
      	   if ($fieldtype == 'text') { return "spaw";
      	      } elseif ($fieldtype == 'datetime') { return "datetimeselect";
      	      } elseif ($fieldtype == 'smalldatetime') { return "dateselect";
      	      } else { return "text";
              }
        } elseif ($this->databasetype == "oracle") {
      	   if ($fieldtype == 'long') { return "spaw";
      	      } elseif ($fieldtype == 'date') { return "dateselect";
      	      } else { return "text";
              }
        }
} //_GetInputType()


function SearchBox(&$search_config,$layout="") {
	global $GS;

	//$fields 	= (!isset($search_config["searchfields"])) 	? $search_config["fields"] : $search_config["searchfields"];
	//$labels 	= (!isset($search_config["searchlabels"])) 	? array() : $search_config["searchlabels"];
	$disable	= (!isset($search_config["disablesearch"])) 	? array() : $search_config["disablesearch"];

	$labels		= $this->_GetSetting($search_config["searchlabels"],array());
	$fields		= $this->_GetSetting($search_config["searchfields"],$search_config["fields"]);
	$advsearch	= $this->_GetSetting($search_config["enableadvsearch"],false);
	$searchlabel    = $this->_GetSetting($search_config["searchlabel"],$this->searchlabel);

	if ($disable == true) {
		return "";
	}

	if ($advsearch == true) {
		$advsearchlink = "&nbsp;<a href=?act=advsearch><b>Advanced Search</b>&nbsp;&nbsp;</a>";
	} else {
		$advsearchlink = "";
	}

	if (count($fields) != count($labels)) {
		$labels = array();
	}

	$act = $this->GetVar("act","show");

	if ($act != "show") {
		return;
	}
	$arrpairs = array();
	$arrpairs[""] = "--Show All--";
	$selected     = $this->GetVar("searchfield","");
	$arraytype    = $this->IsAssocArray($fields);


	for ($i = 0; $i < count($fields); $i++ ) {
		$key	= $fields[$i];
		$label= (isset($labels[$i])) ? $labels[$i] : $this->FormatLabel($key);
		$arrpairs[$key] = $label;
	}
	$searchboxjs = "\n
			<script language=JavaScript>\n
			function ShowAll(frm) {
				if(frm.searchfield.selectedIndex==0){
					frm.query.value = ''
				}
			}\n
			</script>\n";

	$jsscript	 = " onChange=\"JavaScript:ShowAll(searchform);\"";
	$clr_searchbody	 = $this->_GetSetting($search_config["clr_searchbody"],$this->clr_searchbody);
	$clr_searchtext	 = $this->_GetSetting($search_config["clr_searchtext"],$this->clr_searchtext);
	$clr_searchhead	 = $this->_GetSetting($search_config["clr_searchhead"],$this->clr_searchhead);
	$searchfield	 = $this->PrintSelect($arrpairs,$selected,"searchfield",'key_value',1,false,$jsscript);

	$searchinput	 = "<input type=text name=query value=\"".$this->GetVar("query","")."\">";
        $searchbutton	 = "<input id=searchbutton type=submit value=\" Go \">";
	$searchopenform	 = "<form name=searchform>";
	$searchcloseform = "</form>";

	if ($layout == "") {
	$searchbox = "  $searchboxjs
			<table bgcolor=$clr_searchhead cellpadding=5 cellspacing=0>
			$searchopenform<tr>
			<td><font color=$clr_searchtext>$searchlabel</font></td>
			<td bgcolor=$clr_searchbody>$searchinput</td>
			<td bgcolor=$clr_searchbody>$searchfield</td>
			<td bgcolor=$clr_searchbody>$searchbutton</td>
			<td bgcolor=$clr_searchbody>$advsearchlink</td>
                        </tr>$searchcloseform
			</table>";
	} else {
	$find  		= array("%%SEARCHOPENFORM%%","%%SEARCHCLOSEFORM%%","%%SEARCHLABEL%%","%%SEARCHINPUT%%","%%SEARCHFIELDS%%","%%SEARCHBUTTON%%");
	$replace	= array($searchopenform,$searchcloseform,$searchlabel,$searchinput,$searchfield,$searchbutton);
	$mainsearchbox  = "$searchboxjs";
	if (!eregi("SEARCHOPENFORM",$mainsearchbox))  $mainsearchbox .= "%%SEARCHOPENFORM%% $layout";
	if (!eregi("SEARCHCLOSEFORM",$mainsearchbox)) $mainsearchbox .= "%%SEARCHCLOSEFORM%%";
	$searchbox  = str_replace($find,$replace,$mainsearchbox);
	}
	return $searchbox;
} //SearchBox()

function CleanUp($layout) {
	$layout = preg_replace(array("|%%(.*?)%%|","|<a(.*?)href(.*?)>|","|</a>|"),"",$layout);
	return $layout;
} //CleanUp()

function GetClosestMatch($str,$assoc_array) {
        reset($assoc_array);
        $arrfound = array();
        $found = $str;
        while (list($key,$value)=each($assoc_array)) {
               if (eregi($str,$value)) {
                   $found = $key;
                   array_push($arrfound,$key);
               }
        }
        if (count($arrfound) > 1) {
        return $arrfound;
        } else {
        return $found;
        }
} //GetClosestMatch()

function ExtraSpaceRemove($str) {
        $str	= preg_replace("(\r|\n|\t)"," ",$str);
        $array  = split(" ",$str);
        $newstr = "";
        foreach($array as $s) {
            if (trim($s) != "") {
            $newstr .= " ".trim($s);
            }
        }
        return trim($newstr);
} //ExtraSpaceRemove()

function BuildDefaultLayout($fields,$actionlist='',$config=array()) {
        $trattrib          = $this->_GetConfig($config,"trattrib","");
        $tdattrib          = $this->_GetConfig($config,"tdattrib","align=left valign=top");
        $tdsortattrib      = $this->_GetConfig($config,"tdsortattrib","");
        $tdfieldattrib     = $this->_GetConfig($config,"tdfieldattrib",array());
        $tdsortfieldattrib = $this->_GetConfig($config,"tdsortfieldattrib",$tdfieldattrib);
        $currentsort       = $this->_GetConfig($config,"currentsort","");
        $tdactionattrib    = $this->_GetConfig($config,"tdactionattrib"," nowrap ");
        $detailrow         = $this->_GetConfig($config,"detailrow","");
        $clrfieldtext	   = $this->_GetConfig($config,"clrfieldtext",array());
        $clrsortfieldtext  = $this->_GetConfig($config,"clrsortfieldtext",array());
        $tdfieldlayout	   = $this->_GetConfig($config,"tdfieldlayout",array());
        $tdsortfieldlayout = $this->_GetConfig($config,"tdsortfieldlayout",array());
        $tdnumberinglayout = $this->_GetConfig($config,"tdnumberinglayout","");

        $numfields = count($fields);

        $s  = "<tr bgcolor=%%ALTCOLOR%% $trattrib>";

	$s .= ($tdnumberinglayout != "") ? $tdnumberinglayout : "<td $tdattrib>%%NO%%</td>";

        for($i=0;$i<$numfields;$i++) {
            $field      = $fields[$i];
            $attrib     = $this->_GetConfig($tdfieldattrib,$field,$tdattrib);
            $sortattrib = $this->_GetConfig($tdsortfieldattrib,$field,$tdsortattrib);
            $clr_text	= $this->_GetConfig($clrfieldtext,$field,"black");
            $clr_sort   = $this->_GetConfig($clrsortfieldtext,$field,"black");
            $layout	= $this->_GetConfig($tdfieldlayout,$field,"");
            $sortlayout	= $this->_GetConfig($tdsortfieldlayout,$field,$layout);

	    if ($sortattrib == "") $sortattrib = $attrib;

            if ($field == $currentsort) {
              $s .= ($sortlayout != "") ? $sortlayout : "<td $sortattrib><font color=$clr_sort>%%$field%%</font></td>";
            } else {
              $s .= ($layout != "") ? $layout : "<td $attrib><font color=$clr_text>%%$field%%</font></td>";
            }
        }

        if ($actionlist != '') $s .= "<td $tdactionattrib>$actionlist</td>";

        $s .= "</tr>$detailrow";

        return $s;
} //BuildDefaultLayout

function ProcessContent($cfg) {
	//Great function that could handle any kind of data display!!
	//Just master the parameters and the web is yours
	//limited use only for websites built by SPASI/JFK
	//usage for other domains shall obtain a separate license
	//written in Dec 2003-August 2004 by Josef f. Kasenda/spasi.com

	global $GS;

        $keyvarname   = $this->_GetSetting($cfg["keyvarname"],"keyid");
	$database     = $this->_GetSetting($cfg["database"],"");
	$sqlstr	      = $this->_GetSetting($cfg["sql"],"");
	$sqlstr	      = preg_replace("(\r|\n|\t)"," ",$sqlstr);
	$sqlstr       = $this->ExtraSpaceRemove($sqlstr);
	$customfields = $this->_GetSetting($cfg["customfields"],array());


	if ($this->sitedata != $this->datachunk) exit;

	if ($sqlstr == "") {
		return "[FATAL: No query has been executed]";
	}

	if ($sqlstr == "_none_") {
		return $this->_GetSetting($cfg["layout"],"");
		exit;
	}

	//if no fields are specified the call GetFields function to fill the array with fieldnames;
	//$fields	= (!isset($cfg["fields"]))		? $this->GetFields($sqlstr) 	: $cfg["fields"];

        $allfields      = (count($customfields)==0) ? $this->GetFields($sqlstr,$database) : $customfields;
	$fields		= $this->_GetSetting($cfg["fields"],$allfields);
	$primarykey	= $this->_GetSetting($cfg["primarykey"],$fields[0]);
	$primarykey2	= $this->_GetSetting($cfg["primarykey2"],"");
	$cfg["fields"] 	= $fields; //<--update the value in config because it will be used by SearchBox
	$originalfields	= $fields; //<--store the fields for use by strformat function

	//if fields are empty then there's no use of proceeding with the process
	if (count($fields)== 0) return "[FATAL: No fields to display]";

	$start		        = $this->GetVar("start",0);

	$clr_head		= $this->_GetSetting($cfg["clr_head"],$this->clr_head);
	$clr_row1		= $this->_GetSetting($cfg["clr_row1"],$this->clr_row1);
	$clr_row2		= $this->_GetSetting($cfg["clr_row2"],$this->clr_row2);
	$clr_headtext	        = $this->_GetSetting($cfg["clr_headtext"],$this->clr_headtext);
	$num			= $this->_GetSetting($cfg["numitems"],$this->numitems);
	$startno		= $this->_GetConfig($cfg,"startno",$start+1);
	$picturetable           = $this->_GetConfig($cfg,"picturetable",$this->tbl_picture);
	$altcolors		= $this->_GetSetting($cfg["altcolors"],array($clr_row1,$clr_row2));
	$groupcolors		= $this->_GetSetting($cfg["groupcolors"],array(0=>array($clr_row1),1=>array($clr_row2)));
	$groupfield		= $this->_GetSetting($cfg["groupby"],"");
	$numformat		= $this->_GetSetting($cfg["numformat"],array());
	$dateformat		= $this->_GetSetting($cfg["dateformat"],array());
	$strformat		= $this->_GetSetting($cfg["strformat"],array());
	$disableadd		= $this->_GetSetting($cfg["disableadd"],false);
	$disableedit		= $this->_GetSetting($cfg["disableedit"],false);
	$disabledelete		= $this->_GetSetting($cfg["disabledelete"],false);
	$disablesearch		= $this->_GetSetting($cfg["disablesearch"],false);
	$disableview		= $this->_GetSetting($cfg["disableview"],false);
	$disablereferrer	= $this->_GetSetting($cfg["disablereferrer"],false);
	$disablesort		= $this->_GetSetting($cfg["disablesort"],false);
	$noadminheader		= $this->_GetSetting($cfg["noadminheader"],false);
	$header			= $this->_GetSetting($cfg["header"],"");
	$subheader		= $this->_GetSetting($cfg["subheader"],"");
	$footer			= $this->_GetSetting($cfg["footer"],"");
	$grouphead		= $this->_GetSetting($cfg["grouphead"],"");
	$grouptail		= $this->_GetSetting($cfg["grouptail"],"");
	$rowhead		= $this->_GetSetting($cfg["rowhead"],"");
	$rowtail		= $this->_GetSetting($cfg["rowtail"],"");
	$addlabel		= $this->_GetSetting($cfg["addlabel"],"ADD");
	$editlabel		= $this->_GetSetting($cfg["editlabel"],"EDIT");
	$deletelabel		= $this->_GetSetting($cfg["deletelabel"],"DELETE");
	$viewlabel		= $this->_GetSetting($cfg["viewlabel"],"VIEW");
	$opentag		= $this->_GetSetting($cfg["opentag"],"");
	$closetag		= $this->_GetSetting($cfg["closetag"],"");
	$noactions		= $this->_GetSetting($cfg["noactions"],false);
	$initialorder		= $this->_GetSetting($cfg["initialorder"],"");
	$addedactions		= $this->_GetSetting($cfg["moreactions"],"");
	$layout			= $this->_GetSetting($cfg["layout"],"");
	$altlayouts		= $this->_GetSetting($cfg["altlayouts"],array());
	$layoutconditions	= $this->_GetSetting($cfg["layoutconditions"],array());
	$labels			= $this->_GetSetting($cfg["labels"],array());
	$tblattrib		= $this->_GetSetting($cfg["tblattrib"],"cellpadding=4 cellspacing=2 border=0");
	$horizontalmenu		= $this->_GetSetting($cfg["horizontalmenu"],false);
	$nosortfields		= $this->_GetSetting($cfg["nosortfields"],array());
	$enableadvsearch	= $this->_GetSetting($cfg["enableadvsearch"],false);
	$innersql		= $this->_GetSetting($cfg["innersql"],"");
	$innerprocess		= $this->_GetSetting($cfg["innerprocess"],false);
	$replace		= $this->_GetSetting($cfg["replace"],array());
	$userowspan		= $this->_GetSetting($cfg["userowspan"],false);
	$adminpage		= $this->_GetSetting($cfg["adminpage"],false);
	$showerror		= $this->_GetSetting($cfg["showerror"],false);
	$autohead		= $this->_GetSetting($cfg["autohead"],false);
	$printsql		= $this->_GetSetting($cfg["printsql"],false);
	$pagingstyle		= $this->_GetSetting($cfg["pagingstyle"],array());
	$columnar		= $this->_GetSetting($cfg["columnar"],false);
	$numcolumns		= $this->_GetSetting($cfg["numcolumns"],4);
	$separator		= $this->_GetSetting($cfg["separator"],"");
	$verticalorder		= $this->_GetSetting($cfg["verticalorder"],false);
	$imgattrib		= $this->_GetSetting($cfg["imgattrib"],"");
	$customsortmark		= $this->_GetSetting($cfg["sortmark"],"&#8226;");
	$searchresultmode	= $this->_GetSetting($cfg["searchresultmode"],false);
	$qsearchprocess		= $this->_GetSetting($cfg["qsearchprocess"],true);
	$altrows		= $this->_GetSetting($cfg["varlayout"],array());
	$emptycell		= $this->_GetSetting($cfg["emptycell"],"");
	$moreadminvars		= $this->_GetSetting($cfg["moreadminvars"],array());
	$showsimilar		= $this->_GetSetting($cfg["showsimilar"],false);
	$boxwrapper		= $this->_GetSetting($cfg["boxwrapper"],"");
	$rowfunction            = $this->_GetSetting($cfg["rowfunction"],"");
	$maxstart               = $this->_GetSetting($cfg["maxstart"],1000000);
	$numrecords             = $this->_GetSetting($cfg["numrecords"],"");
	$sqlparsing             = $this->_GetSetting($cfg["sqlparsing"],true);
	$tdheadattrib           = $this->_GetSetting($cfg["tdheadattrib"],"");
	$tdsortheadattrib       = $this->_GetSetting($cfg["tdsortheadattrib"],$tdheadattrib);
	$trattrib               = $this->_GetSetting($cfg["trattrib"],"");
        $tdattrib               = $this->_GetSetting($cfg["tdattrib"],"");
	$tdsortattrib           = $this->_GetSetting($cfg["tdsortattrib"],"");
	$tdfieldattrib          = $this->_GetSetting($cfg["tdfieldattrib"],array());
	$tdsortfieldattrib      = $this->_GetSetting($cfg["tdsortfieldattrib"],array());
	$tdactionattrib         = $this->_GetSetting($cfg["tdactionattrib"],"");
        $actionbullet           = $this->_GetSetting($cfg["actionbullet"],"<li>");
        $detailrow              = $this->_GetSetting($cfg["detailrow"],"");
	$sortcolors             = $this->_GetSetting($cfg["sortcolors"],array());
	$sortcolors             = (count($altcolors)!=count($sortcolors)) ? $altcolors : $sortcolors;
	$tdheadfieldattrib	= $this->_GetSetting($cfg["tdheadfieldattrib"],array());
	$tdsortheadfieldattrib	= $this->_GetSetting($cfg["tdsortheadfieldattrib"],array());
	$clrheadfieldtext	= $this->_GetSetting($cfg["clrheadfieldtext"],array());
	$clrsortheadfieldtext	= $this->_GetSetting($cfg["clrsortheadfieldtext"],array());
	$clrfieldtext		= $this->_GetSetting($cfg["clrfieldtext"],array());
	$clrsortfieldtext	= $this->_GetSetting($cfg["clrsortfieldtext"],array());
	$tdheadfieldlayout	= $this->_GetSetting($cfg["tdheadfieldlayout"],array());
	$tdsortheadfieldlayout	= $this->_GetSetting($cfg["tdsortheadfieldlayout"],array());
	$tdfieldlayout		= $this->_GetSetting($cfg["tdfieldlayout"],array());
	$tdsortfieldlayout	= $this->_GetSetting($cfg["tdsortfieldlayout"],array());
	$tdnumberinglayout	= $this->_GetSetting($cfg["tdnumberinglayout"],"");
	$tdheadnumberinglayout	= $this->_GetSetting($cfg["tdheadnumberinglayout"],"");
	$searchboxlayout	= $this->_GetSetting($cfg["searchboxlayout"],"");
	$afterdelete		= $this->_GetSetting($cfg["afterdelete"],"");

        $puresql                = $sqlstr;

	$autoheadlabels         = $labels;

        $upimage                = $this->img_sortasc;
        $downimage              = $this->img_sortdesc;

        if (($start + $num) > $maxstart) return "[page not available]";


	//if boxwrapper is spesified, blank it first and add it later
	if ($boxwrapper != "") {
	   $tmp_header = $header;
	   $header = "";
	}

	$maxaltrows = count($altrows);
	if (($layout == "") && ($maxaltrows > 0)) {
		$layout = $altrows[0];
	} elseif (($layout != "") && ($maxaltrows > 0)) {
		array_unshift($altrows,$layout);
	}

	$rownum 		= $startno;
	$lastgroup 		= "<EMPTY>";

	//if innerprocess is true start from 0, innerprocess
	if ($innerprocess == true) $start = 0;

	//if no opentag is specified and layout is columnar then provide a standard opentag
	if ($columnar == true) {
		if ($opentag == "") {
			$opentag = "<table cellpadding=4 cellspacing=1 border=1><tr>";
		}
		if ($closetag == "") {
			$closetag = "";
		}
	} //columnar

	//error handling report
	$errorlist 	= "";
	if ($showerror == true) {
		if (($layout == "") && ($autohead == true)) {
			$errorlist .= "[<b>autohead</b> is valid only when layout is not empty]<br>";
		}
		if (count($labels) != count($fields)) {
			$errorlist .= "[array length is not similar between <b>fields</b> and <b>labels</b>]<br>";
		}
		if (eregi("%%AUTOHEAD%%",$opentag) && ($layout == "")) {
			$errorlist .= "[%%AUTOHEAD%% tag will not function if layout is not specified]<br>";
		}
		$errorlist .= "<br><br>";
	}

        if (count($labels) != count($fields))	$labels = $this->FormatLabel($fields);

	//stores all GET vars except act and keyid

	if ($disablereferrer == false) {
		$urlstring	= "referrer=".urlencode($this->GetURLVars(array("act",$keyvarname,"referrer")));
	} else {
		$urlstring	= "";
	}

	//if no default action is set to true don't show it
	$actionlist 	= "";

	//check if there is a second primary key
	if ($primarykey2 != "") {
		$additionalkey = "keyid2=%%$primarykey2%%";
	} else {
		$additionalkey = "";
	}

	if (count($moreadminvars) > 0) {
	       $adminvar = "";
	       reset($moreadminvars);
	       for($m=0;$m<count($moreadminvars);$m++) {
	          $var 	    = $moreadminvars[$m];
	          $varvalue = $this->GetVar($var,"");
	          $adminvar = "&$var";
	       }
	} else { $adminvar = ""; }


	if ($disableedit == false) {
		$edithref	= "$actionbullet<a href=\"?$keyvarname=%%$primarykey%%&act=edit&$additionalkey&$adminvar&$urlstring\">$editlabel</a><br>";
	} else {
		$edithref	= "";
	}

	if ($disabledelete == false) {
		$delhref	= "$actionbullet<a href=\"?$keyvarname=%%$primarykey%%&act=delete&$additionalkey&$adminvar&$urlstring\">$deletelabel</a><br>";
	} else {
		$delhref	= "";
	}

	if ($disableview == false) {
		$viewhref	= "$actionbullet<a href=\"?$keyvarname=%%$primarykey%%&act=view&$additionalkey&$adminvar&$urlstring\">$viewlabel</a><br>";
	} else {
		$viewhref	= "";
	}

	if ($enableadvsearch == true) {
		$advsearchlink = "&nbsp;<a href=?act=advsearch><b>Advanced Search<b></a>";
	}

	$defaultactions 	= "
				$edithref
				$delhref
				$viewhref";
	$default_opentag = "";

	if ($horizontalmenu == true) {
		$defaultactions = preg_replace(array("|<li>|","|<br>|"),array("<b>&#8226;</b>&nbsp;","&nbsp;&nbsp;"),$defaultactions);
		$defaultactions = $this->StripWrapper($defaultactions,"|");
	}

	$addedactions 	= str_replace("%%DEFAULT_ACTION%%",$defaultactions,$addedactions);

	if ($noactions == true) {
		$actionlist = "$addedactions";
	} else {
		$actionlist = "$defaultactions$addedactions";
	}

	//check if some condition applies. Modify the string if the original is not already hardcoded with a where condition
	//if (!eregi(" where ",$sqlstr)) {
        if ($adminpage == true) {
                $sql_order = "";
                if (eregi(" order by ",$sqlstr)) {
                   $sqlinfo = $this->SqlAnalyze($sqlstr);
                   //$this->pre($sqlinfo);
                   list($sql_main,$sql_order) = spliti(" order by ",strtolower($sqlinfo["sql"]));
                   $sqlstr    = $sql_main;
                   $sql_order = " order by " . $sql_order;
                }

		if (!eregi(" having ",$sqlstr)) {
                   $where_conj = (!eregi(" where ",$sqlstr)) ? " where " : " and ";
  		} else {
  		   $where_conj = " and ";
		}
		$query 	       = $this->GetVar("query","");
		$searchfield   = $this->GetVar("searchfield","");

		if ($qsearchprocess == true) {
		if (($query != "") && ($searchfield !="")) {
                        if (in_array($searchfield,array_keys($replace))) {
                           $assoc_array   = $replace[$searchfield];
                           $query         = $this->GetClosestMatch($query,$assoc_array);

			   if (is_array($query)) {
                           $sqlstr = $sqlstr . " $where_conj $searchfield in ('".join("'',''",$query)."') $sql_order";
                           } else {
                           $sqlstr = $sqlstr . " $where_conj $searchfield like '%$query%' $sql_order";
                           }
                        } else {
			   $sqlstr = $sqlstr . " $where_conj $searchfield like '%$query%' $sql_order";
                        }
                        $query = ""; $searchfield = "";
		}
		}
	} //adminpage
	//}  //if eregi !where

	//echo $sqlstr;

	$initialorder	= ($initialorder == "desc") ? "asc" : "desc";
	$sortorder	= $this->GetVar("sortorder",$initialorder);

	if ($sortorder == "desc") {
		$sortorder = "asc";
		$customsortmark = $upimage;
	} else {
		$sortorder = "desc";
		$customsortmark = $downimage;
	}

	//check if some sorting is needed

	if (!eregi(" order by ",$sqlstr) && ($adminpage == true)) {

                $orderby = $this->GetVar("orderby",$groupfield);

		//check if orderby is empty. it happens when primarykey is not set and groupby is not set either.
		if ($orderby == "") {
			$orderby = $fields[0];
		}

		if (eregi(" limit ", $sqlstr)) {
			$sqlinfo	= $this->StripLimit($sqlstr);
			$sqlstr	= $sqlinfo["sql"]." order by $orderby $sortorder limit ".$sqlinfo["start"].",".$sqlinfo["num"];
		} else {
			$sqlstr	= $sqlstr . " order by $orderby $sortorder ";
		}
	} else {
		$orderby	= "";
	}

	//if layout is not set, then determine if it's in admin mode or not.
	//In Admin mode, some basic components like SearchBox, PageList and ActionList should appear

	$sorthref	= "?$urlstring";
	$urlvars	= $this->GetURLVars(array("sortorder","orderby","ts"));

	if ($layout	== "") {
		$tdconfig       = array
                                (
                                "trattrib"              => $trattrib,
                                "tdattrib"          	=> $tdattrib,
                                "tdsortattrib"      	=> $tdsortattrib,
                                "currentsort"       	=> (!in_array($orderby,$nosortfields)) ? $orderby : "",
                                "sortcolors"        	=> $sortcolors,
                                "tdfieldattrib"     	=> $tdfieldattrib,
                                "tdsortfieldattrib" 	=> $tdsortfieldattrib,
                                "tdactionattrib"    	=> $tdactionattrib,
                                "detailrow"         	=> $detailrow,
                                "tdheadfieldattrib"     => $tdheadfieldattrib,
                                "tdsortheadfieldattrib" => $tdsortheadfieldattrib,
                                "clrheadfieldtext"      => $clrheadfieldtext,
                                "clrsortheadfieldtext"	=> $clrsortheadfieldtext,
                                "clrfieldtext"      	=> $clrfieldtext,
                                "clrsortfieldtext"	=> $clrsortfieldtext,
                                "tdfieldlayout"    	=> $tdfieldlayout,
                                "tdsortfieldlayout"	=> $tdsortfieldlayout,
                                "tdnumberinglayout"	=> $tdnumberinglayout,
                                );

		if ($adminpage == false) {
                        $default_layout  = $this->BuildDefaultLayout($fields,"",$tdconfig);

			$default_opentag  = "<tr bgcolor=$clr_head>";
			$default_opentag .= ($tdheadnumberinglayout != "") ? $tdheadnumberinglayout : "<td $tdheadattrib><font color=$clr_headtext> No.</font></td>";
			for ($i = 0; $i < count($fields); $i++) {
				$fieldname 	       = $fields[$i];
			    	$tdfieldheadattrib     = $this->_GetConfig($tdheadfieldattrib,$fieldname,$tdheadattrib);
				$tdsortheadattrib      = $this->_GetConfig($tdsortheadfieldattrib,$fieldname,$tdsortheadattrib);
				$label		       = $labels[$i];
				$clr_text	       = $this->_GetConfig($clrheadfieldtext,$fieldname,$clr_headtext);
				$clr_sorttext	       = $this->_GetConfig($clrsortheadfieldtext,$fieldname,$clr_headtext);
				$font		       = ($orderby == $fieldname) ? "<font color=$clr_sorttext>" : "<font color=$clr_text>";
				$tdlayout	       = $this->_GetConfig($tdheadfieldlayout,$fieldname,"");

				$default_opentag      .= ($tdlayout != "") ? $tdlayout : "<td $tdfieldheadattrib><b>$font$label</b></font></td>";
				
				/*
				if ($disablesort == false) {
					if (!in_array($fieldname,$nosortfields)) {
						$sortmark	  = ($fieldname == $orderby) ? $customsortmark : "";
						$sortlink	  = "$sorthref&orderby=$fieldname&sortorder=$sortorder&start=$start&$urlvars";
						$default_opentag .= ($tdlayout != "") ? $tdlayout : "<td $tdfieldheadattrib><a href=$sortlink>$font<b>$label $sortmark</b></font></a></td>";
					} else {
						$default_opentag .= ($tdlayout != "") ? $tdlayout : "<td $tdfieldheadattrib>$font$label</font></td>";
					}
				} else {
					$default_opentag .= ($tdlayout != "") ? $tdlayout : "<td $tdfieldheadattrib>$font$label</font></td>";
				}
				*/
			}
			$default_opentag .= "</tr>";

			$layout 	 = $default_layout;

		} else {
			$actioncolumn	 = ($noactions == false) ? "$actionlist" : "";
                        $default_layout  = $this->BuildDefaultLayout($fields,$actioncolumn,$tdconfig);
			$default_opentag = "<tr bgcolor=$clr_head>";
			$default_opentag .= ($tdheadnumberinglayout != "") ? $tdheadnumberinglayout : "<td $tdheadattrib><font color=$clr_headtext> No.</font></td>";

			for ($i = 0; $i < count($fields); $i++) {
				$fieldname 	       = $fields[$i];
			    	$tdfieldheadattrib     = $this->_GetConfig($tdheadfieldattrib,$fieldname,$tdheadattrib);
				$tdsortheadattrib      = $this->_GetConfig($tdsortheadfieldattrib,$fieldname,$tdsortheadattrib);
				$label		       = $labels[$i];
				$clr_text	       = $this->_GetConfig($clrheadfieldtext,$fieldname,$clr_headtext);
				$clr_sorttext	       = $this->_GetConfig($clrsortheadfieldtext,$fieldname,$clr_headtext);
				$font		       = ($orderby == $fieldname) ? "<font color=$clr_sorttext>" : "<font color=$clr_text>";
				$tdlayout	       = $this->_GetConfig($tdheadfieldlayout,$fieldname,"");
				$tdsortlayout	       = $this->_GetConfig($tdsortheadfieldlayout,$fieldname,$tdlayout);

				if ($disablesort == false) {
					if (!in_array($fieldname,$nosortfields)) {
						$sortmark	= ($fieldname == $orderby) ? $customsortmark : "";
						$sortlink	= "$sorthref&orderby=$fieldname&sortorder=$sortorder&start=$start&$urlvars";
						$tdlayout	= str_replace(array("%%SORTMARK_$fieldname%%","%%SORTLINK_$fieldname%%"),array($sortmark,$sortlink),$tdlayout);
						$tdsortlayout	= str_replace(array("%%SORTMARK_$fieldname%%","%%SORTLINK_$fieldname%%"),array($sortmark,$sortlink),$tdsortlayout);
						$headattrib     = ($fieldname == $orderby) ? $tdsortheadattrib : $tdfieldheadattrib;
						$temptdlayout	= ($fieldname == $orderby) ? $tdsortlayout : $tdlayout;
                                                $default_opentag .= ($tdlayout != "") ? $temptdlayout : "<td $headattrib><a href=$sortlink>$font<b>$label $sortmark</b></font></a></td>";
					} else {
						$default_opentag .= ($tdlayout != "") ? $tdlayout : "<td $tdfieldheadattrib>$font$label</font></td>";
					}
				} else {
					$default_opentag .= ($tdlayout != "") ? $tdlayout : "<td $tdfieldheadattrib>$font$label</font></td>";
				}
			}
			if ($noactions == false) {
				$default_opentag .= "<td $tdfieldheadattrib>$font Action</font></td></tr>";
			} else {
				$default_opentag .= "</tr>";
			}
			$layout 	= $default_layout;
		}
	} else {
		//autohead only works if layout is spesified

		if ($autohead == false) {
			//$default_opentag = "";
		} else {
			$default_opentag = $this->BuildOpenTag($layout,$groupfield,$disablesort,$nosortfields,$autoheadlabels);
		}

	}

	//a new addition as of March 20, 2004
	$layout = "$layout$rowtail";

	//if subheader is not empty, add it as prefix to opentag
	$opentag = "$opentag";

	if (eregi("%%SORTLINK_",$opentag)) {
		preg_match_all("/%%SORTLINK_(.+?)%%/",$opentag,$sortlinktags);
		$numlinktags = count($sortlinktags[0]);
		for ($l=0;$l<$numlinktags;$l++) {
			$field 	        = $sortlinktags[1][$l];
			$fieldtag 	= "%%SORTLINK_$field%%";
			$sorttag	= "%%SORTMARK_$field%%";
			if ($field == $orderby) {
			        if ($sortorder == "asc") {
			        $customsortmark = $upimage;
                                } else {
                                $customsortmark = $downimage;
			        }
			} else {
				$customsortmark = "";
			}
			$sortlink 	= "$sorthref&orderby=$field&sortorder=$sortorder&start=$start&$urlvars";
			$opentag  	= str_replace($fieldtag,$sortlink,$opentag);
			$opentag	= str_replace($sorttag,$customsortmark,$opentag);
		}
	}

	//smarter handling, if no open or closetag is specified but the row starts with <tr> then wrap it with table tags
	//if ($opentag == '' && $closetag == '') {

	if ($opentag == '') {
	if (eregi("<tr",$layout)) {
		if ($adminpage == true) {
			//$components = "%%SEARCHBOX%% <br><br>%%ADD%%Total Records: %%RECORDCOUNT%% in %%PAGECOUNT%% page(s) - %%PAGELIST%%<br><br>";
			if ($noadminheader == true) {
				$components = "";
			} else {
				$component_layout =
						"%%SEARCHBOX%% %%ADD%%Total Records: %%RECORDCOUNT%% in ".
						"%%PAGECOUNT%% page(s) %%PAGELIST%% <br><br>";
				$components	= $this->_GetConfig($cfg,"adminheader",$component_layout);
				//print htmlentities($components);
				//$components = (isset($GS["adminheader"])) ? $GS["adminheader"] : $component;
			}
		} else {
			$components = "";
		}
		$opentag = "$components<table $tblattrib >$default_opentag";

		if ($closetag == '') {
			$closetag= "</table>";
		}
		}
	}

	$basic_components	= array("|%%PAGECOUNT%%|","|%%PAGELIST%%|","|%%ADD%%|","|%%SEARCHBOX%%|","|%%RECORDCOUNT%%|","|%%AUTOHEAD%%|");
	if ($disableadd == false) {
		$acthref		= "<a href=\"?act=add\">$addlabel</a><br>";
	} else {
		$acthref		= "";
	}
	$searchbox		= $this->SearchBox($cfg,$searchboxlayout);

	if (!eregi("<table",$opentag)) {
		$autohead	= "<table $tblattrib>".$default_opentag;
	} else {
		$autohead	= $default_opentag;
	}
	
	if (eregi(" limit ",$sqlstr)) {
		$sqlinfo	= $this->StripLimit($sqlstr);
	        $numrecs 	= ($numrecords == "") ? $this->CountRecs($sqlinfo["sql"],$database) : $numrecords;
		$numrecs        = ($numrecs > $maxstart) ? $maxstart : $numrecs;
                $numpages	= ceil($numrecs / $num);
		$pagelist 	= $this->GetPageList($numrecs,$sqlinfo["num"],"",$start,'start','',$pagingstyle,$maxstart);

	} else {
		//If no limit is specified, spesify it first because the process will need a complete arguments
		//that includes the limit parameters
		$sqlstr	        = "$sqlstr limit $start, $num";
		$sqlinfo	= $this->StripLimit($sqlstr);
		$numrecs 	= ($numrecords == "") ? $this->CountRecs($sqlinfo["sql"],$database) : $numrecords;
		$numrecs        = ($numrecs > $maxstart) ? $maxstart : $numrecs;
		$numpages	= ceil($numrecs / $num);
		$pagelist 	= $this->GetPageList($numrecs,$sqlinfo["num"],"",$start,'start','',$pagingstyle,$maxstart);

	}
	$opentag	= preg_replace($basic_components,array($numpages,$pagelist,$acthref,$searchbox,$numrecs,$autohead),"$subheader$opentag");
	$closetag	= preg_replace($basic_components,array($numpages,$pagelist,$acthref,$searchbox,$numrecs,$autohead),$closetag);

        //after subheader is used, reset it so it won't be used by the innerprocess
        $subheader      = "";

	//count the maximun alternate colors provided

	$maxcolors 	= count($altcolors);		//max alternative colors used
	$maxgcolors	= count($groupcolors); 		//count($cfg["groupcolors"]);   	//maks group colors used
	$maxgccount	= count($groupcolors[0]);	//max element each group color contains
	$maxaltrows	= count($altrows);

	$altcolor  	= 0;
	$sortcolor      = 0;
	$altrow	        = 0;
	$groupno	= 1;
	$groupclrno	= -1;
	$rowspan	= 0;

	$head		= "";
	$tail		= "";
	$content 	= $header.$errorlist.$opentag;

	$rowspans	= array();
	$cellfind	= array();
	$cellreplace	= array();
	$addedcells	= "";

	$use_alternate_layout = false;
	$cond_style	= "";

	$columnno	= 0;
	$rowno		= 1;
	$showrowno	= 1;
	$itemno		= 0;

        if ($sqlparsing == false) $sqlstr = $puresql;

        if ($printsql == true) {
		print "<hr size=1>$database<br><b>SQL:</b> ".$this->PlainMessage($sqlstr)."<hr size=1>";
	}

	$rs	= $this->RunSql($sqlstr,$database);

        //as of 727
        //even though the fields are specified, during loop process all fields
        //this is useful when we need to stringformat certain fields which will not be
        //used in a column but combined with the other fieldvalues
        $fields = $allfields;

	if ($this->numrecs < 1) {
		$layout = "";
	}

	$norecords	= $this->_GetSetting($cfg["norecords"],"");
	if ($searchresultmode == false) {
		if ($norecords == "") {
			$nodatamessage 	= "$header $subheader $opentag $layout $closetag";
		} else {
			$nodatamessage	= $norecords;
		}
	} else {
		if ($norecords == "") {
			$nodatamessage	= "<br>Your query results in no data <br><br>";
		} else {
			$nodatamessage 	= $norecords;
		}
	}
	$norecords	= $nodatamessage;

	//after the head are built, then add primary key to list of fields to be processed
	if (!in_array($primarykey,$fields)) {
		array_push($fields,$primarykey);
		array_push($labels,$primarykey);
	}

	//before enumerating the result, store the original layout variable
	//because it may be conditionally changed within the loop if it matches a certain condition

	$original_layout = $layout;

	if (!$rs || ($this->numrecs < 1)) {
	   $norecordlayout = preg_replace($basic_components,array($numpages,$pagelist,$acthref,$searchbox,$numrecs,$autohead),"$norecords");
	   return ($boxwrapper == "") ? $norecordlayout : str_replace("%%FORMLAYOUT%%",$norecordlayout,$boxwrapper);
 	}

	while ($rows = mysql_fetch_array($rs,MYSQL_BOTH)) {

		$columnno++;
		$elements 	= 0;
		//prepare which color will be used
		if (($altcolor % $maxcolors)== 0) $altcolor = 0;

		if ($maxaltrows > 0) {
			if (($altrow % $maxaltrows)== 0) $altrow = 0;
			$original_layout = $altrows[$altrow];
		}

		$array_elements = array("|%%ROWNO%%|","|%%NO%%|","|%%ALTCOLOR%%|","|%%ALTSORTCOLOR%%|","|%%GROUPNO%%|","|%%DEFAULT_ACTION%%|","|%%ORDERBY%%|");
		$array_values = array($showrowno,$rownum,$altcolors[$altcolor],$sortcolors[$altcolor],$groupno,$actionlist,$orderby);

		$use_alternate_layout = false;
		$cond_style 	= "";		 //reset the condition style used for conditional layout for each record loop

		foreach($fields as $value) {
		        if ($value == $primarykey) $this->last_article_id = $rows[$value];
                        if ($value == "title") $this->last_article_title = $rows[$value];
			//check if the rows need to be grouped by certain field
			$field_value = stripslashes($rows[$value]);
			if ($groupfield == $value) {
			        //if last group field value is the same as the current value
				if (strtolower($lastgroup) == strtolower($field_value)) {
					$startgroup = false;
					$lastgroup = $field_value;
					$field_value = ($showsimilar == false) ? "" : $field_value;
					$head = "";
					$tail = "";
					$rowspan_order = $groupno - 1;
					$rowspan_tag = "|%%ROWSPAN$rowspan_order%%|";
					$rowspans[$rowspan_tag] = $rowspan;
				} else {
					$startgroup	= true;
					$field_value= ucwords($field_value);
					$lastgroup 	= $field_value;
					$groupclrno++;
					$rowspan = 1;
					if ($groupclrno > $maxgcolors-1) $groupclrno = 0;
					if ($grouphead != '') {
						$head = str_replace("%%ORDERBY%%","$field_value",$grouphead);
					}
					if ($grouptail != '') {
						if ($groupno != 1) {
							$tail		= $grouptail;
						}
					}
					$groupno++;
					//group colors are set, then
				} //if lastgroup
				// Now process which group colors to be used
				if ($maxgcolors != 0) {
					for ($c = 0; $c < $maxgcolors; $c++) {
						$tagno = $c + 1;
						if ($groupclrno < 0) $groupclrno = 0;
						if (count($groupcolors[$groupclrno]) != 0) {  //!=
							$gcolor = @$groupcolors[$groupclrno][$c];
							$tagcolor = "ALTGCOLOR".$tagno;
							array_push($array_values,"$gcolor");
							array_push($array_elements,"|%%".$tagcolor."%%|");
						}

					} //for
				}//if maxcolors
			}//if groupfield

			//check if value needs to be formatted
			if (in_array($value,$numformat)) {
				if (is_numeric($field_value)) $field_value = number_format($field_value,0,0,'.');
			} elseif (in_array($value,$dateformat)) {
				$field_value = $this->FormatTime($field_value);
			}

			//check if value needs to replaced
			if (count($replace) != 0) {

				if (trim($field_value) == "") {
					$field_value = "<EMPTY>";
				}
				if (array_key_exists($value,$replace)) {
					if (array_key_exists($field_value,$replace[$value])) {
						$replstr = $replace[$value][$field_value];
						$tmp = str_replace($field_value,$replstr,trim($field_value));
						$field_value = str_replace("%%ROWNO%%",$showrowno,$tmp);
					}
				}
			}
			if ($field_value == "<EMPTY>") $field_value = "";

			//strformat handling used to be here but now placed out of the fields loop

			array_push($array_values,$field_value);
			array_push($array_elements, "|%%".$value."%%|");
			$keyvalues[$value] = $field_value;
			
			//---additional as of 773 to add a security feature
                        if (eregi("%%SAFEKEY_",$layout)) {
                            $safekey   = 'SAFEKEY'.'_'.$value;
                            $safevalue = md5($this->sitekey.$field_value);
                            $keyvalues[$safekey] = $safevalue;
                            array_push($array_values,$safevalue);
    			    array_push($array_elements, "|%%".$safekey."%%|");
                        }
                        //print $safekey;
			//---end of addition

			$elements++;

			//check if table row needs an alternate layout and store the condition into flag

			$layoutconds = @$layoutconditions[$value];
			if (count($layoutconds) > 0) {
				$cond_operator = $layoutconds[0];
				$cond_value	   = $layoutconds[1];
				if ($cond_style == "") {
					$cond_layout   = $layoutconds[2];
				}

				if ($cond_operator == "equals") {
					$comparison_result = (strtolower($field_value) == $cond_value) ? true : false;
				} elseif ($cond_operator == "contains") {
					$comparison_result = (eregi($cond_value,$field_value)) ? true : false;
				}

				//since this is a field-level loop, once a condition is true, then preserve the boolean value

				//and reset the value on the next record loop
				if ($use_alternate_layout == false) {
					if ($comparison_result == true) {
						$use_alternate_layout = true;
						$cond_style	= $cond_layout;
					} else {
						$use_alternate_layout = false;
					}
				} else {
					$use_alternate_layout = true;
					$cond_style	= $cond_layout;
				}
			}
		}//foreach

  		/*---A NEW strformat handling as of v689*/

		reset($strformat);
		while(list($xfield,$xvalue) = each($strformat)) {
			//$xvalue = $this->_Tag2Values($xvalue,$keyvalues);
			//print "$xfield -> $xvalue<br>";
			$key_index     = array_keys($array_elements,"|%%$xfield%%|");
              		$func_str      = split("\(",$xvalue);
                        $func_name     = $func_str[0];
                        $func_param    = substr($func_str[1],0,strlen($func_str[1])-1);
			$index         = $key_index[0];
			$array_values[$index] = $this->ProcessStrFunction($func_name,$this->_Tag2Values($func_param,$keyvalues,false));
		}

                preg_match_all("|%%RELATEDFILE(.*?)%%|",$layout,$related_file_match);
                $related_file_count = count($related_file_match[0]);
		$sqlinfo            = $this->StripLimit($sqlstr);
		$tablename          = $sqlinfo["table"];

                for($z=0;$z < $related_file_count;$z++) {
                        $filetag      = addslashes($related_file_match[0][$z]);
                        $fileattrib   = $this->_GetSetting($related_file_match[1][$z],"");
                        $filesql      = $this->_Tag2Values("select * from cms_upload where tablename='$tablename' and keyid='%%$primarykey%%'",$keyvalues,false);
                        $relatedfile  = $this->GetFile($filesql,stripslashes($fileattrib));
                        array_push($array_elements,"|$filetag|");
                        array_push($array_values,$relatedfile);
                }

                preg_match_all('|%%RELATEDTHUMB(.*?)%%|',$layout,$related_thumb_match);
                $related_thumb_count  = count($related_thumb_match[0]);
                
                for($y=0;$y < $related_thumb_count;$y++) {
                        $thumbtag     = addslashes($related_thumb_match[0][$y]);
                        $thumbattrib  = $this->_GetSetting($related_thumb_match[1][$y],"");
			$picsql       = $this->_Tag2Values("select * from $picturetable where keyid='%%$primarykey%%' and tablename='$tablename'",$keyvalues,false);
                        list($thumbnail,$rel_picture_title,$rel_picture_desc) = $this->GetPicture($picsql,stripslashes($thumbattrib),"thumb");
			$yno          = $y + 1;

                        $this->SavePicTitleDescription("THUMB",$layout,$array_elements,$array_values,$rel_picture_title,$rel_picture_desc,$yno);

                        array_push($array_elements,"|$thumbtag|");
			array_push($array_values,$thumbnail);
                }

                preg_match_all('|%%RELATEDPICTURE(.*?)%%|',$layout,$related_pic_match);
                $related_pic_count  = count($related_pic_match[0]);

                for($x=0;$x < $related_pic_count;$x++) {
                        $pictag     = addslashes($related_pic_match[0][$x]);
                        $picattrib  = $this->_GetSetting($related_pic_match[1][$x],"");
			$picsql     = $this->_Tag2Values("select * from $picturetable where keyid='%%$primarykey%%' and tablename='$tablename'",$keyvalues,false);
                        list($picture,$rel_picture_title,$rel_picture_desc) = $this->GetPicture($picsql,stripslashes($picattrib),"picture");
                        $xno        = $x + 1;

                        $this->SavePicTitleDescription("PICTURE",$layout,$array_elements,$array_values,$rel_picture_title,$rel_picture_desc,$xno);

                        array_push($array_elements,"|$pictag|");
			array_push($array_values,$picture);
                }

		if ($use_alternate_layout == true) {
			if ($cond_style != "") {
				$layout = $altlayouts[$cond_style];
			}
		} else {
			$layout = $original_layout;
		}

                //This is a v733 addition. A real hack to solve layout conditions
                if ($rowfunction != "") {
                    $processed_layout = call_user_func($rowfunction,$keyvalues,$original_layout);
                    $layout = $processed_layout;
                }

		// if there is a sub-query to process

		if ($innersql != '') {
			//before replacing tag in the sql, store the original sql in a temporary variable
			//print "$query $searchfield <br>";
			$tmpsql				= $innersql["sql"];
			$insqlstr 			= preg_replace($array_elements,$array_values,$innersql["sql"]);
			$innersql["sql"] 		= $insqlstr;
			$innersql["qsearchprocess"] 	= false;
			$innersql["sqlparsing"]         = false;
			$incontent 			= $this->ProcessContent($innersql);
			$innersql["sql"] 		= $tmpsql;
			array_push($array_values,$incontent);
			array_push($array_elements,"|%%INNERPROCESS%%|");
		}

		// this is a very complex handling of rowspan
		if ($userowspan == true) {
			$artmp = array();
			$tmp = split("</",$layout);
			$groupfield_tag = "%%$groupfield%%";
			$rowspan_order = $groupno - 1;
			foreach($tmp as $td) {
				if ($startgroup == true) {
					if (ereg($groupfield_tag,$td)) {
						$td = str_replace("<TD","<td",$td);
						array_push($artmp,str_replace("<td","<td rowspan=%%ROWSPAN$rowspan_order%% ",$td));
					} else {
						array_push($artmp,$td);
					}
				} else {
					if (ereg($groupfield_tag,$td)) {
						$tdhidden = str_replace($groupfield_tag,"%%HIDDEN%%",$td);
						array_push($artmp,str_replace("<td","<td_hidden",($tdhidden)));
					} else {
						array_push($artmp,$td);
					}
				}
			}

			$translated_layout = join("</",$artmp);
		} else {
			$translated_layout = $layout;
		}


		//fhew, the complex handling is now done

		if ($verticalorder == true) {
			$print_result = "$tail$head%%---$itemno---%%";
			$cell_result = preg_replace(($array_elements),$array_values,"$tail$head$translated_layout");
			array_push($cellfind,"|$print_result|");
			array_push($cellreplace,"$cell_result");
		} else {

			$print_result = preg_replace(($array_elements),$array_values,"$tail$head$translated_layout");
		}

		//print htmlentities($print_result)."<br>";


		$content .= $print_result;

		//this is to handle multiple column layout
		if ($columnar == true) {
			$newline = $columnno % $numcolumns;
			//print "$numcolumns $columnno $newline<br>";
			$altbgcolor = (($rowno % 2) == 0) ? 1 : 0;
			$trbgcolor	= $altcolors[$altbgcolor];
			if ($newline == 0) {
				if ($itemno >= $num) {
					$rowno++;
					$content .= "</tr>\n<tr>$separator";
				} else {
					$rowno++;
					$content .= "</tr>\n$separator<tr>";
				}
			}
		} else {
			$content .= $separator;
		}

		$rownum++;
		$altcolor++;
		$altrow++;
		$rowspan++;
		$itemno++;
		$showrowno++;
		//if ($startgroup == true) $altcolor = 0;
	} //while

	if ($userowspan == true) {
		$content = preg_replace(array_keys($rowspans),array_values($rowspans),$content);

		preg_match_all("/(\<td_hidden.+?%%HIDDEN%%.+?\/td>)/",$content,$matches);

		foreach ($matches[0] as $m) {
			$find = $m;
			$content = str_replace($find,"",$content);
		}
	}

	//this part handles the columnar layout
	if ($columnar == true) {

		//if no cells left empty
		$emptycells = 1;
		$rowno = ceil($itemno / $numcolumns);

		//print "$itemno - $rowno <hr>";

		if ($itemno < ($numcolumns * $rowno)) {
			$emptycolumns = ($rowno * $numcolumns) - $itemno;
			if ($emptycolumns != $numcolumns) {
			        $emptycell_layout = ($emptycell == "") ? "<td>&nbsp;</td>" : $emptycell;
				for ($cell = 0; $cell < $emptycolumns; $cell++) {
					if ($verticalorder == false) {
						$addedcells .= $emptycell_layout;
					} else {
						$cellnumber = $itemno+$cell;
						$tmpcell = "%%---$cellnumber---%%";
						$addedcells .= $tmpcell;
						array_push($cellfind,"|$tmpcell|");
						array_push($cellreplace,$emptycell_layout);
					}
				}
			}
			$addedcells .= "</tr>$separator";

			$content .= $addedcells;
		}
	}
	$content .= "$closetag$footer";

	if ($verticalorder == true) {
		//$tmp = preg_replace($cellfind,$cellreplace,$content);
		$content = $this->RotateArray($content,$rowno,$numcolumns,$cellfind,$cellreplace);
	}

	if ($boxwrapper != "") {
	   $content = $tmp_header. str_replace("%%FORMLAYOUT%%",$content,$boxwrapper);
	}
	return $content;
} //ProcessContent()

function SavePicTitleDescription($thumb_or_picture,$layout,&$array_elements,&$array_values,$rel_picture_title,$rel_picture_desc,$xno) {
    if (eregi("%%$thumb_or_picture"."DESCRIPTION",$layout)) {
    if ($xno==1) {
           array_push($array_elements,"|%%$thumb_or_picture"."DESCRIPTION%%|");
           array_push($array_values,$rel_picture_desc);
           array_push($array_elements,"|%%$thumb_or_picture"."DESCRIPTION$xno%%|");
           array_push($array_values,$rel_picture_desc);
    } else {
           array_push($array_elements,"|%%$thumb_or_picture"."DESCRIPTION$xno%%|");
           array_push($array_values,$rel_picture_desc);
    }
    }

    if (eregi("%%$thumb_or_picture"."TITLE",$layout)) {
    if ($xno==1) {
           array_push($array_elements,"|%%$thumb_or_picture"."TITLE%%|");
           array_push($array_values,$rel_picture_title);
           array_push($array_elements,"|%%$thumb_or_picture"."TITLE$xno%%|");
           array_push($array_values,$rel_picture_title);
    } else {
           array_push($array_elements,"|%%$thumb_or_picture"."TITLE$xno%%|");
           array_push($array_values,$rel_picture_title);
    }
    }
} //SavePicTitleDescription

function GetFile($sql,$fileattrib) {
	$orderby	= "id";
	$sortorder	= "desc";
	$whereconj	= "";

	if (eregi(" orderby=",$fileattrib)) {
	    preg_match("/ orderby=\b(.+?)\b/i",$imgattrib,$match);
 	    $orderby    = $match[1];
	}

        if (eregi(" field=",$fileattrib)) {
	    preg_match("/ field=\b(.+?)\b/i",$fileattrib,$match);
 	    $picfield   = $match[1];
 	    if (eregi(" where ",$sql)) {
 	       $whereconj = " and fieldname='$picfield' ";
	    } else {
	       $whereconj = " fieldname='$picfield' ";
	    }
	    //print "<li>$picfield";
	}

	if (eregi(" sortorder=",$fileattrib)) {
	    preg_match("/ sortorder=\b(.+?)\b/i",$fileattrib,$match);
 	    $sortorder  = $match[1];

	}

	if (!eregi(" limit 0",$sql)) {
	   $sql		= $sql . "$whereconj order by $orderby $sortorder ";
	}

        list($path,$file) = $this->GetArrayValues($sql,array("path","filename"));
        return "<a href=/$path/$file $fileattrib>$file</a>";
}

function GetPicture($sql,$imgattrib,$picturetype="thumb") {
	global $DOCUMENT_ROOT;

	$orderby	= "id";
	$sortorder	= "desc";
	$whereconj	= "";

	if (eregi(" orderby=",$imgattrib)) {
	    preg_match("/ orderby=\b(.+?)\b/i",$imgattrib,$match);
 	    $orderby    = $match[1];
	}

	if (eregi(" picorder=",$imgattrib)) {
	    preg_match("/ picorder=\b(.+?)\b/i",$imgattrib,$match);
 	    $picorder   = (int)$match[1] - 1;
	} else {
	    $picorder   = 0;
        }

        if (eregi(" field=",$imgattrib)) {
	    preg_match("/ field=\b(.+?)\b/i",$imgattrib,$match);
 	    $picfield   = $match[1];
 	    if (eregi(" where ",$sql)) {
 	       $whereconj = " and fieldname='$picfield' ";
	    } else {
	       $whereconj = " fieldname='$picfield' ";
	    }
	    //print "<li>$picfield";
	}

	if (eregi(" sortorder=",$imgattrib)) {
	    preg_match("/ sortorder=\b(.+?)\b/i",$imgattrib,$match);
 	    $sortorder  = $match[1];

	}

	if (!eregi(" limit ",$sql)) {
	   $sql		= $sql . "$whereconj order by $orderby $sortorder limit $picorder, 1";
	} else {
	   $sql		= $sql . "$whereconj order by $orderby $sortorder";
        }

	$last_pic 	= $this->GetArrayValues($sql,array("path","filename","thumbpath","thumbname","title","description"));
        $title    	= $last_pic["title"];
        $description    = $last_pic["description"];
	$filename	= "/".$last_pic["path"]."/".$last_pic["filename"];
	$thumbname	= "/".$last_pic["thumbpath"]."/".$last_pic["thumbname"];
	$picturename	= ($picturetype == "thumb") ? $thumbname : $filename;
	$checkfile	= "$DOCUMENT_ROOT/$picturename";

	if (file_exists($checkfile)) {
		if (is_file($checkfile)) {
		        $hwattrib = "";
                        if (eregi(" maxdimension=",$imgattrib)) {
                           preg_match("/maxdimension=(\d.*\d)/i",$imgattrib,$match);
                           $maxside = $match[1];
                           list($w,$h,$sw,$sy) = $this->SampleSize($checkfile,$maxside,$maxside,"maxdimension");
                           if ($sw < $w && $sy < $h) {
                             $hwattrib = " ";
                           } else {
                             $hwattrib = " width=$w height=$h";
                           }
                        }
                        if ($hwattrib == " ") {
			$thumbtag = "<img $imgattrib $hwattrib src=\"$picturename\">";
			} else {
			if (eregi(" link_to_original",$imgattrib)) {
			$thumbtag = "<a href=$picturename target=_blank><img $imgattrib $hwattrib src=\"$picturename\"></a>";
                        } else {
			$thumbtag = "<img $imgattrib $hwattrib src=\"$picturename\">";
                        }
                        }
		} else {
			$thumbtag = "&nbsp;"; 		}
	} else {
		$thumbtag = "&nbsp;";
	}
	$thumbtag = str_replace(array("PICTURETITLE","PICTUREDESCRIPTION"),array("\"$title\"","\"$description\""),$thumbtag);
	return array($thumbtag,$title,$description);
} //GetPicture()


function RotateArray($content,$rownum,$colnum,$cellfind,$cellreplace) {
	$itemno = 0;
	$newcellreplace = array();
	for ($row = 1; $row <= $rownum; $row++) {
		for ($col = 0; $col < $colnum; $col++) {
			$pos = ($col * $rownum) + $row;
			//$celltmp = htmlentities($cellreplace[$pos-1]);
			//print "$itemno ($col * $rownum) + $row = $pos => $celltmp<br>";
			array_push($newcellreplace,$cellreplace[$pos-1]);
			$itemno++;
		}
	}
	return preg_replace($cellfind,$newcellreplace,$content);
} //RotateArray()


function BuildOpenTag($layout,$orderby="",$disablesort=false,$nosortfields=array(),$labels=array()) {
	global $GS;
	$opentag = "";//print $orderby;
	$arTags = array();
	$exception = array("ts");
	//v662
	//anticipating miscalculation of columns because of some URL request string

        preg_match("|(<tr(.*?)\/tr>)|si",$layout,$match);
        $layout = $this->_GetSetting($match[0],"");

	preg_match_all("|=%%(.*?)%%|",$layout,$excludedtags,PREG_PATTERN_ORDER);
	foreach($excludedtags[0] as $tag) {
		$layout = preg_replace("|$tag|","",$layout);
	}

	foreach($nosortfields as $tag) {
		$layout = preg_replace("|$tag|","",$layout);
	}
	//

	preg_match_all("|%%(.*?)%%|",$layout,$tags,PREG_PATTERN_ORDER);
	$numtags = count($tags[1]);

	$clr_head	= $this->_GetGS("clr_head","#000000");
	$clr_headtext	= $this->_GetGS("clr_headtext","#000000");

	for ($c = 0; $c < $numtags; $c++) {
		$func 	= $tags[1][$c];
		$tag  	= $tags[0][$c];
		$tag2	= substr($tag,2,-2);

		array_push($arTags,$tag);
		if (!eregi('%%ALTCOLOR%%',$tag)) {
			$fieldname 	= preg_replace(array("|%%|","|DEFAULT_ACTION|"),array("","Action"),$tag);
			if ($fieldname == 'RELATEDPICTURE') $fieldname = "";
			$coltitle	= $this->FormatLabel($fieldname);

			//if labels array is set then use it
                        if (count($labels)!=0) $coltitle = isset($labels[$c]) ? $labels[$c] : $coltitle;

			$start	= $this->GetVar("start",0);
			$sortorder	= ($this->GetVar("sortorder","desc")=="desc") ? "asc" : "desc";

			$orderby	= ($this->GetVar("orderby",$orderby));

			if ($sortorder == "asc") {
			   $customsortmark = $this->img_sortasc;
                        } else {
			   $customsortmark = $this->img_sortdesc;
          	        }

			$sortmark	= ($orderby == $fieldname) ? $customsortmark : "";
			$headlink 	= "?".$this->GetURLVars($exception)."orderby=$fieldname&start=$start&sortorder=$sortorder&";
			if (($coltitle == "NO") || ($coltitle == "Action")) {
				$coltitle = $this->FormatLabel(strtolower($coltitle));
				$opentag .= "<td bgcolor=$clr_head nowrap><font color=$clr_headtext>$coltitle $sortmark</td>";
			} else {
				if (($disablesort == false) && (!in_array($coltitle,$nosortfields))) {
					$opentag .= "<td bgcolor=$clr_head nowrap><a href=$headlink><font color=$clr_headtext><b>".
							ucfirst(strtolower($coltitle))." $sortmark</b></font></a></td>";
                                } else {
					$opentag .= "<td bgcolor=$clr_head><font color=$clr_headtext>".
							ucfirst(strtolower($coltitle))." </font></td>";
				}
			}
		}
	}
	return "<tr>".$opentag."</tr>";
} //BuildOpenTag()


function ProcessStrFunction($func_name,$func_param) {
global $DOCUMENT_ROOT;
	switch (strtolower(trim($func_name))) {
	case 'truncate':
		$params 	= split(",",$func_param);
		$numparams	= count($params);
		$l		= (!isset($params[1])) ? 100 : $params[$numparams-1];
		array_pop($params);
		$s		= strip_tags(join(" ",$params),$this->allowedtags);
		$truncated	= substr($s,0,$l);
		if ($l < strlen($s)) $truncated .= " ...";
		return strip_tags($truncated,"<br>");
		break;
	case 'substr':
		$params 	= split(",",$func_param);
		$numparams	= count($params);
		$l		= (!isset($params[1])) ? 100 : $params[$numparams-1];
		array_pop($params);
		$s		= strip_tags(join(" ",$params));
		$truncated	= substr($s,0,$l);
		return $truncated;
		break;
	case 'addbullet':
		if ($func_param != '') {
			return "<li>$func_param";
		} else {
			return "<li> -";
		}
		break;
	//--Add your custom class here
	case 'piclink':
		clearstatcache();
		$thumbviewsize  = $this->thumbviewsize;
		$params		= split(",",$func_param);
		$pic 		= $params[0];
		$thumb		= $params[1];
		$showthumb	= $params[2];
		$url		= $this->_GetSetting($params[3],"");
		$image_attrib	= $this->_GetSetting($params[4],"border=0 vspace=2 hspace=2 height=$thumbviewsize width=$thumbviewsize");

		if ($thumb == "//") $thumb = "2";

		if (file_exists("$DOCUMENT_ROOT/$pic")) {
			if ($showthumb == 0) {
				return "<a href=\"$url$pic\" target=_blank><font color=#a7a7a7>Yes</a></a>";
			} else {
				clearstatcache();
				if (file_exists("$DOCUMENT_ROOT/$thumb")) {
					return 	"<a href=\"$url$pic\" target=_blank><img ".
						"src=\"$thumb\" $image_attrib></a>";
				} else {
					return "<a href=\"$url$pic\" target=_blank>[no thumbnail]</a>";
				}
			}
		} else {
			if ($showthumb == 0) {
				return "No";
			} else {
				return "";
			}
		}
	        break;
	case 'call_user_func':
	        $params        = split(",",$func_param,2);
	        $user_func     = $params[0];
                $udf_param     = $params[1];
	        if (eregi("@",$user_func)) {
	        list($objname,$obj) = split("@",$user_func);
                return call_user_func(array($obj,$objname),$udf_param);
                } else {
                return call_user_func($user_func,$udf_param);
                }
	        break;
	case 'value2picture':
		$params 	= split(",",$func_param);
		$fieldvalue	= $params[0];
		$prefix		= $params[1];
		$suffix		= $params[2];
		$path		= $params[3];
		$imgname	= "$path/$prefix$fieldvalue$suffix.jpg";
		$checkfile	= "$DOCUMENT_ROOT/$imgname";
		if (file_exists($checkfile)) {
			return "<img src=$imgname>";
		} else {
			return "";
		};
		break;
	case 'value2dbpicture':
	        $params	       = split(",",$func_param);
	        $fieldvalue    = $params[0];
	        $path	       = $params[1];
	        $imgname       = "/$path/$fieldvalue";
	        $checkfile     = "$DOCUMENT_ROOT/$imgname";
	        if (file_exists($checkfile)) {
	     	       return "<img border=0 src=\"$imgname\">";
		} else {
		       return "";
		}
	        break;
	case 'split_into_columns':
		if (eregi("\|",$func_param)) {
			$info = split("\|",$func_param);
			return "$info[0]</td><td align=center>$info[1]";
		} else {
			return "$func_param</td><td>&nbsp;";
		}
		break;
	case 'urlencode':
		return urlencode($func_param);
	default:
		return $this->FieldFormat($func_param,$func_name);
		break;	
	}
} //ProcessStrFunction()


function FormatLabel($array) {
	if (is_array($array)) {
		$result = array();
		foreach($array as $value) {
			$newvalue = str_replace("_"," ",$value);
			array_push($result,ucwords($newvalue));
		}
		return $result; 
	} else {
		$newvalue = str_replace("_"," ",$array);
		return ucwords($newvalue);
	}

} //FormatLabel()


function FieldFormat($fieldvalue,$saveformat='') {

	$saveformat = strtolower($saveformat);

	switch($saveformat) {
	case 'safekey':
		return md5($this->safekey.$fieldvalue);
	case 'concat':
		return join("",split(",",$fieldvalue));
		break;
	case 'strip_tags':
		return strip_tags($fieldvalue,$this->allowedtags);
		break;
	case 'md5':
		return md5($fieldvalue);
	case 'ucfirst':
		return ucfirst($fieldvalue);
		break;
	case 'ucwords':
		return ucwords($fieldvalue);
		break;
	case 'strtolower':
		return strtolower($fieldvalue);
		break;
	case 'strtoupper':
		return strtoupper($fieldvalue);
		break;
	case 'pipetoenter':
		return preg_replace(array("| \| | ","| \||","|\||"),"\n",$fieldvalue);
		break;
	case 'pipetobr':
		return preg_replace(array("| \| | ","| \||","|\||"),"<br>",$fieldvalue);
		break;
	case 'entertopipe':
		return preg_replace("\n",array("| \| |","| \||","|\||"),$fieldvalue);
		break;
	case 'csv_line':
		$fieldvalue = preg_replace("/(,|;|\n|\r|&nbsp;)/"," ",$fieldvalue);
		return stripslashes($fieldvalue);
		break;
	default:
		return $fieldvalue;
		break;
	}
} //FieldFormat()


function GenerateID($prefix='',$use_randomtail = false) {
	if ($use_randomtail == true) {
		$r = rand(1000,9999);
	} else {
		$r = "";
	}
	return $prefix.date("Y").date("m").date("d").date("H").date("i").date("s").$r;
} //GenerateID()


function GetJSArray($query_string, $array_name) {
	$result = array();
	//print str_replace("&","<br>&",$query_string);
	$elements = split("&",$query_string); 
	for ($i = 0; $i < count($elements); $i++) { 
		$pair = split("=",$elements[$i]);
		//count if an alement is a pair of two elements
		if (count($pair) > 1) {
			$key = $pair[0];
			$val = $pair[1]; 
			if ($key == $array_name) { 
				array_push($result,$val); 
			}
		}
	}
	return $result;
} //GetJSArray()


function ProcessAdmin($form_config,$display_config = array()) {

	$act 		= $this->GetVar("act","show");
	$database	= $this->_GetSetting($form_config["database"],"");
	$method		= $this->_GetSetting($form_config["method"],"post");
	$table		= $this->_GetSetting($form_config["table"],"");
	$saveedit	= $this->_GetSetting($form_config["saveedit"],"saveedit");
	$saveadd	= $this->_GetSetting($form_config["saveadd"],"saveadd");
	$reportfields	= $this->_GetSetting($form_config["reportfields"],$this->GetFields("select * from $table limit 0,1",$database));
	$primarykey	= $this->_GetSetting($form_config["primarykey"],$reportfields[0]);
	$displayoutput	= $this->_GetSetting($form_config["displayoutput"],true);

	$disableedit	= $this->_GetSetting($display_config["disableedit"],false);
	$disableadd	= $this->_GetSetting($display_config["disableadd"],false);
	$disabledelete	= $this->_GetSetting($display_config["disabledelete"],false);
	$disableview    = $this->_GetSetting($display_config["disableview"],false);

	$searchheader    = $this->_GetSetting($display_config["searchheader"],true);


 	$form_config["primarykey"]	= $primarykey;
	$display_config["sql"]  	= (!isset($display_config["sql"])) 		? "select * from $table" : $display_config["sql"];
	$display_config["adminpage"] 	= (!isset($display_config["adminpage"])) 	? false 	: $display_config["adminpage"];
	$display_config["primarykey"]	= (!isset($display_config["primarykey"]))	? $primarykey : $display_config["primarykey"];
        $display_config["opentag"]      = (!isset($display_config["opentag"]))	        ? "" : $display_config["opentag"];

	if ($act == "show") {
		print $this->ProcessContent($display_config);
	} elseif ($act == "showresult") {
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
		$method = "get";
		if ($method == "get") {
			$arfields = $HTTP_GET_VARS;
		} else {
			$arfields = $HTTP_POST_VARS;
		}

		//print_r($arfields);
		
		$boolcond	= $this->GetVar("boolcond","AND","get");
		list($searchsql,$queryinfo)	= $this->BuildSearchSQL($arfields,$table,"get",$boolcond,$arfields['column_shown']);
		if ($searchsql != "") {
 			$display_config["sql"] 		    = $searchsql;
 			$display_config["searchresultmode"] = true;

			if ($searchheader == true) {
			print "<b>SEARCH RESULT</b><br><br>
                              <table border=0 cellpadding=4 bgcolor=#ebebeb width=100%>
                              <tr><td><b>Search Criteria:</b> $queryinfo</td></tr></table>
                              <br><a href=?act=show><b>&lt;&lt; Show All</b></a>
                              &nbsp;|&nbsp;
                              <a href=?act=advsearch><b>Search Again &gt;&gt;</b></a>
                              <br>
                              ";
			}
			print $this->ProcessContent($display_config);
		} else {
			$msg = "Your search inputs results in an empty query,<br> therefore no search is performed. <br> ".
			       "Please return to the <i>Advanced Search</i> box and configure your search.";
			print $this->MessageBox("SEARCH STRING IS EMPTY","$msg",
				"<a href=# onClick=window.open('?act=advsearch','_self');>return to the <b>Advanced Search</b></a>");
		}

	} elseif ($act == "edit") {
		if ($disableedit == false) {
		        if ($displayoutput == false) {
			   print $this->ProcessForm($form_config);
          		} else {
          		   $this->ProcessForm($form_config);
          		}
		} else {
			print $this->MessageBox("WARNING","EDIT OPERATION IS NOT ALLOWED");
		}
	} elseif ($act == "add") {
		if ($disableadd == false) {
		        if ($displayoutput == false) {
			   print $this->ProcessForm($form_config);
          		} else {
          		   $this->ProcessForm($form_config);
          		}
		} else {
			print $this->MessageBox("WARNING","ADD OPERATION IS NOT ALLOWED");
		}
	} elseif ($act == "view") {
                if ($disableview == false) {
		    if ($displayoutput == false) {
                        print $this->ProcessView($form_config);
                    } else {
                        $this->ProcessView($form_config);
                    }
                } else {
	            print $this->MessageBox("WARNING","VIEW OPERATION IS NOT ALLOWED");
                }
	} elseif ($act == "advsearch") {
		$this->ProcessAdvSearch($form_config);
	} elseif ($act == "saveadd") {
		$this->ProcessAddEdit($form_config,"saveadd");
	} elseif ($act == "saveedit") {
		$this->ProcessAddEdit($form_config,"saveedit");
	} elseif ($act == "delete") {
		if ($disabledelete == false) {
			$this->ProcessDelete($form_config,"delete",$database);
		} else {
			print $this->MessageBox("WARNING","DELETE OPERATION IS NOT ALLOWED");
		}
	} elseif ($act == "deleteconfirm") {
		if ($disabledelete == false) {			
			$this->ProcessDelete($form_config,"deleteconfirm",$database);
		} else {
			print $this->MessageBox("WARNING","DELETE OPERATION IS NOT ALLOWED");	
		}
	}
} //ProcessAdmin()


function BuildSearchSQL($arfields,$table,$method="get",$boolcond="or",$column_shown=array()) {
	$searchclause = array();
	$searchstr	  = "";
	$searchcond	  = "";
	$searchinfo	  = "";

	while(list($name,$value) = each($arfields)) {
		if (substr($name,0,5) == "sfld_") {
			$fieldname 	= $value;

			if (ereg(".", $fieldname)) $fieldsearch = str_replace(".", "_", $fieldname);
			else $fieldsearch = $fieldname;

			$fieldvalue 	= $this->_GetSetting($arfields["$fieldsearch"],"");
			$fieldbool	= $this->_GetSetting($arfields["bool_$fieldsearch"],"");

			//echo $fieldname." | ".$fieldvalue." | ".$fieldbool."<br>";

			if ($fieldbool == "between") {
				$start 	= $this->GetVarDate("drstart_$fieldname");
				$end 	= $this->GetVarDate("drend_$fieldname");
				if (($this->ValidDate($start) == true) && ($this->ValidDate($end) == true)) {
					$fieldvalue = "$fieldname between '$start' and '$end'";
					$searchinfo .= "$fieldname is between $start and $end <br>";
				} elseif (($this->ValidDate($start) == true) && ($this->ValidDate($end) == false)) {
					$fieldvalue = "$fieldname >= '$start' and $fieldname <= '$start 23:59:59'";
					$searchinfo .= "$fieldname is on $start<br>";
				} else {
					$fieldvalue = "";
				}
			} elseif ($fieldbool == "yearbetween") {
				$start	= $this->GetVar("yrstart_$fieldname","");
				$end	= $this->GetVar("yrend_$fieldname","");
				if (($start != "") && ($end != "")) {
					$fieldvalue = "$fieldname >= $start and $fieldname <= $end";
					$searchinfo .= "$fieldname is between $start and $end <br>";
				} elseif (($start != "") && ($end == "")) {
					$fieldvalue = "$fieldname = $start";
					$searchinfo .= "$fieldname is on $start<br>";
				} else {
					$fieldvalue = "";
				}
			} elseif ($fieldbool == "either") {
				global $QUERY_STRING;
				$fieldvalue = "'".str_replace("|","','",$this->_GetSelection($QUERY_STRING,$fieldname,$method))."'";
				if ($fieldvalue == "''") {
					$fieldvalue = "";
				}
				$searchinfo .= "$fieldname is in the following $fieldvalue <br>";
			} elseif ($fieldbool == "all") {
				global $QUERY_STRING;
				$fieldvalue = "'".str_replace("|","','",$this->_GetSelection($QUERY_STRING,$fieldname,$method))."'";
				if ($fieldvalue == "''") {
					$fieldvalue = "";
				}
				$searchinfo .= "$fieldname is in the following $fieldvalue <br>";
			}

			if ($fieldvalue != "") {
				if ($fieldbool == "like") {
					$searchcond = "($fieldname like '%$fieldvalue%')";
					$searchinfo .= "$fieldname contains '$fieldvalue' <br>";
				} elseif ($fieldbool == "begin") {
					$searchcond = "($fieldname like '$fieldvalue%')";
					$searchinfo .= "$fieldname begins with '$fieldvalue' <br>";
				} elseif ($fieldbool == "end") {
					$searchcond = "($fieldname like '%$fieldvalue')";
					$searchinfo .= "$fieldname ends with '$fieldvalue' <br>";
				} elseif ($fieldbool == "eq") {
					$searchcond = "($fieldname = '$fieldvalue')";
					$searchinfo .= "$fieldname is '$fieldvalue' <br>";
				} elseif ($fieldbool == "between") {
					$searchcond = "($fieldvalue)";
				} elseif ($fieldbool == "yearbetween") {
					$searchcond = "($fieldvalue)";
				} elseif ($fieldbool == "either") {
					$search_split = explode("|", $this->_GetSelection($QUERY_STRING,$fieldname,$method));
					unset($searchcond);
					foreach ($search_split as $key=>$val) {

						$searchcond .= "$fieldname like '%$val%' or ";

					}
					$searchcond = substr($searchcond,0,-4);
					$searchcond = "($searchcond)";
				} elseif ($fieldbool == "all") {
					$search_split = explode("|", $this->_GetSelection($QUERY_STRING,$fieldname,$method));
					foreach ($search_split as $key=>$val) {

						$searchcond .= "$fieldname like '%$val%' and ";

					}
					$searchcond = substr($searchcond,0,-4);
					$searchcond = "($searchcond)";
				}
				array_push($searchclause,$searchcond);
			}
		} //not sfld
	} //while
	$searchstring = join(" $boolcond ",$searchclause);
	if ($searchstring == "") {
		return array("","");
	} else {
		if ($column_shown) {
			foreach ($column_shown as $key=>$val) {
				//echo $key." | ".$val."<br>";
				$columns .= $val.", ";
			}
		}
		$columns = substr($columns,0,-2);

		if (strlen($columns)<1) $columns = "*";

		$searchsql = "select $columns from $table where $searchstring";
		return array($searchsql,$searchinfo);
	}
} //BuildSearchSQL()


function ValidDate($date) {
        if (eregi("-",$date)) {
	   $elmnt = split("-",$date);
	   $year  = $this->_GetSetting($elmnt[0],0);
	   $month = $this->_GetSetting($elmnt[1],0);
	   $day	  = $this->_GetSetting($elmnt[2],0);
        } else {
           $elmnt  = split("/",$date);
	   $year  = $this->_GetSetting($elmnt[2],0);
	   $month = $this->_GetSetting($elmnt[0],0);
	   $day	  = $this->_GetSetting($elmnt[1],0);
        }

	$cdate	= mktime (0,0,0,$month,$day,$year);
	if (checkdate(intval($month),intval($day),intval($year))== true) {
		return true;
	} else {
		return false;
	};
} //ValidDate()


function ProcessAdvSearch($config) {
	// Get the setting values ...
	$table		= $config["table"];
	$method		= "get";
	$searchfields	= $this->_GetSetting($config["searchfields"],"");
	if ($searchfields	== "") {
                $fields = array_keys($config["fields"]);
		$searchfields	= $fields; //$this->_GetSetting($config["fields"],array());
		if (count($searchfields) == 0) {
			$tmpfields = $this->GetFields("select * from $table limit 0, 1");
			for ($f = 0; $f < count($tmpfields); $f++) {
				$fieldname = $tmpfields[$f];
				$searchfields[$fieldname] = array();
			}
		}
	}
	//print_r($searchfields);
	$numfields	= count($searchfields);

	while (list($name,$value) = each($searchfields)) {

		$fieldname 	= $name;
		$type		= $this->_GetSetting(($value["type"]),"text");
		// searchfield needs no validation, empty string means field is not part of search criteria

		unset($searchfields[$fieldname]["validate"]);
		if (eregi("advtext|show",$type)) {
			$searchfields[$fieldname]["type"] = "text";
		} elseif (eregi("upload|file",$type)) {
			unset($searchfields[$fieldname]);
		} elseif (eregi("radio",$type)) {
			$searchfields[$fieldname]["type"] = "multiselect";
		} elseif (eregi("date",$type)) {
			$searchfields[$fieldname]["type"] = "daterange";
		} elseif (eregi("yearselect",$type)) {
			$searchfields[$fieldname]["type"] = "yearrange";
		}
	}

	// Overwrite the values back to the config
	$config["fields"] 	= $searchfields;
	$config["xtblattrib"] 	= "cellpadding=4 cellspacing=0 width=70% align=center";
	$config["savecaption"]	= " Search ";
	$config["method"]	= "get";
	$this->ProcessForm($config);
} //ProcessAdvSearch()


function ProcessView($config) {
	$this->ProcessForm($config);
} //ProcessView()


function _GetSetting(&$configstring,$default="") {
	if (isset($configstring)) {
		$setting = $configstring;
	} else {
		$setting = $default;
	}
	return $setting;
} //_GetSetting


function _GetConfig(&$config,$key,$default="") {
	global $GS;
	if (isset($config[$key])) {
		$setting = $config[$key];
	} else {
		$setting = "";
	}
	if ($setting == "") {
		$setting = $this->_GetGS($key,$default);
	}
	return $setting;
} //_GetConfig()


function _GetGS($key,$default="") {
	global $GS;

	if (isset($GS[$key])) {
		$setting = $GS[$key];
	} else {
		$setting = $default;
	}
	return $setting;
} //_GetGS()

function IsIE6() {
         global $HTTP_USER_AGENT;
         if (eregi("MSIE 6",$HTTP_USER_AGENT)) {
            if (eregi("Opera",$HTTP_USER_AGENT)) {
                return false;
            } else {
                return true;
            }
         } else {
            return false;
         }
} //IsIE6()

function ProcessForm($config) {
	global $PHP_SELF, $GS, $act;
	$keyvarname     = $this->_GetSetting($config["keyvarname"],"keyid");
	$keyid		= $this->GetVar($keyvarname);
	$keyid2		= $this->GetVar("keyid2");
	$safekey	= $this->GetVar("safekey");
	$action		= $this->GetVar("act");
	$nocancel       = $this->GetVar("nocancel",0);
	$anyspaw        = false;
	$content	= "";
	$act		= (!isset($config["act"])) ? ""	: $config["act"];

	if ($act != "") {
		$action = $act;
	}

	$referrer		= $this->GetVar("referrer","act=show");

	//print $referrer;print "<br>";

	//as of v695, act=showresult is added so that an editing done from showresult will return to the result page

	if (eregi("bool_|boolcond=",$referrer)) {
		$referrer = $referrer."&act=showresult";
	}
	//print $referrer;

	//by default the form is not an upload form
	$uploadform 		= false;
	$enctype		= "";
	$database		= $this->_GetSetting($config["database"],"");
	$tablewrap 		= $this->_GetSetting($config["tablewrap"],true);
	$primarykey		= $this->_GetSetting($config["primarykey"],"");
	$primarykey2	        = $this->_GetSetting($config["primarykey2"],"");
	$keycreation	        = $this->_GetSetting($config["keycreation"],"none");
	$fields		        = $this->_GetSetting($config["fields"],array());
	$opentag		= $this->_GetSetting($config["opentag"],"");
	$closetag		= $this->_GetSetting($config["closetag"],"");
	$formname		= $this->_GetSetting($config["formname"],$this->formname);
	$formlayout		= $this->_GetSetting($config["formlayout"],"");
	$method		        = $this->_GetSetting($config["method"],"post");
	$safe			= $this->_GetSetting($config["safe"],false);
	$table		        = $this->_GetSetting($config["table"],"");
	$title		        = $this->_GetSetting($config["title"],$this->FormatLabel($table));
	$subtitle		= $this->_GetSetting($config["subtitle"],"");
	$edittitle		= $this->_GetSetting($config["edittitle"],"Edit Record");
	$newtitle		= $this->_GetSetting($config["newtitle"],"New Record");
	$viewtitle		= $this->_GetSetting($config["viewtitle"],"Record View");
	$advsearchtitle	        = $this->_GetSetting($config["advsearchtitle"],"Advanced Search");
	$tblattrib		= $this->_GetSetting($config["tblattrib"],"");
	$logaction		= $this->_GetSetting($config["logaction"],$this->logaction);
	$allfields		= $this->_GetSetting($config["allfields"],false);
	$showresetbutton        = $this->_GetSetting($config["showresetbutton"],true);
        $showcancelbutton	= $this->_GetSetting($config["showcancelbutton"],true);
	$showclosebutton	= $this->_GetSetting($config["showclosebutton"],false);
	$canceladdress	        = $this->_GetSetting($config["canceladdress"],"");
	$displayoutput		= $this->_GetSetting($config["displayoutput"],true);
	$morebuttons            = $this->_GetSetting($config["morebuttons"],"");
	$saveimage		= $this->_GetSetting($config["saveimage"],"");
	$resetimage		= $this->_GetSetting($config["resetimage"],"");
	$cancelimage		= $this->_GetSetting($config["cancelimage"],"");
	$closeimage		= $this->_GetSetting($config["closeimage"],"");
	$transparent		= $this->_GetSetting($config["transparent"],false);
	$useseparator	        = $this->_GetSetting($config["useseparator"],true);
	$disablejs              = $this->_GetSetting($config["disablejs"],false);
        $formdesign             = $this->_GetSetting($config["formdesign"],"");
        $novalidation           = $this->_GetSetting($config["novalidation"],false);
        $viewprocess            = $this->_GetSetting($config["viewprocess"],"");
        $picturetable           = $this->_GetSetting($config["picturetable"],$this->tbl_picture);

	$header		        = $this->_GetConfig($config,"header","");
	$savecaption	        = $this->_GetConfig($config,"savecaption","Save");
	$resetcaption	        = $this->_GetConfig($config,"resetcaption","Reset");
	$cancelcaption	        = $this->_GetConfig($config,"cancelcaption","Cancel");
	$separator		= $this->_GetConfig($config,"separator","");

	$clr_form		= $this->_GetSetting($config["clr_form"],$this->clr_form);
	$clr_formhead	        = $this->_GetSetting($config["clr_formhead"],$this->clr_formhead);
	$clr_formheadtext	= $this->_GetSetting($config["clr_formheadtext"],$this->clr_formheadtext);
	$clr_formsubhead	= $this->_GetSetting($config["clr_formsubhead"],$this->clr_formsubhead);
	$clr_formsubtext	= $this->_GetSetting($config["clr_formsubtext"],$this->clr_formsubtext);
	$clr_formcolumn1	= $this->_GetSetting($config["clr_formcolumn1"],$this->clr_formcolumn1);
	$clr_formcolumn2	= $this->_GetSetting($config["clr_formcolumn2"],$this->clr_formcolumn2);
	$clr_columntext1	= $this->_GetSetting($config["clr_columntext1"],$this->clr_columntext1);
	$clr_columntext2	= $this->_GetSetting($config["clr_columntext2"],$this->clr_columntext2);
	$clr_button		= $this->_GetSetting($config["clr_button"],$this->clr_button);
	$clr_buttontext		= $this->_GetSetting($config["clr_buttontext"],$this->clr_buttontext);
	$showpreloader          = $this->_GetSetting($config["showpreloader"],false);
        $tableclass             = $this->_GetSetting($config["tableclass"],"cms_table");
        $btn_class              = $this->_GetSetting($config["btn_class"],"cms_button");
        $tdtitleclass           = $this->_GetSetting($config["titleclass"],"cms_title");
        $tdsubtitleclass        = $this->_GetSetting($config["subtitleclass"],"cms_subtitle");
        $columnclass1           = $this->_GetSetting($config["columnclass1"],"cms_column1");
        $columnclass2           = $this->_GetSetting($config["columnclass2"],"cms_column2");
        $buttonrowclass         = $this->_GetSetting($config["buttonrowclass"],"cms_buttonrow");
        $buttonrowlayout        = $this->_GetSetting($config["buttonrowlayout"],"");
        $onsubmitcaption        = $this->_GetSetting($config["onsubmitcaption"],"");
	$confirmmessage		= $this->_GetSetting($config["confirmmessage"],"");

	$boxwrapper		= $this->_GetConfig($config,"boxwrapper","");
	$titlelayout		= $this->_GetConfig($config,"titlelayout","");
	$subtitlelayout		= $this->_GetConfig($config,"subtitlelayout","");
	$destination		= $this->_GetConfig($config,"destination",$PHP_SELF);


        $inputholder            = array();
        $valueholder            = array();

	$this->disablejs	= $disablejs;
	$this->formname		= $formname;
	$this->confirmmessage	= $confirmmessage;
	$showcancelbutton       = ($nocancel == 1) ? false : $showcancelbutton;

        //if ($showpreloader == true) {
        //   $this->ShowPreloader();
        //}

	if ($useseparator == false) $separator = "";

	//this resets all color attributs in order to make the table transparent
	if ($transparent == true) {
	   $blank = "\"\"";
	   $clr_formsubhead = $blank; $clr_formhead = $blank; $clr_form = $blank;
	   $clr_formcolumn1 = $blank; $clr_formcolumn2 = $blank;
	   $separator = "";
	   //$formlayout = "<tr><td>%%INPUTLABEL%%</td><td>%%INPUT%%</td></tr>";
	}

	//if ($useseparator == false) $separator = "";

	if ($formlayout != "") {
		$inputlayout	= $formlayout;
	} else {
		if (!isset($GS["formlayout"])) {
			$inputlayout = "
					<tr><td width=200 bgcolor=$clr_formcolumn1 class=\"%%COLUMNCLASS1%%\"><font color=$clr_columntext1>%%INPUTLABEL%%</font></td>
					<td bgcolor=$clr_formcolumn2 class=\"%%COLUMNCLASS2%%\"><font color=$clr_columntext2>%%INPUT%%</font></td></tr>";
		} else {
			$inputlayout = $GS["formlayout"];
		}
	}

	$arfind = array("|%%CLR_FORMCOLUMN1%%|","|%%CLR_FORMCOLUMN2%%|","|%%CLR_COLUMNTEXT1%%|","|%%CLR_COLUMNTEXT2%%|");
	$inputlayout = preg_replace($arfind,array($clr_formcolumn1,$clr_formcolumn2,$clr_columntext1,$clr_columntext2),$inputlayout);

	if ($subtitle == "") {
	if ($action == "add") {
		$subtitle = $newtitle;
	} elseif ($action == "edit") {
		$subtitle = $edittitle;
	} elseif ($action == "view") {
		$subtitle = $viewtitle;
	} elseif ($action == "advsearch") {
		$subtitle = $advsearchtitle;
	} else {
		$subtitle = $subtitle;
	}
	}

	if ($table == "") {
		print $this->MessageBox("CONFIGURATION ERROR","Database table must be specified"); exit;
	}

	$arrfields = array();

	if ($allfields == true) {
		$tmpfields = $this->GetFields("select * from $table",$database);
		foreach($tmpfields as $fieldname) {
			$arrfields[$fieldname] = array();
		}
	}

	if ($table != "_none_") {
	$fieldcount = count($fields);
	if ($fieldcount == 0) {

		$c = 0;
		$tmpfields = $this->GetFieldsInfo("select * from $table",$database);
		while (list($fieldname,$fieldtype) = each($tmpfields)) {

			//if primarykey is not specified, usually the first field is the primary key
			if ($primarykey == "") {
				if ($c == 0) {
					$primarykey = $fieldname;
				}
			}
			if ($fieldname == $primarykey) {
				$fields[$fieldname] = array("type"=>"show");
			} else {
				$array = array();
				$fields[$fieldname] = array("type"=>$fieldtype); //array($fieldname,$array);
			}
			$c++;
		}
	} else {
		if ($primarykey == "") {
			$tmpfields = $this->GetFields("select * from $table");
			$primarykey = $tmpfields[0];
		}
	}
	}//if table _none_

	//if no array is attached to each element of the field array then attach an array
	if ($this->IsAssocArray($fields) == 'value_value') {
		$numfields = count($fields);
		$tmpfields = array_values($fields);
		$fields = array();
		for($i = 0; $i < $numfields; $i++) {
			$fieldname = $tmpfields[$i];
			$fields[$fieldname] = array();
		}
	} else {
		$tmpfields = $fields;

		$fields = array();
		while (list($fieldname,$value) = each($tmpfields)) {
			if (is_numeric($fieldname)) {
				$fields[$value] = array();
			} else {
				if (isset($value["type"])) {
					if (($value["type"] == "upload") || ($value["type"] == "file")) {
						$uploadform = true;
						$value["dbfield"] = false;
						$method = "post";
						$enctype = "enctype=\"multipart/form-data\"";
					} elseif ($value["type"] == "spaw") {
                                                $anyspaw = true;
                                                //if this is view mode no need to activate SPAW include
                                                if ($action == "view") $anyspaw = false;
                                        }
				}
				$fields[$fieldname] = $value;
			}
		}
	}

	$tmpfields = array_merge($arrfields,$fields);
	$fields = $tmpfields;

	if (($safe == true) && ($action == "edit")) {

	$serverkey	= md5($this->safekey.$keyid);
	if ($serverkey != $safekey) {
		print $this->MessageBox("INVALID ACCESS","You are not authorized to view this page");
		exit;
	}
	}

        if ($disablejs == false) {
           if ($novalidation == false) {
           //TODO:
           //IF NOT IE 6 THEN DO NOT SUPPORT SPAW
           //
           if ($this->IsIE6() == false) $anyspaw = false;

	   $this->GenerateValidation($fields,$method,$anyspaw);
           } else {
           $this->GenerateSubmit();
           }
        } else {
           $this->GenerateSubmit();         
	}                

	if (($action == "edit") || ($action == "view")) {
		if ($primarykey == "") {
			$content .= "[primarykey must be specified]";
			exit;
		}
		//$fieldlist	= $this->GetDbFields($fields);

		//as of 735, rather than relying on user config to determine whether
		//a field is a dbfield or not, just do the field list

                $fieldlist      = join(",",$this->GetFields("select * from $table",$database));

		if ($primarykey2 != "") {
			$additionalkey = " and $primarykey2='$keyid2' ";
		} else {
			$additionalkey = "";
		}
		$sql = "select $fieldlist from $table where $primarykey='$keyid' $additionalkey";

		if (!isset($keyid) || ($keyid == "")) {
			$content .= "<hr>Invalid sql statement set. probably some keyid is missing. <br><hr>";
			print $content;
			exit;
		}
		$values = $this->GetArrayValues($sql,split(",",$fieldlist),$database);

		if ($viewprocess != "") {
		     $values = call_user_func($viewprocess,$values);
                }

                if ($values[$primarykey] != $keyid) {
		    print $this->MessageBox("INVALID EDIT OPERATION","PRIMARYKEY $primarykey $keyid NOT FOUND.");
		    exit;
		};
	} else {
		$values	= array();
	}

	//if no table attributes set, use a default attribute;
	if ($tblattrib == "") {
		$tblattrib = " cellpadding=5 cellspacing=0 border=0 width=100% ";
	}

	//position the pointer to the first element of the array again
	reset($fields);

	if ($titlelayout == "")    $titlelayout    = "<tr bgcolor=$clr_formhead><td colspan=2 class=\"$tdtitleclass\"><font color=$clr_formheadtext><span id=title><b>$title</b></span></font></td></tr>";
        //if ($subtitlelayout == "") $subtitlelayout = "<tr><td bgcolor=$clr_formsubhead>&nbsp;</td><td bgcolor=$clr_formsubhead><font color=$clr_formsubtext><b>$subtitle</b></font></td></tr>";
	if ($subtitlelayout == "") $subtitlelayout = "<tr><td colspan=2 class=\"$tdsubtitleclass\" bgcolor=$clr_formsubhead><font color=$clr_formsubtext><b>$subtitle</b></font></td></tr>";

        $openformtag = "<form name=$formname action=\"$destination\" $enctype method=$method>";

        array_push($inputholder,"|%%OPENFORM%%|");
        array_push($valueholder,$openformtag);
        array_push($inputholder,"|%%CLOSEFORM%%|");
        array_push($valueholder,"</form>");

	if ($tablewrap == true) {
	//if no boxwrapper is specified, add header to content, but if it is spesified,
	//add header later so that it is not boxwrapped along with the content
	if ($boxwrapper == "") $content .= $header;

	$content .= "\n\n
		$opentag \n
		<div id=\"$formname\"><table $tblattrib class=\"$tableclass\" bgcolor=$clr_form>
		$openformtag\n
		$titlelayout
		$subtitlelayout
		";
	} else {
		$content .= "$opentag";
	}

        $arrSPAW_fields = array();
        $arrSPAW_values = array();
        $arrSPAW_styles = array();
        $arrSPAW_width  = array();
        $arrSPAW_height = array();

	while (list($fieldname,$key) = each($fields)) {
		$type		= $this->_GetSetting($fields[$fieldname]["type"],"text");

                if ($type == "spaw") {
                   if ($this->enablespaw == false) $type = "textarea";
                }

		$label		     = $this->_GetSetting($fields[$fieldname]["label"],$this->FormatLabel($fieldname));
		$width		     = $this->_GetSetting($fields[$fieldname]["width"],80);
		$rowhead	     = $this->_GetSetting($fields[$fieldname]["rowhead"],"");
		$rowlayout	     = $this->_GetSetting($fields[$fieldname]["rowlayout"],"");
		$selection	     = $this->_GetSetting($fields[$fieldname]["selection"],array());
		$selected	     = $this->_GetSetting($fields[$fieldname]["selected"],array(""));
		$valuepair	     = $this->_GetSetting($fields[$fieldname]["valuepair"],"");
		$validate	     = $this->_GetSetting($fields[$fieldname]["validate"],"");
		$dbfield	     = $this->_GetSetting($fields[$fieldname]["dbfield"],true);
		$default	     = $this->_GetSetting($fields[$fieldname]["default"],"");
		$readonly	     = $this->_GetSetting($fields[$fieldname]["readonly"],false);
		$range		     = $this->_GetSetting($fields[$fieldname]["range"],array());
		$viewformat	     = $this->_GetSetting($fields[$fieldname]["viewformat"],"");
		$height		     = $this->_GetSetting($fields[$fieldname]["height"],(($type=="textarea" || $type=="advtextarea" || $type=="multiselect")? 5: 1));
		$trcolor	     = $this->_GetSetting($fields[$fieldname]["trcolor"],$clr_form);
		$tdcolor1	     = $this->_GetSetting($fields[$fieldname]["tdcolor1"],$clr_formcolumn1);
		$tdcolor2	     = $this->_GetSetting($fields[$fieldname]["tdcolor2"],$clr_formcolumn2);
		$imgpath	     = $this->_GetSetting($fields[$fieldname]["imgpath"],$this->imgpath);
		$optionbr	     = $this->_GetSetting($fields[$fieldname]["optionbr"],true);
		$warning	     = $this->_GetSetting($fields[$fieldname]["warning"],"");
		$showthumbnail	     = $this->_GetSetting($fields[$fieldname]["showthumbnail"],true);//as of 734 default to true
		$specific	     = $this->_GetSetting($fields[$fieldname]["specific"],false);
		$onepiconly	     = $this->_GetSetting($fields[$fieldname]["onepiconly"],0);
		$onefileonly	     = $this->_GetSetting($fields[$fieldname]["onefileonly"],0);
		$showpicdescription  = $this->_GetSetting($fields[$fieldname]["showpicdescription"],true);
		$layout		     = $this->_GetSetting($fields[$fieldname]["layout"],"auto");
		$showrow	     = $this->_GetSetting($fields[$fieldname]["showrow"],true);
		$inputheader         = $this->_GetSetting($fields[$fieldname]["inputheader"],"");
		$inputcaption        = $this->_GetSetting($fields[$fieldname]["inputcaption"],"");
                $noinfo              = $this->_GetSetting($fields[$fieldname]["noinfo"],false);
		$exceptionfields     = $this->_GetSetting($fields[$fieldname]["exceptionfields"],array());
                $customvalue         = $this->_GetSetting($fields[$fieldname]["customvalue"],"");
                $descriptionstyle    = $this->_GetSetting($fields[$fieldname]["descriptionstyle"],$this->descriptionstyle);
                $previewbutton       = $this->_GetSetting($fields[$fieldname]["previewbutton"],true);
                $titlewidth          = $this->_GetSetting($fields[$fieldname]["titlewidth"],"80 style='width:100%;'");
                $descriptionbutton   = $this->_GetSetting($fields[$fieldname]["descriptionbutton"],true);
                $descriptionwidth    = $this->_GetSetting($fields[$fieldname]["descriptionwidth"],"50");
                $descriptionheight   = $this->_GetSetting($fields[$fieldname]["descriptionheight"],"3");
                $createthumbnail     = $this->_GetSetting($fields[$fieldname]["createthumbnail"],true);
                $optionexpanded      = $this->_GetSetting($fields[$fieldname]["optionexpanded"],false);
                $descriptionexpanded = $this->_GetSetting($fields[$fieldname]["descriptionexpanded"],false);
                $tdclass1            = $this->_GetSetting($fields[$fieldname]["columnclass1"],"");
                $tdclass2            = $this->_GetSetting($fields[$fieldname]["columnclass2"],"");
                $customjs            = $this->_GetSetting($fields[$fieldname]["customjs"],"");

		$readonly	    = ($readonly == true) ? " disabled " : "";
                $valuepair          = ($valuepair == "")  ? $this->IsAssocArray($selection) : $valuepair;
                $tdclass1           = ($tdclass1 == "")   ? $columnclass1 : $tdclass1;
                $tdclass2           = ($tdclass2 == "")   ? $columnclass2 : $tdclass2;

		if ($action == "view") {
			if ($type == "upload") {
			$showpicture = $this->_GetSetting($fields[$fieldname]["showpicture"],"from_db");
			if ($showpicture == "from_db") {
			   $type = "uploadview";
			   } else {
                           $type = "relatedpicture";
                           }
			} elseif ($type == "select" ||
                                  $type == "radio") {
				  $type = "selectview";
			} elseif ($type == "file") {
                                  $type = "relatedfile";
                        } elseif ($type == "spaw") {
                                  $type = "show";
			} else {  $type = "show";
			}
		}

		if ($dbfield == true) {
			if (!isset($values[$fieldname])) {
				if (($action == "add") || ($action != "edit")) {
				   if ($default != "") {
				      $fieldvalue = $default;
				   } else {
				      $fieldvalue = "";
				   }
				} else {
				   $fieldvalue = "";
				}
			} else {
			   $fieldvalue = $this->FieldFormat($values[$fieldname],$viewformat);
			}			
		} else {
			$fieldvalue = "";
		}

		//if customvalue is set then use customvalue to overwrite all values

                if ($customvalue != "") {
                   if ($action == "edit" ) $fieldvalue = $customvalue;
                }

		if ($type == "select") {
			$input	= $this->PrintSelect($selection,$fieldvalue,$fieldname,$valuepair,$height,false,$customjs);
		} elseif ($type == "selectview") {
                        $input = (isset($selection[$fieldvalue])) ? $selection[$fieldvalue] : $fieldvalue;
		} elseif ($type == "multiselect") {
			$selected= split("\|",$fieldvalue);
			$input	= $this->PrintSearchSelect($selection,$selected,$fieldname,$valuepair,$height,true);
		} elseif ($type == "dateselect") {
			$input	= $this->PrintTimeSelect($fieldvalue,false,$fieldname,$range);
		} elseif ($type == "datetimeselect") {
			$input	= $this->PrintTimeSelect($fieldvalue,true,$fieldname,$range);
		} elseif ($type == "yearselect") {
			$years 	= $this->arYears($range);
			$input	= $this->PrintSelect($years,$fieldvalue,$fieldname,'value_value');
		} elseif ($type == "monthyearselect") {
			$input	= $this->PrintMonthYearSelect($fieldvalue,false,$fieldname,$range);
		} elseif ($type == "yearrange") {
			$years 	= $this->arYears($range);
			$yrstart= $this->PrintSelect($years,$fieldvalue,"yrstart_$fieldname",'value_value');
			$yrend	= $this->PrintSelect($years,$fieldvalue,"yrend_$fieldname",'value_value');
			$input	= "$yrstart to $yrend";
		} elseif ($type == "checkboxes" || $type == "checkbox") {
			$selected= split("\|",$fieldvalue);
			$input	= $this->GetCheckboxes($selection,$selected,$fieldname,$method,$layout,$clr_columntext2,$valuepair);
		} elseif ($type == "radio") {
			$input	= $this->RadioSelect($selection,$fieldvalue,$fieldname,$valuepair,$method,$layout,$clr_columntext2);
		} elseif ($type == "hidden") {
			$input	= "<input type=hidden name=$fieldname value=\"$fieldvalue\">";
		} elseif ($type == "show") {
			$input	= $fieldvalue ."<input type=hidden name=$fieldname value=\"".htmlentities($fieldvalue)."\">";
		} elseif ($type == "datetime_autoupdate" || $type == "timestamp_autoupdate") {
			$input	= "<input type=hidden name=$fieldname value=\"datetime_autoupdate\">$fieldvalue";
  		} elseif ($type == "datetime_creation" || $type == "timestamp_creation") {
  		        $input  = "<input type=hidden name=$fieldname value=\"datetime_creation\">$fieldvalue";
		} elseif ($type == "daterange") {
			$drstart= $this->PrintTimeSelect("",false,"drstart_".$fieldname,$range);
			$drend	= $this->PrintTimeSelect("",false,"drend_".$fieldname,$range);
			$input	= "$drstart to $drend";
		} elseif ($type == "search_condition") {
			$input	= "<input type=hidden name=$fieldname value=\"datetime_autoupdate\">$fieldvalue";
		} elseif ($type == "autonumber") {
			$input	= "$fieldvalue";
		} elseif ($type == "advtextarea") {
			$convertbr	= ($optionbr == false) ? "" : "checked";
	     		$fieldvalue   	= $this->ProcessBR($fieldvalue,"edit");
			$tableheight  	= ceil($height * 20);
			$previewheight	= $tableheight+95;
			$tablewidth	= ceil($width * 10);
			//$btnstyle	= "disabled class=button ";
			$advconfig      = array("customjs"=>$customjs,"convertbr"=>$convertbr,"tableheight"=>$tableheight,"previewheight"=>$previewheight,"tablewidth"=>$tablewidth);
			$input          = $this->GetAdvtextarea($fieldname,$fieldvalue,$advconfig);
                } elseif ($type == "spaw") {
                        if ($width  == 80)$width  = ($layout != "mini") ? "100%"  : "350px";
                        if ($height < 20) $height = ($layout != "mini") ? "200px" : "100px";
                        array_push($arrSPAW_fields,$fieldname);
                        array_push($arrSPAW_values,$fieldvalue);
                        array_push($arrSPAW_styles,$layout);
                        array_push($arrSPAW_height,$height);
                        array_push($arrSPAW_width,$width);
                        $input = "%%SPAW_LOCATION%%";//$this->GetSPAW($fieldname,$fieldvalue);
		} elseif ($type == "textarea") {
		        $width  = (eregi("%",$width)) ? (intval($width) / 1.25) : $width;
			$height = (eregi("px",$height)) ? (intval($height) / 10) : $height;
                        $fieldvalue = htmlentities($fieldvalue);
                        $input 	= "<textarea name=$fieldname cols=\"$width\" rows=\"$height\" $customjs>$fieldvalue</textarea>\n";
		} elseif ($type == "password") {
			$input	= "<input name=$fieldname type=password size=$width value=\"$fieldvalue\">\n";
		} elseif ($type == "upload") {
		        $extra_config = array(
                        "showpicdescription"  => $showpicdescription,
                        "descriptionstyle"    => $descriptionstyle,
                        "previewbutton"       => $previewbutton,
                        "descriptionbutton"   => $descriptionbutton,
                        "createthumbnail"     => $createthumbnail,
	                "exceptionfields"     => $exceptionfields,
                        "optionexpanded"      => $optionexpanded,
			"descriptionexpanded" => $descriptionexpanded,
			"titlewidth"          => $titlewidth,
			"descriptionwidth"    => $descriptionwidth,
			"descriptionheight"   => $descriptionheight,
			"picturetable"        => $picturetable
                        );
			$input	= $this->UploadBox($fieldname,$fields[$fieldname],$values,$primarykey,$table,$keyid,$database,$extra_config);
		} elseif ($type == "uploadview") {
                        if ($noinfo == false) {
    			   $addedcond = ($keyid2 != "") ? " and keyid2='$keyid' " : "";
    			   if ($specific == true) {
    				$sqlstr = "select * from $picturetable where tablename='$table' and fieldname='$fieldname' and keyid='$keyid' $addedcond";
    			   } else {
    				$sqlstr	= "select * from $picturetable where tablename='$table' and keyid='$keyid' $addedcond";
    			   }
    			   $input	= $this->_GetPicturesInDb($sqlstr,$showthumbnail,true,$onepiconly,array("picturetable"=>$picturetable),$database);
                        } else {
                           $input = "";
                           $showrow = false;
                        }
		} elseif ($type == "relatedpicture") {
			$input	= $this->_GetRelatedPicture($fields[$fieldname],$values,$keyid,$picturetable);
		} elseif ($type == "relatedfile") {
			$addedcond	= ($keyid2 != "") ? " and keyid2='$keyid' " : "";
			if ($specific == true) {
                        $sqlstr	= "select * from ".$this->tbl_uploads." where tablename='$table' and fieldname='$fieldname' and keyid='$keyid' $addedcond";
			} else {
			$sqlstr = "select * from ".$this->tbl_uploads." where tablename='$table' and keyid='$keyid' $addedcond";
                        }
                        $input	= $this->_GetFilesInDb($sqlstr,true,$onefileonly,array(),$database);
		} elseif ($type == "file") {
			$input	= $this->UploadBox2($fieldname,$fields[$fieldname],$table,$keyid,$database);
                } elseif ($type == "datepop") {
                        $d      = split("-",substr($fieldvalue,0,10));
                        $datevalue = @$d[1]."/".@$d[2]."/".@$d[0];
                        $input  = $this->CallDatePop($fieldname,$datevalue);
                } else {
			$fieldvalue	= htmlentities($fieldvalue);
			$input	= "<input name=$fieldname type=text size=$width value=\"$fieldvalue\" $readonly $customjs>\n";
		}

                $input = $inputheader . $input . $inputcaption;

                //additonal as of 760
                
                $input = str_replace("%%VALUE_$fieldname%%",$fieldvalue,$input);

		//if field is readonly then still provide its value for saving and updating
		if ($readonly == true) {
			$input 	.= "<input type=hidden name=\"$fieldname\" value=\"$fieldvalue\">";
		}

		if ($showrow == false) {
		   $rowlayout = " ";
		}

		//add separator
		//$input .= $separator;

                array_push($inputholder,"|%%INPUT_$fieldname%%|");
                array_push($valueholder,$input);

		if ($action == "advsearch") {
			if (eregi("text",$type)) {
				$comparisons 	= array("eq"=>"exactly is","like"=>"contains","begin"=>"starts with","end"=>"ends with");
			} elseif (eregi("date",$type)) {
				$comparisons 	= array("between"=>"between");
			} elseif (eregi("year",$type)) {
				$comparisons 	= array("yearbetween"=>"between");
			} elseif ($type == "multiselect") {
				$comparisons 	= array("either"=>"one of these", "all"=>"all of these");
			} else {
				$comparison = array("eq"=>"exactly is");
			}
			$booleanops 	= $this->PrintSelect($comparisons,"like","bool_$fieldname");
			$inputprefix = "
					<table cellpadding=0 cellspacing=1 align=left height=100%><tr>
					<td width=110 align=left>$booleanops&nbsp;</td>
					<td bgcolor=$clr_formcolumn1 width=1></td><td style=padding-left:8px;>";
			$input = "$inputprefix $input </td></tr><input type=hidden name=sfld_$fieldname value=$fieldname></table>&nbsp; ";
		}

		$inputlabel	= $label;
		$arfind		= array("|%%CLR_FORMCOLUMN1%%|","|%%CLR_FORMCOLUMN2%%|","|%%CLR_COLUMNTEXT1%%|","|%%CLR_COLUMNTEXT2%%|","|%%INPUTLABEL%%|","|%%INPUT%%|","|%%COLUMNCLASS1%%|","|%%COLUMNCLASS2%%|");
		$arreplace	= array($clr_formcolumn1,$clr_formcolumn2,$clr_columntext1,$clr_columntext2,$inputlabel,$input,$tdclass1,$tdclass2);

		if ($rowlayout == "") {
			if (($type != "hidden")) {
				$customlayout= preg_replace($arfind,$arreplace,$inputlayout);
				$content .= "$rowhead\n$customlayout";
			} else {
				$content .= "$rowhead\n$input\n";
			}
		} else {
			$layout   = preg_replace($arfind,$arreplace,$rowlayout);
			$content .= "$rowhead\n$layout";
		}

		//if rowlayout is defined, separator should be surpressed to avoid messing up a custom layout that may
		//span across multiple rows
		if ($rowlayout == "") {
			$content .= $separator;
		}
	}//while

        //formdesign is empty
        if ($formdesign == "") {

        $contents = split("%%SPAW_LOCATION%%",$content);
        $numcontents = count($contents) - 1;

        if ($numcontents != 0) {
        //if the form contains SPAW then blank the variable since we already have the copy of it in contents
        $content = "";
        ob_start();
        //each chunk of the contents array is enumerated except the last chunk
        for ($c = 0; $c < $numcontents; $c++) {
            $fieldname = $arrSPAW_fields[$c];
            $fieldvalue= $arrSPAW_values[$c];
            $style     = $arrSPAW_styles[$c];
            $height    = $arrSPAW_height[$c];
            $width     = $arrSPAW_width[$c];
            print $contents[$c];
            $this->GetSPAW($fieldname,$fieldvalue,$width,$height,$style);
        }
        //the last chunk of the content is printed out
        print $contents[$numcontents];
        $content = ob_get_contents();
        ob_end_clean();
        }
        }//if formdesign is empty

	//check what appropriate action is needed

	if ($action == "edit") {
		$saveedit   = (!isset($config["saveedit"])) ? "saveedit" : strtolower($config["saveedit"]);
		$nextaction = $saveedit;
	} elseif ($action == "add") {
		$saveadd	= (!isset($config["saveadd"])) ? "saveadd" : strtolower($config["saveadd"]);
		$nextaction = $saveadd;
	} elseif ($action == "advsearch") {
		$nextaction = "showresult";

	} else {
		$nextaction = $action;
	}

	//if ($tablewrap == true) {
	//$bstyle	= "style='color=$clr_buttontext;background-color:$clr_button;border-color=#000000;background-image:uri(\'/i/design/box/basic/a2.gif\')\;";

	//$back_to_referrer = "$PHP_SELF?act=show";
        if ($canceladdress == "") {
		$back_to_referrer = "$PHP_SELF?$referrer";
	} else {
		$back_to_referrer = $canceladdress;
	}

        $btn_class     = ($btn_class != "") ? $btn_class : "button2";
        $onSubmitJs    = ($onsubmitcaption != "") ? "this.value='$onsubmitcaption';" : "";


        $onClickSave   = " onClick=\"SubmitForm($formname,this,'$onsubmitcaption') ;\" ";
        $onClickReset  = " onClick=\"ResetForm($formname)\" ";
        $onClickClose  = " onClick=\"window.close()\" ";
        $onClickCancel = " onClick=\"window.open('$back_to_referrer','_self');\" ";

	if ($action != "view") {
		$btnSave	= "<input id=btn_save  class=$btn_class type=button Value=\" $savecaption \" $onClickSave >";
		$btnReset	= "<input id=btn_reset class=$btn_class type=button name=back value=\" $resetcaption \" $onClickReset >&nbsp;";
	} else {
	       	$saveimage	= ""; $resetimage = "";
		$btnSave	= ""; $btnReset = "";
	}

	if ($action == "advsearch") {
		$boolcond = $this->PrintSelect(array("AND"=>"All matches (AND)","OR"=>"Any of the fields matches (OR)"),"AND","boolcond");
		$content .=  "<tr><td align=left bgcolor=$clr_formcolumn1><font color=$clr_columntext1><br><br><b>Search Condition</b></font></td>
			<td colspan=1 align=left bgcolor=$clr_formcolumn2><br><br>$boolcond</td></tr>$separator\n";
	}

	if ($showclosebutton == true) {
		$btnClose =  "<input id=btn_close type=button class=$btn_class value=\" Close \" $onClickClose >";
	} else {
		$btnClose = "";
	}

	if ($showcancelbutton == true) {
		$btnCancel = "<input id=btn_cancel class=$btn_class type=button name=back value=\" $cancelcaption \"
				 $onClickCancel>&nbsp;\n";
	} else {
		$btnCancel = "";
	}

	//this part hacks the appearance of button save, cancel, reset and close
	if ($saveimage != "") {
	   $btnSave = "<img style='cursor:hand;' src=$saveimage $onClickSave>";
	}
	if ($resetimage != "") {
	   $btnReset = "<img style='cursor:hand;' src=$resetimage $onClickReset>";
	}
	if ($cancelimage != "") {
	   if ($showcancelbutton == true) {
	   $btnCancel = "<img style='cursor:hand;' src=$cancelimage $onClickCancel>";
    	   } else {$btnCancel = "";}
	}
	if ($closeimage != "") {
	   if ($showclosebutton == true) {
	   $btnClose = "<img style='cursor:hand;' src=$closeimage $onClickClose>";
	   } else {$btnClose = "";}
	}

        if ($showresetbutton == false) $btnReset = "";

        $calpopframe = "";
	if ($this->calframecalled == true) {
                $calpopframe = $this->CallDatePopIFrame();
        }

	$buttons = "\n
                <input type=hidden name=referrer value=\"$referrer\">\n
		<input type=hidden name=$keyvarname value=\"$keyid\">\n
		<input type=hidden name=keyid2 value=\"$keyid2\">\n
		<input type=hidden name=safekey value=\"$safekey\">\n
		<input type=hidden name=act value=\"$nextaction\">\n
		$btnCancel\n
		$btnClose\n
		$btnReset\n
		$btnSave\n
		$morebuttons
		$calpopframe
                ";

        if ($tablewrap == true) {
                if ($buttonrowlayout == "") {
                $buttonrow= "
                        <tr bgcolor=$clr_form>
        		<td colspan=2 align=center class=\"$buttonrowclass\" bgcolor=$clr_formcolumn2>\n
        		$buttons
                        <br></td></tr>$separator";
                } else {
                        $buttonrow = str_replace("%%BUTTONROW%%",$buttons,$buttonrowlayout);
                }
        	$content .= $buttonrow;
        	$content .= "</form></table></div>\n $closetag";
        	$c = 0;
	} else {
		$content .= $closetag;
		$content = str_replace("%%BUTTONROW%%",$buttons,$content);
	}

        array_push($inputholder,"|%%BUTTONROW%%|");
        array_push($valueholder,$buttons);

	if ($boxwrapper != "") {
	    $content = $header . str_replace("%%FORMLAYOUT%%",$content,$boxwrapper);
	}

        if ($formdesign != "") {
            ob_start();
            $content       = preg_replace($inputholder,$valueholder,$formdesign);
            $contents      = split("%%SPAW_LOCATION%%",$content);
            $numcontents   = count($contents)-1;
            if ($numcontents > 0) {
            $content = "";
            $formdesign = "";
            for ($c=0;$c<$numcontents;$c++) {
               $fieldname = $arrSPAW_fields[$c];
               $fieldvalue= $arrSPAW_values[$c];
               $style     = $arrSPAW_styles[$c];
               print $contents[$c];
               $this->GetSPAW($fieldname,$fieldvalue,"100%","200",$style);
            };
            print $contents[$numcontents];
            $formdesign = ob_get_contents();
            ob_end_clean();
            } else {
            $formdesign = $content;
            }
        }

	if ($displayoutput == true) {
	   if ($formdesign != "") {
	   print $this->_Tag2Values($formdesign,$values,false);
	   } else {
	   print $content;
           }
	} else {
	   if ($formdesign != "") {
	   return $this->_Tag2Values($formdesign,$values,false);
           } else {
           return $content;
           }
 	}
} //ProcessForm()

function CallDatePop($fieldname,$fieldvalue) {
         $popimg = "<a href=\"javascript:void(0)\" onclick=\"if(self.gfPop)gfPop.fPopCalendar(document.".$this->formname.".$fieldname);return false;\" HIDEFOCUS>".
                   "<img name=popcal align=absmiddle src=/components/calpop/calbtn.gif width=34 height=22 border=0 alt=\"\"></a>";
         $input  = "<input type=text name=$fieldname size=11 value=\"$fieldvalue\">$popimg";
         $this->calframecalled = true;
         return $input;
} //CallDatePop()

function CallDatePopIFrame() {
         return '<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="/components/calpop/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>';
} //CallDatePopIFrame()

function GetAdvtextarea($fieldname,$fieldvalue,$config) {

$tableheight   = $config["tableheight"];
$tablewidth    = $config["tablewidth"];
$previewheight = $config["previewheight"];
$convertbr     = $config["convertbr"];
$customjs      = $config["customjs"];
$btnstyle      = "style='border:solid 1px; margin: 1px;' class=btn_advtextarea";

$advtextarea   = "
        <div id=advtextarea_$fieldname>
        <table border=0 cellpadding=0 height=$previewheight cellspacing=0 border=0 width=$tablewidth style='background-color:transparent;'>
	<tr><td valign=top>
	<!--TABLE SOURCE-->
	<a href=#bookmark_$fieldname></a>
	<table border=0 id=$fieldname"."_tbl0 xstyle='display:block; background-color: tranparent;' height=$tableheight><tr><td>
	Source | <a href=#bookmark_$fieldname onClick=\"ShowTable('$fieldname',1,2);PreviewLayer('$fieldname"."_preview',$fieldname,convertbr_$fieldname)\"><b>Preview</b></a>
	</td></tr>

	<tr xbgcolor=$this->clr_formcolumn2><td>
	<input type=button $btnstyle name=_btnB_$fieldname value=\" B \" onClick=AddTag('$fieldname','B')><input
        type=button $btnstyle name=_btnU_$fieldname value=\" U \" onClick=AddTag('$fieldname','U')><input 
        type=button $btnstyle name=_btnI_$fieldname value=\" I \" onClick=AddTag('$fieldname','I')><input
        type=button $btnstyle name=_btnBR_$fieldname value=\" BR \" onClick=InsertTag($fieldname,'&lt;br&gt;')><input 
        type=button $btnstyle name=_btnStrip_$fieldname value=\" Remove HTML Tags \" onClick=StripHTML('$fieldname')>
	<!--</td></tr><tr><td>-->
	<textarea name=$fieldname $customjs style='height: $tableheight"."px; width: $tablewidth"."px;' wrap=virtual
	onMouseDown=DisableButton(true,'$fieldname')
	onMouseUp=ButtonState('$fieldname')
	onKeyUp=ButtonState('$fieldname')>$fieldvalue</textarea><br>
	<input class=checkbox type=checkbox name=convertbr_$fieldname $convertbr>On saving, automatically convert linebreak to &lt;BR&gt;
	</td></tr></table>
	<!--END OF TABLE SOURCE-->

	<!--TABLE PREVIEW-->
	<a href=#bookmark_$fieldname></a>
	<table id=$fieldname"."_tbl1 style='display:none;' height=$tableheight width=100%>
        <tr><td valign=top>
	<a href=#bookmark_$fieldname onClick=ShowTable('$fieldname',0,2)><b>Source</b></a> | Preview
	</td></tr><tr><td>
	<div id=PreviewFrame style='position:relative; width: 100%; xwidth:$tablewidth"."px; height: $tableheight"."px; z-index:1; visibility: visible'>
	<hr color=#c6c6c6 size=1>
	<div id=\"$fieldname"."_preview\" style='position:relative; width:$tablewidth"."px; height: $tableheight"."px; z-index:1; visibility: visible'></div>
	</div>
	</td></tr></table>
	<!--END OF TABLE PREVIEW-->
	</td></tr>
	</table></div>
	\n";
return $advtextarea;

} //GetAdvtextarea

function ShowPreloader($follow_with_ob_start=false) {

$bufferedContent = ob_get_contents();

@ob_end_clean();
@ob_end_flush();

print "
      $bufferedContent
      <body onload=\"HideProgressLayer();\">
      <script>

      window.status='Please wait, loading interface ...';

      function HideProgressLayer() {
               document.getElementById('progressLayer').style.display = 'none';
               window.status='';
      }
      </script>

      <DIV id=progressLayer style='float:left; padding: 20 30 20 20; width: 100%; text-align: center'>
      <table height=20 width=100%><tr><td background=/i/design/cms/pbar.gif style='background-position: center; background-repeat: no-repeat;'>
      <br><br><br><br><br><br></td></tr></table>
      Please wait, loading interface...<br>
      </DIV>
      </body>
      \n
      ";

      @ob_end_flush();
      if ($follow_with_ob_start==true) ob_start();

} //ShowPreloader()


function GetSPAW($fieldname='spaw',$fieldvalue='',$width='550px',$height='150px',$style='default',$displayoutput=true) {
	global $control_name, $spaw_root,$spaw_dir, $spaw_default_lang, $spaw_dropdown_data;
        global $HTTP_SERVER_VARS, $HTTP_HOST, $DOCUMENT_ROOT;
        $available_styles = array("mini","default","classic");
        if (!(in_array($style,$available_styles))) $style = "mini";

        $content = "";
        if ($this->spawcalled == false) {
	   define('DR', "$DOCUMENT_ROOT/");
	   $spaw_root = DR.'components/spaw/';
	   $spaw_dir = "/components/spaw/";
           //ob_start();
	   include($spaw_root."spaw_control.class.php");
           //$content .= ob_get_contents();
           //ob_end_clean();
	   $this->spawcalled = true;
	   //print "CALLING $fieldname SPAW";
        }

        $content .= "";
	//$content .= "<form name=xxx_$fieldname>";

	if ($style == "default" || $style == "classic") {
	$sw = new SPAW_Wysiwyg($fieldname /*name*/,
     	      stripslashes($fieldvalue) /*value*/,
             'en' /*language*/, 'full' /*toolbar mode*/, $style /*theme*/,
             $width /*width*/, $height /*height*/);
        } elseif ($style == "mini") {
        $sw = new SPAW_Wysiwyg($fieldname /*name*/,stripslashes($fieldvalue) /*value*/,
              'en' /*language*/, 'mini' /*toolbar mode*/, 'default' /*theme*/,
              $width /*width*/, $height /*height*/, '' /*stylesheet file*/);
        }
	$content .= $sw->show();
	//$content .= "</form name=xxx>";
	if ($displayoutput == true) {
            print $content;
        } else {
            return $content;
        }
} //GetSPAW();


function _GetRelatedPicture(&$config,&$values,&$primarykey) {
	global $DOCUMENT_ROOT;

	$ext		= $this->_GetSetting($config["showextension"],"jpg");
	$savename 	= $this->_GetSetting($config["savename"],"%%$primarykey%%");
	$thumbname	= $this->_GetSetting($config["thumbname"],"tn_%%$primarykey%%");
	$imgpath	= $this->StripWrapper($this->_GetSetting($config["imgpath"],$this->imgpath),"/");
	$thumbpath	= $this->StripWrapper($this->_GetSetting($config["thumbpath"],$this->thumbpath),"/");
	$thumb	        = $thumbpath."/".$this->_Tag2Values("$thumbname.$ext",$values);
	$filename	= $imgpath."/".$this->_Tag2Values("$savename.$ext",$values);
	//print "$filename <br> $thumb";
	if (file_exists("$DOCUMENT_ROOT/$filename") && file_exists("$DOCUMENT_ROOT/$thumb")) {
		return "<a href=/$filename target=_blank><img border=0 src=\"/$thumb\"></a>";
	} else {
	        if (file_exists("$DOCUMENT_ROOT/$filename")) {
		return "<img src=\"/$filename\">";
	        }
	}
} //_GetRelatedPicture()


//function UploadBox($fieldname,$upload_config,$values = array(),$primarykey="id",$table="",$keyid='',$database='',$extra_config) {
function UploadBox($fieldname,$upload_config,$values = array(),$primarykey="id",$table="",$keyid='',$database='',$extra_config=array()) {
	global $GS, $DOCUMENT_ROOT;

        //as of 734, picture option defaults to from_db,thumboption true,showthumbnail true

	//$defdimension 	= (isset($GS["thumbsize"])) 			? $GS["thumbsize"] 			: 120;
	//$thumboption	= (isset($upload_config["thumboption"]))	? $upload_config["thumboption"]	: false;
        $formname            = $this->formname;
	$defdimension	     = $this->_GetSetting($upload_config["thumbsize"],120);
	$thumboption	     = $this->_GetSetting($upload_config["thumboption"],false);
	$imgpath	     = $this->StripWrapper($this->_GetConfig($upload_config,"imgpath",$this->imgpath),'/');
	$thumbpath	     = $this->StripWrapper($this->_GetConfig($upload_config,"thumbpath",$this->thumbpath),'/');
	$savename	     = $this->_GetSetting($upload_config["savename"],"%%$keyid%%");
	$thumbname	     = $this->_GetSetting($upload_config["thumbname"],"tn_%%$keyid%%");
	$showpicture	     = $this->_GetSetting($upload_config["showpicture"],"from_db");
	$showthumbnail	     = $this->_GetSetting($upload_config["showthumbnail"],true);
	$specific	     = $this->_GetSetting($upload_config["specific"],false);
	$onepiconly	     = $this->_GetSetting($upload_config["onepiconly"],0);
	$title		     = $this->_GetSetting($upload_config["title"],"");
	$showextension	     = $this->_GetSetting($upload_config["showextension"],"jpg");
	$extensions 	     = $this->_GetSetting($upload_config["extensions"],array("jpg"));
	$thumbwidth	     = $this->_GetSetting($upload_config["thumbwidth"],$defdimension);
	$thumbheigth	     = $this->_GetSetting($upload_config["thumbheigth"],$defdimension);
	$resample	     = $this->_GetSetting($upload_config["resample"],"maxdimension");
	$noinfo              = $this->_GetSetting($upload_config["noinfo"],false);
	$thumbsetting        = $this->_GetSetting($upload_config["thumbsetting"],false);
        $showpicdescription  = $this->_GetSetting($extra_config["showpicdescription"],true);
        //$descriptionstyle    = $this->_GetSetting($extra_config["descriptionstyle"],$this->descriptionstyle);
        $previewbutton       = $this->_GetSetting($extra_config["previewbutton"],true);
        $descriptionbutton   = $this->_GetSetting($extra_config["descriptionbutton"],true);
	$createthumbnail     = $this->_GetSetting($extra_config["createthumbnail"],true);
	$exceptionfields     = $this->_GetSetting($extra_config["exceptionfields"],array());
        $optionexpanded      = $this->_GetSetting($extra_config["optionexpanded"],false);
        $titlewidth          = $this->_GetSetting($extra_config["titlewidth"],40);
        $descriptionexpanded = $this->_GetSetting($extra_config["descriptionexpanded"],false);
        $descriptionwidth    = $this->_GetSetting($extra_config["descriptionwidth"],50);
        $descriptionheight   = $this->_GetSetting($extra_config["descriptionheight"],3);
	$picturetable        = $this->_GetSetting($extra_config["picturetable"],$this->tbl_picture);

        $settingdisplay      = ($optionexpanded == true) ? 'none' : 'inline';
        $descdisplay         = ($descriptionexpanded == true) ? 'block' : 'none';
        $thumboption_checked = ($optionexpanded == true) ? '' : 'checked';
        $thumbdisplay        = ($optionexpanded == true) ? 'inline' : 'none';

        $descriptionstyle   = "<div id=%%FIELDNAME%% style='display: $descdisplay; padding: 0px; line-height:18px;'>
                              <table cellpadding=1 cellspacing=0><tr><td width=80>Title</td>
                              <td><input size=$titlewidth type=text name=\"%%PIC_TITLE%%\"></td></tr>
                              <tr><td>Description</td>
                              <td><textarea name=\"%%PIC_DESCRIPTION%%\""."_description type=text rows=$descriptionheight cols=$descriptionwidth></textarea></td>
                              </tr></table></div>";
        $default_w          = $this->default_w;
        $default_h          = $this->default_h;

        $thumbjs            = "
        <script>
        function ShowThumb$fieldname(t) {
        if (t.checked) {
           divset$fieldname.style.display = 'inline';
           divthumb$fieldname".".style.display = 'none';
        } else {
           divset$fieldname.style.display = 'none';
           divthumb$fieldname".".style.display = 'block';
        }
        }

        function CheckThumb$fieldname(t) {
            if (window.document.$formname.$fieldname.value.length == 0) {
            if (t.value.length > 0) {
               alert('Cannot upload thumbnail without uploading main picture')
               thumb_error = 1
            } else {
               thumb_error = 0
            }
            }
        }
        </script>
        ";

       $hiddensetting  = "
	        <input type=hidden name=$fieldname"."_thumbwidth value=\"$thumbwidth\">
                <input type=hidden name=$fieldname"."_thumbheigth value=\"$thumbheigth\">
                <input type=hidden name=$fieldname"."_resample value=\"$resample\">
                ";
        //print "<pre>$thumbsetting - $createthumbnail - $thumboption</pre>";
        if (($thumbsetting == true) || ($createthumbnail == true)) {
                $settingrow     = $this->GetThumbSetting($fieldname,$default_w,$default_h,$settingdisplay); //"Thumb W: $thumbsetting_w x H: $thumbsetting_h $resamplesetting <br>";
                if ($thumboption == true) {
                   //print "<h1>$fieldname</h1><pre>".htmlentities($hiddensetting)."</pre>";
                   $hiddensetting = "";
                }
        } else {
                $settingrow     = "";
        }

	if ($thumboption == true) {
            if (function_exists('imagecreatefromjpeg') && ($createthumbnail==true)) {
	        $thumboptions	 = "
		<br><span style='width: 80px;'></span>
                <input onClick=\"ShowThumb$fieldname(this)\" class=checkbox type=checkbox name=$fieldname"."_thumbnail $thumboption_checked>
                Automatic thumbnail $settingrow
                <div id=divthumb$fieldname style='padding: 0px; display:$thumbdisplay;'><span style='width: 80px;'>Thumbnail</span>
                <input type=file size=30 name=$fieldname"."_userthumb onBlur=\"CheckThumb$fieldname(this);\"></div>";		$createthumbnail = true;
	    } else {
		$createthumbnail = false;
		$thumboptions	 = "[please install GD library to enable thumbnail creation or enable <i>createthumbnail</i> parameter]";
	    }
	} else {
	    $thumboptions	= "";
	}

	//show picture already related to this picture
	if (strtolower($showpicture) == "from_file") {
		//if thumboption is true, a thumbnail might be available. If so, show the thumbnail instead of the big picture.
		//But before showing check if related file really exists in location.
		$showsavename 	= $this->_Tag2Values($savename,$values);
		$showthumbname	= $this->_Tag2Values($thumbname,$values);

		if ($thumboption == false) {
			$checkfile	= "$imgpath/$showsavename.$showextension";
		} else {
			$checkfile	= "$thumbpath/$showthumbname.$showextension";
		}
		if ($title == "") $title = "Picture related";
		if (file_exists("$DOCUMENT_ROOT/$checkfile")) {
			$bigfile	= "/$imgpath/$showsavename.$showextension";
			$imagetag	= "<table cellpadding=4 cellspacing=1><tr><td><b>$title</b></td></tr>
					<tr><td><a href=\"/$bigfile\" target=_blank><img src=\"/$checkfile\" border=0></a><br clear=left>
					</td></tr></table>";
			$options	= "
					<input type=radio name=$fieldname"."_fileop value=keep checked>Keep
					<input type=radio name=$fieldname"."_fileop value=delete>Delete
					<input type=hidden name=$fieldname"."_curimage value=$bigfile>
					<input type=hidden name=$fieldname"."_curthumb value=$checkfile>
					<input type=hidden name=$fieldname"."_resample value=$resample>
					<input type=hidden name=$fieldname"."_showpicture value=$showpicture>
					";
		} else {
			$imagetag	= "[no picture is related to this record]<br>";
			$options	= "";
		}
		$description_input	= "";
	} elseif (strtolower($showpicture) == "from_db") {

		if ($specific == true) {
			$sql = "select * from $picturetable where tablename='$table' and fieldname='$fieldname' and keyid='$keyid'";
		} else {
			if (count($exceptionfields)==0) {
				$sql = "select * from $picturetable where tablename='$table' and keyid='$keyid'";
			} else {

				$exceptionlist = "'".join("','",$exceptionfields)."'";
				$sql = "select * from $picturetable where tablename='$table' and keyid='$keyid' and fieldname not in ($exceptionlist)";
			}
		}
		if ($keyid != "") {
		        if ($noinfo == false) {
			$imagetag = $this->_GetPicturesInDb($sql,$showthumbnail,false,$onepiconly,array("title"=>$title,"picturetable"=>$picturetable),$database)."<br>";
                        } else {
                        $imagetag = "";
                        }
		} else {
			$imagetag = "";
		}
		$options = "";
		$description_input = preg_replace(array("|%%FIELDNAME%%|","|%%PIC_TITLE%%|","|%%PIC_DESCRIPTION%%|"),array("div$fieldname","$fieldname"."_title","$fieldname"."_description"),$descriptionstyle);
	}
	if ($showpicdescription == false) { $description_input = ""; }

	$onepiconly = $onepiconly + 0;

        //$btnpreview     = ($previewbutton == false)     ? "" : "<span onClick=window.open(".$this->formname.".$fieldname.value,'preview') style='cursor:hand; width=18px; background: transparent url(\"/i/design/cms/preview.gif\") no-repeat;'>&nbsp;&nbsp;</span>";
        $btnpreview     = ($previewbutton == false)     ? "" : "<input type=button onClick=window.open(".$this->formname.".$fieldname.value,'preview') style='cursor:hand; width=18px; background: transparent url(\"/i/design/cms/preview.gif\") no-repeat;'>";
        $jsfunction     = ($descriptionbutton == false) ? "" : "<script>function ShowHideDiv$fieldname() { if (div$fieldname.style.display=='none') { div$fieldname.style.display='block'; } else { div$fieldname.style.display='none'; }; } </script>";
        $btndetail      = ($descriptionbutton == false) ? "" : "$jsfunction<input type=button style='cursor: hand; width=18px; background: transparent url(\"/i/design/cms/detail.gif\") no-repeat;' onClick=\"ShowHideDiv$fieldname()\">";


        $uploadrow ="
		<tr><td colspan=2>
                $thumbjs
                <span style='width: 80px;'>Picture</span>
                <input class=xbutton size=30 type=file name=\"$fieldname\">
                $btndetail
                $btnpreview
                $thumboptions
                $description_input </td></tr>
                ";


	$content = "
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
		<tr><td colspan=2>$imagetag $options</td></tr>
		$uploadrow
		<input type=hidden name=$fieldname"."_imgpath value=\"$imgpath\">
		<input type=hidden name=$fieldname"."_savename value=\"$savename\">
		<input type=hidden name=$fieldname"."_thumbpath value=\"$thumbpath\">
		<input type=hidden name=$fieldname"."_thumbname value=\"$thumbname\">
		<input type=hidden name=$fieldname"."_createthumbnail value=\"$createthumbnail\">
                $hiddensetting
		<input type=hidden name=$fieldname"."_showpicture value=\"$showpicture\">
		<input type=hidden name=$fieldname"."_onepiconly value=\"$onepiconly\">
		</table>";
	return $content;
} //UploadBox()


function GetThumbSetting($fieldname,$default_w,$default_h,$display='inline') {
        $resampling     = ($default_w == $default_h) ? "maxdimension" : "fixed";
        $thumbchoices   = array("30"=>"30","45"=>"45","90"=>"90","120"=>"120","150"=>"150","180"=>"180","200"=>"200","250"=>"250");
        if (!in_array($default_w,$thumbchoices)) { $thumbchoices[$default_w]=$default_w; }
        if (!in_array($default_h,$thumbchoices)) { $thumbchoices[$default_h]=$default_h; }

        asort($thumbchoices);

        $thumb_js1       = " onChange=\"if($fieldname"."_resample.value!='fixed') { $fieldname"."_thumbheigth".".selectedIndex=$fieldname"."_thumbwidth.selectedIndex; }\" ";
        $thumb_js2       = " onChange=\"if($fieldname"."_resample.value!='fixed') { $fieldname"."_thumbwidth.selectedIndex=$fieldname"."_thumbheigth.selectedIndex; }\" ";
        $resample_js     = " onChange=\"if($fieldname"."_resample.value!='fixed') { $fieldname"."_thumbwidth.selectedIndex=$fieldname"."_thumbheigth.selectedIndex; }\" ";
        $thumbsetting_w  = $this->PrintSelect($thumbchoices,$default_w,"$fieldname"."_thumbwidth","key_value",1,false,"class=button $thumb_js1");
        $thumbsetting_h  = $this->PrintSelect($thumbchoices,$default_h,"$fieldname"."_thumbheigth","key_value",1,false,"class=button $thumb_js2");
        $resamplesetting = $this->PrintSelect(array("maxdimension"=>"Proportional","fixed"=>"Fixed"),$resampling,"$fieldname"."_resample","key_value",1,false,"class=button $resample_js");
        $content         = "<div id=\"divset$fieldname\" style='float:auto; display:$display;'>using this setting W: $thumbsetting_w x H: $thumbsetting_h $resamplesetting </div><br clear=left>";
        //$content         = "<span id=\"divset$fieldname\" style='float:auto; '>using this setting W: $thumbsetting_w x H:</span><br clear=left>";

        return $content;
}

function UploadBox2($fieldname,$config,$table,$keyid,$database='') {
	$tbl_uploads 	= $this->tbl_uploads;
	$uploadpath 	= $this->StripWrapper($this->_GetConfig($config,"uploadpath",$this->uploadpath),'/');
	$extensions 	= $this->_GetSetting($config["extensions"],array("All files"));
	$onefileonly	= $this->_GetSetting($config["onefileonly"],0);
	$specific       = $this->_GetSetting($config["specific"],false);
        $title		= $this->_GetSetting($config["title"],"");
	$noinfo         = $this->_GetSetting($config["noinfo"],false);
	$showinputdescription = $this->_GetSetting($config["showinputdescription"],false);
        $allowed_extensions = join(", ",$extensions);

	if ($keyid != "") {
	        if ($noinfo == false) {
	        if ($specific == true) {
		$sql = "select * from $tbl_uploads where tablename='$table' and fieldname='$fieldname' and keyid='$keyid'";
		} else {
		$sql = "select * from $tbl_uploads where tablename='$table' and keyid='$keyid'";
                }
                $files_related = $this->_GetFilesInDb($sql,false,$onefileonly,array("title"=>$title),$database);
	        } else { $files_related = ""; }
        } else {
		$files_related = "";
	}
	$inputdescription =($showinputdescription == false) ? "<input type=hidden name=$fieldname"."_description>" : "&nbsp;&nbsp;Description: <input type=text class=button size=40 name=$fieldname"."_description>";
	$uploadpath 	  = $this->StripWrapper($this->_GetConfig($config,"uploadpath",$this->uploadpath),'/');
	$extensions 	  = $this->_GetSetting($config["extensions"],array("All files"));
	$onefileonly	  = $this->_GetSetting($config["onefileonly"],0);
	$allowed_extensions = join(", ",$extensions);

	$content = "
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
		<tr><td>$files_related</td></tr>
		<tr><td>
		<br><input type=file class=button name=\"$fieldname\">
		$inputdescription
                <input type=hidden name=$fieldname"."_onefileonly value=$onefileonly>
		<input type=hidden name=$fieldname"."_uploadpath value=\"$uploadpath\"><br></td></tr>
		<tr><td height=20><font size=1>Allowed file types to upload: <i>$allowed_extensions</i></font></td></tr>
		</table>";
	return $content;
} //UploadBox2()


function _GetFilesInDb($sql,$viewmode = false,$onefileonly=0,$extras=array(),$database='') {

	$title		= $this->_GetSetting($extras["title"],"");
	$title    	= ($title != "")  ? $title :  "File(s) related to this Article";
	$formname 	= $this->formname;

	$NO_str		= ($onefileonly == 1) ? "" 	:  "%%NO%%";
	$NO_label	= ($onefileonly == 1) ? "" 	:  "No";

	$dellabel  = ($viewmode == true) ? "" : "<a name=filetodel href=#filetodel onClick=CheckAllFileToDelete('$formname');>Delete</a>";
	$delinput  = ($viewmode == true) ? "" : "<input type=checkbox name=filetodel[] value=%%id%%>";

	if ($this->disablejs == true) $dellabel = "";

	$fontstyle = "<font style=color:#bababa>";
	$list = array(
	      	"database"      => $database,
		"sql"		=> $sql,
		"fields"	=> array("id","filesize","filename","lastupdate","path"),
		"adminpage"	=> false,
		"groupfield"	=> "lastupdate",
		"initialorder"	=>"desc",
		"numitems"	=> 100,
		"opentag"	=> "
				<table cellpadding=0 cellspacing=1 bgcolor=#c7c7c7 width=100%><tr><td>
				<table width=100% cellspacing=0 cellpadding=4 border=0 bgcolor=#ebebeb>
				<tr bgcolor=#ffffff><td colspan=6><b>$title</font></b></tr>
				<tr bgcolor=#ffffff><td width=15>$NO_label</td><td>Filename</td><td>Size</td><td>Upload Date</td>
				<td>$dellabel</td></tr>
				<tr bgcolor=#a7a7a7><td colspan=6></tr>",
		"closetag"	=> "</table></td></tr></table>",
		"norecords"	=> "[no file is related to this record]<br>",
		"layout"	=> "
				<tr valign=top class=rowsel><td>$NO_str</td>
				<td valign=top><a href=\"/%%path%%/%%filename%%\" target=_new><b>%%description%%</b></a>&nbsp;&nbsp;&nbsp;</td>
				<td align=center>$fontstyle%%filesize%% bytes</font></td>
				<td $fontstyle%%lastupdate%%</font></td>
				<td align=center width=30>&nbsp;$delinput</td></tr>
				<tr><td colspan=6 bgcolor=#c6c6c6></td></tr>
				");
	return $this->ProcessContent($list);
} //_GetFilesInDb()


function _GetPicturesInDb($sql,$showthumbnail = false,$viewmode = false,$onepiconly=0,$extras=array(),$database='') {

	$showthumb = ($showthumbnail == true) ? 1 : 0;
	$fontstyle = "<font style=color:#bababa>";
	$formname  = $this->formname;
	$dellabel  = ($viewmode == true) ? "" : "<a name=pictodel href=#filetodel onClick=CheckAllPicToDelete('$formname');>Delete</a>";
	$delinput  = ($viewmode == true) ? "" : "<input type=checkbox name=pictodel[] value=%%id%%>";

	$NO_str	   = ($onepiconly == 1) ? "" 	:  "%%NO%%";
	$NO_label  = ($onepiconly == 1) ? "" 	:  "No";

	$title	      = $this->_GetSetting($extras["title"],"");
	$title        = ($title != "")  ? $title :  "Picture(s) related to this Article";
	$picturetable = $this->_GetSetting($extras["picturetable"],$this->tbl_picture);

	if ($this->disablejs == true) $dellabel = "";

	$info_about_onepiconly = ($onepiconly == 0) ? "" : "<tr><td colspan=7 align=left>Uploading a new picture will replace the current picture.</td></tr>";

        $thumbviewsize         = $this->thumbviewsize;

	$list = array(
	        "database"      => $database,
		"sql"		=> $sql,
		"fields"	=> array("id","filesize","filename","lastupdate","path","width","height","thumbname","thumbpath"),
		"adminpage"	=> false,
		"groupfield"	=> "lastupdate",
		"initialorder"	=>"desc",
		"replace"	=> array("description"=>array("<EMPTY>"=>"[no description]")),
		"strformat"	=> array(
				"description"=>"truncate(%%description%%,100)",
				"thumbname"=>"piclink(/%%path%%/%%filename%%,/%%thumbpath%%/%%thumbname%%,$showthumb)"),
		"numitems"	=> 100,
		"opentag"	=> "
				<table border=0 cellpsadding=0 cellspacing=1 bgcolor=#c7c7c7 width=\"100%\"><tr><td>
				<table width=\"100%\" cellspacing=0 cellpadding=4 border=0 bgcolor=#ebebeb>
				<tr bgcolor=#ffffff><td colspan=7><b>$title</b></tr>
				<tr bgcolor=#ffffff><td>$NO_label</td><td>Filename</td><td>Size</td><td align=center>Thumb</td><td>Upload Date</td><td>Dimension</td>
				<td>$dellabel</td></tr>
				<tr bgcolor=#a7a7a7><td style='height:1px; padding:0px;' colspan=7></tr>",
		"closetag"	=> "$info_about_onepiconly</table></td></tr></table>",
		"norecords"	=> "[no picture is related to this record]<br>",
		"layout"	=> "<tr class=rowsel>
				<td valign=top width=20 bgcolor=white align=center><br>$NO_str &nbsp;</td>
				<td nowrap><a href=\"/%%path%%/%%filename%%\" target=_new><font color=#a9a9a9><b>%%filename%%</a>
				<br>
                                <input style='color: #a7a7a7; text-decoration: underline; background-color: transparent; border: none;' size=40% type=text name=title_%%id%% value=\"%%title%%\" readonly><br>
                                <input style='color: #a7a7a7; font-style: italic; background-color: transparent; border: none;' size=40% type=text name=desc_%%id%% value=\"%%description%%\" readonly>&nbsp;&nbsp;<a href=#
                                onClick=\"x%%id%% = window.open('cms_picture_description.php?act=edit&keyid=%%id%%&f=$formname&t1=title_%%id%%&t2=desc_%%id%%&tbl=$picturetable','EditDescription_pic%%id%%','height=230, width=600, status=NO,toolbar=NO');x%%id%%.focus();return false;\">[Edit]</a></font>&nbsp;&nbsp;&nbsp;</td>
				<td width=80 align=right>$fontstyle%%filesize%% bytes</font></td>
				<td align=center>$fontstyle %%thumbname%%</td>
				<td align=center width=120> $fontstyle%%lastupdate%%</font></td>
				<td align=center>$fontstyle%%width%% x %%height%%</font></td>
				<td align=center width=30>&nbsp;$delinput</td></tr>
				<tr><td colspan=7 style='height:1px; padding:0px;' bgcolor=#c6c6c6></td></tr>
				");
	return $this->ProcessContent($list);
} //_GetPicturesInDb()


function _Tag2Values($tag,$valuepairs,$validate_as_filename = true) {
	reset($valuepairs);
	if (!isset($valuepairs)) return $tag;
	while (list($key,$value) = each($valuepairs)) {
		$strkey = "%%$key%%";
		//$safestrkey = "%%SAFEKEY_$key%%";
		if (!is_array($value)) {
		        $safevalue = md5($this->sitekey.$value);
			$tag = str_replace($strkey,$value,$tag);
			//$tag = str_replace($safestrkey,$safevalue,$tag);
		}
	}

	if ($validate_as_filename == true) {
		return $this->ValidateFilename($tag);
	} else {
		return $tag;
	}
} //_Tag2Values()


function GetDbFields($fields) {
	$fieldnames	= array();
	reset($fields);
	while(list($fieldname,$key) = each($fields)) {
		$dbfield = (!isset($fields[$fieldname]["dbfield"])) ? true : $fields[$fieldname]["dbfield"];
		if ($dbfield == true) {	
			array_push($fieldnames,$fieldname);
		}
	}
	$fieldlist = join(",",$fieldnames);

	return $fieldlist;
} //GetDbFields()


function GenerateSubmit() {
         print "
	 <script language=JavaScript>
	 function SubmitForm(frm) {
	 	  frm.submit()
	 }

	 function ResetForm(frm) {
	         e = confirm('Reset form?')
		 if (e == true) theform.reset()
	 }
	 </script>";
} //GenerateSubmit()

function ServerValidation($config,$keyvalues) {
	 $numerror 	= 0;
	 $warn_pos      = 0;
	 $message       = "";
	 $donemessage	= $this->_GetSetting($config["donemessage"],"");
	 $header	= $this->_GetSetting($config["header"],"");
	 $novalidation  = $this->_GetSetting($config["novalidation"],false);
         $cfgfields     = $this->_GetSetting($config["fields"],array());

	 if ($novalidation == true || count($cfgfields)==0) {
            return true;
	 }

         while (list($key,$vrule)=each($cfgfields)) {
	 //while (list($key,$vrule)=each($config["fields"])) {
	       if (isset($vrule["validate"])) {
	          $fieldtype     = isset($vrule["type"]) 	? $vrule["type"]    : "";
	          $warninglist   = isset($vrule["warning"])     ? $vrule["warning"] : "";

                  if ($fieldtype == "upload" || $fieldtype == "file") {
	              $vrulelist  = "";
		      $value	  = "";
		  } else {
		      $vrulelist = $vrule["validate"];
		      $value     = $keyvalues[$key];
    		  }
		  //print "$value $vrulelist";
		  if (is_array($vrulelist)) {
		     while(list($vkey,$vrelement) = each($vrulelist)) {

                     if (is_array($warninglist)) {
                             $warning    = (isset($warninglist[$warn_pos])) ? $warninglist[$warn_pos] : "";
                             $warn_pos++;
                     } else {
                             $warning    = $warninglist;
                     }

		     if ($this->ServerValidationCheck($key,$vrelement,$value) == false) {
			     $numerror = $numerror + 1;
			     $msg      = ($warning == "") ? $this->tmp_message : $warning;
			     $message .= "<br>$msg";
		     };
		     $this->tmp_message = "";
		     }
		  } else {
		     if ($this->ServerValidationCheck($key,$vrulelist,$value) == false) {
                             $warning  = $warninglist;
			     $numerror = $numerror + 1;
			     $msg      = ($warning == "") ? $this->tmp_message : $warning;
			     $message .= "<br>$msg";
    		     }
    		     $this->tmp_message = "";
		  }
	       }
	 }
	 if ($numerror == 0) {
	 	return true;
  	 } else {
  	        $messagetitle = "PLEASE CORRECT...";
  	        $link	      = "<a href=# onClick=history.go(-1)>Return to form</a>";
  	        if ($donemessage == "") {
  	           print $header . $this->MessageBox("PLEASE CORRECT",$message,$link);
           	} else {
                   print $header . preg_replace(array("|%%MESSAGETITLE%%|","|%%MESSAGE%%|","|%%MESSAGELINK%%|"),array($messagetitle,$message,$link),$donemessage);
		}
  	        return false;
  	 }
} //ServerValidation

function ServerValidationCheck($key,$rule,$value){
	 if (eregi("must_fill",$rule)){
	      if (strlen(trim($value)) == 0) {
	         $this->tmp_message = "Please fill in $key";
	         return false;
	      }
	 } elseif (eregi("max_length",$rule)) {
	   	 list($key,$max) = split(" ",$rule." 255");
		 if (strlen($value) > $max) {
		 $this->tmp_message = "$key should not exceed $max characters";
		 return false;
		 }
  	 } elseif (eregi("min_length",$rule)) {
	   	 list($rule,$min) = split(" ",$rule." 0");
		 if (strlen($value) < $min) {
		 $this->tmp_message = "$key should be at least $min characters";
		 return false;
		 }
    	 } elseif (eregi("must_select",$rule)) {
    	   	 list($key,$atleast) = split(" ",$rule." 1");
    	   	 if (strlen(trim($value)) == 0) {
    	   	    $numselected = 0;
          	 } else {
    	   	    $numselected = count(split("\|",$value));
          	 }
		 if ($numselected < $atleast) {
		 $this->tmp_message = "Please select at least $atleast of $key options";
		 return false;
		 }
	 } elseif (eregi("valid_numeric",$rule)) {
	   	 if (!is_numeric($value)) {
		 $this->tmp_message = "$key should be a valid numeric input";
	   	 return false;
      		 }
	 } elseif (eregi("valid_date",$rule)) {
	         if ($this->databasetype=="mysql") {
	            list($year,$month,$day) = split("-",$value."--");
	         } else {
	            list($month,$day,$year) = split("/",$value."//");
                 }
                 //print intval($day);
                 //print "<h1>$year-$month-$day</h1>";
                 //print intval($day);
                 if (checkdate(intval($month),intval($day),intval($year))==false) {
		 $this->tmp_message = "$key should be a valid date";
	   	 return false;
		 }
	 } elseif (eregi("valid_range",$rule)) {
 		 $range	     = split(" ",$rule);
 		 $ranges     = split('-',$range[1]);
		 $rangemin   = $ranges[0];
		 $rangemax   = $ranges[1];
		 if (!($value >= $rangemin && $value <= $rangemax)) {
		 $this->tmp_message = "$key should be between $rangemin and $rangemax";
		 return false; }
	 } elseif (eregi("valid_email",$rule)) {
	         if (!(preg_match("/(.*?@.*?)\.(.+?)+$/",$value,$match))) {
		 $this->tmp_message = "$key should be a valid email";
	         return false;
  		 }
	 } elseif (eregi("valid_verification",$rule)) {
	         list($field1,$field2) = split(" ",$rule." ");
	         $verification = $this->GetVar($field2,"");
	         if ($verification <> $value) {
		 $this->tmp_message = "$key should be correctly verified";
		 return false;
                 }
  	 }
	 return true;
}

function GenerateValidation($validate_items,$method=post,$withspaw = false) {
	include("jfkJS_v101.php");

        $SPAW_UpdateField = (($withspaw == true) && ($this->enablespaw == true)) ? "SPAW_UpdateFields()" : "";

	print "
	<script language=JavaScript>
	//JavaScript Utility and Validation Section
	//written by Josef F. Kasenda
	//Please do not use this script without permission
	//Works best ONLY under IE 6.

	var lastrow = -1
	var lastrowstate = 0
	var lastadvtextarea = ''
	var allchecked = 0;
	var allpicchecked = 0;
	var thumb_error = 0;

	function ShowTable(fieldname,activetable,numoftable) {
		var current_state

		//this is an amazing solution to the anomaly still found in v645
		//if we are handling a different textarea then reset the lastrowstate of the previous textarea

		if (lastadvtextarea != fieldname) {
			lastrowstate = 0
		}

		lastadvtextarea = fieldname

		//alert(fieldname)
		for (i = 0; i < numoftable; i++) {
			if (i != activetable) {
				eval(fieldname+\"_tbl\"+i+\".style.display='none';\");
			}
		}


		if (lastrow == activetable) {
			if (lastrowstate == 1) {
				display_state = 'none'
				lastrowstate = 0
			} else {
				display_state = 'block'

				lastrowstate = 1
			}

		} else {
			display_state = 'block'
			lastrowstate = 1
		}
		eval(fieldname+\"_tbl\"+activetable+\".style.display='\"+display_state+\"';\");
		lastrow = activetable

	}

	function ResetForm(theform) {
	         e = confirm('Reset form?')
		 if (e == true) theform.reset()
	}

	function ButtonState(fieldname) {
		if (document.selection) {
			var selectedRange = document.selection.createRange();

			var strSelection = document.selection.createRange().text ;
			//alert(strSelection.length)
			if (strSelection.length == 0) {
				bool = true
			} else {
				bool = false
			}

			DisableButton(bool,fieldname)
		}


	}

	function DisableButton(bool,fieldname) {
		document.getElementById('_btnI_'+fieldname).disabled = bool
		document.getElementById('_btnB_'+fieldname).disabled = bool
		document.getElementById('_btnU_'+fieldname).disabled = bool
		document.getElementById('_btnStrip_'+fieldname).disabled = bool
	}

	function AddTag(advtextarea,tag) {
		if (document.selection) {
		var selectedRange = document.selection.createRange();
		var strSelection = document.selection.createRange().text ;
		inputname = selectedRange.parentElement().name;

		if (inputname == advtextarea) {
			if (strSelection.length != 0) {

				document.selection.createRange().text = \"<\"+tag+\">\" + strSelection +\"</\"+tag+\">\"
				DisableButton(true,inputname)
				return;
			}
		}
		}
	}

	function AddTag2(advtextarea,tag,close) {

		if (document.selection) {

		var selectedRange = document.selection.createRange();
		var strSelection = document.selection.createRange().text ;
		inputname = selectedRange.parentElement().name;

		if (inputname == advtextarea) {
			if (strSelection.length != 0) {
				document.selection.createRange().text = \"<\"+tag+\">\" + strSelection +\"</\"+close+\">\"
				return;
			}
		}
		}
	}

	function InsertTag(input,insText) {
 		input.focus();
 		if( input.createTextRange ) {
   			document.selection.createRange().text += insText;
 		} else if( input.setSelectionRange ) {
   			var len = input.selectionEnd;
   			input.value = input.value.substr( 0, len ) + insText + input.value.substr( len );
   			input.setSelectionRange(len+insText.length,len+insText.length);
 		} else { 

			input.value += insText; 

		}
	}

	function StripHTML(advtextarea){
		if (document.selection) {
		var selectedRange = document.selection.createRange();
		var strSelection = document.selection.createRange().text ;
		inputname = selectedRange.parentElement().name;

		if (inputname == advtextarea) {
			regexp= new RegExp (\"<.+?>\", \"gi\");
			stripped = strSelection.replace(regexp,\"\");
			document.selection.createRange().text = stripped
		}
		}
	}

	function PreviewLayer(previewlayer, source,convertbr) {
		if (convertbr.checked) {
			input = source.value
			document.getElementById(previewlayer).innerHTML = input.replace(/\\n/gi,\"<br>\");
		} else {
			document.getElementById(previewlayer).innerHTML = source.value
		}
	}


	function CheckAllPicToDelete(frm) {
		var lf = document.forms[frm];
		var len = lf.elements.length;
		
		for (var i = 0; i < len; i++) {
	    		var e = lf.elements[i];
			if (e.name == \"pictodel[]\") {
				if (allpicchecked == 0) {
					e.checked = true;
				} else {
					e.checked = false;
				}
			}
		}
		if (allpicchecked == 0) {
			allpicchecked = 1
		} else {
			allpicchecked = 0
		}
	}

	function CheckAllFileToDelete(frm) {
		var lf = document.forms[frm];
		var len = lf.elements.length;

		for (var i = 0; i < len; i++) {
	    		var e = lf.elements[i];
			if (e.name == \"filetodel[]\") {
				if (allchecked == 0) {
					e.checked = true;
				} else {
					e.checked = false;
				}
			}
		}

		if (allchecked == 0) {
			allchecked = 1
		} else {
			allchecked = 0
		}
	}

	function SubmitForm(frm,btn,msg) {

        $SPAW_UpdateField
        ";

	if ($this->confirmmessage != "") {
	print "e = confirm('$this->confirmmessage') \n if (e == false) return false;";
	}

	$alias_pos = 0;
        $warn_pos  = 0;

	while (list($fieldname,$config) = each($validate_items)) {

		$warninglist 	= (!isset($config["warning"])) 	? ""		: $config["warning"];
		$alias 		= (!isset($config["alias"])) 	? $fieldname	: $config["alias"];
		$rule		= (!isset($config["validate"]))	? array()	: $config["validate"];;
		$type		= (!isset($config["type"]))	? "text"	: ($config["type"]);
                $warn_pos       = 0;


                $alias = $this->FormatLabel($alias);

		if (!is_array($rule)) $rule = array($rule);

		for ($i = 0; $i < count($rule); $i++) {

                //check if multiple validation is coupled with multiple warning
  	        if (is_array($warninglist)) {
                     $warning = (isset($warninglist[$warn_pos])) ? $warninglist[$warn_pos] : "";
                     $warn_pos++;
                } else {
                     $warning = $warninglist;
                }

		$vrule = $rule[$i];
		if ($vrule == "must_fill") {
			$alert = ($warning != "") ? "'$warning'" : "'$alias must be filled'";
			print "
			if (frm.$fieldname.value.length == 0) {
				alert($alert)
				frm.$fieldname.focus()
				return false
			}";
    		} elseif (eregi('min_length',$vrule)) {
    		        $range = split(" ",$vrule." 0");
    		        $min_length = $range[1];
    		        $alert = ($warning != "") ? "'$warning'" : "'$alias length should be at least $min_length characters'";
    		        print "
			if (frm.$fieldname.value.length < $min_length) {
			        alert($alert);
			        return false;
			}
			";
    		} elseif (eregi('max_length',$vrule)) {
    		        $range = split(" ",$vrule." 255");
    		        $max_length = $range[1];
    		        $alert = ($warning != "") ? "'$warning'" : "'$alias length should not exceed $max_length characters'";
    		        print "
			if (frm.$fieldname.value.length > $max_length) {
			        alert($alert);
			        return false;
			}
			";
		} elseif ($vrule == "valid_numeric") {
			$alert = ($warning != "") ? "'$warning'" : "'$alias must be numeric'";
			print "
			if (frm.$fieldname.value != (frm.$fieldname.value * 1)) {
				alert($alert)
				frm.$fieldname.focus()
				return false
			}";
		} elseif (eregi('valid_range',$vrule)) {
			$range	= split(" ",$vrule);
			$ranges	= split('-',$range[1]);
			$rangemin	= $ranges[0];
			$rangemax	= $ranges[1];
			$alert	= ($warning != "") ? $warning : "$alias must be within $rangemin and $rangemax";
			print "
				if ((frm.$fieldname.value < $rangemin) || (frm.$fieldname.value > $rangemax)) {
					alert('$alert')
					frm.$fieldname.focus()
					return false
				}"; 
		} elseif (eregi('must_select',$vrule)) {

			$cond 	= split(" ",$vrule);
			$cond_1	= (!isset($cond[1])) 	? 1	: $cond[1]; 
			$atleast= (count($cond) == 1) 	? 1	: $cond_1;
			$alert	= ($warning != "") ? "'$warning'" : "'You must select at least $atleast $alias'";
			if (eregi('select',$type)) {
				print "
					numselected = 0
					for(i = 0; i < frm.$fieldname.length; i++) {
						if (frm.$fieldname"."[i].selected == true) numselected++
					}
					if (numselected < $atleast) {
						alert($alert)
						return false
					}";

			} elseif (eregi('radio|checkbox',$type)) {
				$alert = ($warning != "") ? "'$warning'" : "'You must select at least $atleast of the $alias'";
				if ($method == "get") {	
					print "
						numchecked = 0
						for(i = 0; i < frm.$fieldname.length; i++) {
							if (frm.$fieldname"."[i].checked) numchecked++
						}

						if (numchecked < $atleast) {
							alert($alert)
							return false
						}";
				} else {
					//as of 715 lf = document.forms[0] is changed to lf = frm
					print "
						numchecked = 0
						var lf = frm;
						var len = lf.elements.length;		
						for (var i = 0; i < len; i++) {
	    					var e = lf.elements[i];
						if (e.name == \"$fieldname"."[]\") {
							if (e.checked == true) {
								numchecked++
							} else {

							}
						}//if
						}//for

						if (numchecked < $atleast) {
							alert($alert);
							return false;
						}
						";
				}
			}
		} elseif ($vrule == "valid_email") {
			$alert = ($warning != "") ? "'$warning'" : "frm.$fieldname.value +' is not a valid email address'";
			print "
			if (CheckEmail(frm.$fieldname) == false) {
				alert($alert)
				return false
			}";
		} elseif (eregi('valid_verification',$vrule)) {
			$alert = ($warning != "") ? "'$warning'" : "'$alias must be correctly verified'";		                                              	
		        $vrule = $vrule . " 1"; //just to avoid blank;
		        list($rule,$cmpfield) = split(" ",$vrule);
		        print "
		        if (frm.$fieldname.value != frm.$cmpfield.value) {
	              	   	  alert($alert);
		      	   	  return false
         		   	  }
		      	";
		} elseif ($vrule == "valid_date") {
                        if ($type == "dateselect") {

			$date = "frm.".$fieldname."_date";
			$month = "frm.".$fieldname."_month";
			$year  = "frm.".$fieldname."_year";
			$alert = ($warning != "") ? "'$warning'" : "d + ' ' + monthOfYear[m] + ' '+ y + ' is not a valid date'";

			print "
			if (CheckDate($date,$month,$year) == false) {
				d = $date.options[$date.options.selectedIndex].value;
				m = $month.options[$month.options.selectedIndex].value;
				y = $year.options[$year.options.selectedIndex].value;
				m = $month.options.selectedIndex;
				selecteddate = d + '' + monthOfYear[m] + '' + y
				if (selecteddate == '') {
				   alert('Date cannot be empty')
				} else {
				  alert($alert)
     					}
				return false
			}
			if ($year.value == '') {
				alert('$warning');
				return false
			}
			";
                        } elseif ($type == "datepop") {
                                 print "
                                 selecteddate = frm.$fieldname.value
                                 var d = selecteddate.split('/')
                                 var year_$fieldname  = parseInt(d[2]*1)
                                 var month_$fieldname = parseInt(d[0]*1)
                                 var day_$fieldname   = parseInt(d[1]*1)
                                 sumdate = year_$fieldname + month_$fieldname + day_$fieldname

                                 if (sumdate == 0) {
                                     alert(month_$fieldname + ' ' + day_$fieldname + ' ' + year_$fieldname + ' is not a valid date...')
                                     return false;
                                 }
                                 if (DateValidate(day_$fieldname,month_$fieldname,year_$fieldname) == false) {
                                     //alert(frm.$fieldname.value + ' is not a valid date')
                                     alert(month_$fieldname + ' ' + day_$fieldname + ' ' + year_$fieldname + ' is not a valid date')
                                     return false
                                 }
                                 ";
                        }
		} elseif ($vrule == "valid_extension") {
			$exts = $this->_GetSetting($config["extensions"],array("jpg","gif"));
			$alert = ($warning != "") ? "'$warning'" : "filename + ' is not allowed to be uploaded'";

			$numexts = count($exts);
			if ($numexts !=0) {
				$array_exts = "\"".join("\",\"",$exts)."\"";
			}

			print "
				var array_exts = new Array($array_exts);				
				var filename = frm.$fieldname.value;
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
						//alert(filename + ' is not allowed to be uploaded');
                                                alert($alert)
                                                return false;
					}
				} else {
					alert($alert);
					return false
				}
				} //if a file is uploaded
				";
		}
		} //for each rule
	}
		
	print "
	if (msg != '') {
           btn.value = msg;
        }
        frm.submit(); } ";

        print "</script>";
} //GenerateValidation()


function ProcessDelete($config,$act) {

        $keyvarname     = $this->_GetSetting($config["keyvarname"],"keyid");

	$keyid		= $this->GetVar($keyvarname,"");
	$keyid2		= $this->GetVar("keyid2","");
	$referrer	= $this->GetVar("referrer","");
	$whendone	= $this->_GetSetting($config["whendone"],"show_message");
	$nocancel       = $this->GetVar("nocancel",0);
	$nocmsmenu      = $this->GetVar("nocmsmenu",0);
	$database	= $this->_GetSetting($config["database"],"");
	$table		= $this->_GetSetting($config["table"],"");
	$header		= $this->_GetSetting($config["header"],"");
	$confirmfields	= $this->_GetSetting($config["confirmfields"],array());
	$primarykey	= $this->_GetSetting($config["primarykey"],"");
	$primarykey2	= $this->_GetSetting($config["primarykey2"],"");
	$fields		= $this->_GetSetting($config["fields"],array());
	$logaction	= $this->_GetSetting($config["logaction"],$this->logaction);
	$log_delstr	= $this->_GetSetting($config["logstring"]["delete"],"A record with id $keyid in table $table deleted.");
	$donemessage	= $this->_GetSetting($config["donemessage"],"");
        $preprocess     = $this->_GetSetting($config["preprocess"],"");
        $preprocessonly = $this->_GetSetting($config["preprocessonly"],false);
        $afterprocess   = $this->_GetSetting($config["afterprocess"],"");
	$afterdelete	= $this->_GetSetting($config["afterdelete"],"");
	$clr_columntext1= $this->_GetSetting($config["clr_columntext1"],"");
	$clr_columntext2= $this->_GetSetting($config["clr_columntext2"],"");
	$clr_formcolumn1= $this->_GetSetting($config["clr_formcolumn1"],"");
	$clr_formcolumn2= $this->_GetSetting($config["clr_formcolumn2"],"");


	if ($primarykey2 != "") {
		$condition 	= " $primarykey='$keyid' and $primarykey2='$keyid2' " ;
		$delcond	= " and keyid2='$keyid2' ";
	} else {
		$condition = " $primarykey='$keyid' ";
		$delcond	= " ";
	}

	$sql = "select * from $table where $condition";

	if (count($confirmfields) == 0) {
	        $fields = $this->GetFields($sql);
		$info   = $this->GetArrayValues($sql,$fields,$database);
		$field1 = $info[0];
		$field2 = $info[1];
		$label1 = $this->FormatLabel($fields[0]);
		$label2 = $this->FormatLabel($fields[1]);
		$data	= "
			<tr><td width=100 bgcolor=$clr_formcolumn1><font color=$clr_columntext1>$label1</font></td>
			<td bgcolor=$clr_formcolumn2><font color=$clr_columntext2>$field1</font></td></tr>
			<tr><td  bgcolor=$clr_formcolumn1><font color=$clr_columntext1>$label2</font></td>
			<td bgcolor=$clr_formcolumn2><font color=$clr_columntext2>$field2</font></td></tr>";

	} else {
		$info	  = $this->GetArrayValues($sql,$confirmfields,$database);
		$data   = "";
		for ($i=0;$i < count($confirmfields);$i++) {
			$fieldname = $confirmfields[$i];
			$fieldvalue= $info[$fieldname];
			$data .= "
			<tr><td width=100 bgcolor=$clr_formcolumn1>".$this->FormatLabel($fieldname)."</td>
			<td bgcolor=$clr_formcolumn2><font color=$clr_columntext2>$fieldvalue</font></td></tr>";
		}

		if ($this->_AnyUpload($fields) === true) {
			$data .= "<tr><td colspan=2>This will delete any file(s) and picture(s) related to this records</td></tr>";
		}
	}

        $preprocess_msg = "";
        if ($preprocess != "") {
            $preprocess_msg = call_user_func($preprocess);
        }
        if ($preprocessonly == true) {
            exit;
        }

        $cancelbutton  = ($nocancel == 1)  ? "" : "<input class=cms_button type=button onClick=\"history.go(-1);\" value=\" Cancel \">";
        $cmsmenuoption = ($nocmsmenu == 0) ? "" : "<input type=hidden name=nocmsmenu value=1>";


	if ($act == "delete") {
	        $messagetitle = "DELETE?";
		$confirmation = "Delete the following record?<br>$preprocess_msg";
		$confirmation .= "<br><table width=100% cellpadding=3 cellspacing=3>$data</table><br>";
		$link = "<input type=hidden name=$keyvarname value=\"$keyid\">
			<input type=hidden name=keyid2 value=\"$keyid2\">
			<input type=hidden name=act value=deleteconfirm>
			<input type=hidden name=referrer value=\"$afterdelete\">
			$cmsmenuoption
			$cancelbutton
			<input type=submit class=cms_button value=\"Delete\">";
		if ($donemessage != "") {
		  $message = preg_replace(array("|%%MESSAGETITLE%%|","|%%MESSAGE%%|","|%%MESSAGELINK%%|"),array($messagetitle,$confirmation,$link),$donemessage);
		} else {
		  $message = $this->MessageBox($messagetitle,$confirmation,$link);
  		}
  		print "$header<form name=confirm>$message</form>";
	} elseif ($act == "deleteconfirm") {
		if ($keyid2 != "") {
			$additionalkey = " and $primarykey2='$keyid2'";
		} else {
			$additionalkey = "";
		}

		//Check if some uploads or pics are related. If any related then remove them as well

		if ($this->_AnyUpload($fields) === true) {
			$sql = "select * from $this->tbl_picture where tablename='$table' and keyid='$keyid' $delcond ";

			$array_ids = $this->GetArrayRows($sql,array("id","filename","tablename","keyid","fieldname"),$database);

			for ($i=0; $i<count($array_ids); $i++) {
				$picture_id = $array_ids[$i][0];
				$this->DeletePictures($picture_id,$database);
			}

			$sql = "select * from $this->tbl_uploads where tablename='$table' and keyid='$keyid' $delcond ";
			$array_ids = $this->GetArrayRows($sql,array("id","filename","tablename","keyid","fieldname"),$database);

			for ($i=0; $i<count($array_ids); $i++) {
				$file_id = $array_ids[$i][0];
				$this->DeleteFiles($file_id,$database);
			}
		}
		//print $sql;

		if ($referrer == "") {
		    $referrer = "?";
		}

		$sql 	= "delete from $table where $primarykey='$keyid' $additionalkey";
		$this->RunSql($sql,$database);

		$messagetitle	= "DELETED";
		$message 	= "Data has been deleted";
		$link 		= "<a href=\"$referrer\">LIST</a>";
		//print "$header<br>".$this->MessageBox("DELETED","Data has been deleted","<a href=\"$referrer\">LIST</a>");

		if ($donemessage != "") {
		  $message = preg_replace(array("|%%MESSAGETITLE%%|","|%%MESSAGE%%|","|%%MESSAGELINK%%|"),array($messagetitle,$message,$link),$donemessage);
		} else {
		  $message = $this->MessageBox($messagetitle,$message,$link);
  		}
  		print "$header<form name=confirm>$message</form>";

		if ($logaction == true) {
			$this->InsertLog($log_delstr,$database);
		}
	//print $sql;
	}

		if ($afterprocess != "") {
            call_user_func($afterprocess);
        }
} //ProcessDelete()


function _AnyUpload(&$fields) {
	$anyupload = 0;
	while (list($fieldname,$value) = each($fields)) {
		if (is_numeric($fieldname)) {
			$fields[$value] = array();
		} else {
			if (isset($value["type"])) {
				if (($value["type"] == "upload") || ($value["type"] == "file")) {
					$anyupload++;
				}
			}
		}
	}
	if ($anyupload > 0) {
		return true;
	} else {
		return false;
	}
} //_AnyUpload()


function _GetSelection($query,$fieldname,$method="get") {
	if ($method == "get") {
		$tmp = $this->GetJSArray($query,$fieldname);
		$field_value = join("|",$tmp);
	} else {
		$tmp = $this->GetVar($fieldname);
		if (is_array($tmp)) {
			$field_value = join("|",$tmp);
		} else {
			$field_value = $tmp;
		}
	}
	return urldecode($field_value);
} //_GetSelection()


function ProcessAddEdit($config,$act) {
	global $QUERY_STRING, $HTTP_POST_VARS;
        $keyvarname     = $this->_GetSetting($config["keyvarname"],"keyid");
	$keyid		= $this->GetVar($keyvarname,"");
	$keyid2		= $this->GetVar("keyid2","");
	$referrer	= $this->GetVar("referrer","act=show");

	$database	= $this->_GetSetting($config["database"],"");
	$method		= $this->_GetSetting($config["method"],"post");
	$table		= $this->_GetSetting($config["table"],"");
	$picturetable   = $this->_GetSetting($config["picturetable"],$this->tbl_picture);
	$fields		= $this->_GetSetting($config["fields"],array());
	$header		= $this->_GetSetting($config["header"],"");
	$primarykey	= $this->_GetSetting($config["primarykey"],"");
	$primarykey2	= $this->_GetSetting($config["primarykey2"],"");
	$keycreation	= $this->_GetSetting($config["keycreation"],"autonumber");
	$allfields	= $this->_GetSetting($config["allfields"],false);
	$logaction	= $this->_GetSetting($config["logaction"],$this->logaction);
	$log_addstr	= $this->_GetSetting($config["logstring"]["saveadd"],"A new record was added in table $table.");
	$log_editstr	= $this->_GetSetting($config["logstring"]["saveedit"],"A record with id $keyid in table $table was edited.");
	$printsql	= $this->_GetSetting($config["printsql"],false);
	$whendone	= $this->_GetSetting($config["whendone"],"show_message");
	$preprocess	= $this->_GetSetting($config["preprocess"],"");
	$preprocessonly	= $this->_GetSetting($config["preprocessonly"],false);
	$afterprocess   = $this->_GetSetting($config["afterprocess"],"");
	$donemessage	= $this->_GetSetting($config["donemessage"],"");
	$nextaction     = $this->_GetSetting($config["nextaction"],"");
        $allstriptags   = $this->_GetSetting($config["allstriptags"],false);
	$referrer	= $this->_GetSetting($config["referrer"],"act=show");

	//if no fields are set or allfields are true, then use all fields
	if ((count($fields) == 0) || ($allfields == true)) {
		$tmp = $this->GetFields("select * from $table",$database);
		for($i = 0; $i < count($tmp); $i++) {
			$fieldname = $tmp[$i];
			$tmpfields[$fieldname] = array($fieldname,array());
		}
	}

	if ($allfields == true) {
		$mergefields = array_merge($tmpfields,$fields);
		$fields = $mergefields;
	} else {
		if (count($fields) == 0) {
			$fields = $tmpfields;
		}
	}

	$process_upload = false;
	$process_file	= false;
	$upload_file	= array();
	$upload_list	= array();
	$savename_list	= array();
	$keyvalues	= array();
	$arfind		= array();
	$arreplace	= array();

	while (list($fieldname,$values) = each($fields)) {

	      	$type		= $this->_GetSetting($values["type"],"text");
		$dbfield	= $this->_GetSetting($values["dbfield"],true);
		$rule		= $this->_GetSetting($values["validate"],array());
		$alias		= $this->_GetSetting($values["alias"],$fieldname);
		$viewformat	= $this->_GetSetting($values["viewformat"],"");
		$saveformat	= $this->_GetSetting($values["saveformat"],"");
		$savename	= $this->_GetSetting($values["savename"],"");
		$extensions	= $this->_GetSetting($values["extensions"],array());
		$striptags	= $this->_GetSetting($values["striptags"],$allstriptags);
		$allowedtags	= $this->_GetSetting($values["allowedtags"],$this->allowedtags);

		if (!is_array($rule)) 	$rule = array($rule);
		if ($type == "upload") 	{
			$process_upload = true;
			array_push($upload_list,$fieldname);
			array_push($savename_list,$fieldname);
		}
		if ($type == "file") {
			$process_file = true;
			array_push($upload_file,$fieldname);
		}

		if (($dbfield != false) && ($type!="upload") && ($type!="file")) {
		if (($type == "dateselect") || ($type == "datetimeselect") || ($type == "monthyearselect")) {
			if ($type == "dateselect") {
				$field_value = $this->GetVarDate($fieldname,"dateselect");
			} elseif ($type == "datetimeselect") {
				$field_value = $this->GetVarDate($fieldname,"datetimeselect");
			} elseif ($type == "monthyearselect") {
				$field_value = $this->GetVarDate($fieldname,"monthyearselect");
			}
		} elseif (($type == "checkboxes") || ($type == "checkbox") || ($type == "multiselect")) {
			if (isset($fieldname)) {
				$field_value = $this->_GetSelection($QUERY_STRING,$fieldname,$method);
			} else {
				$field_value = "";
			}
		} elseif ($type == "advtextarea") {
			$convertbr	 = $this->GetVar("convertbr_$fieldname","off");
			if ($convertbr == "on") {
				$field_value = $this->ProcessBR($this->GetVar($fieldname),"save");
			} else {
				$field_value = $this->GetVar($fieldname);
			}
		} elseif ($type == "datetime_autoupdate") {
			$field_value = $this->CurrentTime();
		} elseif ($type == "date_autoupdate") {
			$field_value = $this->CurrentDate();
  		} elseif ($type == "datetime_creation") {
  		        $field_value = $this->CurrentTime();
  		} elseif ($type == "timestamp_creation" || $type == "timestamp_autoupdate") {
  		        $field_value = $this->GenerateID('',false);
                } elseif ($type == "spaw") {
                        $field_value = $this->GetVar($fieldname);
                } elseif ($type == "datepop") {
                        $dateval = $this->GetVar($fieldname);
                        $d       = split("/",$dateval);
                        $field_value = @$d[2]."-".@$d[0]."-".@$d[1];
                } else {
			$field_value = $this->GetVar($fieldname);
		}

		//if some formatting is required

		if ($saveformat == "") {
			$field_value = $this->FieldFormat($field_value);
		} else {
			$field_value = $this->FieldFormat($field_value,$saveformat);
		}

		if ($striptags == true) {
		   	$field_value = strip_tags($field_value,$allowedtags);
		}

		//this is to fix array-type value resulting from radio selection
		//radio selection changed to array input so that it's compatible to js validation
		if (is_array($field_value)) {
			$field_value = join("|",$field_value);
		}

		//store values into assoc array but check whether automatic id generation is needed
		if ($fieldname == $primarykey) {
			if ($act == "saveadd") {
				if ($keycreation == "autonumber") {
					$keyvalues[$fieldname] = "_autonumber_";
				} elseif ($keycreation == "timestamp") {
					$keyvalues[$fieldname] = $this->GenerateID('');
				} elseif ($keycreation == "timestamp2") {
					$keyvalues[$fieldname] = $this->GenerateID('',true);
				} else {
					$keyvalues[$fieldname] = $this->GetVar($fieldname);
				}
			} else {
				$field_value = $this->GetVar($fieldname);
				$keyvalues[$fieldname] = $field_value; //$this->GetVar($fieldname);
			}
		} else {
			$keyvalues[$fieldname] = $field_value;
		}

		//after getting the field_value, check if such value is unique

		for($i = 0; $i < count($rule); $i++) {

		$vrule = $rule[$i];
		if (($vrule == "valid_unique") || ($vrule == "unique_value")) {
			$checksql = "select * from $table where $fieldname = '".$this->GetVar($fieldname)."' ".
				    "and $primarykey != '$keyid'";
			$existkey = $this->GetValue($checksql,$primarykey);
			if ($existkey != "") {
				print $this->MessageBox("DATA NOT UNIQUE","$field_value already exists in record id $existkey.
				<br> Field $alias must contain a unique value.","GOBACK:Return");
				return;
			};
		}
		}
		} //if dbfield is true

		//as of 719 a new type is added. Creation time is created upon a record is made
		//the value is not changing on updates

		if ($act != "saveadd") {
		if ($type == "datetime_creation" || $type == "timestamp_creation") {
		   unset($keyvalues[$fieldname]);
		}
  		}
	}

	//this will preprocess the value before being saved or updated
	if ($preprocess != "") {
	    $keyvalues = call_user_func($preprocess,$keyvalues);
	}
	//this will block this process from proceeding
	if ($preprocessonly == true) {
	    exit;
	}

	if ($this->ServerValidation($config,$keyvalues) == false) {
	    exit;
	};

	$list	= "<a href=\"?$referrer\">LIST</a>";
	if ($act == "saveadd") {
		if ($keycreation == "autonumber") {
			unset($keyvalues[$primarykey]);
		}
		$fieldlist = join(", ",array_keys($keyvalues));

                reset($keyvalues);
                $valuelist = "";
                while (list($key,$value) = each($keyvalues)) {
                      $valuelist .= $this->FormatSqlData($value).",";
                }
                $valuelist = $this->StripWrapper($valuelist,',');
                //$valuelist = "'".join("', '",array_values($keyvalues))."'";

		$sql = "insert into $table ($fieldlist) values ($valuelist)";

		$this->RunSql($sql,$database);
		$lastid = $this->insert_id;

		if ($printsql == true ) {
			print $sql;
		}
		//if keycreation is autonumber, overwrite the value with mysql_insert_id

		if ($keycreation == "autonumber") {
			$keyvalues[$primarykey] = $lastid;
		}

		if ($this->numrecs > 0) {
			$msgboxtitle	= "SUCCESS";
			$msgboxmessage	= "New record has been added";
			if ($logaction == true) {
				$logtranslated	= $this->_Tag2Values($log_addstr,$keyvalues,false);
				$this->InsertLog($logtranslated,$database);
			}

		} else {
			$msgboxtitle	= "NO NEW DATA ADDED";
			$process_upload	= false;
			$msgboxmessage	= "No new data has been added.";
		}
	} elseif ($act == "saveedit") {
		$updatelist = array();
		$numfields = count($keyvalues);
		reset($keyvalues);
		while(list($key,$value) = each($keyvalues)) {
			if ($key != $primarykey) {
				if (is_array($value)) {
				   $value = join("|",$value);
				}
				array_push($updatelist,"$key = ". $this->FormatSqlData($value));
			} else {
				if ($keycreation == "none") {
				   array_push($updatelist,"$key = ". $this->FormatSqlData($value));
				}
			}
		}

		if ($primarykey2 != "") {
			$additionalkey = " and $primarykey2='$keyid2' ";
		} else {
			$additionalkey = "";
		}

		$sql = "update $table set ".join(",",$updatelist)." where $primarykey = '$keyid' $additionalkey";

		if ($printsql == true) {
			print $sql;
		}

		$this->RunSql($sql,$database);
		if ($this->numrecs > 0) {
			$msgboxtitle	= "SUCCESS";
			$msgboxmessage	= "Data has been updated";
			if ($logaction == true) {
				$logtranslated	= $this->_Tag2Values($log_editstr,$keyvalues,false);
				$this->InsertLog($logtranslated);
			}
		} else {
			$msgboxtitle	= "NO UPDATE";
			$msgboxmessage	= "No changes has been updated to the record";
		}
	}

	if ($process_file == true) {
		global $GS, $HTTP_POST_FILES, $DOCUMENT_ROOT, $REMOTE_ADDR;

		if ($act == "saveadd") {
			$keyid = $lastid;
		}

		$filetodels = $this->GetVar("filetodel",array());
		if (count($filetodels) > 0) {
			$this->DeleteFiles($filetodels,$database);
		}

		for ($i=0;$i < count($upload_file); $i++) {
			$fieldname	= $upload_file[$i];
			$tmpfile	= $HTTP_POST_FILES["$fieldname"]['tmp_name'];
			$filename	= $HTTP_POST_FILES["$fieldname"]['name'];
			$filesize	= $HTTP_POST_FILES["$fieldname"]['size'];
			$destpath	= $this->GetVar($fieldname."_uploadpath",$this->uploadpath);
			$description    = $this->GetVar($fieldname."_description","$filename");
                        $extension	= $this->GetExtension($filename);
			$savename	= $this->ValidateFilename($filename);
			$tbl_uploads	= $this->tbl_uploads;
			$onefileonly	= $this->GetVar($fieldname."_onefileonly",0);

			if (($filename != "") && ($filesize != 0)) {
          			if (count($extensions)!=0) {
          				if (!in_array($extension,$extensions)) {
          				     $msgboxmessage .= "
          					<br><br>$filename has an invalid type.
          					<br>Such file is not allowed to be uploaded. ";
          				}
          			}

				$date = $this->CurrentTime();

				$destfile	= "$DOCUMENT_ROOT/$destpath/$savename";

				if (file_exists($destfile)) {
					$filename_part = $this->StripWrapper($savename,".$extension");
					$ts = $this->ValidateFilename($this->CurrentTime(),false);
					$newsavename = "$filename_part"."_"."$ts.$extension";
					$destfile = "$DOCUMENT_ROOT/$destpath/$newsavename";
					$savename = $newsavename;
				}

				if ($onefileonly == 1) {
			 		$sqldel = "
			 			delete from $tbl_uploads
			 			where tablename='$table' and fieldname='$fieldname' and
			 			keyid='$keyid' and keyid2='$keyid2'";
			 		$this->RunSql($sqldel,$database);
			 	}

				$sql = "insert into $tbl_uploads (description,filename,originalname,filesize,tablename,fieldname,lastupdate,path,keyid,keyid2,sender) ".
					"values ('$description','$savename','$filename','$filesize','$table','$fieldname','$date','$destpath','$keyid','$keyid2','$REMOTE_ADDR')";
				$this->RunSql($sql,$database);

				copy($tmpfile,$destfile);
                               
                                if (eregi("NO NEW DATA ADDED",$msgboxtitle)) {
                                        $msgboxtitle = "PARTIALLY SUCCESSFUL";
                                }


				$msgboxmessage .= "
					<br><br>File: <b>$filename</b> (Size: $filesize bytes)
					<br> has beed added and saved as
					<br><a href=/$destpath/$savename><b>$savename</b></a>
					<br>";
			} else {
			        if ($filename != "") {
                                   if ($filesize == 0) {
                                       $msgboxmessage .= "
                                            <br><br>Failed to save file: <font color=red><b>$filename.</b></font><br>
                                            probably file is larger than the maximum upload size allowed. <br>";
                                   } else {
                                       //
                                   }
			        }
                        }
		}
	}

	if ($process_upload == true) {
		global $GS, $HTTP_POST_FILES, $DOCUMENT_ROOT;

		for ($i=0;$i < count($upload_list); $i++) {

			$fieldname 	= $upload_list[$i];
			$userthumb      = $fieldname."_userthumb";
			$tmpfile	= $HTTP_POST_FILES["$fieldname"]['tmp_name'];
			$filename	= $HTTP_POST_FILES["$fieldname"]['name'];
			$filesize	= $HTTP_POST_FILES["$fieldname"]['size'];
			$originalname   = $filename;

			$destpath	= $this->GetVar($fieldname."_imgpath","");
			$thumbpath	= $this->GetVar($fieldname."_thumbpath","");
			$savename	= $this->GetVar($fieldname."_savename","");
			$thumbname	= $this->GetVar($fieldname."_thumbname","");
			$curimage	= $this->GetVar($fieldname."_curimage","");
			$curthumb	= $this->GetVar($fieldname."_curthumb","");
			$fileop		= $this->GetVar($fieldname."_fileop","keep");
			$resample	= $this->GetVar($fieldname."_resample","fixed");
			$showpicture	= $this->GetVar($fieldname."_showpicture","from_file");
			$onepiconly	= $this->GetVar($fieldname."_onepiconly",0);
			$title          = $this->GetVar($fieldname."_title","");
			$description	= $this->GetVar($fieldname."_description","");


			if ($savename == "") {
				$savename = $filename;
			} else {
				$savename = $savename . "." . $this->GetExtension($filename);
			}

			if ($thumbname == "") {
				$thumbname = $filename;

			} else {
				$thumbname = $thumbname . "." . $this->GetExtension($filename);
			}

			$savename	= $this->_Tag2Values($savename,$keyvalues);

			$thumbname	= $this->_Tag2Values($thumbname,$keyvalues);
			$savename	= $this->ValidateFilename($savename);
			$thumbname	= $this->ValidateFilename($thumbname);

			if ($fileop == "delete") {
				$thtodel	= "$DOCUMENT_ROOT/$curthumb";
				$filetodel	= "$DOCUMENT_ROOT/$curimage";

				if (file_exists($filetodel)) {
					unlink($filetodel);
				}
				if (file_exists($thtodel)) {
					unlink($thtodel);
				}
				$filename 	= "";
			}

			//only process bulk deletion on the first loop
			if ($i == 0) {
				$pictodels = $this->GetVar("pictodel",array());
				if (count($pictodels) > 0) {
					$this->DeletePictures($pictodels,$database);
				}
			}

			if ($filename != "") {
				if ($act == "saveadd") {
					$keyid = $lastid;
				}

			$ext = $this->GetExtension($filename);
			$allowed_exts = array("jpeg","jpg");

			if (in_array($ext,$allowed_exts)) {
			if ($showpicture == "from_file") {
				$destfile = "$DOCUMENT_ROOT/$destpath/$savename";

				copy($tmpfile,$destfile);
				$msgboxmessage .= "
					<br><br>Picture file: $filename
					<br> (Size: $filesize bytes)
					<br> has beed added and saved as
     				        <br> <a href=/$destpath/$savename>$savename</a> <br>";
				$thumbmsg 	= "";
				$thumb 		= $this->GetVar($fieldname."_thumbnail","on");
				$createthumbnail= $this->GetVar($fieldname."_createthumbnail",1);
				$thumbwidth 	= $this->GetVar($fieldname."_thumbwidth",0);
				$thumbheigth	= $this->GetVar($fieldname."_thumbheigth",0);
				//print "$resample: $thumbheigth - $thumbwidth";
				if ($thumb == "on") {
					list($sw,$sy) = $this->SampleSize($destfile,$thumbwidth,$thumbheigth,$resample);

					$ext = $this->GetExtension($savename);

					if ($this->CreateThumbnail($destfile,$thumbname,$thumbpath,$ext,$sw,$sy) == true) {
						$msgboxmessage .= "
							<br><br>Thumbnail has also been generated successfully
							<br>and saved as $thumbname";
					};
			 	};

			} elseif ($showpicture == "from_db") {  //global $HTTP_POST_VARS;
			                                     	//$this->pre($HTTP_POST_VARS); exit;
			        $filename	= $this->ValidateFilename($filename);
                                $userthumbname  = @$HTTP_POST_FILES["$userthumb"]['name'];

				//check first if file of the same name already exists in the db

				$filecheck = $this->GetFilename($filename,false);
				$sql 	   = "select count(*) as total from $picturetable where filename like '$filecheck"."_%' and path='$destpath'";
				$found     = $this->GetValue($sql,"total");

				//print "<hr>$found - $sql<hr>";
				if ($found == 0) {
					$picnum = "1";
				} else {
					$picnum = $found+1;
				}

				$filename 	= $this->GetFilename($filename,false)."_".$picnum.".".$this->GetExtension($filename);
				$destfile	= "$DOCUMENT_ROOT/$destpath/$filename";
				$thumbname	= "tn_$filename";

				copy($tmpfile,$destfile);

				$msgboxmessage 	.= "
						<br><br>Picture file: $filename
						<br> (Size: $filesize bytes)
						<br> has beed added and saved as
						<br> <a href=/$destpath/$filename>$filename</a> <br>";
				$thumb 		= $this->GetVar($fieldname."_thumbnail","");
				$createthumbnail= $this->GetVar($fieldname."_createthumbnail",1);
				$thumbwidth 	= $this->GetVar($fieldname."_thumbwidth",0);
				$thumbheigth 	= $this->GetVar($fieldname."_thumbheigth",0);

				@list($sw,$sy,$ori_w,$ori_y) = $this->SampleSize($destfile,$thumbwidth,$thumbheigth,$resample);
                                //print "<h1>$createthumbnail -- $thumb </h1>";
                                //if (($createthumbnail == '1') && ($thumb == "on")) {
  				if ($createthumbnail == '1') {
                                     $ext = $this->GetExtension($filename);
  				     if ((strlen($userthumbname) > 0) && ($thumb != "on")) {
                                           $tmpfile      = $HTTP_POST_FILES["$userthumb"]['tmp_name'];
                                           $thumbname    = "$DOCUMENT_ROOT/$thumbpath/".basename($userthumbname);
                                           if (file_exists($thumbname)) {
                                              $thumbname = "$DOCUMENT_ROOT/$thumbpath/".$this->GetFilename($thumbname,false)."_".time().".".$this->GetExtension($thumbname);
                                           }
                                           //print $userthumbdest;
                                           if (copy($tmpfile,$thumbname)) {
                                              $thumbname      = basename($thumbname);
                                              $msgboxmessage .= "
                                              <br><br>User thumbnail has been saved successfully
                                              <br>and saved as $thumbname";
                                           };

                                     } else {
                                           if ($this->CreateThumbnail($destfile,$thumbname,$thumbpath,$ext,$sw,$sy) == true) {
                                              $msgboxmessage .= "
      					      <br><br>Thumbnail has also been generated successfully
      					      <br>and saved as $thumbname";
      				            };
      			             }
			 	} else {
		 		        $thumbname = "";
			 		$thumbpath = "";
			 	};

			 	if ($onepiconly == 1) {
			 		$sqldel = "
			 			delete from $picturetable
			 			where tablename='$table' and fieldname='$fieldname' and
			 			keyid='$keyid' and keyid2='$keyid2'";
			 		$this->RunSql($sqldel,$database);
			 	}

				$date = $this->CurrentTime();
				$sql  = "insert into $picturetable (filename,originalname,title,description,thumbname,thumbpath,filesize,tablename,fieldname,lastupdate,path,keyid,keyid2,width,height) ".
					"values ('$filename','$originalname','$title','$description','$thumbname','$thumbpath','$filesize','$table','$fieldname','$date','$destpath','$keyid','$keyid2','$ori_w','$ori_y')";
				$this->RunSql($sql,$database);

				//print $sql;
			}
			} else {
				$msgboxmessage .= "
					<br><br>$filename cannot be uploaded. Invalid type of picture.<br><br>";
			}//if not valid extension
			}//if filename
		}//for
	}//if upload

	if ($afterprocess != "") {
	    $submitvalue = $this->GetVar("btn_custom");
            $keyvalues = call_user_func($afterprocess,$keyvalues,$submitvalue);
	}

	//now decide what to do after a process                    is complete
	if (eregi("to_referrer",$whendone)) {
		header("location: ?$referrer");
	} elseif (eregi("forward_to ",$whendone)) {
		$forwards = split(" ",$whendone);
		//$url = preg_replace("|%%$primarykey%%|",$keyid,$forwards[1]);
		$url = $this->_Tag2Values($forwards[1],$keyvalues,false);
		$key = "%%SAFEKEY_$primarykey%%";
		$val = $keyvalues[$primarykey];
		$x   = md5($val.$this->sitekey);
                $url = str_replace($key,$x,$url);
                //print $url;
		header("location: $url");
	} else {
	       	if ($donemessage == "") {
			$message = $this->MessageBox($msgboxtitle,$msgboxmessage,$list);
			print "$header $message";
		} else {
		       	$donemessage = preg_replace(array("|%%MESSAGETITLE%%|","|%%MESSAGE%%|","|%%MESSAGELINK%%|"),array($msgboxtitle,$msgboxmessage,$list),$donemessage);
		        print "$header $donemessage";
		}

	}
} //ProcessAddEdit()

function DeleteFiles($listids,$database = '') {
	if (is_array($listids)) {
		$numids = count($listids);
		for ($i=0; $i < $numids; $i++ ) {
			$id = $listids[$i];
			$this->_DeleteFiles($id,$database);
		}
	} else {
		$this->_DeleteFiles($listids,$database);
	}
} //DeleteFiles()


function DeletePictures($listids,$database = '') {
	if (is_array($listids)) {
		$numids = count($listids);
		for ($i=0; $i < $numids; $i++ ) {
			$id = $listids[$i];
			$this->_DeletePictures($id,$database);
		}
	} else {
			$this->_DeletePictures($listids,$database);
	}
} //DeletePictures()



function _DeleteFiles($id,$database = '') {
	global $DOCUMENT_ROOT;

	$fields	= array("filename","path");
	$files 	= $this->GetArrayValues("select * from ".$this->tbl_uploads." where id='$id'",$fields,$database);
	$filename	= $files["filename"];
	if ($files["filename"] != "") {

		$path 	= $files["path"];

		$filetodel 	= "$DOCUMENT_ROOT/$path/$filename";
		if (file_exists($filetodel)) {
			unlink($filetodel);
		}
		$sql = "delete from ".$this->tbl_uploads." where id='$id'";
		$this->RunSql($sql,$database);
	}
} //_DeleteFiles()


function _DeletePictures($id,$database = '') {
	global $DOCUMENT_ROOT;

	$fields	= array("filename","path","thumbpath");

	$pictures 	= $this->GetArrayValues("select * from ".$this->tbl_picture." where id='$id'",$fields,$database);
	$filename	= $pictures["filename"];
	if ($pictures["filename"] != "") {
		$path 		  = $pictures["path"];
		$thumbpath 	  = $pictures["thumbpath"];
		$filetodel 	  = "$DOCUMENT_ROOT/$path/$filename";
		$thumbtodel	  = "$DOCUMENT_ROOT/$thumbpath/tn_$filename";

		if (file_exists($filetodel)) {
			unlink($filetodel);
		}
		if (file_exists($thumbtodel)) {
			unlink($thumbtodel);
		}
		$sql = "delete from ".$this->tbl_picture." where id='$id'";
		$this->RunSql($sql,$database);
	}
} //_DeletePictures()


function ProcessBR($content,$action = "") {
	if ($action == "edit") {
		$content	= @htmlentities(stripslashes($content));
		//$content	= str_replace("&lt;br&gt;","&lt;br&gt;\r\n",$content);
		$content	= str_replace("&lt;br&gt;","\r\n",$content);
	} elseif ($action == "save") {
		$content 	= str_replace("<br>\r\n","<br>",$content);
		$content 	= str_replace("\r\n","<br>",$content);
		$content 	= str_replace("\r","",$content);			
	}
	return $content;
} //ProcessBR()


function GetCheckboxes($cb_items,$cb_selected,$name,$method,$layout = "multicolumn 1",$textcolor="black",$valuepair="key_value") {
         //as of 728, the key value is used instead of value value
         //I dont know what was I thinking to once set to value value instead of keyvalue
	$layout    = split(" ",$layout." 1");
	if ($layout[0] == "multicolumn") {
	$numcolumn = $layout[1];
	} else { $numcolumn = 1; }
        $rownum    = 1;
	$content   = "<table border=0 cellpadding=1><tr>";
	while(list($key,$value) = each($cb_items)) {
		$item = $key;
		if ($valuepair == "value_value") {
		   $item = $value;
		   $key  = $value;
                }
		if (is_array($cb_selected)) {
			$ischecked = (in_array($item,$cb_selected)) ? "checked" : "";
		} else {
			$ischecked = ($cb_selected == $item) ? "checked" : "";
		}
		$varsuffix = ($method == "get") ? "" : "[]";
		$content .= "<td><input class=checkbox type=checkbox name=$name"."$varsuffix value=\"$key\" $ischecked><font color=$textcolor>$value</font></td>";
		if (($rownum % $numcolumn == 0)) $content .= "</tr><tr>";
		$rownum++;
	}
	$content .= "</tr></table>";
	return $content;
} //GetCheckboxes()


function GetVarDate($varname,$datetype = "dateselect") {
	$year 	= $this->GetVar($varname."_year",0);
	$month	= $this->GetVar($varname."_month",0);
	$date	= $this->GetVar($varname."_date",0);
	$hour	= $this->GetVar($varname."_hour",0);
	$minute	= $this->GetVar($varname."_min",0);
        $datevalue = $this->BuildDate($year,$month,$date,$hour,$minute);
	return $datevalue;

} //GetVarDate()

function BuildDate($year,$month,$date,$hour="00",$minute="00",$showtime=true) {
         $time = ($showtime == true) ? " ".$hour.":".$minute.":00"  : "";
         if ($this->databasetype == "mysql") {
             return $year."-".$month."-".$date.$time;
         } elseif ($this->databasetype == "mssql") {
             return $month."/".$date."/".$year.$time;
         } elseif ($this->databasetype == "oracle") {
             return $month."/".$date."/".$year.$time;
         }
} //BuildDate

function SampleSize($source,$maxwidth=0,$maxheight=0,$resample="fixed") {

        if (($resample == "fixed") && (($maxwidth != 0) || ($maxheight != 0))) {
            return array($maxwidth,$maxheight,$sw,$sy);
        }

	$size = getimagesize($source);
	$sw = $size[0];
	$sy = $size[1];

	//this is to determine which dimension is the longest

	//if the parameter is maxdimension, pass the value here first

	if ($resample == "maxdimension") {
		$thelongest = ($sw > $sy) ? "sw" : "sy";
		if ($thelongest == "sw") {
			$maxheight = 0;
		} else {
			$maxwidth = 0;
		}
		$resample = "fixed";
	}

	if ($resample == "fixed") {
	//if all parameters are 0 then just return the height and width
	if (($maxwidth == 0) && ($maxheight == 0)) {
		return array($sw,$sy);
	}

	//fix width sample size
	if (($maxwidth != 0) && ($maxheight == 0)) {
		$factor = $maxwidth / $sw;
		$newsw  = $maxwidth;
		$newsy  = ceil($sy * $factor);
		return array($newsw,$newsy,$sw,$sy);
	}

	//fix height sample size

	if (($maxwidth == 0) && ($maxheight != 0)) {
		$factor = $maxheight / $sy;
		$newsw  = ceil($sw * $factor); 
		$newsy  = $maxheight;
		return array($newsw,$newsy,$sw,$sy);
	}

	//fix width and height sample size

	if (($maxwidth != 0) && ($maxheight != 0)) {
		return array($maxwidth,$maxheight,$sw,$sy);
	}
	}

} //SampleSize()


function PlainMessage($message) {
	return $this->MessageBox('',$message,'',false);
} //PlainMessage()



function MessageBox($title='',$message='',$link='',$formatted=true) {
	global $GS;

	$clr_msgboxhead	= $GS["clr_msghead"];
	$clr_msgboxtitle= $GS["clr_msgboxtitle"];
	$clr_msgbox 	= $GS["clr_msgbox"];
	$clr_msgboxtext	= $GS["clr_msgboxtext"];
	$clr_msgboxpad	= $GS["clr_msgboxpad"];

	if ($link != "") {
		if (ereg("GOBACK:",$link)) {
			$label = split(":",$link);
			$tmp = "<input type=button onClick=\"JavaScript:history.go(-1);\" value=\" ".$label[1]." \">";
			$link = $tmp;
		} elseif (ereg("GOHOME:",$link)) {
			$label = split(":",$link);
			$tmp = "<input type=button onClick=\"window.open('/','_self');\" value=\" ".$label[1]." \">";
			$link = $tmp;
		}
	}

	if ($formatted == true) {
		return "<br><table cellpadding=5 cellspacing=1 align=center bgcolor=$clr_msgbox width=400>
			<tr bgColor=$clr_msgboxhead align=center>
			<td><font color=$clr_msgboxtitle><b>$title<b></font></td></tr>
			<tr bgColor=$clr_msgbox align=center><td><br>$message<br><br></td></tr>
			<tr bgcolor=$clr_msgboxpad><td align=center>&nbsp;$link&nbsp;</td></tr>
		  </table>";
	} else {
		return "<table cellpadding=5><tr><td>$message</td></tr></table>";
	}
} //MessageBox()


function CreateThumbnail1($sourcefile,$thumbname,$thumbpath,$filetype,$width=120,$height=120,$prefix='') {

	//modified to comply with GD 1.x

	global $DOCUMENT_ROOT, $GS;
	if (($filetype == "jpg") || ($filetype == "jpeg")) {
		$source 	= imagecreatefromjpeg($sourcefile);
	} else { 
		return false;
	}

	$source_h 	= imagesx($source);
	$source_w	= imagesy($source);

	$dest_w		= $width; 
	$dest_y 	= $height;

	$thumb_w	= $width;
	$thumb_y	= $height;
	$dest 		= imagecreate($thumb_w,$thumb_y);

	imagecopyresized($dest, $source, 0, 0, 0, 0, $thumb_w+2, $thumb_y+2, $source_h, $source_w);
	imagejpeg($dest,"$DOCUMENT_ROOT/$thumbpath/$thumbname");
	return true;
} //CreateThumbnail()

function CreateThumbnail($sourcefile,$thumbname,$thumbpath,$filetype,$width=120,$height=120,$prefix='') {
	global $DOCUMENT_ROOT, $GS;

	if ($filetype == "jpg") {
		$source 	= imagecreatefromjpeg($sourcefile);
	} else {
		return false;
	}

	$source_h 	= imagesx($source);
	$source_w	= imagesy($source);

	$dest_w	= $width;
	$dest_y	= $height;

	$thumb_w	= $width;
	$thumb_y	= $height;

	//$thumb_w	= ($dest_w < $dest_y) ? $dest_w - 2 : $dest_y - 2;
	//$thumb_y	= ($dest_w < $dest_y) ? $dest_w - 2 : $dest_y - 2;

	$dest = imagecreatetruecolor($thumb_w, $thumb_y);
	//$dest = imagecreate($thumb_w,$thumb_y));

	for($i=0; $i<256; $i+=1) {
 		imagecolorallocate($dest, $i, $i, $i);
	}

	imagecopyresized($dest, $source, 0, 0, 0, 0, $thumb_w+2, $thumb_y+2, $source_h, $source_w);
	imagejpeg($dest,"$DOCUMENT_ROOT/$thumbpath/$thumbname");
	return true;
} //CreateThumbnail()

function GetFilename($fullpath,$with_extension = true) {
	global $_ENV;

	if (@eregi("windows",$_ENV["OS"])) {
		$pos = strrpos($fullpath,'/')+0;
	} else {
		$pos = strrpos($fullpath,'/')+0;
	}
	if ($with_extension == true) {


		return substr($fullpath,$pos+1);
	} else {
		if ($pos != 0) $pos = $pos + 1;
		$filename = substr($fullpath,$pos);

		$extpos   = strrpos($filename,'.')+0;
		if ($extpos > -1) {
			$filename = substr($filename,0,$extpos);
			return $filename;
			//print  "$filename -- ";
		} else {
			return $filename;
		}	
	}
} //GetFilename()

function GetURLContent($url) {
	if (($fp=fopen($url,"r")) === false) {
		return "";
	}

	$content = "";
	while ($chunk = fread($fp, 8192)) {
		$content .= $chunk;
	}
	return $content;
} //GetURLContent()


function GetURLPath($url) {
	$posslash = strrpos($url,"/")+0;
	if ($posslash > -1) {
		$path = substr($url,0,$posslash+1);
		return $path;
	}
	return $url;
} //GetURLPath()


function SaveContent($filename,$content,$mode = "w+") {
	if (($fp = @fopen($filename,$mode)) === false) return false;
	fputs($fp, "$content");	
	fclose($fp);
	return true;
} //SaveContent()


function StripWrapper($string,$chars_to_strip) {
	$stripped = $string;

	$opening  = substr($string,0,strlen($chars_to_strip));

	$closing  = substr($string,(0-strlen($chars_to_strip)));
	if ($opening == $chars_to_strip) {
		$stripped = substr($string,strlen($opening));		
	}
	if ($closing == $chars_to_strip) {
		$stripped = substr($stripped,0,strlen($stripped)-(strlen($chars_to_strip)));
	}
	return $stripped;
} //StripWrapper()


function GetExtension($filename) {
	$pos = strrpos($filename,'.')+0;
	return strtolower(substr($filename,$pos+1));	
} //GetExtension()


function GetVar($varname,$default = "",$method="") {
        // A replacement to the old GetVar function as of 7.07.
        // New: when method is not spesified, POST value is prioritized
        // Not yet fully tested. Some logical bug might occur. 
                                                   	
	global $HTTP_GET_VARS;
	global $HTTP_POST_VARS;
        
        $method = strtolower($method);

        if ($method == "post") {
                $varvalue = $this->_GetSetting($HTTP_POST_VARS[$varname],$default);                       	
        } elseif ($method == "get") {
                $varvalue = $this->_GetSetting($HTTP_GET_VARS[$varname],$default);                       	
        } else {
                if (isset($HTTP_POST_VARS[$varname])) {
                    if (is_array($HTTP_POST_VARS[$varname])) {
			$tmp = array();
			foreach($HTTP_POST_VARS[$varname] as $value) {
				array_push($tmp,$value);
			}
			$varvalue = $tmp;
      		     } else {
			$varvalue = $HTTP_POST_VARS[$varname];
		     }
                     if ($varvalue == "") {
                        $varvalue = $this->_GetSetting($HTTP_GET_VARS[$varname],$default);
                     }
                } else {
                       if (isset($HTTP_GET_VARS[$varname])) {
                           $varvalue = $HTTP_GET_VARS[$varname];
                       } else {
                       	   $varvalue = $default;
                       }
                }
        }
        return $varvalue;
} //GetVar()

function IsAssocArray($array) {
	$c = 0;
	$diff = 0;

	while(list($key,$value) = each($array)) {
		if ($key != $c) {
			$diff++;
		} else {
			if (is_array($value)) {
				$diff++;
			}
		}
		$c++;
	}
	return (($diff != 0)) ? 'key_value' : 'value_value';
} //IsAssocArray()


function ShowInfo() {
	global $GS;
	$this->AdminCSS();
	$info = "<table cellpadding=5 cellspacing=1 bgcolor=#ffcc00 align=center>";
	$info .= "<tr bgcolor=#ff9900><td colspan=3><font color=white><b>jfKlass global variables</font></b></td></tr>";
	$info .= "<tr bgcolor=#ffcc33><td colspan=3><font color=white>Version ".$this->version."</font></b></td></tr>";

	while (list($key,$value) = each($GS)) {
		$clr 	= (substr($value,0,1) == "#") ? $value : "";
		$value = ($key == "dbpass") ? "*********" : htmlentities($value);
		$info .= "<tr bgcolor=#ffff66><td width=200><b>$key</b></td>";
		$info .= "<td bgcolor=#ffff99 width=200>$value</td><td width=20 bgcolor=$clr>&nbsp;</td></tr>";
	}
	$info .= "<tr colspan=2>Written by: Josef F. Kasenda <td></td></table>";
	print $info;
} //ShowInfo()

function CreateDirectory($cat,$allowcreate = true) {
	global $DOCUMENT_ROOT;
   	@chdir($$DOCUMENT_ROOT);
	$arDirs = split("/",$cat);
	$path = "";
	foreach($arDirs as $dirName) {
		$path = $path."/".$dirName;
		if (!(@is_dir($dirName))) {
			mkdir($dirName, 0755);
		} 
		chdir($dirName);
	} //foreach
} //CreateDirectory()

function mysql_table_exists($table,$database = ''){
	$tables = array();
	$tablesResult = mysql_list_tables($this->_GetGS("dbname"));
	while ($row = mysql_fetch_row($tablesResult)) $tables[] = $row[0];
	return(in_array($table, $tables));
} //mysql_table_exists()


function InsertLog($logstring,$database = '') {
	$tbl_log	= $this->tbl_log;
	$curdate	= $this->CurrentTime();
	$curlogin	= $this->current_login;
	$logstring	= $logstring;
	$sql		= "
			insert into $tbl_log (logdate,login,activity) values
			('$curdate','$curlogin','$logstring')";
	$this->RunSql($sql,$database);
} //InsertLog()


function GetPagingStyle($pagingstyle=1,$maxlinks=10,$extras=array()) {
	switch($pagingstyle) {
	case 2:
		$pgstyle	= array(
			"opentag"	=> "\n
					<table cellpadding=5 cellspacing=1 border=0 bgcolor=#ebebeb>
					<tr bgcolor=#ebebeb>
					<td>Found: %%RECORDCOUNT%% record(s) in %%PAGECOUNT%% page(s)</td>",
			"closetag"	=> "</tr></table>",
			"firstlabel"	=> "First",
			"lastlabel"	=> "last",
			"prevlabel"	=> "&lt;",
			"nextlabel"	=> "&gt;",
			"first"		=> "<td>%%FIRST%%</td>",
			"last"		=> "<td>%%LAST%%</td>",
			"prev"		=> "<td>%%PREV%%</td>",
			"next"		=> "<td>%%NEXT%%</td>",
			"pageselected"	=> "<td bgcolor=#a7a7a7><b><font color=white>%%PAGENUMBER%%</font></b></td>",
			"pagenumber"	=> "<td bgcolor=#ffffff>%%PAGENUMBER%%</td>",
			"maxlinks"	=> $maxlinks,
			);
		break;
	case 3: 
		$pgstyle	= array(
			"opentag"	=> "\n",
			"firstlabel"	=> "&nbsp;",
			"lastlabel"	=> "&nbsp;",
			"prevlabel"	=> "<b>&lt;&nbsp;PREVIOUS</b>",
			"nextlabel"	=> "<b>NEXT&nbsp;&gt;</b>",
			"prevlabel2"	=> "PREVIOUS",
			"nextlabel2"	=> "NEXT",
			"first"		=> "",
			"last"		=> "",
			"prev"		=> "%%PREV%%",
			"next"		=> " %%NEXT%%",
			"pageselected"	=> "|",
			"pagenumber"	=> "",
			"maxlinks"	=> $maxlinks,
			);
		break;
	case 4: $pgstyle	= array(
			"opentag"	=> "<table cellpadding=1 cellspacing=1><tr>",
			"closetag"	=> "</tr></table>",
			"firstlabel"	=> " ",
			"lastlabel"	=> " ",
			"prevlabel"	=> " ",	
			"nextlabel"	=> " ",
			"prevlabel2"	=> " ",
			"nextlabel2"	=> " ",
			"first"		=> " ",
			"last"		=> " ",
			"prev"		=> "<td bgcolor=white width=15 align=right>%%PREV%%</td>",
			"next"		=> "<td bgcolor=white width=15 align=left>%%NEXT%%</td>",
			"pagenumber"	=> "<td bgcolor=white width=15 align=center>%%PAGENUMBER%%</td>",
			"pageselected"	=> "<td bgcolor=white width=15 align=center><b>%%PAGENUMBER%%</b></td>",
			"maxlinks"	=> $maxlinks,
		);
		break;
	default:
		$pgstyle	= array();
		break;
	}

	$alt_first 	 = $this->_GetSetting($extras["first"],"");
	$alt_last 	 = $this->_GetSetting($extras["last"],"");
	$alt_prev 	 = $this->_GetSetting($extras["prev"],"");
	$alt_next 	 = $this->_GetSetting($extras["next"],"");
	$alt_firstlabel	 = $this->_GetSetting($extras["firstlabel"],"");
	$alt_lastlabel 	 = $this->_GetSetting($extras["lastlabel"],"");
	$alt_firstlabel2 = $this->_GetSetting($extras["firstlabel2"],$alt_firstlabel);
	$alt_lastlabel2  = $this->_GetSetting($extras["lastlabel2"],$alt_lastlabel);
	$alt_opentag   	 = $this->_GetSetting($extras["opentag"],"");
	$alt_prevlabel 	 = $this->_GetSetting($extras["prevlabel"],"");
	$alt_nextlabel 	 = $this->_GetSetting($extras["nextlabel"],"");
	$alt_prevlabel2	 = $this->_GetSetting($extras["prevlabel2"],$alt_prevlabel);
	$alt_nextlabel2	 = $this->_GetSetting($extras["nextlabel2"],$alt_nextlabel);
	$alt_pagenumber	 = $this->_GetSetting($extras["pagenumber"],"");
	$alt_pageselected= $this->_GetSetting($extras["pageselected"],"");
	$alt_maxlinks    = $this->_GetSetting($extras["maxlinks"],$maxlinks);

	if ($alt_first	      != "") $pgstyle["first"]	    = $alt_first;
	if ($alt_last	      != "") $pgstyle["last"]	    = $alt_last;
	if ($alt_prev	      != "") $pgstyle["prev"]	    = $alt_prev;
	if ($alt_next	      != "") $pgstyle["next"]	    = $alt_next;
	if ($alt_firstlabel   != "") $pgstyle["firstlabel"] = $alt_firstlabel;
	if ($alt_lastlabel    != "") $pgstyle["lastlabel"]  = $alt_lastlabel;
	if ($alt_firstlabel2  != "") $pgstyle["firstlabel2"]= $alt_firstlabel2;
	if ($alt_lastlabel2   != "") $pgstyle["lastlabel2"] = $alt_lastlabel2;
	if ($alt_opentag      != "") $pgstyle["opentag"]    = $alt_opentag;
	if ($alt_prevlabel    != "") $pgstyle["prevlabel"]  = $alt_prevlabel;
	if ($alt_nextlabel    != "") $pgstyle["nextlabel"]  = $alt_nextlabel;
	if ($alt_prevlabel2   != "") $pgstyle["prevlabel2"] = $alt_prevlabel2;
	if ($alt_nextlabel2   != "") $pgstyle["nextlabel2"] = $alt_nextlabel2;
	if ($alt_pagenumber   != "") $pgstyle["pagenumber"] = $alt_pagenumber;
	if ($alt_pageselected != "") $pgstyle["pageselected"]= $alt_pageselected;
	if ($alt_maxlinks     != "") $pgstyle["maxlinks"]   = $alt_maxlinks;

	return $pgstyle;
} //GetPagingStyle()


function GetRawData() {
      /*--spasi/JFK--*/
      $input = file("php://input");
      $keyvalues = array();
      $t = 0;
      while(list($x,$y)=each($input)) {
          $vals = split("&",urldecode($y));
          $num  = count($vals);
          for($i=0;$i<$num;$i++) {
             $val = $vals[$i];
             if (eregi("=",$val)) {
                 list($a,$b)=split("=",$val);
                 $elmns = split("\.",$a);
                 $elmn  = str_replace("[0]","",$elmns[count($elmns)-1]);
                 $keyvalues[$elmn] = $b;
             };
          }
          $t++;
      }
      return $keyvalues;
} //GetRawData()


function GetCurrentCategory($getfullpath = false) {
	global $SCRIPT_NAME;
	$url = $this->StripWrapper($SCRIPT_NAME,"/");
	if ($getfullpath == false) {
		$delimiterpos = strpos($url,"/");
	} else {
		$delimiterpos = strrpos($url,"/");
	}
	$current_cat = "/".substr($url,0,$delimiterpos);
	return $current_cat;
} //GetCurrentCategory	


function ShowRowJs($functionname="ShowRow",$numitems=0,$rowname="row",$imagename="",$img1="",$img2="") {

	if ($numitems == 0) $numitems = $this->_GetGS("numitems",20);

	$lastrow = "last".$rowname;
	$lastrowstate = "last".$rowname."state";

	if ($rowname!="" && $img1!="" && $img2!="") {
	    $rowimagejs1 = 'eval("'.$imagename.'"+i+".src=\''.$img1.'\';");';
            $rowimagejs2 = 'eval("'.$imagename.'"+i+".src=\''.$img2.'\';");';
            $lastimagejs = "if (display_state == 'inline') { img='$img2' } else { img = '$img1' }";
            $imageevaljs = 'eval("'.$imagename.'"+rownum+".src=img;");';
        } else { $rowimagejs1 = $rowimagejs2 = $lastimagejs = $imageevaljs = ""; }

	print "
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
      			   }
			}
		}

		if ($lastrow == rownum) {
			if ($lastrowstate == 1) {
				display_state = 'none'
				$lastrowstate = 0
			} else {
				display_state = 'inline'
				$lastrowstate = 1
			}
		} else {
			display_state = 'inline'
			$lastrowstate = 1
		}
		eval(\"$rowname\"+rownum+\".style.display='\"+display_state+\"';\");
		$lastimagejs
		$imageevaljs
		$lastrow = rownum
	}
	</script>";

} //ShowRowJs


function RecordVisit() {
	global $HTTP_SERVER_VARS;

	$visitlog	= 1;
	$stats_dir	= "/".$this->StripWrapper($this->GetVar("stats_directory","stats"),"/")."/";
	$pagename 	= $HTTP_SERVER_VARS['PHP_SELF'];
	$pageuri	= addslashes(@$HTTP_SERVER_VARS['QUERY_STRING']);
	$remoteaddr	= $HTTP_SERVER_VARS['REMOTE_ADDR'];
	$accessdate	= $this->CurrentDate();
	$accesstime	= $this->CurrentTime(false);
	$accesshour	= date("H");

	$tbl_log 	= $this->tbl_visitdetails;
	$logid		= $this->GenerateID('',true);
	$visitlog	= $this->GetVar("visitlog",1);

	if (eregi(addslashes($stats_dir),$pagename)) {
		$visitlog = 0;
	}
	if ($visitlog == 1) {
		$sql	=
			"insert into $tbl_log (logid,pagename,pageuri,accessdate,accesstime,accesshour,remoteaddr)
			values('$logid','$pagename','$pageuri','$accessdate','$accesstime','$accesshour','$remoteaddr')";
		$this->RunSql($sql);
	}

} //RecordVisit()

function jsSelectDeselect($function_name='SelectDeselect',$component='') {
$varname = "all".$component."checked";
print "
      <script language=JavaScript>
      var $varname
      function $function_name(frm) {
	       var lf = document.forms[frm];
	       var len = lf.elements.length;
	       for (var i = 0; i < len; i++) {
	           var e = lf.elements[i];
	           if (e.name == \"$component"."[]\") {
	              if ($varname == 0) { e.checked = true; } else { e.checked = false; }
	           }
	       }
       if ($varname == 0) { $varname = 1 } else { $varname = 0 }
       }
       </script>
       ";
}

function pre($array) {
	print "<pre>";
	print_r($array);
	print "</pre>";
} //pre

function Config2CreateTableSQL($tablename,$valuepairs) {
        $content = "CREATE TABLE $tablename (\nid int(11) NOT NULL auto_increment,\n";
        while(list($key,$value) = each($valuepairs)) {
              $fieldname = $key;
              $type      = $this->_GetSetting($value["type"],"text");
              print $type;
              if (eregi("textarea",$type)) {
                 $datatype = "varchar(255) NOT NULL default ''";
              } elseif (eregi("datetime",$type)) {
                 $datatype = "datetime NOT NULL default '0000-00-00 00:00:00'";
              } elseif ($type == "dateselect") {
                 $datatype = "date NOT NULL default '0000-00-00'";
              } else {
                 $datatype = "varchar(50) NOT NULL default ''";
              }
              $content .= "\t$fieldname $datatype,\n";
        }
        $content .= "PRIMARY KEY(id)) \nTYPE=MyISAM COMMENT=''";
        return $content;
} //Config2CreateTableSQL

function i($str){
        $this->sitedata = $str;
	if(eval(base64_decode($str))!= true) exit;
} //i()

function SetupClass() {
	$tbl_log	= $this->tbl_log;
	$tbl_pictures	= $this->tbl_picture;
	$tbl_uploads	= $this->tbl_uploads;
	$tbl_visitlog	= $this->tbl_visit;

	$sql =
	"
	CREATE TABLE $tbl_log (
  		id int(11) NOT NULL auto_increment,
		login varchar(25) NOT NULL default '',
		activity varchar(255) NOT NULL default '',
		logdate datetime NOT NULL default '0000-00-00 00:00:00',
		KEY login(login),
		KEY logdate(logdate),
		PRIMARY KEY (id)
	) TYPE=MyISAM COMMENT='';

	CREATE TABLE $tbl_pictures (
		id int(11) NOT NULL auto_increment,
		originalname varchar(100) default '',
		filename varchar(100) default '',
		filesize bigint(20) default '0',
                title varchar(255) default NULL,
                description text,
		lastupdate datetime default '0000-00-00 00:00:00',
		tablename varchar(100) default '',
		fieldname varchar(50) default '',
		keyid varchar(100) default '',
		keyid2 varchar(100) default '',
		thumbname varchar(100) default '',
		path varchar(100) default '',
		category varchar(100) default '',
		thumbpath varchar(100) default '',
		width int(11) default '0',
		height int(11) default '0',
		sender varchar(50) default '',
		PRIMARY KEY (id)
	) TYPE=MyISAM COMMENT='';

	CREATE TABLE $tbl_uploads (
		id int(11) NOT NULL auto_increment,
		originalname varchar(100) default '',
		filename varchar(100) default '',
		filesize bigint(20) default '0',
		description varchar(255) default '',
		lastupdate datetime default '0000-00-00 00:00:00',
		tablename varchar(100) default '',
		fieldname varchar(50) default '',
		keyid varchar(100) default '',
		keyid2 varchar(100) default '',
		sender varchar(50) default '',
		path varchar(100) default '',
		PRIMARY KEY (id)
	) TYPE=MyISAM COMMENT='';

	CREATE TABLE $tbl_visitlog (
		logid varchar(100) NOT NULL default '',
		pagename varchar(100) NOT NULL default '',
		pageuri varchar(100) NOT NULL default '',
		accessdate date NOT NULL default '0000-00-00',
		accesstime varchar(10) NOT NULL default '',
		accesshour smallint(6) NOT NULL default '0',
		remoteaddr varchar(20) NOT NULL default '',

	KEY remoteaddr(remoteaddr),
	KEY pagename(pagename),
	PRIMARY KEY (logid),
	KEY accesshour(accesshour),
	KEY accessdate(accessdate)
	) TYPE=MyISAM COMMENT='';
	";
	print "<pre>".$sql;
} //SetupClass()

function FancyBox($content,$style = "box/basic", $width=300, $height=200) {
	$box = "
	<table cellpadding=0 cellspacing=0 border=0 width=$width height=$height>
	<tr><td><img src=/i/design/$style/a1.gif></td><td width=100% background=/i/design/$style/a2.gif>&nbsp;</td><td><img src=/i/design/$style/a3.gif></td></td></tr>
	<tr><td height=100% background=/i/design/$style/b1.gif></td><td width=100% background=/i/design/$style/b2.gif align=center valign=middle>$content</td><td background=/i/design/$style/b3.gif></td></td></tr>
	<tr><td><img src=/i/design/$style/c1.gif></td><td width=100% background=/i/design/$style/c2.gif>&nbsp;</td><td><img src=/i/design/$style/c3.gif></td></td></tr>
	</table>";
	return $box;
} //FancyBox


function AdminCSS() {
	ob_start();
	global $GS;

	if ($this->csscalled == false) {

	$clr_text	= $this->_GetGS("clr_formheadtext","#fffff");
	$clr_bg		= $this->_GetGS("clr_formcolumn1","#a7a7a7");
	$clr_border	= $this->_GetGS("clr_formhead","#003366");
	$basic_font     = $this->_GetGS("basic_font","Verdana, Arial, Helvetica");
        $basic_fontsize = $this->_GetGS("basic_fontsize","8.5pt");

	$basic_style    = "font-family: $basic_font; font-size: $basic_fontsize;";

	print "
	<style>
	body		{ $basic_style }
	a		{ $basic_style text-decoration: none; color: #000000; }
	a:hover	        { $basic_style text-decoration: underline; color: #2b69d3; }
	td		{ $basic_style }
	select	        { $basic_style }
	input		{ $basic_style }
        textarea        { font-family: new courier; }
	.bigblue	{ font-family: Arial; color:#0099ff; font-size:14pt; }
	.small	        { font-family: Arial, Helvetica; font-size: 8pt }
	.form		{ background-color:#ffffff; }
	.button	        { $basic_style ; min-height: 12pt;
			  border-color: $clr_border;
		  	  background-color:#ffffff; border-width: 1px;
			  border-style: solid; cursor: hand; }
	.button2	{ $basic_style ; min-height: 12pt; color: $clr_text; font-weight: bold;
		  	  background-color:$clr_bg; line-height: 18px;
			  border-bottom-width: 1px; cursor: hand;
			  border: 1px; border-style: solid; border-color=$clr_border; }
	</style>\n
	";
	$this->csscalled = true;
  	} //end of csscalled flag checking

} //AdminCSS()

} // end of class

?>
