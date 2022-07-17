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
    $title = 'Edit User';
} else {
    $title = 'Add User';
}
$user_details = (isset($_GET['user']) && !empty($_GET['user'])) ? $operation->retrieveSingle("SELECT *FROM users WHERE  user_id = '" . $_GET['user'] . "'") : [];

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
                                    if (empty($user_details)) {
                                        ?>
                                        <form id="addUserForm">
                                            <div class="mdc-layout-grid__inner">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input type="text" class="mdc-text-field__input" id="fname"
                                                               name="fname" required
                                                               autocomplete="off">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="fname"
                                                                       class="mdc-floating-label">First name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input type="text" class="mdc-text-field__input" id="lname"
                                                               name="lname" required
                                                               autocomplete="off">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="lname"
                                                                       class="mdc-floating-label">Last name</label>
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
                                                               name="phone"
                                                               id="phone">
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
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                                        <i class="material-icons mdc-text-field__icon">email</i>
                                                        <input autocomplete="off" type="email" required
                                                               class="mdc-text-field__input "
                                                               name="email"
                                                               id="email">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Email</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-select " style="width: 100%;"
                                                         data-mdc-auto-init="MDCSelect">
                                                        <input type="hidden" required name="role" id="role">
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <div class="mdc-select__selected-text"></div>
                                                        <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                            <ul class="mdc-list">
                                                                <li class="mdc-list-item mdc-list-item--selected"
                                                                    data-value="" aria-selected="true">
                                                                </li>
                                                                <li class="mdc-list-item" data-value="admin">
                                                                    Admin
                                                                </li>
                                                                <li class="mdc-list-item" data-value="agent">
                                                                    Agent
                                                                </li>
                                                                <li class="mdc-list-item" data-value="supplier">
                                                                    Supplier
                                                                </li>
                                                                <li class="mdc-list-item" data-value="stock_manager">
                                                                    Stock Manager
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <span class="mdc-floating-label">Pick a role</span>
                                                        <div class="mdc-line-ripple"></div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
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
                                        <img src="../assets/images/faces/<?= $user_details['img_url'] ?>"
                                             height="300" class="mdi-radius-outline mb-3 mt-3 ml-1 "
                                             style="border-radius: 160px" width="300"/>
                                        <form id="editUserForm">
                                            <div class="mdc-layout-grid__inner">

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <div class="mdc-text-field w-100">

                                                        <input type="file" name="profile_pic" id="profile_pic"
                                                               class="mdc-text-field__input">
                                                        <label for="profile_pic"><small>Profile Pic</small></label>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input value="<?= $user_details['fname'] ?>" type="text"
                                                               class="mdc-text-field__input" id="fname"
                                                               name="efname" required
                                                               autocomplete="off">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="fname"
                                                                       class="mdc-floating-label">First name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input value="<?= $user_details['lname'] ?>" type="text"
                                                               class="mdc-text-field__input" id="lname"
                                                               name="elname" required
                                                               autocomplete="off">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="lname"
                                                                       class="mdc-floating-label">Last name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">phone</i>
                                                        <input value="<?= $user_details['phone'] ?>" autocomplete="off"
                                                               type="tel" required
                                                               class="mdc-text-field__input "
                                                               name="ephone"
                                                               id="phone">
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
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                                        <i class="material-icons mdc-text-field__icon">email</i>
                                                        <input value="<?= $user_details['email'] ?>" autocomplete="off"
                                                               type="email" required
                                                               class="mdc-text-field__input "
                                                               name="eemail"
                                                               id="email">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="text-field-hero-input"
                                                                       class="mdc-floating-label">Email</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-select " style="width: 100%;"
                                                         data-mdc-auto-init="MDCSelect">
                                                        <input type="hidden" required name="erole" id="role">
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <div class="mdc-select__selected-text"></div>
                                                        <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                            <ul class="mdc-list">
                                                                <?php
                                                                if ($user_details['user_role'] == 'admin') {
                                                                    ?>
                                                                    <li class="mdc-list-item mdc-list-item--selected"
                                                                        data-value="admin">
                                                                        Admin
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="agent">
                                                                        Agent
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="supplier">
                                                                        Supplier
                                                                    </li>
                                                                    <li class="mdc-list-item"
                                                                        data-value="stock_manager">
                                                                        Stock Manager
                                                                    </li>
                                                                    <?php
                                                                } elseif ($user_details['user_role'] == 'agent') {
                                                                    ?>
                                                                    <li class="mdc-list-item mdc-list-item--selected"
                                                                        data-value="admin">
                                                                        Admin
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="agent">
                                                                        Agent
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="supplier">
                                                                        Supplier
                                                                    </li>
                                                                    <li class="mdc-list-item"
                                                                        data-value="stock_manager">
                                                                        Stock Manager
                                                                    </li>
                                                                    <?php
                                                                } elseif ($user_details['user_role'] == 'supplier') {
                                                                    ?>
                                                                    <li class="mdc-list-item mdc-list-item--selected"
                                                                        data-value="admin">
                                                                        Admin
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="agent">
                                                                        Agent
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="supplier">
                                                                        Supplier
                                                                    </li>
                                                                    <li class="mdc-list-item"
                                                                        data-value="stock_manager">
                                                                        Stock Manager
                                                                    </li>
                                                                    <?php
                                                                } elseif ($user_details['user_role'] == 'stock_manager') {
                                                                    ?>
                                                                    <li class="mdc-list-item mdc-list-item--selected"
                                                                        data-value="admin">
                                                                        Admin
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="agent">
                                                                        Agent
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="supplier">
                                                                        Supplier
                                                                    </li>
                                                                    <li class="mdc-list-item"
                                                                        data-value="stock_manager">
                                                                        Stock Manager
                                                                    </li>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <li class="mdc-list-item "
                                                                        data-value="admin">
                                                                        Admin
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="agent">
                                                                        Agent
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="supplier">
                                                                        Supplier
                                                                    </li>
                                                                    <li class="mdc-list-item"
                                                                        data-value="stock_manager">
                                                                        Stock Manager
                                                                    </li>
                                                                    <li class="mdc-list-item mdc-list-item--selected"
                                                                        data-value="customer">
                                                                        Customer
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </ul>
                                                        </div>
                                                        <span class="mdc-floating-label">Pick a role</span>
                                                        <div class="mdc-line-ripple"></div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">lock</i>
                                                        <input autocomplete="off" type="password"
                                                               class="mdc-text-field__input"
                                                               id="pass1" name="password"/>
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

                                                <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">


                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--no-label">
                                                        <textarea placeholder="Address" class="mdc-text-field__input"
                                                                  id="city_name" name="eaddress" rows="2" cols="40"
                                                                  aria-label="Label"><?= $user_details['address'] ?></textarea>
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

                                                <input type="hidden" id="euser_id" name="euser_id"
                                                       value="<?= $user_details['user_id'] ?>">
                                                <input type="hidden" id="status" name="status"
                                                       value="<?= $user_details['user_id'] ?>">


                                                <div class="mt-3 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">


                                                    <label class="mx-4  ">
                                                        Account Status
                                                    </label>
                                                    <div class="mdc-switch mdc-switch--checked mt-2"
                                                         data-mdc-auto-init="MDCSwitch">
                                                        <div class="mdc-switch__track"></div>
                                                        <div class="mdc-switch__thumb-underlay">
                                                            <div class="mdc-switch__thumb">
                                                                <input type="checkbox" id="account_status"
                                                                       name="account_status"
                                                                       class="mdc-switch__native-control"
                                                                       role="switch" <?= ($user_details['account_status'] == 1) ? 'checked' : 'unchecked' ?>>
                                                            </div>
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


    //edit user
    $("#editUserForm").on('submit', function (e) {
        var form_data = new FormData(this); //Creates new FormData object

        var email = $("#email").val();
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var phone = $("#phone").val();


        // console.log(email + "----" + phone + '--' + fname + "--" + lname + '---' + city_name + '---' + pass1)

        if (email !== '' && fname !== '' && lname !== '' && phone !== '') {

            $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Validating...</span></div></div>');
            $.ajax({ //make ajax request to cart_process.php
                url: 'process/manage_user.php',
                type: 'post',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (dataResult) { //on Ajax success
                    console.log(dataResult)
                    $("#loginBtn").html('Save');
                    var data = JSON.parse(dataResult);
                    if (data.code == 1) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )
                        setTimeout(function () {
                            // window.location = "products.php";
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
                            text: "Unknown error occurred!",
                        })
                    }
                },
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


</script>
</body>
</html>