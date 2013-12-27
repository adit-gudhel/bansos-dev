<?

/*==============================================================*
 *
 *					Variables Setting
 *
 *==============================================================*/
$server_host = '10.200.252.60';
#$server_host = 'localhost:8007';
$dbhostname	='localhost';
$dbusername	='root';
$dbpassword	='spkt2012';
$dbname		='spktdb';
$dbdriver	='mysql';

/*==============================================================*
 *
 *					DB Connection
 *
 *==============================================================*/ 
$db = mysql_pconnect($dbhostname, $dbusername, $dbpassword);
if (!$db) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname	, $db); 



// Pull in the NuSOAP code
require_once("lib/nusoap.php");

// Create the client instance
$client = new soapclient('http://'.$server_host.'/webservices/syncserver.php?wsdl', true);
// Check for an error
$err = $client->getError();

if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}

//Get last Sync
$sql = "SELECT max(last_sync) as last_sync FROM tbl_syncclient_log";
$result = mysql_query($sql);
$row = mysql_fetch_array($result, MYSQL_ASSOC);

$last_sync = $row['last_sync'];

mysql_free_result($result);

//Get Setting
$sql = "SELECT a.* FROM tbl_syncclient_setting a";
$result = mysql_query($sql);
if (!$result) print mysql_error($db);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $table = $row['table'];
    $primarykey = $row['key'];
    
    echo "$table
";
    
    $rows = array();
    $sql = "SELECT * FROM $table WHERE mtime>'$last_sync'";
    $result1 = mysql_query($sql);
    $row2 = array();
    if ($result1) {
    while ($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)) {
        foreach($row1 as $key1=>$val1) {
            $row2[$key1] = rawurlencode($val1);
        }
        $rows[] = $row2;
    }
    mysql_free_result($result1);
    }
    
    $jrows = json_encode($rows);
    
    // Call the SOAP method
    $request = array('table' => $table, 'key' => $primarykey, 'rows'=>$jrows);
    $result_ws = $client->call('sync_data', array('Request' => $request));
    // Check for a fault
    if ($client->fault) {
        echo 'Fault:';
        print_r($result_ws);
    } else {
        // Check for errors
        $err = $client->getError();
        if ($err) {
            // Display the error
            echo 'Error: ' . $err . '';
        } else {
            // Display the result
            #echo '<h2>Result</h2><pre>';
            #print_r($result_ws);
            #echo '</pre>';
            echo "status: OK
            
";
        }
    }
    
    // Display the request and response
    //echo '<h2>Request</h2>';
    //echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
    //echo '<h2>Response</h2>';
    //echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
    // Display the debug messages
    //echo '<h2>Debug</h2>';
    //echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
    
}
mysql_free_result($result);

//Insert log

$sql = "INSERT INTO tbl_syncclient_log (last_sync) VALUES (NOW())";
$result = mysql_query($sql);
if (!$result) print mysql_error($db);

?>