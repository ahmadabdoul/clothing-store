<?php

require_once 'Database.php';


class SignUp {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function signup($username, $email, $password) {
        $conn = $this->db->getConnection();
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $password);
       
        if($stmt->execute()){
            $_SESSION['user_id'] = $conn->insert_id;
            return true;
        
         } else{

            return false;
        }
    }
}
