<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");

if(isset($_POST['nama']) && isset($_POST['tipe'])){
	$nama = htmlentities($db->escape($_POST["nama"]));
	$pimpinan = htmlentities($db->escape($_POST["pimpinan"]));
	$jalan = htmlentities($db->escape($_POST["alamat"]));
	$rt = htmlentities($db->escape($_POST["rt"]));
	$rw = htmlentities($db->escape($_POST["rw"]));
	$kd_kelurahan = htmlentities($db->escape($_POST["kel"]));
	$kodepos = htmlentities($db->escape($_POST["kodepos"]));
	$ktp = htmlentities($db->escape($_POST["ktp"]));
	
	if($_POST['tipe'] == 'hibah'){
		$sql = "SELECT a.hib_kode as id, a.hib_nama AS nama, a.pimpinan, a.hib_jalan as jalan, a.hib_rt as rt, a.hib_rw as rw, c.nm_propinsi as propinsi, d.nm_dati2 as kota, e.nm_kecamatan as kecamatan, f.nm_kelurahan as kelurahan, a.hib_kodepos as pos, YEAR(b.tgl_cair) as cair_tahun
	FROM tbl_hibah a LEFT JOIN tbl_cair_hibah b ON a.hib_kode = b.hib_kode LEFT JOIN tbl_propinsi c ON a.kd_propinsi = c.kd_propinsi LEFT JOIN tbl_dati2 d ON a.kd_dati2 = d.kd_dati2 LEFT JOIN tbl_kecamatan e ON a.kd_kecamatan = e.kd_kecamatan LEFT JOIN tbl_kelurahan f ON a.kd_kelurahan = f.kd_kelurahan
	WHERE a.hib_nama LIKE '%".$nama."%' or a.pimpinan LIKE '%".$pimpinan."%' or a.hib_jalan LIKE '%".$jalan."%' or (a.hib_rt = '".$rt."' and a.hib_rw = '".$rw."' and a.kd_kelurahan = '".$kd_kelurahan."') LIMIT 10";
	} elseif ($_POST['tipe'] == 'bansos'){
		$sql = "SELECT a.ban_kode as id, a.ban_nama AS nama, a.pimpinan, a.ban_jalan as jalan, a.ban_ktp as ktp, a.ban_rt as rt, a.ban_rw as rw, c.nm_propinsi as propinsi, d.nm_dati2 as kota, e.nm_kecamatan as kecamatan, f.nm_kelurahan as kelurahan, a.ban_kodepos as pos, YEAR(b.tgl_cair) as cair_tahun
	FROM tbl_bansos a LEFT JOIN tbl_cair_bansos b ON a.ban_kode = b.ban_kode LEFT JOIN tbl_propinsi c ON a.kd_propinsi = c.kd_propinsi LEFT JOIN tbl_dati2 d ON a.kd_dati2 = d.kd_dati2 LEFT JOIN tbl_kecamatan e ON a.kd_kecamatan = e.kd_kecamatan LEFT JOIN tbl_kelurahan f ON a.kd_kelurahan = f.kd_kelurahan
	WHERE a.ban_nama LIKE '%".$nama."%' or a.pimpinan LIKE '%".$pimpinan."%' or a.ban_jalan LIKE '%".$jalan."%' or a.ban_ktp = '".$ktp."' or (a.ban_rt = '".$rt."' and a.ban_rw = '".$rw."' and a.kd_kelurahan = '".$kd_kelurahan."') LIMIT 10";
	}
	#echo  $sql;
	$res=$db->Execute($sql);
	$num_row = $res->NumRows();
	
	if($num_row > 0){
		$i=1;
		echo "<img src='/i/invalid.png' /> Terdapat beberapa kemiripan penerima ".$_POST['tipe']."";
		$end_result = '<table border="0" width="100%">';
		$end_result .= '<thead><tr><th>No</th><th>Nama</th>';
		if($_POST['tipe']=='bansos'){
			$end_result .= '<th>KTP</th>';
		}
		$end_result .= '<th>Pimpinan</th><th>Alamat</th><th>Status Cair</th></thead>';
		
		$end_result .= '<tbody>';
		while($row = $res->Fetchrow()){  
			$end_result     .= '<tr><td>'.$i.'</td><td>'.$row['nama'].'</td>';
			if($_POST['tipe']=='bansos'){
				$end_result	.= '<td>'.$row['ktp'].'</td>';
			}
			$end_result		.= '<td>'.$row['pimpinan'].'</td><td>'.$row['jalan'].' RT.'.$row['rt'].' / RW.'.$row['rw'].', Kel. '.ucwords(strtolower($row['kelurahan'])).' Kec. '.ucwords(strtolower($row['kecamatan'])).', '.ucwords(strtolower($row['kota'])).' '.$row['pos'].'</td><td>'.$row['cair_tahun'].'</td></tr>';            
			$i++;
		}
		$end_result .= '<tbody>';
		$end_result .= '</table>';
		echo $end_result;
	} else {
		echo "<img src='/i/valid.png' /> Tidak ditemukan kemiripan penerima ".$_POST['tipe']."";
	}
}
?>