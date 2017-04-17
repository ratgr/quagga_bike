<?php
  //retorna si el email se encuentra en la base de datos
  require_once "php/BicicletaDB.php";
  $db = new BicicletaDB();
  $response = array("error" => false);
  $angular = json_decode(file_get_contents('php://input'), true);
  if(isset($angular['email']))
    $email = $angular['email'];
  if(isset($_REQUEST['email']))
    $email = $_REQUEST['email'];

  //$_POST = json_decode(file_get_contents('php://input'), true);
  if(isset($email)){
    $data =  $db->hasEmail($email);
    $response["available"] = ($data == 0);
  }else{
    $response["error"] = TRUE;
    $response["error_msg"] = "required email is missing";
    $response["encoded"] = json_encode($_POST);
  }
   echo json_encode($response);
?>