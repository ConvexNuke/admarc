<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMARC</title>
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

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mt-1">
                            <div class="mdc-card">
                                <div class="d-flex justify-content-center">
                                    <h4 class="card-title mb-0 ">CONFIGURE SYSTEM</h4>

                                </div>
                                <div class="d-block d-sm-flex justify-content-center align-items-center">
                                    <h5 class="card-sub-title mb-2 mb-sm-0">Register to create your account</h5>

                                </div>
                                <div class="mdc-layout-grid__inner mt-2 ">
                                    <div class="mdc-layout-grid__cell--span-3"></div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">


                                        <form class="mt-2 py-3" id="registerForm">
                                            <div class="">

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop my-3">
                                                    <div class="mdc-text-field w-100">
                                                        <input type="text" class="mdc-text-field__input" id="fname" name="fname" required
                                                               autocomplete="off">
                                                        <div class="mdc-line-ripple"></div>
                                                        <label for="fname" class="mdc-floating-label">First name</label>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop my-2">
                                                    <div class="mdc-text-field w-100">
                                                        <input type="text" class="mdc-text-field__input" id="lname" name="lname" required
                                                               autocomplete="off">
                                                        <div class="mdc-line-ripple"></div>
                                                        <label for="lname" class="mdc-floating-label">Last name</label>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mb-2">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <small><i class="material-icons mdc-text-field__icon mt-1">phone</i></small>
                                                        <input autocomplete="false" type="tel" required
                                                               class="mdc-text-field__input "
                                                               name="phone"
                                                               id="phone">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch ">
                                                                <label for="email"
                                                                       class="mdc-floating-label">Phone</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <small><i class="material-icons mdc-text-field__icon mt-1">email</i></small>
                                                        <input autocomplete="false" type="email" required
                                                               class="mdc-text-field__input "
                                                               name="email"
                                                               id="email">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch ">
                                                                <label for="email"
                                                                       class="mdc-floating-label">Email</label>
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
                                                               id="pass1" name="pass1"/>
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="pass1"
                                                                       class="mdc-floating-label">Password</label>
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
                                                               id="pass2" name="pass2"/>
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="pass2"
                                                                       class="mdc-floating-label">Confirm Password</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">


                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--no-label">
                                                        <textarea placeholder="Address"  class="mdc-text-field__input"
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


                                            </div>
                                            <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                                            </div>
                                            <input type="hidden" name="role" id="role" value="admin" />
                                            <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                <button id="loginBtn" type="submit"
                                                        class="mdc-button mdc-button--raised w-100">
                                                    FINISH
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


    // });
</script>
<!-- End custom js for this page-->
</body>
</html>