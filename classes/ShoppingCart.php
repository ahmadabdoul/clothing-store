<?php
require_once 'Database.php';
require_once 'Login.php';

class ShoppingCart {
    private $db;
    private $login;

    public function __construct() {
        $this->db = new Database();
        $this->login = new Login();
    }

    public function addCart($product_id) {
        if ($this->login->isLoggedIn()) {
            $user_id = $this->login->getUserId();
            $conn = $this->db->getConnection();
            $query = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        } else {
            $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], true) : array();
            $wishlist[] = $product_id;
            setcookie("wishlist", json_encode($wishlist), time() + (86400 * 30));
        }
    }

    public function getUserCart() {
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
        } else {
            return json_decode($_COOKIE['wishlist'], true);
        }
    }
    public function removeCart($product_id) {
        if ($this->login->isLoggedIn()) {
            $user_id = $this->login->getUserId();
            $conn = $this->db->getConnection();
            $query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        } else {
            $wishlist = json_decode($_COOKIE['wishlist'], true);
            if (!$wishlist) {
                return;
            }
            $key = array_search($product_id, $wishlist);
            unset($wishlist[$key]);
            setcookie("wishlist", json_encode($wishlist), time() + (86400 * 30), "/");
        }
    }

    public function isProductInCart($product_id) {
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