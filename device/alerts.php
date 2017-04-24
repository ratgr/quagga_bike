<?php
    session_start();
    require_once "../php/InputData.php";
    require_once "../php/BicicletaDB.php";

    $response_fn = function() use ($INPUT){
        $db = new BicicletaDB();
        if(!isset($_SESSION["user_id"]))
            return ["error" => true, "error_msg" => "needs authentication"];
        if($INPUT->contains("start"))
            return ["error" => true, "error_msg" => "missing parameter 'start'"];
        
        $user_id = $_SESSION["user_id"];
        $start = $INPUT->get("start");


        return ["error" => false, "alert" => $db->getAlert($user_id, $start)];
       
    };

    echo json_encode($response_fn());