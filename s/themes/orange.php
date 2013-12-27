<?
// "Alternate Settings";
$GS["altcolors"]         = array("FFDC87","#F8E4B4");
$GS["altcolors2"]        = array("#DD7200","orange");
$GS["altfrmcolors"]      = array("orange");
$GS["altfrmcolors2"]     = array("#FFDC87","#F8E4B4");
$GS["alttxtcolors"]      = array("black");
$GS["alttxtcolors2"]     = array("white","black");
$GS["altattrib"]         = array("");
$GS["altattrib2"]        = array("");
$GS["altrcolors"]        = array("#FFE6C2","#FCEDD6");

// "Color Settings";
$GS["clr_head"]          = "#E57C00";
$GS["clr_rhead"]         = "#F7BA64";
$GS["clr_sorthead"]      = "maroon";
$GS["clr_headtext"]      = "white";
$GS["clr_rheadtext"]     = "maroon";
$GS["clr_bgtable"]       = "#F7BA64"; //"#EC910E";
$GS["clr_rbgtable"]      = "#F7BA64"; //"#EC910E";
$GS["clr_row"]           = "#F8E4B4";
$GS["clr_rowtext"]       = "black";
$GS["clr_frmhead"]       = "#E57C00";
$GS["clr_frmbgtable"]    = "#EC910E";
$GS["clr_frmheadtext"]   = "white";
$GS["clr_frmcolumn1"]    = "#a0a0a0";
$GS["clr_frmcolumn2"]    = "#ebebeb";
$GS["clr_frmtext1"]      = "white";
$GS["clr_frmtext2"]      = "black";
$GS["clr_buttonrow"]     = "#EC910E";
$GS["clr_link"]          = "maroon";

// "Label Settings";
$GS["addlabel"]          = "<table cellpadding=2 cellspacing=0 align=left><tr><td>&nbsp;&nbsp;<a href=?act=add%%MOREADDVARS%%><font color=%%CLR_LINK%%><b>+ Add a new Record</b></font></a>&nbsp;&nbsp;</td></tr></table>";
$GS["editlabel"]         = "&#8226; EDIT";
$GS["deletelabel"]       = "&#8226; DELETE";
$GS["viewlabel"]         = "&#8226; VIEW";

// "Layout Settings";
$GS["searchbar"]         = "%%SEARCHBOX%%";
$GS["adminbar"]          = "<table cellpadding=10 cellspacing=0 width=100%><tr><td>%%ADD%%</td><td>%%PAGELIST%%</td><td align=right>%%SEARCHBAR%%</td></tr></table>";
$GS["tblattrib"]         = "border=0 cellspacing=1 cellpadding=5 width=100% bgcolor=%%CLR_BGTABLE%%";
$GS["tdhead"]            = "<td bgcolor=%%CLR_HEAD%%><a href=?%%SORTLINK_FIELDNAME%%><font color=%%CLR_HEADTEXT%%><b>%%FIELDNAME%%</b></font></a> %%SORTMARK%%</td>";
$GS["tdheadsort"]        = "<td bgcolor=%%CLR_SORTHEAD%%><a href=?%%SORTLINK_FIELDNAME%%><font color=%%CLR_HEADTEXT%%><b>%%FIELDNAME%%</b></font></a>&nbsp;&nbsp;%%SORTMARK%%</td>";
$GS["tdheadnosort"]      = "<td bgcolor=%%CLR_HEAD%%><font color=%%CLR_HEADTEXT%%><b>%%FIELDNAME%%</b></font></td>";
$GS["tdlayout"]          = "<td bgcolor=%%ALTCOLOR%%><font color=%%ALTTXTCOLOR%%>%%FIELDNAME%%</font>&nbsp;</td>";
$GS["tdsortlayout"]      = "<td bgcolor=%%ALTCOLOR2%%><font color=%%ALTTXTCOLOR2%%><b>%%FIELDNAME%%</b></font>&nbsp;</td>";
$GS["contentwrapper"]	 = "<table width=100% cellpadding=0 cellspacing=0 
									style='background: url(/s/themes/i/orange_bg.jpg) repeat-x; padding:3px;
									border: solid %%CLR_HEAD%% 1px;'><tr><td><tr><td>%%__PROCESSCONTENT__%%</td></tr></table>";

