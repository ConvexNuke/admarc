<?php
session_start();
if (!isset($_SESSION['email_reset'])) {
    header('Location: forget.php?error=Enter email first');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/demo/style.css">
    <link rel="stylesheet" href="../assets/css/custom/custom.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png"/>
</head>
<body>
<script src="../assets/js/preloader.js"></script>
<div class="body-wrapper">

    <div class="main-wrapper mdc-drawer-app-content">

        <div class="page-wrapper mdc-toolbar-fixed-adjust">
            <main class="content-wrapper">
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mt-5">
                            <div class="mdc-card">

                                <div class="d-flex justify-content-center">
                                    <div class="justify-content-center">
                                        <a href="../../customer/index.php"><img src="../assets/images/logo.png"
                                                                                height="120px" width="120px"></a>
                                    </div>
                                    <!--                                    <h4 class="card-title mb-0 ">LOGIN</h4>-->
                                </div>
                                <div class="d-block d-sm-flex justify-content-center align-items-center">
                                    <h5 class="card-sub-title mb-2 mb-sm-0">Create a new password</h5>

                                </div>
                                <div class="mdc-layout-grid__inner mt-2 ">
                                    <div class="mdc-layout-grid__cell--span-3"></div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">


                                        <form class="mt-2 py-5" id="newPasswordForm">

                                            <div class="">

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <small><i class="material-icons mdc-text-field__icon mt-1">lock</i></small>
                                                        <input autocomplete="false" type="password" required
                                                               class="mdc-text-field__input "
                                                               name="password"
                                                               id="password">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch ">
                                                                <label for="email"
                                                                       class="mdc-floating-label">New Password</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">lock</i>
                                                        <input autocomplete="off" type="password" required
                                                               class="mdc-text-field__input"
                                                               id="confirm_password" name="confirm_password"/>
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="password"
                                                                       class="mdc-floating-label">Confirm
                                                                    Password</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="password_reset_email"
                                                       name="password_reset_email"
                                                       value="<?= $_SESSION['email_reset'] ?>" required/>
                                            </div>

                                            <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                <button id="loginBtn" type="submit"
                                                        class="mdc-button mdc-button--raised w-100">
                                                    Reset
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mdc-layout-grid__cell--span-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        </main>

    </div>
</div>
</div>
<!-- plugins:js -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="../assets/vendors/chartjs/Chart.min.js"></script>
<script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="../assets/js/material.js"></script>
<script src="../assets/js/misc.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/js.js"></script>
<script>

    //login
    $("#newPasswordForm").on('submit', function (e) {
        var form_data = $(this).serialize();

        var email = $("#email_reset").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        if (password === confirm_password) {
            if (email !== '' && password !== '') {

                $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Checking...</span></div></div>');
                $.ajax({ //make ajax request to cart_process.php
                    url: "process/forget.php",
                    type: "POST",
                    //dataType:"json", //expect json value from server
                    data: form_data
                }).done(function (dataResult) { //on Ajax success
                        console.log(dataResult)
                        $("#loginBtn").html('Reset');
                        var data = JSON.parse(dataResult);
                        if (data.code == 1) {
                            Swal.fire(
                                'Success!',
                                data.msg,
                                'success'
                            )
                            setTimeout(function () {
                                window.location = "login.php";
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
                );

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Empty fields!"
                })
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Password and confirm password do not match!"
            })
        }

        e.preventDefault();
    });

    // });
</script>
<!-- End custom js for this page-->
</body>
</html>