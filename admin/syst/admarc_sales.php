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
$products = $operation->retrieveMany("SELECT *FROM admarc_sales JOIN users ON admarc_sales.user_id = users.user_id ORDER BY sale_id DESC");


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
                                <h6 class="card-title card-padding pb-0 text-center">ADMARC SALES</h6>


                                <div class="mdc-layout-grid " style="width: 100%;">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 ">

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10  "
                                                 style="width: 100%;">
                                                <a href="./dom/index.php?admarc_sales=1" type="button"
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
                                            <th class="text-left "><b>Customer</b></th>
                                            <th class="text-left "><b>Products</b></th>
                                            <th class="text-left "><b>Type - isApproved?</b></th>
                                            <th class="text-left "><b>Total</b></th>

                                            <th><b></b></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($products as $product) {

                                            $sale_id = $product['sale_id'];
                                            $isApproved = ($product['is_approved'] == 1) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
                                            $salesCount = $operation->countAll("SELECT *FROM admarc_sale_details WHERE sale_id = '$sale_id'");

                                            echo '<tr>
                                                        <td class="text-left"><b>' . $product['fname'] . ' ' . $product['lname'] . '</b></td>
                                                        <td class="text-left ">' . $salesCount . '</td>
                                                        <td class="text-left"><b>' . $product['payment_type'] . ' - ' . $isApproved . '</b></td>
                                                        <td class="text-left">' . number_format($product['total'], 2) . '</td>
                                                      
                                                        <td>
                                                        <a href="admarc_sale_details.php?sale=' . $product['sale_id'] . '" class="mdc-button mdc-button--outlined ">
                                                            View Details
                                                        </a>
                                                        </td>
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