<?php
    class InputData{
        private $angular;

        public function __construct() {
            $this->angular = json_decode(file_get_contents('php://input'), true);
        }

        public function get($name){
            if(isset($this->angular[$name])) return $this->angular[$name];
            return $_REQUEST[$name];
        }

        public function contains($name){
            return isset($this->angular[$name]) || isset($_REQUEST[$name]);
        }

        public function hasPayload($name){
            return isset($this->angular[$name]);
        }
    
    }


    $INPUT = new InputData();

?>