<?php
require_once 'Database.php';
require_once 'Login.php';

class Wishlist {
    private $db;
    private $login;

    public function __construct() {
        $this->db = new Database();
        $this->login = new Login();
    }

    public function addWishlist($product_id) {
        if ($this->login->isLoggedIn()) {
            $user_id = $this->login->getUserId();
            $conn = $this->db->getConnection();
            $query = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        } else {
            //die(isset($_COOKIE['wishlist']));
            $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], true) : array();
            $wishlist[] = $product_id;
            setcookie("wishlist", json_encode($wishlist), time() + (86400 * 30));
        }
    }

    public function getUserWishlists() {
        if ($this->login->isLoggedIn()) {
            $user_id = $this->login->getUserId();
            $conn = $this->db->getConnection();
            $query = "SELECT product_id FROM wishlist WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($product_id);
            $wishlists = array();
            while ($stmt->fetch()) {
                $wishlists[] = $product_id;
            }
            return $wishlists;
        } else if(isset($_COOKIE['wishlist'])) {
            return json_decode($_COOKIE['wishlist'], true);
        }
        else{
            return array();
        }
    }
    public function removeWishlist($product_id) {
        if (!$this->isProductInWishlist($product_id)) {
            return false;
        }
        if ($this->login->isLoggedIn()) {
            $user_id = $this->login->getUserId();
            $conn = $this->db->getConnection();
            $query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo "Prepared statement error: " . $conn->error;
                return false;
            }
            $stmt->bind_param("ii", $user_id, $product_id);
            if (!$stmt->execute()) {
                echo "Execute statement error: " . $stmt->error;
                return false;
            }
        } else {
            $wishlist = json_decode($_COOKIE['wishlist'], true);
            if (!$wishlist) {
                echo "Cookie 'wishlist' not found";
                return false;
            }
            $key = array_search($product_id, $wishlist);
            if ($key === false) {
                echo "Product not found in cookie 'wishlist'";
                return false;
            }
           // die($wishlist[$key]);
            unset($wishlist[$key]);
            //delete the cookie
            setcookie("wishlist", "", time() - 3600);
            //create the cookie again with the new value
            setcookie("wishlist", json_encode($wishlist), time() + (86400 * 30));
            
            
        }
        return true;
    }
    

    public function isProductInWishlist($product_id) {
        if ($this->login->isLoggedIn()) {
            $user_id = $this->login->getUserId();
            $conn = $this->db->getConnection();
            $query = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return true;
            }
        } else {
            if (isset($_COOKIE['wishlist'])) {
                $wishlist = json_decode($_COOKIE['wishlist'], true);
                return in_array($product_id, $wishlist);
            } else {
                return false;
            }
        }
        
    }
    
}    