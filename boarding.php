<?

include("$DOCUMENT_ROOT/s/BMSSA.php");
$dba	= new BMSSA();

include_once ("$DOCUMENT_ROOT/s/template.php");
$t		= new template;

include_once ("$DOCUMENT_ROOT/classes/functions.php");
$f		= new functions;

if ($act!="scan") include("header.php");

if (!$act || $act=="show") echo "<meta http-equiv=\"Refresh\" content=\"60;URL=boarding.php\" />";
else if ($act=="saveadd" || $act=="saveedit") echo "<meta http-equiv=\"Refresh\" content=\"1;URL=boarding.php\" />";
else if ($act=="scan") {}
else echo "<meta http-equiv=\"Refresh\" content=\"120;URL=boarding.php\" />";

if ($act!="scan") echo "<body onload=\"setBoardingPassFocus(); checkValidity(document.theform.npwp.value);\">";

if ($act == "scan") {

	$sql = "SELECT id FROM tbl_boarding WHERE boarding_number='".trim($boarding_number)."' or no_pasport='".trim($boarding_number)."' order by id desc";
	$rs=$db->Execute($sql);
	if(!$rs) print $db->ErrorMsg();	
	$row   =$rs->FetchRow();

	$keyid = $row['id'];

	if ($keyid) {
	header("location: boarding.php?act=edit&keyid=$keyid");
	exit();
	}
	else{
	header("location: boarding.php");
	exit();
	}
}

