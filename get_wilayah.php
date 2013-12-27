<?
ob_start();
include("$DOCUMENT_ROOT/s/config.php");

$f->checkaccess();

if ($ajaxselect == 'propinsi') {
    $i = 0;
    $response = array();
    $sql = "select kd_dati2 as id, nm_dati2 as label from tbl_dati2 where substr(kd_dati2,1,2)='".$kd_propinsi."'";
    #echo $sql;
    $result=$db->Execute($sql);
    if ($result->RecordCount() == 0) {
        $response[$i]['id'] = 0;
        $response[$i]['text'] = '';
    }
    else {
        while($arr=$result->Fetchrow()){
            foreach($arr as $key => $val){
                $key=strtolower($key);
                $$key=$val;
            }
            $response[$i]['id'] = $id;
            $response[$i]['text'] = $label;
            $i++;
        }
    }
    echo json_encode($response);
    die();
}
else if ($ajaxselect == 'dati2') {
    $i = 0;
    $response = array();
    $sql = "select kd_kecamatan as id, nm_kecamatan as label from tbl_kecamatan where substr(kd_kecamatan,1,4)='".$kd_dati2."'";
    #echo $sql;
    $result=$db->Execute($sql);
    if ($result->RecordCount() == 0) {
        $response[$i]['id'] = 0;
        $response[$i]['text'] = '';
    }
    else {
        while($arr=$result->Fetchrow()){
            foreach($arr as $key => $val){
                $key=strtolower($key);
                $$key=$val;
            }
            $response[$i]['id'] = $id;
            $response[$i]['text'] = $label;
            $i++;
        }
    }
    echo json_encode($response);
    die();
}
else if ($ajaxselect == 'kecamatan') {
    $i = 0;
    $response = array();
    $sql = "select kd_kelurahan as id, nm_kelurahan as label from tbl_kelurahan where substr(kd_kelurahan,1,7)='".$kd_kecamatan."'";
    #echo $sql;
    $result=$db->Execute($sql);
    if ($result->RecordCount() == 0) {
        $response[$i]['id'] = 0;
        $response[$i]['text'] = '';
    }
    else {
        while($arr=$result->Fetchrow()){
            foreach($arr as $key => $val){
                $key=strtolower($key);
                $$key=$val;
            }
            $response[$i]['id'] = $id;
            $response[$i]['text'] = $label;
            $i++;
        }
    }
    echo json_encode($response);
    die();
}
?>
