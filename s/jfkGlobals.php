<?

include_once ("$DOCUMENT_ROOT/s/connection.php");

//db
$dbtype = 'MYSQL';

if ($dbtype == 'MYSQL') {
$GS["dbtype"]				= "MYSQL";
$GS["dbhost"]				= $dbhostname;
$GS["dbuser"]				= $dbusername;
$GS["dbpass"]				= $dbpassword;
$GS["dbname"]				= $dbname;
}

if ($dbtype == 'ORACLE') {
$GS["dbtype"]				= "ORACLE";
$GS["dbhost"]				= $dbhostname;
$GS["dbuser"]				= $dbusername;
$GS["dbpass"]				= $dbpassword;
$GS["dbname"]				= $dbname;
}

//general config
$GS["tbl_picture"]		= "tbl_pictures";
$GS["tbl_visitlog"]		= "tbl_visitlog";
$GS["sitename"]			= "SISKKA - Sistem Keuangan Kepegawaian dan Aktiva";
$GS["sitekey"]			= "06088b937594915869b552927d21eebc";
$GS["logvisit"]			= true;
$GS["cmspath"]			= "AdminStudio";
$GS["imgpath"]			= "img";
$GS["downloadpath"]		= "downloads";
$GS["thumbpath"]		= "img/th";
$GS["dbaurl"]			= "http://".$_SERVER['HTTP_HOST']."/".$GS["cmspath"]."/phpMyAdmin/";

//RPC
$GS["xmlrpc_server"]	= "127.0.0.1";
$GS["xmlrpc_port"] 		= "55000";

//include("themes/orange.php");
$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];

include("themes/default.php");

?>
