<?php
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
require_once("$DOCUMENT_ROOT/classes/PHPExcel/Classes/PHPExcel/IOFactory.php");

$today = date("Y-m-d");

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
		
	require_once 'classes/PHPExcel/Classes/PHPExcel/IOFactory.php';
	$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
	$rendererLibrary = 'domPDF0.6.0beta3';
	$rendererLibraryPath = 'classes/' . $rendererLibrary;
		
	$objPHPExcel->setActiveSheetIndex(1);
	$objPHPExcel->getActiveSheet()->setShowGridLines(false);
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setShowGridLines(false);
	
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
	if (!PHPExcel_Settings::setPdfRenderer(
			$rendererName,
			$rendererLibraryPath
		)) {
		die(
			'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
			EOL .
			'at the top of this script as appropriate for your directory structure'
		);
	}
		
	$filename = "dncpbs-opd-".$id.".pdf";
	$filepath = 'docs/'.$filename;
		
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
	$objWriter->writeAllSheets();
	$objWriter->save(UPLOAD_PATH . $filename);
	
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="' . $filename . '"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($file));
	header('Accept-Ranges: bytes');
	
	ob_clean();

	@readfile(UPLOAD_PATH . $filename);	
		
}
?>