<?php
include("../connection/Functions.php");
$operation = new Functions();
session_start();
//login admin
if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);

    //check if any user exists
    if ($operation->countAll("SELECT *FROM users") > 0) {
        $query = "SELECT * FROM `users` WHERE email = '$email' ";
        $count = $operation->countAll($query);

        if ($count == 1) {

            //check password and email then redirect
            $user = $operation->retrieveSingle($query);
            $hashed_password = $user['password'];

            if (password_verify($password, $hashed_password)) {
                //check if user account is active
                if ($operation->countAll($query . " AND account_status = 1") > 0) {
                    $_SESSION['user'] = $user;
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
    } else {
        echo json_encode(array("code" => 3, "msg" => "Welcome to the new system, configure new admin!"));

    }


}

?>