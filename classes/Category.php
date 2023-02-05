<?php

require_once 'Database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getCategoriesWithCount() {
        $conn = $this->db->getConnection();
        $query = "SELECT categories.category, COUNT(products.product_id) as count
                  FROM categories
                  LEFT JOIN products
                  ON categories.id = products.category
                  GROUP BY categories.category";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->bind_result($category, $count);
        $categories = array();
    while ($stmt->fetch()) {
        $categories[] =  array(
            'category' => $category,
            'count' => $count
        );
    }
    return $categories;
    }
}
