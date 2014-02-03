<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$f->checkaccess();

$sql="select * from tbl_setting";
$result=$f->get_last_record($sql);
foreach($result as $key=>$val){
    $$key=$val;
#   echo"$key - $val<BR>";
}

echo"
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">
<head>
<title>$title</title>
<link href=\"/prototipe.css \" rel=stylesheet type=text/css>
</head>
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0 bgcolor=\"$page_color\">
";

function checkQuickForm($judul) {
    global $db, $login_access;
    
    $sql = "SELECT count(*) as num FROM tbl_functionaccess a
            LEFT JOIN tbl_menu b on a.menu_id=b.nomorurut 
            WHERE a.name='$login_access' and b.judul='$judul'";
    $result=$db->Execute($sql);
    $row=$result->Fetchrow();
    $num = $row['num'];
    
    if ($num<1) return FALSE;
    else return TRUE;
}


?>
<script type="text/javascript" src="jquery.masonry.min.js"></script>
<link rel="stylesheet" href="front.css" />
<div id="container" class="clearfix">

<div class="box col3">
    <table><tr><td><img src="/images/button_correct.gif" width="32"></td><td> Selamat datang di Sistem Informasi Bantuan Sosial dan Hibah Pemerintah Kota Bogor</td></tr></table>
</div>

<div class="box col2">
    <div class="boxtitle">QUICK FORM HIBAH</div>
    <?
    if (checkQuickForm('Pendaftaran Hibah')) echo "<a href=# onclick=\"window.parent.addTab('Pendaftaran Hibah','hibah.php?act=add')\"><div class=\"button\">Pendaftaran Hibah</div></a>";
	if (checkQuickForm('Evaluasi Hibah OPD')) echo "<a href=# onclick=\"window.parent.addTab('Evaluasi Hibah OPD','evaluasi_hibah_opd.php?act=add')\"><div class=\"button\">Evaluasi Hibah OPD</div></a>";
	if (checkQuickForm('Pertimbangan Hibah TAPD')) echo "<a href=# onclick=\"window.parent.addTab('Pertimbangan Hibah TAPD','evaluasi_hibah_tapd.php?act=add')\"><div class=\"button\">Pertimbangan Hibah TAPD</div></a>";
	if (checkQuickForm('Daftar Nama Penerima Hibah')) echo "<a href=# onclick=\"window.parent.addTab('Daftar Nama Penerima Hibah','penerima_hibah.php')\"><div class=\"button\">Daftar Penerima Hibah</div></a>";
	if (checkQuickForm('Pencairan Hibah')) echo "<a href=# onclick=\"window.parent.addTab('Pencairan Hibah','pencairan_hibah.php?act=add')\"><div class=\"button\">Pencairan Hibah</div></a>";
	if (checkQuickForm('Monitoring dan Evaluasi Hibah')) echo "<a href=# onclick=\"window.parent.addTab('Monitoring dan Evaluasi Hibah','monev_hibah.php?act=add')\"><div class=\"button\">Monitoring dan Evaluasi Hibah</div></a>";
	if (checkQuickForm('LPJ Hibah')) echo "<a href=# onclick=\"window.parent.addTab('LPJ Hibah','lpj_hibah.php?act=add')\"><div class=\"button\">Laporan Pertanggungjawaban Hibah</div></a>";
    ?>
    
</div>
<?
	$last_login = explode(' ',$login_last_login); 
?>
<div class="box col1">
    <div class="boxtitle">INFO LOGIN</div>
    <table class="index">
    	<tr><td><b>Nama</b></td><td><?=$login_full_name?></td></tr>
    	<tr><td><b>Login Terakhir</b></td><td><? echo $f->convertdatetime(array("datetime"=>$last_login[0]))." ".$last_login[1]; ?></td></tr>
    	<tr><td><b>IP</b></td><td><?=$login_ip?></td></tr>
    	<tr><td><b>Username</b></td><td><?=$login_username?></td></tr>
    	<tr><td class="last"><b>Akses</b></td><td class="last"><?=$login_access_detail?></td></tr>
    </table>
</div>
<div class="box col2">
    <div class="boxtitle">QUICK FORM BANTUAN SOSIAL</div>
    <?
    if (checkQuickForm('Pendaftaran Bantuan Sosial')) echo "<a href=# onclick=\"window.parent.addTab('Pendaftaran Bantuan Sosial','bansos.php?act=add')\"><div class=\"button\">Pendaftaran Bantuan Sosial</div></a>";
	if (checkQuickForm('Evaluasi Bantuan Sosial OPD')) echo "<a href=# onclick=\"window.parent.addTab('Evaluasi Bantuan Sosial OPD','evaluasi_bansos_opd.php?act=add')\"><div class=\"button\">Evaluasi Bantuan Sosial OPD</div></a>";
	if (checkQuickForm('Pertimbangan Bantuan Sosial TAPD')) echo "<a href=# onclick=\"window.parent.addTab('Pertimbangan Bantuan Sosial TAPD','evaluasi_bansos_tapd.php?act=add')\"><div class=\"button\">Pertimbangan Bantuan Sosial TAPD</div></a>";
	if (checkQuickForm('Daftar Nama Penerima Bantuan Sosial')) echo "<a href=# onclick=\"window.parent.addTab('Daftar Nama Penerima Bantuan Sosial','penerima_bansos.php')\"><div class=\"button\">Daftar Penerima Bantuan Sosial</div></a>";
	if (checkQuickForm('Pencairan Bantuan Sosial')) echo "<a href=# onclick=\"window.parent.addTab('Pencairan Bantuan Sosial','pencairan_bansos.php?act=add')\"><div class=\"button\">Pencairan Bantuan Sosial</div></a>";
	if (checkQuickForm('Monitoring dan Evaluasi Bantuan Sosial')) echo "<a href=# onclick=\"window.parent.addTab('Monitoring dan Evaluasi Bantuan Sosial','monev_bansos.php?act=add')\"><div class=\"button\">Monitoring dan Evaluasi Bantuan Sosial</div></a>";
	if (checkQuickForm('LPJ Bansos')) echo "<a href=# onclick=\"window.parent.addTab('LPJ Bansos','lpj_bansos.php?act=add')\"><div class=\"button\">Laporan Pertanggungjawaban Bantuan Sosial</div></a>";
    ?>
</div>

</div>


<?
echo "
</body>
</html>";
?>