<?php
//error 200: fallo general en asignacion de sensores
//error 101: falta de parametro en request
    session_start();
    require_once "php/InputData.php";
    require_once "php/BicicletaDB.php";
    
    $db = new BicicletaDB();
    $response = array("error" => false);

    if($INPUT->contains('acc') && $INPUT->contains('gyro')){
        $acc = $INPUT->get('acc');
        $gyro = $INPUT->get('gyro');
        
        $sensor = array_merge($acc, $gyro);
        //var_dump( $sensor);
        $res = $db->setSensor($sensor);
        
        if($res){
            $response["error"] = false;
            $response["success"] = true;
        }
        else{
            $response["error"] = true;
            $response["error_code"] = 200 ; 
        }
       
    }else{
        $response["error"] = true;
         $response["error_code"] = 101 ; 
    }
    echo json_encode($response);

?>