// "Form Layout";
$GS["frmtblattrib"]      = "align=center border=0 cellspacing=1 cellpadding=5 width=780 bgcolor=%%CLR_FRMBGTABLE%%";
$GS["titlerow"]          = "<tr><td></td><td bgcolor=%%CLR_FRMHEAD%% align=center><font color=%%CLR_HEADTEXT%%><b>%%TITLE%%</b></font></td></tr>";
$GS["rowlayout"]         = "<tr><td bgcolor=%%ALTCOLOR%% width=140><font color=%%CLR_FRMTEXT1%%><b>%%LABEL%%</b></font></td><td xbgcolor=%%CLR_FRMCOLUMN2%% bgcolor=%%ALTCOLOR2%%><font color=%%CLR_FRMTEXT2%%>%%INPUT%%</font></td></tr>";
$GS["buttonrow"]         = "<tr><td></td><td align=center bgcolor=%%CLR_FRMHEAD%%>%%BUTTONS%%</td></tr>";


// "Table Layout";
$GS["tdheadnumbering"]   = "<td bgcolor=%%CLR_HEAD%% align=right><font color=%%CLR_HEADTEXT%%><b>No.</b>&nbsp;</font></td>";
$GS["tdheadaction"]      = "<td bgcolor=%%CLR_HEAD%% align=center nowrap><font color=%%CLR_HEADTEXT%%><b>Action</b>&nbsp;</font></td>";
$GS["tdnumbering"]       = "<td bgcolor=white align=right>%%NO%%.&nbsp;</td>";
$GS["tdaction"]          = "<td bgcolor=%%ALTCOLOR%% align=left nowrap>%%DEFAULT_ACTION%%&nbsp;</td>";
$GS["tdheadrownum"]      = "<td bgcolor=%%CLR_HEAD%% align=right><font color=%%CLR_HEADTEXT%%><b>Row No.</b>&nbsp;</font></td>";
$GS["tdrownum"]          = "<td bgcolor=%%ALTCOLOR%% align=right>%%ROWNUM%%.&nbsp;</font></td>";

// "Images";
$GS["img_sort_up"]       = "/i/sys/sort_up.gif";
$GS["img_sort_down"]     = "/i/sys/sort_down.gif";

// "number of items shown in table";
$GS["numitems"]          = "20";

// "Pagelist Layout";
$GS["1_opentag"]         = "<span class=navinfo>&nbsp; Found %%RECORDCOUNT%% records in %%PAGECOUNT%% pages. </span>";
$GS["1_closetag"]        = " <br><br>";
$GS["1_firstlabel"]      = "<span class=navselected>&nbsp;<b>First</b>&nbsp;</span>";
$GS["1_lastlabel"]       = "<span class=navselected>&nbsp;<b>Last</b>&nbsp;</span>";
$GS["1_firstlabel2"]     = "<span class=nav>&nbsp;First&nbsp;</span>";
$GS["1_lastlabel2"]      = "<span class=nav>&nbsp;Last&nbsp;</span>";
$GS["1_prevlabel"]       = "<span class=navselected>&nbsp; &lt; &nbsp;</span>";
$GS["1_nextlabel"]       = "<span class=navselected>&nbsp; &gt; &nbsp;</span>";
$GS["1_prevlabel2"]      = "<span class=nav>&nbsp; &lt; &nbsp;</span>";
$GS["1_nextlabel2"]      = "<span class=nav>&nbsp; &gt; &nbsp;</span>";
$GS["1_pagenumber"]      = "<span class=page>&nbsp;%%PAGENUMBER%%&nbsp;</span>";
$GS["1_pageselected"]    = "&nbsp;<span class=pageselected><font color=black>&nbsp;<b>%%PAGENUMBER%%</b>&nbsp;</font></span>";
$GS["1_maxlinks"]        = "5";

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
?>
