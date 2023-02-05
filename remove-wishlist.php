<?php
require_once 'classes/Wishlist.php';

if (!isset($_GET['product'])) {
    die("Error: No product id provided.");
}

$product_id = $_GET['product'];

$wishlist = new Wishlist();
$wishlist->removeWishlist($product_id);

$referrer = $_SERVER['HTTP_REFERER'];
header("Location: $referrer");
