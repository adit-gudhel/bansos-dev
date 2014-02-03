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
							 ->setTitle("Export Data Penerima Hibah Bansos")
							 ->setSubject("Export Data Penerima Hibah Bansos")
							 ->setDescription("Export Data Penerima Hibah Bansos")
							 ->setKeywords("export data penerima hibah bansos")
							 ->setCategory("report");


// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);

$AS = $objPHPExcel->getActiveSheet();

// Main Table
$AS->setCellValue('A1', 'NO');
$AS->setCellValue('B1', 'JENIS HIBAH');
$AS->setCellValue('C1', 'JENIS PEMOHON');
$AS->setCellValue('D1', 'NAMA PENERIMA');
$AS->setCellValue('E1', 'NAMA PIMPINAN');
$AS->setCellValue('F1', 'ALAMAT PENERIMA');
$AS->setCellValue('G1', 'KODEPOS');
$AS->setCellValue('H1', 'TELEPON');
$AS->setCellValue('I1', 'HP');
$AS->setCellValue('J1', 'BANK');
$AS->setCellValue('K1', 'NO REKENING');
$AS->setCellValue('L1', 'TANGGAL PROPOSAL');
$AS->setCellValue('M1', 'JUDUL KEGIATAN');
$AS->setCellValue('N1', 'RENCANA PENGGUNAAN');
$AS->setCellValue('O1', 'JUMLAH UANG (Rp)');
$AS->setCellValue('P1', 'NO BERITA ACARA EVALUASI');
$AS->setCellValue('Q1', 'TANGGAL CAIR');
$AS->setCellValue('R1', 'NO SPPH');
$AS->setCellValue('S1', 'TANGGAL SPPH');
$AS->setCellValue('T1', 'NO NPHD PENERIMA');
$AS->setCellValue('U1', 'NO NPHD PEMBERIA');
$AS->setCellValue('V1', 'TANGGAL NPHD');
$AS->setCellValue('W1', 'TENTANG');
$AS->setCellValue('X1', 'NO SP2D');
$AS->setCellValue('Y1', 'TANGGAL SP2D');
$AS->setCellValue('Z1', 'TANGGAL MONEV');
$AS->setCellValue('AA1', 'HASIL MONEV');
$AS->setCellValue('AB1', 'URAIAN');
$AS->setCellValue('AC1', 'TANGGAL LPJ');
$AS->setCellValue('AD1', 'URAIAN');


$AS->setCellValue('A2', '1');
$AS->setCellValue('B2', '2');
$AS->setCellValue('C2', '3');
$AS->setCellValue('D2', '4');
$AS->setCellValue('E2', '2');
$AS->setCellValue('F2', '6');
$AS->setCellValue('G2', '7');
$AS->setCellValue('H2', '8');
$AS->setCellValue('I2', '9');
$AS->setCellValue('J2', '10');
$AS->setCellValue('K2', '11');
$AS->setCellValue('L2', '12');
$AS->setCellValue('M2', '13');
$AS->setCellValue('N2', '14');
$AS->setCellValue('O2', '12');
$AS->setCellValue('P2', '16');
$AS->setCellValue('Q2', '17');
$AS->setCellValue('R2', '18');
$AS->setCellValue('S2', '19');
$AS->setCellValue('T2', '20');
$AS->setCellValue('U2', '21');
$AS->setCellValue('V2', '22');
$AS->setCellValue('W2', '23');
$AS->setCellValue('X2', '24');
$AS->setCellValue('Y2', '22');
$AS->setCellValue('Z2', '26');
$AS->setCellValue('AA2', '27');
$AS->setCellValue('AB2', '28');
$AS->setCellValue('AC2', '29');
$AS->setCellValue('AD2', '29');

//$sql = "SELECT nama, alamat, kelurahan, kecamatan, kota, propinsi, hasil_evaluasi_tapd as jumlah_uang FROM v_dncpbh_tapd WHERE YEAR(tgl_ba)='$thn' AND (status_opd = 1 AND status_tapd = 1) ORDER BY nama ASC";

