<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");

$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Hibah &raquo; Data Pemohon Hibah');


if ($act == "add" || $act == "edit") {

	if ($id) {

        $sql = "SELECT * FROM tbl_hibah WHERE hib_kode=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
       
    }
    
    if ($id && $act == "add") unset($id, $hib_tanggal);
    
    if (!$hib_tanggal) $hib_tanggal = date('Y-m-d');
    

?>
<script type="text/javascript" src="/hibah.js"></script>
<script>
//$(document).ready(function(){

/*
$(function(){
	$("#hib_nama").change(function(){
		var searchNama = $("#hib_nama").val();
		var data = 'nama='+ searchNama;
		
		if(searchNama.length > 2){
			$.ajax({
                type: "POST",
                url: "/check.php",
                data: data,
                beforeSend: function(html) { // this happens before actual call
                    //$("#message").html(''); 
					$("#results").html('');
                    $("#results").show();
                    $(".word").html(searchNama);
               },
               success: function(html){ // this happens after we get results
                    $("#results").show();
                    $("#results").append(html);
              }
            });    
		}
		
		return false;
	});
});
/*
var minKata = 2;
$(document).ready(function(){
    $("#hib_nama").change(function(){
    	$("#message").html(" <img src='/images/ajax-loader.gif' /> Memeriksa...");
     	var nama=$("#hib_nama").val();
		$.ajax({
           	type:"post",
            url:"/check.php",
            data:"nama="+nama,
            success:function(data){
            	if(data==0){
                	$("#message").html(" <img src='/i/valid.png' /> Tidak ada kemiripan nama");
                }else{
                    $("#message").html(" <img src='/i/invalid.png' /> Ada kemiripan nama");
               	}
			}
		});
	});
});
*/
</script>
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="<?=($act=='edit')?"do_update":"do_add"?>">
<input type="hidden" name="id" value="<?=$hib_kode?>">
  <tr>
    <td>Jenis Hibah</td>
    <td>
      <?=$f->selectList("jh_kode","tbl_jenis_hibah","jh_kode","jh_jenis",$jh_kode,"class='easyui-validatebox' required='true'","",1,"","-- Pilih Salah Satu --")?>    </td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>
      <input type="text" name="hib_tanggal" id="hib_tanggal" value="<?=$f->convertdatetime(array("datetime"=>$hib_tanggal))?>" class="easyui-validatebox" required="true" />    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Pemohon Hibah</strong></td>
  </tr>
  <tr>
    <td>Jenis Pemohon</td>
    <td>
      <?=$f->selectList("id_jp","tbl_jenis_pemohon","id_jp","jenis_pemohon",$id_jp,"class='easyui-validatebox' required='true'","",1,"","-- Pilih Salah Satu --")?>    </td>
  </tr>
  <tr>
    <td>Nama Pemohon</td>
    <td>
      <input type="text" name="hib_nama" id="hib_nama" value="<?=$hib_nama?>" style="width:250px;" class="easyui-validatebox" required="true" />    </td>
  </tr>
  <tr>
    <td>Nama Pimpinan</td>
    <td>
      <input type="text" name="pimpinan" id="pimpinan" value="<?=$pimpinan?>" style="width:250px;" class="easyui-validatebox" required="true" />    </td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>
      <textarea name="hib_jalan" id="hib_jalan" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$hib_jalan?></textarea>    </td>
  </tr>
  <tr>
    <td>RT / RW</td>
    <td>
      <input type="text" name="hib_rt" id="hib_rt" value="<?=$hib_rt?>" style="width:80px;" class="easyui-validatebox" required="true" />  / <input type="text" name="hib_rw" id="hib_rw" value="<?=$hib_rw?>" style="width:80px;" class="easyui-validatebox" required="true" />    </td>
  </tr>
  <tr>
    <td>Propinsi</td>
    <td>
      <?=$f->selectList("kd_propinsi","tbl_propinsi","kd_propinsi","nm_propinsi",$kd_propinsi," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text',onSelect: function(rec){ var url = 'get_wilayah.php?ajaxselect=propinsi&kd_propinsi='+rec.id; $('#kd_dati2').combobox('clear'); $('#kd_dati2').combobox('reload', url); $('#kd_kecamatan').combobox('clear'); $('#kd_kecamatan').combobox('reload', 'get_wilayah.php'); $('#kd_kelurahan').combobox('clear'); $('#kd_kelurahan').combobox('reload', 'get_wilayah.php'); }\" ","",1,"","-- Pilih Salah Satu --")?>    </td>
  </tr>
  <tr>
    <td>Kota / Kabupaten</td>
    <td>
     <?=$f->selectList("kd_dati2","tbl_dati2","kd_dati2","nm_dati2",$kd_dati2," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text',onSelect: function(rec2){ var url = 'get_wilayah.php?ajaxselect=dati2&kd_dati2='+rec2.id; $('#kd_kecamatan').combobox('clear'); $('#kd_kecamatan').combobox('reload', url); $('#kd_kelurahan').combobox('clear'); $('#kd_kelurahan').combobox('reload', 'get_wilayah.php'); }\" ","where substr(kd_dati2,1,2)='".$kd_propinsi."'")?>    </td>
  </tr>
   <tr>
    <td>Kecamatan</td>
    <td>
      <?=$f->selectList("kd_kecamatan","tbl_kecamatan","kd_kecamatan","nm_kecamatan",$kd_kecamatan," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text',onSelect: function(rec3){ var url = 'get_wilayah.php?ajaxselect=kecamatan&kd_kecamatan='+rec3.id; $('#kd_kelurahan').combobox('clear'); $('#kd_kelurahan').combobox('reload', url); }\" ","where substr(kd_kecamatan,1,4)='".$kd_dati2."'")?>    </td>
  </tr>
   <tr>
    <td>Kelurahan</td>
    <td>
      <?=$f->selectList("kd_kelurahan","tbl_kelurahan","kd_kelurahan","nm_kelurahan",$kd_kelurahan," style=\"width:250px\" class=\"easyui-combobox\" data-options=\"valueField:'id',textField:'text'\" ","where substr(kd_kelurahan,1,7)='".$kd_kecamatan."'")?>    </td>
  </tr>
  <tr>
    <td>Kodepos</td>
    <td>
      <input type="text" name="hib_kodepos" id="hib_kodepos" value="<?=$hib_kodepos?>" style="width:200px;" />
      <input type="button" name="cek" id="cek" value="Cek" />
      <div id="message" style="display:inline-block;"></div>
    </td>
  </tr>
  <script>
  $(function(){
	$("#cek").click(function(){
		//$("#message").html(" <img src='/images/ajax-loader.gif' /> Memeriksa...");
		var nama = $("#hib_nama").val();
		var pimpinan = $("#pimpinan").val();
		var alamat = $("#hib_jalan").val();
		var rt = $("#hib_rt").val();
		var rw = $("#hib_rw").val();
		//var prop = $("input[name='kd_propinsi']").val();
		//var dati2 = $("input[name='kd_dati2']").val();
		//var kec = $("input[name='kd_kecamatan']").val();
		var kel = $("input[name='kd_kelurahan']").val();
		var kodepos = $("#hib_kodepos").val();
		//var data = "nama="+nama
		
		//console.log(nama +" "+ pimpinan +" "+ alamat +" RT."+ rt +" / RW."+ rw +", "+ kel +" "+ kodepos);
		
		$.ajax({
                type: "POST",
                url: "/check.php",
                data: {tipe: "hibah", nama: $("#hib_nama").val(), pimpinan: $("#pimpinan").val(), alamat: $("#hib_jalan").val(), rt: $("#hib_rt").val(), rw: $("#hib_rw").val(), kel: $("input[name='kd_kelurahan']").val(), kodepos: $("#hib_kodepos").val()},
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
      <input type="text" name="hib_tlp" id="hib_tlp" value="<?=$hib_tlp?>" style="width:200px;" /> / <input type="text" name="hib_hp" id="hib_hp" value="<?=$hib_hp?>" style="width:200px;"  />    </td>
  </tr>
  <tr>
    <td>Bank</td>
    <td>
      <?=$f->selectList("bank_kode","tbl_bank","bank_kode","bank_nama",$bank_kode," style=\"width:250px\" class=\"easyui-combobox\"'","order by bank_nama asc")?>    </td>
  </tr>
  <tr>
    <td>No. Rekening</td>
    <td>
      <input type="text" name="hib_norek" id="hib_norek" value="<?=$hib_norek?>" style="width:200px;" class="easyui-validatebox" required="true" />    </td>
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
      <?=$f->selectList("opd_kode","tbl_opd","opd_kode","opd_nama",$opd_kode,"","")?>    </td>
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
      <input type="text" name="hib_judul_kegiatan" id="hib_judul_kegiatan" value="<?=$hib_judul_kegiatan?>" style="width:500px;" class="easyui-validatebox" required="true" />    </td>
  </tr>
   <tr>
  	<td>Rencana Penggunaan</td>
  	<td>
      <textarea name="hib_ren_guna" id="hib_ren_guna" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$hib_ren_guna?></textarea>    </td>
  </tr>
  <tr>
  	<td>Lokasi Kegiatan</td>
  	<td>
      <textarea name="hib_lokasi_kegiatan" id="hib_lokasi_kegiatan" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$hib_lokasi_kegiatan?></textarea>    </td>
  </tr>
  <tr>
    <td>Besaran Permohonan Hibah (Rp)</td>
    <td>
      <input type="text" name="hib_besaran_hibah" id="hib_besaran_hibah" value="<?=$hib_besaran_hibah?>" style="width:250px;" class="easyui-validatebox" required="true" />    </td>
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
        $sql = "UPDATE tbl_hibah SET hib_tanggal='".$f->preparedate($hib_tanggal)."', jh_kode='$jh_kode', hib_judul_kegiatan='$hib_judul_kegiatan', hib_lokasi_kegiatan='".trim($hib_lokasi_kegiatan)."',id_jp='$id_jp', hib_nama='$hib_nama', pimpinan='$pimpinan', hib_jalan='$hib_jalan', hib_rt='$hib_rt', hib_rw='$hib_rw', kd_propinsi='$kd_propinsi', kd_dati2='$kd_dati2', kd_kecamatan='$kd_kecamatan', kd_kelurahan='$kd_kelurahan', hib_kodepos='$hib_kodepos', bank_kode='$bank_kode', hib_norek='$hib_norek', hib_ren_guna='".trim($hib_ren_guna)."', hib_tlp='$hib_tlp', hib_hp='$hib_hp', hib_besaran_hibah='$hib_besaran_hibah', opd_kode='$opd_kode', mtime=NOW(), user='".$login_full_name."' WHERE hib_kode=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
      $sql = "INSERT INTO tbl_hibah (hib_kode, hib_tanggal, jh_kode, hib_judul_kegiatan, hib_lokasi_kegiatan, id_jp, hib_nama, pimpinan, hib_jalan, hib_rt, hib_rw, kd_propinsi, kd_dati2, kd_kecamatan, kd_kelurahan, hib_kodepos, hib_tlp, hib_hp, bank_kode, hib_norek, hib_ren_guna, hib_besaran_hibah, opd_kode, ctime, mtime, user) VALUES
('','".$f->preparedate($hib_tanggal)."','$jh_kode','$hib_judul_kegiatan','".trim($hib_lokasi_kegiatan)."','$id_jp','$hib_nama','$pimpinan','$hib_jalan','$hib_rt','$hib_rw','$kd_propinsi','$kd_dati2','$kd_kecamatan','$kd_kelurahan','$hib_kodepos','$hib_tlp','$hib_hp','$bank_kode','$hib_norek','".trim($hib_lokasi_kegiatan)."','$hib_besaran_hibah','$opd_kode', NOW(), NOW(), '$login_full_name')";

        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
else if ($act == "delete") {
	$f->checkaccess("delete");
	$sql = "DELETE FROM tbl_hibah WHERE hib_kode=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }

	header("location: $PHP_SELF");
}
else {

    if(!$start) $start='1';
    if(!$order)	$order='h.hib_tanggal';
    if(!$sort) 	$sort='desc';
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

$cond1 = " left join tbl_jenis_hibah jh on h.jh_kode=jh.jh_kode left join tbl_opd o on h.opd_kode=o.opd_kode ";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (h.hib_kode = '$query' or h.hib_nama like '%$query%' or h.hib_jalan like '%$query%' or h.hib_tanggal = '".$f->preparedate($query)."' or jh.jh_jenis = '$query' or o.opd_nama like '%$query%')";
}

$rel = !empty($cond)?"and":"where";
if($login_access=='OPD'){
	$cond  .=" $rel h.opd_kode = $login_opd ";
}

$total = $f->count_total("tbl_hibah h","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));

$sql="select h.*, jh.jh_jenis, o.opd_nama from tbl_hibah h $cond1 $cond order by $order $sort";
$result=$db->SelectLimit("$sql","$num","$start");
#echo $sql;
if(!$result) print $db->ErrorMsg();
$_sort=($sort=='desc')?"asc":"desc"; 

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Tanggal&nbsp;<a href='$PHP_SELF?order=hib_tanggal&sort=$_sort'><img src='/i/bg.gif' /></a></th>
		<th class=white  valign=top>Nama Pemohon&nbsp;<a href='$PHP_SELF?order=hib_nama&sort=$_sort'><img src='/i/bg.gif' /></a></th>
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
			<td valign=top>".$f->convertdatetime(array("datetime"=>$hib_tanggal))."</td>
			<td valign=top>$hib_nama</td>
			<td valign=top>$hib_jalan RT.".$hib_rt."/RW.".$hib_rw."</td>
			<td valign=top>$jh_jenis</td>
			<td valign=top>".number_format($hib_besaran_hibah,2,',','.')."</td>
			<td valign=top>$opd_nama</td>
			<td valign=top>$user</td>
			";
            
        echo "
			<td  valign=top ALIGN=left>";
			
			if($login_opd)
				echo"&nbsp;";
			else
				echo"
				<a href=$PHP_SELF?act=edit&id=$hib_kode><img src=../images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$hib_kode onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a>";

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