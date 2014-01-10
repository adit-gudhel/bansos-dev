<?
ob_start();
include("$DOCUMENT_ROOT/s/config.php");
$f->checkaccess();
$t->basicheader();
$t->title('Setting &raquo; Ganti Password');

if(!$start) 	$start='0';
if(!$order)	$order='id';
if(!$sort) 	$sort='desc';
if(!$page) 	$page='0';
if(!$num)	$num='10';
$start=($page-1)*$num;
if($start < 0) $start='0';
$advance_search = 0;

	$sql="select inquiry_access from tbl_inquiry_access where access_name='$login_access' and inquiry_name='ManageUser'";

	$result         = $db->Execute($sql);
	if (!$result) print $db->ErrorMsg();
	$row=$result->FetchRow();
	$_inquiry_access=$row[inquiry_access];



if($act=='add' || $act=='update'){
	/*
	include("user_add.php");
	die();
	*/

	$user_id=$login_id;

	$_act=(!empty($user_id))?"do_update":"do_add";
	if(!empty($user_id)){
		$sql="select * from tbl_user where id='$user_id' ";
		//echo $sql;die;
		$result=$db->Execute($sql);
		if(!$result) print $db->ErrorMsg();
		$row=$result->FetchRow();
		foreach($row as $key=>$val){
			$key=strtolower($key);
			$$key=$val;
		}
	}
	$user_id = $id;
	#echo"<pre>";
	#print_r($row);

	echo"
	<script Language=\"Javascript\">
	function sendForm() {
	        this.f1.act.value = this.f1.tempact.value;
	        this.f1.submit();
	}
	</script>



	<form method=post name=f1 ENCTYPE=\"multipart/form-data\">	
	<input type=hidden name=act value=$_act>
	<input type=hidden name=tempact value=$act>
	<input type=hidden name=id value=$id>
	<table class=index>
	<tr>
		<td bgcolor=ebebeb colspan=2><ximg src=../i/arrow.gif>&nbsp;<B><font color=>User<BR>
		<ximg src=../i/component_divider.gif width=400 height=10></td>
	</tr>
	
	<tr>	
		<td >Password *</b></td>
		<td ><input type=password name=password value='' size=50 maxlength=20></td>
	</tr>
		
	<tr>	
		<td >Verify *</b></td>
		<td ><input type=password name=verify value='' size=50 maxlength=20></td>
	</tr>";

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

	if ($password != $verify) {
		$f->result_message("Password not Verified.<P>
			<a href=javascript:history.back(-1)>Return to Form </a> or
			<a href=$PHP_SELF?channel=$channel>Return to Main Page</a>
			");
		die();
	}

	#$f->checkaccesswrite("$access_level_privillege");
	if($error){
		echo"<B>ERROR: </B>
		<ul>$error</ul><P>
		<B>&laquo;</B> <a href=# onClick=javascript:history.back(-1)>Kembali</a>";

	}else{
		global $signature_name;
		$filename=time().$signature_name;
		$filename=eregi_replace(" ","_",$filename);
		$dirfile ="$DOCUMENT_ROOT/i/art";

		#echo"<PRE>";
		#print_r($HTTP_POST_VARS);
		foreach($HTTP_POST_VARS as $key=>$val){

			if($act=='do_add' && !preg_match("/^(act|id|tempact|department_id|search_deputi_bidang)$/i",$key)){
				
				if($key=='password'){
					$val=md5($val);
				}
				elseif($key=='akses_deputi_bidang'){
					unset($_val);
					foreach($val as $k=>$v) {
						$_val .= $v."|";
					}
					$_val=substr($_val,0,-1);
					$val = $_val;
				}
				$columns .="$key,";
				$values .="'$val',";

			}elseif($act=='do_update' && !preg_match("/^(act|tempact|department_id|signature_change|search_deputi_bidang|verify)$/i",$key)){
				
				if($key=='id'){
					$cond="$key='$val'";
				}elseif($key=='password'){
					if(!empty($val)) $list .="$key='".md5($val)."',";
				}elseif($key=='akses_deputi_bidang'){
					unset($_val);
					foreach($val as $k=>$v) {
						$_val .= $v."|";
					}
					$_val=substr($_val,0,-1);
					$list .="$key='".$_val."',";
				
				}else{
					$list .="$key='$val',";
				}
			}

		}
		$columns = preg_replace("/,$/","",$columns);
		$values	 = preg_replace("/,$/","",$values);
		$list	 = preg_replace("/,$/","",$list);

		if($act=="do_update"){
			
			$sql_update="update tbl_user set $list where $cond";
			//echo $sql_update; die();
			$result=$db->Execute("$sql_update");
			if (!$result){
				print $db->ErrorMsg();
				die($sql_update);
			}

			/*$sql="delete from tbl_user_department where user_id='$id'";
			$result=$db->Execute($sql);
			if (!$result){
 			       print $db->ErrorMsg();
			        die($sql_update);
			}
				//add dept authority
			for($i=0;$i<count($department_id);$i++){
				$sql="insert into tbl_user_department (user_id,department_id) values ('$id','".$department_id[$i]."')";
				#echo $sql."<HR>";
				$result=$db->Execute($sql);
				if (!$result){
       					print $db->ErrorMsg();
					die($sql_insert);
				}
			}*/

			$f->insert_log("CHANGE PASSWORD. USER_ID: $id, USER: $username");


			$f->result_message("User successfully updated.<P>
			<a href=javascript:history.back(-1)>Return to Form </a> or
			<a href=/admin/ganti_password.php?act=update>Return to Main Page</a>
			");
		}else{
			if(empty($username)) $error .="<li>Please Fill-in UserName field";
			if(empty($password)) $error .="<LI>Please Fill-in Password field";

			//check apakah user-nya sudah ada atau belum?
			$sql="select id from tbl_user where username='$username'";
			$result=$db->Execute($sql);
			$row=$result->FetchRow();
			$user_id_exist=$row[ID];

			if(!empty($user_id_exist)) $error .="Error: User $username already exist! <a href=# onClick=javascript:history.back(-1);>Return to form</a>";
			if($error){
				echo"<P>";
				$f->box("INVALID INPUT","<UL>$error</ul>","","error","");

			}


				if(!empty($signature)){
					move_uploaded_file($HTTP_POST_FILES['signature']['tmp_name'],"$dirfile/$filename") or die("Tambah Baru: Gagal Upload ");
					$replace=addslashes($DOCUMENT_ROOT);
					$path=eregi_replace($replace,"","$dirfile/$filename");
				}else{
					unset($path);
				}
				$columns .=",signature";
				$values .=",'$path'";
	
				$sql_insert="insert into tbl_user  ($columns) values ($values)";

				#die($sql_insert);
				$result=$db->Execute($sql_insert);
				if (!$result){
					print $db->ErrorMsg();
					die($sql_insert);
				}	
				//max
				
				$sql="select max(id) as MAX_ID from tbl_user";
				#echo"$sql<HR>";
				$result=$db->Execute($sql);
				if(!$result) print $db->ErrorMsg();
				$row=$result->FetchRow();
				$user_id=$row[MAX_ID];

				//add dept authority
				for($i=0;$i<count($department_id);$i++){
					$sql="insert into tbl_user_department (user_id,department_id) values ('$user_id','".$department_id[$i]."')";
					#echo $sql."<HR>";
					$result=$db->Execute($sql);
					if (!$result){
       						print $db->ErrorMsg();
					        die($sql_insert);
					}
				}
				$f->insert_log("ADD USER.USER: $username");
				$f->result_message("Record has been added into Database.
				  ");
		}
	}
	#echo $sql_insert;
}
$t->basicfooter();
?>