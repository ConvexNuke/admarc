<?php
include('includes/header.php');
$categories = $operation->retrieveMany("SELECT *FROM product_categories ORDER BY category_name ASC LIMIT 4");
//    print_r($categories[1]);
$products = $operation->retrieveMany(
    "SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0
                AND selling_price IS NOT NULL
                LIMIT 8
            ");
?>

    <section id="home-section" class="hero">
        <div class="home-slider owl-carousel">
            <div class="slider-item" style="background-image: url(images/queue_bg.jpg); ">
                <div class="overlay"></div>
                <div style="background: rgba(0,0,0,0.68); width: 100%">

                    <div class="container">
                        <div class="row slider-text justify-content-center align-items-center"
                             data-scrollax-parent="true">

                            <div class="col-md-12 ftco-animate text-center">
                                <h1 class="mb-2">Avoid Long queues</h1>
                                <h2 class="subheading mb-4">You buy online & we deliver, No need for standing in
                                    queues</h2>
                                <p><a href="#ShopOnline" class="btn btn-primary">Shop Now</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-item" style="background-image: url(images/maize_bg.jpg);">
                <div class="overlay"></div>
                <div style="background: rgba(0,0,0,0.68); width: 100%">
                    <div class="container">
                        <div class="row slider-text justify-content-center align-items-center"
                             data-scrollax-parent="true">

                            <div class="col-sm-12 ftco-animate text-center">
                                <h1 class="mb-2">100% Well Preserved Crops</h1>
                                <h2 class="subheading mb-4">We buy from farmers & sell at an affordable price</h2>
                                <p><a href="#" class="btn btn-primary">View Details</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row no-gutters ftco-services">
                <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services mb-md-0 mb-4">
                        <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-shipped"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Free Shipping</h3>
                            <!--                <span>On order over $100</span>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services mb-md-0 mb-4">
                        <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-diet"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Well Preserved</h3>
                            <!--                <span>Product well package</span>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services mb-md-0 mb-4">
                        <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-award"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Superior Quality</h3>
                            <!--                <span>Quality Products</span>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services mb-md-0 mb-4">
                        <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                            <span class="flaticon-customer-service"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">24/7 Support</h3>
                            <!--                <span>24/7 Support</span>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
if (!empty($categories)) {
    ?>
    <section class="ftco-section ftco-category ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 order-md-last align-items-stretch d-flex">
                            <div class="category-wrap-2 ftco-animate img align-self-stretch d-flex"
                                 style="background-image: url(images/category.jpg);">
                                <div class="text text-center">
                                    <h2>Crops/Products</h2>
                                    <p>Observe COVID-19 by staying at Home</p>
                                    <p><a href="#shopOnline" class="btn btn-primary">Shop Online</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end"
                                 style="background-image: url(../admin/assets/images/products/<?= $categories[0]['category_img'] ?>);">
                                <div class="text px-3 py-1">
                                    <h2 class="mb-0"><a
                                                href="shop.php?category=<?= $categories[0]['category_id'] ?>"><?= $categories[0]['category_name'] . ' <small> (' . $operation->countAll("SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0
                AND selling_price IS NOT NULL AND category_id = '" . $categories[0]['category_id'] . "'
                LIMIT 8") . ' products)</small>' ?></a>
                                    </h2>
                                </div>
                            </div>
                            <div class="category-wrap ftco-animate img d-flex align-items-end"
                                 style="background-image: url(../admin/assets/images/products/<?= $categories[2]['category_img'] ?>);">
                                <div class="text px-3 py-1">
                                    <h2 class="mb-0"><a
                                                href="shop.php?category=<?= $categories[2]['category_id'] ?>"><?= $categories[2]['category_name'] . ' <small> (' . $operation->countAll("SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0
                AND selling_price IS NOT NULL AND category_id = '" . $categories[2]['category_id'] . "'
                LIMIT 8") . ' products)</small>' ?></a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end"
                         style="background-image: url(../admin/assets/images/products/<?= $categories[1]['category_img'] ?>);">
                        <div class="text px-3 py-1">
                            <h2 class="mb-0"><a
                                        href="shop.php?category=<?= $categories[1]['category_id'] ?>"><?= $categories[1]['category_name'] . ' <small> (' . $operation->countAll("SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0
                AND selling_price IS NOT NULL AND category_id = '" . $categories[1]['category_id'] . "'
                LIMIT 8") . ' products)</small>' ?></a>
                            </h2>
                        </div>
                    </div>
                    <div class="category-wrap ftco-animate img d-flex align-items-end"
                         style="background-image: url(../admin/assets/images/products/<?= $categories[3]['category_img'] ?>);">
                        <div class="text px-3 py-1">
                            <h2 class="mb-0"><a
                                        href="shop.php?category=<?= $categories[3]['category_id'] ?>"><?= $categories[3]['category_name'] . ' <small> (' . $operation->countAll("SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0
                AND selling_price IS NOT NULL AND category_id = '" . $categories[3]['category_id'] . "'
                LIMIT 8") . ' products)</small>' ?></a>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>

    <section id="shopOnline" class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Featured Products</span>
                    <h2 class="mb-4">Products/Crops</h2>
                    <!--                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>-->
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!--                <div class="col-md-6 col-lg-3 ftco-animate">-->
                <!--                    <div class="product">-->
                <!--                        <a href="#" class="img-prod"><img class="img-fluid" src="images/product-1.jpg"-->
                <!--                                                          alt="Colorlib Template">-->
                <!--                            <span class="status">30%</span>-->
                <!--                            <div class="overlay"></div>-->
                <!--                        </a>-->
                <!--                        <div class="text py-3 pb-4 px-3 text-center">-->
                <!--                            <h3><a href="#">Bell Pepper</a></h3>-->
                <!--                            <div class="d-flex">-->
                <!--                                <div class="pricing">-->
                <!--                                    <p class="price"><span class="mr-2 price-dc">$120.00</span><span class="price-sale">$80.00</span>-->
                <!--                                    </p>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="bottom-area d-flex px-3">-->
                <!--                                <div class="m-auto d-flex">-->
                <!--                                    <a href="#"-->
                <!--                                       class="add-to-cart d-flex justify-content-center align-items-center text-center">-->
                <!--                                        <span><i class="ion-ios-menu"></i></span>-->
                <!--                                    </a>-->
                <!--                                    <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">-->
                <!--                                        <span><i class="ion-ios-cart"></i></span>-->
                <!--                                    </a>-->
                <!--                                    <a href="#" class="heart d-flex justify-content-center align-items-center ">-->
                <!--                                        <span><i class="ion-ios-heart"></i></span>-->
                <!--                                    </a>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <?php
                foreach ($products as $product) {
                    ?>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="product">
                            <a href="product-single.php?product=<?= $product['product_id'] ?>" class="img-prod"><img
                                        style="height: 150px; width: 180px; display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;" class="img-fluid"
                                        src="../admin/assets/images/products/<?= $product['img_url'] ?>"
                                        alt="Product">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="#"><?= $product['product_name'] ?></a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price">
                                            <span>K<?= number_format($product['selling_price'], 2) ?></span></p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                        <a href="product-single.php?product=<?= $product['product_id'] ?>"
                                           class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                            <span><i class="ion-ios-information-circle"></i></span>
                                        </a>
                                        <a href="#"
                                           onclick="addToCart('<?= $product['product_id'] ?>', '<?= $product['product_name'] ?>', '<?= $product['selling_price'] ?>', 'inline')"
                                           id="btn_cart_add<?= $product['product_id'] ?>"
                                           class="buy-now d-flex justify-content-center align-items-center mx-1">
                                            <span><i class="ion-ios-cart"></i></span>
                                        </a>
                                        <!--                                            <a href="#" class="heart d-flex justify-content-center align-items-center ">-->
                                        <!--                                                <span><i class="ion-ios-heart"></i></span>-->
                                        <!--                                            </a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>


            </div>
        </div>
    </section>


<?php
include('includes/footer.php');
?>