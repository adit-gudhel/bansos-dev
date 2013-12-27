<?
//colors
$GS["altcolors"]			= array("white","#ebebeb");
$GS["altcolor1"]			= "white";
$GS["altcolor2"]			= "#ebebeb";
$GS["altcolors2"]			= array("#ebebeb","#d9d9d9");
$GS["altfrmcolors"]     = array("#4973B9");
$GS["altfrmcolors2"]    = array("#D4DEF0","#E7EDF7");
$GS["altrcolors"]			= array("#D4DEF0","#E7EDF7");
$GS["alttxtcolors"]		= array("black","black");
$GS["alttxtcolors2"]		= array("black","black");

$GS["clr_head"]			= "#666666";
$GS["clr_rhead"]			= "#A0B7DC";
$GS["clr_sorthead"]		= "#333333";
$GS["clr_headtext"]		= "white";
$GS["clr_row"]				= "#E7EDF7";
$GS["clr_rowtext"]		= "black";
$GS["clr_bgtable"]      = "#ebebeb";
$GS["clr_frmhead"]      = "#4973B9";
$GS["clr_frmbgtable"]   = "#A0B7DC";
$GS["clr_frmheadtext"]  = "white";
$GS["clr_frmcolumn1"]   = "#A0B7DC";
$GS["clr_frmcolumn2"]   = "#E7EDF7";
$GS["clr_frmtext1"]     = "white";
$GS["clr_frmtext2"]     = "black";
$GS["clr_buttonrow"]		= "white";
$GS["clr_link"]         = "#003366";
$GS["horizontalmenu"]	= true;

// "Label Settings";
$GS["addlabel"]          = "<table cellpadding=2 cellspacing=0 align=left><tr><td>&nbsp;&nbsp;<a href=?act=add%%MOREADDVARS%%><font color=%%CLR_LINK%%><b>+ Tambah Data Baru</b></font></a>&nbsp;&nbsp;</td></tr></table>";
$GS["editlabel"]         = "&#8226; UBAH";
$GS["deletelabel"]       = "&#8226; HAPUS";
$GS["viewlabel"]         = "_none_";

// "Layout Settings";
$GS["searchbar"]         = "%%SEARCHBOX%%";
$GS["adminbar"]          = "<table cellpadding=10 cellspacing=0 width=95% align=center><tr><td>%%ADD%%</td><td align=center>%%PAGELIST%%</td><td align=right>%%SEARCHBAR%%</td></tr></table>";
$GS["tblattrib"]         = "border=0 cellspacing=0 cellpadding=5 width=95% align=center bgcolor=%%CLR_BGTABLE%%";
$GS["tdhead"]            = "<td class=tdbg3 align=center>&nbsp;<a href=?%%SORTLINK_FIELDNAME%%><font color=black><b>%%FIELDNAME%%</b></font></a> %%SORTMARK%%</td>";
$GS["tdheadsort"]        = "
<td class=tdbg2 align=center bgcolor=%%CLR_SORTHEAD%%>&nbsp;<a href=?%%SORTLINK_FIELDNAME%%><font color=white><b>%%FIELDNAME%%</b></font></a>&nbsp;&nbsp;%%SORTMARK%%</td>
<td class=tdbg4 bgcolor=%%CLR_SORTHEAD%%>&nbsp;</td>";
$GS["tdheadnosort"]      = "<td class=tdbg3>&nbsp;<font color=black>%%FIELDNAME%%</font></td>";
$GS["tdlayout"]          = "<td bgcolor=%%ALTCOLOR%% class=bottomline><font color=%%ALTTXTCOLOR%%>%%FIELDNAME%%</font>&nbsp;</td>";
$GS["tdsortlayout"]      = "<td bgcolor=%%ALTCOLOR2%% class=bottomline colspan=2><font color=%%ALTTXTCOLOR2%%>%%FIELDNAME%%</font>&nbsp;</td>";
$GS["fieldorder"]			 = array(100=>"DEFAULT_ACTION");
$GS["contentwrapper"]	 = "";
$GS["initialorder"]		 = "desc";

