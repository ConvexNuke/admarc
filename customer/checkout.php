<?php
include('includes/header.php');
$cart_checkout = '';
$cart_total = 0;
$req_url = 'https://v6.exchangerate-api.com/v6/33324d2c592428071aaf4ddc/latest/MWK';
$response_json = file_get_contents($req_url);
$responses = json_decode($response_json);
?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Checkout</span>
                </p>
                <h1 class="mb-0 bread">Checkout</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <p style="width: 100%;" id="response">
            <?php

            $error = (isset($_GET['error']) && !empty($_GET['error'])) ? '<span class="text-center text-danger">' . $_GET['error'] . '</span>' : '';
            $success = (isset($_GET['success']) && !empty($_GET['success'])) ? '<span class="text-center text-success">' . $_GET['success'] . '</span>' : '';
            echo $error;
            echo $success;
            ?>
        </p>
        <form action="process/checkout.php" enctype="multipart/form-data" method="post" id="checkoutForme"
              class="billing-form">
            <div class="row justify-content-center">
                <div class="col-xl-7 ftco-animate">

                    <h3 class="mb-4 billing-heading">Customer Details</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input id="fname" name="fname" type="text" class="form-control" placeholder=""
                                       required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input id="lname" name="lname" type="text" class="form-control" placeholder=""
                                       required/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control" placeholder=""
                                       required/>
                            </div>
                        </div>
                        <!-- <div class="w-100"></div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <label for="country"></label>
                                 <div class="select-wrap">
                                     <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                     <select name="" id="" class="form-control">
                                         <option value="">France</option>
                                         <option value="">Italy</option>
                                         <option value="">Philippines</option>
                                         <option value="">South Korea</option>
                                         <option value="">Hongkong</option>
                                         <option value="">Japan</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <div class="w-100"></div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="streetaddress">Street Address</label>
                                 <input type="text" class="form-control" placeholder="House number and street name">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <input type="text" class="form-control"
                                        placeholder="Appartment, suite, unit etc: (optional)">
                             </div>
                         </div>
                         <div class="w-100"></div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="towncity">Town / City</label>
                                 <input type="text" class="form-control" placeholder="">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="postcodezip">Postcode / ZIP *</label>
                                 <input type="text" class="form-control" placeholder="">
                             </div>
                         </div>
                         <div class="w-100"></div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label for="phone">Phone</label>
                                 <input type="text" class="form-control" placeholder="">
                             </div>
                         </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailaddress"> Address</label>
                                <textarea class="form-control" placeholder="" id="address" name="address"
                                          required></textarea>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <!--                                    <div class="radio">-->
                                <!--                                        <label><input type="radio" value="create" checked id="optradio1" name="optradio"> Guest Account</label>-->
                                <!--                                        <label class="mr-3"><input type="radio" value="guest" id="optradio1" name="optradio"> Create-->
                                <!--                                            an Account? </label>-->
                                <!--                                    </div>-->
                            </div>
                        </div>
                    </div>

                </div>

                <?php
                if (isset($_SESSION['cart_customer'])) {
                if (count($_SESSION['cart_customer']) > 0) {


                    foreach ($_SESSION['cart_customer'] as $item) {

                        $prod_id = $item['prod_id'];
                        $product_name = $item['product_name'];
                        $price = $item['price'];
                        $qty = $item['qty'];
                        $cart_total += ($price * $qty);

                    }
                } else {
                if (!empty($success)) {
                    ?>
                    <script>
                        window.location = 'cart.php?success=<?=$success?>';
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        window.location = 'cart.php?error=<?=$error?>';
                    </script>
                <?php
                }

                }
                } else {
                if (!empty($success)) {
                ?>
                    <script>
                        window.location = 'cart.php?success=<?=$success?>';
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        window.location = 'cart.php?error=<?=$error?>';
                    </script>
                    <?php
                }
                }

                $base_price = $cart_total; // Your price in USD
                $USD_price = round(($base_price * $responses->conversion_rates->USD), 2);
                ?>

                <input type="hidden" id="paypal_amount" value="<?= $USD_price ?>">
                <div class="col-xl-5">
                    <div class="row mt-5 pt-3">
                        <div class="col-md-12 d-flex mb-5">
                            <div class="cart-total mb-3">
                                <h3>Cart Totals</h3>

                                <p class="d-flex">
                                    <span>Delivery</span>
                                    <span>K 0.00</span>
                                </p>

                                <hr>
                                <p class="d-flex total-price">
                                    <span>Total</span>
                                    <span>K <?= number_format($cart_total, 2) ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="cart-detail p-3 p-md-4">
                                <h3 class="billing-heading mb-4">Payment Method</h3>

                                <div class="form-group">

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="radio">
                                                <label><input checked type="radio" value="Cash"
                                                              name="payment_type" id="cash" class="mr-2"> Cash</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input value="Airtel Money | TNM Mpamba" type="radio"
                                                          name="payment_type" class="mr-2">
                                                Airtel Money/Mpamba(0994040828/0884040828)</label>
                                        </div>
                                        <div class="row" id="mobile_money">

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input value="PayPal | Visa" type="radio"
                                                          name="payment_type" class="mr-2">
                                                PayPal/Visa</label>
                                        </div>

                                    </div>


                                </div>


                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label><input required type="checkbox" id="terms" value="" class="mr-2">
                                                I have
                                                read and accept
                                                the
                                                terms and conditions</label>
                                        </div>
                                    </div>
                                </div>

                                <p>
                                    <button id="loginBtn" type="submit" class="btn btn-primary py-3 px-4">Place an
                                        order
                                    </button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div> <!-- .col-md-8 -->

            </div>
        </form><!-- END -->
    </div>
