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
$products = $operation->retrieveMany("
        SELECT products.*, users.user_id, users.user_role FROM products 
        LEFT JOIN users
        ON products.user_id = users.user_id
        
        WHERE qty > 0 ORDER BY product_name ASC");


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
                            <div class=" " style="width: 100%;">
                                <h6 class="card-title card-padding pb-0 text-center">FIND PRODUCTS/FARM PRODUCE</h6>
                                <div class="">
                                    <a href="admarc_items.php" class="mdc-button mdc-button--outlined ">
                                        <span class="mdi mdi-arrow-left"></span>Back
                                    </a>
                                    <div class="mdc-layout-grid">
                                        <div class="mdc-layout-grid__inner">


                                            <?php
                                            foreach ($products as $product) {
                                                $style = " border-radius: 5px; background-image: url('../assets/images/products/" . $product['img_url'] . "'); background-size: contain; background-position: center; background-repeat: no-repeat;";
                                                echo '
                                                        
                                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 ">
        
                                                                    <div class="mdc-card mdc-card--outlined demo-card">
        
        
                                                                        <div class="mdc-card__media mdc-card__media--16-9"
                                                                             style="' . $style . '">
                                                                             
                                                                        </div>
        
                                                                        <div class="mdc-card-wrapper__text-section"><!---->
                                                                            <div class="demo-card__title mt-3 " style="width: 100%;">
                                                                                <span class="" >' . $product['product_name'] . '</span>
                                                                                <span class="" style="float: right;"><small>K' . number_format($product['price'], 2) . '</small></span>
                                                                            </div>
                                                                            <div class="demo-card__subhead mt-1 "><small id="qty_' . $product['product_id'] . '">' . $product['qty'] . ' remaining</small></div>
                                                                           <small> <small class="mt-2">' . ucfirst(strtolower($product['user_role'])) . '</small></small>
                                                                            <!----></div>
        
                                                                        <div class="mdc-card__actions">
                                                                         <input style="width: 50px" id="prod_qty' . $product['product_id'] . '" type="number" value="1" max="' . $product['qty'] . '" placeholder="qty" min="1"  />
                                                                            <button id="btn_cart_add' . $product['product_id'] . '" onclick="addToCart(\'' . $product['product_id'] . '\',\'' . $product['product_name'] . '\',\'' . $product['price'] . '\')"  class="mdc-button mdc-card__action mdc-card__action--button mdc-ripple-upgraded mx-2">
        
                                                                                    <span class="mdc-button__label">
                                                                                        Add to Cart
                                                                                    </span>
                                                                                    <div class="mdc-button__ripple"></div>
                                                                            </button>
                                                                            
                                                                        </div>
        
                                                                    </div>
                                                                </div>
                                                            
                                                        
                                                    ';
                                            }
                                            ?>


                                        </div>

                                    </div>
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