// "Form Layout";
$GS["frmtblattrib"]      = "class=tbl align=center border=0 cellspacing=0 cellpadding=2 align=left bgcolor=white";
$GS["titlerow"]          = "<tr><td colspan=2 valign=top height=60
style='padding-top:13px; margin-top: 13px; background: url(/i/siskka/tdtitle_row.jpg) top left no-repeat;' align=center><b class=PageTitle>%%TITLE%%</b></td></tr>";
$GS["rowlayout"]         = "<tr><td width=150 style='padding-left: 10px;' valign=top>%%LABEL%% <MandatoryMark></td><td><font color=%%CLR_FRMTEXT2%% style='padding-right:10px;'>%%INPUT%% &nbsp;</font></td></tr>";
$GS["captcharow"]        = "<tr><td width=150 style='padding-left: 10px;' valign=middle>%%LABEL%%</td><td>%%CAPTCHA%%</td></tr>";
$GS["captchalabel"]		 = "Kode Keamanan";
$GS["buttonrow"]         = "<tr><td colspan=2>&nbsp;</td></tr><tr><td class=tdbuttonrow colspan=2 align=center bgcolor=%%CLR_BUTTONROW%%>%%BUTTONS%%</td></tr>";

// "Table Layout";
$GS["tdheadnumbering"]   = "<td class=tdbg align=center><font color=black>No.&nbsp;</font></td>";
$GS["tdheadaction"]      = "<td class=tdbg align=center nowrap><font color=black>Actions&nbsp;</font></td>";
$GS["tdnumbering"]       = "<td bgcolor=white align=right class=bottomline>%%NO%%.&nbsp;</td>";
$GS["tdaction"]          = "<td bgcolor=%%ALTCOLOR%% align=center nowrap class=bottomline>%%DEFAULT_ACTION%%&nbsp;</td>";
$GS["tdheadrownum"]      = "<td bgcolor=%%CLR_HEAD%%><font color=%%CLR_HEADTEXT%%><b>Row No.</b>&nbsp;</font></td>";
$GS["tdrownum"]          = "<td bgcolor=%%ALTCOLOR%% align=center>%%ROWNUM%%.&nbsp;</font></td>";

// "Images";
$GS["img_sort_up"]       = "/i/sys/sort_up.gif";
$GS["img_sort_down"]     = "/i/sys/sort_down.gif";

// "number of items shown in table";
$GS["numitems"]          = "20";
$GS["confirmmessage"]	 = "Simpan sekarang?";
$GS["cancelcaption"]		 = " &laquo; Kembali ";
$GS["submitcaption"]		 = " Simpan &raquo;";

// "Pagelist Layout";

$GS["1_opentag"]         = "<span class=pagelistinfo>&nbsp; Terdapat %%RECORDCOUNT%% %%RECORDNAME%% pada %%PAGECOUNT%% halaman. </span>";
$GS["1_closetag"]        = " <br>";
$GS["1_firstlabel"]      = "<span class=pagelistinfo>&nbsp;<b>Awal</b>&nbsp;</span>";
$GS["1_lastlabel"]       = "<span class=pagelistinfo>&nbsp;<b>Akhir</b>&nbsp;</span>";
$GS["1_firstlabel2"]     = "<span class=pagelistinfo>&nbsp;Awal&nbsp;</span>";
$GS["1_lastlabel2"]      = "<span class=pagelistinfo>&nbsp;Akhir&nbsp;</span>";
$GS["1_prevlabel"]       = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["1_nextlabel"]       = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["1_prevlabel2"]      = "<span class=pagelistinfo>&nbsp; &lt; &nbsp;</span>";
$GS["1_nextlabel2"]      = "<span class=pagelistinfo>&nbsp; &gt; &nbsp;</span>";
$GS["1_pagenumber"]      = "<span class=pagelistinfo>&nbsp; %%PAGENUMBER%%&nbsp;</span>";
$GS["1_pageselected"]    = "&nbsp;<span><font color=black>&nbsp;<b>%%PAGENUMBER%%</b>&nbsp;</font></span>";
$GS["1_maxlinks"]        = "5";

$GS["2_opentag"]         = "<span class=pagelistinfo>&nbsp; Ditemukan %%RECORDCOUNT%% %%RECORDNAME%% di %%PAGECOUNT%% halaman. </span>";
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
	<table cellpadding=5 cellspacing=1 align=center width=200 bgcolor=#ebebeb>
	<tr><td align=center bgcolor=%%CLR_HEAD%%><font color=%%CLR_FRMHEADTEXT%%>
	<font color=%%CLR_FRMHEADTEXT%%><b>%%CAPTION%%</b></font></td></tr>
	<tr bgcolor=#ebebeb><td align=center height=50><p>%%MESSAGE%%</p></td></tr>
	<tr><td align=center bgcolor=%%CLR_BUTTONROW%%><font color=%%CLR_LINK%%>%%BUTTON%%</font></td>
	</table>";

