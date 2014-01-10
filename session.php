<?
//Load Files
include_once ("$DOCUMENT_ROOT/s/config.php");

if ($act == "dologin")  {
	
#die("username: $username");
	if ((!$username)||(!$password)) {
		header("Location: index.php");
		exit();
	}


	//TRIM DATA
	$username = trim($username);
	$password = trim($password);

	//CHECK USERNAME & PASSWORD
	$strSQL		="SELECT *
				from tbl_user 
				WHERE username='$username' and password='".md5($password)."'";
                
	$result		= $db->Execute($strSQL);

	if (!$result) print $db->ErrorMsg();

	$row = $result->FetchRow();
	if(empty($row)) print $db->ErrorMsg();

	$id_exist 	= $row[id];
	$access   	= $row[access_level];
	$department_id	= $row[department_id];
	$grade_code	= $row[grade_code];
	$inquiry_access	= $row[inquiry_access];

	if (empty($id_exist)) {
			header("Location: index.php?message=Invalid+Username+or+Password");
			exit();
	}
	
	$sec=microtime();
	mt_srand((double)microtime()*1000000);
	$sec2 = mt_rand(1000,9999);
	$id=md5("$sec2$sec");

	setcookie("bms_session_id","$id");
	setcookie("login_name",$username);
	setcookie("login_id",$id_exist);
	setcookie("login_access",$access);
	setcookie("login_inquiry_access",$inquiry_access);
	
	$timeNow = $db->DBDate(time());
	$time= explode( " ", microtime());
	$usersec= (double)$time[1];

	$strSQL		= "DELETE FROM tbl_session WHERE username='".$username."'";
	$result		= $db->Execute($strSQL);
	if (!$result) print $db->ErrorMsg();
	$ctime=date("Y-m-d H:i:s");

	$strSQL		= "INSERT INTO tbl_session (session_id, username, last_login,last_access) VALUES ('".$id."','".$username."','$ctime','$usersec')";
	
	$result		= $db->Execute($strSQL);
	if (!$result) print $db->ErrorMsg();

	//update last login @ tbl_user
	$strSQL		= "Update tbl_user set ip='$REMOTE_ADDR',last_login='$ctime' where id='$id_exist'";
	$result		= $db->Execute($strSQL);
	if (!$result) print $db->ErrorMsg();
	$login_name	=$username;
	$login_id	=$id_exist;

	$script = "home.php";

	
	echo"
	<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$script\">"; 
}


if ($act == "logout")  {

	$strSQL		= "DELETE from tbl_session WHERE session_id='".$$sessionCookie."' ";
	$result		= $db->Execute($strSQL);
	if (!$result) print $db->ErrorMsg();
	$f->insert_log("Logout");

	setcookie($appCookie);
	setcookie("login_name","");
	setcookie("login_id","");
	setcookie("login_access","");
	setcookie("login_department","");
	setcookie("login_grade_code","");
	setcookie("login_inquiry_access","");
	header("Location: index.php");

	
}

$db->Close();

?>