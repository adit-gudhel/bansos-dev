<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 */

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../classes/PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Aditya Nursyahbani")
							 ->setLastModifiedBy("Aditya Nursyahbani")
							 ->setTitle("Laporan Pertanggungjawaban")
							 ->setSubject("Laporan Pertanggungjawaban")
							 ->setDescription("Laporan Pertanggungjawaban Hibah dan Bantuan Sosial")
							 ->setKeywords("laporan, lpj")
							 ->setCategory("report");


// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);

$AS = $objPHPExcel->getActiveSheet();

// Header
$AS->mergeCells('A1:G1');
$AS->setCellValue('A1', 'LAPORAN PERTANGGUNGJAWABAN HIBAH');
$AS->mergeCells('A2:G2');
$AS->setCellValue('A2', '');

$arr_status = array("Belum Mengumpulkan","Sudah Mengumpulkan");

// Main Table
$AS->setCellValue('A4', 'NO');
$AS->setCellValue('B4', 'NAMA PENERIMA');
$AS->setCellValue('C4', 'ALAMAT PENERIMA');
$AS->setCellValue('D4', 'JUMLAH UANG (Rp)');
$AS->setCellValue('E4', 'TANGGAL LPJ');
$AS->setCellValue('F4', 'URAIAN');
$AS->setCellValue('G4', 'STATUS');

$AS->setCellValue('A5', '1');
$AS->setCellValue('B5', '2');
$AS->setCellValue('C5', '3');
$AS->setCellValue('D5', '4');
$AS->setCellValue('E5', '5');
$AS->setCellValue('F5', '6');
$AS->setCellValue('G5', '7');

$sql = "SELECT a.tgl_cair, b.lpj_tgl,b.lpj_uraian, v.nama, v.alamat, v.kelurahan, v.kecamatan, v.kota, v.propinsi, v.hasil_evaluasi_tapd as jumlah_uang FROM tbl_cair_hibah a LEFT JOIN v_dncpbh_tapd v ON a.hib_kode=v.hib_kode LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode WHERE YEAR(a.tgl_cair)='$thn' AND (v.status_opd = 1 AND v.status_tapd = 1) ORDER BY b.lpj_uraian ASC";
$result=$db->Execute($sql);

$total_rows = $result->NumRows();
$start_row=6;
$i=0;
while($row=$result->Fetchrow()){
	foreach($row as $key => $val){
		$$key=$val;
	}
    $i++;
	$AS->setCellValue('A'.$start_row.'', $i);
	$AS->setCellValue('B'.$start_row.'', $nama);
	$AS->setCellValue('C'.$start_row.'', ''.$alamat.' Kel. '.ucwords(strtolower($kelurahan)).' Kec. '.ucwords(strtolower($kecamatan)).' '.ucwords(strtolower($kota)).', '.ucwords(strtolower($propinsi)).'');
	$AS->setCellValue('D'.$start_row.'', $jumlah_uang);
	$AS->setCellValue('E'.$start_row.'', $lpj_tgl);
	$AS->setCellValue('F'.$start_row.'', $lpj_uraian);
	
	if(empty($lpj_uraian)){
		$sts = $arr_status[0]; }
	else {
		$sts = $arr_status[1]; }
		
	$AS->setCellValue('G'.$start_row.'', $sts);
	
	$start_row++;
}

$AS->mergeCells('A'.$start_row.':C'.$start_row.'');
$AS->setCellValue('A'.$start_row.'', 'Total');
$AS->setCellValue('D'.$start_row.'', '=SUM(D6:D'.($start_row - 1).')');
$AS->setCellValue('E'.$start_row.'', '');
$AS->setCellValue('F'.$start_row.'', '');
$AS->setCellValue('G'.$start_row.'', '');

//Summary
$summary_row = $start_row + 2;

/*
//Cair
$sql ="SELECT SUM(v.hasil_evaluasi_tapd) as total_cair FROM v_dncpbh_tapd v LEFT JOIN tbl_hibah h on v.hib_kode=h.hib_kode WHERE YEAR(v.tgl_ba)='$thn' AND (v.status_opd = 1 AND v.status_tapd = 1) AND h.hib_cair=1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();

$AS->setCellValue('B'.$summary_row.'', 'Total Cair');
$AS->setCellValue('C'.$summary_row.'', $row['total_cair']);

$sql ="SELECT count(*) as jml_cair FROM v_dncpbh_tapd v LEFT JOIN tbl_hibah h on v.hib_kode=h.hib_kode WHERE YEAR(v.tgl_ba)='$thn' AND (v.status_opd = 1 AND v.status_tapd = 1) AND h.hib_cair=1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();

$AS->setCellValue('D'.$summary_row.'', 'Jumlah Cair');
$AS->setCellValue('E'.$summary_row.'', $row['jml_cair']);


//Belum Cair
$sql ="SELECT SUM(v.hasil_evaluasi_tapd) as total_blm_cair FROM v_dncpbh_tapd v LEFT JOIN tbl_hibah h on v.hib_kode=h.hib_kode WHERE YEAR(v.tgl_ba)='$thn' AND (v.status_opd = 1 AND v.status_tapd = 1) AND h.hib_cair=0";
$result=$db->Execute($sql);
$row = $result->Fetchrow();

$AS->setCellValue('B'.($summary_row + 1).'', 'Total Belum Cair');
$AS->setCellValue('C'.($summary_row + 1).'', $row['total_blm_cair']);

$sql ="SELECT count(*) as jml_blm_cair FROM v_dncpbh_tapd v LEFT JOIN tbl_hibah h on v.hib_kode=h.hib_kode WHERE YEAR(v.tgl_ba)='$thn' AND (v.status_opd = 1 AND v.status_tapd = 1) AND h.hib_cair=0";
$result=$db->Execute($sql);
$row = $result->Fetchrow();

$AS->setCellValue('D'.($summary_row + 1).'', 'Jumlah Belum Cair');
$AS->setCellValue('E'.($summary_row + 1).'', $row['jml_blm_cair']);
*/


