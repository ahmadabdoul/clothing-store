<?php

require 'classes/ShoppingCart.php';

$product_id = $_GET['product'];

$wishlist = new ShoppingCart();
$wishlist->addCart($product_id);

$referrer = $_SERVER['HTTP_REFERER'];
header("Location: $referrer");
?>