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
$products = $operation->retrieveMany("SELECT *FROM admarc_products WHERE from_user = '$user_id'");


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
                                <h6 class="card-title card-padding pb-0 text-center">MY SALES</h6>


                                <div class="mdc-layout-grid " style="width: 100%;">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 ">

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10  "
                                                 style="width: 100%;">
                                                <a href="./dom/index.php?my_sales=1" type="button"
                                                        class="mdc-button mdc-button--outlined material-icons mx-2">
                                                    <div class="mdc-icon-button__ripple"></div>
                                                    picture_as_pdf
                                                </a>

<!--                                                <button type="button"-->
<!--                                                        class="mdc-button mdc-button--outlined material-icons mx-2 ">-->
<!--                                                    <span class="mdi mdi-file-excel"></span>-->
<!---->
<!--                                                </button>-->
                                            </div>

<!--                                            <div id="openModal"-->
<!--                                                 class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-2 ">-->
<!--                                                <a href="obtain_products.php" class="mdc-button mdc-button--outlined ">-->
<!--                                                    Buy Products-->
<!--                                                </a>-->
<!---->
<!--                                            </div>-->

                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hoverable">
                                        <thead>
                                        <tr class="bg-light ">
                                            <th class="text-left "><b>Product Name</b></th>
                                            <th class="text-left "><b>Selling Price (K)</b></th>
                                            <th class="text-left "><b>Qty Sold</b></th>
                                            <th class="text-left "><b>Date Sold</b></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($products as $product) {
                                            $status = '';
                                            if ($product['qty_remaining'] >= 10) {
                                                $status = '<i class="text-success">' . $product['qty_remaining'] . '</i>';
                                            } else {
                                                $status = '<i class="text-danger">' . $product['qty_remaining'] . '</i>';
                                            }
                                            $category_id = $product['category_id'];
                                            $category = $operation->retrieveSingle("SELECT *FROM product_categories WHERE category_id = '$category_id'");

                                            echo '<tr>
                                                        <td class="text-left"><img src="../assets/images/products/' . $product['img_url'] . '" height="60px" width="60px"><b>' . $product['product_name'] . '</b> - <small>' . $category['category_name'] . '</small></td>
                                                        <td class="text-left">' . number_format($product['buying_price'], 2) . '</td>
                                                        <td class="text-left ">' . $product['qty_obtained'] . '</td>
                                                        <td class="text-left ">' . $product['date_created'] . '</td>
                                                       
                                                    </tr>';

                                        }
                                        ?>


                                        </tbody>
                                    </table>
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