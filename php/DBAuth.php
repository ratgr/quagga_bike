<?php

class DBAuth{

	protected $conn;
	
	
	public static function GetDB(){
		
		$env = (include_once __DIR__ . "/../config.php")->database;
		
		
		
		$conn = new mysqli($env->servername, $env->username, $env->password, $env->database);
		
		if ($conn->connect_error) {
			
			throw new Exception("Failed to Connect to DataBase::" .  $conn->connect_error);
			
		}
		
		
		return $conn;
		
	}
	
	
	function __construct() {
		
		$this->conn = self::GetDB();
		
	}
	
}
