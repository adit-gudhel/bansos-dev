<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Bantuan Sosial &raquo; Pencairan Bantuan Sosial');


if ($act == "add" || $act == "edit") {

	if ($id) {

        $sql = "SELECT a.*, b.ban_nama, c.besaran_tapd FROM tbl_cair_bansos a LEFT JOIN tbl_bansos b ON a.ban_kode=b.ban_kode LEFT JOIN tbl_eval_tapd_detail c ON a.ban_kode=c.hib_kode left join tbl_eval_tapd d on c.kode=d.kode WHERE d.tipe='BANSOS' AND a.id_cair=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
       
    }
    
    if ($id && $act == "add") unset($id, $tgl_cair, $sppbs_tgl, $sp2d_tgl);
    
    if (!$tgl_cair) $tgl_cair = date('Y-m-d');
	if (!$sppbs_tgl) $sppbs_tgl = date('Y-m-d');
	if (!$sp2d_tgl) $sp2d_tgl = date('Y-m-d');
    

?>
<script type="text/javascript" src="/pencairan_bansos.js"></script>
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="<?=($act=='edit')?"do_update":"do_add"?>">
<input type="hidden" name="id" value="<?=$id_cair?>">
  <tr>
    <td>Tanggal Pencairan Bantuan Sosial</td>
    <td>
      <input type="text" name="tgl_cair" id="tgl_cair" value="<?=$f->convertdatetime(array("datetime"=>$tgl_cair))?>" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Penerima Bantuan Sosial</strong></td>
  </tr>
  <tr>
    <td>Nama Penerima</td>
    <td>
      <input type="text" name="ban_nama" id="ban_nama" value="<?=$ban_nama?>" style="width:250px;" class="easyui-validatebox" required="true" <?php if($act=='edit') echo 'disabled="disabled"';?> />
      <input type="hidden" name="ban_kode" id="ban_kode" value="<?=$ban_kode?>" />
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
    <td colspan="2"><strong>Surat Permohonan Pencairan Bantuan Sosial (SPPBS)</strong></td>
  </tr>
  <tr>
    <td>No. SPPH</td>
    <td>
      <input type="text" name="sppbs_no" id="sppbs_no" value="<?=$sppbs_no?>" style="width:250px;" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Tanggal SPPH</td>
    <td>
      <input type="text" name="sppbs_tgl" id="sppbs_tgl" value="<?=$f->convertdatetime(array("datetime"=>$sppbs_tgl))?>" class="easyui-validatebox" required="true" />
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
        $sql = "UPDATE tbl_cair_bansos SET tgl_cair='".$f->preparedate($tgl_cair)."',sppbs_no='$sppbs_no',sppbs_tgl='".$f->preparedate($sppbs_tgl)."',sp2d_no='$sp2d_no',sp2d_tgl='".$f->preparedate($sp2d_tgl)."',ban_kode='$ban_kode',mtime=NOW(),user='$login_full_name' WHERE id_cair=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    else {
      $sql = "INSERT INTO tbl_cair_bansos (id_cair, tgl_cair, sppbs_no, sppbs_tgl, sp2d_no, sp2d_tgl, ban_kode, ctime, mtime, user) VALUES
('','".$f->preparedate($tgl_cair)."','$sppbs_no','".$f->preparedate($sppbs_tgl)."','$sp2d_no','".$f->preparedate($sp2d_tgl)."','$ban_kode', NOW(), NOW(), '$login_full_name')";

      $result=$db->Execute($sql);
      if(!$result){ print $db->ErrorMsg(); die(); }
	  
	  $sql = "UPDATE tbl_bansos SET ban_cair=1, ban_status='Cair' WHERE ban_kode = '$ban_kode'";

      $result=$db->Execute($sql);
      if(!$result){ print $db->ErrorMsg(); die(); }
	  
    }
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
else if ($act == "delete") {
	$sql = "SELECT ban_kode FROM tbl_cair_bansos WHERE id_cair=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$row = $result->FetchRow();
	$ban_kode = $row['ban_kode'];
	
	$sql = "UPDATE tbl_bansos SET ban_cair = 0, ban_status = 'Proses' WHERE ban_kode='$ban_kode'";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	$sql = "DELETE FROM tbl_cair_bansos WHERE id_cair=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	/*
    $sql = "DELETE FROM tbl_cair_bansos_opd WHERE id_cair=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	*/
	header("location: $PHP_SELF");
}
else {

    if(!$start) $start='1';
    if(!$order)	$order='h.ban_nama';
    if(!$sort) 	$sort='asc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    $f->standard_buttons();
    $f->search_box($query);

$cond1 = " left join tbl_bansos h on c.ban_kode=h.ban_kode left join tbl_eval_tapd_detail e on c.ban_kode=e.hib_kode left join tbl_eval_tapd f on e.kode=f.kode ";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (c.id_cair = '$query' or h.ban_nama like '%$query%' or c.tgl_cair = '".$f->preparedate($query)."')";
}

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel f.tipe='BANSOS'";

$total = $f->count_total("tbl_cair_bansos c","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));

$sql="select c.*, h.ban_nama, e.besaran_tapd FROM tbl_cair_bansos c $cond1 $cond order by $order $sort";
$result=$db->SelectLimit("$sql","$num","$start");
#echo $sql;
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
		<th class=white  valign=top>No. SP2D</th>
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
			<td valign=top>".$f->convertdatetime(array("datetime"=>$tgl_cair))."</td>
			<td valign=top>$ban_nama</td>
			<td valign=top>".number_format($besaran_tapd,2,',','.')."</td>
			<td valign=top>$sppbs_no</td>
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