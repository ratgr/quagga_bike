
<?php
class BicicletaDB{
    private static $servername = "localhost";
    private static $username = "quagga_user";
    private static $password = "KsvocXKuPW44";
    private static $database = "quagga_db";
    
    public static function GetDB(){
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$database);
        if ($conn->connect_error) {
            throw new Exception("Failed to Connect to DataBase::" .  $conn->connect_error);  
        } 

        return $conn;
    }

    private $conn;
    function __construct() {
        $this->conn = self::GetDB();
    }

    public function getUser($username, $password){
        $conn = $this->conn;
        //echo  "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");

        $stmt->bind_param("s", $username);

        //echo htmlspecialchars($conn->error);
        //echo "antes de ejecutar";
        if($stmt->execute()){
            //$result = $stmt->get_result();
            //echo "result";
            
            $stmt->bind_result($binded_username, $binded_pass);
            $stmt->fetch();
            $user = array("username" => $binded_username, "password" => $binded_pass);
            //$user = $result->fetch_assoc();
            //echo "fetch";
            //echo "<p>user password:" .  $binded_username . "," . $binded_pass ."<p>";
            if($user['password'] != $password) return false;
            $stmt->close();
            return $user;
        }else{
            return false;
        }
    }
    public function makeUser($username, $password){
        $conn = $this->conn;
        //echo  "SELECT * FROM users WHERE username=?";
        
        $stmt = $conn->prepare("INSERT INTO users (username, password) Values (?, ?)");
        //var_dump($stmt);
       
        $stmt->bind_param("ss", $username, $password);
        //echo htmlspecialchars($mysqli->error);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function hasUsername($username){
         $conn = $this->conn;
         $stmt = $conn->prepare("SELECT count(1) as count FROM users WHERE username=?");
         $stmt->bind_param("s", $username);
         if($stmt->execute()){
            $stmt->bind_result($count);
            $stmt->fetch();
          
            // $value = $stmt->get_result()->fetch_assoc();
            //return $value['count'];
            return $count;
        }else{
            return false;
        }
    }
    public function hasEmail($email){
         $conn = $this->conn;
         $stmt = $conn->prepare("SELECT count(1) as count FROM users WHERE email=?");
         $stmt->bind_param("s", $email);
         if($stmt->execute()){
            
          
            // $value = $stmt->get_result()->fetch_assoc();
            //return $value['count'];
            $stmt->bind_result($count);
            $stmt->fetch();
            return $count;
        }else{
            return false;
        }
    }

}
?>

