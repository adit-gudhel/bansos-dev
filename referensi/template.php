<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
$t->basicheader();
$f->checkaccess();
$t->title('Setting - Template Laporan');

if ($act == "add" || $act == "edit") {
	if ($act == "edit" && $id) {

        $sql = "SELECT * FROM tbl_template WHERE id=$id";
        $result=$db->Execute($sql);
        $row = $result->Fetchrow();
        foreach($row as $key => $val){
            $$key=$val;
        }
    }
?>
<script type="text/javascript" src="/tiny_mce/tiny_mce.js"></script>
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
<table class="index">
<form method="POST" action="<?=$PHP_SELF?>">
<input type="hidden" name="act" value="<?=(!empty($id))?"do_update":"do_add"?>">
<input type="hidden" name="id" value="<?=$id?>">
  <tr>
    <td>Nama</td>
    <td><label>
      <input type="text" name="name" id="name" value="<?=$name ?>"/>
    </label></td>
  </tr>
  <tr>
    <td>Nama Penanggung Jawab</td>
    <td><label>
      <textarea class="mceEditor" name="template_laporan" id="template_laporan" style="width:750px;height:1200px;"><?=$template_laporan?></textarea>
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
    
        $sql = "UPDATE tbl_gol_gk SET golongan='$golongan' WHERE id_gol_gk=$id";
                
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    
    }
    else {
        
        $sql = "INSERT INTO tbl_gol_gk (golongan)
                VALUES ('$golongan')";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    header("location: $PHP_SELF");
}
else if ($act == "delete") {
	$sql = "DELETE FROM tbl_gol_gk WHERE id_gol_gk=$id";
    $result=$db->Execute($sql);
    if(!$result){ print $db->ErrorMsg(); die(); }
    header("location: $PHP_SELF");
}
else {

    if(!$start) $start='0';
    if(!$order)	$order='id';
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
		$cond  .=" $rel (name like '%$query%')";
	}


	$total = $f->count_total("tbl_template","$cond");

	$f->standard_buttons();	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select * from tbl_template $cond order by $order $sort";
    $result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Nama</th>
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
			<td valign=top>$name</td>";
            
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