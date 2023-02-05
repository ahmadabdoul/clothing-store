<?php

require 'classes/Wishlist.php';

$product_id = $_GET['product'];

$wishlist = new Wishlist();
$wishlist->addWishlist($product_id);

header("Location: index.php");

?>