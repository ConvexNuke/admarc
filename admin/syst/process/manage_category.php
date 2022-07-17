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
if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
    $category_name = addslashes($_POST['category_name']);

    if (isset($_FILES['prod_pic']) && !empty($_FILES['prod_pic']['name']) && $_FILES['prod_pic']['size'] > 0) {
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

                $table = "product_categories";
                $data = [
                    'category_name' => "$category_name",
                    'category_img' => "$filename"
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
    } else {
        $table = "product_categories";
        $data = [
            'category_name' => "$category_name"
        ];
        if ($operation->insertData($table, $data) == 1) {

            echo json_encode(array("code" => 1, "msg" => "Success, redirecting, please wait!"));
        } else {
//                   echo 0;
            echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving, please try again later!"));
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


}