// Define Style
$formatJudul = 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'bold'		=> TRUE,
		'size'		=> 12
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

$formatIsi= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	)
);

$formatIsiCenter= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

$formatIsiLeft= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	)
);

$formatIsiLeftB= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'bold'		=> TRUE,
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	)
);

$formatIsiRight= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	)
);

$formatTableCenter= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
	),
	'borders' => array(
		'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN,
      			'color' => array(
      				'rgb' => '808080'
      			)
     	)
	)
);

$formatTableCenterB= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10,
		'bold'		=> TRUE
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
	),
	'borders' => array(
		'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN,
      			'color' => array(
      				'rgb' => '808080'
      			)
     	)
	)
);

$formatTableCenterI= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10,
		'italic'	=> TRUE
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
	),
	'borders' => array(
		'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN,
      			'color' => array(
      				'rgb' => '808080'
      			)
     	)
	)
);

$formatTableCenterT= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP, 
	),
	'borders' => array(
		'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN,
      			'color' => array(
      				'rgb' => '808080'
      			)
     	)
	)
);

$formatTableLeft= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP, 
	),
	'borders' => array(
		'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN,
      			'color' => array(
      				'rgb' => '808080'
      			)
     	)
	)
);

$formatTableRight= 
array(
	'font'    => array(
		'name'		=> 'Times New Roman',
		'size'		=> 10
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP, 
	),
	'borders' => array(
		'allborders' => array(
      		'style' => PHPExcel_Style_Border::BORDER_THIN,
      			'color' => array(
      				'rgb' => '808080'
      			)
     	)
	)
);

$AS->getStyle('A1:A2')->applyFromArray($formatJudul);
$AS->getStyle('A4:G4')->applyFromArray($formatTableCenterB);
$AS->getStyle('A5:G5')->applyFromArray($formatTableCenterI);


$AS->getStyle('A6:A'.($start_row).'')->applyFromArray($formatTableCenterT);
$AS->getStyle('B6:C'.($start_row).'')->applyFromArray($formatTableLeft);
$AS->getStyle('D6:D'.($start_row).'')->applyFromArray($formatTableRight);
$AS->getStyle('E6:E'.($start_row).'')->applyFromArray($formatTableLeft);
$AS->getStyle('F6:F'.($start_row).'')->applyFromArray($formatTableLeft);
$AS->getStyle('G6:G'.($start_row).'')->applyFromArray($formatTableLeft);

$AS->getStyle('B6:B'.($start_row).'')->getAlignment()->setWrapText(true);
$AS->getStyle('C6:C'.($start_row).'')->getAlignment()->setWrapText(true);
$AS->getStyle('F6:F'.($start_row).'')->getAlignment()->setWrapText(true);

$AS->getStyle('D6:D'.($start_row).'')->getNumberFormat()->applyFromArray(
	array(
		'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1	
	)
);

//$AS->getStyle('B'.($summary_row).':E'.($summary_row + 1).'')->applyFromArray($formatIsiLeftB);


// Set column widths
$AS->getColumnDimension('A')->setWidth(4);
$AS->getColumnDimension('B')->setWidth(20);
$AS->getColumnDimension('C')->setWidth(35);
$AS->getColumnDimension('D')->setWidth(25);
$AS->getColumnDimension('E')->setWidth(25);
$AS->getColumnDimension('F')->setWidth(25);
$AS->getColumnDimension('G')->setWidth(25);

// Set page orientation and size
$AS->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$AS->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$AS->getPageSetup()->setFitToPage(TRUE);
$AS->getPageSetup()->setHorizontalCentered(true);

$AS->getPageMargins()->setLeft(0.5);
$AS->getPageMargins()->setRight(0.5);

$AS->setTitle('Hibah');

//-----------------------------------------------------------------------------------------------------------------

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);
$AS2 = $objPHPExcel->getActiveSheet();

// Header
$AS2->mergeCells('A1:G1');
$AS2->setCellValue('A1', 'LAPORAN PERTANGGUNGJAWABAN BANTUAN SOSIAL');
$AS2->mergeCells('A2:G2');
$AS2->setCellValue('A2', '');

