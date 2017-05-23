<?php
require_once "DBAuth.php";
class BicicletaDB extends DBAuth{

    public function getUser($username, $password){
        $conn = $this->conn;
        //echo  "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");

        $stmt->bind_param("s", $username);

        //echo htmlspecialchars($conn->error);
        //echo "antes de ejecutar";
        if($stmt->execute()){
            //$result = $stmt->get_result();
            //echo "result";
            
            $stmt->bind_result($binded_id, $binded_username, $binded_pass);
            $stmt->fetch();
            $user = array("id" => $binded_id, "username" => $binded_username, "password" => $binded_pass);
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
    public function getConfig($user){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT telefono, serial, usuario FROM bicicletas WHERE usuario = 1");
        if($stmt->execute()){
            $stmt->bind_result($b_telefono, $b_serial, $b_usuario);
            $stmt->fetch();
            $config = array("telefono" => $b_telefono, "serial" => $b_serial, "usuario" => $b_usuario);
            $stmt->close();

            return $config;
        }else{
            return false;
        }
    }
    public function getmode(){

        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT mode FROM bicicletas WHERE usuario = 1");
        if($stmt->execute()){
            
            $stmt->bind_result($mode);
            $stmt->fetch();
            return $mode;
            
        }else{
            return false;
        }
    }


    public function getAlert($user_id, $start){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT NOW(), text, id, time_stamp FROM alerts WHERE user_id = ? AND time_stamp > ?");
        $stmt->bind_param("is", $user_id, $start);
    }
    public function setSensor($array)
    {
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO sensors Values (?, ?, ?, ?, ?, ?, now())");
        $stmt->bind_param("iiiiii", $array[0], $array[1], $array[2], $array[3], $array[4], $array[5]);
        if(!$stmt->execute()) return false;
        return true;
    }
    public function addGPS($id, $date, $lat, $lon){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO coordinates Values (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id, $lat, $lon, $date);
       
        if(!$stmt->execute()) return false;
        return true;
    }

    public function getSensor($start){
        $conn = $this->conn;

        $stmt = $conn->prepare("SELECT NOW(), a_x, a_y, a_z,g_x, g_y, g_z, time_stamp FROM sensors WHERE time_stamp > ?");
        $stmt->bind_param("s", $start);
        //var_dump($start);
        if(!$stmt->execute()) return false;
        $stmt->bind_result($now, $a_x, $a_y, $a_z, $g_x, $g_y, $g_z, $time_stamp);
        $ret = [];
        while($stmt->fetch())
        {
            $ret[] = [  
                "now" => $now,
                "a_x" => $a_x,  
                "a_y" => $a_y,
                "a_z" => $a_z, 
                "g_x" => $g_x, 
                "g_y" => $g_y, 
                "g_z" => $g_z,
                "time_stamp" => $time_stamp];
        }
       

        return  $ret;
    }
     public function now(){
        $conn = $this->conn;

        $stmt = $conn->prepare("SELECT NOW() FROM sensors");
        //var_dump($start);
        if(!$stmt->execute()) return false;
        $stmt->bind_result($now);
        return  $now;
    }
    public function setNumber($number)
    {
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE bicicletas SET telefono=? WHERE usuario = 1");
        $stmt->bind_param("s", $number);
        if($stmt->execute()) return true;
        else return false;
    }

}
?>

