<?
include_once("$DOCUMENT_ROOT/s/jfkInclude.php");
class jfkLog extends jfKlass {
/*
<-jfkLog-------------------------------------------------------------------->
//Joint Features Class

WARNING!
=============================================================================
DO NOT ALTER OR MODIFY OR REMOVE ANY PART OF THIS SCRIPT. ALTERATION,
MODIFICATION OR REMOVAL OF ANY KIND WILL VOID THE WARRANTY AND MAY CAUSE
THE SYSTEM RELYING ON THIS SCRIPT TO FAIL COMPLETELY.

THIS CLASS IS TO BE USED BY SITES ADMINISTERED BY SPASI.COM ONLY
=============================================================================

Written by: Josef F. Kasenda/SPASI.COM
version 1.04
(p)2004
<--------------------------------------------------------------------------->
*/

//var $stats_server	= "http://localhost:6969";

function jfkLog() {
         global $HTTP_HOST;
         $this->InitVars();
         $stats_server	= "http://$HTTP_HOST";
}

function GetCacheName() {
	global $HTTP_SERVER_VARS;
	$pagename 	= $HTTP_SERVER_VARS["PHP_SELF"];
	$urlvars	= $this->GetURLVars(array("ts"));
	$cachename	= "$pagename?$urlvars";
	return md5($cachename);
}

function ProcessVisitAdmin() {
	global $act, $logact;
	$act		= $this->GetVar("act","show");
	$datestart 	= $this->GetVarDate("datestart",$this->StartOfMonth());
	$dateend	= $this->GetVarDate("dateend",$this->CurrentDate());

	if ($act == "show") {
		$this->ShowVisitReport($datestart,$dateend);
	} elseif ($act == "dailydetails") {
		$this->ShowDailyVisitReport($this->GetVar("date"),$this->CurrentDate());
	} elseif ($act == "hourlydetails") {
		$this->ShowHourlyVisitReport($this->GetVar("date"),$this->CurrentDate());
	} elseif ($act == "urlbased") {
		$this->ShowDailyReportByURI($this->GetVar("date"),$this->CurrentDate());
	} elseif ($act == "addressbased") {
		$this->ShowDailyReportByVisitors($this->GetVar("date"),$this->CurrentDate());
	}
}

function VisitAdminHeader() {
	$datestart	= $this->GetVarDate("datestart",$this->StartOfMonth());
	$dateend	= $this->GetVarDate("dateend",$this->CurrentDate());

	if (!$this->ValidDate($datestart)) 	$datestart = $this->StartOfMonth();
	if (!$this->ValidDate($dateend)) 	$dateend = $this->CurrentDate();

	$datestart	= $this->PrintTimeSelect($datestart,false,"datestart");
	$dateend	= $this->PrintTimeSelect($dateend,false,"dateend");
	$header 	= "
			<table border=0 cellpadding=4 cellspacing=2 width=100% bgcolor=#c6c6c6><form>
			<tr bgcolor=#ebebeb><td colspan=2><b>VISIT COUNTER</b></td></tr>
			<tr><td>From</td><td bgcolor=#ffffff>$datestart</td></tr>
			<tr><td>To</td><td bgcolor=#ffffff>$dateend</td></tr>
			<tr><td></td><td td bgcolor=#ffffff><input class=button2 type=submit value=\" See Report \"></td></tr></form>
			</table>";

	return $header;
}

function ShowVisitReport($datestart,$dateend) {
	$tbl_log 	= $this->tbl_visitdetails;

	if (!$this->ValidDate($datestart)) 	$datestart = $this->StartOfMonth();
	if (!$this->ValidDate($dateend)) 	$dateend = $this->CurrentDate();

	$sql 		= 
			"select pagename as Page_Visited,
			count(pagename) as Total_Visits,
			accessdate as Access_Date,
			accessdate as accdate,
			DAYOFMONTH(accessdate) as AccDay,
			MONTH(accessdate) as AccMonth,
			YEAR(accessdate) as AccYear 
			from $tbl_log group by Access_Date 
			having Access_Date >= '$datestart' and Access_Date <= '$dateend'
			";
	//		having YEAR(Access_Date) = $year and MONTH(Access_Date) = $month";
	//print $sql;

	$subheader	= "
			<table cellpadding=4 width=100%><tr bgcolor=#ebebeb><td>
			<font style=font-size:16px;><b>Report of Visits</b></font></td></tr><tr><td bgcolor=#ffffff>
			 from ".$this->FormatTime($datestart)." to ".

			$this->FormatTime($dateend).
			"</td></tr></table>";

	$list	= array(
		"sql"			=> $sql,
		"header"		=> $this->VisitAdminHeader(),
		"subheader"		=> $subheader,
		"adminpage"		=> true,
		"noactions"		=> true,
		"noadminheader"	=> true,
		"groupby"		=> "Access_Date", 
		"numitems"		=> 1000,
		"moreactions"	=> "<li> Click here to see <a href=?act=dailydetails&date=%%accdate%%>THE DETAILS FOR THE DAY</a>",
		"disablesearch"	=> true,
		"disableadd"	=> true,
		"disablereferrer"	=> true,
		"autohead"		=> true,
		"dateformat"	=> array("Access_Date"),
		"altcolors"		=> array("#ebebeb","#ffffff"),
		"fields"		=> array("Page_Visited","Total_Visits","Access_Date","accdate"),
		"layout"		=> "
					<tr bgcolor=%%ALTCOLOR%%>
					<td>%%NO%%</td>
					<td>%%Access_Date%%</td>
					<td>%%Total_Visits%%</td>
					<td><a href=?act=dailydetails&date=%%accdate%%>
					%%DEFAULT_ACTION%%</a></td></tr>",
		"xprintsql"		=> true,

		);
	print $this->ProcessContent($list);
}

function ShowDailyVisitReport($date) {
	$tbl_log 	= $this->tbl_visitdetails;
	
	$sql		= "
			select count(pagename) as Totals, accessdate from $tbl_log
			group by accessdate having accessdate='$date'";

	$total	= $this->GetValue($sql,"Totals");

	$sql 		= 
			"select pagename as Page_Visited,
			count(pagename) as Total_Visits,
			accessdate as Access_Date,
			accessdate as accdate,
			DAYOFMONTH(accessdate) as AccDay,
			MONTH(accessdate) as AccMonth,
			YEAR(accessdate) as AccYear 
			from $tbl_log group by Access_Date, Page_Visited
			having Access_Date = '$date'";

	$curdate	= $this->FormatTime($date);
	$subheader	= "
			<table cellpadding=4 width=100%>
			<tr bgcolor=#ebebeb><td>
			<font style=font-size:16px;><b>Report of Visits</b></font></td></tr>
			<tr><td>
				<a href=?act=show>Main Reports</a> &raquo; 
				<b>Report on $curdate</b> &raquo; 				
				<a href=?act=hourlydetails&date=$date>Hourly-based Reports</a> &#8226;
				<a href=?act=urlbased&date=$date>URL-based report</A> &#8226;
				<a href=?act=addressbased&date=$date>Address-based report</a>
			</td></tr>
			<tr><td bgcolor=#c6c6c6></td></tr>			
			<tr><td bgcolor=#ffffff>On $curdate</td></tr>
			<tr><td>Total: <b>$total</b> Visits</td></tr>
			</table>
			";

	$list	= array(
		"sql"			=> $sql,
		"header"		=> $this->VisitAdminHeader(),
		"subheader"		=> $subheader,
		"adminpage"		=> true,
		"noactions"		=> true,
		"noadminheader"	=> true,
		"numitems"		=> 50,


		"moreactions"	=> "<li> Click here to see <a href=?act=hourlydetails&date=%%accdate%%>THE HOURLY DETAILS</a>",
		"disablesearch"	=> true,
		"disableadd"	=> true,
		"disablereferrer"	=> true,
		"autohead"		=> true,
		"groupby"		=> "Page_Visited",
		"dateformat"	=> array("Access_Date"),
		"altcolors"		=> array("#ebebeb","#ffffff"),
		"fields"		=> array("Page_Visited","Total_Visits","Access_Date","accdate"),
		"layout"		=> "
					<tr bgcolor=%%ALTCOLOR%%>
					<td>%%NO%%</td>
					<td width=300>%%Page_Visited%%</td>
					<td>%%Total_Visits%%</td>
					</tr>",
		"xprintsql"		=> true,

		);
	print $this->ProcessContent($list);
}

function ShowDailyReportByURI($rpt_date) {
	$tbl_log 	= $this->tbl_visitdetails;

	$sql		= "
			select count(pagename) as Totals, accessdate from $tbl_log
			group by accessdate having accessdate='$rpt_date'";
	$total	= $this->GetValue($sql,"Totals");

	$sql 		= 
			"select pagename as Page_Visited,
			CONCAT(pagename,'?',pageuri) as Page_URI,
			count(pagename) as Total_Visits,
			accessdate as Access_Date
			from $tbl_log group by Page_URI, Access_Date
			having Access_Date = '$rpt_date'";

	$curdate	= $this->FormatTime($rpt_date);
	$subheader	= "
			<table cellpadding=4 width=100%><tr bgcolor=#ebebeb><td>
			<font style=font-size:16px;><b>Report of Visits by Spesific URL Requests</b></font></td></tr>
			<tr><td>
				<a href=?act=show>Main Reports</a> &raquo; 
				<a href=?act=dailydetails&date=$rpt_date>Report on $curdate</a> &raquo;
				<a href=?act=hourlydetails&date=$rpt_date>Hourly-based Report</a> &#8226; 
				<b>URL-based report</b> &#8226;
				<a href=?act=addressbased&date=$rpt_date>Address-based report</a>
			</td></tr>
			<tr bgcolor=#c6c6c6><td></td></tr>
			<tr><td bgcolor=#ffffff> Visits on $curdate</td></tr><tr><td>Total: <b>$total</b> visits</td></tr>
			</table>";

	$list	= array(
		"sql"			=> $sql,
		"header"		=> $this->VisitAdminHeader(),
		"subheader"		=> $subheader,
		"adminpage"		=> true,
		"noactions"		=> true,
		"noadminheader"	=> true,
		"disableadd"	=> true,
		"disablesearch"	=> true,
		"disablereferrer"	=> true,
		"disablepagelist"	=> true,
		"numitems"		=> 1000,
		"autohead"		=> true,
		"altcolors"		=> array("#ebebeb","#ffffff"),
		"groupby"		=> $this->GetVar("orderby","Page_URI"),
		"userowspan"	=> true,
		"grouptail"		=> "<tr bgcolor=#c6c6c6><td colspan=5></td></tr>",
		"fields"		=> array("Page_Visited","Page_URI","Total_Visits","Access_Date"),
		"layout"		=> "<tr bgcolor=%%ALTCOLOR%%>
					<td>%%NO%%</td>
					<td><a href=%%Page_URI%%&visitlog=0 target=_blank>%%Page_URI%%</a></td>
					<td>%%Total_Visits%%</td>
					</tr>",
		);
	print $this->ProcessContent($list);
}

function ShowDailyReportByVisitors($rpt_date) {
	$tbl_log 	= $this->tbl_visitdetails;

	$sql		= "
			select count(pagename) as Totals, accessdate from $tbl_log
			group by accessdate having accessdate='$rpt_date'";
	$total	= $this->GetValue($sql,"Totals");

	$sql 		= 
			"select remoteaddr as Visitor_Address,
			count(pagename) as Total_Visits,
			accessdate as Access_Date
			from $tbl_log group by Visitor_Address, Access_Date
			having Access_Date = '$rpt_date'";

	$curdate	= $this->FormatTime($rpt_date);
	$subheader	= "
			<table cellpadding=4 width=100%><tr bgcolor=#ebebeb><td>
			<font style=font-size:16px;><b>Report of Visits by Visitor Address</b></font></td></tr>
			<tr><td>
				<a href=?act=show>Main Reports</a> &raquo; 
				<a href=?act=dailydetails&date=$rpt_date>Report on $curdate</a> &raquo;
				<a href=?act=hourlydetails&date=$rpt_date>Hourly-based Report</a> &#8226; 
				<a href=?act=urlbased&date=$rpt_date>URL-based report</A> &#8226;
				<b>Address-based report</b>
			</td></tr>
			<tr bgcolor=#c6c6c6><td></td></tr>
			<tr><td bgcolor=#ffffff> Visits on $curdate</td></tr><tr><td>Total: <b>$total</b> visits</td></tr>
			</table>";

	$list	= array(
		"sql"			=> $sql,
		"header"		=> $this->VisitAdminHeader(),
		"subheader"		=> $subheader,
		"adminpage"		=> true,
		"noactions"		=> true,
		"noadminheader"	=> true,
		"disableadd"	=> true,
		"disablesearch"	=> true,
		"disablereferrer"	=> true,
		"disablepagelist"	=> true,
		"numitems"		=> 1000,
		"autohead"		=> true,
		"altcolors"		=> array("#ebebeb","#ffffff"),
		"groupby"		=> $this->GetVar("orderby","Total_Visits"),
		"userowspan"	=> true,
		"grouptail"		=> "<tr bgcolor=#c6c6c6><td colspan=5></td></tr>",
		"fields"		=> array("Visitor_Address","Total_Visits","Access_Date"),
		"layout"		=> "<tr bgcolor=%%ALTCOLOR%%>
					<td>%%NO%%</td>
					<td>%%Visitor_Address%%</a></td>
					<td>%%Total_Visits%%</td>
					</tr>",
		);
	print $this->ProcessContent($list);
}


function ShowHourlyVisitReport($rpt_date) {
	$tbl_log 	= $this->tbl_visitdetails;

	$sql		= "
			select count(pagename) as Totals, accessdate from $tbl_log
			group by accessdate having accessdate='$rpt_date'";
	$total	= $this->GetValue($sql,"Totals");

	$sql 		= 
			"select pagename as Page_Visited,
			count(pagename) as Total_Visits,
			accessdate as Access_Date,
			accesshour as Access_Hour,
			MONTH(accessdate) as AccMonth,
			YEAR(accessdate) as AccYear 
			from $tbl_log group by Page_visited, Access_Date, Access_Hour 
			having Access_Date = '$rpt_date'";
	//print $sql;

	$curdate	= $this->FormatTime($rpt_date);
	$subheader	= "
			<table cellpadding=4 width=100%><tr bgcolor=#ebebeb><td>
			<font style=font-size:16px;><b>Report of Visits (Hourly-based)</b></font></td></tr>
			<tr><td>
				<a href=?act=show>Main Reports</a> &raquo; 
				<a href=?act=dailydetails&date=$rpt_date>Report on $curdate</a> &raquo;
				<b>Hourly-based Reports</b> &#8226; 
				<a href=?act=urlbased&date=$rpt_date>URL-based Reports</a> &#8226;
				<a href=?act=addressbased&date=$rpt_date>Address-based report</a>
			</td></tr>
			<tr bgcolor=#c6c6c6><td></td></tr>
			<tr><td bgcolor=#ffffff> Visits on $curdate</td></tr><tr><td>Total: <b>$total</b> visits</td></tr>
			</table>";

	$list	= array(
		"sql"			=> $sql,
		"header"		=> $this->VisitAdminHeader(),
		"subheader"		=> $subheader,
		"adminpage"		=> true,
		"noactions"		=> true,
		"noadminheader"	=> true,
		"disableadd"	=> true,
		"disablesearch"	=> true,
		"disablereferrer"	=> true,
		"disablepagelist"	=> true,
		"numitems"		=> 1000,
		"xopentag"		=> "
					<table cellpadding=10><tr bgcolor=#c6c6c6>
					<td>No.</td>
					<td>Access Date</td>
					<td>Access Hour</td>
					<td>Page Visited </td>
					<td>Total Visits</td>
					<!--<td>Actions</td>--></tr>",
		"autohead"		=> true,
		"altcolors"		=> array("#ebebeb","#ffffff"),
		"groupby"		=> $this->GetVar("orderby","Access_Hour"),
		"userowspan"	=> true,
		"grouptail"		=> "<tr bgcolor=#c6c6c6><td colspan=5></td></tr>",
		"fields"		=> array("Page_Visited","Total_Visits","Access_Date","Access_Hour","AccMonth","AccYear"),
		"layout"		=> "<tr bgcolor=%%ALTCOLOR%%>
					<td>%%NO%%</td>
					<td align=right>%%Access_Hour%%</td>
					<td width=300>%%Page_Visited%%</td>
					<td>%%Total_Visits%%</td>
					</tr>",
		"strformat"	=> array
					(
					"Access_Hour"	=> "concat(%%Access_Hour%%:00 - %%Access_Hour%%:59)",
					),
		"xprintsql"		=> true,
		);
	print $this->ProcessContent($list);
}

function CreateVisitTable() {
	$tbl_log 	= $this->tbl_visitdetails;

	$sql = "
	CREATE TABLE $tbl_log (
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
	)";

	$this->RunSql($sql); 
}

function ZeroPad($n,$len = 2) {
	return substr((str_repeat("0",$len).$n),(0-$len));
}

} // end class


?>
