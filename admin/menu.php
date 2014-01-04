<?

ob_start();
include("$DOCUMENT_ROOT/s/config.php");

$t->basicheader();
$t->title('Setting &raquo; Menu');

$nomorurut = $nomorurut_menuedit;
$referensi = $referensi_menuedit;

echo"
<link rel=\"StyleSheet\" href=\"/dtree.css\" type=\"text/css\" />
<script type=\"text/javascript\" src=\"/js/dtree_admin.js\"></script>
";

$f->checkaccess();

$maintable="tbl_menu";
$menu             = array(
                  "menu.php"=>"Pengaturan Menu"
                  );
                  


if($act=="do_add" || $act=="do_update"){
	

	foreach($_POST as $key=>$val){	
		if($act=='do_update' && $key=='nomorurut_old'){
			$update_condition ="nomorurut='$val'";
		}elseif(!preg_match("/^(act|id|tempact)$/",$key) && $key!="nomorurut_old"){
			$insert_column .="$key,";
			$insert_value .="'$val',";
			$update_value .="$key='$val',";
		}
	}
	$insert_column = preg_replace("/,$/","",$insert_column);
	$insert_value  = preg_replace("/,$/","",$insert_value);

	$update_value = preg_replace("/,$/","",$update_value);
	$update_condition = preg_replace("/,$/","",$update_condition);

	$sql="select judul as judul_referensi from $maintable where id='$referensi'";
	$result=$db->Execute($sql);
	$row=$result->FetchRow();
	
	$judul_referensi = $row['judul_referensi'];
	
	if($act=="do_add"){
		/* CHECK APAKAH NOMERURUT-NYA SUDAH ADA ATAU BELUM? */
		$sql="select nomorurut from $maintable where nomorurut='$nomorurut'";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$nomorurutexist=$row['nomorurut'];
		if(!empty($nomorurutexist)) die("Nomor Urut $nomorurut telah digunakan untuk menu yang lain");

		$sql="insert into $maintable 
			($insert_column)
			values 
			($insert_value)";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();

		$button=array(
			"0"=>array("$PHP_SELF","Kembali")
			);
		$f->box("Tambah Sukses","Penambahan Berhasil",$button,"info");
		$f->insert_log("ADD MENU JUDUL: $judul, REFERENSI: $judul_referensi");

	}else{
		$sql="update $maintable set $update_value where $update_condition";
		//echo $sql;
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$button=array("0"=>array("$PHP_SELF","Kembali"));
		$f->insert_log("EDIT MENU JUDUL: $judul, REFERENSI: $judul_referensi");
		$f->box("Update Sukses","Perubahan Berhasil",$button,"info");
	}

}elseif($act=="delete"){

	$sql="delete from $maintable where nomorurut='$nomorurut'";
	echo $sql;
	$result=$db->Execute($sql);
	if(!$result) print $db->ErrorMsg();

	$f->insert_log("DELETE MENU JUDUL: $judul, REFERENSI: $judul_referensi");

	header("Location: menu.php");	
	ob_flush();
	exit;



		
}elseif($act=='add' || $act=='update'){

	

	if($nomorurut && $act=='update'){
		$sql="select * from $maintable where nomorurut='$nomorurut'";
		//echo $sql;
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		foreach($row as $key => $val){
			$key=strtolower($key);
			$$key=$val;
		}
	}else{
		$sql="select max(nomorurut)+1  as nomorurut from $maintable order by nomorurut desc";
		//echo $sql;
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$nomorurut=$row['nomorurut'];

	}

	if($referensi){

		$sql="select * from $maintable where nomorurut='$referensi'";
		//echo $sql;
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		$level	=$row['level']+1;
	}


	$_act= ($act=='add')?"do_add":"do_update";


	echo"

	<script>
	function sendForm() {
	      this.f1.act.value = this.f1.tempact.value;
	      this.f1.submit();
	}
	</script>

	<form method=post name=f1>
	<input type=hidden name=act value=$_act>
	<input type=hidden name=id value=$id>
	<input type=hidden name=nomorurut_old value='$nomorurut'>
	<input type=hidden name=tempact value=$act>
	<table class=index>
	<tr>
		<td>NOMOR URUT</td>
		<td><input type=text name=nomorurut size=2 value=\"$nomorurut\" ".($act=='update'?"disabled":"")."></td>
	</tr>
	<tr>
		<td>LEVEL</td>
		<td><select name=level  onChange=sendForm();>";
		for($i=0;$i<=6;$i++){
			$selected = ($level==$i)?"selected":"";
			echo"<option value='$i' $selected>Level $i";
			unset($selected);
		}

		echo"
		</select>
		</td>
	</tr>
	<tr>
		<td>REFERENSI</td>
		<td>";
		$level_referensi=$level-1;

		echo"<select name=referensi><option value=0>";

		if($referensi){
			$referensi=$referensi;
			$sql="select * from tbl_menu where nomorurut='$referensi'";
			//echo $sql;
						
		}else{
			$sql="select * from tbl_menu where level='$level_referensi'";
		}
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		while($row=$result->FetchRow()){

			$_nomorurut	=$row['nomorurut'];
			$_judul	=$row['judul'];
			$selected=($referensi==$_nomorurut)?"selected style=background-color:ffdd00;":"";
			echo"<option value='$_nomorurut' $selected> $_judul</option>";
			unset($selected);
		}
		echo"</select></td>
	</tr>
	<tr>
		<td>BOBOT</td>
		<td>";
		if(empty($bobot) && !empty($referensi)){
			$sql="select max(bobot) as bobot from tbl_menu where referensi='$referensi'";
			$result=$db->Execute($sql);
			if(!$result) print $db->ErrorMsg();
			$row=$result->FetchRow();
			$_bobot=$row["bobot"];
			$bobot=$_bobot + 1;
			//bobot=
		}
		
		
		echo"<input type=text name=bobot value='$bobot' size=5>
		</td>
	</tr>

	<tr>
		<td>JUDULMENU </td>
		<td><input type=text name=judul value=\"$judul\" size=60> </td>
	</tr>
	<tr>
		<td>URL</td>
		<td><input type=text name=url value=\"$url\" size=60> </td>
	</tr>
	<tr>
		<td>KETERANGAN</td>
		<td><input type=text name=keterangan value=\"$keterangan\" size=60> </td>
	</tr>
	<tr>
		<td>TARGET</td>
		<td><input type=text name=target value=\"$target\"> </td>
	</tr>
	<tr>
		<td>IMAGE</td>
		<td><input type=text name=image value=\"$image\"> </td>
	</tr>
	<tr>
		<td>TAMPIL</td>
		<td><input type=radio name=tampil value='1' ".((empty($tampil)||$tampil=='1')?"checked":"").">Ya 
		<input type=radio name=tampil value='0' ".(($tampil=='0')?"checked":"").">Tidak
		</td>
	</tr>
	<tr>
		<td>PARENT MENU HIRARKI</td>
		<td><input type=radio name=hirarki value='1' ".(($hirarki=='1')?"checked":"").">Ya 
		<input type=radio name=hirarki value='0' ".((empty($hirarki)||$hirarki=='0')?"checked":"").">Tidak
		</td>
	</tr>
	<tr>
		<td>BASIS DIREKTORI MENU HIRARKI</td>
		<td><input type=text name=basishirarki value='$basishirarki' size=60>
		</td>
	</tr>


	<tr>
		<td>&nbsp;</td>
		<td>
		<input type=button onClick=location.href('$PHP_SELF'); value='Back'>
		<input type=reset>
		<input type=submit value=submit> 
		</td>

	</tr>
	</table>
	</form>
	";
}else{

	$f->standard_buttons();

	echo"
	<div class=\"dtree\" style=padding-left:40px;>	
	<script type=\"text/javascript\">
	<!--
	d = new dTree('d');
	d.add(0,-1,'HOME','home.php','Home','main');
	";


	$sql="select * from $maintable order by bobot";
	$result=$db->Execute($sql);
	while($row=$result->FetchRow()){
	
		foreach($row as $key => $val){
			$key=strtolower($key);
			$$key=$val;
		}

		//echo"d.add('$id','$referensi','$judul - <font color=c0c0c0>$bobot</font>','$url','$keterangan','$target','$image');\n";
        //die("$nomorurut,$referensi,$judul $jumlah,$url,$keterangan,$target,$image");
		echo"d.add('$nomorurut','$referensi','$judul $jumlah','$url','$keterangan','$target','$image');\n";

	}
	echo"
	document.write(d);
	//-->
	</script>
		<p><a href=\"javascript: d.openAll();\">open all</a> | 
		<a href=\"javascript: d.closeAll();\">close all</a> | 
		<a href=menu.php>Refresh</a></p>
	</div>
	";

}
$t->basicfooter();
?>