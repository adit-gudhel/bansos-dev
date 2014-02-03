<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Hibah &raquo; Data Pertimbangan TAPD');


if ($act == "add" || $act == "edit") {

	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_eval_tapd WHERE id=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
		
		//$counter = $f->count_total("tbl_eval_tapd_detail"," where kode='$kode'") + 1;
		$counter1 = $f->count_total("v_dncpbh_tapd"," where kode='$kode' and jenis='Uang'") + 1;
		$counter2 = $f->count_total("v_dncpbh_tapd"," where kode='$kode' and (jenis='Barang' or jenis='Jasa')") + 1;
    }
    
    if ($id && $act == "add") unset($id, $tgl_nphd, $ba_tgl);
    
	if (!$tgl_nphd) $tgl_nphd = date('Y-m-d');
	if (!$ba_tgl) $ba_tgl = date('Y-m-d');
	 
?>
<script type="text/javascript" src="/evaluasi_hibah_tapd.js"></script>
<script type="text/javascript">
	$(function() {
		var counter1 = <?php if(empty($counter1)) echo 1; else echo $counter1; ?>;
		var options = {
			source: 'autocomplete_hibah_tapd_uang.php',
			minLength: 2,
			focus: function( event, ui ) {
                    $( '#nama_' + counter1 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibUangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibUangAlamat').val(ui.item.alamat);   
					$(this).closest('tr').find('input.hibUangRenGuna').val(ui.item.rencana_penggunaan);
					$(this).closest('tr').find('input.hibUangNilHibah').val(ui.item.besaran_hibah);
					$(this).closest('tr').find('input.hibUangNilHibahOpd').val(ui.item.besaran_opd); 
					//console.log(ui.item.alamat);
           },
            select: function( event, ui ) {
					//event.preventDefault();
                    $( '#nama_' + counter1 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibUangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibUangAlamat').val(ui.item.alamat);
					$(this).closest('tr').find('input.hibUangRenGuna').val(ui.item.rencana_penggunaan);
					$(this).closest('tr').find('input.hibUangNilHibah').val(ui.item.besaran_hibah);  
					$(this).closest('tr').find('input.hibUangNilHibahOpd').val(ui.item.besaran_opd);  
					//console.log(ui.item.alamat);
                   //return false;
           }
		};
		$('input.hibUangNama').live("keydown.autocomplete", function() {
		
			$(this).autocomplete(options);
		});
	
		var addInput = function() {
			if (counter1 > 1){
				$('input#removeButton').removeAttr('disabled');
			}
			var inputHTML = ' <tr><td><div id="' + counter1 + '">'+ counter1 +'</div></td><td><input type="text" id="nama_' +counter1 + '" class="hibUangNama easyui-validatebox" name="nama_' + counter1 +'" value="" required="true" /> <input type="hidden" name="hib_kode_' + counter1 + '" id="hib_kode_' + counter1 + '" class="hibUangId" value="" /></td><td><input type="text" id="alamat_' + counter1 + '" class="hibUangAlamat" name="alamat_' + counter1 +'" value="" disabled /></td><td><input type="text" id="ren_guna_' + counter1 + '" class="hibUangRenGuna" name="ren_guna_' + counter1 +'" value="" disabled /></td><td><input type="text" id="nil_hibah_' + counter1 + '" class="hibUangNilHibah" name="nil_hibah_' + counter1 +'" value="" disabled /></td><td><input type="text" id="nil_opd_' + counter1 + '" class="hibUangNilHibahOpd easyui-validatebox" name="nil_opd_' + counter1 +'" value="" disabled /><td><input type="text" id="nil_tapd_' + counter1 + '" class="hibUangNilHibahTapd easyui-validatebox" name="nil_tapd_' + counter1 +'" value="" required="true" /></td><td><input type="text" id="ket_' + counter1 + '" class="hibUangKet" name="ket_' + counter1 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-hibah-uang tbody");
			$("input.hibUangNama:last").focus();
			counter1++;
		};
		
		var removeInput = function() {
			counter1--;
			if(counter1 == 1){
				 $('input#removeButton').attr('disabled','disabled');
				//alert("Minimal sisa 1!");
				counter1++;
				console.log('Jika Counter == 1 :' + counter1);
			}
			else{
				$("table#tbl-hibah-uang tbody tr:last").remove();
				console.log('Jika Counter != 1 :' + counter1);
			}
			$("input.hibUangNama:last").focus();
		};
	
		if (!$("table#tbl-hibah-uang tbody").find("input.hibUangNama").length) {
			addInput();
		}
	
	
		$("input#addButton").click(addInput);
		$("input#removeButton").click(removeInput);
});
</script>

<script type="text/javascript">
	$(function() {
		var counter2 = <?php if(empty($counter2)) echo 1; else echo $counter2; ?>;
		var options = {
			source: 'autocomplete_hibah_tapd_barang.php',
			minLength: 2,
			focus: function( event, ui ) {
                    $( '#nama2_' + counter2 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibBarangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibBarangAlamat').val(ui.item.alamat); 
					$(this).closest('tr').find('input.hibBarangRenGuna').val(ui.item.rencana_penggunaan);  
					$(this).closest('tr').find('input.hibBarangNilHibah').val(ui.item.besaran_hibah); 
					$(this).closest('tr').find('input.hibBarangNilHibahOpd').val(ui.item.besaran_opd); 
					//console.log(ui.item.alamat);
           },
            select: function( event, ui ) {
					//event.preventDefault();
                    $( '#nama2_' + counter2 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibBarangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibBarangAlamat').val(ui.item.alamat); 
					$(this).closest('tr').find('input.hibBarangRenGuna').val(ui.item.rencana_penggunaan);  
					$(this).closest('tr').find('input.hibBarangNilHibah').val(ui.item.besaran_hibah); 
					$(this).closest('tr').find('input.hibBarangNilHibahOpd').val(ui.item.besaran_opd);   
					//console.log(ui.item.alamat);
                   //return false;
           }
		};
		$('input.hibBarangNama').live("keydown.autocomplete", function() {
		
			$(this).autocomplete(options);
		});
	
		var addInput2 = function() {
			if (counter2 > 1){
				$('input#removeButton2').removeAttr('disabled');
			}
			var inputHTML = ' <tr><td><div id="' + counter2 + '">'+ counter2 +'</div></td><td><input type="text" id="nama2_' +counter2 + '" class="hibBarangNama easyui-validatebox" name="nama2_' + counter2 +'" value="" /> <input type="hidden" name="hib_kode2_' + counter2 + '" id="hib_kode2_' + counter2 + '" class="hibBarangId" value="" /></td><td><input type="text" id="alamat2_' + counter2 + '" class="hibBarangAlamat" name="alamat2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="ren_guna2_' + counter2 + '" class="hibBarangRenGuna" name="ren_guna2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="nil_hibah2_' + counter2 + '" class="hibBarangNilHibah" name="nil_hibah2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="nil_opd2_' + counter2 + '" class="hibBarangNilHibahOpd" name="nil_opd2_' + counter2 +'" value="" disabled /><td><input type="text" id="nil_tapd2_' + counter2 + '" class="hibBarangNilHibahTapd easyui-validatebox" name="nil_tapd2_' + counter2 +'" value="" /></td><td><input type="text" id="ket2_' + counter2 + '" class="hibBarangKet" name="ket2_' + counter2 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-hibah-barang tbody");
			$("input.hibBarangNama:last").focus();
			counter2++;
		};
		
		var removeInput2 = function() {
			counter2--;
			if(counter2 == 1){
				 $('input#removeButton2').attr('disabled','disabled');
				//alert("Minimal sisa 1!");
				counter2++;
				console.log('Jika Counter == 1 :' + counter2);
			}
			else{
				$("table#tbl-hibah-barang tbody tr:last").remove();
				console.log('Jika Counter != 1 :' + counter2);
			}
			$("input.hibBarangNama:last").focus();
		};
	
		if (!$("table#tbl-hibah-barang tbody").find("input.hibBarangNama").length) {
			addInput2();
		}
	
	
		$("input#addButton2").click(addInput2);
		$("input#removeButton2").click(removeInput2);
});
</script>

<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="<?=($act=='edit')?"do_update":"do_add"?>">
<input type="hidden" id="d_id" name="id" value="<?=$id?>">	
   <tr>
    <td colspan="2"><strong>Berita Acara Hasil Evaluasi TAPD</strong></td>
  </tr>
   <tr>
    <td>Nomor Berita Acara</td>
    <td>
      <input type="text" name="ba_no" id="ba_no" value="<?=$ba_no?>" style="width:200px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
   <tr>
    <td>Tanggal Berita Acara</td>
    <td>
      <input type="text" name="ba_tgl" id="ba_tgl" value="<?=$f->convertdatetime(array("datetime"=>$ba_tgl))?>" style="width:200px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>OPD</td>
    <td>
      <?=$f->selectList("opd_kode","tbl_opd","opd_kode","opd_nama",$opd_kode,"","")?>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Daftar Nominatif Calon Penerima Belanja Hibah (DNC-PBH) Berupa Uang</strong></td>
  </tr>
  <tr>
  	<td colspan="2">
    	<table id="tbl-hibah-uang" cellpadding="1" cellspacing="1" width="100%">
            <thead>
            	<tr>
                	 <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2">Alamat</th>
                     <th rowspan="2">Rencana Penggunaan</th>
                     <th colspan="3" align="center">Besaran Hibah (Rp)</th>
                     <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                	<th>Permohonan</th>
                    <th>Hasil Evaluasi OPD</th>
                    <th>Pertimbangan TAPD</th>
                </tr>
            </thead>
            <tbody>
<?
$i=0;
if ($kode) {
    //$sql = "SELECT a.hib_kode, b.hib_nama, CONCAT(hib_jalan,' RT.',hib_rt,' / RW.',hib_rw) as alamat, c.rencana_penggunaan as ren_guna, b.hib_besaran_hibah as besaran_hibah, c.besaran_opd, a.besaran_tapd, a.keterangan FROM tbl_eval_tapd_detail a LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode LEFT JOIN tbl_berita_acara_detail c ON a.hib_kode=c.hib_kode WHERE a.kode='$kode' and b.jh_kode=1 ORDER BY b.hib_nama ASC";
	$sql="SELECT hib_kode, nama AS hib_nama, alamat, rencana_penggunaan AS ren_guna, permohonan AS besaran_hibah, hasil_evaluasi_opd as besaran_opd, hasil_evaluasi_tapd as besaran_tapd, keterangan FROM v_dncpbh_tapd WHERE kode='$kode' and jenis='Uang' and tipe='HIBAH'";
    $result=$db->Execute($sql);
    while($row=$result->Fetchrow()){
		foreach($row as $key => $val){
				$$key=$val;
		}    
        $i++;
?>
        <tr>
            <td><div id="<?=$i?>"><?=$i?></div></td>
            <td><input type="text" id="nama_<?=$i?>" class="hibUangNama easyui-validatebox" name="nama_<?=$i?>" value="<?=$hib_nama?>" required="true" /> <input type="hidden" name="hib_kode_<?=$i?>" id="hib_kode_<?=$i?>" class="hibUangId" value="<?=$hib_kode?>" /></td>
            <td><input type="text" id="alamat_<?=$i?>" class="hibUangAlamat" name="alamat_<?=$i?>" value="<?=$alamat?>" disabled /></td>
            <td><input type="text" id="ren_guna_<?=$i?>" class="hibUangRenGuna" name="ren_guna_<?=$i?>" value="<?=$ren_guna?>" disabled /></td>
            <td><input type="text" id="nil_hibah_<?=$i?>" class="hibUangNilHibah" name="nil_hibah_<?=$i?>" value="<?=$besaran_hibah?>" disabled /></td>
            <td><input type="text" id="nil_opd_<?=$i?>" class="hibUangNilHibahOpd" name="nil_opd_<?=$i?>" value="<?=$besaran_opd?>" disabled /></td>
            <td><input type="text" id="nil_tapd_<?=$i?>" class="hibUangNilHibahTapd easyui-validatebox" name="nil_tapd_<?=$i?>" value="<?=$besaran_tapd?>" required="true" /></td>
            <td><input type="text" id="ket_<?=$i?>" class="hibUangKet" name="ket_<?=$i?>" value="<?=$keterangan?>" /></td>
        </tr>
<?
    }
}
$i++;
?>            
            
            </tbody>
    	</table>
        <input id="addButton" name="addButton" type="button" value="Tambah Baris" />
<input id="removeButton" name="removeButton" type="button" value="Hapus Baris" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Daftar Nominatif Calon Penerima Belanja Hibah (DNC-PBH) Berupa Barang/Jasa</strong></td>
  </tr>
  <tr>
  	<td colspan="2">
    	<table id="tbl-hibah-barang" border="0" cellpadding="1" cellspacing="1">
            <thead>
            	<tr>
                	 <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2">Alamat</th>
                     <th rowspan="2">Rencana Penggunaan</th>
                     <th colspan="3" align="center">Besaran Hibah (Rp)</th>
                     <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                	<th>Permohonan</th>
                    <th>Hasil Evaluasi OPD</th>
                    <th>Pertimbangan TAPD</th>
                </tr>
            </thead>
            <tbody>
<?
$i=0;
if ($kode) {
    //$sql = "SELECT a.hib_kode, b.hib_nama, CONCAT(hib_jalan,' RT.',hib_rt,' / RW.',hib_rw) as alamat, c.rencana_penggunaan as ren_guna, b.hib_besaran_hibah as besaran_hibah, c.besaran_opd, a.besaran_tapd, a.keterangan FROM tbl_eval_tapd_detail a LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode LEFT JOIN tbl_berita_acara_detail c ON a.hib_kode=c.hib_kode WHERE a.kode='$kode' and (b.jh_kode=2 or b.jh_kode=3) ORDER BY b.hib_nama ASC";
	$sql="SELECT hib_kode, nama AS hib_nama, alamat, rencana_penggunaan AS ren_guna, permohonan AS besaran_hibah, hasil_evaluasi_opd as besaran_opd, hasil_evaluasi_tapd as besaran_tapd, keterangan FROM v_dncpbh_tapd WHERE kode='$kode' and (jenis='Barang' or jenis='Jasa') and tipe='HIBAH'";
    $result=$db->Execute($sql);
    while($row=$result->Fetchrow()){
		foreach($row as $key => $val){
				$$key=$val;
		}    
        $i++;
?>
        <tr>
            <td><div id="<?=$i?>"><?=$i?></div></td>
            <td><input type="text" id="nama2_<?=$i?>" class="hibBarangNama easyui-validatebox" name="nama2_<?=$i?>" value="<?=$hib_nama?>" required="true" /> <input type="hidden" name="hib_kode2_<?=$i?>" id="hib_kode2_<?=$i?>" class="hibBarangId" value="<?=$hib_kode?>" /></td>
            <td><input type="text" id="alamat2_<?=$i?>" class="hibBarangAlamat" name="alamat2_<?=$i?>" value="<?=$alamat?>" disabled /></td>
            <td><input type="text" id="ren_guna2_<?=$i?>" class="hibBarangRenGuna" name="ren_guna2_<?=$i?>" value="<?=$ren_guna?>" disabled /></td>
            <td><input type="text" id="nil_hibah2_<?=$i?>" class="hibBarangNilHibah" name="nil_hibah2_<?=$i?>" value="<?=$besaran_hibah?>" disabled /></td>
            <td><input type="text" id="nil_opd2_<?=$i?>" class="hibBarangNilHibahOpd easyui-validatebox" name="nil_opd2_<?=$i?>" value="<?=$besaran_opd?>" disabled /></td>
            <td><input type="text" id="nil_tapd2_<?=$i?>" class="hibBarangNilHibahTapd easyui-validatebox" name="nil_tapd2_<?=$i?>" value="<?=$besaran_tapd?>" required="true" /></td>
            <td><input type="text" id="ket_2<?=$i?>" class="hibBarangKet" name="ket2_<?=$i?>" value="<?=$keterangan?>" /></td>
        </tr>
<?
    }
}
$i++;
?>           
            </tbody>
    	</table>
        <input id="addButton2" name="addButton2" type="button" value="Tambah Baris" />
<input id="removeButton2" name="removeButton2" type="button" value="Hapus Baris" />
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    <input type=button onClick=history.back(-1) value='&laquo; Back'> 
    <input class="submit" type=submit value="<?=($act=='add')?"Add":"Update";?>"></td>
  </tr>  
</table>
</form>

<?
} else if ($act == "do_add" || $act == "do_update") {
	foreach ($_POST as $key=>$val) {
        $$key = $val;
    }
    
    if ($id) {
		$sql = "SELECT kode FROM tbl_eval_tapd WHERE id=$id";
        $result=$db->Execute($sql);
        $row=$result->Fetchrow();
        $kode = $row['kode'];
       	    
        $sql = "UPDATE tbl_eval_tapd SET ba_no='$ba_no', ba_tgl='".$f->preparedate($ba_tgl)."', opd_kode='$opd_kode', mtime=NOW() WHERE id=$id";        
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
		
		/*
		if(!empty($no_nphd) && !empty($tgl_nphd))
			$sql = "UPDATE tbl_hibah SET hib_nphd='$no_nphd', hib_nphd_tgl='".$f->preparedate($tgl_nphd)."', hib_status='".$status_permohonan."' WHERE hib_kode=$reg_kode";
		else
			$sql = "UPDATE tbl_hibah SET hib_status='".$status_permohonan."' WHERE hib_kode=$reg_kode";
			
		$result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
		*/
		
		$sql2 = "SELECT hib_kode FROM tbl_eval_tapd_detail WHERE kode='$kode'";
		$result2=$db->Execute($sql2);
		while($row2=$result2->FetchRow()){
			$sql3 = "UPDATE tbl_hibah SET hib_eval_tapd='0', hib_status='Proses', mtime=NOW() WHERE hib_kode=$row2[hib_kode]";
			$result3=$db->Execute($sql3);
			if(!$result3){ print $db->ErrorMsg(); die(); }
		}
		  
        $sql = "DELETE FROM tbl_eval_tapd_detail WHERE kode='$kode'";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
		$kode = $login_id."-HIBAH-".$f->createRandomKey(10);
      
	    $sql = "INSERT INTO tbl_eval_tapd (id,ba_no,ba_tgl,opd_kode,tipe,kode,ctime,mtime) VALUES
('','".trim($ba_no)."','".$f->preparedate($ba_tgl)."','".$opd_kode."','HIBAH','$kode',NOW(),NOW())";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
	
	$i = 1;
    while (${"nama_".$i}) {
		$sta = ${"nil_tapd_".$i}==0?"0":"1"; 
		if(!${"nama_".$i}){
			// do nothing
		} else {
			$sql = "INSERT INTO tbl_eval_tapd_detail (id,kode,besaran_tapd,keterangan,hib_kode,status,ctime,mtime) VALUES ('','$kode','".${"nil_tapd_".$i}."', '".${"ket_".$i}."', '".${"hib_kode_".$i}."', '$sta', NOW(), NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
					
			// flag update hib_eval_tapd
			if(!$result){ print $db->ErrorMsg(); die(); }
			$sql = "UPDATE tbl_hibah SET hib_eval_tapd='1' WHERE hib_kode = '".${"hib_kode_".$i}."'";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
			if(!$result){ print $db->ErrorMsg(); die(); }
		}
		$i++;
    }
	
	$i = 1;
    while (${"nama2_".$i}) {
		$sta = ${"nil_tapd2_".$i}==0?"0":"1"; 
		if(!${"nama2_".$i}){
			// do nothing
		} else {
			$sql = "INSERT INTO tbl_eval_tapd_detail (id,kode,besaran_tapd,keterangan,hib_kode,status,ctime,mtime) VALUES ('','$kode', '".${"nil_tapd2_".$i}."', '".${"ket2_".$i}."', '".${"hib_kode2_".$i}."', '$sta', NOW(), NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
					
			// flag update hib_eval_tapd
			if(!$result){ print $db->ErrorMsg(); die(); }
			$sql = "UPDATE tbl_hibah SET hib_eval_tapd='1' WHERE hib_kode = '".${"hib_kode2_".$i}."'";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
			if(!$result){ print $db->ErrorMsg(); die(); }
		}
		$i++;
    }
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
else if ($act == "delete") {
	$sql = "SELECT kode FROM tbl_eval_tapd WHERE id=$id";
    $result=$db->Execute($sql);
    $row=$result->Fetchrow();
    $kode = $row['kode'];
	
	$sql2 = "SELECT hib_kode FROM tbl_eval_tapd_detail WHERE kode='$kode'";
    $result2=$db->Execute($sql2);
    while($row2=$result2->FetchRow()){
   		$sql3 = "UPDATE tbl_hibah SET hib_eval_tapd='0', hib_status='Proses', mtime=NOW() WHERE hib_kode=$row2[hib_kode]";
		$result3=$db->Execute($sql3);
		if(!$result3){ print $db->ErrorMsg(); die(); }
    }
	
	$sql = "DELETE FROM tbl_eval_tapd_detail WHERE kode='$kode'";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$sql = "DELETE FROM tbl_eval_tapd WHERE id=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
		
    header("location: $PHP_SELF");
}
else {

    if(!$start) $start='1';
    if(!$order)	$order='t.ba_tgl';
    if(!$sort) 	$sort='desc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    $f->standard_buttons();
    $f->search_box($query);

$cond1 = " left join tbl_opd o on t.opd_kode=o.opd_kode ";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));
$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (t.ba_no like '%$query%' or t.ba_tgl = '".$f->preparedate($query)."' or o.opd_nama like '%$query%')";
}

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel t.tipe = 'HIBAH' ";

$total = $f->count_total("tbl_eval_tapd t","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));
$sql="SELECT t.id, t.ba_no, t.ba_tgl, t.kode, o.opd_nama FROM tbl_eval_tapd t $cond1 $cond order by $order $sort";
$result=$db->SelectLimit("$sql","$num","$start");
#echo $sql;
if(!$result) print $db->ErrorMsg();
$_sort=($sort=='desc')?"asc":"desc"; 

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Nomor Berita Acara</th>
		<th class=white  valign=top>Tanggal Berita Acara</th>
		<th class=white  valign=top>OPD</th>
		<th class=white  valign=top>Besaran Permohonan (Rp)</th>
		<th class=white  valign=top>Besaran Hasil Evaluasi OPD (Rp)</th>
		<th class=white  valign=top>Besaran Pertimbangan TAPD (Rp)</th>
		<th class=white  valign=top>Function</th>
	</tr>
	";
	while($val=$result->FetchRow()){
		$i++;
		$bgcolor= ($i%2)?"#FFDDDD":"FFFFFF";
		//echo"<pre>";
		//print_r($val);
		foreach($val as $key1 => $val1){
			$key1=strtolower($key1);
			$$key1=$val1;
		}
		
		$sql2 = "SELECT SUM(permohonan) as permohonan, SUM(hasil_evaluasi_opd) as hasil_evaluasi_opd, SUM(hasil_evaluasi_tapd) as hasil_evaluasi_tapd FROM v_dncpbh_tapd WHERE kode='$kode'";
		$result2=$db->Execute($sql2);
		if(!$result2) print $db->ErrorMsg();
		$row2=$result2->FetchRow();
		
		/*
		$total_nilai_pem = 0;
		$total_nilai_opd = 0;
		$sql4 = "SELECT hib_kode FROM tbl_eval_tapd_detail WHERE kode='$kode'";
		$result4=$db->Execute($sql4);
		while($row4=$result4->FetchRow()){
			$hib_kode = $row4['hib_kode'];
			
			$sql2 = "SELECT hib_besaran_hibah as besaran_hibah FROM tbl_hibah WHERE hib_kode='$hib_kode'";
			$result2=$db->Execute($sql2);
			$row2=$result2->Fetchrow();
			$total_nilai_pem = $total_nilai_pem + $row2['besaran_hibah'];
			
			$sql3 = "SELECT besaran_opd FROM tbl_berita_acara_detail WHERE hib_kode='$hib_kode'";
			$result3=$db->Execute($sql3);
			$row3=$result3->Fetchrow();
			$total_nilai_opd = $total_nilai_opd + $row3['besaran_opd'];
		}
	
		$sql5 = "SELECT SUM(besaran_tapd) as t_nil_tapd FROM tbl_eval_tapd_detail WHERE kode = '$kode'";
		$result5=$db->Execute($sql5);
		$row5=$result5->Fetchrow();
		$total_nilai_tapd = $row5['t_nil_tapd'];
		*/
		
        echo"
		<tr bgcolor=$bgcolor>
			<td valign=top>".($i+$start)."</td>
			<td valign=top>$ba_no</td>
			<td valign=top>".$f->convertdatetime(array("datetime"=>$ba_tgl))."</td>
			<td valign=top>$opd_nama</td>
			<td valign=top align='right'>".number_format($row2['permohonan'],2,',','.')."</td>
			<td valign=top align='right'>".number_format($row2['hasil_evaluasi_opd'],2,',','.')."</td>
			<td valign=top align='right'>".number_format($row2['hasil_evaluasi_tapd'],2,',','.')."</td>
			";
        
        echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$id><img src=../images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$id onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a>
				<!--
				<p>
                <a href=docs/print_ba_evaluasi_hibah.php?id=$id><img src=../i/iconprint.gif border=0> Cetak Berita Acara</a>
				</p>
				!-->
				<p>
                <a href=dncpbh_tapd_preview.php?id=$id><img src=../i/iconprint.gif border=0> View DNC-PBH TAPD</a>
				</p>
				<p>
                <a href=dncpbh_tapd.php?id=$id><img src=../i/iconprint.gif border=0> Download DNC-PBH TAPD</a>
				</p> 
				 
				";

			echo"</td>
		</tr>
		";
		
		unset($_status,$tp);
	}
	echo"
	</table>
	";
	$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&status=$status&outlet_id=$outlet_id&outlet_query=$outlet_query&dealer_query=$dealer_query&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));



}
$t->basicfooter();
?>