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
    $title = 'Edit Product';
} else {
    $title = 'Add Product';
}

$categories = $operation->retrieveMany("SELECT *FROM product_categories");
$product_details = (isset($_GET['product'])) ? $operation->retrieveSingle('SELECT *FROM products WHERE product_id = ' . $_GET['product']) : [];
$form_type = (!empty($product_details)) ? 'Edit' : 'Add';
$product_id = (!empty($product_details)) ? $_GET['product'] : '';
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
                                    if (empty($product_details)) {
                                        ?>
                                        <form id="addProductForm" enctype="multipart/form-data">
                                            <div class="mdc-layout-grid__inner">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined">
                                                        <input type="file" class="mdc-text-field__input" id="prod_pic"
                                                               name="prod_pic" required
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
                                                               name="prod_name"
                                                               id="prod_name">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="prod_name"
                                                                       class="mdc-floating-label">Product Name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-select " style="width: 100%;"
                                                         data-mdc-auto-init="MDCSelect">
                                                        <input type="hidden" required name="category_id"
                                                               id="category_id">
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <div class="mdc-select__selected-text"></div>
                                                        <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                            <ul class="mdc-list">

                                                                <li class="mdc-list-item mdc-list-item--selected"
                                                                    data-value="" aria-selected="true">
                                                                </li>
                                                                <?php
                                                                foreach ($categories as $category) {
                                                                    echo '
                                                                        <li class="mdc-list-item" data-value="' . $category['category_id'] . '">
                                                                            ' . $category['category_name'] . '
                                                                        </li>
                                                                        ';
                                                                }
                                                                ?>

                                                            </ul>
                                                        </div>
                                                        <span class="mdc-floating-label">Pick a category</span>
                                                        <div class="mdc-line-ripple"></div>
                                                    </div>
                                                </div>


                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">money</i>
                                                        <input autocomplete="off" type="text" required
                                                               class="mdc-text-field__input "
                                                               name="prod_price"
                                                               id="prod_price">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="prod_price"
                                                                       class="mdc-floating-label">Product Price
                                                                    (K)</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">amount</i>
                                                        <input autocomplete="off" type="number" required
                                                               class="mdc-text-field__input "
                                                               name="prod_qty"
                                                               id="prod_qty">
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="prod_qty"
                                                                       class="mdc-floating-label">Product
                                                                    Quantity</label>
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
                                        <?php
                                    } else {
                                        ?>
                                        <img src="../assets/images/products/<?= $product_details['img_url'] ?>"
                                             height="300" class="mdi-radius-outline mb-3 ml-1" width="300"/>
                                        <form id="editProductForm2" enctype="multipart/form-data">
                                            <div class="mdc-layout-grid__inner">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
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
                                                               name="eprod_name"
                                                               id="eprod_name"
                                                               value="<?= $product_details['product_name'] ?>"
                                                        />
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="prod_name"
                                                                       class="mdc-floating-label">Product Name</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-select " style="width: 100%;"
                                                         data-mdc-auto-init="MDCSelect">
                                                        <input type="hidden" required name="ecategory_id"
                                                               id="ecategory_id">
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <div class="mdc-select__selected-text"></div>
                                                        <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                            <ul class="mdc-list">

                                                                <!--                                                                <li class="mdc-list-item mdc-list-item--selected"-->
                                                                <!--                                                                    data-value="" aria-selected="true">-->
                                                                <!--                                                                </li>-->
                                                                <?php
                                                                foreach ($categories as $category) {
                                                                    $item_selected = ($category['category_id'] == $product_details['category_id']) ? 'mdc-list-item--selected' : '';
                                                                    echo '
                                                                        <li class="mdc-list-item ' . $item_selected . '" data-value="' . $category['category_id'] . '">
                                                                            ' . $category['category_name'] . '
                                                                        </li>
                                                                        ';
                                                                }
                                                                ?>

                                                            </ul>
                                                        </div>
                                                        <span class="mdc-floating-label">Pick a category</span>
                                                        <div class="mdc-line-ripple"></div>
                                                    </div>
                                                </div>


                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">money</i>
                                                        <input autocomplete="off" type="text" required
                                                               class="mdc-text-field__input "
                                                               name="eprod_price"
                                                               id="eprod_price"
                                                               value="<?= $product_details['price'] ?>"
                                                        />
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="prod_price"
                                                                       class="mdc-floating-label">Product Price
                                                                    (K)</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                        <i class="material-icons mdc-text-field__icon">amount</i>
                                                        <input autocomplete="off" type="number" required
                                                               class="mdc-text-field__input "
                                                               name="eprod_qty"
                                                               id="eprod_qty"
                                                               value="<?= $product_details['qty'] ?>"

                                                        />
                                                        <div class="mdc-notched-outline">
                                                            <div class="mdc-notched-outline__leading"></div>
                                                            <div class="mdc-notched-outline__notch">
                                                                <label for="prod_qty"
                                                                       class="mdc-floating-label">Product
                                                                    Quantity</label>
                                                            </div>
                                                            <div class="mdc-notched-outline__trailing"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="form_type" id="form_type"
                                                       value="<?= $form_type ?>"/>

                                                <input type="hidden" name="product_id" id="product_id"
                                                       value="<?= $product_id ?>"/>


                                                <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <button id="loginBtn" type="submit"
                                                            class="mdc-button mdc-button--raised w-100">
                                                        SAVE
                                                    </button>
                                                </div>
                                                <div class="mt-2 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <button onclick="deleteProductPrompt('<?= $product_id ?>')"
                                                            id="delBtn" type="button"
                                                            class="mdc-button mdc-button--danger w-100">
                                                        DELETE
                                                    </button>
                                                </div>
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
    //edit product
    $("#editProductForm2").on('submit', function (e) {

        var prod_name = $("#eprod_name").val();
        var prod_price = $("#eprod_price").val();
        var prod_qty = $("#eprod_qty").val();


        if (prod_name !== '' && prod_price !== '' && prod_qty !== '') {
            var form_data = new FormData(this); //Creates new FormData object

            $("#loginBtn").html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Saving...</span></div></div>');
            $.ajax({ //make ajax request to cart_process.php
                url: 'process/manage_product.php',
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
                            window.location = "products.php";
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
                text: "Please fill the required fields!",
            })
        }
        e.preventDefault();
        e.stopImmediatePropagation();
    });

    function deleteProductPrompt(id) {
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
                deleteProduct(id)
            }
        })
    }

    function deleteProduct(id) {
        $.ajax({
            url: "process/manage_product.php",
            method: "POST",
            data: {
                del_id: id
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
                        window.location = "products.php";
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