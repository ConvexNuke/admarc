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
    $title = 'Edit Branch';
} else {
    $title = 'Add Branch';
}
$branch_details = (isset($_GET['branch']) && !empty($_GET['branch'])) ? $operation->retrieveSingle("SELECT *FROM branch WHERE  branch_id = '" . $_GET['branch'] . "'") : [];


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
                                    <?php
                                    if (empty($branch_details)) {
                                        ?>
                                        <form id="addBranchForm">
                                            <div class="mdc-layout-grid__inner">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input type="text" class="mdc-text-field__input"
                                                               id="branch_name"
                                                               name="branch_name" required
                                                               autocomplete="off">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="fname"
                                                                       class="mdc-floating-label">Branch
                                                                    name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">phone</i>
                                                        <input autocomplete="off" type="tel" required
                                                               class="mdc-text-field__input "
                                                               name="branch_phone"
                                                               id="branch_phone">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="phone"
                                                                       class="mdc-floating-label">Phone</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">


                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--no-label">
                                                        <textarea placeholder="Address" class="mdc-text-field__input"
                                                                  id="city_name" name="city_name" rows="2" cols="40"
                                                                  aria-label="Label"></textarea>
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="city_name"
                                                                       class="mdc-floating-label">Address</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <button id="loginBtn" type="submit"
                                                            class="mdc-button mdc-button--raised w-100">
                                                        SAVE
                                                    </button>
                                                </div>
                                        </form>
                                        <?php
                                    } else {
                                        ?>
                                        <form id="editBranchForm">
                                            <div class="mdc-layout-grid__inner">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input type="text" class="mdc-text-field__input"
                                                               value="<?= $branch_details['branch_name'] ?>" id="branch_name"
                                                               name="ebranch_name" required
                                                               autocomplete="off">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="fname"
                                                                       class="mdc-floating-label">Branch
                                                                    name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">phone</i>
                                                        <input autocomplete="off" type="tel" required
                                                               class="mdc-text-field__input "
                                                               name="ebranch_phone"
                                                               id="branch_phone" value="<?= $branch_details['branch_phone'] ?>">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="phone"
                                                                       class="mdc-floating-label">Phone</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">


                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--no-label">
                                                        <textarea placeholder="Address" class="mdc-text-field__input"
                                                                  id="city_name" name="ecity_name" rows="2" cols="40"
                                                                  aria-label="Label"><?= $branch_details['address'] ?></textarea>
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="city_name"
                                                                       class="mdc-floating-label">Address</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </label>
                                                </div>

                                                <input type="hidden" name="branch_id" id="branch_id"
                                                       value="<?= $branch_details['branch_id'] ?>"/>

                                                <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <button id="loginBtn" type="submit"
                                                            class="mdc-button mdc-button--raised w-100">
                                                        SAVE
                                                    </button>
                                                </div>

                                                <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <button id="loginBtn" type="button"
                                                            onclick="deleteBranchPrompt('<?= $branch_details['branch_id'] ?>')"
                                                            class="mdc-button mdc-button--danger w-100">
                                                        DELETE
                                                    </button>
                                                </div>
                                        </form>
                                        <?php
                                    }
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
<script>
    //add branch
    $("#editBranchForm").on('submit', function (e) {
        var form_data = $(this).serialize();

        var branch_name = $("#branch_name").val();
        var branch_phone = $("#branch_phone").val();


        if (branch_name !== '' && branch_phone !== '' ) {

            $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
            $.ajax({ //make ajax request to cart_process.php
                url: "process/manage_branch.php",
                type: "POST",
                //dataType:"json", //expect json value from server
                data: form_data
            }).done(function (dataResult) { //on Ajax success
                console.log(dataResult)
                $("#loginBtn").html('SAVE');
                var data = JSON.parse(dataResult);

                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        // window.location = "branches.php";
                        location.reload();
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occured",
                    })
                }

            });


        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Fields with a * are required",
            })
        }


        e.stopImmediatePropagation();
        e.preventDefault();
    });

    function deleteBranchPrompt(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                deleteBranch(id)
            }
        })
    }

    function deleteBranch(id) {
        $.ajax({
            url: "process/manage_branch.php",
            method: "POST",
            data: {
                del_branch_id: id
            },

            success: function (dataResult) {
                // alert(data);
                var data = JSON.parse(dataResult);
                if (data.code == 1) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )
                    setTimeout(function () {
                        window.location = "branches.php";
                    }, 1000);
                } else if (data.code == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Unknown error occurred!",
                    })
                }


            }
        });

    }


</script>
</body>
</html>