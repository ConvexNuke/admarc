<?php
include('includes/header.php');
if (!isset($_GET['product']) || empty($_GET['product']) || !is_numeric($_GET['product'])) {
    ?>
    <script>
        window.location = 'index.php';
    </script>
    <?php

}

$product_id = addslashes($_GET['product']);
$product = $operation->retrieveSingle(
    "SELECT *
                FROM admarc_products 
                WHERE product_id =  '$product_id'
            ");
$category_id = $product['category_id'];
$products = $operation->retrieveMany(
    "SELECT *
                FROM admarc_products
                WHERE qty_remaining > 0 AND category_id = '$category_id'
            ");
?>


<div class="hero-wrap hero-bread" style="background-image: url('images/category-4.jpg'); ">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span>
                    <span>View Product </span></p>
                <h1 class="mb-0 bread">View Product</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="images/product-1.jpg" class="image-popup"><img height="250px" width="250px"
                                                                        src="../admin/assets/images/products/<?= $product['img_url'] ?>"
                                                                        class="img-fluid"
                                                                        alt="Product Image"/></a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3><?= $product['product_name'] ?></h3>
                <!--  <div class="rating d-flex">
                      <p class="text-left mr-4">
                          <a href="#" class="mr-2">5.0</a>
                          <a href="#"><span class="ion-ios-star-outline"></span></a>
                          <a href="#"><span class="ion-ios-star-outline"></span></a>
                          <a href="#"><span class="ion-ios-star-outline"></span></a>
                          <a href="#"><span class="ion-ios-star-outline"></span></a>
                          <a href="#"><span class="ion-ios-star-outline"></span></a>
                      </p>
                      <p class="text-left mr-4">
                          <a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>
                      </p>
                      <p class="text-left">
                          <a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></a>
                      </p>
                  </div> -->
                <p class="price"><span>K <?= number_format($product['selling_price'], 2) ?></span></p>

                <div class="row mt-4">
                    <!--<div class="col-md-6">
                        <div class="form-group d-flex">
                            <div class="select-wrap">
                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                <select name="" id="" class="form-control">
                                    <option value="">Small</option>
                                    <option value="">Medium</option>
                                    <option value="">Large</option>
                                    <option value="">Extra Large</option>
                                </select>
                            </div>
                        </div>
                    </div>-->
                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
	             	<span class="input-group-btn mr-2">
	                	<button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
	                   <i class="ion-ios-remove"></i>
	                	</button>
	            		</span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1"
                               min="1" max="<?= $product['qty_remaining'] ?>">
                        <span class="input-group-btn ml-2">
	                	<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
	                     <i class="ion-ios-add"></i>
	                 </button>
	             	</span>
                        <input type="hidden" value="<?= $product['qty_remaining'] ?>" id="maxProd"/>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <p style="color: #000;"><?= $product['qty_remaining'] ?> available</p>
                    </div>
                </div>
                <p><a href="#"
                      onclick="addToCart('<?= $product['product_id'] ?>', '<?= $product['product_name'] ?>', '<?= $product['selling_price'] ?>', 'input')"
                      class="btn btn-black py-3 px-5 buy-now">Add to Cart</a></p>
            </div>
        </div>
    </div>
</section>


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
                            <h3><a href="#">Strawberry</a></h3>
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
                                    <a href="cart.php"
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

<script>
    $(document).ready(function () {

        var quantitiy = 0;
        $('.quantity-right-plus').click(function (e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            var maxProd = parseInt($('#maxProd').val());

            if ((quantity + 1) <= maxProd) {

                // If is not undefined
                $('#quantity').val(quantity + 1);
            } else {
                // alert('bigg')
            }


            // Increment

        });

        $('.quantity-left-minus').click(function (e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 1) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>

