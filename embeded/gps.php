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
    return success(["value" => ParseGPS($INPUT->get("ID"),$INPUT->get("GPS"))]);
};

echo json_encode($response());

function ParseGPS($id, $gps){
    $array = explode($gps,",");
    //create the date
    $date = DateTime::createFromFormat("DDMMYYHHmmss",$array[9] . $array[1])->format(DateTime::ATOM);
    $lat = ($array[4]=="N" ? 1:-1) * (float)ltrim($array[3]);
    $lon = ($array[6]=="E" ? 1:-1) * (float)ltrim($array[5]);
    $db = new BicicletaDB();
    return $db->addGPS($id,$date,$lat,$lon);
}


function error($error_msg){
    return ["error"=> true, "error_msg" => $error_msg];
}
function success($array){
    return array_merge(["error"=> false], $array);
}