<?
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=print_berita_acara_evaluasi_bansos_".date('YmdHis').".doc");

include "../s/config.php";
$f->checkaccess();

$doc_template = "ba_evaluasi_bansos.htm";
$style = "
<style type=\"text/css\">
<!--
p, td, li {
	font-family: \"Tahoma\";
	font-size: 10pt;
}
-->
</style>
";

$handle = fopen($doc_template, "r");
$contents = fread($handle, filesize($doc_template));

$contents = str_replace("__HTTP_HOST__", $_SERVER['HTTP_HOST'], $contents);
$contents = str_replace("<head>", "<head>\n".$style, $contents);
$contents = str_replace("__TANGGAL__", $f->format_tgl_cetak(date('Y-m-d')), $contents);

$sql = "SELECT a.ba_no, a.ba_tgl, a.sk_no, a.sk_tgl, YEAR(a.sk_tgl) as tahun_sk, a.sk_tentang, b.opd_nama, a.kode, substr(a.ba_tgl,1,4) as tahun, a.ba_tgl as hari, DAY(a.ba_tgl) as tanggal_huruf, MONTH(a.ba_tgl) as bulan_huruf, YEAR(a.ba_tgl) as tahun_huruf 
	FROM tbl_berita_acara a 
	LEFT JOIN tbl_opd b ON a.opd_kode=b.opd_kode 
	WHERE a.id = $id";

#die($sql);
$result=$db->Execute($sql);
$row = $result->Fetchrow();

foreach($row as $key => $val){
    $val = str_replace("  ","&nbsp; ",$val);
	if (preg_match("/ba_tgl|sk_tgl/", $key)){
		$val = $f->convertdatetime3(array("datetime"=>$val));
	}
	if (preg_match("/hari/", $key)){
		$val = $f->check_hari2($val);
	}
	if (preg_match("/tanggal_huruf|bulan_huruf|tahun_huruf/", $key)){
		$val = ucwords($f->terbilang($val));
	}
	
	$$key=$val;
	#echo"$key - $val<BR>";
	$doc_var = "__".strtoupper($key)."__";
	#echo $doc_var."|".$val."<br>";
	$contents = str_replace($doc_var, $val, $contents);
}

//=======================================================
// Permohonan yg masuk
//=======================================================
// Jumlah bansos berupa uang
$sql = "SELECT COUNT(*) as jum FROM v_dncpbs_opd WHERE (jenis='Uang' AND kode = '$kode')";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$jum = $row['jum'];
$contents = str_replace("__JUM__", $jum, $contents);

// Jumlah bansos berupa barang
$sql = "SELECT COUNT(*) as jbm FROM v_dncpbs_opd WHERE (jenis='Barang' AND kode = '$kode')";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$jbm = $row['jbm'];
$contents = str_replace("__JBM__", $jbm, $contents);

// Jumlah total bansos
$sql = "SELECT COUNT(*) as tjm FROM v_dncpbs_opd WHERE kode = '$kode'";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$tjm = $row['tjm'];
$contents = str_replace("__TJM__", $tjm, $contents);

// Nilai bansos berupa uang
$sql = "SELECT SUM(permohonan) as num FROM v_dncpbs_opd WHERE (jenis='Uang' AND kode = '$kode')";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$num = number_format($row['num'],2,',','.');
$contents = str_replace("__NUM__", $num, $contents);

// Nilai bansos berupa barang/jasa
$sql = "SELECT SUM(permohonan) as nbm FROM v_dncpbs_opd WHERE (jenis='Barang' AND kode = '$kode')";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$nbm = number_format($row['nbm'],2,',','.');
$contents = str_replace("__NBM__", $nbm, $contents);

// Nilai total hibah
$sql = "SELECT SUM(permohonan) as tnm FROM v_dncpbs_opd WHERE kode = '$kode'";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$tnm = number_format($row['tnm'],2,',','.');
$contents = str_replace("__TNM__", $tnm, $contents);


//=======================================================
// Hasil Evaluasi OPD
//=======================================================
// Jumlah bansos berupa uang
$sql = "SELECT COUNT(*) as juhe FROM v_dncpbs_opd WHERE (jenis='Uang' AND kode = '$kode') AND status_opd = 1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$juhe = $row['juhe'];
$contents = str_replace("__JUHE__", $juhe, $contents);

// Jumlah bansos berupa barang
$sql = "SELECT COUNT(*) as jbhe FROM v_dncpbs_opd WHERE (jenis='Barang' AND kode = '$kode') AND status_opd = 1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$jbhe = $row['jbhe'];
$contents = str_replace("__JBHE__", $jbhe, $contents);