$sql = "SELECT a.opd_nama as opd,
	b.jh_jenis as jenis, 
	c.hib_tanggal as tgl_proposal,
	c.hib_nama as nama,
	m.jenis_pemohon,
	c.hib_judul_kegiatan as judul_kegiatan,
	c.hib_lokasi_kegiatan as lokasi_kegiatan,
	c.pimpinan,
	c.hib_tlp as tlp,
	c.hib_hp as hp,
	l.bank_nama as bank,
	c.hib_norek as no_rek,
	c.hib_kode, 
	CONCAT(`hib_jalan`,' RT.',`hib_rt`,' / RW.',`hib_rw`) as alamat, d.nm_kelurahan as kelurahan,e.nm_kecamatan as kecamatan,
	f.nm_dati2 as kota,
	g.nm_propinsi as propinsi,
	c.hib_kodepos as kodepos, 
	c.hib_ren_guna as rencana_penggunaan,
	c.hib_besaran_hibah as permohonan,
	h.besaran_opd as hasil_evaluasi_opd,
	j.besaran_tapd as jumlah_terima,
	j.keterangan,
	j.kode,
	k.tipe,
	i.ba_no as no_ba_opd,
	i.ba_tgl as tgl_ba_opd,
	k.ba_no as no_ba_tapd,
	k.ba_tgl as tgl_ba_tapd,
	c.hib_cair as cair,
	n.tgl_cair,
	n.spph_no,
	n.spph_tgl,
	n.nphd_no_pemberi,
	n.nphd_no_penerima,
	n.nphd_tgl,
	n.nphd_tentang,
	n.sp2d_no,
	n.sp2d_tgl,
	c.mon_tgl as tgl_monev,
	c.mon_hasil as hasil_monev,
	c.mon_uraian as uraian_monev,
	c.lpj_tgl as tgl_lpj,
	c.lpj_uraian as uraian_lpj
FROM tbl_opd a, tbl_jenis_hibah b, tbl_hibah c, tbl_kelurahan d, tbl_kecamatan e, tbl_dati2 f, tbl_propinsi g, tbl_berita_acara_detail h, tbl_berita_acara i, tbl_eval_tapd_detail j, tbl_eval_tapd k, tbl_bank l, tbl_jenis_pemohon m, tbl_cair_hibah n
WHERE c.opd_kode=a.opd_kode AND c.jh_kode=b.jh_kode AND c.kd_kelurahan=d.kd_kelurahan AND c.kd_kecamatan=e.kd_kecamatan AND c.kd_dati2=f.kd_dati2 AND c.kd_propinsi=g.kd_propinsi AND c.hib_kode=h.hib_kode AND h.kode=i.kode AND i.tipe='HIBAH' AND c.hib_kode=j.hib_kode AND j.kode=k.kode AND k.tipe ='HIBAH' AND (h.status = 1 AND j.status=1) AND c.bank_kode=l.bank_kode AND c.id_jp=m.id_jp AND c.hib_kode=n.hib_kode AND YEAR(k.ba_tgl)='$thn'";

$result=$db->Execute($sql);

