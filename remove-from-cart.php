<?php
require_once 'classes/ShoppingCart.php';

if (!isset($_GET['product'])) {
    die("Error: No product id provided.");
}

$product_id = $_GET['product'];

$wishlist = new ShoppingCart();
$wishlist->removeCart($product_id);

header("Location: index.php");
