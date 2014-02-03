<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Hibah &raquo; Input Data Rekening Hibah');


if ($act == "add" || $act == "edit") {

	if ($id) {

		$sql = "SELECT a.hib_kode, a.nama, a.alamat, a.kelurahan, a.kecamatan, a.kota, a.propinsi, a.hasil_evaluasi_tapd as jumlah_uang, b.rek_anggaran as no_rek FROM v_dncpbh_tapd a LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode where (a.status_opd = 1 AND a.status_tapd = 1) AND a.hib_kode=$id";
		
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
       
    }
    
    if ($id && $act == "add") unset($id);
    
?>
<script type="text/javascript" src="/rekening_hibah.js"></script>
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="do_update">
<input type="hidden" name="id" value="<?=$hib_kode?>">
  <tr>
    <td>Nama Penerima Hibah</td>
    <td>
      <?=$nama?>
    </td>
  </tr>
  <tr>
    <td>Alamat Penerima Hibah</td>
    <td>
      <? echo "$alamat Kel. ".ucwords(strtolower($kelurahan))." Kec. ".ucwords(strtolower($kecamatan)).", ".ucwords(strtolower($kota))." - ".ucwords(strtolower($propinsi)).""; ?>
    </td>
  </tr>
  <tr>
    <td>Jumlah Uang (Rp)</td>
    <td>
      Rp. <?=number_format($jumlah_uang,2,',','.')?>
    </td>
  </tr>
  <tr>
  	<td>Rekening Anggaran</td>
    <td>
    <?=$f->selectList("no_rek","tbl_rekening","no_rek","keterangan",$no_rek,$script="",$cond,1,"","--")?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    <input type="button" onClick="history.back(-1);" value="&laquo; Back" /> 
    <input class="submit" type="submit" value="Update" /></td>
  </tr>  
</table>
</form>
<br/>
<?
}
else if ($act == "do_update") {
	foreach ($_POST as $key=>$val) {	
    	$$key = $val;
    }
     
    if ($act=='do_update') {	   
        
		$sql = "UPDATE tbl_hibah SET rek_anggaran='$no_rek' WHERE hib_kode=$id";
		
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
		
    }
    
    echo"<p><a href=$PHP_SELF>Sukses Simpan Data</a></p> ";
}
/*
else if ($act == "delete") {
	
	$sql = "DELETE FROM tbl_monev_hibah WHERE hib_kode=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	header("location: $PHP_SELF");
}
*/

else {

    if(!$start) $start='1';
    if(!$order)	$order='a.nama';
    if(!$sort) 	$sort='asc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    $f->standard_buttons('noadd');
    $f->search_box($query);

$cond1 = " LEFT JOIN tbl_hibah b ON a.hib_kode=b.hib_kode ";

if(!empty($query)){
	$query = urldecode($query);
	$query = strtolower(trim($query));
	
	$rel = !empty($cond)?"and":"where";
	$cond  .=" $rel (a.nama like '%$query%' or a.alamat like '%$query%')";
}

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (a.status_opd = 1 AND a.status_tapd = 1)";

$total = $f->count_total("v_dncpbh_tapd a","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));


$sql="SELECT a.hib_kode as id, a.nama, a.alamat, a.kelurahan, a.kecamatan, a.kota, a.propinsi, a.hasil_evaluasi_tapd as jumlah_uang, b.rek_anggaran FROM v_dncpbh_tapd a $cond1 $cond order by $order $sort";

$result=$db->SelectLimit("$sql","$num","$start");
# echo $sql;
if(!$result) print $db->ErrorMsg();
$_sort=($sort=='desc')?"asc":"desc"; 

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Nama Penerima</th>
		<th class=white  valign=top>Alamat Penerima</th>
		<th class=white  valign=top>Jumlah Uang (Rp)</th>
		<th class=white  valign=top>Kode Rekening Anggaran</th>
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
			<td valign=top>$nama</td>
			<td valign=top>$alamat Kel. ".ucwords(strtolower($kelurahan))." Kec. ".ucwords(strtolower($kecamatan)).", ".ucwords(strtolower($kota))." - ".ucwords(strtolower($propinsi))."</td>
			<td valign=top>".number_format($jumlah_uang,2,',','.')."</td>
			<td valign=top>$rek_anggaran</td>
			";
            
        echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$id><img src=../images/button_edit.gif border=0></a> 
				<!-- <a href=$PHP_SELF?act=delete&id=$id onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a> --!>";

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