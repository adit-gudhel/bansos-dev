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
							 ->setTitle("Daftar Penerima Bantuan Sosial")
							 ->setSubject("Daftar Nama Penerima Bantuan Sosial")
							 ->setDescription("Daftar Nama dan Alamat Penerima Bantuan Sosial")
							 ->setKeywords("daftar penerima bantuan sosial")
							 ->setCategory("report");


// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);

$AS = $objPHPExcel->getActiveSheet();

// Header
$AS->mergeCells('A1:D1');
$AS->setCellValue('A1', 'DAFTAR NAMA PENERIMA, ALAMAT DAN BESARAN');
$AS->mergeCells('A2:D2');
$AS->setCellValue('A2', 'ALOKASI BANTUAN SOSIAL YANG DITERIMA');

// Main Table
$AS->setCellValue('A4', 'NO');
$AS->setCellValue('B4', 'NAMA PENERIMA');
$AS->setCellValue('C4', 'ALAMAT PENERIMA');
$AS->setCellValue('D4', 'JUMLAH UANG (Rp)');

$AS->setCellValue('A5', '1');
$AS->setCellValue('B5', '2');
$AS->setCellValue('C5', '3');
$AS->setCellValue('D5', '4');

$sql = "SELECT nama, alamat, kelurahan, kecamatan, kota, propinsi, hasil_evaluasi_tapd as jumlah_uang FROM v_dncpbs_tapd WHERE YEAR(tgl_ba)='$thn' AND (status_opd = 1 AND status_tapd = 1) ORDER BY nama ASC";
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
	
	$start_row++;
}

$AS->mergeCells('A'.$start_row.':C'.$start_row.'');
$AS->setCellValue('A'.$start_row.'', 'Total');
$AS->setCellValue('D'.$start_row.'', '=SUM(D6:D'.($start_row - 1).')');

$ttd_row = $start_row + 3;
$AS->setCellValue('D'.$ttd_row.'', 'WALIKOTA BOGOR,');

$sql2 = "SELECT nama FROM tbl_penandatanganan WHERE jabatan='WALIKOTA BOGOR'";
$result2=$db->Execute($sql2);
$row2 = $result2->FetchRow();

$AS->setCellValue('D'.($ttd_row + 5 ).'', $row2['nama']);


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
$AS->getStyle('A4:D4')->applyFromArray($formatTableCenterB);
$AS->getStyle('A5:D5')->applyFromArray($formatTableCenterI);


$AS->getStyle('A6:A'.($start_row).'')->applyFromArray($formatTableCenterT);
$AS->getStyle('B6:C'.($start_row).'')->applyFromArray($formatTableLeft);
$AS->getStyle('D6:D'.($start_row).'')->applyFromArray($formatTableRight);

$AS->getStyle('B6:B'.($start_row).'')->getAlignment()->setWrapText(true);
$AS->getStyle('C6:C'.($start_row).'')->getAlignment()->setWrapText(true);

$AS->getStyle('D6:D'.($start_row).'')->getNumberFormat()->applyFromArray(
	array(
		'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1	
	)
);

$AS->getStyle('D'.$ttd_row.':D'.($ttd_row + 5).'')->applyFromArray($formatJudul);

// Set column widths
$AS->getColumnDimension('A')->setWidth(4);
$AS->getColumnDimension('B')->setWidth(20);
$AS->getColumnDimension('C')->setWidth(35);
$AS->getColumnDimension('D')->setWidth(25);



// Set page orientation and size
$AS->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$AS->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$AS->getPageSetup()->setFitToPage(TRUE);
$AS->getPageSetup()->setHorizontalCentered(true);

$AS->getPageMargins()->setLeft(0.5);
$AS->getPageMargins()->setRight(0.5);

$AS->setTitle('Daftar Penerima Bantuan Sosial');

?>
