<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Pelayanan &raquo; Bantuan Sosial &raquo; Monitoring dan Evaluasi Bantuan Sosial');


if ($act == "add" || $act == "edit") {

	if ($id) {

		$sql = "SELECT c.*, h.ban_nama, h.mon_tgl, h.mon_hasil, h.mon_uraian, e.besaran_tapd FROM tbl_cair_bansos c left join tbl_bansos h on c.ban_kode=h.ban_kode left join tbl_eval_tapd_detail e on c.ban_kode=e.hib_kode left join tbl_eval_tapd f on e.kode=f.kode WHERE f.tipe='BANSOS' and c.id_cair='$id'";
		#echo $sql;
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
       
    }
    
    if (!$mon_tgl) $mon_tgl = date('Y-m-d');
   
?>
<script type="text/javascript" src="/monev_bansos.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
        editor_selector : "mceEditor",
        editor_deselector : "mceNoEditor",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		formats : {
			alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
			aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
			alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
			alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
			bold : {inline : 'span', 'classes' : 'bold'},
			italic : {inline : 'span', 'classes' : 'italic'},
			underline : {inline : 'span', 'classes' : 'underline', exact : true},
			strikethrough : {inline : 'del'}
		},

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<form id="ff" enctype="multipart/form-data" method="POST" action="<?=$PHP_SELF?>">
<table class="index">
<input type="hidden" name="act" value="do_update" />
<input type="hidden" name="id" value="<?=$ban_kode?>" />
  <tr>
    <td>Tanggal Evaluasi</td>
    <td>
      <input type="text" name="mon_tgl" id="mon_tgl" value="<?=$f->convertdatetime(array("datetime"=>$mon_tgl))?>" class="easyui-validatebox" required="true" />
    </td>
  </tr>
  <tr>
    <td>Nama Penerima Bantuan Sosial</td>
    <td>
      <?=$ban_nama?>
    </td>
  </tr>
  <tr>
    <td>Jumlah (Rp)</td>
    <td>
      Rp. <?=number_format($besaran_tapd,2,',','.')?>
    </td>
  </tr>
  <tr>
  	<td>Hasil</td>
    <td><?=$f->selectListArray("mon_hasil",array("Baik"=>"Baik", "Cukup Baik"=>"Cukup Baik", "Kurang"=>"Kurang"),$mon_hasil)?></td>
  </tr>
  <tr>
  	<td>Uraian</td>
    <td>
    	<textarea class="mceEditor" name="mon_uraian" id="mon_uraian" cols="45" rows="8" style="width:500px;" ><?=$mon_uraian?></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
    <input type="button" onClick="history.back(-1)" value="&laquo; Back" /> 
    <input class="submit" type="submit" value="Update" /></td>
  </tr>  
</table>
</form>

<?
}
else if ($act == "do_update") {
	foreach ($_POST as $key=>$val) {	
    	$$key = $val;
    }
     
    if ($act=='do_update') {	    
        $sql = "UPDATE tbl_bansos SET mon_tgl='".$f->preparedate($mon_tgl)."', mon_hasil='$mon_hasil', mon_uraian='".trim(strip_tags($mon_uraian))."' WHERE ban_kode=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    
    
    echo"<a href=$PHP_SELF>Sukses Simpan Data</a> ";
}
/*
else if ($act == "delete") {
	
	$sql = "DELETE FROM tbl_monev_bansos WHERE ban_kode=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
	
	header("location: $PHP_SELF");
}
*/
else {

    if(!$start) $start='1';
    if(!$order)	$order='h.ban_nama';
    if(!$sort) 	$sort='asc';
    if(!$page) 	$page='0';
    if(!$num)	$num='10';
    $start=($page-1)*$num;
    if($start < 0) $start='0';
    $advance_search = 0;

    $f->standard_buttons('noadd');
    $f->search_box($query);

$cond1 = " left join tbl_bansos h on c.ban_kode=h.ban_kode left join tbl_eval_tapd_detail e on c.ban_kode=e.hib_kode left join tbl_eval_tapd f on e.kode=f.kode";

if(!empty($query)){
$query = urldecode($query);
$query = strtolower(trim($query));

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel (h.ban_nama like '%$query%' and f.tipe='BANSOS')";
}

$rel = !empty($cond)?"and":"where";
$cond  .=" $rel f.tipe='BANSOS' ";

$total = $f->count_total("tbl_cair_bansos c","$cond1 $cond"); 

$f->paging(array("link"=>$PHP_SELF."?query=$query&order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"$num","show_total"=>1));
$sql="select c.*, h.ban_nama, h.mon_tgl, h.mon_hasil, h.mon_uraian, e.besaran_tapd FROM tbl_cair_bansos c $cond1 $cond order by $order $sort";
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
		<th class=white  valign=top>Tanggal Evaluasi</th>
		<th class=white  valign=top>Hasil</th>
		<th class=white  valign=top>Uraian</th>
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
			<td valign=top>";
			if ($mon_tgl){ echo $f->convertdatetime(array("datetime"=>$mon_tgl));}
            echo "</td>
			<td valign=top>$mon_hasil</td>
			<td valign=top>$mon_uraian</td>
			";
            
        echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=edit&id=$id_cair><img src=../images/button_edit.gif border=0></a> 
				<!-- <a href=$PHP_SELF?act=delete&id=$id_cair onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a> --!>";

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