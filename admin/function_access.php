<?
ob_start();
include("../s/config.php");
$f->checkaccess();
$t->basicheader();
$t->title('Setting &raquo; Function Access');
echo"<center>";
/*===========================================
CONFIG
============================================*/

$maintable="tbl_functionaccess";

if($act=="do_add" || $act=="do_update"){
	
	if ($act == "do_update") $f->checkaccess("edit");
	else if ($act == "do_add") $f->checkaccess("add");
	
	if(empty($name)) die("Nama Akses Harus Diisi! ");
	if($act=='do_update'){

		$sql="delete from tbl_functionaccess where name='$name'";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		
	}
	//echo"<PRE>";
	//print_r($_POST);
	//die();
	foreach($_POST as $key=>$val){
		if(eregi("read_priv|edit_priv|add_priv|delete_priv",$key)){
			foreach($$key as $key1 => $val1){
				//check
				$sql="select url from tbl_menu where nomorurut='$val1'";
#echo"$sql<HR>";
                                $result=$db->Execute($sql);
                                if(!$result) print $db->ErrorMsg();
                                $row=$result->FetchRow();
                                $url=$row[url];

				
				$sql="select menu_id as idexist from tbl_functionaccess where menu_id='$val1' and name='$name'";
#echo"$sql<HR>";
				$result=$db->Execute($sql);
				if(!$result) print $db->ErrorMsg();
				$row=$result->FetchRow();
				$idexist=$row[idexist];
				if(!empty($idexist)){
					$sql="update tbl_functionaccess set $key='1' where menu_id='$val1' and name='$name'";
#echo"$sql<HR>";
					$result=$db->Execute($sql);
					if(!$result) print $db->ErrorMsg();
					$f->insert_log("UPDATE FUNCTION ACCESS: $name");

				}else{

					$sql="insert into tbl_functionaccess ($key,name,url,menu_id) values ('1','$name','$url','$val1')";
#echo"$sql<HR>";
					$f->insert_log("INSERT FUNCTION ACCESS: $name");
					$result=$db->Execute($sql);
					if(!$result) print $db->ErrorMsg();

				}
			}
		}

	}

	echo"Sukses. <a href=$PHP_SELF>Kembali</a>";

}elseif($act=="delete"){

	$f->checkaccess("delete");

	$sql="delete from $maintable where name='$name'";
	$result=$db->Execute($sql);
	if(!$result) print $db->ErrorMsg();

	header("Location: $HTTP_REFERER");
	ob_flush();
	exit;

	
}elseif($act=='add' || $act=='update'){


	$_act = ($act=="add")?"do_add":"do_update";
	
	
	if ($_act == "do_update") $f->checkaccess("edit");
	else if ($_act == "do_add") $f->checkaccess("add");
	
	echo"
	<script type=\"text/javascript\"><!--

	 var formblock;
	 var forminputs;
	
	 function prepare() {
	 formblock= document.getElementById('myform');
	 forminputs = formblock.getElementsByTagName('input');
	 }

	 function select_all(name, value) {
	 for (i = 0; i < forminputs.length; i++) {
	
	 var regex = new RegExp(name, \"i\");
	 if (regex.test(forminputs[i].getAttribute('name'))) {
	 if (value == '1') {
	 forminputs[i].checked = true;
	 } else {
	 forminputs[i].checked = false;
	 }
	 }
	 }
	 }
	
	 if (window.addEventListener) {
	 window.addEventListener(\"load\", prepare, false);
	 } else if (window.attachEvent) {
	 window.attachEvent(\"onload\", prepare)
	 } else if (document.getElementById) {
	 window.onload = prepare;
	 }
	
	 //--></script>
	";

	if($name && $act=='update'){
		$name=urldecode($name);
		$sql="select * from $maintable where name='$name'";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		while($row=$result->FetchRow()){
			foreach($row as $key => $val){
				$key=strtolower($key);
				$$key=$val;
			}
		}
		
	}

	

	echo"<BR>";
	
	echo"
	<form method=post name=myform>
	<input type=hidden name=act value=$_act>
	<input type=hidden name=tempact value=$act>
	<input type=hidden name=id value=$id>

	<table width=95% align=center>
	<tr>
		<td>Nama Akses</td>
		<td>";
		if($act=='update'){
			echo"
			<input type=text name=name value='$name' readonly>
			"; 
		}else{
			echo"<input type=text name=name value='$name' size=50>";
		}
		echo"</td>
	</tr>

	</table>

	<table border=0 width=95% align=center cellpadding=2 cellspacing=1 bgcolor=white>
	<tr bgcolor=#AAAACC>
			<td colspan=5>Menu</td>
			<td align=center>READ</td>
			<td align=center>EDIT</td>
			<td align=center>ADD</td>
			<td align=center>DELETE</td>
	</tr>
	<tr bgcolor=#C0C0C0>
			<td colspan=5>&nbsp;</td>
			<td align=center>
			<a href=# onClick=\"select_all('read_priv', '1');\">Check</a>&nbsp;|&nbsp;<a href=# onClick=\"select_all('read_priv', '0');\">UnCheck</a>
			</td>
			<td align=center>
			<a href=# onClick=\"select_all('edit_priv', '1');\">Check</a>&nbsp;|&nbsp;<a href=# onClick=\"select_all('edit_priv', '0');\">UnCheck</a>
			</td>
			<td align=center>
			<a href=# onClick=\"select_all('add_priv', '1');\">Check</a>&nbsp;|&nbsp;<a href=# onClick=\"select_all('add_priv', '0');\">UnCheck</a>
			</td>
			<td align=center>
			<a href=# onClick=\"select_all('delete_priv', '1');\">Check</a>&nbsp;|&nbsp;<a href=# onClick=\"select_all('delete_priv', '0');\">UnCheck</a>
			</td>
	</tr>

		";
	$checked="checked style=background-color:ffdd00; ";
	$sql="select * from tbl_menu where level='0' order by bobot";
	$result=$db->Execute($sql);
	if(!$result) print $db->ErrorMsg();
	while($row=$result->FetchRow()){
		$judul	=$row[judul];
		$id	=$row[nomorurut];


		$sql="select * from $maintable where name='$name' and menu_id='$id' ";
		//echo $sql."<br>";
		$result_check=$db->Execute("$sql");
		$row_check=$result_check->FetchRow();
		$read_check= $row_check[read_priv];
		$edit_check	= $row_check[edit_priv];
		$add_check	= $row_check[add_priv];
		$delete_check	= $row_check[delete_priv];

		echo"<tr bgcolor=#C0C9EC><td>&#149;</td><td colspan=4>$judul </td>
		<td align=center><input type=checkbox name=read_priv[] value=$id	".($read_check=='1'?"$checked":"")."></td>
		<td align=center><input type=checkbox name=edit_priv[] value=$id	".($edit_check=='1'?"$checked":"")."></td>
		<td align=center><input type=checkbox name=add_priv[] value=$id	".($add_check=='1'?"$checked":"")."></td>
		<td align=center><input type=checkbox name=delete_priv[] 	value=$id	".($delete_check=='1'?"$checked":"")."></td>
		</tr>";

		unset($read_check,$edit_check,$add_check,$delete_check);

		$sql="select * from tbl_menu where referensi='$id'  order by bobot";		
		//echo $sql."<br>";
		$result1=$db->Execute($sql);
		if(!$result1) print $db->ErrorMsg();
		while($row1=$result1->FetchRow()){
			$k++;
			$judul	=$row1[judul];
			$id	=$row1[nomorurut];

	
			$sql="select * from $maintable where name='$name' and menu_id='$id'";
			#if($id=='50') die($sql);
			$result_check=$db->Execute("$sql");
			$row_check=$result_check->FetchRow();
			$read_check	= $row_check[read_priv];
			$edit_check	= $row_check[edit_priv];
			$add_check	= $row_check[add_priv];
			$delete_check	= $row_check[delete_priv];
			$class=($k%2)?"tdganjil":"tdgenap";

			
			echo"<tr class=$class><td>&nbsp;</td><td>&#149;</td><td colspan=3 >$judul</td>
			<td align=center><input type=checkbox name=read_priv[] 	value=$id ".($read_check=='1'?"$checked":"")."></td>
			<td align=center><input type=checkbox name=edit_priv[] 	value=$id ".($edit_check=='1'?"$checked":"")."></td>
			<td align=center><input type=checkbox name=add_priv[] 	value=$id ".($add_check=='1'?"$checked":"")."></td>
			<td align=center><input type=checkbox name=delete_priv[] 	value=$id ".($delete_check=='1'?"$checked":"")."></td></tr>";

			$sql="select * from tbl_menu where referensi='$id' order by bobot";		
			//echo $sql;
			$result2=$db->Execute($sql);
			if(!$result2) print $db->ErrorMsg();
			while($row2=$result2->FetchRow()){
				$l++;
				$judul	=$row2[judul];
				$id	=$row2[nomorurut];

				$class=($l%2)?"tdganjil":"tdgenap";

				$result_check=$db->Execute("select * from $maintable where name='$name' and menu_id='$id'");
				$row_check=$result_check->FetchRow();
				$read_check	= $row_check[read_priv];
				$edit_check	= $row_check[edit_priv];
				$add_check	= $row_check[add_priv];
				$delete_check	= $row_check[delete_priv];


				echo"<tr class=$class><td>&nbsp;</td><td>&nbsp;</td><td>&#149;</td><td colspan=2 width=50%>$judul</td>	
				<td align=center><input type=checkbox name=read_priv[] 	value=$id  ".($read_check=='1'?"$checked":"")."></td>
				<td align=center><input type=checkbox name=edit_priv[] 	value=$id  ".($edit_check=='1'?"$checked":"")."></td>
				<td align=center><input type=checkbox name=add_priv[] 	value=$id  ".($add_check=='1'?"$checked":"")."></td>
				<td align=center><input type=checkbox name=delete_priv[] 	value=$id  ".($delete_check=='1'?"$checked":"")."></td>
				</tr>";

				$sql="select * from tbl_menu where referensi='$id'";			
				$result3=$db->Execute($sql);
				if(!$result3) print $db->ErrorMsg();
				while($row3=$result3->FetchRow()){
					$judul	=$row3[judul];
					$id	=$row3[nomorurut];

					$result_check=$db->Execute("select * from $maintable where name='$name' and menu_id='$id'");
					$row_check=$result_check->FetchRow();
					$read_check	= $row_check[read_priv];
					$edit_check	= $row_check[edit_priv];
					$add_check	= $row_check[add_priv];
					$delete_check	= $row_check[delete_priv];



					echo"<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&#149;</td><td>$judul</td>	
					<td align=center><input type=checkbox name=read_priv[] 	value=$id ".($read_check=='1'?"$checked":"")."></td>
					<td align=center><input type=checkbox name=edit_priv[] 	value=$id ".($edit_check=='1'?"$checked":"")."></td>
					<td align=center><input type=checkbox name=add_priv[] 	value=$id ".($add_check=='1'?"$checked":"")."></td>
					<td align=center><input type=checkbox name=delete_priv[] 	value=$id ".($delete_check=='1'?"$checked":"")."></td>
					</tr>";
				}

			}

		}

	}
	echo"

	<tr bgcolor=c0c0c0>
		<td colspan=8 align=right>
				<a href=# onClick=\"select_all('read_priv', '1');select_all('edit_priv', '1');select_all('add_priv', '1');select_all('delete_priv', '1');\">Select All</a> |
				<a href=# onClick=\"select_all('read_priv', '0');select_all('edit_priv', '0');select_all('add_priv', '0');select_all('delete_priv', '0');\">Deselect All</a>  
		</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td colspan=8>&nbsp;</td>
		<td><input type=submit value='submit'></td>
	</tr>
	</table>
	
	</form>
	";
}else{

	if(!$start) 	$start='0';
	if(!$order)	$order='name';
	if(!$sort) 	$sort='desc';
	if(!$page) 	$page='0';
	if(!$num)	$num='10';
	$start=($page-1)*$num;
	if($start < 0) $start='0';


	if(!empty($query)){
	       $query	= urldecode($query);
	       $query	= strtolower(trim($query));
		$rel 	= !empty($cond)?"and":"where";
		$cond  .=" $rel username like '%$query%'";
	}

	$cond .=" group by name";
	$total = $f->count_total("tbl_functionaccess","$cond");

	$advance_search="0";
	$f->standard_buttons();	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select name from tbl_functionaccess $cond order by name $sort";
	$result=$db->SelectLimit("$sql","$num","$start");
	if(!$result) print $db->ErrorMsg();

	$_sort=($sort=='desc')?"asc":"desc";

	echo"
	<table class=index>
	<tr>
		<th width=10><font color=white><B>No.</th>
		<th width=90%><font color=white><B>Access Name</th>
		<th width=10%><font color=white><B>Fungsi</th>
	</tr>";

	while($arr=$result->Fetchrow()){
		$i++;
		$bgcolor = ($i%2)?"ebebeb":"ffffff";
		foreach($arr as $key => $val){
			$key=strtolower($key);
			$$key=$val;
		}
		echo"<tr bgcolor=$bgcolor>
			<td>$i</td>
			<td>$name</td>
			<td>

			<a href=?name=".urlencode($name)."&act=update><img src=/images/button_edit.gif border=0></a>  
			<a href=?act=delete&name=".urlencode($name)."><img src=/images/button_delete.gif onClick=\"javascript:return confirm('Are you sure ?');return false;\" border=0></a> 
			</td>
		</tr>";		
		unset($td);
	}
	echo"</table>";
}
$t->basicfooter();
?>