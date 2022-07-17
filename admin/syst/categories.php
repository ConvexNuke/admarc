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
$categories = $operation->retrieveMany("SELECT *FROM product_categories ORDER BY category_name ASC");


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
                                <h6 class="card-title card-padding pb-0 text-center">PRODUCT CATEGORIES</h6>


                                <div class="mdc-layout-grid " style="width: 100%;">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 ">

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10  "
                                                 style="width: 100%;">
                                                <a href="products.php" class="mdc-button mdc-button--outlined ">
                                                    <span class="mdi mdi-arrow-left"></span>Back
                                                </a>
                                            </div>

                                            <div id="openModal"
                                                 class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-2 ">
                                                <a href="manage_category.php" class="mdc-button mdc-button--outlined ">
                                                    Add Category
                                                </a>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hoverable">
                                        <thead>
                                        <tr class="bg-light ">
                                            <th class="text-left "></th>
                                            <th class="text-left "><b>Category Name</b></th>
                                            <th><b></b></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($categories as $category) {
                                            echo '<tr>
                                                        <td class="text-left"><img height="50px" width="50px" src="../assets/images/products/' . $category['category_img'] . '" /></td>
                                                        <td class="text-left">' . $category['category_name'] . '</td>
                                                       
                                                        <td>
                                                        <a href="manage_category.php?category=' . $category['category_id'] . '" class="mdc-button mdc-button--outlined ">
                                                            Manage
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