// Jumlah total bansos
$sql = "SELECT COUNT(*) as tjhe FROM v_dncpbs_opd WHERE kode = '$kode' AND status_opd = 1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$tjhe = $row['tjhe'];
$contents = str_replace("__TJHE__", $tjhe, $contents);

// Nilai bansos berupa uang
$sql = "SELECT SUM(hasil_evaluasi_opd) as nuhe FROM v_dncpbs_opd WHERE (jenis='Uang' AND kode = '$kode') AND status_opd = 1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$nuhe = number_format($row['nuhe'],2,',','.');
$contents = str_replace("__NUHE__", $nuhe, $contents);

// Nilai bansos berupa barang
$sql = "SELECT SUM(hasil_evaluasi_opd) as nbhe FROM v_dncpbs_opd WHERE (jenis='Barang' AND kode = '$kode') AND status_opd = 1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$nbhe = number_format($row['nbhe'],2,',','.');
$contents = str_replace("__NBHE__", $nbhe, $contents);

// Nilai total hibah
$sql = "SELECT SUM(hasil_evaluasi_opd) as tnhe FROM v_dncpbs_opd WHERE kode = '$kode' AND status_opd = 1";
$result=$db->Execute($sql);
$row = $result->Fetchrow();
$tnhe = number_format($row['tnhe'],2,',','.');
$contents = str_replace("__TNHE__", $tnhe, $contents);

// generate ttd
$row = 2;
$i = 1;
$ttd = "<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;mso-yfti-tbllook:1184;mso-padding-alt:0in 5.75pt .05in 5.75pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=638 colspan=4 valign=top style='width:6.65in;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:10.0pt;font-family:Times New Roman,serif'>TIM EVALUASI<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=234 colspan=2 valign=top style='width:175.5pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:10.0pt;font-family:Times New Roman,serif'>Nama Lengkap /
  NIP.<o:p></o:p></span></b></p>
  </td>
  <td width=189 valign=top style='width:141.75pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:10.0pt;font-family:Times New Roman,serif'><o:p>&nbsp;</o:p></span></b></p>
  </td>
  <td width=215 valign=top style='width:161.55pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
  style='font-size:10.0pt;font-family:Times New Roman,serif'>Tanda Tangan<o:p></o:p></span></b></p>
  </td>
 </tr>";

$totalRec = $f->count_total("tbl_tim_evaluasi"," where kode='$kode'");

$sql = "SELECT nama,nip FROM tbl_tim_evaluasi WHERE kode='$kode'";
$result=$db->Execute($sql);
if(!$result) print $db->ErrorMsg();

while($val=$result->FetchRow()){
	foreach($val as $key1 => $val1){
			$key1=strtolower($key1);
			$$key1=$val1;
	}

  $ttd .= "<tr style='mso-yfti-irow:".$row."'>
  <td width=26 valign=top style='width:19.6pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:10.0pt;
  font-family:Times New Roman,serif'>".$i."<o:p></o:p></span></p>
  </td>
  <td width=208 valign=top style='width:155.9pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:10.0pt;font-family:Times New Roman,serif'>".$nama."<o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:141.75pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:10.0pt;
  font-family:Times New Roman,serif'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=215 valign=top style='width:161.55pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:10.0pt;
  font-family:Times New Roman,serif'>......................................<o:p></o:p></span></p>
  </td>
 </tr>";
 $row++;
 if($i==$totalRec){
 	$ttd .= "<tr style='mso-yfti-irow:".$row.";mso-yfti-lastrow:yes'>";
 } else{
 	$ttd .= "<tr style='mso-yfti-irow:".$row."'>";
 }
 	$ttd .= "<td width=26 valign=top style='width:19.6pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:10.0pt;
  font-family:Times New Roman,serif'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=208 valign=top style='width:155.9pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;line-height:
  normal'><span style='font-size:10.0pt;font-family:Times New Roman,serif'>NIP. ".$nip."<o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:141.75pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:10.0pt;
  font-family:Times New Roman,serif'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=215 valign=top style='width:161.55pt;padding:0in 5.75pt .05in 5.75pt'>
  <p class=MsoNormal align=center style='margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:10.0pt;
  font-family:Times New Roman,serif'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>";
 $row++;
 $i++;
}
 
$ttd .= "</table>";
$contents = str_replace("__TEMPLATE_TTD__", $ttd, $contents);

$contents = str_replace("ba_evaluasi_hibah_files/", "http://".$_SERVER['HTTP_HOST']."/docs/ba_evaluasi_hibah_files/", $contents);
echo $contents;


?>