<?
include("$DOCUMENT_ROOT/s/connection.php");
global $HTTP_HOST;

$GS["sitename"]         = "Timezone Indonesia";
$GS["sitekey"]          = "b0900cb8616bfa28138b3e96f72a8b0c";

//PRIMARY SECTION
$GS["dbaurl"]		= "http://$HTTP_HOST/cmsroom/phpMyAdmin/";
$GS["dbserver"]		= $dbhostname;
$GS["dbname"]		= $dbname;
$GS["dbpass"]		= $dbpassword;
$GS["dbuser"]		= $dbusername;
$GS["remotedb"]         = @$remotedb;
$GS["remoteuser"]       = @$remoteuser;
$GS["remotepass"]       = @$remotepass;


//GENERAL SETTING
$GS["numitems"]		= 20;			//number of items to show per page
$GS["recordvisit"]	= true;
$GS["stats_directory"]	= "stats";
$GS["basic_font"]       = "Tahoma";
$GS["basic_fontsize"]   = "8.5pt";
$GS["logaction"]        = true;
$GS["tbl_visit"]        = "cms_visitlog";
$GS["tbl_visitdetails"] = "cms_visitlog";
$GS["tbl_picture"]		= "tbl_picture";
$GS["tbl_uploads"]		= "tbl_upload";

//Upload Sections
$GS["imgpath"]		= "/i";
$GS["thumbpath"]	= "/i/th";
$GS["gallerypath"]      = "/i/gallery";
$GS["shopinfopath"]     = "/i/shopinfo";
$GS["uploadpath"]       = "/downloads/";
$GS["img_sortasc"]      = "<img src=/i/design/up.gif border=0>";
$GS["img_sortdesc"]     = "<img src=/i/design/down.gif border=0>";

//LIST COLOR SECTION
$GS["clr_head"]		= "#a7a7a7";
$GS["clr_row1"]		= "#ebebeb";
$GS["clr_row2"]		= "#ffffff";
$GS["clr_table"]	= "#ebebeb";
$GS["clr_headtext"]	= "#ffffff";

/* $GS["clr_head"]		= "red";
$GS["clr_row1"]		= "orange";
$GS["clr_row2"]		= "yellow";
$GS["clr_table"]	= "#ebebeb";
$GS["clr_headtext"]	= "orange"; */

//MSGBOX COLOR SECTION
$GS["clr_msghead"]	= "#a7a7a7";
$GS["clr_msgboxtitle"]	= "#ffffff";
$GS["clr_msgbox"]	= "#ebebeb";
$GS["clr_msgboxtext"]	= "#ff0000";
$GS["clr_msgboxpad"]	= "#e1e1e1";

//FORM COLOR SECTION
$GS["clr_form"]		= "#ebebeb";
$GS["clr_formhead"]	= "#a7a7a7";	    //"#003366";	//"#9999c6";	//
$GS["clr_formheadtext"] = "#ffffff";
$GS["clr_formsubhead"]	= "#e1e1e1";
$GS["clr_formsubtext"]	= "#000000";
$GS["clr_formcolumn1"]	= "#a7a7a7";
$GS["clr_formcolumn2"]	= "#ebebeb";
$GS["clr_columntext1"]  = "#ffffff";
$GS["clr_columntext2"]  = "#000000";

//SEARCH BOX SECTION
$GS["searchlabel"]      = "<img src=/i/design/cms/search.gif alt=Search></a>";
$GS["clr_searchhead"]	= "#a7a7a7";
$GS["clr_searchtext"]	= "#ffffff";
$GS["clr_searchbody"]	= "#ebebeb";

/* $GS["clr_searchhead"] = "red";
$GS["clr_searchtext"]	= "orange";
$GS["clr_searchbody"]	= "yellow"; */

//MESSAGE
$GS["norecords"]	= ""; // "No records found for this query";

//DEFAULT LAYOUT
$GS["adminheader"]	= "%%SEARCHBOX%%<br>%%ADD%% <br> %%PAGELIST%%<br><br>";
$GS["formlayout"]	= "<tr><td bgcolor=%%CLR_FORMCOLUMN1%% width=150 class=\"%%COLUMNCLASS1%%\"><font color=%%CLR_COLUMNTEXT1%%><b>%%INPUTLABEL%%</b></font></td>
			   <td bgcolor=%%CLR_FORMCOLUMN2%% class=\"%%COLUMNCLASS2%%\"><font color=%%CLR_COLUMNTEXT2%%>%%INPUT%%</font></td></tr>";
$GS["separator"]	= "<tr style='height:1px; padding:0px;' bgcolor=#c6c6c6 class=cms_separator height=1><td colspan=2 height=1 style='height:1px;padding:0px;'></td></tr>";
$GS["useseparator"]	= true;

?>
