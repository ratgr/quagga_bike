<?php

    class DBAuth{

        private static $servername = "localhost";
        private static $username = "quagga_user";
        private static $password = "KsvocXKuPW44";
        private static $database = "quagga_db";
        protected $conn;
        
        public static function GetDB(){
            $env = (include_once "../.env.php")->database;


            $conn = new mysqli($env->$servername, $env->$username, $env->$password, $env->$database);
            if ($conn->connect_error) {
                throw new Exception("Failed to Connect to DataBase::" .  $conn->connect_error);  
            } 

            return $conn;
        }
        
        function __construct() {
            $this->conn = self::GetDB();
        }
    }  

?>