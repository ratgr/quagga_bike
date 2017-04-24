<?php
require_once "DBAuth.php";

abstract class MigrationBase extends DBAuth{
	

    public function migrate(){
        $conn = $this->conn;
        $this->initialize_migration_table();
        //checa si la tabla esta en la lista de migraciones
        $stmt = $conn->prepare("SELECT table_version FROM migration_table WHERE table_name = '" . $this->TableName()."'");
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows == 0) //si no esta en la lista de migraciones
            $this->prepare_up();
        else{
            //si se encuentra en la lista hacemos un update
            $stmt->bind_result($res_version);
            //si no se logra hacer el update hacemos drop y luego subimos
            print "trying to update the database " . $this->TableName().PHP_EOL;
            if(!$this->update($res_version));
            {
               $this->prepare_up();
            }     
        }
        
        $s = "INSERT INTO migration_table VALUES ( '" . $this->TableName() . "', '" . $this->version() . "') ON DUPLICATE KEY UPDATE table_version = '" . $this->version()."'";
        $stmt = $conn->query($s);
        if(!$stmt)
            throw new Exception( $s);
        
        $this->populate();

    }

    private function prepare_up(){
        print "droping the database " . $this->TableName().PHP_EOL;
        $this->down();
        print "Creating the database " . $this->TableName().PHP_EOL;
        $this->up();
    }

    protected function initialize_migration_table(){
        $conn = $this->conn;
        $conn->query("SHOW TABLES LIKE 'migration_table'");
        if( $conn->affected_rows == 0)
             $conn->query("CREATE TABLE migration_table(table_name varchar(100) UNIQUE, table_version TEXT)");

    }

   public function populate(){

   }
   public function TableName(){
        throw "Not Implemented";
    }
    public function version(){
        return "0.0.0";
    }
    public function up(){
        echo "Function not implemented yet!";
    }
    public function update($version){
         echo "Function not implemented yet!";
    }
    
    public function down(){
       $conn = $this->conn;
       $conn->query("SHOW TABLES LIKE '" . $this->TableName() . "'");
       if( $conn->affected_rows > 0)
            $conn->query("DROP TABLE ". $this->TableName());
    }
	
}
