<?php
require_once __DIR__ . "/../php/MigrationBase.php";

//php -r "(require_once 'BicicletasTable.php')->migrate();"
class CoordinatesTable extends MigrationBase{
	
    
	public function TableName(){
		return "coordinates";
	}
	
	
	public function version(){
		return "0.0.3";
	}
	
	
	public function populate(){
	}
	
	public function up(){
		$conn = $this->conn;
		
		$conn->query(
            "CREATE TABLE coordinates 
             (  
				id INT NOT NULL AUTO_INCREMENT,
                id_user INT NOT NULL,
                latitude DECIMAL(64,16) NOT NULL , 
                longitude DECIMAL(64,16) NOT NULL,
                timestamp_create TIMESTAMP NOT NULL
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	}
	
	
	public function update($version){
		
		switch($version){
			case "0.0.2":
				$conn->query("ALTER TABLE coordinates 
				ADD COLUMN id INT NOT NULL AUTO_INCREMENT FIRST,
				ADD PRIMARY KEY (id);");
			return true;
		}

		return false;
		
		
	}
	
	
}

return new CoordinatesTable();

