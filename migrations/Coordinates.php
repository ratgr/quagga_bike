<?php
require_once __DIR__ . "/../php/MigrationBase.php";



//php -r "(require_once 'BicicletasTable.php')->migrate();"
class CoordinatesTable extends MigrationBase{
	
    
	public function TableName(){
		return "coordinates";
	}
	
	
	public function version(){
		return "0.0.0";
	}
	
	
	public function populate(){
	}
	
	public function up(){
		$conn = $this->conn;
		
		$conn->query(
            "CREATE TABLE coordinates 
             (  
                id_user INT NOT NULL,
                latitude DECIMAL NOT NULL , 
                longitude DECIMAL NOT NULL,
                timestamp_create DATE NOT NULL
                )");
	}
	
	
	public function update($version){
		
		
		return false;
		
		
	}
	
	
}

return new CoordinatesTable();

