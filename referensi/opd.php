<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Referensi - Data OPD');

if ($act == "add" || $act == "edit") {
	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_opd WHERE opd_kode=$id";
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
    <td>Nama OPD</td>
    <td><label>
      <input type="text" name="opd_nama" id="opd_nama" value="<?=$opd_nama ?>" style="width:350px;" class="easyui-validatebox" required="true"/>
    </label></td>
  </tr>
  <tr>
    <td>Bidang OPD</td>
    <td><label>
      <input type="text" name="opd_bidang" id="opd_bidang" value="<?=$opd_bidang ?>" style="width:350px;" class="easyui-validatebox" required="true"/>
    </label></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Kepala OPD</td>
    <td><label>
      <input type="text" name="opd_kepala" id="opd_kepala" value="<?=$opd_kepala?>" style="width:350px;" class="easyui-validatebox" />
    </label></td>
  </tr>
  <tr>
    <td>NIP</td>
    <td><label>
      <input type="text" name="opd_nip" id="opd_nip" value="<?=$opd_nip?>" style="width:150px;" class="easyui-validatebox" />
    </label></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" onClick="history.back(-1)" value="&laquo; Back"> <input type=submit value="<?=($act=='add')?"Add":"Update";?>" class=buttonhi></td>
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
    
        $sql = "UPDATE tbl_opd SET opd_nama='$opd_nama', opd_bidang='$opd_bidang', opd_kepala='$opd_kepala', opd_nip='$opd_nip' WHERE opd_kode=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    
    }
    else {
        
        $sql = "INSERT INTO tbl_opd (opd_kode, opd_nama, opd_kepala, opd_nip)
                VALUES ('','$opd_nama','$opd_bidang','$opd_kepala','$opd_nip')";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    header("location: $PHP_SELF");
}
else if ($act == "delete") {
	$sql = "DELETE FROM tbl_opd WHERE opd_kode=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
    header("location: $PHP_SELF");
}
else {

    if(!$start) $start='0';
    if(!$order)	$order='opd_nama';
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
		$cond  .=" $rel (opd_nama like '%$query%')";
	}


	$total = $f->count_total("tbl_opd","$cond");

	$f->standard_buttons();	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select * from tbl_opd $cond order by $order $sort";
    $result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";
	//$_icon=($sort=='desc')?"/i/asc.gif":"/i/desc.gif";

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
        <th class=white  valign=top>Nama OPD&nbsp;&nbsp;<a href='$PHP_SELF?order=opd_nama&sort=$_sort'><img src='/i/bg.gif' /></a></th>
		<th class=white  valign=top>Bidang OPD&nbsp;&nbsp;<a href='$PHP_SELF?order=opd_bidang&sort=$_sort'><img src='/i/bg.gif' /></a></th>
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
			<td valign=top>$opd_nama</td>
			<td valign=top>$opd_bidang</td>";
            
        echo "
			    <td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$opd_kode><img src=/images/button_edit.gif border=0></a> 
				<a href=$PHP_SELF?act=delete&id=$opd_kode onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=/images/button_delete.gif border=0></a>
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