if ($act == "saveadd" || $act == "saveedit") {

	foreach ($HTTP_POST_VARS as $key=>$val) {
		$HTTP_POST_VARS[$key] = strtoupper($val);
	}
}
?>
<script>
function printPreviewPage(url) {

	//window.open(url, 'printpage');
	document.location.href=url;

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


var http = createRequestObject();

function checkValidity(npwp){

	randval=Math.random();
	npwp = npwp.replace(/[^\d]/g,"");
	document.theform.npwp.value=npwp;
	name=document.theform.name.value;
	document.getElementById('error').innerHTML='';

	if(npwp.length < 15){
		//alert('ada yang bukan digit');
	}else {

		document.getElementById('error').innerHTML='<img src=/i/loading2.gif> Check Validity..';
		var url ='validate_adv.php?send='+npwp+'|'+name+'&randval='+randval;
		http.open('get', url);
		http.onreadystatechange = handleResponsecheckValidity;
		http.send(null);
	}
}

function handleResponsecheckValidity() {
    if(http.readyState == 4){
		var response = http.responseText;
		check=/1/;
		output = response.split('||');
		document.getElementById('error').innerHTML=output[1];
		//alert('|'+output[0]+'|');
		//document.getElementById('npwp_match').value=1;
		if (output[0]=='1')
		{
			//alert('test');	
			document.getElementById('npwp_match').value=1;
			document.theform.fiscal_status.options[1].selected = true;
		}
		else if (output[0]=='0' && document.theform.family_status.options[0].selected == true && document.theform.skb.options[0].selected == true && document.theform.payment.value==0){
			//alert('test2');
			document.getElementById('npwp_match').value=0;
			document.theform.fiscal_status.options[0].selected = true;
		}
		else if (output[0]=='0'){
			//alert('test2');
			document.getElementById('npwp_match').value=0;
		}
		return true;
    }
}

function CheckAge(day,month,year){

	randval=Math.random();
	
	var url ='check_age.php?day='+day+'&month='+month+'&year='+year+'&randval='+randval;
	http.open('get', url);
	http.onreadystatechange = handleResponseCheckAge;
	http.send(null);
	
}

function handleResponseCheckAge() {
    if(http.readyState == 4){
		var response = http.responseText;
		document.theform.skb.options[response].selected = true;
		checkSKB(document.theform.skb.value);
		return true;
    }
}

function checkPassport(no_pasport){

	randval=Math.random();
	document.theform.no_pasport.value=no_pasport;
	document.getElementById('errorps').innerHTML='';

	if(no_pasport.length < 6){
		//alert('ada yang bukan digit');
	}else {

		document.getElementById('errorps').innerHTML='<img src=/i/loading2.gif> Check Passport..';
		var url ='validate_passport.php?send='+no_pasport+'&randval='+randval;
		http.open('get', url);
		http.onreadystatechange = handleResponsecheckPassport;
		http.send(null);
	}
}

function handleResponsecheckPassport() {
    if(http.readyState == 4){
	    var response = http.responseText;
	    var update = new Array();
	    var subCat	= new Array();
		var mydel=response.indexOf('||');
		if(response.indexOf('||') != -1) {
			update = response.split('||');
			
			var x;
			
			for(var i=0;i<(update.length-1);i++){
				var subCat=update[i].split(';;');	
				document.theform[subCat[0]].value = subCat[1];
			}
		} 
		checkValidity(document.theform.npwp.value);
		document.getElementById('errorps').innerHTML = '';
    }
}
function rtrim (str, chars) {

	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
function setBoardingPassFocus() {

	document.scanform.boarding_number.focus();

}
function checkFamily(value) {
	//alert(document.getElementById('npwp_match').value+'|'+document.theform.skb.options[0].selected);
	if (value==2)
	{
		document.theform.fiscal_status.options[1].selected = true;
	}
	else if (value==1 && document.getElementById('npwp_match').value==0 && document.theform.skb.options[0].selected == true && document.theform.payment.value==0)
	{
		document.theform.fiscal_status.options[0].selected = true;
	}
}
function checkSKB(value) {
	if (value>1)
	{
		document.theform.fiscal_status.options[1].selected = true;
	}
	else if (value==1 && document.getElementById('npwp_match').value==0 && document.theform.family_status.options[0].selected == true && document.theform.payment.value==0)
	{
		document.theform.fiscal_status.options[0].selected = true;
	}
}
function checkPayment(value) {
	if (value>0)
	{
		document.theform.fiscal_status.options[1].selected = true;
	}
	else if (value==0 && document.getElementById('npwp_match').value==0 && document.theform.family_status.options[0].selected == true && document.theform.skb.options[0].selected == true)
	{
		document.theform.fiscal_status.options[0].selected = true;
	}
}
</script>

<center>
<form method=get name=scanform>
<input type=hidden name=act value=scan>
<b>Boarding Pass : <input type="text" name="boarding_number" id="boarding_number"><input type="submit" value="  search  ">
<? if ($act=="edit") { ?>
 <input type=button value=" Print Fiscal " onClick="printPreviewPage('print_fiscal.php?keyid=<?=$keyid?>');"> <input type=button value=" Print SKB " onClick="printPreviewPage('print_skb.php?keyid=<?=$keyid?>');"> <input type=button value=" Print Fiscal Pass " onClick="printPreviewPage('print_fiscal_pass.php?keyid=<?=$keyid?>');">
<? } ?>
</form>
</center>
<?

title("Boarding Data","1");

if ($act == "edit") {

	$sql = "SELECT no_pasport, npwp, dayofmonth(issue_date) as issue_date_day, month(issue_date) as issue_date_month, year(issue_date) as issue_date_year, dayofmonth(expire_date) as expire_date_day, month(expire_date) as expire_date_month, year(expire_date) as expire_date_year, dayofmonth(departure_date) as departure_date_day, month(departure_date) as departure_date_month, year(departure_date) as departure_date_year, dayofmonth(residence_arrival_date) as residence_arrival_date_day, month(residence_arrival_date) as residence_arrival_date_month, year(residence_arrival_date) as residence_arrival_date_year, dayofmonth(residence_expire) as residence_expire_day, month(residence_expire) as residence_expire_month, year(residence_expire) as residence_expire_year, dayofmonth(birth_date) as birth_date_day, month(birth_date) as birth_date_month, year(birth_date) as birth_date_year, dayofmonth(family_dob) as family_dob_day, month(family_dob) as family_dob_month, year(family_dob) as family_dob_year, dayofmonth(departure_date) as departure_date_day, month(departure_date) as departure_date_month, year(departure_date) as departure_date_year, hour(departure_date) as departure_date_hour, minute(departure_date) as departure_date_minute, dayofmonth(entry_time) as entry_time_day, month(entry_time) as entry_time_month, year(entry_time) as entry_time_year, hour(entry_time) as entry_time_hour, minute(entry_time) as entry_time_minute, payment, family_status, family_name, skb, residence, residence_expire, npwp_match, fiscal_number, fiscal_status FROM tbl_boarding WHERE id=$keyid";
	$rs=$db->Execute($sql);
	if(!$rs) print $db->ErrorMsg();	
	$row   =$rs->FetchRow();

	foreach($row as $key1 => $val1){
		$key1=strtolower($key1);
		$$key1=$val1;

		//echo $key1." = ".$val1."<br>";
	}

	if ($fiscal_status==1) {
		$rowlayout = "<tr><td bgcolor=#00FF00><b>CLEAR</b></td><td bgcolor=#00FF00><input class=button_cancel type=button onClick=\"window.open('?act=show','_self');\" value=\"  Cancel  \"></td></tr>";
	}
	else if ($fiscal_status==2) {
		$rowlayout = "<tr><td bgcolor=#FFFF00 colspan=2><b>DEPARTED</b></td></tr>";
	}
	else {
		$rowlayout = "<tr><td bgcolor=#FF0000 colspan=2><b>NOT CLEAR</b></td></tr>";
	}
}



	if (!$issue_date_day) $issue_date_day = '00'; 
	if (!$issue_date_month) $issue_date_month = '00'; 
	if (!$issue_date_year) $issue_date_year = '0000'; 
	if (!$expire_date_day) $expire_date_day = '00'; 
	if (!$expire_date_month) $expire_date_month = '00'; 
	if (!$expire_date_year) $expire_date_year = '0000'; 
	if (!$birth_date_day) $birth_date_day = '00'; 
	if (!$birth_date_month) $birth_date_month = '00'; 
	if (!$birth_date_year) $birth_date_year = '0000'; 
	if (!$family_dob_day) $family_dob_day = '00'; 
	if (!$family_dob_month) $family_dob_month = '00'; 
	if (!$family_dob_year) $family_dob_year = '0000'; 
	if (!$departure_date_day) $departure_date_day = date('d'); 
	if (!$departure_date_month) $departure_date_month = date('m'); 
	if (!$departure_date_year) $departure_date_year = date('Y'); 
	if (!$departure_date_hour) $departure_date_hour = date('H'); 
	if (!$departure_date_minute) $departure_date_minute = date('i'); 
	if (!$entry_time_day) $entry_time_day = date('d'); 
	if (!$entry_time_month) $entry_time_month = date('m'); 
	if (!$entry_time_year) $entry_time_year = date('Y'); 
	if (!$entry_time_hour) $entry_time_hour = date('H'); 
	if (!$entry_time_minute) $entry_time_minute = date('i');
	if (!$residence_expire_day) $residence_expire_day = '00'; 
	if (!$residence_expire_month) $residence_expire_month = '00'; 
	if (!$residence_expire_year) $residence_expire_year = '0000'; 
	if (!$residence_arrival_date_day) $residence_arrival_date_day = '00'; 
	if (!$residence_arrival_date_month) $residence_arrival_date_month = '00'; 
	if (!$residence_arrival_date_year) $residence_arrival_date_year = '0000'; 

	if (!$family_status) $family_status = 1;
	if (!$skb) $skb=1;
	


/*===========================================================================================
CHECK PRIVILEGE
============================================================================================*/
/*
if(!preg_match("/index|attribute|copyright/i",$PHP_SELF)) {
	if($act=='add' || $act=='do_add'  || $act=='saveadd'){
		$f->checkaccess("add");
	}elseif($act=='update' || $act=='do_update' || $act=='saveedit'){
		$f->checkaccess("edit");
	}elseif($act=='delete'){
		$f->checkaccess("delete");
	}else{
		$f->checkaccess("read");
	}
}
*/

print $dba->AdminCSS();
//print $dba->UseAjax();

if ($_GET['searchfield']=='port') {

	$sql = "SELECT kd_pos FROM tbl_port WHERE nama LIKE '%".$_GET['query']."%'";
	$rs=$db->Execute($sql);
	if(!$rs) print $db->ErrorMsg();	
	$row   =$rs->FetchRow();

	//echo "<h1>".$row['kd_pos']."</h1>";

	$_GET['query'] = $row['kd_pos'];
}
//print_r($_GET);



//Get Array dari Tabel Lain ===============================================================================================
$gender_arr				= array("M", "F");
$status_kel_arr			= array(1=>"Owner", 2=>"Family");
$skb_arr				= $dba->storevaluepairs("select id_skb, concat(concat(id_skb,'. '), ket_bebas) as ket_bebas from tbl_skb","id_skb","ket_bebas",false);
$port_arr				= $dba->storevaluepairs("select kd_pos, nama from tbl_port","kd_pos","nama",false);
//End Get Array dari Tabel Lain ===============================================================================================

$list = array(
	"sql"			=> "select a.id, concat(a.name,'<br>',a.no_pasport,'/',a.nationality) as name, concat(a.boarding_number,'<br>',a.npwp) as boarding_number, concat(a.departure_date,'<br>',a.carrier_name,'<br>',a.destination) as departure_date, a.port, a.fiscal_status from tbl_boarding a",
	//"sqlparse"		=> false,
	//"printsql"		=> true,
	"primarykey"		=> "id",
	"initialsort"		=> "departure_date",
	"initialorder"		=> "desc",
	"fields"		=> array("name","boarding_number", "departure_date", "port", "fiscal_status"),
	"dbfields"		=> array("name","boarding_number", "departure_date", "port", "fiscal_status"),
	"labels"		=> array("boarding_number"=>"Boarding #<br>npwp", "name"=>"Name<br>No Passport", "departure_date"=>"Departure Date<br>Destination", "port"=>"Port Name"),
	"searchfields"		=> array("no_pasport", "port","name", "boarding_number", "npwp"),
	"horizontalmenu"	=> true,
	"addlabel"		=> "<a href=?act=add><img src=/i/new.gif border=0 alt=\"Add\"> Tambah Data Baru</a>",
	"editlabel"		=> "<img src=/i/edit.gif border=0 alt=\"Edit\"> ",
	"deletelabel"		=> "<img src=/i/delete.gif border=0 alt=\"Delete\"> ",
	"viewlabel"		=> "<img src=/i/view_log.gif border=0 alt=\"View\"> ",
	//"moreactions"		=> "<a href=?act=choose&keyid=%%kd_pers%%><img src=/i/load_package.gif border=0 alt=\"Pilih\"></a> ",
	//"tdwidth"		=> array(10,150,"50%","25%","25%"),
	"replace"		=> array("fiscal_status"=>array(""=>"Not Clear", 0=>"Not Clear", 1=>"Clear", 2=>"Departed"), "port"=>$port_arr),
	//"horizontalorder"	=> true,
	//"disableedit"		=> true,
	//"editlabel"		=> "<a href=form_recruitment_edit.php?act=edit&keyid=%%id%%&&referrer=%26>" EDIT</a>",
	"adminpage"		=> true,
	"numitems"		=> 20,
	//"disableedit"		=> $form_disableedit,
	///"disabledelete"	=> $form_disabledelete,
	//"disableview"		=> $form_disableview,
	//"disableadd"		=> $form_disableadd,
);


$form = array(
	"table"				=> "tbl_boarding",
	//"printsql"			=> TRUE,
	"primarykey"		=> "id",
	"allfields"			=> false,
	"showcancelbutton"	=> true,
	"title"				=> "   ",
	"whendone"			=> "act=jump",
	"showwhendone"		=> true,
	"showconfirmation"	=> false,
	"opentag"			=> "<div id=\"PassportPanel\" class=\"CollapsiblePanel\">
  <div class=\"CollapsiblePanelTab\" tabindex=\"0\">Passport</div>
  <div class=\"CollapsiblePanelContent\"><table border=0 cellspacing=1 cellpadding=5 width=100% bgcolor=#ebebeb><form name=theform method=post enctype=\"multipart/form-data\" action=/boarding.php>",
	"buttonrow"			=> "<tr><td bgcolor=%%CLR_SORTHEAD%%></td><td align=center bgcolor=%%CLR_FRMHEAD%%>%%BUTTONS%%</td></tr>",
	"titlerow"			=> " ",
	"validation"		=> array
							(
							"name"						=> array("validate"=>"must_fill", "warning"=>"Silahkan isi Nama"),
							"no_pasport"				=> array("validate"=>"must_fill", "warning"=>"Silahkan isi No Passport"),
							"gender"					=> array("validate"=>"must_fill", "warning"=>"Silahkan isi Gender"),
							"nationality"				=> array("validate"=>"must_fill", "warning"=>"Silahkan isi Nationality"),
							"birth_place"				=> array("validate"=>"must_fill", "warning"=>"Silahkan isi Birth Place"),
							"operator_name"				=> array("validate"=>"must_fill", "warning"=>"Silahkan isi Operator"),
							),
	"fields"			=> array (
							"id"						=> array("type"=>"hidden_autonumber"), 
							"separator0"				=> array("dbfield"=>false, "rowlayout"=>$rowlayout),
							"no_pasport"				=> array("type"=>"text", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>No Passport</b> </font></td><td xbgcolor=#ebebeb bgcolor=#ebebeb><font color=black><input type=text size=60 name=no_pasport id=no_pasport value=\"$no_pasport\" maxlength=15 onKeyUp=checkPassport(this.value);><div name=errorps id=errorps style=padding-left:3px;></div></font></td></tr>"),
							"name"						=> array("type"=>"text", "label"=>"Name"),
							"birth_date"				=> array("type"=>"dateselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Birth Date</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#ebebeb><font color=black><input name=birth_date_day size=2 maxlength=2 value=$birth_date_day onKeyUp='CheckAge(document.theform.birth_date_day.value,document.theform.birth_date_month.value,document.theform.birth_date_year.value);'> / <input name=birth_date_month size=2  maxlength=2 value=$birth_date_month onKeyUp='CheckAge(document.theform.birth_date_day.value,document.theform.birth_date_month.value,document.theform.birth_date_year.value);'> / <input name=birth_date_year size=4  maxlength=4 value=$birth_date_year onKeyUp='CheckAge(document.theform.birth_date_day.value,document.theform.birth_date_month.value,document.theform.birth_date_year.value);'></font></td></tr>"),
							"birth_place"				=> array("type"=>"text"),
							//"gender"					=> array("type"=>"select", "selection"=>$gender_arr),
							"gender"					=> array("type"=>"select", "selection"=>array("M"=>"M", "F"=>"F"), "js"=>"size=2", "inputcaption"=>"   <b>M:Male/Pria / F:Female/Wanita</b>"),
							//"gender"					=> array("type"=>"text", "size"=>"1 maxlength=1", "inputcaption"=>"   <b>M / F</b>"),
							"nationality"				=> array("type"=>"text"),
							"poi"						=> array("type"=>"text", "label"=>"Place of Issue"),
							"issue_date"				=> array("type"=>"dateselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Issue Date</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#ebebeb><font color=black><input name=issue_date_day size=2 maxlength=2 value=$issue_date_day> / <input name=issue_date_month size=2  maxlength=2 value=$issue_date_month> / <input name=issue_date_year size=4  maxlength=4 value=$issue_date_year></font></td></tr>"),
							"expire_date"				=> array("type"=>"dateselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Expire Date</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#ebebeb><font color=black><input name=expire_date_day size=2 maxlength=2 value=$expire_date_day> / <input name=expire_date_month size=2  maxlength=2 value=$expire_date_month> / <input name=expire_date_year size=4  maxlength=4 value=$expire_date_year></font></td></tr>"),
							"separator1"				=> array("dbfield"=>false, "rowlayout"=>"</table></div></div><div id=\"TicketPanel\" class=\"CollapsiblePanel\"><div class=\"CollapsiblePanelTab\" tabindex=\"0\">Ticket</div><div class=\"CollapsiblePanelContent\"><table border=0 cellspacing=1 cellpadding=5 width=95%  bgcolor=#ebebeb>"),
							"carrier_name"				=> array("type"=>"text"),
							"carrier_number"			=> array("type"=>"text", "label"=>"Carrier Code"),
							"destination"				=> array("type"=>"text"),
							"departure_date"			=> array("type"=>"datetimeselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Departure Time</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#d9d9d9><font color=black><input name=departure_date_day size=2 maxlength=2 value=$departure_date_day  > / <input name=departure_date_month size=2 maxlength=2 value=$departure_date_month  > / <input name=departure_date_year  size=4 maxlength=4 value=$departure_date_year >      <input name=departure_date_hour  size=2 maxlength=2 value=$departure_date_hour > : <input name=departure_date_minute  size=2 maxlength=2 value=$departure_date_minute ></font></td></tr>"),
							"boarding_number"			=> array("type"=>"text"),
							"separator2"				=> array("dbfield"=>false, "rowlayout"=>"</table></div></div><div id=\"OperatorPanel\" class=\"CollapsiblePanel\"><div class=\"CollapsiblePanelTab\" tabindex=\"0\">Operator</div><div class=\"CollapsiblePanelContent\"><table border=0 cellspacing=1 cellpadding=5 width=95%  bgcolor=#ebebeb>"),
							"operator_name"				=> array("type"=>"text"),
							"entry_time"				=> array("type"=>"datetimeselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Entry Time</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#d9d9d9><font color=black><input name=entry_time_day size=2 maxlength=2 value=$entry_time_day readonly > / <input name=entry_time_month size=2 maxlength=2 value=$entry_time_month  readonly > / <input name=entry_time_year  size=4 maxlength=4 value=$entry_time_year  readonly>      <input name=entry_time_hour  size=2 maxlength=2 value=$entry_time_hour  readonly > : <input name=entry_time_minute  size=2 maxlength=2 value=$entry_time_minute  readonly></font></td></tr>"),
							"separator3"				=> array("dbfield"=>false, "rowlayout"=>"</table></div></div><div id=\"TaxPanel\" class=\"CollapsiblePanel\"><div class=\"CollapsiblePanelTab\" tabindex=\"0\">Tax</div><div class=\"CollapsiblePanelContent\"><table border=0 cellspacing=1 cellpadding=5 width=95%  bgcolor=#ebebeb>"),
							"npwp"						=> array("type"=>"text", "label"=>"NPWP", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>NPWP</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#d9d9d9><font color=black><input type=text size=60 name=npwp id=npwp value=\"$npwp\" maxlength=15 onKeyUp=checkValidity(this.value);> without dash(-) or dot(.)<div name=error id=error style=padding-left:3px;></div></font></td></tr>" ),
							"npwp_match"				=> array("type"=>"hidden"),
							"family_status"				=> array("type"=>"select", "selection"=>$status_kel_arr, "js"=>"size=2 onChange='checkFamily(this.value);'", "label"=>" "),
							//"family_status"				=> array("type"=>"text", "size"=>"1 maxlength=1", "inputcaption"=>"   <b>1:Owner / 2:Family</b>", "label"=>" "),
							"family_name"				=> array("type"=>"select", "selection"=>array(""=>" ","1"=>"Spouse/Pasangan", "2"=>"Child/Anak Kandung", "3"=>"Parents/Orang Tua", "4"=>"Step Child/Anak Tiri", "5"=>"Parents in Law/Mertua", "6"=>"Adopted Child/Anak Angkat"), "js"=>"size=7", "label"=>" "),
							"kk_number"					=> array("type"=>"text", "label"=>"Family Card Number"),
							//"family_name"				=> array("type"=>"text", "size"=>"1 maxlength=1", "inputcaption"=>"   <b>S:Spouse / C:Child / P:Parents</b>", "label"=>" "),
							"skb"						=> array("type"=>"select", "selection"=>$skb_arr, "js"=>"size=16 onChange='checkSKB(this.value);'", "label"=>"Bebas FLN", "inputcaption"=>" <br><table><tr><td>2-9</td><td>: Bebas Otomatis</td></tr><tr><td>10-16</td><td>: Bebas dengan SKB FLN</td></tr></table>"),
							"skb_number"				=> array("type"=>"text", "label"=>"SKB Number"),
							"residence"					=> array("type"=>"text", "label"=>"Residence Country"),
							"residence_expire"			=> array("type"=>"dateselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Residence Expire</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#ebebeb><font color=black><input name=residence_expire_day size=2 maxlength=2 value=$residence_expire_day> / <input name=residence_expire_month size=2  maxlength=2 value=$residence_expire_month> / <input name=residence_expire_year size=4  maxlength=4 value=$residence_expire_year></font></td></tr>"),
							"residence_id"					=> array("type"=>"text", "label"=>"Residence ID"),
							"residence_arrival_date"		=> array("type"=>"dateselect", "rowlayout"=>"<tr><td bgcolor=#666666 width=140 valign=top><font color=white><b>Residence Arrival Date</b> </font></td><td xbgcolor=#d9d9d9 bgcolor=#ebebeb><font color=black><input name=residence_arrival_date_day size=2 maxlength=2 value=$residence_arrival_date_day> / <input name=residence_arrival_date_month size=2  maxlength=2 value=$residence_arrival_date_month> / <input name=residence_arrival_date_year size=4  maxlength=4 value=$residence_arrival_date_year></font></td></tr>"),
							"tki_ktkln_number"			=> array("type"=>"text", "label"=>"KTKLN Number"),
							"separator4"				=> array("dbfield"=>false, "rowlayout"=>"</table></div></div><div id=\"PaymentPanel\" class=\"CollapsiblePanel\"><div class=\"CollapsiblePanelTab\" tabindex=\"0\">Payment</div><div class=\"CollapsiblePanelContent\"><table border=0 cellspacing=1 cellpadding=5 width=95%  bgcolor=#ebebeb>"),
							"payment"					=> array("type"=>"select", "default"=>"0", "selection"=>array("0"=>"0", "1000000"=>"1.000.000"), "js"=>"size=2"),
							"fiscal_number"				=> array("type"=>"text"),
							"separator5"				=> array("dbfield"=>false, "rowlayout"=>"</table></div></div><table border=0 cellspacing=1 cellpadding=5 width=95%  bgcolor=#ebebeb><tr><td bgcolor=#FFFFFF colspan=2>Fiscal Status</td></tr>"),
							"fiscal_status"				=> array("type"=>"select", "selection"=>array(0=>"Not Clear", 1=>"Clear", 2=>"Departed")),
	
		)
);

print $dba->ProcessAdmin($form,$list);

if ($act == "saveadd" || $act == "saveedit") {

	$sql = "SELECT count(*) as num FROM mfpaspor WHERE no_pasport='".$_POST['no_pasport']."'";
	$rs=$db->Execute($sql);
	if(!$rs) print $db->ErrorMsg();	
	$row   =$rs->FetchRow();

	$num = $row['num'];

	//echo "<h1>$num</h1>";

	if ($num>0) {

		$sql = "UPDATE mfpaspor SET name='".$_POST['name']."', gender='".$_POST['gender']."', birth_date='".$_POST['birth_date_year']."-".$_POST['birth_date_month']."-".$_POST['birth_date_day']."',  birth_place='".$_POST['birth_place']."',  issue_date='".$_POST['issue_date_year']."-".$_POST['issue_date_month']."-".$_POST['issue_date_day']."', expire_date='".$_POST['expire_date_year']."-".$_POST['expire_date_month']."-".$_POST['expire_date_day']."', poi='".$_POST['poi']."', nationality='".$_POST['nationality']."', npwp='".$_POST['npwp']."', family_status='".$_POST['family_status']."', family_name='".$_POST['family_name']."' where  no_pasport='".$_POST['no_pasport']."'";

	} else {

		$sql = "INSERT INTO mfpaspor (no_pasport, name, gender, birth_date, birth_place, issue_date, expire_date, poi, nationality, npwp, family_status, family_name) VALUES ('".$_POST['no_pasport']."', '".$_POST['name']."', '".$_POST['gender']."', '".$_POST['birth_date_year']."-".$_POST['birth_date_month']."-".$_POST['birth_date_day']."',  '".$_POST['birth_place']."',  '".$_POST['issue_date_year']."-".$_POST['issue_date_month']."-".$_POST['issue_date_day']."', '".$_POST['expire_date_year']."-".$_POST['expire_date_month']."-".$_POST['expire_date_day']."', '".$_POST['poi']."', '".$_POST['nationality']."', '".$_POST['npwp']."', '".$_POST['family_status']."', '".$_POST['family_name']."')";


	}

	$f->passenger_log($_POST['boarding_number'], "counter fiskal", date('Y-m-d H:i:s'), $login_name);

	$rs=$db->Execute($sql);
	if(!$rs) print $db->ErrorMsg();	
}
if ($act=="edit" || $act=="view") {
	?>
	<script type="text/javascript">
	<!--
	var PassportPanel = new Spry.Widget.CollapsiblePanel("PassportPanel");
	var TicketPanel = new Spry.Widget.CollapsiblePanel("TicketPanel");
	var OperatorPanel = new Spry.Widget.CollapsiblePanel("OperatorPanel");
	var TaxPanel = new Spry.Widget.CollapsiblePanel("TaxPanel");
	var PaymentPanel = new Spry.Widget.CollapsiblePanel("PaymentPanel");
		
<?
	if ($f->getinquiryaccess("ManagePassport") != "Yes") {
		?>
		PassportPanel.enableAnimation = false;
		PassportPanel.close();
		PassportPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManageTicket") != "Yes") {
		?>
		TicketPanel.enableAnimation = false;
		TicketPanel.close();
		TicketPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManageOperator") != "Yes") {
		?>
		OperatorPanel.enableAnimation = false;
		OperatorPanel.close();
		OperatorPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManageTax") != "Yes") {
		?>
		TaxPanel.enableAnimation = false;
		TaxPanel.close();
		TaxPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManagePayment") != "Yes") {
		?>
		PaymentPanel.enableAnimation = false;
		PaymentPanel.close();
		PaymentPanel.enableAnimation = true;
		<?
	}
?>
	
	checkValidity(document.theform.npwp.value);	//CheckAge(document.theform.birth_date_day.value,document.theform.birth_date_month.value,document.theform.birth_date_year.value);

	//-->
	</script>
	<?
}
else if ($act == "add") {
?>
	<script type="text/javascript">
	<!--
	var PassportPanel = new Spry.Widget.CollapsiblePanel("PassportPanel");
	var TicketPanel = new Spry.Widget.CollapsiblePanel("TicketPanel");
	var OperatorPanel = new Spry.Widget.CollapsiblePanel("OperatorPanel");
	var TaxPanel = new Spry.Widget.CollapsiblePanel("TaxPanel");
	var PaymentPanel = new Spry.Widget.CollapsiblePanel("PaymentPanel");
		
<?
	if ($f->getinquiryaccess("ManagePassport") != "Yes") {
		?>
		PassportPanel.enableAnimation = false;
		PassportPanel.close();
		PassportPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManageTicket") != "Yes") {
		?>
		TicketPanel.enableAnimation = false;
		TicketPanel.close();
		TicketPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManageOperator") != "Yes") {
		?>
		OperatorPanel.enableAnimation = false;
		OperatorPanel.close();
		OperatorPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManageTax") != "Yes") {
		?>
		TaxPanel.enableAnimation = false;
		TaxPanel.close();
		TaxPanel.enableAnimation = true;
		<?
	}
	if ($f->getinquiryaccess("ManagePayment") != "Yes") {
		?>
		PaymentPanel.enableAnimation = false;
		PaymentPanel.close();
		PaymentPanel.enableAnimation = true;
		<?
	}

	?>
		document.theform.skb.options[0].selected = true;
		document.theform.family_status.options[0].selected = true;
	</script>
<?
}


include "footer.php";
?>