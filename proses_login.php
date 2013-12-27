<?
ob_start();
session_start();
include("$DOCUMENT_ROOT/s/config.php");
if (trim($_POST['username']) == '') {
	$error[] = '- Masukan Username';
}
if (trim($_POST['passwd']) == '') {
	$error[] = '- Masukan Password';
}
$passwd_ori = $_POST[passwd];
$passwd = md5($_POST[passwd]);
$sec = microtime();
mt_srand((double)microtime() * 1000000);
$sec2 = mt_rand(1000, 9999);
$id = md5("$sec2$sec");

$time = explode(" ", microtime());
$timeNow = (double)$time[1];
$ip=$_SERVER['REMOTE_ADDR'];

$password_ori	= $passwd;
$cond_pssw="and password='$passwd'";

$sql	= "select username, password from 
tbl_user where username='$username' $cond_pssw"; //die($sql);
#die($sql);
$resultdb = $f->get_last_record($sql);
foreach($resultdb as $key => $val) $$key = $val;
	if ($password_ori != $password) {
		$error[] = '- Password yang anda masukan salah';
	}if($username != $_POST['username']){
		$error[] = '- Username yang anda masukan salah';
	}

//dan seterusnya

if (isset($error)) {
	echo "<span align=left><b>Error</b>: <br />".implode('<br />', $error)."</span>";
} else {

	$sql	= "select username, password from tbl_user where username='$username ' $cond_pssw"; //die($sql);
	$resultdb = $f->get_last_record($sql);
	foreach($resultdb as $key => $val) $$key = $val;

	$sql = "update tbl_session set status='0' where username='$username' and status='1'";
	$result = $db->Execute($sql);
	if (!$result) print $db->ErrorMsg();

	$strSQL = "insert into tbl_session (session_id, username, last_login, last_access, status,ip,ctime)
					values ('$id','$username',SYSDATE(),'$timeNow','1','$ip',SYSDATE())";
    $result = $db->Execute($strSQL);
    
    $strSQL = "UPDATE tbl_user SET last_login=SYSDATE(), ip='$ip' WHERE username='$username'";
    $result = $db->Execute($strSQL);

	$_SESSION[$sessionCookie]=$id;
		
	$f->insert_log("LOGIN $username","",$username);

	//$f->redirect("1", "menu.php", "<div align=center><img src=/i/loading.gif><br><br>Please wait, Loading Profile..</div>");
	echo "
		<script language=Javascript>
			window.open('/home.php','_parent');
		</script>
		"; 
	//ob_end_flush();
	exit;
}

?>