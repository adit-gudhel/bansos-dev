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
$f->checkaccess();

	$t->basicheader();
    
    $t->title('Setting &raquo; User');
    
    
	$sql="select inquiry_access from tbl_inquiry_access where access_name='$login_access' and inquiry_name='ManageUser'";

	$result         = $db->Execute($sql);
	if (!$result) print $db->ErrorMsg();
	$row=$result->FetchRow();
	$_inquiry_access=$row[inquiry_access];



if($act=='delete'){
	$username	= $f->convert_value(array("table"=>"tbl_user","cs"=>"username","cd"=>"id","vd"=>$user_id,"print_query"=>0));
	$sql="delete from tbl_user where id='$user_id'";
	$result=$db->Execute($sql);
	if(!$result){print $db->ErrorMsg(); die();}
	$encoded_sql=base64_encode($sql);
	$f->insert_log("DELETE USER $username, USER_ID: $id","$encoded_sql");

	
	header("Location: $HTTP_REFERER");
	ob_end_flush();
	exit;

}elseif($act=='add' || $act=='update'){
	/*
	include("user_add.php");
	die();
	*/
	$_act=(!empty($user_id))?"do_update":"do_add";
	if(!empty($user_id)){
		$sql="select * from tbl_user where id='$user_id' ";
		#echo $sql;die;
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
    <script type=\"text/javascript\" src=\"/jquery-1.8.2.min.js\"></script>
    <script type=\"text/javascript\" src=\"/jquery.selectboxes.js\"></script>
    <script type=\"text/javascript\" src=\"user.js\"></script>

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
		<td >Nama</b></td>
		<td ><input type=text name=full_name value='$full_name' size=50></td>
	</tr>
    <tr>	
		<td >Username *</b></td>
		<td ><input type=text name=username value='$username' size=50></td>
	</tr>
	<tr>	
		<td >Password ".(($act=='add')?"*":"")."</b></td>
		<td ><input type=password name=password value='' size=50 maxlength=20></td>
	</tr>";

	echo"
	<tr>	
		<td >Function Access</b></td>
		<td >";
		$cond="group by name";
		echo $f->selectList("access_level","tbl_functionaccess","name","name",$access_level,$script="",$cond);
		echo"
		</td>
	</tr>

	<tr>	
		<td >Inquiry Access</b></td>
		<td >";
		$cond="group by access_name";
		echo $f->selectList("inquiry_access","tbl_inquiry_access","access_name","access_name",$inquiry_access,$script="",$cond);
		echo"
		</td>
	</tr>
	<tr>	
		<td >OPD</b></td>
		<td >";
		$cond="order by opd_nama asc";
		echo $f->selectList("opd_kode","tbl_opd","opd_kode","opd_nama",$opd_kode,$script="",$cond,1,"0","--");
		echo"
		</td>
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

	#$f->checkaccesswrite("$access_level_privillege");
	if($error){
		echo"<B>ERROR: </B>
		<ul>$error</ul><P>
		<B>&laquo;</B> <a href=# onClick=javascript:history.back(-1)>Kembali</a>";

	}else{

		#echo"<PRE>";
		#print_r($HTTP_POST_VARS);
		foreach($_POST as $key=>$val){

			if($act=='do_add' && !preg_match("/^(act|id|tempact)$/i",$key)){
				
				if($key=='password'){
					$val=md5($val);
				}
				
                $columns .="$key,";
				$values .="'$val',";
                

			}elseif($act=='do_update' && !preg_match("/^(act|tempact)$/i",$key)){
				
				if($key=='id'){
					$cond="$key='$val'";
				}elseif($key=='password'){
					if(!empty($val)) $list .="$key='".md5($val)."',";
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
			//echo $sql_update;
			$result=$db->Execute("$sql_update");
			if (!$result){
				print $db->ErrorMsg();
				die($sql_update);
			}

			$f->insert_log("UPDATE USER. USER_ID: $id, USER: $username");


			$f->result_message("User successfully update.<P>
			<a href=javascript:history.back(-1)>Return to Form </a>
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

				$f->insert_log("ADD USER.USER: $username");
				$f->result_message("Record has been added into Database.
				  ");
		}
	}
	#echo $sql_insert;
}
else {


	//check inquiry access!
	#echo"<h1>$sql $inquiry_access</h1>";

	if(!empty($query)){
	       $query	= urldecode($query);
	       $query	= strtolower(trim($query));
		$rel 	= !empty($cond)?"and":"where";
		$cond  .=" $rel (full_name like '%$query%' or username like '%$query%')";
	}


	$total = $f->count_total("tbl_user","$cond");

	$f->standard_buttons();	
	$f->search_box($query);
	$f->paging(array("link"=>$PHP_SELF."?order=$order&sort=$sort&type=$type&act=","page"=>$page,"total"=>$total,"num"=>"10","show_total"=>1));


	$sql="select * from tbl_user $cond order by $order $sort";
	$result=$db->SelectLimit("$sql","$num","$start");

	$_sort=($sort=='desc')?"asc":"desc";

	echo"
	<table class=index>
	<tr class=bgTitleTr>

		<th class=white width=5  valign=top><B>No</th>
		<th class=white  valign=top>Username</th>
		<th class=white  valign=top>Level</th>

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
			<td valign=top>$full_name <BR><B>$username</td>
			<td valign=top>$access_level</td>
			";		
			echo "
			<td  valign=top ALIGN=left>";
				echo"
				<a href=$PHP_SELF?act=update&user_id=$id><img src=../images/button_edit.gif border=0></a><br><br>
				<a href=$PHP_SELF?act=delete&user_id=$id onClick=\"javascript:return confirm('Anda Yakin Menghapus Data ini?');return false;\"><img src=../images/button_delete.gif border=0></a>";

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