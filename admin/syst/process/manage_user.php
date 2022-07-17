<?php
include("../connection/Functions.php");
$operation = new Functions();
session_start();
//register
//echo '<pre>';
//print_r($_POST);
//
//echo '</pre>';
//die();
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
//            $getUser = $operation->retrieveSingle("SELECT * FROM `users` WHERE email='$email' AND user_role = '$user_role'");
//            $_SESSION['user'] = $getUser;
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
} elseif (isset($_POST['efname'], $_POST['elname'], $_POST['eemail'], $_POST['euser_id'], $_POST['ephone'], $_POST['eaddress']) && !empty($_POST['efname']) && !empty($_POST['elname']) && !empty($_POST['eemail']) && !empty($_POST['euser_id']) && !empty($_POST['ephone'])) {
    $fname = addslashes($_POST['efname']);
    $lname = addslashes($_POST['elname']);
    $user_id = addslashes($_POST['euser_id']);
    $email = addslashes($_POST['eemail']);
    $phone = addslashes($_POST['ephone']);
    $address = addslashes($_POST['eaddress']);

    $table = "users";
    $where = "user_id = '$user_id'";
    $data = [
        'fname' => "$fname",
        'lname' => "$lname",
        'email' => "$email",
        'phone' => "$phone",
        'address' => "$address",
    ];
    $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE user_id = '$user_id'");


    if ($operation->updateData($table, $data, $where) == 1) {


        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if (!password_verify($password, $getUser['password'])) {
                $data = [
                    'password' => "$password",
                ];
                $operation->updateData($table, $data, $where);
            }
        }

        if (isset($_POST['status'])) {
            if (isset($_POST['account_status']) && !empty($_POST['account_status'])) {
                $data = [
                    'account_status' => "1",
                ];
                $operation->updateData($table, $data, $where);

            } else {

                $data = [
                    'account_status' => "0",
                ];
                $operation->updateData($table, $data, $where);
            }
        }


        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['size'] > 1) {

            $images = $_FILES['profile_pic']['name'];
            $image = strtolower(pathinfo($images, PATHINFO_EXTENSION));
            $filename = rand(1000, 1000000) . "." . $image;
            /* Location */
            $location = "../../assets/images/faces/" . $filename;
            $uploadOk = 1;
            $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
            /* Valid Extensions */
            $valid_extensions = array("jpg", "jpeg", "png");
            /* Check file extension */
            if (!in_array(strtolower($imageFileType), $valid_extensions)) {
                $uploadOk = 0;
            }


            if ($_FILES['profile_pic']['size'] > 3000000) {
                echo json_encode(array("code" => 2, "msg" => "✖ File must be less than 3mb!"));
                die();
            }


            if ($uploadOk == 0) {
                echo json_encode(array("code" => 2, "msg" => "✖ File type not supported, try jpg, jpeg or png!"));
                die();
            } else {
                /* Upload file */
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $location)) {

                    $data = [

                        'img_url' => "$filename"
                    ];
                    if ($operation->updateData($table, $data, $where) == 1) {
                        //get user and delete profile pic
                        $img = $getUser['img_url'];
                        $_SESSION['user']['img_url'] = $filename;
                        if ($img != 'face1.jpg') {
                            $directory = "../../assets/images/faces/" . $img;
                            if (unlink($directory)) {
                            }
                        }
                        echo json_encode(array("code" => 1, "msg" => "Success, refreshing page, please wait!"));
                        die();
                    } else {
//                   echo 0;
                        echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving picture, other information saved, please try again later!"));
                        die();
                    }


                } else {
                    echo json_encode(array("code" => 2, "msg" => "✖ An error occurred while saving the picture!"));
                    die();
                }
            }


        }
        echo json_encode(array("code" => 1, "msg" => "Success, redirecting!"));

    } else {
        echo json_encode(array("code" => 2, "msg" => "Updating record failed!"));
    }
}


?>