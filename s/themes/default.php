<?
//colors
$GS["altcolors"]			= array("white","#ebebeb");
$GS["altcolor1"]			= "white";
$GS["altcolor2"]			= "#ebebeb";
$GS["altcolors2"]			= array("#ebebeb","#d9d9d9");
$GS["altfrmcolors"]     = array("#666666");
$GS["altfrmcolors2"]    = array("#ebebeb","#d9d9d9");
$GS["altrcolors"]			= array("#ebebeb","#d9d9d9");
$GS["alttxtcolors"]		= array("black","black");
$GS["alttxtcolors2"]		= array("black","black");

$GS["clr_head"]			= "#000000";
$GS["clr_rhead"]			= "#000000";
$GS["clr_sorthead"]		= "#000000";
$GS["clr_headtext"]		= "white";
$GS["clr_row"]				= "#ebebeb";
$GS["clr_rowtext"]		= "black";
$GS["clr_bgtable"]      = "#ebebeb";
$GS["clr_frmhead"]      = "#000000";
$GS["clr_frmbgtable"]   = "#ebebeb";
$GS["clr_frmheadtext"]  = "white";
$GS["clr_frmcolumn1"]   = "#ebebeb";
$GS["clr_frmcolumn2"]   = "#d9d9d9";
$GS["clr_frmtext1"]     = "white";
$GS["clr_frmtext2"]     = "black";
$GS["clr_buttonrow"]		= "white";
$GS["clr_link"]         = "#1F4D9A";
$GS["horizontalmenu"]	= true;

// "Label Settings";
$GS["addlabel"]          = "<table cellpadding=2 cellspacing=0 align=left><tr><td>&nbsp;&nbsp;<a href=?act=add%%MOREADDVARS%%><font color=%%CLR_LINK%%><b>+ Add a new Record</b></font></a>&nbsp;&nbsp;</td></tr></table>";
$GS["editlabel"]         = "&#8226; EDIT";
$GS["deletelabel"]       = "&#8226; DELETE";
$GS["viewlabel"]         = "&#8226; VIEW";

// "Layout Settings";
$GS["searchbar"]         = "%%SEARCHBOX%%";
$GS["adminbar"]          = "<table cellpadding=10 cellspacing=0 width=95%><tr><td>%%ADD%%</td><td align=center>%%PAGELIST%%</td><td align=right>%%SEARCHBAR%%</td></tr></table>";
$GS["tblattrib"]         = "border=0 cellspacing=0 cellpadding=5 width=95% bgcolor=%%CLR_BGTABLE%%";
$GS["tdhead"]            = "<td bgcolor=%%CLR_HEAD%%><a href=?%%SORTLINK_FIELDNAME%%><font color=%%CLR_HEADTEXT%%><b>%%FIELDNAME%%</b></font></a> %%SORTMARK%%</td>";
$GS["tdheadsort"]        = "<td bgcolor=%%CLR_SORTHEAD%%><a href=?%%SORTLINK_FIELDNAME%%><font color=%%CLR_HEADTEXT%%><b>%%FIELDNAME%%</b></font></a>&nbsp;&nbsp;%%SORTMARK%%</td>";
$GS["tdheadnosort"]      = "<td bgcolor=%%CLR_HEAD%%><font color=%%CLR_HEADTEXT%%><b>%%FIELDNAME%%</b></font></td>";
$GS["tdlayout"]          = "<td bgcolor=%%ALTCOLOR%% style='border-bottom:solid %%CLR_BGTABLE%% 1px;'><font color=%%ALTTXTCOLOR%%>%%FIELDNAME%%</font>&nbsp;</td>";
$GS["tdsortlayout"]      = "<td bgcolor=%%ALTCOLOR2%% style='border-bottom:solid %%CLR_BGTABLE%% 1px;'><font color=%%ALTTXTCOLOR2%%><b>%%FIELDNAME%%</b></font>&nbsp;</td>";
$GS["fieldorder"]			 = array(0=>"DEFAULT_ACTION");
$GS["contentwrapper"]	 = "";

