<?php

require 'classes/ShoppingCart.php';

$product_id = $_GET['product'];

$wishlist = new ShoppingCart();
$wishlist->addCart($product_id);

header("Location: index.php");

?>