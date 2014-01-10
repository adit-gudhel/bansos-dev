<?

ob_start();

$output = "DEBUG ".date('Y-m-d H:i:s')." =======================================================================";

function xmlspecialchars($text) {
   //return str_replace(''', '&apos;', htmlspecialchars($text, ENT_QUOTES));
   
   return htmlspecialchars($text, ENT_QUOTES);
}

require_once("lib/nusoap.php");
require_once("../s/config.php");

$s = new soap_server;

$s->configureWSDL('spkt', 'urn:spkt');

//===============================================================================================================

$s->wsdl->addComplexType(
    'Request',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'table' => array('name' => 'table', 'type' => 'xsd:string'),
        'key' => array('name' => 'key', 'type' => 'xsd:string'), 
		'rows' => array('name' => 'rows', 'type' => 'xsd:anytype')
    )
);

$s->wsdl->addComplexType(
    'Response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'status' => array('name' => 'status', 'type' => 'xsd:string')
    )
);

//======================================================================================================

$s->register(
	'sync_data',
	array(
        'Request' => 'tns:Request'
    ),
	array(
        'Response' => 'tns:Response', 
    ),
	'urn:spkt',
	'urn:spkt#sync_data',
	'rpc',
	'encoded'
);


//=========================================================================================================


function sync_data($Request) {

    global $db;
    
    $table = $Request['table'];
    $primarykey = $Request['key'];
    $jrows = $Request['rows'];
    
    
    $rows = json_decode($jrows);
    foreach($rows as $row) {
        unset($columns, $values);
        foreach($row as $key=>$val) {
            
            if (!preg_match('/id/', $key)) {
                $$key = $val;
                $columns .= $key.", ";
                $values .= "'".rawurldecode($val)."', ";
            }
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        
        $sql = "DELETE FROM $table WHERE $primarykey='".$$primarykey."'";
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
        
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        #die($sql);
        $result=$db->Execute($sql);
        if(!$result){ print $db->ErrorMsg(); die(); }
    }
    
	return array (
            'status' => 1,
            );
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$s->service($HTTP_RAW_POST_DATA);

/*
$output .= "\n";
$fp = fopen('./debug_server.txt', 'a');
fwrite($fp, $output);
fclose($fp);
*/
?>