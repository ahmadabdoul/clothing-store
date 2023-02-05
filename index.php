<?php

include_once 'header.php';
include_once 'classes/Category.php';
include_once 'classes/Wishlist.php';

?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <li><a href="index.php">All</a></li>
                                                <?php
                                         $wishlist = new Wishlist();
                                        $category = new Category();
                                        $categories = $category->getCategoriesWithCount();
                                         foreach ($categories as $cat) {
                                     echo '<li><a href="index.php?c=' . $cat['category'] . '">' . $cat['category'] . ' (' . $cat['count'] . ')</a></li>';
                                    }
                                         ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                               
                               
                               
                      
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1–12 of 126 results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select>
                                        <option value="">Low To High</option>
                                        <option value="">$0 - $55</option>
                                        <option value="">$55 - $100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                         if (isset($_GET['c'])) {
                            $category = $_GET['c'];
                            //get category id
                            $query = "SELECT id FROM categories WHERE category = '$category'";
                            $result = mysqli_query($conn, $query) or die("An Error Ocurred ".mysqli_error($conn));
                            $row = mysqli_fetch_assoc($result);
                            $category = $row['id'];
                            //get products
                            $query = "SELECT * FROM products WHERE category = '$category'";
                        } else {
                            $query = "SELECT * FROM products";
                        }
                        $result = mysqli_query($conn, $query) or die("An Error Ocurred ".mysqli_error($conn));
                        if(mysqli_num_rows($result)){
                            while($row=mysqli_fetch_assoc($result)){


                        ?>
                        
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item sale">
                                <div class="product__item__pic set-bg" data-setbg="<?php echo $row['image']; ?>">
                                    <span class="label">Sale</span>
                                    <ul class="product__hover">
                                        <?php
                                        if (!$wishlist->isProductInWishlist($row['product_id'])) {
                                          
                                            // product is not in wishlist

                                            ?>
                                            <li><a href="add-to-wishlist.php?product=<?php echo $row['product_id']; ?>"><img src="img/icon/heart.png" alt=""></a></li>
                                      <?php
                                        }
                                        ?>
                                        
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><?php echo $row['name']; ?></h6>
                                    <a href="#" class="add-cart">+ Add To Cart</a>
                                    
                                   
                                    <h5>N<?php echo $row['price']; ?></h5>
                                 
                                </div>
                            </div>
                        </div>
                           <?php
                            }
                        }
                            ?>
                        
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

   <?php
    include 'footer.php';
    ?>