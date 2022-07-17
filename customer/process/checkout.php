<?php
include("../../admin/syst/connection/Functions.php");
$operation = new Functions();
session_start();
//
//echo '<pre>';
//print_r($_FILES);
//echo '</pre>';
//return;

if (isset($_POST['phone']) && isset($_POST['payment_type']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['address']) && !empty($_POST['phone']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['address'])) {
    $email = 'customer@admarc.com';
    $phone = addslashes($_POST['phone']);
    $fname = addslashes($_POST['fname']);
    $lname = addslashes($_POST['lname']);
    $city_name = addslashes($_POST['address']);
    $payment_type = addslashes($_POST['payment_type']);
    $pass1 = 'password';
    $user_role = 'customer';
    $password = password_hash($pass1, PASSWORD_DEFAULT);
    $filename = '';
    $status = '';

    $table = 'users';
    $data = [
        'address' => "$city_name",
        'fname' => "$fname",
        'lname' => "$lname",
        'email' => "$email",
        'phone' => "$phone",
        'password' => "$password",
        'account_status' => "0",
        'user_role' => "$user_role",
    ];
    //check email if already taken
    $checkEmail = $operation->retrieveSingle("SELECT *FROM users WHERE phone='$phone' AND user_role = '$user_role'");
    if (!empty($checkEmail)) {
        //update user records
        $where = "phone='$phone' AND user_role = '$user_role'";
        $operation->updateData($table, $data, $where);
    } else {
        $operation->insertData($table, $data);
    }
    $getUser = $operation->retrieveSingle("SELECT * FROM `users` WHERE phone='$phone' AND user_role = '$user_role'");
    if (empty($getUser)) {
        $error = "Something is keeping you from proceeding, please try again later!";
        header('Location:../checkout.php?error=' . $error);

        return;
    }
    $cart_total = 0;
    $user_id = $getUser['user_id'];
    foreach ($_SESSION['cart_customer'] as $item) {
        $prod_id = $item['prod_id'];
        $product_name = $item['product_name'];
        $price = $item['price'];
        $qty = $item['qty'];
        $cart_total += ($price * $qty);
    }

    if ($payment_type != 'Cash') {
        $status = 0;
        if (isset($_FILES['transaction_screenshot'])) {
            if (isset($_FILES['transaction_screenshot']) && $_FILES['transaction_screenshot']['size'] > 1) {

                $images = $_FILES['transaction_screenshot']['name'];
                $image = strtolower(pathinfo($images, PATHINFO_EXTENSION));
                $filename = rand(1000, 1000000) . "." . $image;
                /* Location */
                $location = "../../admin/assets/images/payment/" . $filename;
                $uploadOk = 1;
                $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
                /* Valid Extensions */
                $valid_extensions = array("jpg", "jpeg", "png");
                /* Check file extension */
                if (!in_array(strtolower($imageFileType), $valid_extensions)) {
                    $uploadOk = 0;
                }


                if ($_FILES['transaction_screenshot']['size'] > 3000000) {
                    $error = "✖ File must be less than 3mb!";
                    header('Location:../checkout.php?error=' . $error);
                    die();
                }


                if ($uploadOk == 0) {
                    $error = "✖ File type not supported, try jpg, jpeg or png!";
                    header('Location:../checkout.php?error=' . $error);

                    die();
                } else {
                    /* Upload file */
                    if (move_uploaded_file($_FILES['transaction_screenshot']['tmp_name'], $location)) {


                    } else {
                        $error = "✖ An error occurred while saving the picture!";
                        header('Location:../checkout.php?error=' . $error);

                        die();
                    }
                }


            }
        }
    } else {
        $status = 0;
    }

    $tbl = 'admarc_sales';
    $dt = [
        'total' => $cart_total,
        'user_id' => $user_id,
        'payment_type' => $payment_type,
        'is_approved ' => $status,
        'payment_screenshot ' => $filename,
    ];
    $operation->insertData($tbl, $dt);
    $getSale = $operation->retrieveSingle("SELECT * FROM `admarc_sales` WHERE user_id = '$user_id' AND total='$cart_total' ORDER BY sale_id DESC ");
    $sale_id = $getSale['sale_id'];
    //insert details
    $table = 'admarc_sale_details';
    foreach ($_SESSION['cart_customer'] as $item) {
        $prod_id = $item['prod_id'];
        $product_name = $item['product_name'];
        $price = $item['price'];
        $qty = $item['qty'];
        $cart_total += ($price * $qty);
        $data = [
            'sale_id' => $sale_id,
            'product_id' => $prod_id,
            'qty' => $qty,
            'prod_total' => $price * $qty,
        ];
        $operation->insertData($table, $data);

        $getProduct = $operation->retrieveSingle("SELECT * FROM `admarc_products` WHERE product_id = '$prod_id'");
        $qty_remaining = $getProduct['qty_remaining'] - $qty;

        $tbl = 'admarc_products';
        $dat = [
            'qty_remaining' => $qty_remaining
        ];
        $where = "product_id = '$prod_id'";
        $operation->updateData($tbl, $dat, $where);
    }

    unset($_SESSION['cart_customer']); //remove old item
//    echo json_encode(array("code" => 1, "msg" => "Products checked out!"));
    $success = 'Products checkout successful';
    header('Location:../checkout.php?success=' . $success);

    return;


}