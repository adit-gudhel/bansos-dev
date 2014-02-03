<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Hibah &raquo; Pencairan Hibah');


if ($act == "add" || $act == "edit") {

	if ($id) {

        $sql = "SELECT a.*, b.hib_nama, c.besaran_tapd FROM tbl_cair_hibah a LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode LEFT JOIN tbl_eval_tapd_detail c ON a.hib_kode=c.hib_kode WHERE a.id_cair=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
       
    }
    
    if ($id && $act == "add") unset($id, $tgl_cair, $spph_tgl, $nphd_tgl, $sp2d_tgl);
    
    if (!$tgl_cair) $tgl_cair = date('Y-m-d');
	if (!$spph_tgl) $spph_tgl = date('Y-m-d');
	if (!$nphd_tgl) $nphd_tgl = date('Y-m-d');
	if (!$sp2d_tgl) $sp2d_tgl = date('Y-m-d');
    

?>
<script type="text/javascript" src="/pencairan_hibah.js"></script>
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="<?=($act=='edit')?"do_update":"do_add"?>">
<input type="hidden" name="id" value="<?=$id_cair?>">
  <tr>
    <td>Tanggal Pencairan Hibah</td>
    <td>
      <input type="text" name="tgl_cair" id="tgl_cair" value="<?=$f->convertdatetime(array("datetime"=>$tgl_cair))?>" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Penerima Hibah</strong></td>
  </tr>
  <tr>
    <td>Nama Penerima</td>
    <td>
      <input type="text" name="hib_nama" id="hib_nama" value="<?=$hib_nama?>" style="width:250px;" class="easyui-validatebox" required="true" <?php if($act=='edit') echo 'disabled="disabled"';?> />
      <input type="hidden" name="hib_kode" id="hib_kode" value="<?=$hib_kode?>" />
    </td>
  </tr>
  <tr>
    <td>Jumlah (Rp)</td>
    <td>
      <input type="text" name="besaran_tapd" id="besaran_tapd" value="<?=$besaran_tapd?>" style="width:250px;" class="easyui-validatebox" disabled="disabled" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Surat Permohonan Pencairan Hibah (SPPH)</strong></td>
  </tr>
  <tr>
    <td>No. SPPH</td>
    <td>
      <input type="text" name="spph_no" id="spph_no" value="<?=$spph_no?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tanggal SPPH</td>
    <td>
      <input type="text" name="spph_tgl" id="spph_tgl" value="<?=$f->convertdatetime(array("datetime"=>$spph_tgl))?>" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Naskah Perjanjian Hibah Daerah (NPHD)</strong></td>
  </tr>
  <tr>
    <td>No. NPHD Pemberi</td>
    <td>
      <input type="text" name="nphd_no_pemberi" id="nphd_no_pemberi" value="<?=$nphd_no_pemberi?>" style="width:500px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>No. NPHD Penerima</td>
    <td>
      <input type="text" name="nphd_no_penerima" id="nphd_no_penerima" value="<?=$nphd_no_penerima?>" style="width:500px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tanggal NPHD</td>
    <td>
      <input type="text" name="nphd_tgl" id="nphd_tgl" value="<?=$f->convertdatetime(array("datetime"=>$nphd_tgl))?>" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tentang</td>
    <td>
      <textarea name="nphd_tentang" id="nphd_tentang" cols="45" rows="5" class="easyui-validatebox" required="true" style="width:500px;" ><?=$nphd_tentang?></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Surat Perintah Pencairan Dana (SP2D)</strong></td>
  </tr>
  <tr>
    <td>No. SP2D</td>
    <td>
      <input type="text" name="sp2d_no" id="sp2d_no" value="<?=$sp2d_no?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tanggal SP2D</td>
    <td>
      <input type="text" name="sp2d_tgl" id="sp2d_tgl" value="<?=$f->convertdatetime(array("datetime"=>$sp2d_tgl))?>" class="easyui-validatebox" required="true" />
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
     
    if ($act=='do_update') {	    
        $sql = "UPDATE tbl_cair_hibah SET tgl_cair='".$f->preparedate($tgl_cair)."',spph_no='$spph_no',spph_tgl='".$f->preparedate($spph_tgl)."',nphd_no_pemberi='$nphd_no_pemberi',nphd_no_penerima='$nphd_no_penerima',
		nphd_tgl='".$f->preparedate($nphd_tgl)."',nphd_tentang='".trim($nphd_tentang)."',
		sp2d_no='$sp2d_no',sp2d_tgl='".$f->preparedate($sp2d_tgl)."',hib_kode='$hib_kode',mtime=NOW(),user='$login_full_name' WHERE id_cair=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
      $sql = "INSERT INTO tbl_cair_hibah (id_cair, tgl_cair, spph_no, spph_tgl, nphd_no_pemberi, nphd_no_penerima, nphd_tgl, nphd_tentang, sp2d_no, sp2d_tgl, hib_kode, ctime, mtime, user) VALUES
('','".$f->preparedate($tgl_cair)."','$spph_no','".$f->preparedate($spph_tgl)."','$nphd_no_pemberi','$nphd_no_penerima','".$f->preparedate($nphd_tgl)."','".trim($nphd_tentang)."','$sp2d_no','".$f->preparedate($sp2d_tgl)."','$hib_kode', NOW(), NOW(), '$login_full_name')";

      $result=$db->Execute($sql);
      if(!$result){ print $db->ErrorMsg(); die(); }
	  
	  $sql = "UPDATE tbl_hibah SET hib_cair=1, hib_status='Cair' WHERE hib_kode = '$hib_kode'";

      $result=$db->Execute($sql);
      if(!$result){ print $db->ErrorMsg(); die(); }
	  
    }
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
else if ($act == "delete") {
	$sql = "SELECT hib_kode FROM tbl_cair_hibah WHERE id_cair=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$row = $result->FetchRow();
	$hib_kode = $row['hib_kode'];
	
	$sql = "UPDATE tbl_hibah SET hib_cair = 0, hib_status = 'Proses' WHERE hib_kode='$hib_kode'";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$sql = "DELETE FROM tbl_cair_hibah WHERE id_cair=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	/*
    $sql = "DELETE FROM tbl_cair_hibah_opd WHERE id_cair=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	*/
	header("location: $PHP_SELF");
}
else {

    if(!$start) $start='1';
    if(!$order)	$order='h.hib_nama';
    if(!$sort) 	$sort='asc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    $f->standard_buttons();
    $f->search_box($query);

$cond1 = " left join tbl_hibah h on c.hib_kode=h.hib_kode left join tbl_eval_tapd_detail e on c.hib_kode=e.hib_kode left join tbl_eval_tapd f on e.kode=f.kode ";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (c.id_cair = '$query' or h.hib_nama like '%$query%' or c.tgl_cair = '".$f->preparedate($query)."')";
}

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel f.tipe='HIBAH'";

$total = $f->count_total("tbl_cair_hibah c","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));

$sql="select c.*, h.hib_nama, e.besaran_tapd FROM tbl_cair_hibah c $cond1 $cond order by $order $sort";
$result=$db->SelectLimit("$sql","$num","$start");
# echo $sql;
if(!$result) print $db->ErrorMsg();
$_sort=($sort=='desc')?"asc":"desc"; 

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Tanggal Cair</th>
		<th class=white  valign=top>Nama Pemohon</th>
		<th class=white  valign=top>Jumlah (Rp)</th>
		<th class=white  valign=top>No. SPPH</th>
		<th class=white  valign=top>No. NPHD Pemberi</th>
		<th class=white  valign=top>No. NPHD Penerima</th>
		<th class=white  valign=top>No. SP2D</th>
		<th class=white  valign=top>Function</th>
	</tr>
	";
	while($val=$result->FetchRow()){
		$i++;
		$bgcolor= ($i%2)?"#FFDDDD":"FFFFFF";
		#echo"<pre>";
		#print_r($val);
		foreach($val as $key1 => $val1){
			$key1=strtolower($key1);
			$$key1=$val1;
		}
		
        echo"
		<tr bgcolor=$bgcolor>
			<td valign=top>".($i+$start)."</td>
			<td valign=top>".$f->convertdatetime(array("datetime"=>$tgl_cair))."</td>
			<td valign=top>$hib_nama</td>
			<td valign=top>".number_format($besaran_tapd,2,',','.')."</td>
			<td valign=top>$spph_no</td>
			<td valign=top>$nphd_no_pemberi</td>
			<td valign=top>$nphd_no_penerima</td>
			<td valign=top>$sp2d_no</td>
			";
            
        echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$id_cair><img src=../images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$id_cair onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a>";

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