<?php

require 'classes/Wishlist.php';

$product_id = $_GET['product_id'];

$wishlist = new Wishlist();
$wishlist->removeWishlist($product_id);

header("Location: index.php");

?>