<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$f->checkaccess();

$sql = "SELECT h.hib_kode as id, h.hib_nama as nama, h.hib_jalan as jalan, h.hib_rt as rt, h.hib_rw as rw, p.nm_propinsi as prop, d.nm_dati2 as dati2, kec.nm_kecamatan as kecamatan, kel.nm_kelurahan as kelurahan, h.hib_kodepos as kodepos, h.hib_tlp as no_tlp, h.hib_hp as no_hp, b.bank_nama as rekening, h.hib_ren_guna as ren_guna, h.hib_norek as no_rekening, h.hib_besaran_hibah as besaran_hibah, o.opd_nama as opd_tujuan FROM tbl_hibah h, tbl_propinsi p, tbl_dati2 d, tbl_kecamatan kec, tbl_kelurahan kel, tbl_bank b, tbl_opd o WHERE h.kd_propinsi = p.kd_propinsi AND h.kd_dati2=d.kd_dati2 AND h.kd_kecamatan=kec.kd_kecamatan AND h.kd_kelurahan=kel.kd_kelurahan AND h.bank_kode=b.bank_kode AND h.opd_kode=o.opd_kode AND h.hib_eval_opd = '0' AND h.jh_kode = '1' AND h.hib_nama LIKE '%".$_REQUEST['term']."%'";
#die($sql);

if($login_opd){
	$sql .= " and h.opd_kode='$login_opd'";
}

//$sql = "SELECT * FROM v_pemohon_hibah WHERE status_eval_opd = 0 AND pemohon LIKE '%".$_REQUEST['term']."%'";
$result=$db->Execute($sql);
$results = array();
$i=0;
while ($row = $result->Fetchrow()) {
    $results[$i]['label'] = $row['nama']." - ".$row['jalan'].' RT.'.$row['rt'].' / RW.'.$row['rw'].', Kel. '.ucwords(strtolower($row['kelurahan'])).' Kel. '.ucwords(strtolower($row['kecamatan'])).', '.ucwords(strtolower($row['dati2'])).' - '.ucwords(strtolower($row['prop']));
    $results[$i]['value'] = $row['nama'];
	$results[$i]['id'] = $row['id'];
	$results[$i]['alamat'] = $row['jalan'].' RT.'.$row['rt'].' / RW.'.$row['rw'].' Kel. '.ucwords(strtolower($row['kelurahan'])).' Kec. '.ucwords(strtolower($row['kecamatan'])).', '.ucwords(strtolower($row['dati2'])).' - '.ucwords(strtolower($row['prop']));
	$results[$i]['ren_guna'] = $row['ren_guna'];
	$results[$i]['besaran_hibah'] = $row['besaran_hibah'];

    $i++;
}

echo json_encode($results);

?>