<?php
require_once __DIR__ . "/../php/MigrationBase.php";

//php -r "(require_once 'BicicletasTable.php')->migrate();"
class BicicletaTable extends MigrationBase{
	
	
	public function TableName(){
		return "bicicletas";
	}
	
	
	public function version(){
		
		return "0.0.0";
	}
	
	
	public function populate(){
		$conn = $this->conn;
		echo "inserting start bike";
		$conn->query(
                "INSERT INTO `bicicletas` (`id`, `telefono`, `serial`, `usuario`) 
                VALUES (1, '', '', 1)");
	}
	
	public function up(){
		$conn = $this->conn;
		
		$conn->query(
            "CREATE TABLE `bicicletas` (
            `id` int(11) NOT NULL,
            `telefono` varchar(150) NOT NULL,
            `serial` varchar(150) NOT NULL,
            `usuario` int(11) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	}
	
	
	public function update($version){
		
		
		return false;
		
		
	}
	
	
}

return new BicicletaTable();

