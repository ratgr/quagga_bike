<?php
    session_start();
    require_once "php/InputData.php";
    require_once "php/BicicletaDB.php";
    
    $db = new BicicletaDB();
    $response = array("error" => false);

    if($INPUT->contains('username')) $username = $INPUT->get('username');

    if($INPUT->contains('password')) $password = $INPUT->get('password');

    if(isset($username) && isset( $password )){
        $result = $db->makeUser($username, $password);
       
        if($result!= false){
            $_SESSION["username"] = $username;
            $response["username"] = $username;
            
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "No se pudo crear el usuario " . $username;
            
        }
    } else {
        // required post params is missing
        $response["error"] = TRUE;
        $response["error_msg"] = "Parametros Faltantes, Usuario o contraseña no especificados!"; 
    }
    echo json_encode($response);

?>