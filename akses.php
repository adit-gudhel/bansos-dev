<?
ob_start();

include("$DOCUMENT_ROOT/s/config.php");
if(!$start) 	$start='0';
if(!$order)	$order='id';
if(!$sort) 	$sort='desc';
if(!$page) 	$page='0';
if(!$num)	$num='10';
$start=($page-1)*$num;
if($start < 0) $start='0';
$advance_search = 0;

	include("$DOCUMENT_ROOT/header.php");
	title("Referensi - Manage Akses","1");
	echo"
	<center>
	";
    
$f->checkaccess();


foreach ($_POST as $k => $v) {
    $$k = $v;
}

if($act=='delete'){

    $f->checkaccess("delete");

	$sql="delete from tbl_access where id='$access_id'";
	$result=$db->Execute($sql);
	if(!$result){print $db->ErrorMsg(); die();}
	
    $encoded_sql=base64_encode($sql);
	$f->insert_log("DELETE ACCESS: $username, FOLDER: $folder, USER_ID: $id","$encoded_sql");
	
	header("Location: $HTTP_REFERER");
	ob_end_flush();
	exit;

}elseif($act=='add' || $act=='update'){

    $_act=(!empty($access_id))?"do_update":"do_add";
    
    if ($_act == "do_update") $f->checkaccess("edit");
	else if ($_act == "do_add") $f->checkaccess("add");
    
	if(!empty($access_id)){
		$sql="select * from tbl_access where id='$access_id' ";
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		foreach($row as $key=>$val){
			$key=strtolower($key);
			$$key=$val;
		}
	}

	echo"
	
	<form method=POST name=f1 enctype=\"multipart/form-data\">	
	<input type=hidden name=act value=$_act>
	<input type=hidden name=tempact value=$act>
	<input type=hidden name=access_id value=$access_id>
	<table class=index>
	
	<tr>	
		<td >Username *</b></td>
		<td >".$f->selectList('user_id','tbl_user','id','username',$user_id)."</td>
	</tr>
	<tr>	
		<td >Folder *</b></td>
		<td ><input type=text name=folder value='$folder' size=50></td>
	</tr>
	";


	echo"
	<tr>
		<td >&nbsp;</td><td><input type=button onClick=history.back(-1) value='&laquo; Back'> <input type=submit value=".(($act=='add')?"Add":"Update")." class=buttonhi></td>
	</tr>
	
	
	Note :<BR>
	<small><sup>(*)</sup>Required Information</small>
	
		</td>
	</tr>
	</table>
	</form>
	";


}elseif($act=="do_add"||$act=="do_update"){

    if(empty($user_id)) $error .="<li>Silahkan isi username";
    if(empty($folder)) $error .="<LI>Silahkan isi folder";

	if($error){
    
		echo"<B>ERROR: </B>
		<ul>$error</ul><P>
		<B>&laquo;</B> <a href=# onClick=javascript:history.back(-1)>Kembali</a>";

	}else{
    
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
		
		foreach($_POST as $key=>$val){

			if($act=='do_add' && !preg_match("/^(act|access_id|tempact)$/i",$key)){
				
				$columns .="$key,";
				$values .="'$val',";

			} elseif ($act=='do_update' && !preg_match("/^(act|tempact)$/i",$key)){
				
				if ($key=='access_id') {
					$cond="id='$val'";
				} else {
					$list .="$key='$val',";
				}
			}

		}
		$columns = preg_replace("/,$/","",$columns);
		$values	 = preg_replace("/,$/","",$values);
		$list	 = preg_replace("/,$/","",$list);

		if ($act=="do_update") {
			
			$sql_update="update tbl_access set $list where $cond";
			$result=$db->Execute("$sql_update");
			
            if (!$result){
				print $db->ErrorMsg();
				die($sql_update);
			}

			$f->insert_log("UPDATE USER. USER_ID: $id, USER: $username");


			$f->result_message("Access updated successfully.<P>
			<a href=javascript:history.back(-1)>Return to Form </a>
			");
            
		} else {
        
			$sql_insert="insert into tbl_access  ($columns) values ($values)";

			$result=$db->Execute($sql_insert);
			if (!$result){
				print $db->ErrorMsg();
				die($sql_insert);
			}	
				
			$f->insert_log("ADD USER.USER: $username");
			$f->result_message("Access added successfully.<P>
			<a href=javascript:history.back(-1)>Return to Form </a>
			");
		}
	}
}
else {

    $cond1 = " left join tbl_user  b on a.user_id=b.id ";

	if(!empty($query)){
        
        $query	= urldecode($query);
        $query	= strtolower(trim($query));
		$rel 	= !empty($cond)?"and":"where";
		$cond  .=" $rel (b.username like '%$query%')";
	}


	$total = $f->count_total("tbl_access a","$cond1 $cond");

	$f->standard_buttons();	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select a.*, b.username from tbl_access a $cond1 $cond order by $order $sort";
	$result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";

	subtitle("Access Management");
	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Username</th>
		<th class=white  valign=top>Folder</th>
		

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
		#$access_level=$f->convert_value(array("table"=>"tbl_functionaccess","cs"=>"name","cd"=>"name","vd"=>$access_level,"print_query"=>1));
		echo"
		<tr bgcolor=$bgcolor>
			<td valign=top>".($i+$start)."</td>
			<td valign=top>$fullname <BR><B>$username</td>
			<td valign=top>$folder</td>
			";

			echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=update&access_id=$id><img src=/images/button_edit.gif border=0></a><br><br>
				<a href=$PHP_SELF?act=delete&access_id=$id onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=/images/button_delete.gif border=0></a>";

			echo"</td>
		</tr>
		";
		
		unset($_status,$tp);
	}
	echo"
	</table>
	";
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));

}
?>