// "Form Layout";
$GS["frmtblattrib"]      = "border=0 cellspacing=1 cellpadding=5 width=95% bgcolor=%%CLR_FRMBGTABLE%%";
$GS["titlerow"]          = "<tr><td bgcolor=%%CLR_SORTHEAD%%></td><td bgcolor=%%CLR_FRMHEAD%% align=center><font color=%%CLR_HEADTEXT%%><b>%%TITLE%%</b></font></td></tr>";
$GS["rowlayout"]         = "<tr><td bgcolor=%%ALTCOLOR%% width=140 valign=top><font color=%%CLR_FRMTEXT1%%><b>%%LABEL%%</b> <MandatoryMark></font></td><td xbgcolor=%%CLR_FRMCOLUMN2%% bgcolor=%%ALTCOLOR2%%><font color=%%CLR_FRMTEXT2%%>%%INPUT%%</font></td></tr>";
$GS["buttonrow"]         = "<tr><td bgcolor=%%CLR_SORTHEAD%%></td><td align=center bgcolor=%%CLR_FRMHEAD%%>%%BUTTONS%%</td></tr>";


// "Table Layout";
$GS["tdheadnumbering"]   = "<td bgcolor=%%CLR_HEAD%% align=right><font color=%%CLR_HEADTEXT%%><b>No.</b>&nbsp;</font></td>";
$GS["tdheadaction"]      = "<td bgcolor=%%CLR_HEAD%% align=center nowrap><font color=%%CLR_HEADTEXT%%><b>Action</b>&nbsp;</font></td>";
$GS["tdnumbering"]       = "<td bgcolor=white align=right style='border: solid %%CLR_BGTABLE%% 0px; border-width: 0 1 1 1;'>%%NO%%.&nbsp;</td>";
$GS["tdaction"]          = "<td bgcolor=%%ALTCOLOR%% align=center nowrap style='border-bottom:solid %%CLR_BGTABLE%% 1px;'>%%DEFAULT_ACTION%%&nbsp;</td>";
$GS["tdheadrownum"]      = "<td bgcolor=%%CLR_HEAD%% align=right><font color=%%CLR_HEADTEXT%%><b>Row No.</b>&nbsp;</font></td>";
$GS["tdrownum"]          = "<td bgcolor=%%ALTCOLOR%% align=right>%%ROWNUM%%.&nbsp;</font></td>";

// "Images";
$GS["img_sort_up"]       = "/i/sys/sort_up.gif";
$GS["img_sort_down"]     = "/i/sys/sort_down.gif";

// "number of items shown in table";
$GS["numitems"]          = "20";

// "Pagelist Layout";
$GS["1_opentag"]         = "<span class=pagelistinfo>&nbsp; Terdapat %%RECORDCOUNT%% %%RECORDNAME%% pada %%PAGECOUNT%% halaman. </span><br>";
$GS["1_closetag"]        = " <br>";
$GS["1_firstlabel"]      = "<span class=pagelistinfo>&nbsp;<b>First</b>&nbsp;</span>";
$GS["1_lastlabel"]       = "<span class=pagelistinfo>&nbsp;<b>Last</b>&nbsp;</span>";
$GS["1_firstlabel2"]     = "<span class=pagelistinfo>&nbsp;First&nbsp;</span>";
$GS["1_lastlabel2"]      = "<span class=pagelistinfo>&nbsp;Last&nbsp;</span>";
$GS["1_prevlabel"]       = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["1_nextlabel"]       = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["1_prevlabel2"]      = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["1_nextlabel2"]      = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["1_pagenumber"]      = "<span class=pagelistinfo>&nbsp; %%PAGENUMBER%%&nbsp;</span>";
$GS["1_pageselected"]    = "&nbsp;<span><font color=black>&nbsp;<b>%%PAGENUMBER%%</b>&nbsp;</font></span>";
$GS["1_maxlinks"]        = "5";

