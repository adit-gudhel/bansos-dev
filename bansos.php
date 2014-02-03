<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Bantuan Sosial &raquo; Data Pemohon Bantuan Sosial');


if ($act == "add" || $act == "edit") {

	if ($id) {

        $sql = "SELECT * FROM tbl_bansos WHERE ban_kode=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
       
    }
    
    if ($id && $act == "add") unset($id, $ban_tanggal);
    
    if (!$ban_tanggal) $ban_tanggal = date('Y-m-d');
    

?>
<script type="text/javascript" src="/bansos.js"></script>
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="<?=($act=='edit')?"do_update":"do_add"?>">
<input type="hidden" name="id" value="<?=$ban_kode?>">
  <tr>
    <td>Jenis Bantuan Sosial</td>
    <td>
     <?=$f->selectListArray("ban_jenis",array("Terencana"=>"Terencana", "Tidak Terencana"=>"Tidak Terencana"),$ban_jenis)?>
    </td>
  </tr>
  <tr>
    <td>Bantuan Sosial Berupa</td>
    <td>
      <?=$f->selectList("jh_kode","tbl_jenis_hibah","jh_kode","jh_jenis",$jh_kode,"","")?>
    </td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>
      <input type="text" name="ban_tanggal" id="ban_tanggal" value="<?=$f->convertdatetime(array("datetime"=>$ban_tanggal))?>" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Pemohon Bantuan Sosial</strong></td>
  </tr>
  <tr>
    <td>Nama Pemohon</td>
    <td>
      <input type="text" name="ban_nama" id="ban_nama" value="<?=$ban_nama?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>No. KTP</td>
    <td>
      <input type="text" name="ban_ktp" id="ban_ktp" value="<?=$ban_ktp?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Nama Pimpinan</td>
    <td>
      <input type="text" name="pimpinan" id="pimpinan" value="<?=$pimpinan?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>
      <textarea name="ban_jalan" id="ban_jalan" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$ban_jalan?></textarea>
    </td>
  </tr>
  <tr>
    <td>RT / RW</td>
    <td>
      <input type="text" name="ban_rt" id="ban_rt" value="<?=$ban_rt?>" style="width:80px;" class="easyui-validatebox" required="true" />  / <input type="text" name="ban_rw" id="ban_rw" value="<?=$ban_rw?>" style="width:80px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Propinsi</td>
    <td>
      <?=$f->selectList("kd_propinsi","tbl_propinsi","kd_propinsi","nm_propinsi",$kd_propinsi," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text',onSelect: function(rec){ var url = 'get_wilayah.php?ajaxselect=propinsi&kd_propinsi='+rec.id; $('#kd_dati2').combobox('clear'); $('#kd_dati2').combobox('reload', url); $('#kd_kecamatan').combobox('clear'); $('#kd_kecamatan').combobox('reload', 'get_wilayah.php'); $('#kd_kelurahan').combobox('clear'); $('#kd_kelurahan').combobox('reload', 'get_wilayah.php'); }\" ","")?>
    </td>
  </tr>
  <tr>
    <td>Kota / Kabupaten</td>
    <td>
     <?=$f->selectList("kd_dati2","tbl_dati2","kd_dati2","nm_dati2",$kd_dati2," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text',onSelect: function(rec2){ var url = 'get_wilayah.php?ajaxselect=dati2&kd_dati2='+rec2.id; $('#kd_kecamatan').combobox('clear'); $('#kd_kecamatan').combobox('reload', url); $('#kd_kelurahan').combobox('clear'); $('#kd_kelurahan').combobox('reload', 'get_wilayah.php'); }\" ","where substr(kd_dati2,1,2)='".$kd_propinsi."'")?>
    </td>
  </tr>
   <tr>
    <td>Kecamatan</td>
    <td>
      <?=$f->selectList("kd_kecamatan","tbl_kecamatan","kd_kecamatan","nm_kecamatan",$kd_kecamatan," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text',onSelect: function(rec3){ var url = 'get_wilayah.php?ajaxselect=kecamatan&kd_kecamatan='+rec3.id; $('#kd_kelurahan').combobox('clear'); $('#kd_kelurahan').combobox('reload', url); }\" ","where substr(kd_kecamatan,1,4)='".$kd_dati2."'")?>
    </td>
  </tr>
   <tr>
    <td>Kelurahan</td>
    <td>
      <?=$f->selectList("kd_kelurahan","tbl_kelurahan","kd_kelurahan","nm_kelurahan",$kd_kelurahan," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text'\" ","where substr(kd_kelurahan,1,7)='".$kd_kecamatan."'")?>
    </td>
  </tr>
  <tr>
    <td>Kodepos</td>
    <td>
      <input type="text" name="ban_kodepos" id="ban_kodepos" value="<?=$ban_kodepos?>" style="width:200px;" />
      <input type="button" name="cek" id="cek" value="Cek" />
      <div id="message" style="display:inline-block;"></div>
    </td>
  </tr>
  
  <script>
  $(function(){
	$("#cek").click(function(){
		//$("#message").html(" <img src='/images/ajax-loader.gif' /> Memeriksa...");
		var nama = $("#ban_nama").val();
		var pimpinan = $("#pimpinan").val();
		var alamat = $("#ban_jalan").val();
		var rt = $("#ban_rt").val();
		var rw = $("#ban_rw").val();
		//var prop = $("input[name='kd_propinsi']").val();
		//var dati2 = $("input[name='kd_dati2']").val();
		//var kec = $("input[name='kd_kecamatan']").val();
		var kel = $("input[name='kd_kelurahan']").val();
		var kodepos = $("#ban_kodepos").val();
		//var data = "nama="+nama
		
		//console.log(nama +" "+ pimpinan +" "+ alamat +" RT."+ rt +" / RW."+ rw +", "+ kel +" "+ kodepos);
		
		$.ajax({
                type: "POST",
                url: "/check.php",
                data: {tipe: "bansos", nama: $("#ban_nama").val(), pimpinan: $("#pimpinan").val(), alamat: $("#ban_jalan").val(), rt: $("#ban_rt").val(), rw: $("#ban_rw").val(), kel: $("input[name='kd_kelurahan']").val(), kodepos: $("#ban_kodepos").val(), ktp: $("#ban_ktp").val()},
                beforeSend: function(html) { // this happens before actual call
                    $("#message").append("<div class='loading'><img src='/images/ajax-loader.gif' /> Memeriksa... </div>");
					$("#cek-result").html('');
                    $("#cek-result").show("slow");
               },
               success: function(data){ // this happens after we get results
			   		$('.loading').remove();
					
					$("#cek-result").fadeIn("slow");
                    $("#cek-result").append(data).fadeIn("slow");
              }
            });    
		
		
		
	});
});
  </script>
  <tr>
    <td colspan="2"><div id="cek-result">&nbsp;</div></td>
  </tr>
  <tr>
    <td>No. Telp / HP</td>
    <td>
      <input type="text" name="ban_tlp" id="ban_tlp" value="<?=$ban_tlp?>" style="width:200px;" /> / <input type="text" name="ban_hp" id="ban_hp" value="<?=$ban_hp?>" style="width:200px;"  />
    </td>
  </tr>
  <tr>
    <td>Bank</td>
    <td>
      <?=$f->selectList("bank_kode","tbl_bank","bank_kode","bank_nama",$bank_kode," style=\"width:250px\" class=\"easyui-combobox\"'","order by bank_nama asc")?>
    </td>
  </tr>
  <tr>
    <td>No. Rekening</td>
    <td>
      <input type="text" name="ban_norek" id="ban_norek" value="<?=$ban_norek?>" style="width:200px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2"><strong>Organisasi Perangkat Daerah (OPD) Evaluator</strong></td>
  </tr>
  <tr>
    <td>OPD Evaluator</td>
    <td>
      <?=$f->selectList("opd_kode","tbl_opd","opd_kode","opd_nama",$opd_kode,"","")?>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Proposal</strong></td>
  </tr>
  <tr>
    <td>Judul Kegiatan</td>
    <td>
      <input type="text" name="ban_judul_kegiatan" id="ban_judul_kegiatan" value="<?=$ban_judul_kegiatan?>" style="width:500px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
  	<td>Rencana Penggunaan</td>
  	<td>
      <textarea name="ban_ren_guna" id="ban_ren_guna" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$ban_ren_guna?></textarea>
    </td>
  </tr>
  <tr>
  	<td>Lokasi Kegiatan</td>
  	<td>
      <textarea name="ban_lokasi_kegiatan" id="ban_lokasi_kegiatan" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$ban_lokasi_kegiatan?></textarea>
    </td>
  </tr>
  <tr>
    <td>Besaran Permohonan Bantuan Sosial (Rp)</td>
    <td>
      <input type="text" name="ban_besaran_bansos" id="ban_besaran_bansos" value="<?=$ban_besaran_bansos?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tujuan Penggunaan Bantuan Sosial</td>
    <td>
      <?=$f->selectList("id_tb","tbl_tujuan_bansos","id_tb","tb",$id_tb,"","")?>
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
}
else if ($act == "do_add" || $act == "do_update") {
	foreach ($_POST as $key=>$val) {	
    	$$key = $val;
    }
	
	if ($act == "do_update") $f->checkaccess("edit");
	else if ($act == "do_add") $f->checkaccess("add");
     
    if ($act=='do_update') {	    
        $sql = "UPDATE tbl_bansos SET ban_tanggal='".$f->preparedate($ban_tanggal)."', ban_jenis='$ban_jenis', jh_kode='$jh_kode', ban_judul_kegiatan='$ban_judul_kegiatan', ban_lokasi_kegiatan='".trim($ban_lokasi_kegiatan)."', id_tb='$id_tb', ban_nama='$ban_nama', ban_ktp='$ban_ktp', pimpinan='$pimpinan', ban_jalan='$ban_jalan', ban_rt='$ban_rt', ban_rw='$ban_rw', kd_propinsi='$kd_propinsi', kd_dati2='$kd_dati2', kd_kecamatan='$kd_kecamatan', kd_kelurahan='$kd_kelurahan', ban_kodepos='$ban_kodepos', bank_kode='$bank_kode', ban_norek='$ban_norek', ban_ren_guna='".trim($ban_ren_guna)."', ban_tlp='$ban_tlp', ban_hp='$ban_hp', ban_besaran_bansos='$ban_besaran_bansos', opd_kode='$opd_kode', mtime=NOW(), user='".$login_full_name."' WHERE ban_kode=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
      $sql = "INSERT INTO tbl_bansos (ban_kode,ban_tanggal,ban_jenis,jh_kode,ban_judul_kegiatan,ban_lokasi_kegiatan,id_tb,ban_nama,ban_ktp,pimpinan,ban_jalan,ban_rt,ban_rw,kd_propinsi,kd_dati2,kd_kecamatan,kd_kelurahan,ban_kodepos,ban_tlp,ban_hp,bank_kode,ban_norek,ban_ren_guna,ban_besaran_bansos,opd_kode,ctime,mtime,user) VALUES
('','".$f->preparedate($ban_tanggal)."','$ban_jenis','$jh_kode','$ban_judul_kegiatan','".trim($ban_lokasi_kegiatan)."','$id_tb','$ban_nama','$ban_ktp','$pimpinan','$ban_jalan','$ban_rt','$ban_rw','$kd_propinsi','$kd_dati2','$kd_kecamatan','$kd_kelurahan','$ban_kodepos','$ban_tlp','$ban_hp','$bank_kode','$ban_norek','".trim($ban_ren_guna)."','$ban_besaran_bansos','$opd_kode', NOW(), NOW(), '$login_full_name')";

        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
else if ($act == "delete") {
	$f->checkaccess("delete");
	$sql = "DELETE FROM tbl_bansos WHERE ban_kode=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	header("location: $PHP_SELF");
}
else {

    if(!$start) $start='1';
    if(!$order)	$order='b.ban_tanggal';
    if(!$sort) 	$sort='asc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    //cek akses
	if($login_opd)
		$f->standard_buttons('refresh');
	else
    	$f->standard_buttons();
		
    $f->search_box($query);

$cond1 = " left join tbl_jenis_hibah jh on b.jh_kode=jh.jh_kode left join tbl_opd o on b.opd_kode=o.opd_kode ";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (b.ban_kode = '$query' or b.ban_nama like '%$query%' or b.ban_jalan like '%$query%' or b.ban_tanggal = '".$f->preparedate($query)."' or jh.jh_jenis = '$query' or o.opd_nama like '%$query%')";
}

$rel = !empty($cond)?"and":"where";
if($login_access=='OPD'){
	$cond  .=" $rel b.opd_kode = $login_opd ";
}

$total = $f->count_total("tbl_bansos b","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));

$sql="select b.*, jh.jh_jenis, o.opd_nama from tbl_bansos b $cond1 $cond order by $order $sort";
$result=$db->SelectLimit("$sql","$num","$start");
#echo $sql;
if(!$result) print $db->ErrorMsg();
$_sort=($sort=='desc')?"asc":"desc"; 

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Tanggal&nbsp;<a href='$PHP_SELF?order=ban_tanggal&sort=$_sort'><img src='/i/bg.gif' /></a></th>
		<th class=white  valign=top>Nama Pemohon&nbsp;<a href='$PHP_SELF?order=ban_nama&sort=$_sort'><img src='/i/bg.gif' /></a></th>
		<th class=white  valign=top>Alamat</th>
		<th class=white  valign=top>Jenis Hibah</th>
		<th class=white  valign=top>Besaran Hibah (Rp)</th>
		<th class=white  valign=top>OPD Evaluator&nbsp;<a href='$PHP_SELF?order=opd_nama&sort=$_sort'><img src='/i/bg.gif' /></a></th>
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
		
        echo"
		<tr bgcolor=$bgcolor>
			<td valign=top>".($i+$start)."</td>
			<td valign=top>".$f->convertdatetime(array("datetime"=>$ban_tanggal))."</td>
			<td valign=top>$ban_nama</td>
			<td valign=top>$ban_jalan RT.".$ban_rt."/RW.".$ban_rw."</td>
			<td valign=top>$jh_jenis</td>
			<td valign=top>".number_format($ban_besaran_bansos,2,',','.')."</td>
			<td valign=top>$opd_nama</td>
			<td valign=top>$user</td>
			";
            
        echo "
			<td  valign=top ALIGN=left>";
			if($login_opd)
				echo"&nbsp;";
			else
				echo"
				<a href=$PHP_SELF?act=edit&id=$ban_kode><img src=../images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$ban_kode onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a>";

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