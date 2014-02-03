<?
include("$DOCUMENT_ROOT/s/connection.php");

//Define Database Connection
$dbhostname		= "localhost";
$dbusername		= "root";
$dbpassword		= "";
$dbname		= "bansos";

//Define Server Connection
//$serverhostname = "10.200.252.60";
//$serverport     = "80";

//Define Variables
$site_title		= "Sistem Informasi Bantuan Sosial Pemerintah Kota Bogor";
$assoc_case		= 'lower';			// upper or lower
$code_prefix	= 'WF';
//$upload_path	= 'docs/upload/';

define('UPLOAD_PATH','docs/upload/');

//Set DOCUMENT_ROOT untuk include
$URL_ROOT		= "/workflow";
$sessionCookie	= "bansos_session_id";

include("$DOCUMENT_ROOT/s/lang_id.php");
//Include Class
include "$DOCUMENT_ROOT/classes/adodb/adodb.inc.php";
include "$DOCUMENT_ROOT/s/template.php";
include "$DOCUMENT_ROOT/classes/functions.php";

//Init Class
$t		= new template;
$f		= new functions;

//Database Connection
//Oracle
#$db		= ADONewConnection('oci8');
#$db->PConnect($dbhostname, $dbusername, $dbpassword);
#$db->SetFetchMode(ADODB_FETCH_ASSOC);

// MySQL
$db	= &ADONewConnection('mysql');
$db	->Connect($dbhostname,$dbusername,$dbpassword,$dbname);
$db	->SetFetchMode(ADODB_FETCH_ASSOC);

session_start();

?>