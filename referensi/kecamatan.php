<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Referensi - Wilayah Administrasi - Propinsi - Dati2 - Kecamatan');

if ($act == "add" || $act == "edit") {
	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_kecamatan WHERE kd_kecamatan=$id";
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
<input type="hidden" name="kd_dati2" value="<?=$kd_dati2?>">
  <tr>
    <td>Kode</td>
    <td><label>
      <input type="text" name="kd_kecamatan" id="kd_kecamatan" value="<?=$kd_kecamatan ?>" maxlength="7" width="15"/>
    </label></td>
  </tr>
  <tr>
    <td>Kecamatan</td>
    <td><label>
      <input type="text" name="nm_kecamatan" id="nm_kecamatan" value="<?=$nm_kecamatan ?>"/>
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
    
        $sql = "UPDATE tbl_kecamatan SET nm_kecamatan='$nm_kecamatan', kd_kecamatan='$kd_kecamatan' WHERE kd_kecamatan=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    
    }
    else {
        
        $sql = "INSERT INTO tbl_kecamatan (nm_kecamatan, kd_kecamatan)
                VALUES ('$nm_kecamatan', '$kd_kecamatan')";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    header("location: $PHP_SELF?kd_dati2=$kd_dati2");
}
else if ($act == "delete") {
	$sql = "DELETE FROM tbl_kecamatan WHERE kd_kecamatan=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
    header("location: $PHP_SELF?kd_dati2=$kd_dati2");
}
else {

    if(!$start) $start='0';
    if(!$order)	$order='kd_kecamatan';
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
		$cond  .=" $rel (nm_kecamatan like '%$query%')";
	}
    
    $rel 	= !empty($cond)?"and":"where";
    $cond  .=" $rel kd_kecamatan like '$kd_dati2%' ";


	$total = $f->count_total("tbl_kecamatan","$cond");

	$f->standard_buttons(array("cond"=>"&kd_dati2=$kd_dati2"));	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?kd_dati2=$kd_dati2&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select * from tbl_kecamatan $cond order by $order $sort";
    $result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>KD Kecamatan</th>
        <th class=white  valign=top>Kecamatan</th>
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
			<td valign=top>$kd_kecamatan</td>
            <td valign=top><a href=kelurahan.php?kd_kecamatan=$kd_kecamatan>$nm_kecamatan</a></td>
            ";
            
        echo "
			    <td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&kd_dati2=$kd_dati2&id=$kd_kecamatan><img src=/images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&kd_dati2=$kd_dati2&id=$kd_kecamatan onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=/images/button_delete.gif border=0></a>
                ";

			echo"</td>
		</tr>
		";
		
		unset($_status,$tp);
	}
	echo"
	</table>
	";
	$f->paging(array("link"=>$PHP_SELF."?kd_dati2=$kd_dati2&order=$order&sort=$sort&status=$status&outlet_id=$outlet_id&outlet_query=$outlet_query&dealer_query=$dealer_query&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));










}
$t->basicfooter();
?>