$total_rows = $result->NumRows();
$start_row=3;
$i=0;
while($row=$result->Fetchrow()){
	foreach($row as $key => $val){
		$$key=$val;
	}
    $i++;
	$AS->setCellValue('A'.$start_row.'', $i);
	$AS->setCellValue('B'.$start_row.'', $jenis);
	$AS->setCellValue('C'.$start_row.'', $jenis_pemohon);
	$AS->setCellValue('D'.$start_row.'', $nama);
	$AS->setCellValue('E'.$start_row.'', $pimpinan);
	$AS->setCellValue('F'.$start_row.'', ''.$alamat.' Kel. '.ucwords(strtolower($kelurahan)).' Kec. '.ucwords(strtolower($kecamatan)).' '.ucwords(strtolower($kota)).', '.ucwords(strtolower($propinsi)).'');
	$AS->setCellValue('G'.$start_row.'', $kodepos);
	$AS->setCellValue('H'.$start_row.'', $tlp);
	$AS->setCellValue('I'.$start_row.'', $hp);
	$AS->setCellValue('J'.$start_row.'', $bank);
	$AS->setCellValue('K'.$start_row.'', $no_rek);
	$AS->setCellValue('L'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_proposal)));
	$AS->setCellValue('M'.$start_row.'', $judul_kegiatan);
	$AS->setCellValue('N'.$start_row.'', $rencana_penggunaan);
	$AS->setCellValue('O'.$start_row.'', $jumlah_terima);
	$AS->setCellValue('P'.$start_row.'', $no_ba_opd);
	$AS->setCellValue('Q'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_cair)));
	$AS->setCellValue('R'.$start_row.'', $spph_no);
	$AS->setCellValue('S'.$start_row.'', $f->convertdatetime(array("datetime"=>$spph_tgl)));
	$AS->setCellValue('T'.$start_row.'', $nphd_no_pemberi);
	$AS->setCellValue('U'.$start_row.'', $nphd_no_penerima);
	$AS->setCellValue('V'.$start_row.'', $f->convertdatetime(array("datetime"=>$nphd_tgl)));
	$AS->setCellValue('W'.$start_row.'', $nphd_tentang);
	$AS->setCellValue('X'.$start_row.'', $sp2d_no);
	$AS->setCellValue('Y'.$start_row.'', $f->convertdatetime(array("datetime"=>$sp2d_tgl)));
	$AS->setCellValue('Z'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_monev)));
	$AS->setCellValue('AA'.$start_row.'', $hasil_monev);
	$AS->setCellValue('AB'.$start_row.'', $uraian_monev);
	$AS->setCellValue('AC'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_lpj)));
	$AS->setCellValue('AD'.$start_row.'', $uraian_lpj);
	
	$start_row++;
}

$AS->mergeCells('A'.$start_row.':N'.$start_row.'');
$AS->setCellValue('A'.$start_row.'', 'Total');
$AS->setCellValue('O'.$start_row.'', '=SUM(O3:O'.($start_row - 1).')');


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

$AS->getStyle('A1:AD1')->applyFromArray($formatTableCenterB);
$AS->getStyle('A2:AD2')->applyFromArray($formatTableCenterI);


$AS->getStyle('A3:AD'.($start_row).'')->applyFromArray($formatTableLeft);
$AS->getStyle('O3:O'.($start_row).'')->getNumberFormat()->applyFromArray(
	array(
		'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1	
	)
);

// Set column widths
$AS->getColumnDimension('A')->setWidth(4);
$AS->getColumnDimension('B')->setWidth(20);
$AS->getColumnDimension('C')->setWidth(35);
$AS->getColumnDimension('D')->setWidth(25);
$AS->getColumnDimension('E')->setWidth(25);
$AS->getColumnDimension('F')->setWidth(25);
$AS->getColumnDimension('G')->setWidth(25);
$AS->getColumnDimension('H')->setWidth(25);
$AS->getColumnDimension('I')->setWidth(25);
$AS->getColumnDimension('J')->setWidth(25);
$AS->getColumnDimension('K')->setWidth(25);
$AS->getColumnDimension('L')->setWidth(25);
$AS->getColumnDimension('M')->setWidth(25);
$AS->getColumnDimension('N')->setWidth(25);
$AS->getColumnDimension('O')->setWidth(20);
$AS->getColumnDimension('P')->setWidth(35);
$AS->getColumnDimension('Q')->setWidth(25);
$AS->getColumnDimension('R')->setWidth(25);
$AS->getColumnDimension('S')->setWidth(25);
$AS->getColumnDimension('T')->setWidth(25);
$AS->getColumnDimension('U')->setWidth(20);
$AS->getColumnDimension('V')->setWidth(35);
$AS->getColumnDimension('W')->setWidth(25);
$AS->getColumnDimension('X')->setWidth(25);
$AS->getColumnDimension('Y')->setWidth(25);
$AS->getColumnDimension('Z')->setWidth(25);
$AS->getColumnDimension('AA')->setWidth(20);
$AS->getColumnDimension('AB')->setWidth(35);
$AS->getColumnDimension('AC')->setWidth(25);
$AS->getColumnDimension('AD')->setWidth(25);


