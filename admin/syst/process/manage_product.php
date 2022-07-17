<?php
include("../connection/Functions.php");
$operation = new Functions();
session_start();

$logged_user = $_SESSION['user'];
$user_id = $logged_user['user_id'];
//register
//print_r($_POST);
//return;
//add product
if (isset($_FILES['prod_pic']) && isset($_POST['prod_name']) && isset($_POST['prod_price']) && isset($_POST['prod_qty']) && isset($_POST['category_id']) && !empty($_POST['prod_name'])) {
    $prod_name = addslashes($_POST['prod_name']);
    $prod_price = addslashes($_POST['prod_price']);
    $prod_qty = addslashes($_POST['prod_qty']);
    $category_id = addslashes($_POST['category_id']);


    $images = $_FILES['prod_pic']['name'];
    $image = strtolower(pathinfo($images, PATHINFO_EXTENSION));
    $filename = rand(1000, 1000000) . "." . $image;
    /* Location */
    $location = "../../assets/images/products/" . $filename;
    $uploadOk = 1;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    /* Valid Extensions */
    $valid_extensions = array("jpg", "jpeg", "png");
    /* Check file extension */
    if (!in_array(strtolower($imageFileType), $valid_extensions)) {
        $uploadOk = 0;
    }


    if ($_FILES['prod_pic']['size'] > 3000000) {
        echo json_encode(array("code" => 2, "msg" => "✖ File must be less than 3mb!"));
        die();
    }


    if ($uploadOk == 0) {
        echo json_encode(array("code" => 2, "msg" => "✖ File type not supported, try jpg, jpeg or png!"));
    } else {
        /* Upload file */
        if (move_uploaded_file($_FILES['prod_pic']['tmp_name'], $location)) {

            $table = "products";
            $data = [
                'user_id' => $user_id,
                'category_id' => $category_id,
                'product_name' => "$prod_name",
                'price' => "$prod_price",
                'qty' => "$prod_qty",
                'img_url' => "$filename"
            ];
            if ($operation->insertData($table, $data) == 1) {

                echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));
            } else {
//                   echo 0;
                echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving, please try again later!"));
            }


        } else {
            echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving the picture!"));
        }
    }
} elseif (isset($_POST['branch_id']) && isset($_POST['product_name']) && isset($_POST['buying_price']) && isset($_POST['selling_price']) && !empty($_POST['qty_obtained']) && isset($_POST['qty_remaining']) && isset($_POST['date_start_sale']) && isset($_POST['date_end_sale'])) {
    $product_name = addslashes($_POST['product_name']);
    $buying_price = addslashes($_POST['buying_price']);
    $selling_price = addslashes($_POST['selling_price']);
    $qty_obtained = addslashes($_POST['qty_obtained']);
    $qty_remaining = addslashes($_POST['qty_remaining']);
    $date_start_sale = addslashes($_POST['date_start_sale']);
    $date_end_sale = addslashes($_POST['date_end_sale']);
    $product_id = addslashes($_POST['product_id']);
    $category_id = addslashes($_POST['category_id']);
    $branch_id = addslashes($_POST['branch_id']);

    //check if exists or not
    if ($operation->countAll("SELECT * FROM `admarc_branch_products` WHERE product_id ='$product_id'") == 0) {
        $table = 'admarc_branch_products';
        $data = [
            'branch_id' => $branch_id,
            'product_id' => $product_id
        ];
        $operation->insertData($table, $data);
    } else {
        $table = 'admarc_branch_products';
        $data = [
            'branch_id' => $branch_id
        ];
        $where = "product_id = '$product_id'";
        $operation->updateData($table, $data, $where);
    }


    if ($_FILES['prod_pic']['size'] > 1) {
        $images = $_FILES['prod_pic']['name'];
        $image = strtolower(pathinfo($images, PATHINFO_EXTENSION));
        $filename = rand(1000, 1000000) . "." . $image;
        /* Location */
        $location = "../../assets/images/products/" . $filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
        /* Valid Extensions */
        $valid_extensions = array("jpg", "jpeg", "png");
        /* Check file extension */
        if (!in_array(strtolower($imageFileType), $valid_extensions)) {
            $uploadOk = 0;
        }


        if ($_FILES['prod_pic']['size'] > 3000000) {
            echo json_encode(array("code" => 2, "msg" => "✖ File must be less than 3mb!"));
            die();
        }


        if ($uploadOk == 0) {
            echo json_encode(array("code" => 2, "msg" => "✖ File type not supported, try jpg, jpeg or png!"));
        } else {
            /* Upload file */
            if (move_uploaded_file($_FILES['prod_pic']['tmp_name'], $location)) {

                $table = "admarc_products";
                $data = [
                    'product_name' => "$product_name",
                    'category_id' => "$category_id",
                    'buying_price' => "$buying_price",
                    'selling_price' => "$selling_price",
                    'qty_obtained' => "$qty_obtained",
                    'qty_remaining' => "$qty_remaining",
                    'date_start_sale' => "$date_start_sale",
                    'date_end_sale' => "$date_end_sale",
                    'img_url' => "$filename"
                ];
                $where = "product_id  = '$product_id'";

                if ($operation->updateData($table, $data, $where) == 1) {
                    echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));
                } else {
//                   echo 0;
                    echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving, please try again later!"));
                }


            } else {
                echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving the picture!"));
            }
        }
    } else {
        $table = "admarc_products";
        $data = [
            'product_name' => "$product_name",
            'category_id' => "$category_id",
            'buying_price' => "$buying_price",
            'selling_price' => "$selling_price",
            'qty_obtained' => "$qty_obtained",
            'qty_remaining' => "$qty_remaining",
            'date_start_sale' => "$date_start_sale",
            'date_end_sale' => "$date_end_sale"
        ];
        $where = "product_id  = '$product_id'";

        if ($operation->updateData($table, $data, $where) == 1) {
            echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));
        } else {
//                   echo 0;
            echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving, please try again later!"));
        }
    }


} elseif (isset($_POST['form_type']) && isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    if (isset($_POST['eprod_name']) && isset($_POST['eprod_price']) && isset($_POST['eprod_qty']) && isset($_POST['ecategory_id']) && !empty($_POST['eprod_name'])) {
        $prod_name = addslashes($_POST['eprod_name']);
        $prod_price = addslashes($_POST['eprod_price']);
        $prod_qty = addslashes($_POST['eprod_qty']);
        $category_id = addslashes($_POST['ecategory_id']);
        $product_id = addslashes($_POST['product_id']);

        if ($_FILES['prod_pic']['size'] > 1) {
            $images = $_FILES['prod_pic']['name'];
            $image = strtolower(pathinfo($images, PATHINFO_EXTENSION));
            $filename = rand(1000, 1000000) . "." . $image;
            /* Location */
            $location = "../../assets/images/products/" . $filename;
            $uploadOk = 1;
            $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
            /* Valid Extensions */
            $valid_extensions = array("jpg", "jpeg", "png");
            /* Check file extension */
            if (!in_array(strtolower($imageFileType), $valid_extensions)) {
                $uploadOk = 0;
            }


            if ($_FILES['prod_pic']['size'] > 3000000) {
                echo json_encode(array("code" => 2, "msg" => "✖ File must be less than 3mb!"));
                die();
            }


            if ($uploadOk == 0) {
                echo json_encode(array("code" => 2, "msg" => "✖ File type not supported, try jpg, jpeg or png!"));
                die();
            } else {
                /* Upload file */
                if (move_uploaded_file($_FILES['prod_pic']['tmp_name'], $location)) {
                    $product = $operation->retrieveSingle("SELECT *FROM products WHERE product_id = '$product_id'");
                    $directory = "../../assets/images/products/" . $product['img_url'];
                    //delete old file
                    if (unlink($directory)) {
                    }

                    $table = "products";
                    $data = [
                        'product_name' => "$prod_name",
                        'category_id' => "$category_id",
                        'price' => "$prod_price",
                        'qty' => "$prod_qty",
                        'img_url' => "$filename"
                    ];
                    $where = "product_id  = '$product_id'";

                    if ($operation->updateData($table, $data, $where) == 1) {
                        echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));
                    } else {
//                   echo 0;
                        echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving, please try again later!"));
                    }


                } else {
                    echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving the picture!"));
                }
            }

        } else {

            $table = "products";
            $data = [
                'product_name' => "$prod_name",
                'category_id' => "$category_id",
                'price' => "$prod_price",
                'qty' => "$prod_qty",
            ];
            $where = "product_id  = '$product_id'";
            if ($operation->updateData($table, $data, $where) == 1) {
                echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));
            } else {
//                   echo 0;
                echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving, please try again later!"));
            }
        }


    }
} elseif (isset($_POST['del_id']) && !empty($_POST['del_id'])) {
    $product_id = addslashes($_POST['del_id']);
    $checkProduct = $operation->retrieveSingle("SELECT *FROM products WHERE product_id = '$product_id'");
    if (!empty($checkProduct)) {

        if ($operation->deleteData('products', "product_id = '$product_id'")) {
            $directory = "../../assets/images/products/" . $checkProduct['img_url'];
            //delete old file
            if (unlink($directory)) {
            }
            echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));

        } else {
            echo json_encode(array("code" => 2, "msg" => "✖ Failed deleting product, please try again later!"));

        }
    } else {
        echo json_encode(array("code" => 2, "msg" => "✖ requested service unavailable, please try again later!"));

    }
} elseif (isset($_POST['del_admarc_prod_id']) && !empty($_POST['del_admarc_prod_id'])) {
    $product_id = addslashes($_POST['del_admarc_prod_id']);
    $checkProduct = $operation->retrieveSingle("SELECT *FROM admarc_products WHERE product_id = '$product_id'");
    if (!empty($checkProduct)) {

        if ($operation->deleteData('admarc_products', "product_id = '$product_id'")) {
            $directory = "../../assets/images/products/" . $checkProduct['img_url'];
            //delete old file
            if (unlink($directory)) {
            }
            echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));

        } else {
            echo json_encode(array("code" => 2, "msg" => "✖ Failed deleting product, please try again later!"));

        }
    } else {
        echo json_encode(array("code" => 2, "msg" => "✖ requested service unavailable, please try again later!"));

    }
}



