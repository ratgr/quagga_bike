<?php
    session_start();
    require_once "php/InputData.php";
    require_once "php/BicicletaDB.php";
    
    $db = new BicicletaDB();
    $response = array("error" => false);
    $response = call_function($INPUT, $db, $INPUT->get("function"));
    echo json_encode($response);
    
    function call_function($INPUT,$db, $function)
    {
        switch ($function){
            case "check_email" :{
                if(!$INPUT->contains('email')) 
                    return setError("required email is missing");
                return setValue(array("available" => $db->hasEmail($INPUT->get("email")) == 0));
            }
            case "get_config" : {
                //checar usuario
                $config = $db->getConfig(0);
                if($config == false) return setError("query failed!");
                return setValue(array("config" => $config));
            }
            case "get_Emergency" : {
                //checar usuario
                $config = $db->getEmergency();
                if($config == false) 
                    return setError("query failed!");
                return setValue($config);
            }
            case "unset_emergency" :{
                
                $config = $db->unsetEmergency();
                if($config == false) 
                    return setError("query failed!");
                return setValue(array("unset" => 1));
            }
            case "set_telefono":{
                if(!$INPUT->contains('telefono')) 
                    return setError("required parameter 'telefono' is missing" );
                return setValue(array(
                    "success" => $db->setNumber($INPUT->get('telefono'))
                ));
            }
            case "set_mode":{
                if(!$INPUT->contains('mode')) 
                    return setError("required parameter 'mode' is missing");
                 return setValue(array(
                    "success" => $db->setMode($INPUT->get('mode'))
                ));
            }
            default:
                return setError("unknown or empty function");
        }
        
    }

    function setError($error_msg){
        return array( "error" => true, "error_msg"=> $error_msg) ;
    }
    function setValue($array){
        return array_merge(array("error"=>false),$array);   
    }

?>