// Set page orientation and size
$AS->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$AS->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$AS->getPageSetup()->setFitToPage(TRUE);
$AS->getPageSetup()->setHorizontalCentered(true);

$AS->getPageMargins()->setLeft(0.5);
$AS->getPageMargins()->setRight(0.5);

$AS->setTitle('Export Data Penerima Hibah');

// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);
$AS2 = $objPHPExcel->getActiveSheet();

// Main Table
$AS2->setCellValue('A1', 'NO');
$AS2->setCellValue('B1', 'JENIS BANTUAN SOSIAL');
$AS2->setCellValue('C1', 'NAMA PENERIMA');
$AS2->setCellValue('D1', 'NO KTP');
$AS2->setCellValue('E1', 'NAMA PIMPINAN');
$AS2->setCellValue('F1', 'ALAMAT PENERIMA');
$AS2->setCellValue('G1', 'KODEPOS');
$AS2->setCellValue('H1', 'TELEPON');
$AS2->setCellValue('I1', 'HP');
$AS2->setCellValue('J1', 'BANK');
$AS2->setCellValue('K1', 'NO REKENING');
$AS2->setCellValue('L1', 'TANGGAL PROPOSAL');
$AS2->setCellValue('M1', 'JUDUL KEGIATAN');
$AS2->setCellValue('N1', 'RENCANA PENGGUNAAN');
$AS2->setCellValue('O1', 'TUJUAN PENGGUNAAN');
$AS2->setCellValue('P1', 'JUMLAH UANG (Rp)');
$AS2->setCellValue('Q1', 'NO BERITA ACARA EVALUASI');
$AS2->setCellValue('R1', 'TANGGAL CAIR');
$AS2->setCellValue('S1', 'NO SPPBS');
$AS2->setCellValue('T1', 'TANGGAL SPPBS');
$AS2->setCellValue('U1', 'NO SP2D');
$AS2->setCellValue('V1', 'TANGGAL SP2D');
$AS2->setCellValue('W1', 'TANGGAL MONEV');
$AS2->setCellValue('X1', 'HASIL MONEV');
$AS2->setCellValue('Y1', 'URAIAN');
$AS2->setCellValue('Z1', 'TANGGAL LPJ');
$AS2->setCellValue('AA1', 'URAIAN');


$AS2->setCellValue('A2', '1');
$AS2->setCellValue('B2', '2');
$AS2->setCellValue('C2', '3');
$AS2->setCellValue('D2', '4');
$AS2->setCellValue('E2', '2');
$AS2->setCellValue('F2', '6');
$AS2->setCellValue('G2', '7');
$AS2->setCellValue('H2', '8');
$AS2->setCellValue('I2', '9');
$AS2->setCellValue('J2', '10');
$AS2->setCellValue('K2', '11');
$AS2->setCellValue('L2', '12');
$AS2->setCellValue('M2', '13');
$AS2->setCellValue('N2', '14');
$AS2->setCellValue('O2', '12');
$AS2->setCellValue('P2', '16');
$AS2->setCellValue('Q2', '17');
$AS2->setCellValue('R2', '18');
$AS2->setCellValue('S2', '19');
$AS2->setCellValue('T2', '20');
$AS2->setCellValue('U2', '21');
$AS2->setCellValue('V2', '22');
$AS2->setCellValue('W2', '23');
$AS2->setCellValue('X2', '24');
$AS2->setCellValue('Y2', '22');
$AS2->setCellValue('Z2', '26');
$AS2->setCellValue('AA2', '27');


//$sql = "SELECT nama, alamat, kelurahan, kecamatan, kota, propinsi, hasil_evaluasi_tapd as jumlah_uang FROM v_dncpbh_tapd WHERE YEAR(tgl_ba)='$thn' AND (status_opd = 1 AND status_tapd = 1) ORDER BY nama ASC";

