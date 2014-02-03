<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Bantuan Sosial &raquo; Data Pertimbangan TAPD');


if ($act == "add" || $act == "edit") {

	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_eval_tapd WHERE id=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
		
		//$counter = $f->count_total("tbl_eval_tapd_detail"," where kode='$kode'") + 1;
		$counter1 = $f->count_total("v_dncpbs_tapd"," where kode='$kode' and jenis='Uang'") + 1;
		$counter2 = $f->count_total("v_dncpbs_tapd"," where kode='$kode' and jenis='Barang'") + 1;
    }
    
    if ($id && $act == "add") unset($id, $tgl_nphd, $ba_tgl);
    
	if (!$tgl_nphd) $tgl_nphd = date('Y-m-d');
	if (!$ba_tgl) $ba_tgl = date('Y-m-d');
	 
?>
<script type="text/javascript" src="/evaluasi_bansos_tapd.js"></script>
<script type="text/javascript">
	$(function() {
		var counter1 = <?php if(empty($counter1)) echo 1; else echo $counter1; ?>;
		var options = {
			source: 'autocomplete_bansos_tapd_uang.php',
			minLength: 2,
			focus: function( event, ui ) {
                    $( '#nama_' + counter1 ).val( ui.item.value );
					$(this).closest('tr').find('input.banUangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.banUangAlamat').val(ui.item.alamat);   
					$(this).closest('tr').find('input.banUangRenGuna').val(ui.item.rencana_penggunaan);
					$(this).closest('tr').find('input.banUangNilBansos').val(ui.item.besaran_bansos);
					$(this).closest('tr').find('input.banUangNilBansosOpd').val(ui.item.besaran_opd); 
					//console.log(ui.item.alamat);
           },
            select: function( event, ui ) {
					//event.preventDefault();
                    $( '#nama_' + counter1 ).val( ui.item.value );
					$(this).closest('tr').find('input.banUangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.banUangAlamat').val(ui.item.alamat);   
					$(this).closest('tr').find('input.banUangRenGuna').val(ui.item.rencana_penggunaan);
					$(this).closest('tr').find('input.banUangNilBansos').val(ui.item.besaran_bansos);
					$(this).closest('tr').find('input.banUangNilBansosOpd').val(ui.item.besaran_opd);   
					//console.log(ui.item.alamat);
                   //return false;
           }
		};
		$('input.banUangNama').live("keydown.autocomplete", function() {
		
			$(this).autocomplete(options);
		});
	
		var addInput = function() {
			if (counter1 > 1){
				$('input#removeButton').removeAttr('disabled');
			}
			var inputHTML = ' <tr><td><div id="' + counter1 + '">'+ counter1 +'</div></td><td><input type="text" id="nama_' +counter1 + '" class="banUangNama easyui-validatebox" name="nama_' + counter1 +'" value="" required="true" /> <input type="hidden" name="ban_kode_' + counter1 + '" id="ban_kode_' + counter1 + '" class="banUangId" value="" /></td><td><input type="text" id="alamat_' + counter1 + '" class="banUangAlamat" name="alamat_' + counter1 +'" value="" disabled /></td><td><input type="text" id="ren_guna_' + counter1 + '" class="banUangRenGuna" name="ren_guna_' + counter1 +'" value="" disabled /></td><td><input type="text" id="nil_bansos_' + counter1 + '" class="banUangNilBansos" name="nil_bansos_' + counter1 +'" value="" disabled /></td><td><input type="text" id="nil_opd_' + counter1 + '" class="banUangNilBansosOpd easyui-validatebox" name="nil_opd_' + counter1 +'" value="" disabled /><td><input type="text" id="nil_tapd_' + counter1 + '" class="banUangNilBansosTapd easyui-validatebox" name="nil_tapd_' + counter1 +'" value="" required="true" /></td><td><input type="text" id="ket_' + counter1 + '" class="banUangKet" name="ket_' + counter1 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-bansos-uang tbody");
			$("input.banUangNama:last").focus();
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
				$("table#tbl-bansos-uang tbody tr:last").remove();
				console.log('Jika Counter != 1 :' + counter1);
			}
			$("input.banUangNama:last").focus();
		};
	
		if (!$("table#tbl-bansos-uang tbody").find("input.banUangNama").length) {
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
			source: 'autocomplete_bansos_tapd_barang.php',
			minLength: 2,
			focus: function( event, ui ) {
                    $( '#nama2_' + counter2 ).val( ui.item.value );
					$(this).closest('tr').find('input.banBarangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.banBarangAlamat').val(ui.item.alamat); 
					$(this).closest('tr').find('input.banBarangRenGuna').val(ui.item.rencana_penggunaan);  
					$(this).closest('tr').find('input.banBarangNilHibah').val(ui.item.besaran_bansos); 
					$(this).closest('tr').find('input.banBarangNilHibahOpd').val(ui.item.besaran_opd); 
					//console.log(ui.item.alamat);
           },
            select: function( event, ui ) {
					//event.preventDefault();
                    $( '#nama2_' + counter2 ).val( ui.item.value );
					$(this).closest('tr').find('input.banBarangId').val(ui.item.id);                        
               		$(this).closest('tr').find('input.banBarangAlamat').val(ui.item.alamat); 
					$(this).closest('tr').find('input.banBarangRenGuna').val(ui.item.rencana_penggunaan);  
					$(this).closest('tr').find('input.banBarangNilBansos').val(ui.item.besaran_bansos); 
					$(this).closest('tr').find('input.banBarangNilBansosOpd').val(ui.item.besaran_opd);   
					//console.log(ui.item.alamat);
                   //return false;
           }
		};
		$('input.banBarangNama').live("keydown.autocomplete", function() {
		
			$(this).autocomplete(options);
		});
	
		var addInput2 = function() {
			if (counter2 > 1){
				$('input#removeButton2').removeAttr('disabled');
			}
			var inputHTML = ' <tr><td><div id="' + counter2 + '">'+ counter2 +'</div></td><td><input type="text" id="nama2_' +counter2 + '" class="banBarangNama easyui-validatebox" name="nama2_' + counter2 +'" value="" /> <input type="hidden" name="ban_kode2_' + counter2 + '" id="ban_kode2_' + counter2 + '" class="banBarangId" value="" /></td><td><input type="text" id="alamat2_' + counter2 + '" class="banBarangAlamat" name="alamat2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="ren_guna2_' + counter2 + '" class="banBarangRenGuna" name="ren_guna2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="nil_bansos2_' + counter2 + '" class="banBarangNilBansos" name="nil_bansos2_' + counter2 +'" value="" disabled /></td><td><input type="text" id="nil_opd2_' + counter2 + '" class="banBarangNilBansosOpd" name="nil_opd2_' + counter2 +'" value="" disabled /><td><input type="text" id="nil_tapd2_' + counter2 + '" class="hbanBarangNilBansosTapd easyui-validatebox" name="nil_tapd2_' + counter2 +'" value="" /></td><td><input type="text" id="ket2_' + counter2 + '" class="banBarangKet" name="ket2_' + counter2 +'" value="" /></td></tr>';
			$(inputHTML).appendTo("table#tbl-bansos-barang tbody");
			$("input.banBarangNama:last").focus();
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
				$("table#tbl-bansos-barang tbody tr:last").remove();
				console.log('Jika Counter != 1 :' + counter2);
			}
			$("input.banBarangNama:last").focus();
		};
	
		if (!$("table#tbl-bansos-barang tbody").find("input.banBarangNama").length) {
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
    <td colspan="2"><strong>Daftar Nominatif Calon Penerima Bantuan Sosial (DNC-PBS) Berupa Uang</strong></td>
  </tr>
  <tr>
  	<td colspan="2">
    	<table id="tbl-bansos-uang" cellpadding="1" cellspacing="1" width="100%">
            <thead>
            	<tr>
                	 <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2">Alamat</th>
                     <th rowspan="2">Rencana Penggunaan</th>
                     <th colspan="3" align="center">Besaran Bantuan Sosial (Rp)</th>
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
	$sql="SELECT ban_kode, nama AS ban_nama, alamat, rencana_penggunaan AS ren_guna, permohonan AS besaran_bansos, hasil_evaluasi_opd as besaran_opd, hasil_evaluasi_tapd as besaran_tapd, keterangan FROM v_dncpbs_tapd WHERE kode='$kode' and jenis='Uang' and tipe='BANSOS'";
    $result=$db->Execute($sql);
    while($row=$result->Fetchrow()){
		foreach($row as $key => $val){
				$$key=$val;
		}    
        $i++;
?>
        <tr>
            <td><div id="<?=$i?>"><?=$i?></div></td>
            <td><input type="text" id="nama_<?=$i?>" class="banUangNama easyui-validatebox" name="nama_<?=$i?>" value="<?=$ban_nama?>" required="true" /> <input type="hidden" name="ban_kode_<?=$i?>" id="ban_kode_<?=$i?>" class="banUangId" value="<?=$ban_kode?>" /></td>
            <td><input type="text" id="alamat_<?=$i?>" class="banUangAlamat" name="alamat_<?=$i?>" value="<?=$alamat?>" disabled /></td>
            <td><input type="text" id="ren_guna_<?=$i?>" class="banUangRenGuna" name="ren_guna_<?=$i?>" value="<?=$ren_guna?>" disabled /></td>
            <td><input type="text" id="nil_bansos_<?=$i?>" class="banUangNilBansos" name="nil_bansos_<?=$i?>" value="<?=$besaran_bansos?>" disabled /></td>
            <td><input type="text" id="nil_opd_<?=$i?>" class="banUangNilBansosOpd" name="nil_opd_<?=$i?>" value="<?=$besaran_opd?>" disabled /></td>
            <td><input type="text" id="nil_tapd_<?=$i?>" class="banUangNilBansosTapd easyui-validatebox" name="nil_tapd_<?=$i?>" value="<?=$besaran_tapd?>" required="true" /></td>
            <td><input type="text" id="ket_<?=$i?>" class="banUangKet" name="ket_<?=$i?>" value="<?=$keterangan?>" /></td>
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
    <td colspan="2"><strong>Daftar Nominatif Calon Penerima Bantuan Sosial (DNC-PBS) Berupa Barang</strong></td>
  </tr>
  <tr>
  	<td colspan="2">
    	<table id="tbl-bansos-barang" border="0" cellpadding="1" cellspacing="1">
            <thead>
            	<tr>
                	 <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2">Alamat</th>
                     <th rowspan="2">Rencana Penggunaan</th>
                     <th colspan="3" align="center">Besaran Bantuan Sosial (Rp)</th>
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
	
	$sql="SELECT ban_kode, nama AS ban_nama, alamat, rencana_penggunaan AS ren_guna, permohonan AS besaran_bansos, hasil_evaluasi_opd as besaran_opd, hasil_evaluasi_tapd as besaran_tapd, keterangan FROM v_dncpbs_tapd WHERE kode='$kode' and jenis='Barang' and tipe='BANSOS'";
    $result=$db->Execute($sql);
    while($row=$result->Fetchrow()){
		foreach($row as $key => $val){
				$$key=$val;
		}    
        $i++;
?>
        <tr>
            <td><div id="<?=$i?>"><?=$i?></div></td>
            <td><input type="text" id="nama2_<?=$i?>" class="banBarangNama easyui-validatebox" name="nama2_<?=$i?>" value="<?=$ban_nama?>" required="true" /> <input type="hidden" name="ban_kode2_<?=$i?>" id="ban_kode2_<?=$i?>" class="banBarangId" value="<?=$ban_kode?>" /></td>
            <td><input type="text" id="alamat2_<?=$i?>" class="banBarangAlamat" name="alamat2_<?=$i?>" value="<?=$alamat?>" disabled /></td>
            <td><input type="text" id="ren_guna2_<?=$i?>" class="banBarangRenGuna" name="ren_guna2_<?=$i?>" value="<?=$ren_guna?>" disabled /></td>
            <td><input type="text" id="nil_bansos2_<?=$i?>" class="banBarangNilBansos" name="nil_bansos2_<?=$i?>" value="<?=$besaran_bansos?>" disabled /></td>
            <td><input type="text" id="nil_opd2_<?=$i?>" class="banBarangNilBansosOpd easyui-validatebox" name="nil_opd2_<?=$i?>" value="<?=$besaran_opd?>" disabled /></td>
            <td><input type="text" id="nil_tapd2_<?=$i?>" class="banBarangNilBansosTapd easyui-validatebox" name="nil_tapd2_<?=$i?>" value="<?=$besaran_tapd?>" required="true" /></td>
            <td><input type="text" id="ket_2<?=$i?>" class="banBarangKet" name="ket2_<?=$i?>" value="<?=$keterangan?>" /></td>
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
			$sql3 = "UPDATE tbl_bansos SET ban_eval_tapd='0', ban_status='Proses', mtime=NOW() WHERE ban_kode=$row2[hib_kode]";
			$result3=$db->Execute($sql3);
			if(!$result3){ print $db->ErrorMsg(); die(); }
		}
		  
        $sql = "DELETE FROM tbl_eval_tapd_detail WHERE kode='$kode'";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
		$kode = $login_id."-BANSOS-".$f->createRandomKey(10);
      
	    $sql = "INSERT INTO tbl_eval_tapd (id,ba_no,ba_tgl,opd_kode,tipe,kode,ctime,mtime) VALUES
('','".trim($ba_no)."','".$f->preparedate($ba_tgl)."','".$opd_kode."','BANSOS','$kode',NOW(),NOW())";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
	
	$i = 1;
    while (${"nama_".$i}) {
		$sta = ${"nil_tapd_".$i}==0?"0":"1"; 
		if(!${"nama_".$i}){
			// do nothing
		} else {
			$sql = "INSERT INTO tbl_eval_tapd_detail (id,kode,besaran_tapd,keterangan,hib_kode,status,ctime,mtime) VALUES ('','$kode','".${"nil_tapd_".$i}."', '".${"ket_".$i}."', '".${"ban_kode_".$i}."', '$sta', NOW(), NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
					
			// flag update hib_eval_tapd
			if(!$result){ print $db->ErrorMsg(); die(); }
			$sql = "UPDATE tbl_bansos SET ban_eval_tapd='1' WHERE ban_kode = '".${"ban_kode_".$i}."'";
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
			$sql = "INSERT INTO tbl_eval_tapd_detail (id,kode,besaran_tapd,keterangan,hib_kode,status,ctime,mtime) VALUES ('','$kode', '".${"nil_tapd2_".$i}."', '".${"ket2_".$i}."', '".${"ban_kode2_".$i}."', '$sta', NOW(), NOW())";
			#echo $sql."<p>";
			$result=$db->Execute($sql);
					
			// flag update hib_eval_tapd
			if(!$result){ print $db->ErrorMsg(); die(); }
			$sql = "UPDATE tbl_bansos SET ban_eval_tapd='1' WHERE ban_kode = '".${"ban_kode2_".$i}."'";
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
   		$sql3 = "UPDATE tbl_bansos SET ban_eval_tapd='0', ban_status='Proses', mtime=NOW() WHERE ban_kode=$row2[hib_kode]";
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
$cond  .=" $rel t.tipe = 'BANSOS' ";

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
		
		$sql2 = "SELECT SUM(permohonan) as permohonan, SUM(hasil_evaluasi_opd) as hasil_evaluasi_opd, SUM(hasil_evaluasi_tapd) as hasil_evaluasi_tapd FROM v_dncpbs_tapd WHERE kode='$kode'";
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
                <a href=docs/print_ba_evaluasi_bansos.php?id=$id><img src=../i/iconprint.gif border=0> Cetak Berita Acara</a>
				</p>
				!-->
				<p>
                <a href=dncpbs_tapd_preview.php?id=$id><img src=../i/iconprint.gif border=0> View DNC-PBS TAPD</a>
				</p>
				<p>
                <a href=dncpbs_tapd.php?id=$id><img src=../i/iconprint.gif border=0> Download DNC-PBS TAPD</a>
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