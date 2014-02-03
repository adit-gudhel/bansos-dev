<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Export Data');

$tahun = date('Y');

?>
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
  <tr>
    <td>Pilih Tahun</td>
    <td>
     	<select name="thn" id="thn">
            <option value="0" <?php if($thn=='0'){echo"selected";}?>>-- Pilih Tahun --</option> 
            <?	for($x = ($tahun-2); $x <= ($tahun+1); $x++){
					if($x == $thn)
					echo '<option value="'.$x.'" selected>'.$x.'</option>';
					else
					echo '<option value="'.$x.'">'.$x.'</option>';
				} ?>
     	</select>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    <!--<input type=button onClick=history.back(-1) value='&laquo; Back'>!--> 
    <input class="submit" type="submit" id="generate" name="generate" value="Generate"></td>
  </tr>  
</table>
</form>

<?

foreach ($_POST as $key=>$val) {
        $$key = $val;
}

if ($generate && $thn!=='0'){
	$sql = "SELECT nama, alamat, kelurahan, kecamatan, kota, propinsi, hasil_evaluasi_tapd as jumlah_uang FROM v_dncpbh_tapd WHERE YEAR(tgl_ba)='$thn' AND (status_opd = 1 AND status_tapd = 1)";
	#echo $sql;
	$result=$db->Execute($sql);
	$row = $result->Fetchrow();
		
	if(empty($row['nama'])){
		echo "<p>Tidak ada penerima Hibah pada tahun ".$thn."</p>";
	} else {
		
		//generate excel
		include 'docs/export_data.inc.php';
		
		require_once 'classes/PHPExcel/Classes/PHPExcel/IOFactory.php';
			
		$filename = "export-data-".$thn.".xls";
			
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save(UPLOAD_PATH . $filename);
		
		echo "<p><a href=".UPLOAD_PATH . $filename.">Download</a></p>";	
			
	}
}

$t->basicfooter();
?>