</section> <!-- .section -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proceed to PayPal | Visa Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="paypal-button-container"></div>
            </div>

        </div>
    </div>
</div>
<?php
include('includes/footer.php');

?>
<script
        src="https://www.paypal.com/sdk/js?client-id=AbQcSwlh_LqOgO7WnEJ4jypN_rISO3ThLz_08Lax9x8bEPblHgja_aA1Bl3Mmlbac1rtY_U6kCVdiu9v&commit=false&components=buttons"> // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
</script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
    $("input[name='payment_type']").change(
        function (e) {
            // your stuffs go here
            // alert($("input[name='payment_type']:checked").val())
            if ($("input[name='payment_type']:checked").val() == 'Airtel Money | TNM Mpamba') {
                $('#mobile_money').html('<div class="col-md-10"><div class="form-group"><small>Transaction Screenshot</small><input type="file" class="form-control" placeholder="Screenshot" name="transaction_screenshot" required/></div><div class="form-group"><input type="text" class="form-control" placeholder="Transaction Reference Number" name="transaction_number" required></div></div>')
                // alert('Approval of mobile money may take up to 24hours')
                alertify.alert("", "Approval of mobile money may take up to 24hours");
            } else if ($("input[name='payment_type']:checked").val() == 'PayPal | Visa') {

                $('#mobile_money').html('')
                // $('#checkoutForme').submit();
                var fname = $('#fname').val();
                var lname = $('#lname').val();
                var phone = $('#phone').val();
                var address = $('#address').val();

                if (fname !== '' && lname !== '' && phone !== '' && address !== '') {
                    jQuery.noConflict();
                    $("#exampleModal").modal('toggle')
                } else {
                    $('#cash').prop('checked', true);

                    alertify.alert('Error', 'Please fill all form field first!')
                }


            } else {
                $('#mobile_money').html('')
            }
        });


    paypal.Buttons({
        createOrder: function (data, actions) {
            var amount = $("#paypal_amount").val();
            // alert(amount)
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: amount
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function (details) {
                // This function shows a transaction success message to your buyer.
                // alert('Transaction completed by ' + details.payer.name.given_name);
                $("#exampleModal").modal('toggle')
                alertify.success("Transaction completed, one more thing, please wait!");

                setTimeout(function () {
                    $('#checkoutForme').submit();
                }, 1500);


            });
        }
    }).render('#paypal-button-container');

</script>
