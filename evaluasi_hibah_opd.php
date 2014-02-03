<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Hibah &raquo; Data Evaluasi OPD');


if ($act == "add" || $act == "edit") {

	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_berita_acara WHERE id=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
		
		//$counter = $f->count_total("tbl_berita_acara_detail"," where kode='$kode'") + 1;
		$counter1 = $f->count_total("v_dncpbh_opd"," where kode='$kode' and jenis='Uang'") + 1;
		$counter2 = $f->count_total("v_dncpbh_opd"," where kode='$kode' and (jenis='Barang' or jenis='Jasa')") + 1;
		$counter3 = $f->count_total("tbl_tim_evaluasi"," where kode='$kode'") + 1;
    }
    
    if ($id && $act == "add") unset($id, $sk_tgl, $ba_tgl);
    
	if (!$sk_tgl) $sk_tgl = date('Y-m-d');
	if (!$ba_tgl) $ba_tgl = date('Y-m-d');
	 
?>
<script type="text/javascript" src="/jquery.formatCurrency.min.js"></script>
<script type="text/javascript" src="/jquery.formatCurrency.id-ID.js"></script>
<script type="text/javascript" src="/evaluasi_hibah_opd.js"></script>
<script type="text/javascript">
	$(function() {
		var counter1 = <?php if(empty($counter1)) echo 1; else echo $counter1; ?>;
		var options = {
			source: 'autocomplete_hibah_opd_uang.php',
			minLength: 2,
			focus: function( event, ui ) {
                    $( '#nama_' + counter1 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibUangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibUangAlamat').val(ui.item.alamat);
					$(this).closest('tr').find('input.hibUangRenGuna').val(ui.item.ren_guna);   
					$(this).closest('tr').find('input.hibUangNilHibah').val(ui.item.besaran_hibah); 
					//console.log(ui.item.alamat);
           },
            select: function( event, ui ) {
					//event.preventDefault();
                    $( '#nama_' + counter1 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibUangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibUangAlamat').val(ui.item.alamat);
					$(this).closest('tr').find('input.hibUangRenGuna').val(ui.item.ren_guna); 
					$(this).closest('tr').find('input.hibUangNilHibah').val(ui.item.besaran_hibah);   
					console.log(ui.item.alamat);
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
			var inputHTML = ' <tr><td><div id="' + counter1 + '">'+ counter1 +'</div></td><td><input type="text" id="nama_' +counter1 + '" class="hibUangNama easyui-validatebox" name="nama_' + counter1 +'" value="" required="true" /> <input type="hidden" name="hib_kode_' + counter1 + '" id="hib_kode_' + counter1 + '" class="hibUangId" value="" /></td><td><input type="text" id="alamat_' + counter1 + '" class="hibUangAlamat" name="alamat_' + counter1 +'" value="" disabled /></td><td><input type="text" id="ren_guna_' + counter1 + '" class="hibUangRenGuna" name="ren_guna_' + counter1 +'" value="" disabled /></td><td><input type="text" id="nil_hibah_' + counter1 + '" class="hibUangNilHibah" name="nil_hibah_' + counter1 +'" value="" disabled /></td><td><input type="text" id="nil_opd_' + counter1 + '" class="hibUangNilHibahOpd easyui-validatebox" name="nil_opd_' + counter1 +'" value="" required="true" /></td><td><input type="text" id="ket_' + counter1 + '" class="hibUangKet" name="ket_' + counter1 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-hibah-uang tbody");
			//$("input.hibUangNama:last").focus();
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
			source: 'autocomplete_hibah_opd_barang.php',
			minLength: 2,
			focus: function( event, ui ) {
                    $( '#nama2_' + counter2 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibBarangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibBarangAlamat').val(ui.item.alamat);  
					$(this).closest('tr').find('input.hibBarangRenGuna').val(ui.item.ren_guna);  
					$(this).closest('tr').find('input.hibBarangNilHibah').val(ui.item.besaran_hibah); 
					//console.log(ui.item.alamat);
           },
            select: function( event, ui ) {
					//event.preventDefault();
                    $( '#nama2_' + counter2 ).val( ui.item.value );
					$(this).closest('tr').find('input.hibBarangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.hibBarangAlamat').val(ui.item.alamat);
					$(this).closest('tr').find('input.hibBarangRenGuna').val(ui.item.ren_guna);
					$(this).closest('tr').find('input.hibBarangNilHibah').val(ui.item.besaran_hibah);   
					console.log(ui.item.alamat);
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
			var inputHTML = ' <tr><td><div id="' + counter2 + '">'+ counter2 +'</div></td><td><input type="text" id="nama2_' +counter2 + '" class="hibBarangNama easyui-validatebox" name="nama2_' + counter2 +'" value="" /> <input type="hidden" name="hib_kode2_' + counter2 + '" id="hib_kode2_' + counter2 + '" class="hibBarangId" value="" /></td><td><input type="text" id="alamat2_' + counter2 + '" class="hibBarangAlamat" name="alamat2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="ren_guna2_' + counter2 + '" class="hibBarangRenGuna" name="ren_guna2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="nil_hibah2_' + counter2 + '" class="hibBarangNilHibah" name="nil_hibah2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="nil_opd2_' + counter2 + '" class="hibBarangNilHibahOpd easyui-validatebox" name="nil_opd2_' + counter2 +'" value="" /></td><td><input type="text" id="ket2_' + counter2 + '" class="hibBarangKet" name="ket2_' + counter2 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-hibah-barang tbody");
			//$("input.hibBarangNama:last").focus();
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

<script type="text/javascript">
	$(function() {
		var counter3 = <?php if(empty($counter3)) echo 1; else echo $counter3; ?>;
	
		var addInput3 = function() {
			if (counter3 > 1){
				$('input#removeTE').removeAttr('disabled');
			}
			var inputHTML = ' <tr><td><div id="' + counter3 + '">'+ counter3 +'</div></td><td><input type="text" id="te_nama_' +counter3 + '" class="teNama easyui-validatebox" required="required" name="te_nama_' + counter3 +'" value="" style="width:300px;" /> <input type="hidden" name="te_id_' + counter3 + '" id="te_id_' + counter3 + '" class="teId" value="" /></td><td><input type="text" id="te_nip_' + counter3 + '" class="teNip easyui-validatebox" required="required" name="te_nip_' + counter3 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-tim-eval tbody");
			//$("input.teNama:last").focus();
			counter3++;
		};
		
		var removeInput3 = function() {
			counter3--;
			if(counter3 == 1){
				 $('input#removeTE').attr('disabled','disabled');
				//alert("Minimal sisa 1!");
				counter3++;
				console.log('Jika Counter == 1 :' + counter3);
			}
			else{
				$("table#tbl-tim-eval tbody tr:last").remove();
				console.log('Jika Counter != 1 :' + counter3);
			}
			$("input.teNama:last").focus();
		};
	
		if (!$("table#tbl-tim-eval tbody").find("input.teNama").length) {
			addInput3();
		}
	
		$("input#addTE").click(addInput3);
		$("input#removeTE").click(removeInput3);
});
</script>

<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="<?=($act=='edit')?"do_update":"do_add"?>">
<input type="hidden" id="d_id" name="id" value="<?=$id?>">	
   <tr>
    <td colspan="2"><strong>Berita Acara Hasil Evaluasi OPD</strong></td>
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
  <?php
  if($login_opd!=='0'){
  	echo "<input type='hidden' name='opd_kode' id='opd_kode' value='$login_opd' />";
  } else {
  	?>
    <tr>
        <td>OPD</td>
        <td>
          <?=$f->selectList("opd_kode","tbl_opd","opd_kode","opd_nama",$opd_kode,"","")?>
        </td>
  	</tr>
  	<?php
  }
  ?>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Tim Evaluasi</strong></td>
  </tr>
  <tr>
    <td>Nomor SK Tim Evaluasi</td>
    <td>
      <input type="text" name="sk_no" id="sk_no" value="<?=$sk_no?>" style="width:200px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tanggal SK Tim Evaluasi</td>
    <td>
      <input type="text" name="sk_tgl" id="sk_tgl" value="<?=$f->convertdatetime(array("datetime"=>$sk_tgl))?>" style="width:200px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tentang</td>
    <td>
      <textarea name="sk_tentang" id="sk_tentang" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$sk_tentang?></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="2"><strong>Daftar Tim Evaluasi</strong></td>
  </tr>
  <tr>
    <td colspan="2">
    	<table id="tbl-tim-eval" cellpadding="1" cellspacing="1" width="100%">
            <thead>
            	<tr>
                	 <th width="5%">No</th>
                     <th width="25%">Nama</th>
                     <th width="75%">NIP</th>
                </tr>
            </thead>
            <tbody>
<?
$i=0;
if ($kode) {
    $sql = "SELECT id, nama, nip FROM tbl_tim_evaluasi WHERE kode = '$kode'";
    $result=$db->Execute($sql);
    while($row=$result->Fetchrow()){
		foreach($row as $key => $val){
				$$key=$val;
		}    
        $i++;
?>
        <tr>
            <td><div id="<?=$i?>"><?=$i?></div></td>
            <td><input type="text" id="te_nama_<?=$i?>" class="teNama easyui-validatebox" required="required" name="te_nama_<?=$i?>" value="<?=$nama?>" style="width:300px;" /><input type="hidden" id="te_id_<?=$i?>" class="teId" name="te_id_<?=$i?>" value="<?=$id?>" /></td>
            <td><input type="text" id="te_nip_<?=$i?>" class="teNip easyui-validatebox" required="required" name="te_nip_<?=$i?>" value="<?=$nip?>" /></td>
        </tr>
<?
    }
}
$i++;
?>
			</tbody>
    	</table>
        <input id="addTE" name="addTE" type="button" value="Tambah Baris" />
		<input id="removeTE" name="removeTE" type="button" value="Hapus Baris" />  
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
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
                     <th colspan="2" align="center">Besaran Hibah (Rp)</th>
                     <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                	<th>Permohonan</th>
                    <th>Hasil Evaluasi OPD</th>
                </tr>
            </thead>
            <tbody>
<?
$i=0;
if ($kode) {
    $sql = "SELECT a.hib_kode, b.hib_nama, CONCAT(hib_jalan,' RT.',hib_rt,' / RW.',hib_rw) as alamat, b.hib_ren_guna as ren_guna, b.hib_besaran_hibah as besaran_hibah, a.besaran_opd, a.keterangan FROM tbl_berita_acara_detail a LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode WHERE a.kode = '$kode' and b.jh_kode=1 ORDER BY b.hib_nama ASC";
    $result=$db->Execute($sql);
    while($row=$result->Fetchrow()){
		foreach($row as $key => $val){
				$$key=$val;
		}    
        $i++;
?>
	<!--
    <script>
    $('#nil_opd_1').blur(function() {
		$(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: 2, region: 'id-ID' });
	})
    </script>
    !-->
        <tr>
            <td><div id="<?=$i?>"><?=$i?></div></td>
            <td><input type="text" id="nama_<?=$i?>" class="hibUangNama easyui-validatebox" name="nama_<?=$i?>" value="<?=$hib_nama?>" required="true" /> <input type="hidden" name="hib_kode_<?=$i?>" id="hib_kode_<?=$i?>" class="hibUangId" value="<?=$hib_kode?>" /></td>
            <td><input type="text" id="alamat_<?=$i?>" class="hibUangAlamat" name="alamat_<?=$i?>" value="<?=$alamat?>" disabled /></td>
            <td><input type="text" id="ren_guna_<?=$i?>" class="hibUangRenGuna" name="ren_guna_<?=$i?>" value="<?=$ren_guna?>" disabled /></td>
            <td><input type="text" id="nil_hibah_<?=$i?>" class="hibUangNilHibah" name="nil_hibah_<?=$i?>" value="<?=$besaran_hibah?>" disabled /></td>
            <td><input type="text" id="nil_opd_<?=$i?>" class="hibUangNilHibahOpd easyui-validatebox" name="nil_opd_<?=$i?>" value="<?=$besaran_opd?>" required="true" /></td>
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
    	<table id="tbl-hibah-barang" border="0" cellpadding="1" cellspacing="1" width="100%">
            <thead>
            	<tr>
                	 <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2">Alamat</th>
                     <th rowspan="2">Rencana Penggunaan</th>
                     <th colspan="2" align="center">Besaran Hibah (Rp)</th>
                     <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                	<th>Permohonan</th>
                    <th>Hasil Evaluasi OPD</th>
                </tr>
            </thead>
            <tbody>
<?
$i=0;
if ($kode) {
    $sql = "SELECT a.hib_kode, b.hib_nama, CONCAT(hib_jalan,' RT.',hib_rt,' / RW.',hib_rw) as alamat, b.hib_ren_guna as ren_guna, b.hib_besaran_hibah as besaran_hibah, a.besaran_opd, a.keterangan FROM tbl_berita_acara_detail a LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode WHERE a.kode = '$kode' and (b.jh_kode=2 or b.jh_kode=3) ORDER BY b.hib_nama ASC";
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
            <td><input type="text" id="nil_opd2_<?=$i?>" class="hibBarangNilHibahOpd easyui-validatebox" name="nil_opd2_<?=$i?>" value="<?=$besaran_opd?>" required="true" /></td>
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
    <input type="button" onClick="history.back(-1)" value="&laquo; Back" /> 
    <input class="submit" type=submit value="<?=($act=='add')?"Add":"Update";?>" /></td>
  </tr>  
</table>
</form>

<?
} else if ($act == "do_add" || $act == "do_update") {
	foreach ($_POST as $key=>$val) {
        $$key = $val;
    }
    
    if ($id) {
		$sql = "SELECT kode FROM tbl_berita_acara WHERE id=$id";
        $result=$db->Execute($sql);
        $row=$result->Fetchrow();
        $kode = $row['kode'];
       	    
        $sql = "UPDATE tbl_berita_acara SET ba_no='$ba_no', ba_tgl='".$f->preparedate($ba_tgl)."', opd_kode='$opd_kode', sk_no='$sk_no', sk_tgl='".$f->preparedate($sk_tgl)."', sk_tentang='".trim($sk_tentang)."', user='".$login_full_name."', mtime=NOW() WHERE id=$id";        
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
		
		$sql2 = "SELECT hib_kode FROM tbl_berita_acara_detail WHERE kode='$kode'";
		$result2=$db->Execute($sql2);
		while($row2=$result2->FetchRow()){
			$sql3 = "UPDATE tbl_hibah SET hib_eval_opd='0', hib_status='Proses', mtime=NOW() WHERE hib_kode=$row2[hib_kode]";
			$result3=$db->Execute($sql3);
			if(!$result3){ print $db->ErrorMsg(); die(); }
		}
		  
        $sql = "DELETE FROM tbl_berita_acara_detail WHERE kode='$kode'";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
		
		$sql = "DELETE FROM tbl_tim_evaluasi WHERE kode='$kode'";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
		$kode = $login_id."-HIBAH-".$f->createRandomKey(10);
      
	    $sql = "INSERT INTO tbl_berita_acara (id,ba_no,ba_tgl,opd_kode,tipe,sk_no,sk_tgl,sk_tentang,kode,user,ctime,mtime) VALUES
('','".trim($ba_no)."','".$f->preparedate($ba_tgl)."','".$opd_kode."','HIBAH','$sk_no','".$f->preparedate($sk_tgl)."','".trim($sk_tentang)."','$kode','".$login_full_name."',NOW(),NOW())";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
	
	// DNC-PBH Hibah Berupa Uang
	$i = 1;
    while (${"nama_".$i}) {
		$sta = ${"nil_opd_".$i}==0?"0":"1"; 
		if(!${"nama_".$i}){
			// do nothing
		} else {
			$sql = "INSERT INTO tbl_berita_acara_detail (id,kode,besaran_opd,keterangan,hib_kode,status,ctime,mtime) VALUES ('','$kode', '".${"nil_opd_".$i}."', '".${"ket_".$i}."', '".${"hib_kode_".$i}."', '$sta', NOW(), NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
					
			// flag update hib_eval_opd
			if(!$result){ print $db->ErrorMsg(); die(); }
			$sql = "UPDATE tbl_hibah SET hib_eval_opd='1' WHERE hib_kode = '".${"hib_kode_".$i}."'";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
			if(!$result){ print $db->ErrorMsg(); die(); }
		}
		$i++;
    }
	
	// DNC-PBH Hibah Berupa Barang/Jasa
	$i = 1;
    while (${"nama2_".$i}) {
		$sta = ${"nil_opd2_".$i}==0?"0":"1"; 
		if(!${"nama2_".$i}){
			// do nothing
		} else {
			$sql = "INSERT INTO tbl_berita_acara_detail (id,kode,besaran_opd,keterangan,hib_kode,status,ctime,mtime) VALUES ('','$kode', '".${"nil_opd2_".$i}."', '".${"ket2_".$i}."', '".${"hib_kode2_".$i}."', '$sta', NOW(), NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
					
			// flag update hib_eval_opd
			if(!$result){ print $db->ErrorMsg(); die(); }
			$sql = "UPDATE tbl_hibah SET hib_eval_opd='1' WHERE hib_kode = '".${"hib_kode2_".$i}."'";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
			if(!$result){ print $db->ErrorMsg(); die(); }
		}
		$i++;
    }
	
	// Tim Evaluasi 
	$i = 1;
    while (${"te_nama_".$i}) {
		if(!${"te_nama_".$i}){
			// do nothing
		} else {
			$sql = "INSERT INTO tbl_tim_evaluasi (id,nama,nip,kode,ctime,mtime) VALUES ('','".${"te_nama_".$i}."','".${"te_nip_".$i}."','$kode',NOW(),NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
			if(!$result){ print $db->ErrorMsg(); die(); }
		}
		$i++;
    }
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
else if ($act == "delete") {
	$sql = "SELECT kode FROM tbl_berita_acara WHERE id=$id";
    $result=$db->Execute($sql);
    $row=$result->Fetchrow();
    $kode = $row['kode'];
	
	$sql2 = "SELECT hib_kode FROM tbl_berita_acara_detail WHERE kode='$kode'";
    $result2=$db->Execute($sql2);
    while($row2=$result2->FetchRow()){
   		$sql3 = "UPDATE tbl_hibah SET hib_eval_opd='0', hib_status='Proses', mtime=NOW() WHERE hib_kode=$row2[hib_kode]";
		$result3=$db->Execute($sql3);
		if(!$result3){ print $db->ErrorMsg(); die(); }
    }
	
	$sql = "DELETE FROM tbl_berita_acara_detail WHERE kode='$kode'";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$sql = "DELETE FROM tbl_berita_acara WHERE id=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$sql = "DELETE FROM tbl_tim_evaluasi WHERE kode='$kode'";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
		
    header("location: $PHP_SELF");
}
else {

    if(!$start) $start='1';
    if(!$order)	$order='b.ba_tgl';
    if(!$sort) 	$sort='desc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    $f->standard_buttons();
    $f->search_box($query);

$cond1 = " left join tbl_opd o on b.opd_kode=o.opd_kode ";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));
$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (b.ba_no like '%$query%' or b.ba_tgl = '".$f->preparedate($query)."' or o.opd_nama like '%$query%') ";

}

$rel = !empty($cond)?"and":"where";
if($login_opd!=='0'){
	$cond  .=" $rel b.tipe = 'HIBAH' and b.opd_kode = $login_opd ";
}else{
	$cond  .=" $rel b.tipe = 'HIBAH' ";
}

$total = $f->count_total("tbl_berita_acara b","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));
$sql="SELECT b.id, b.ba_no, b.ba_tgl, b.kode, b.user, o.opd_nama FROM tbl_berita_acara b $cond1 $cond order by $order $sort";
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
		<th class=white  valign=top>Petugas</th>
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
		
		$total_nilai_pem = 0;
		$sql2 = "SELECT hib_kode FROM tbl_berita_acara_detail WHERE kode='$kode'";
		$result2=$db->Execute($sql2);
		while($row2=$result2->FetchRow()){
			$hib_kode = $row2['hib_kode'];
			$sql3 = "SELECT hib_besaran_hibah as besaran_hibah FROM tbl_hibah WHERE hib_kode='$hib_kode'";
			$result3=$db->Execute($sql3);
			$row3=$result3->Fetchrow();
			
			$total_nilai_pem = $total_nilai_pem + $row3['besaran_hibah'];
		}
		
		$sql4 = "SELECT SUM(besaran_opd) as t_nil_opd FROM tbl_berita_acara_detail WHERE kode = '$kode'";
		$result4=$db->Execute($sql4);
		$row4=$result4->Fetchrow();
		$total_nilai_opd = $row4['t_nil_opd'];
		
		
        echo"
		<tr bgcolor=$bgcolor>
			<td valign=top>".($i+$start)."</td>
			<td valign=top>$ba_no</td>
			<td valign=top>".$f->convertdatetime(array("datetime"=>$ba_tgl))."</td>
			<td valign=top>$opd_nama</td>
			<td valign=top align='right'>".number_format($total_nilai_pem,2,',','.')."</td>
			<td valign=top align='right'>".number_format($total_nilai_opd,2,',','.')."</td>
			<td valign=top>$user</td>
			";
        
        echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$id><img src=../images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$id onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a>
				<p>
                <a href=docs/print_ba_evaluasi_hibah.php?id=$id><img src=../i/iconprint.gif border=0> Cetak Berita Acara</a>
				</p>
				<p>
                <a href=dncpbh_opd_preview.php?id=$id><img src=../i/iconprint.gif border=0> View DNC-PBH OPD</a>
				</p> 
				<p>
                <a href=dncpbh_opd.php?id=$id><img src=../i/iconprint.gif border=0> Download DNC-PBH OPD</a>
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