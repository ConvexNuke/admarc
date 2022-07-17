<?php
include("../connection/Functions.php");
require_once("../PHPMailer/src/PHPMailer.php");
require_once("../PHPMailer/src/SMTP.php");
require_once("../PHPMailer/src/Exception.php");
$operation = new Functions();
session_start();
//login admin


if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = addslashes($_POST['email']);
    $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE email = '$email'");
    if (!empty($email)) {
        $reset_code = rand(1000, 9999);
        //check if user has a reset record
        $table = 'password_reset';

        $checkUserReset = $operation->retrieveSingle("SELECT *FROM  password_reset WHERE email = '$email'");
        if (empty($checkUserReset)) {
            $data = [
                'email' => "$email",
                'reset_code' => "$reset_code"
            ];
            if ($operation->insertData($table, $data)) {

                $output = "Hello " . $getUser['fname'] . ", You have requested to reset your account, please enter the following code below to verify your email ";

                $body = "
                        <div style='max-width:600px;margin:0px auto; border:1px solid #F1F3F4;border-radius:5px; padding:16px;background-color:#F1F3F4;'>
                       
                        <hr style='border:1px solid #163665;'>
                        <div>
                        $output
                        </div>
                                                <br/>
                                                <p style='align-items: center'><b>" . $reset_code . "</b></p>
                        <div>
                        ";

                $mailer_name = "ADMARC";
                $mailer_email = "info@ulendowathu.com";
                $mailer_password = "ulendoinfo21!";
                $mailer_website = "ulendowathu.com";

                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true; // authentication enabled
                $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host = "mail.ulendowathu.com";
                $mail->Port = 587; // or 587
                $mail->IsHTML(true);
                $mail->Username = $mailer_email;
                $mail->Password = $mailer_password;
                $mail->setFrom($mailer_email, $mailer_name);
                $mail->AddEmbeddedImage("../../assets/images/logo.png", "ADMARC");
                $mail->Subject = "PASSWORD RESET";
                $mail->Body = $body;

                $mail->addAddress($email);

                $mail->Send();
                //Clear all addresses and attachments for the next iteration
                $mail->clearAddresses();
                $mail->clearAttachments();

                $_SESSION['email_reset'] = $email;

                echo json_encode(array("code" => 1, "msg" => "We have sent you an email with instructions on how to reset you password, check spam folder if you can't see it!"));

            } else {
                echo json_encode(array("code" => 2, "msg" => "An error occurred while processing, please try again later!"));
            }
        } else {
            $data = [
                'reset_code' => "$reset_code"
            ];
            $where = "email = '$email'";
            if ($operation->updateData($table, $data, $where)) {
                $output = "Hello " . $getUser['fname'] . ", You have requested to reset your account, please enter the following code below to verify your email ";

                $body = "
                        <div style='max-width:600px;margin:0px auto; border:1px solid #F1F3F4;border-radius:5px; padding:16px;background-color:#F1F3F4;'>
                       
                        <hr style='border:1px solid #163665;'>
                        <div>
                        $output
                        </div>
                                                <br/>
                                                <p style='align-items: center'><b>" . $reset_code . "</b></p>
                        <div>
                        ";

                $mailer_name = "ADMARC";
                $mailer_email = "info@ulendowathu.com";
                $mailer_password = "ulendoinfo21!";
                $mailer_website = "ulendowathu.com";

                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true; // authentication enabled
                $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host = "mail.ulendowathu.com";
                $mail->Port = 587; // or 587
                $mail->IsHTML(true);
                $mail->Username = $mailer_email;
                $mail->Password = $mailer_password;
                $mail->setFrom($mailer_email, $mailer_name);
                $mail->AddEmbeddedImage("../../assets/images/logo.png", "ADMARC");
                $mail->Subject = "PASSWORD RESET";
                $mail->Body = $body;

                $mail->addAddress($email);

                $mail->Send();
                //Clear all addresses and attachments for the next iteration
                $mail->clearAddresses();
                $mail->clearAttachments();

                $_SESSION['email_reset'] = $email;

                echo json_encode(array("code" => 1, "msg" => "We have sent you an email with instructions on how to reset you password, check spam folder if you can't see it!"));

            } else {
                echo json_encode(array("code" => 2, "msg" => "An error occurred while processing, please try again later!"));
            }
        }

    } else {
        echo json_encode(array("code" => 2, "msg" => "No account with specified email exists!"));

    }


} elseif (isset($_POST['reset_email']) && !empty($_POST['reset_email']) && isset($_POST['reset_code']) && !empty($_POST['reset_code'])) {
    $email = addslashes($_POST['reset_email']);
    $code = addslashes($_POST['reset_code']);

    $getData = $operation->retrieveSingle("SELECT *FROM password_reset WHERE email = '$email' AND reset_code = '$code'");

    if (!empty($getData)) {
        echo json_encode(array("code" => 1, "msg" => "Email verified, please wait!"));
    } else {
        echo json_encode(array("code" => 2, "msg" => "Email or reset code verification code failed!"));

    }
} elseif (isset($_POST['password_reset_email']) && !empty($_POST['password_reset_email']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $email = addslashes($_POST['password_reset_email']);
    $password = password_hash(addslashes($_POST['password']), PASSWORD_DEFAULT);

    $table = "users";
    $where = "email = '$email'";
    $data = [
        'password' => "$password"
    ];

    if ($operation->updateData($table, $data, $where) == 1) {
        $getUser = $operation->retrieveSingle("SELECT *FROM users WHERE email = '$email'");

        $output = "Hello " . $getUser['fname'] . ", You have successfully resetted your password. Here is your new password for login:  ";

        $body = "
                        <div style='max-width:600px;margin:0px auto; border:1px solid #F1F3F4;border-radius:5px; padding:16px;background-color:#F1F3F4;'>
                       
                        <hr style='border:1px solid #163665;'>
                        <div>
                        $output
                        </div>
                                                <br/>
                                                <p style='align-items: center'><b>" . addslashes($_POST['password']) . "</b></p>
                        <div>
                        ";

        $mailer_name = "ADMARC";
        $mailer_email = "info@ulendowathu.com";
        $mailer_password = "ulendoinfo21!";
        $mailer_website = "ulendowathu.com";

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "mail.ulendowathu.com";
        $mail->Port = 587; // or 587
        $mail->IsHTML(true);
        $mail->Username = $mailer_email;
        $mail->Password = $mailer_password;
        $mail->setFrom($mailer_email, $mailer_name);
        $mail->AddEmbeddedImage("../../assets/images/logo.png", "ADMARC");
        $mail->Subject = "PASSWORD RESET SUCCESSFUL";
        $mail->Body = $body;

        $mail->addAddress($email);

        $mail->Send();
        //Clear all addresses and attachments for the next iteration
        $mail->clearAddresses();
        $mail->clearAttachments();

        unset($_SESSION['email_reset']);

        echo json_encode(array("code" => 1, "msg" => "You have successfully resetted your password, please login to continue!"));


    } else {
        echo json_encode(array("code" => 2, "msg" => "Password reset failed, please try again later!"));

    }


}
