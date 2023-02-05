<?php
// Path: wishlist.php
include 'header.php';
include_once 'classes/Wishlist.php';

$wishlist = new Wishlist();
$userWishlists = $wishlist->getUserWishlists();


?>
    <!-- Header Section End -->

   

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>

                                <tr>
                                    <th>Product</th>
                                    
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach($userWishlists as $wishlist){
                                    $sql = "SELECT * FROM products WHERE product_id = " . $wishlist;
                                    $result = mysqli_query($conn, $sql) or die("An Error Ocurred ".mysqli_error($conn));
                                    $row = mysqli_fetch_assoc($result);
                                    $product_id = $row['product_id'];
                                    $product_name = $row['name'];
                                    $price = $row['price'];
                                    $image = $row['image'];
                                    ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="<?php echo $image; ?>" alt="">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?php echo $product_name; ?></h6>
                                                <h5>N<?php echo $price; ?></h5>
                                            </div>
                                        </td>
                                       
                                        <td class="cart__price">N<?php echo $price; ?></td>
                                        <td class="cart__close"><a href="remove-wishlist.php?product=<?php echo $product_id; ?>"><i class="fa fa-close"></i></a></td>
                                    </tr>
                                    <?php

                                }
                              ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="index.php">Continue Shopping</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    
                    <div class="cart__total">
                        <h6>Wishlist total</h6>
                        <ul>
                            <?php
                            $total = 0;
                            foreach($userWishlists as $wishlist){
                                $sql = "SELECT * FROM products WHERE product_id = " . $wishlist;
                                $result = mysqli_query($conn, $sql) or die("An Error Ocurred ".mysqli_error($conn));
                                $row = mysqli_fetch_assoc($result);
                                $price = $row['price'];
                                $total += $price;
                            }
                            ?>
                            <li>Subtotal <span>N<?php echo $total; ?></span></li>
                            <li>Total <span>N<?php echo $total; ?></span></li>
                        </ul>
                        <a href="checkout.php" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
<?php

include 'footer.php';

?>