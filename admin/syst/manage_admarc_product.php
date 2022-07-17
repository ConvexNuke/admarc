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
    $title = 'Product Details';
} else {
    header('Location:admarc_items.php');
}
$product_id = addslashes($_GET['product']);
$admarc_products = $operation->retrieveSingle("SELECT *FROM admarc_products WHERE product_id = '$product_id'");
$today = date("Y-m-d");

$branches = '';

$product_branch = $operation->retrieveSingle("SELECT *FROM admarc_branch_products WHERE product_id = '$product_id'");


$all_categories = $operation->retrieveMany("SELECT *FROM product_categories");

$categories = '';

foreach ($all_categories as $all_category) {
    if ($all_category['category_id'] == $admarc_products['category_id']) {
        $categories .= '   <li class="mdc-list-item mdc-list-item--selected" data-value="' . $all_category['category_id'] . '">' . $all_category['category_name'] . '</li>';
    } else {
        $branches .= '   <li class="mdc-list-item" data-value="' . $all_category['category_id'] . '">' . $all_category['category_name'] . '</li>';
    }
}


$all_branches = $operation->retrieveMany("SELECT *FROM branch");

$branches = '';
if (empty($product_branch)) {
    $branches .= ' <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true"></li>';
}
foreach ($all_branches as $all_branch) {
    if (!empty($product_branch)) {
        if ($all_branch['branch_id'] == $product_branch['branch_id']) {
            $branches .= '   <li class="mdc-list-item mdc-list-item--selected" data-value="' . $all_branch['branch_id'] . '">' . $all_branch['branch_name'] . '</li>';
        } else {
            $branches .= '   <li class="mdc-list-item" data-value="' . $all_branch['branch_id'] . '">' . $all_branch['branch_name'] . '</li>';
        }
    } else {
        $branches .= '   <li class="mdc-list-item" data-value="' . $all_branch['branch_id'] . '">' . $all_branch['branch_name'] . '</li>';
    }
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
                                    <img class="mt-5 mb-2"
                                         src="../assets/images/products/<?= $admarc_products['img_url'] ?>" height="250"
                                         width="250"/>
                                    <hr/>
                                    <form id="admarcProductForm" enctype="multipart/form-data">
                                        <input type="hidden" name="product_id" id="product_id"
                                               value="<?= $product_id ?>"/>
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
                                                <div class="mdc-select " style="width: 100%;"
                                                     data-mdc-auto-init="MDCSelect">
                                                    <input type="hidden" required name="category_id" id="category_id">
                                                    <i class="mdc-select__dropdown-icon"></i>
                                                    <div class="mdc-select__selected-text"></div>
                                                    <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                        <ul class="mdc-list">

                                                            <?= $categories ?>

                                                        </ul>
                                                    </div>
                                                    <span class="mdc-floating-label">Pick a category</span>
                                                    <div class="mdc-line-ripple"></div>
                                                </div>
                                            </div>


                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-select " style="width: 100%;"
                                                     data-mdc-auto-init="MDCSelect">
                                                    <input type="hidden" required name="branch_id" id="branch_id">
                                                    <i class="mdc-select__dropdown-icon"></i>
                                                    <div class="mdc-select__selected-text"></div>
                                                    <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                        <ul class="mdc-list">

                                                            <?= $branches ?>

                                                        </ul>
                                                    </div>
                                                    <span class="mdc-floating-label">Pick a branch</span>
                                                    <div class="mdc-line-ripple"></div>
                                                </div>
                                            </div>

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">word</i>
                                                    <input value="<?= $admarc_products['product_name'] ?>"
                                                           autocomplete="off" type="tel" required
                                                           class="mdc-text-field__input "
                                                           name="product_name"
                                                           id="product_name">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="product_name"
                                                                   class="mdc-floating-label">Product Name</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">money</i>
                                                    <input value="<?= $admarc_products['buying_price'] ?>"
                                                           autocomplete="off" type="text" required
                                                           class="mdc-text-field__input "
                                                           name="buying_price"
                                                           id="buying_price">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="buying_price"
                                                                   class="mdc-floating-label">Buying Price (K)</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">money</i>
                                                    <input value="<?= $admarc_products['selling_price'] ?>"
                                                           autocomplete="off" type="text" required
                                                           class="mdc-text-field__input "
                                                           name="selling_price"
                                                           id="selling_price">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="selling_price"
                                                                   class="mdc-floating-label">Selling Price (K)</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">amount</i>
                                                    <input value="<?= $admarc_products['qty_obtained'] ?>" min="0"
                                                           autocomplete="off" type="number" required
                                                           class="mdc-text-field__input "
                                                           name="qty_obtained"
                                                           id="qty_obtained">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="qty_obtained"
                                                                   class="mdc-floating-label">Quantity Obtained</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">amount</i>
                                                    <input value="<?= $admarc_products['qty_remaining'] ?>" min="0"
                                                           autocomplete="off" type="number" required readonly
                                                           class="mdc-text-field__input "
                                                           name="qty_remaining"
                                                           id="qty_remaining">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="qty_remaining"
                                                                   class="mdc-floating-label">Quantity Remaining</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">date</i>
                                                    <input value="<?= $admarc_products['date_start_sale'] ?>"
                                                           min="<?= $today ?>" autocomplete="off" type="date" required
                                                           class="mdc-text-field__input "
                                                           name="date_start_sale"
                                                           id="date_start_sale">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="date_start_sale"
                                                                   class="mdc-floating-label">Sale Start Date</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <i class="material-icons mdc-text-field__icon">date</i>
                                                    <input value="<?= $admarc_products['date_end_sale'] ?>"
                                                           min="<?= $today ?>" autocomplete="off" type="date" required
                                                           class="mdc-text-field__input "
                                                           name="date_end_sale"
                                                           id="date_end_sale">
                                                    <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                            <label for="date_end_sale"
                                                                   class="mdc-floating-label">Sale End Date</label>
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <button id="loginBtn" type="submit"
                                                        class="mdc-button mdc-button--raised w-100">
                                                    SAVE
                                                </button>
                                            </div>

                                            <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <button id="loginBtn" type="button" onclick="deleteAdmarcProductPrompt('<?=$product_id?>')"
                                                        class="mdc-button mdc-button--danger w-100">
                                                    DELETE
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

    function deleteAdmarcProductPrompt(id) {
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
                deleteAdmarcProduct(id)
            }
        })
    }

    function deleteAdmarcProduct(id) {
        $.ajax({
            url: "process/manage_product.php",
            method: "POST",
            data: {
                del_admarc_prod_id: id
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
                        window.location = "manage_admarc_product.php";
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