$GS["reportbox"]         = "
	<table class=tblborder cellpadding=4 align=left width=100%>
	<tr><td align=left bgcolor=%%CLR_HEAD%%><font color=%%CLR_HEADTEXT%%><b>%%CAPTION%%</b></font></td></tr>
	<tr><td align=left><p>%%MESSAGE%%</p></td></tr>
	</table><br clear=left>";

$GS["css"]					=
"
	a						{ text-decoration: none; color: #003366; }
	a:hover				{ text-decoration: underline;}
	a:visited			{ text-decoration: none;}
	a:active				{ text-decoration: none; }
	a:link				{ text-decoration: none;}
	#print				{ width: 90%; }
	#print td			{ padding: 1px; width:
							  font-family: Tahoma, Verdana, Arial; font-size: 11px; }
	td                { padding-left: 5px; padding: 3px; font-family: Tahoma, Verdana, Arial; font-size: 11px; }
	tr                { font-family: Tahoma, Verdana, Arial; font-size: 11px; }
	body	{
		background: #FFFFFF url(/i/siskka/bg_blue.jpg) bottom left fixed repeat-x;
		color: #333;
		margin: 0 15% 0 15%; padding: 0; border: 0;
		font-family: Tahoma, Verdana, Arial;
		font-size: 11px;
		xborder-top: 5px solid #0066CC;
		padding-bottom: 15px;
		}
	input,select      { font-family: Tahoma, Verdana, Arial; font-size: 11px; }

	.page a           { text-decoration:none; color: %%CLR_HEAD%%; }
	.navselected      { text-decoration:none; color: black; border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.nav              { text-decoration:none; color: %%CLR_HEAD%%; border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.navinfo          { text-decoration:none; color: black; border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.page             { border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 2px; background-color: white;}
	.pageselected     { border: solid %%CLR_HEAD%% 1; margin: 1px; padding: 5px; background-color: %%CLR_ROW%%;}
	.bottomline			{ border-bottom:solid #c6c6c6 1px; border-left: dashed #c9c9c9 1px; }
	.tdbg					{ padding-top:20px; border-bottom: solid black 2px; background: url('/i/siskka/tdheadbg_blue.jpg') #c6c6c6;}
	.tdbg3				{ padding-top:20px; border-left: none black 1px; border-bottom: solid black 2px; background: url(/i/siskka/tdheadbg_blue.jpg) #c6c6c6; }
	.tdbg2				{ border-bottom: solid black 2px; background: url('/i/siskka/tdheadbg4_blue.jpg') #999999; }
	.tdbg4				{ border-bottom: solid black 2px; background: #ffffff url('/i/siskka/tdheadbg4_blue2.jpg') top right; }
	.tdinput				{ padding: 8px; border-bottom: solid #ebebeb 1px;  }
	.inputborder		{ padding: 8px; border-bottom: dashed #c6c6c6 1px; background: #ebebeb}
	.PageTitle			{ font-family: Georgia,Arial; font-size:15px; color: black; text-align:center; }
	.tbl					{ border-bottom: solid #99CCFF 1px;
 							  background-color: white;
							  border-left: solid #99CCFF 1px; border-top: solid #99CCFF 1px;
							  border-right: solid #99CCFF 1px;}
	.tblmsg				{ border-bottom: solid #99CCFF 1px;
 							  background-color: white;
							  border-left: solid #99CCFF 1px; border-top: solid #99CCFF 0px;
							  border-right: solid #99CCFF 1px;}
	.tdsep				{ border-left: solid #999999 1px; }
	.childtbl, td		{ padding-top: 3px; padding-left: 4px; }
	.tdrowhead			{ padding-left: 10px; line-height: 30px; }
	.tdrow				{ padding-left: 10px; }
	.tdbuttonrow		{ padding: 10px; background: #FFFFFF url('/i/siskka/tdbutton_row.jpg'); }
	.noborder			{ border: none white 0px; font-family: Verdana, Arial; font-size: 8pt; }
	.boxit				{ padding: 2px; border: solid #c6c6c6 1px; margin: 1px; }
	.invisible			{ padding: 2px; border: none; margin: 1px; }
	P.pagebreak 		{ page-break-after: always; }
	.button				{ background-color: #ebebeb; color: black; padding: 10px; border: solid #c6c6c6 1px; margin: 5px; line-height:40px; }
	.smallbutton		{ background-color: #ebebeb; color: black; padding: 3px; border: solid #c6c6c6 1px; }
";
?>
