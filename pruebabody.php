<?php
    session_start();
    require_once "php/InputData.php";
    require_once "php/BicicletaDB.php";
    
    $db = new BicicletaDB();
    $response = array("error" => false);

    if($INPUT->contains('ID')){
        //$user = $db->getUser($username, $password);
       
       $response["error"] = false;
       $response["data"] = array("ID" => $INPUT->get("ID"));
       $response["contact"] =  $config = $db->getConfig(0)["telefono"];
    } else {
        // required post params is missing
        $response["error"] = TRUE;
        $response["error_code"] = 100 ; 
    }
    echo json_encode($response);