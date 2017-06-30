<?php
require_once __DIR__ . "/../php/BicicletaDB.php";
require_once __DIR__ . "/../php/InputData.php";

$response = function() use ($INPUT){
    if(!$INPUT->contains('ID')) return error("missing parameter 'ID'");
       
    $db = new BicicletaDB();
    $result = $db->getEmergency();
    if ($result == false) return error("Query Failed!");
    $db->unsetEmergency();

    return success(["emergencia" => $result["value"]]);
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