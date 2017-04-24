<?php
    session_start();
    require_once "php/InputData.php";
    require_once "php/BicicletaDB.php";
    
    $db = new BicicletaDB();
    $response = array("error" => false);

    if($INPUT->contains('username')) $username = $INPUT->get('username');
    if($INPUT->contains('password')) $password = $INPUT->get('password');

    if(isset($username) && isset( $password )){
        $user = $db->getUser($username, $password);
       
        if($user != false){
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $user["id"];
            $response["username"] = $username;
            
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "El Password o Contraseña son incorrectos, por favor intente de nuevo";
            
        }
    } else {
        // required post params is missing
        $response["error"] = TRUE;
        $response["error_msg"] = "Required parameters email or password is missing!"; 
    }
    echo json_encode($response);