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

$get_id = '';
$title = '';
if (isset($_GET) && !empty($_GET)) {
    $title = 'Edit Product Category';
} else {
    $title = 'Add Product Category';
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
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title"><?= $title ?></h6>

                                <div class="template-demo">
                                    <form id="addProductCategoryForm" enctype="multipart/form-data">
                                        <div class="mdc-layout-grid__inner">
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined">
                                                    <input type="file" class="mdc-text-field__input" id="prod_pic"
                                                           name="prod_pic"
                                                           autocomplete="off">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">

                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">word</i>
                                                    <input autocomplete="off" type="tel" required
                                                           class="mdc-text-field__input "
                                                           name="category_name"
                                                           id="category_name">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="category_name"
                                                                   class="mdc-floating-label">Category Name</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                <button id="loginBtn" type="submit"
                                                        class="mdc-button mdc-button--raised w-100">
                                                    SAVE
                                                </button>
                                            </div>
                                    </form>
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
<script>


</script>
</body>
</html>