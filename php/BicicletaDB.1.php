<?php
require_once "DBAuth.php";
class BicicletaDB extends DBAuth{

    public function getUser($username, $password){
        $conn = $this->conn;
        //echo  "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        //var_dump($stmt);
        echo htmlspecialchars($mysqli->error);
       
        $stmt->bind_param("s", $username);
        //echo htmlspecialchars($mysqli->error);
        if($stmt->execute()){
            $user = $stmt->get_result()->fetch_assoc();
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
            $value = $stmt->get_result()->fetch_assoc();
            return $value['count'];
        }else{
            return false;
        }
    }
    public function hasEmail($email){
         $conn = $this->conn;
         $stmt = $conn->prepare("SELECT count(1) as count FROM users WHERE email=?");
         $stmt->bind_param("s", $email);
         if($stmt->execute()){
            $value = $stmt->get_result()->fetch_assoc();
            return $value['count'];
        }else{
            return false;
        }
    }
}
?>

