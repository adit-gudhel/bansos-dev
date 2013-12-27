<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Referensi - Setting');

if ($act == "add" || $act == "edit") {
	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_setting WHERE id=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
    }
?>
<table class="index">
<form method="POST" action="<?=$PHP_SELF?>">
<input type="hidden" name="act" value="<?=(!empty($id))?"do_update":"do_add"?>">
<input type="hidden" name="id" value="<?=$id?>">
  
  <tr>
    <td>Kop Surat SPKT</td>
    <td><label>
      <textarea name="kop_surat" id="kop_surat" cols="45" rows="5" style="width:500px;" ><?=$kop_surat?></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Kop Surat Intelkam</td>
    <td><label>
      <textarea name="kop_surat_intelkam" id="kop_surat_intelkam" cols="45" rows="5" style="width:500px;" ><?=$kop_surat_intelkam?></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Kop Surat Binmas</td>
    <td><label>
      <textarea name="kop_surat_binmas" id="kop_surat_binmas" cols="45" rows="5" style="width:500px;" ><?=$kop_surat_binmas?></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Kop Surat Reskrim</td>
    <td><label>
      <textarea name="kop_surat_reskrim" id="kop_surat_reskrim" cols="45" rows="5" style="width:500px;" ><?=$kop_surat_reskrim?></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td><label>
      <input type="text" name="address" id="address" value="<?=$address ?>" style="width:300px;"/>
    </label></td>
  </tr>
  <tr>
    <td>Kota</td>
    <td><label>
      <input type="text" name="kota" id="kota" value="<?=$kota ?>" style="width:300px;"/>
    </label></td>
  </tr>
  <tr>
    <td>Zona Waktu</td>
    <td><label>
      <input type="text" name="timezone" id="timezone" value="<?=$timezone?>" style="width:50px;"/>
    </label></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type=button onClick=history.back(-1) value='&laquo; Back'> <input type=submit value="<?=($act=='add')?"Add":"Update";?>" class=buttonhi></td>
  </tr>

</form>
</table>
<?
}
else if ($act == "do_add" || $act == "do_update") {
foreach ($_POST as $key=>$val) {
        $$key = $val;
    }
    
    if (!empty($id)) {
    
        $kode = $login_satker."-SET-".$f->createRandomKey(10);
        $sql = "UPDATE tbl_setting SET kode='$kode', address='$address', kop_surat='$kop_surat', kop_surat_intelkam='$kop_surat_intelkam', kop_surat_binmas='$kop_surat_binmas', kop_surat_reskrim='$kop_surat_reskrim', kota='$kota', timezone='$timezone', mtime=NOW(), ctime=NOW() WHERE id=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    
    }
    else {
        $kode = $login_satker."-SET-".$f->createRandomKey(10);
        $sql = "INSERT INTO tbl_setting (kode, address, kop_surat, kop_surat_intelkam, kop_surat_binmas, kop_surat_reskrim, kota, timezone, ctime, mtime)
                VALUES ('$kode','$nama', '$kop_surat', '$kop_surat_intelkam', '$kop_surat_binmas', '$kop_surat_reskrim', '$kota', '$timezone', NOW(),NOW())";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    header("location: $PHP_SELF");
}
else if ($act == "delete") {

	$sql = "DELETE FROM tbl_setting WHERE id=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }

    header("location: $PHP_SELF");
}
else {

    if(!$start) $start='0';
    if(!$order)	$order='kode';
    if(!$sort) 	$sort='asc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    
	if(!empty($query)){
	       $query	= urldecode($query);
	       $query	= strtolower(trim($query));
		$rel 	= !empty($cond)?"and":"where";
		$cond  .=" $rel (pekerjaan like '%$query%')";
	}

	$total = $f->count_total("tbl_setting","$cond");

	$f->standard_buttons(array("noadd"=>TRUE));	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select * from tbl_setting $cond order by $order $sort";
    $result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Kop Surat</th>
        <th class=white  valign=top>Alamat</th>
        <th class=white  valign=top>Kota</th>
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
			<td valign=top>$kop_surat</td>
            <td valign=top>$address</td>
            <td valign=top>$kota</td>";
            
        echo "
			    <td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$id><img src=/images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$id onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=/images/button_delete.gif border=0></a>
                ";

			echo"</td>
		</tr>
		";
		
		unset($_status,$tp);
	}
	echo"
	</table>
	";
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&status=$status&outlet_id=$outlet_id&outlet_query=$outlet_query&dealer_query=$dealer_query&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));










}
$t->basicfooter();
?>