<?php
include('includes/header.php');
$cart_checkout = '';
$cart_total = 0;
?>

<div class="hero-wrap hero-bread" style="background-image: url('images/category-4.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
                <h1 class="mb-0 bread">My Cart</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <p style="width: 100%;" id="response">
                        <?php

                        $error = (isset($_GET['error']) && !empty($_GET['error'])) ? '<span class="text-center text-danger">' . $_GET['error'] . '</span>' : '';
                        $success = (isset($_GET['success'])  && !empty($_GET['success'])) ? '<span class="text-center text-success">' . $_GET['success'] . '</span>' : '';
                        echo $error;
                        echo $success;
                        ?>
                    </p>
                    <?php

                    if (isset($_SESSION['cart_customer'])) {
                        if (count($_SESSION['cart_customer']) > 0) {
                            ?>
                            <table class="table">
                                <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>&nbsp;</th>
                                    <th>Product name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($_SESSION['cart_customer'] as $item) {

                                    $prod_id = $item['prod_id'];
                                    $product_name = $item['product_name'];
                                    $price = $item['price'];
                                    $qty = $item['qty'];
                                    $cart_total += ($price * $qty);

                                    ?>
                                    <tr id="cartRow<?= $prod_id ?>" class="text-center">
                                        <td class="product-remove"><a class="rmCrt"
                                                                      onclick="deleteFromCart('<?= $prod_id ?>')"
                                                                      href="#"><span class="ion-ios-close"></span></a>
                                        </td>


                                        <td class="product-name">
                                            <h3><?= $product_name ?></h3>
                                        </td>

                                        <td class="price">K<?= number_format($price, 2) ?></td>

                                        <td class="quantity">
                                            <div class="input-group mb-3">
                                                <input readonly type="text" name="quantity"
                                                       class="quantity form-control input-number"
                                                       value="<?= $qty ?>" min="1" max="100">
                                            </div>
                                        </td>

                                        <td class="total">K<?= number_format($qty * $price, 2) ?></td>
                                    </tr><!-- END TR-->

                                    <?php
                                }

                                ?>

                                </tbody>
                            </table>
                            <?php
                            $cart_checkout = '
                                <div class="row justify-content-end">
                                    <div class="col-lg-4 mt-5 ftco-animate">
                                       
                                    </div>
                                    <div class="col-lg-4 mt-5 ftco-animate">
                                       
                                    </div>
                                    <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
                                        <div class="cart-total mb-3">
                                            <h3>Cart Totals</h3>
                                            
                                            <p class="d-flex">
                                                <span>Delivery</span>
                                                <span>K 0.00</span>
                                            </p>
                                           
                                            <hr>
                                            <p class="d-flex total-price">
                                                <span>Total</span>
                                                <span id="cart_total">K ' . number_format($cart_total, 2) . '</span>
                                            </p>
                                        </div>
                                        <p><a href="checkout.php" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
                                    </div>
                                </div>
                            ';
                        } else {
                            echo '<p class="text-center alert alert-warning">No products in cart!</p>';
                        }
                    } else {
                        echo '<p class="text-center alert alert-warning">No products in cart!</p>';
                    }
                    ?>

                </div>
            </div>
        </div>


        <?= $cart_checkout ?>
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

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function (e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>

</body>
</html>