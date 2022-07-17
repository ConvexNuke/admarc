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
$branches = $operation->retrieveMany("SELECT *FROM branch");


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
                                <h6 class="card-title card-padding pb-0 text-center">BRANCHES</h6>


                                <div class="mdc-layout-grid " style="width: 100%;">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 ">

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10  "
                                                 style="width: 100%;">
                                                <a href="./dom/index.php?branches=1" type="button"
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

                                            <div id="openModal"
                                                 class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-2 ">
                                                <a href="manage_branch.php" class="mdc-button mdc-button--outlined ">
                                                    Add branch
                                                </a>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hoverable">
                                        <thead>
                                        <tr class="bg-light ">
                                            <th class="text-left "><b>Branch Name</b></th>
                                            <th class="text-left "><b>Phone</b></th>
                                            <th><b></b></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($branches as $branch) {

                                            echo '<tr>
                                                        <td class="text-left">' . $branch['branch_name'] . '</td>
                                                        <td class="text-left ">' . $branch['branch_phone'] . '</td>
                                                      
                                                        <td>
                                                        <a href="manage_branch.php?branch=' . $branch['branch_id'] . '" class="mdc-button mdc-button--outlined ">
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