// Main Table
$AS2->setCellValue('A4', 'NO');
$AS2->setCellValue('B4', 'NAMA PENERIMA');
$AS2->setCellValue('C4', 'ALAMAT PENERIMA');
$AS2->setCellValue('D4', 'JUMLAH UANG (Rp)');
$AS2->setCellValue('E4', 'TANGGAL LPJ');
$AS2->setCellValue('F4', 'URAIAN');
$AS2->setCellValue('G4', 'STATUS');

$AS2->setCellValue('A5', '1');
$AS2->setCellValue('B5', '2');
$AS2->setCellValue('C5', '3');
$AS2->setCellValue('D5', '4');
$AS2->setCellValue('E5', '5');
$AS2->setCellValue('F5', '6');
$AS2->setCellValue('G5', '7');

$sql = "SELECT a.tgl_cair, b.lpj_tgl,b.lpj_uraian, v.nama, v.alamat, v.kelurahan, v.kecamatan, v.kota, v.propinsi, v.hasil_evaluasi_tapd as jumlah_uang FROM tbl_cair_bansos a LEFT JOIN v_dncpbs_tapd v ON a.ban_kode=v.ban_kode LEFT JOIN tbl_bansos b ON a.ban_kode=b.ban_kode WHERE YEAR(a.tgl_cair)='$thn' AND (v.status_opd = 1 AND v.status_tapd = 1) ORDER BY b.lpj_uraian ASC";
$result=$db->Execute($sql);

$total_rows = $result->NumRows();
$start_row=6;
$i=0;
while($row=$result->Fetchrow()){
	foreach($row as $key => $val){
		$$key=$val;
	}
    $i++;
	$AS2->setCellValue('A'.$start_row.'', $i);
	$AS2->setCellValue('B'.$start_row.'', $nama);
	$AS2->setCellValue('C'.$start_row.'', ''.$alamat.' Kel. '.ucwords(strtolower($kelurahan)).' Kec. '.ucwords(strtolower($kecamatan)).' '.ucwords(strtolower($kota)).', '.ucwords(strtolower($propinsi)).'');
	$AS2->setCellValue('D'.$start_row.'', $jumlah_uang);
	$AS2->setCellValue('E'.$start_row.'', $lpj_tgl);
	$AS2->setCellValue('F'.$start_row.'', $lpj_uraian);
	
	if(empty($lpj_uraian)){
		$sts = $arr_status[0]; }
	else {
		$sts = $arr_status[1]; }
		
	$AS2->setCellValue('G'.$start_row.'', $sts);
	
	$start_row++;
}

$AS2->mergeCells('A'.$start_row.':C'.$start_row.'');
$AS2->setCellValue('A'.$start_row.'', 'Total');
$AS2->setCellValue('D'.$start_row.'', '=SUM(D6:D'.($start_row - 1).')');
$AS2->setCellValue('E'.$start_row.'', '');
$AS2->setCellValue('F'.$start_row.'', '');
$AS2->setCellValue('G'.$start_row.'', '');

$AS2->getStyle('A1:A2')->applyFromArray($formatJudul);
$AS2->getStyle('A4:G4')->applyFromArray($formatTableCenterB);
$AS2->getStyle('A5:G5')->applyFromArray($formatTableCenterI);


$AS2->getStyle('A6:A'.($start_row).'')->applyFromArray($formatTableCenterT);
$AS2->getStyle('B6:C'.($start_row).'')->applyFromArray($formatTableLeft);
$AS2->getStyle('D6:D'.($start_row).'')->applyFromArray($formatTableRight);
$AS2->getStyle('E6:E'.($start_row).'')->applyFromArray($formatTableLeft);
$AS2->getStyle('F6:F'.($start_row).'')->applyFromArray($formatTableLeft);
$AS2->getStyle('G6:G'.($start_row).'')->applyFromArray($formatTableLeft);

$AS2->getStyle('B6:B'.($start_row).'')->getAlignment()->setWrapText(true);
$AS2->getStyle('C6:C'.($start_row).'')->getAlignment()->setWrapText(true);
$AS2->getStyle('F6:F'.($start_row).'')->getAlignment()->setWrapText(true);

$AS2->getStyle('D6:D'.($start_row).'')->getNumberFormat()->applyFromArray(
	array(
		'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1	
	)
);

//$AS2->getStyle('B'.($summary_row).':E'.($summary_row + 1).'')->applyFromArray($formatIsiLeftB);


// Set column widths
$AS2->getColumnDimension('A')->setWidth(4);
$AS2->getColumnDimension('B')->setWidth(20);
$AS2->getColumnDimension('C')->setWidth(35);
$AS2->getColumnDimension('D')->setWidth(25);
$AS2->getColumnDimension('E')->setWidth(25);
$AS2->getColumnDimension('F')->setWidth(25);
$AS2->getColumnDimension('G')->setWidth(25);

$AS2->setTitle('Bantuan Sosial');

$objPHPExcel->setActiveSheetIndex(0);

?>
