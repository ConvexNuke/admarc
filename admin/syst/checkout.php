<?php
session_start();
//unset($_SESSION['user']);
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
}

include('connection/Functions.php');
$operation = new Functions();
$logged_user = $_SESSION['user'];
$user_id = $logged_user['user_id'];


$html = '';
$counter = 0;
$cart_total = 0;
$btnPay = '';
if (!empty($_SESSION['cart']) && isset($_SESSION['cart'])) {

    $html .= '
             <table class="table table-hoverable p-5">
             <thead>
               <tr class="bg-light ">
                   <th style="text-align: left; padding-left:  30px; width: 40%;"><small>Product Name</small></th>
                    <th style="text-align: left; width: 30%;" ><small>Price (K)</small></th>
                    <th style="text-align: left;width: 20%; " ><small>Quantity</small></th>
                    <th style="text-align: left; width: 10%;"></th>
                    </tr>
                    </thead>
                    <tbody>
            ';
    foreach ($_SESSION['cart'] as $item) {

        $prod_id = $item['prod_id'];
        $product_name = $item['product_name'];

        $qty = $item['qty'];
        $cart_total += $item['price'];
        $html .= '
				<tr>
				<td style="text-align: left">' . $item["product_name"] . '</td>
				<td style="text-align: left">' . $item["price"] . '</td>
				<td  style="text-align: left">' . $item["qty"] . '</td>
				<td style="text-align: left">
				    <a onclick="deleteFromCart(\'' . $item['prod_id'] . '\')" href="#" class="mdc-button mdc-button--danger icon-sm">
                                                <i class="mdi mdi-trash-can-outline mr-2 tx-16"></i>
                     </a>
                </td>
				</tr>
            ';
    }

    $html .= '
            </tbody>
            </table>
            ';

    $counter = count($_SESSION['cart']);
    $btnPay = '<a  href="#" onclick="finishPayment()" class="mdc-button mdc-button--outlined ">
                                                    <i class="mdi mdi-paypal"></i> PAY K(' . number_format($cart_total, 2) . ')
                                                </a>';
} else {
    $html = '<div class="" style="width: 100%; "> <span style="" class="text-center text-warning p-5">No Items in your cart</span></div>';
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/css.php'); ?>
<body>
<script src="../assets/js/preloader.js"></script>
<div class="body-wrapper">

    <?php include('includes/aside.php'); ?>
    <div class="main-wrapper mdc-drawer-app-content">

        <?php include('includes/header.php'); ?>


        <!-- partial -->
        <div class="page-wrapper mdc-toolbar-fixed-adjust">
            <main class="content-wrapper">
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card p-0">
                                <h6 class="card-title card-padding pb-0 text-center">CHECKOUT PRODUCTS</h6>


                                <div class="mdc-layout-grid " style="width: 100%;">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 ">

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10  "
                                                 style="width: 100%;">
                                            </div>

                                            <div id="btnPay"
                                                 class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-2 ">
                                                <?= $btnPay ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="cartItems2" class="table-responsive ">

                                    <?php

                                    echo $html;

                                    ?>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
            <?php include("includes/footer.php"); ?>

            <!-- partial -->
        </div>
    </div>
</div>

<?php include('includes/scripts.php'); ?>

</body>
</html>