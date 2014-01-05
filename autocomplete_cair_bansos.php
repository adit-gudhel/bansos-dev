<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");

$sql = "SELECT a.nama, a.alamat, a.kelurahan, a.kecamatan, a.kota, a.propinsi, a.hasil_evaluasi_tapd as besaran_tapd, a.ban_kode FROM v_dncpbs_tapd a LEFT JOIN tbl_bansos b ON a.ban_kode=b.ban_kode WHERE a.tipe='BANSOS' AND (a.status_opd = 1 AND a.status_tapd = 1) AND b.ban_cair = 0 AND a.nama like '".$_REQUEST['term']."%'";
$result=$db->Execute($sql);
$results = array();
$i=0;
while ($row = $result->Fetchrow()) {
    $results[$i]['label'] = $row['nama']." - ".$row['alamat'].', Kel. '.ucwords(strtolower($row['kelurahan'])).' Kel. '.ucwords(strtolower($row['kecamatan'])).', '.ucwords(strtolower($row['kota'])).' - '.ucwords(strtolower($row['propinsi']));
    $results[$i]['value'] = $row['nama'];
    $results[$i]['ban_kode'] = $row['ban_kode'];
	$results[$i]['besaran_tapd'] = $row['besaran_tapd'];

    $i++;
}

echo json_encode($results);

?>