$sql = "SELECT a.opd_nama as opd,
	b.jh_jenis as jenis, 
	c.ban_tanggal as tgl_proposal,
	c.ban_nama as nama,
	c.ban_ktp as ktp,
	m.tb,
	c.ban_judul_kegiatan as judul_kegiatan,
	c.ban_lokasi_kegiatan as lokasi_kegiatan,
	c.pimpinan,
	c.ban_tlp as tlp,
	c.ban_hp as hp,
	l.bank_nama as bank,
	c.ban_norek as no_rek,
	c.ban_kode, 
	CONCAT(`ban_jalan`,' RT.',`ban_rt`,' / RW.',`ban_rw`) as alamat, d.nm_kelurahan as kelurahan,e.nm_kecamatan as kecamatan,
	f.nm_dati2 as kota,
	g.nm_propinsi as propinsi,
	c.ban_kodepos as kodepos, 
	c.ban_ren_guna as rencana_penggunaan,
	c.ban_besaran_bansos as permohonan,
	h.besaran_opd as hasil_evaluasi_opd,
	j.besaran_tapd as jumlah_terima,
	j.keterangan,
	j.kode,
	k.tipe,
	i.ba_no as no_ba_opd,
	i.ba_tgl as tgl_ba_opd,
	k.ba_no as no_ba_tapd,
	k.ba_tgl as tgl_ba_tapd,
	c.ban_cair as cair,
	n.tgl_cair,
	n.sppbs_no,
	n.sppbs_tgl,
	n.sp2d_no,
	n.sp2d_tgl,
	c.mon_tgl as tgl_monev,
	c.mon_hasil as hasil_monev,
	c.mon_uraian as uraian_monev,
	c.lpj_tgl as tgl_lpj,
	c.lpj_uraian as uraian_lpj
FROM tbl_opd a, tbl_jenis_hibah b, tbl_bansos c, tbl_kelurahan d, tbl_kecamatan e, tbl_dati2 f, tbl_propinsi g, tbl_berita_acara_detail h, tbl_berita_acara i, tbl_eval_tapd_detail j, tbl_eval_tapd k, tbl_bank l, tbl_tujuan_bansos m, tbl_cair_bansos n
WHERE c.opd_kode=a.opd_kode AND c.jh_kode=b.jh_kode AND c.kd_kelurahan=d.kd_kelurahan AND c.kd_kecamatan=e.kd_kecamatan AND c.kd_dati2=f.kd_dati2 AND c.kd_propinsi=g.kd_propinsi AND c.ban_kode=h.hib_kode AND h.kode=i.kode AND i.tipe='BANSOS' AND c.ban_kode=j.hib_kode AND j.kode=k.kode AND k.tipe ='BANSOS' AND (h.status = 1 AND j.status=1) AND c.bank_kode=l.bank_kode AND c.id_tb=m.id_tb AND c.ban_kode=n.ban_kode AND YEAR(k.ba_tgl)='$thn'";

$result=$db->Execute($sql);

