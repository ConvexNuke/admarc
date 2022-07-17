<?php
include("../connection/Functions.php");
$operation = new Functions();
session_start();
//register
//print_r($_POST);
if (isset($_POST['email']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['phone']) && isset($_POST['city_name']) && isset($_POST['pass1']) && !empty($_POST['email']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['phone']) && !empty($_POST['city_name']) && !empty($_POST['pass1'])) {
    $email = addslashes($_POST['email']);
    $fname = addslashes($_POST['fname']);
    $lname = addslashes($_POST['lname']);
    $phone = addslashes($_POST['phone']);
    $city_name = addslashes($_POST['city_name']);
    $pass1 = addslashes($_POST['pass1']);
    $user_role = $_POST['role'];
    $table = 'users';
    //check email if already taken
    $countEmail = $operation->countAll("SELECT *FROM users WHERE email='$email' AND user_role = '$user_role'");
    if ($countEmail > 0) {
        echo json_encode(array("code" => 2, "msg" => "Email already taken"));
    } else {
        $password = password_hash($pass1, PASSWORD_DEFAULT);
        $data = [
            'address' => "$city_name",
            'fname' => "$fname",
            'lname' => "$lname",
            'email' => "$email",
            'phone' => "$phone",
            'password' => "$password",
            'account_status' => "1",
            'user_role' => "$user_role",
        ];
        if ($operation->insertData($table, $data) == 1) {
            //get user id
            $getUser = $operation->retrieveSingle("SELECT * FROM `users` WHERE email='$email' AND user_role = '$user_role'");
            $_SESSION['user'] = $getUser;
            echo json_encode(array("code" => 1, "msg" => "Success, redirecting"));
        } else {
            echo json_encode(array("code" => 2, "msg" => "An error occured, please try again later"));
        }
    }
} elseif (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);

    $query = "SELECT * FROM `users` WHERE email = '$email' AND user_role = 'customer'";
    $count = $operation->countAll($query);

    if ($count == 1) {

        //check password and email then redirect
        $user = $operation->retrieveSingle($query);
        $hashed_password = $user['password'];

        if (password_verify($password, $hashed_password)) {
            //check if user account is active
            if ($operation->countAll($query . " AND account_status = 1") > 0) {
                $_SESSION['user'] = $user['user_id'];
                echo json_encode(array("code" => 1, "msg" => "Success, redirecting!"));

            } else {
                echo json_encode(array("code" => 2, "msg" => "Your account has been terminated, contact manager!"));
            }


        } else {
            echo json_encode(array("code" => 2, "msg" => "Wrong password or email, try again!"));
        }

    } else {
        echo json_encode(array("code" => 2, "msg" => "Email does not match any records!"));
    }
}

?>