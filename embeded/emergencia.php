<?php
require_once __DIR__ . "/../php/BicicletaDB.php";
require_once __DIR__ . "/../php/InputData.php";

$response = function() use ($INPUT){
    if(!$INPUT->contains('ID')) return error("missing parameter 'ID'");
    if(!$INPUT->contains('GPS')) return error("missing parameter 'GPS'");
    
    $db = new BicicletaDB();

    $result = $db->getEmergencyContacts();
    

    if(!$result) 
        return error('Could not get emergency contacts');
    $setted = $db->setEmergency();

    if(!$setted) 
        return error('Could not set emergency mode');

    return success($result);
};

echo json_encode($response());

function error($error_msg){
    return [
        "error"=> true, 
        "error_msg" => $error_msg, 
        "mirror" => file_get_contents('php://input'), 
        "decoded" => json_decode(file_get_contents('php://input'))
    ];
}
function success($array){
    return array_merge(["error"=> false], $array);
}