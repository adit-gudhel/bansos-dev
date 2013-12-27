<?
//jfKlass::DB_ORACLE
//(c)2004-2007 Josef Freddy Kasenda/SPASI
//exclusive usage license to JFK/SPASI

include("$DOCUMENT_ROOT/s/adodb/adodb.inc.php");

$ado = ADONewConnection('oci8');

class DB {

var $conn;
var $insert_id  = 0;
var $tmpCLOB = array();
var $sqlerr	 = '';

function dbType() {
   return 'ORACLE';
}

function Connect($server,$user,$pass,$dbname) {
   global $ado;
   $this->conn = $ado->Connect($server, $user, $pass, $dbname) or die($this->ShowBusy());
}

function ShowBusy() {
	global $_SERVER;
	$errpage = "";
	$err 		= ocierror();
	$host		= $_SERVER['HTTP_HOST'];
	$page		= $_SERVER['DOCUMENT_ROOT']."/error/index.php";
	$msg		= "Server is currently busy. Please retry again in a few seconds." .
			  	  "<br><a href=http://$host>REFRESH</a>\n<br>".$err['message']."</br>";
	if (file_exists($page)) {
		while(@ob_end_clean());
		header("location: http://$host/error/index.php");
 	} else {
		print $msg;
	}
}

function RunSql($sql) {
	global $ado;
   $rs      = $ado->Execute($sql);
	$this->numrecs = $rs->_numOfRows;
   return $rs;
}

function UpdateSql($sql) {
	global $ado;
   $rs      		= $ado->Execute($sql);
	$this->sqlerr 	= $ado->ErrorMsg();
	$numrecs 		= ($rs) ? 1 : -1;
   return $numrecs;
}

function InsertSql($sql) {
	global $ado;
   $rs      		= $ado->Execute($sql);
	$this->sqlerr 	= $ado->ErrorMsg();
	$numrecs 		= ($rs) ? 1 : -1;
   return $numrecs;
}

function DeleteSql($sql) {
	global $ado;
   $rs      		= $ado->Execute($sql);
	$this->sqlerr 	= $ado->ErrorMsg();
	$numrecs 		= ($rs) ? 1 : -1;
   return $numrecs;
}

function GetLastInsertId($tablename,$primarykey='ID',$primarykey2='',$custompk=false,$keyid='') {
	if ($custompk == true) {
		return $keyid;
	} else {
	   //$sql     = "select $primarykey from $tablename where ROWNUM < 2 order by ROWNUM desc";
		$sql		= "select MAX($primarykey) from $tablename";
	   $result  = $this->SelectLimit($sql);
	   $lastid  = ((int)@$result[0][0]);
   	return $lastid;
	}
}

function GetNextID($tablename,$primarykey='ID') {
	$lastnum = $this->GetLastInsertId($tablename,$primarykey,'',false);
	return $lastnum + 1;
}

function SelectTop($sql,$num) {
	$sql = "$sql limit 0, $num";
   return $sql;
}

function SelectLimit($sql,$start=0,$numitems=0,$is_recordset=false) {
	global $ado;
	if (eregi( ' limit ',$sql)) {
	   $sqlinfo  = $this->StripLimit($sql);
		$sql  	 = $sqlinfo["sql"];
		$numitems = $sqlinfo["num"];
		$start	 = $sqlinfo["start"];
	}
	if ($numitems > 0) {
		$rs	= $ado->SelectLimit($sql,$numitems,$start);
	} else {
		$rs	= $this->RunSql($sql);
	}
   $result  = array();
   $rownum  = 0;
   $count   = 0;
   $min     = $start;
   $max     = $numitems;
   if ($rs) {
   while ($rows = $rs->FetchRow()) {
         $result[$rownum] = $rows;
         $rownum++;
   }
   }
   return $result;
}

function GetFieldInfo($rs) {
//print "<pre>";	print_r($rs);

    $array_fields = array();

	 if (@$rs->_fieldobjects) {
	    $numfields    = count($rs->_fieldobjects);
	    $fieldobject	= $rs->_fieldobjects;
    } else {
	    $numfields    = count($rs->_fieldobjs);
	    $fieldobject	= $rs->_fieldobjs;
    }

	if (!$fieldobject) {
		$dbuser = $this->GetGS("dbuser");
		$dbhost = $this->GetGS("dbhost");
		$dbtype = $this->dbType();
		$dbinfo = "<br><br>Current setting: <br> Database: $dbhost ($dbtype)<br> user: $dbuser";
		//print $this->MessageBox('EMPTY OBJECT',"Query results in no object. Check your query for mispellings or syntaxes. $dbinfo",'&nbsp;');
		return array();
	}

	foreach($fieldobject as $field) {
	   $fieldinfo = array();
	    while(list($key,$val) = each($field)) {
	   	$fieldinfo[$key] = $val;
	   }
	$fieldname = $fieldinfo['name'];
	$fieldtype	= $fieldinfo['type'];
	$fieldlen	= $fieldinfo['max_length'];

	$array_fields[$fieldname] = array($fieldtype,$fieldlen);
	}
   return $array_fields;
}

function SelectTableInfo($table) {
	if (eregi("^select ",$table)) {
	   return $table;
 	} else {
		return "select * from $table where ROWNUM < 2";
  	}
}

function BuildDate($year,$month,$day,$hour="00",$min="00",$sec="00",$showtime=false) {
   return ($showtime==false) ? "$year-$month-$day" : "$year-$month-$day $hour:$min:$sec";
}

function DateFormatStr($date) {
   return "TO_DATE('$date','YYYY-MM-DD HH24:MI:SS')";
}

function IsValidDate($date) {
	list($year,$month,$day) = split("-",$date."--");
	if (checkdate(intval($month),intval($day),intval($year)) == false) {
		return false;
	}
 	return true;
}

function EscapeStr($s) {
	global $ado;
	return str_replace("'","''",stripslashes($s));
	//return addslashes(stripslashes($s));
}

function GetTableList($dbname) {
	//$result = array();
	//$rs = mysql_list_tables($dbname);
	//while ($row = mysql_fetch_row($rs)) {
	//	$tablename = $row[0];
	//	array_push($result,$tablename);
	//}
	//mysql_free_result($rs);
	//return $result;
}

//==========specific function for the non-mysql version

function OracleUpdateInsertSql($sql) {
	global $ado;
	$ado->BeginTrans();

	while(list($fieldname,$clob) = each($this->tmpCLOB)) {
		$bindname 	= ":$fieldname";
		$fieldvalue = $clob;
		$sql			= str_replace("'$fieldvalue'",$bindname,$sql);
 	}
	reset($this->tmpCLOB);

	$sth=$ado->PrepareSP($sql);
	while(list($fieldname,$clob) = each($this->tmpCLOB)) {
		$bindname 	= "$fieldname";
		$fieldvalue = $clob; //print "<br>bindname: $fieldname <br>";
		$ado->InParameter($sth,$fieldvalue,$bindname,-1,OCI_B_CLOB);
	}
	$ado->Execute($sth);
	$ado->CommitTrans();
	unset($this->tmpCLOB);
}

function StripLimit($sqlstr,$striporder = false) {
	$nstart 		= strpos(strtolower($sqlstr)," limit ") + 0;
	if ($nstart == 0) {
		$nstart 		= strlen($sqlstr);
		$limitinfo  = " , ";   	//since sql contains no limit, fake the limit string to prevent split error
	} else {
		$limitinfo 	= substr($sqlstr,$nstart+7);
	}

	if (eregi(" where ",$sqlstr)) {
		$wh_start= strpos(strtolower($sqlstr)," where ");
		$where	= substr($sqlstr,$wh_start, ($nstart - $wh_start));
	} else {
		$where 	= "";
	}

	$newsqlstr 	= substr($sqlstr,0,$nstart)." ";
	$info 		= split(",",$limitinfo);
	$tbl_nstart	= strpos(strtolower($newsqlstr)," from ") + 6;
	$tbl_nend	= strpos(strtolower($newsqlstr), " ",$tbl_nstart+1) + 0;
	$table		= trim(substr($newsqlstr,$tbl_nstart,($tbl_nend - $tbl_nstart)));

	if ($striporder == true) {
	if (eregi(" order by ",$newsqlstr)) {
		$ord_start	= strpos(strtolower($sqlstr)," order by ");
		$newsqlstr	= substr($newsqlstr,0,$ord_start);
	}
	}
	$sqlinfo["start"] = $info[0];
	$sqlinfo["num"] 	= $info[1];
	$sqlinfo["table"]	= $table;
	$sqlinfo["sql"] 	= $newsqlstr;
	$sqlinfo["where"]	= $where;

	//print "<hr>$newsqlstr $tbl_nstart, $tbl_nend, <b>$table</b> <hr>";
	return $sqlinfo;
} //StripLimit()

}
?>
