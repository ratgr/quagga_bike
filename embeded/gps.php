<?php
require_once __DIR__ . "/../php/BicicletaDB.php";
require_once __DIR__ . "/../php/InputData.php";
//recibir coordenada gps en 
/*
$GPRMC,123519,A,4807.038,N,01131.000,E,022.4,084.4,230394,003.1,W*6A

Where:
     0 => RMC          Recommended Minimum sentence C
     1 => 123519       Fix taken at 12:35:19 UTC
     2 => A            Status A=active or V=Void.
     3,4 => 4807.038,N   Latitude 48 deg 07.038' N
     5,6 => 01131.000,E  Longitude 11 deg 31.000' E
     7 => 022.4        Speed over the ground in knots
     8 => 084.4        Track angle in degrees True
     9 => 230394       Date - 23rd of March 1994
     10, 11 => 003.1,W      Magnetic Variation
     *6A          The checksum data, always begins with *
*/

$response = function() use ($INPUT){
    if(!$INPUT->contains('ID')) return error("missing parameter 'ID'");
    if(!$INPUT->contains('GPS')) return error("missing parameter 'GPS'");
    $db = new BicicletaDB();
    return success(["ParseGPS" => ParseGPS($INPUT->get("ID"),$INPUT->get("GPS"))]);
};

echo json_encode($response());

function ParseGPS($id, $gps){
    try {
        $array = explode(",",$gps);
    //create the date
    if(count($array) < 10) return ["error"=> true, "error_msg" => "Bad GPS RMC code", "array_count" => count($array), "gpscode" => $gps ];
    if($array[9] == "" ||$array[3] == "" || $array[5] == "" )  return ["error"=> true,  "error_msg" => "Empty RMC code" ];
    $date = DateTime::createFromFormat("dmyHis",$array[9] . $array[1])->format(DateTime::ATOM);
    echo "llegue aqui" . $date;
    $lat = ($array[4]=="N" ? 1:-1) * (float)ltrim($array[3],"0");
    $lon = ($array[6]=="E" ? 1:-1) * (float)ltrim($array[5],"0");
    echo "latitud y longitud: " .  $lat . ", " . $lon;
    $db = new BicicletaDB();
        return $db->addGPS($id,$date,$lat,$lon);
    }
    catch(Exception $e){
        return ["error"=> true, "exception_message" => $e->getMessage(), "error_msg" => "failed to Parse GPS" ];
    }
}


function error($error_msg){
    return ["error"=> true, 
        "error_msg" => $error_msg, 
        "json_error" => JSON_error_string(),
        "mirror" => file_get_contents('php://input'), 
        "decoded" => json_decode(file_get_contents('php://input'))
    ];
}
function success($array){
    return array_merge(["error"=> false], $array);
}

function JSON_error_string(){
     switch(json_last_error()) {
        case JSON_ERROR_NONE:
           return 'JSON_ERROR_NONE';
        case JSON_ERROR_DEPTH:
            return 'JSON_ERROR_DEPTH';
        case JSON_ERROR_STATE_MISMATCH:
            return 'JSON_ERROR_STATE_MISMATCH';
        case JSON_ERROR_CTRL_CHAR:
            return 'JSON_ERROR_CTRL_CHAR';
        case JSON_ERROR_SYNTAX:
            return 'JSON_ERROR_SYNTAX';
        case JSON_ERROR_UTF8:
           return 'JSON_ERROR_UTF8';
        default:
            return 'JSON_ERROR_UNKNOWN';

    }
}