<?php
require_once __DIR__ . "/../php/MigrationBase.php";

class RoutesTable extends MigrationBase{
    public function TableName(){
		return "routes";
	}
    public function version(){
		return "0.0.3";
	}
    public function populate(){
	}
    public function up(){
		$conn = $this->conn;
		
		$conn->query(
            "CREATE TABLE routes
             (  
                id INT NOT NULL AUTO_INCREMENT,
                timestamp_start TIMESTAMP NOT NULL,
                timestamp_end TIMESTAMP NOT NULL
             )");
	}

    public function update($version){
		return false;
	}

}

return new RoutesTable();