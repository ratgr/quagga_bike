<?php
  //retorna si el username se encuentra en la base de datos
  require_once "php/BicicletaDB.php";
  require_once "php/InputData.php";

  $db = new BicicletaDB();
  $response = array("error" => false);
  $angular = json_decode(file_get_contents('php://input'), true);
  
  if($INPUT->contains('username')){
     $data =  $db->hasUsername($INPUT->get('username'));
     $response["available"] = ($data == 0);
  }else {
    $response["error"] = TRUE;
    $response["error_msg"] = "required username is missing";
    $response["encoded"] = json_encode($_POST);
  }
  echo json_encode($response);
?>