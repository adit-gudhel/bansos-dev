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
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
require_once("$DOCUMENT_ROOT/classes/PHPExcel/Classes/PHPExcel/IOFactory.php");

date_default_timezone_set('Asia/Jakarta');

$today = date("Y-m-d");

$t->basicheader();
$f->checkaccess();
$t->title('DNCPBH OPD');

$filepath = "$DOCUMENT_ROOT/docs/";

foreach ($_POST as $key=>$val) {
        $$key = $val;
}

$q = mysql_query("SELECT kode FROM tbl_berita_acara WHERE id=1");
$d = mysql_fetch_array($q);
$kode = $d[0];
mysql_free_result($q);


echo date('H:i:s') , " Load from Excel2007 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load("dncpbh_opd.xlsx");

$objPHPExcel->setActiveSheetIndex(0);
$AS = $objPHPExcel->getActiveSheet();

$today = date('Y-m-d');

$t = explode('-',$today);

$AS->setCellValue('A2', 'TAHUN ANGGARAN '.$t[0].'');
$AS->setCellValue('C4', 'Dinas Pendidikan');
$AS->setCellValue('C5', 'Uang');

echo date('H:i:s') , " Add new data to the template" , EOL;
/*
$data = array(array('title'		=> 'Excel for dummies',
					'price'		=> 17.99,
					'quantity'	=> 2
				   ),
			  array('title'		=> 'PHP for dummies',
					'price'		=> 15.99,
					'quantity'	=> 1
				   ),
			  array('title'		=> 'Inside OOP',
					'price'		=> 12.95,
					'quantity'	=> 1
				   )
			 );

$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));

$baseRow = 5;
foreach($data as $r => $dataRow) {
	$row = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['title'])
	                              ->setCellValue('C'.$row, $dataRow['price'])
	                              ->setCellValue('D'.$row, $dataRow['quantity'])
	                              ->setCellValue('E'.$row, '=C'.$row.'*D'.$row);
}
$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
*/

$q2 = mysql_query("SELECT * FROM v_dncpbh_opd where kode='1-HIBAH-Nf8QaY3KHm'");
//$data = mysql_fetch_object($q2);
$data = array();
$i=0;
while($r = mysql_fetch_assoc($q2)) {
    $data[] = $r;
	$i++;
}
//json_encode($data);

$baseRow = 11;
foreach($data as $r => $dataRow) {
	$row = $baseRow + $r;
	$AS->insertNewRowBefore($row,1);

	$AS->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['nama'])
	                              ->setCellValue('C'.$row, $dataRow['alamat'])
	                              ->setCellValue('D'.$row, $dataRow['rencana_penggunaan'])
	                              ->setCellValue('E'.$row, $dataRow['permohonan'])
								  ->setCellValue('F'.$row, $dataRow['hasil_evaluasi_opd'])
								  ->setCellValue('G'.$row, $dataRow['keterangan']);
}
$AS->removeRow($baseRow-1,1);

echo date('H:i:s') , " Write to Excel 2007 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('test.xlsx');
echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;
