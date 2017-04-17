<?php
    session_start();
    require_once "php/BicicletaDB.php";
    
    $db = new BicicletaDB();
    $response = array("error" => false);


    // if(isset($_SESSION['username'])){
    //     $response["username"] = $_SESSION['username'];
    //      echo json_encode($response);
    //      exit();
    // }
    //echo json_encode($_REQUEST);
    if(isset($_REQUEST['username']))
        $username = $_REQUEST['username'];

    if(isset($_REQUEST['password']))
        $password = $_REQUEST['password'];

    if(isset($username) && isset( $password )){
        $user = $db->getUser($username, $password);
        //echo "username:$_REQUEST[username], password:$_REQUEST[password]," . json_encode($user);
        if($user != false){
            $_SESSION["username"] = $username;
            $response["username"] = $username;
            echo json_encode($response);
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "El Password o Contraseña son incorrectos, por favor intente denuevo";
            echo json_encode($response);
        }
    } else {
        // required post params is missing
        $response["error"] = TRUE;
        $response["error_msg"] = "Required parameters email or password is missing!";
        echo json_encode($response);
    }


?>