$GS["2_opentag"]         = "<span class=pagelistinfo>&nbsp; Ditemukan %%RECORDCOUNT%% %%RECORDNAME%% di %%PAGECOUNT%% halaman. </span><br>";
$GS["2_closetag"]        = " <br>";
$GS["2_firstlabel"]      = "<span class=pagelistinfo>&nbsp;<b>Awal</b>&nbsp;</span>";
$GS["2_lastlabel"]       = "<span class=pagelistinfo>&nbsp;<b>Akhir</b>&nbsp;</span>";
$GS["2_firstlabel2"]     = "<span class=pagelistinfo>&nbsp;Awal&nbsp;</span>";
$GS["2_lastlabel2"]      = "<span class=pagelistinfo>&nbsp;Akhir&nbsp;</span>";
$GS["2_prevlabel"]       = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["2_nextlabel"]       = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["2_prevlabel2"]      = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["2_nextlabel2"]      = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["2_pagenumber"]      = "<span class=pagelistinfo>&nbsp; %%PAGENUMBER%%&nbsp;</span>";
$GS["2_pageselected"]    = "&nbsp;<span><font color=black>&nbsp;<b>%%PAGENUMBER%%</b>&nbsp;</font></span>";
$GS["2_maxlinks"]        = "5";

$GS["3_opentag"]         = "<span class=pagelistinfo>&nbsp; Ditemukan %%RECORDCOUNT%% %%RECORDNAME%% di %%PAGECOUNT%% halaman. </span>";
$GS["3_closetag"]        = " ";
$GS["3_firstlabel"]      = "<span class=pagelistinfo>&nbsp;<b>Awal</b>&nbsp;</span>";
$GS["3_lastlabel"]       = "<span class=pagelistinfo>&nbsp;<b>Akhir</b>&nbsp;</span>";
$GS["3_firstlabel2"]     = "<span class=pagelistinfo>&nbsp;Awal&nbsp;</span>";
$GS["3_lastlabel2"]      = "<span class=pagelistinfo>&nbsp;Akhir&nbsp;</span>";
$GS["3_prevlabel"]       = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["3_nextlabel"]       = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["3_prevlabel2"]      = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["3_nextlabel2"]      = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["3_pagenumber"]      = "<span class=pagelistinfo>&nbsp; %%PAGENUMBER%%&nbsp;</span>";
$GS["3_pageselected"]    = "&nbsp;<span><font color=black>&nbsp;<b>%%PAGENUMBER%%</b>&nbsp;</font></span>";
$GS["3_maxlinks"]        = "10";

// "MessageBox/ReportBox Layout";
$GS["messagebox"]        = "
	<table cellpadding=4 align=center width=200>
	<tr><td align=center bgcolor=%%CLR_HEAD%%><font color=%%CLR_FRMHEADTEXT%%>
	<font color=%%CLR_FRMHEADTEXT%%><b>%%CAPTION%%</b></font></td></tr>
	<tr bgcolor=%%CLR_ROW%%><td align=center height=50><p>%%MESSAGE%%</p></td></tr>
	<tr><td align=center bgcolor=%%CLR_BUTTONROW%%><font color=%%CLR_LINK%%>%%BUTTON%%</font></td>
	</table>";

$GS["reportbox"]         = "
	<table class=tblborder cellpadding=4 align=left width=100%>
	<tr><td align=left bgcolor=%%CLR_HEAD%%><font color=%%CLR_HEADTEXT%%><b>%%CAPTION%%</b></font></td></tr>
	<tr><td align=left><p>%%MESSAGE%%</p></td></tr>
	</table><br clear=left>";

$GS["css"]					=
"
	a						{ text-decoration: none; }
	a:hover				{ text-decoration: underline; }
	a:visited			{ text-decoration: none; }
	a:active				{ text-decoration: none; }
	a:link				{ text-decoration: none; }
	td                { font-family: Tahoma, Verdana, Arial; font-size: 11px; }
	tr                { font-family: Tahoma, Verdana, Arial; font-size: 11px; }
	body              { font-family: Tahoma, Verdana, Arial; font-size: 11px; }
	input,select      { font-family: Tahoma, Verdana, Arial; font-size: 11px; }

	.page a           { text-decoration:none; color: %%CLR_HEAD%%; }
	.navselected      { text-decoration:none; color: black; border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.nav              { text-decoration:none; color: %%CLR_HEAD%%; border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.navinfo          { text-decoration:none; color: black; border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.page             { border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.pageselected     { border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 5px; background-color: %%CLR_ROW%%;}
";
?>
