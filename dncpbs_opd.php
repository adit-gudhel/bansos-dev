<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
require_once("$DOCUMENT_ROOT/classes/PHPExcel/Classes/PHPExcel/IOFactory.php");
$today = date("Y-m-d");

$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Bantuan Sosial &raquo; Data Evaluasi OPD &raquo; Download DNCPBS');

$filepath = "$DOCUMENT_ROOT/docs/";

foreach ($_POST as $key=>$val) {
        $$key = $val;
}

$sql = "select a.kode, b.opd_nama, YEAR(a.ba_tgl) as tahun from tbl_berita_acara a, tbl_opd b where a.id=$id and a.opd_kode=b.opd_kode";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
		

if(empty($row['kode'])){
	echo "<a href=evaluasi_bansos_opd.php>Tidak ada DNCPBS</a>";
} else {
	$kode = $row['kode'];
	$tahun = $row['tahun'];
	$opd_nama = $row['opd_nama'];
	
	//generate excel
	include 'docs/dncpbs_opd.inc.php';
	
	require_once 'classes/PHPExcel/Classes/PHPExcel/IOFactory.php';
		
	$filename = "dncpbs-opd-".$id.".xls";
		
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save(UPLOAD_PATH . $filename);
	
	echo "<a href=".UPLOAD_PATH . $filename.">Download</a>";	
		
}
		
		
$t->basicfooter();
?>