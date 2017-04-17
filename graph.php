<?php

require_once "php/InputData.php";
require_once "php/BicicletaDB.php";

$response_fn = function() use ($INPUT){
    if($INPUT->contains('now')) return["error" => false, "now" => $db->now()];

    if(!$INPUT->contains('start')) 
        return ["error" => true, "error_msg" => "missing parameter start date"];
    $db = new BicicletaDB();
    $points = $db->getSensor($INPUT->get("start"));

    return ["error" => false, "points" => $points];
};

$response = $response_fn();

echo json_encode($response);

