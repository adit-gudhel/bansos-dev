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
$f->checkaccess();
require_once("$DOCUMENT_ROOT/classes/PHPExcel/Classes/PHPExcel.php");
require_once("$DOCUMENT_ROOT/classes/PHPExcel/Classes/PHPExcel/IOFactory.php");

date_default_timezone_set('Asia/Jakarta');

$today = date("Y-m-d");

$t->basicheader();
$f->checkaccess();
$t->title('DNCPBH OPD - Uang');

$filepath = "$DOCUMENT_ROOT/docs/";

foreach ($_POST as $key=>$val) {
        $$key = $val;
}

foreach ($_GET as $key=>$val) {
        $$key = $val;
}

$q = mysql_query("SELECT a.kode, b.opd_nama, a.tipe, YEAR(a.ba_tgl) as tahun FROM tbl_berita_acara a LEFT JOIN tbl_opd b ON a.opd_kode=b.opd_kode WHERE a.id=$id");
$d = mysql_fetch_array($q);
$kode = $d[0];
//mysql_free_result($q);


echo date('H:i:s') , " Load from Excel2007 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load("dncpbh_opd.xlsx");

$objPHPExcel->setActiveSheetIndex(0);
$AS = $objPHPExcel->getActiveSheet();


$AS->setCellValue('A2', 'TAHUN ANGGARAN '.$d[3].'');
$AS->setCellValue('C4', $d[1]);
$AS->setCellValue('C5', 'Uang');

$q2 = mysql_query("SELECT * FROM v_dncpbh_opd where kode='$kode' and jenis='Uang'");
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


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('test.xlsx');

echo "<a href=test.xlsx>Download</a>";
?>