$total_rows = $result->NumRows();
$start_row=3;
$i=0;
while($row=$result->Fetchrow()){
	foreach($row as $key => $val){
		$$key=$val;
	}
    $i++;
	$AS2->setCellValue('A'.$start_row.'', $i);
	$AS2->setCellValue('B'.$start_row.'', $jenis);
	$AS2->setCellValue('C'.$start_row.'', $nama);
	$AS2->setCellValue('D'.$start_row.'', ''.$ktp);
	$AS2->setCellValue('E'.$start_row.'', $pimpinan);
	$AS2->setCellValue('F'.$start_row.'', ''.$alamat.' Kel. '.ucwords(strtolower($kelurahan)).' Kec. '.ucwords(strtolower($kecamatan)).' '.ucwords(strtolower($kota)).', '.ucwords(strtolower($propinsi)).'');
	$AS2->setCellValue('G'.$start_row.'', $kodepos);
	$AS2->setCellValue('H'.$start_row.'', $tlp);
	$AS2->setCellValue('I'.$start_row.'', $hp);
	$AS2->setCellValue('J'.$start_row.'', $bank);
	$AS2->setCellValue('K'.$start_row.'', $no_rek);
	$AS2->setCellValue('L'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_proposal)));
	$AS2->setCellValue('M'.$start_row.'', $judul_kegiatan);
	$AS2->setCellValue('N'.$start_row.'', $rencana_penggunaan);
	$AS2->setCellValue('O'.$start_row.'', $tb);
	$AS2->setCellValue('P'.$start_row.'', $jumlah_terima);
	$AS2->setCellValue('Q'.$start_row.'', $no_ba_opd);
	$AS2->setCellValue('R'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_cair)));
	
	$AS2->setCellValue('S'.$start_row.'', $sppbs_no);
	$AS2->setCellValue('T'.$start_row.'', $f->convertdatetime(array("datetime"=>$sppbs_tgl)));
	$AS2->setCellValue('U'.$start_row.'', $sp2d_no );
	$AS2->setCellValue('V'.$start_row.'', $f->convertdatetime(array("datetime"=>$sp2d_tgl)));
	$AS2->setCellValue('W'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_monev)));
	$AS2->setCellValue('X'.$start_row.'', $hasil_monev);
	$AS2->setCellValue('Y'.$start_row.'', $uraian_monev);
	$AS2->setCellValue('Z'.$start_row.'', $f->convertdatetime(array("datetime"=>$tgl_lpj)));
	$AS2->setCellValue('AA'.$start_row.'', $uraian_lpj);
	
	$start_row++;
}

$AS2->mergeCells('A'.$start_row.':O'.$start_row.'');
$AS2->setCellValue('A'.$start_row.'', 'Total');
$AS2->setCellValue('P'.$start_row.'', '=SUM(P3:P'.($start_row - 1).')');

$AS2->getStyle('A1:AA1')->applyFromArray($formatTableCenterB);
$AS2->getStyle('A2:AA2')->applyFromArray($formatTableCenterI);


$AS2->getStyle('A3:AC'.($start_row).'')->applyFromArray($formatTableLeft);
$AS2->getStyle('P3:O'.($start_row).'')->getNumberFormat()->applyFromArray(
	array(
		'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1	
	)
);

// Set column widths
$AS2->getColumnDimension('A')->setWidth(4);
$AS2->getColumnDimension('B')->setWidth(20);
$AS2->getColumnDimension('C')->setWidth(35);
$AS2->getColumnDimension('D')->setWidth(25);
$AS2->getColumnDimension('E')->setWidth(25);
$AS2->getColumnDimension('F')->setWidth(25);
$AS2->getColumnDimension('G')->setWidth(25);
$AS2->getColumnDimension('H')->setWidth(25);
$AS2->getColumnDimension('I')->setWidth(25);
$AS2->getColumnDimension('J')->setWidth(25);
$AS2->getColumnDimension('K')->setWidth(25);
$AS2->getColumnDimension('L')->setWidth(25);
$AS2->getColumnDimension('M')->setWidth(25);
$AS2->getColumnDimension('N')->setWidth(25);
$AS2->getColumnDimension('O')->setWidth(20);
$AS2->getColumnDimension('P')->setWidth(35);
$AS2->getColumnDimension('Q')->setWidth(25);
$AS2->getColumnDimension('R')->setWidth(25);
$AS2->getColumnDimension('S')->setWidth(25);
$AS2->getColumnDimension('T')->setWidth(25);
$AS2->getColumnDimension('U')->setWidth(20);
$AS2->getColumnDimension('V')->setWidth(35);
$AS2->getColumnDimension('W')->setWidth(25);
$AS2->getColumnDimension('X')->setWidth(25);
$AS2->getColumnDimension('Y')->setWidth(25);
$AS2->getColumnDimension('Z')->setWidth(25);
$AS2->getColumnDimension('AA')->setWidth(20);

$AS2->setTitle('Export Data Penerima Bansos');

$objPHPExcel->setActiveSheetIndex(0);
?>
