<?php
require("../../mailing/vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("../../mailing/vendor/phpmailer/phpmailer/src/SMTP.php");
require("../../mailing/vendor/phpmailer/phpmailer/src/Exception.php");
include("../../connection/Functions.php");
$operation = new Functions();
//add driver
if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password']) && !empty($_POST['city_name']) && !empty($_POST['access_level']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['city_name']) && isset($_POST['access_level'])){
    $fname = addslashes($_POST['fname']);
    $lname = addslashes($_POST['lname']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $password = addslashes($_POST['password']);
    $city_id = addslashes($_POST['city_name']);
    $access_level = addslashes($_POST['access_level']);
    $role = "driver";
    $encrptedPass=password_hash($password, PASSWORD_DEFAULT);
    $table = "admins";
    $data = [
        'city_id'=>"$city_id",
        'access_level'=>"$access_level",
        'fname'=>"$fname",
        'lname'=>"$lname",
        'email'=>"$email",
        'phone'=>"$phone",
        'password'=>"$encrptedPass",
        'account_status'=>"1",
    ];
    //check if email is free
    if($operation->countAll("SELECT *FROM admins WHERE email = '$email'") == 0){
        if($operation->insertData($table,$data) == 1){

            //send email
            $output='<p>Dear '.$fname." ".$lname.',</p>';
            $output.='<p>Use the following credentials to login into your Ordermw Admin Account, Please Keep the Information confidential</p>';
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p>Email: '.$email.'<br/> Password: '.$password.'</p>';		
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p>Thanks,</p>';
            $output.='<p>OrderMw, Food Order and Delivery System.</p>';
            $body = $output; 
            $message = " " ;
            $headers = "From :  Admin Support - ordermw.com";

            $mail = new PHPMailer\PHPMailer\PHPMailer();
           //$mail->IsSMTP(); // enable SMTP
           $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
           $mail->SMTPAuth = true; // authentication enabled
           $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
           $mail->Host = "mail.netsoftmw-test.com";
           $mail->Port = 587; // or 587
           $mail->IsHTML(true);
           $mail->Username = "support@gdg.com";
           $mail->Password = "xxxxx1";
           $mail->setFrom("support@netsoftmw-test.com","OrderIn");
           $mail->Subject = $subject;
           $mail->Body = $body;
           $mail->addAddress($email);

             if(!$mail->Send()){
             }else{
             }
        echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
    }else{
        echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later!"));
    } 
    }else{
         echo json_encode(array("code"=>2,"msg"=>"Email is already taken, use a different one!"));
    }
    
    //edit driver
}elseif(!empty($_POST['efname']) && !empty($_POST['elname']) && !empty($_POST['eemail']) && !empty($_POST['ephone'])  && !empty($_POST['ecity_name']) && isset($_POST['efname']) && isset($_POST['elname']) && isset($_POST['eemail']) && isset($_POST['ephone'])  && isset($_POST['ecity_name']) && isset($_POST['admin_id']) && !empty($_POST['admin_id']) && isset($_POST['eaccess_level']) && !empty($_POST['eaccess_level'])){
    $fname = addslashes($_POST['efname']);
    $lname = addslashes($_POST['elname']);
    $email = addslashes($_POST['eemail']);
    $phone = addslashes($_POST['ephone']);
    $password = addslashes($_POST['epassword']);
    $city_id = addslashes($_POST['ecity_name']);
    $admin_id = addslashes($_POST['admin_id']);
    $access_level = addslashes($_POST['eaccess_level']);
    
    $where = "user_id = '$admin_id'";
    if(!empty($_POST['epassword'])){
        $encrptedPass=password_hash($password, PASSWORD_DEFAULT);
        $table = "admins";
        $data = [
            'city_id'=>"$city_id",
            'access_level'=>"$access_level",
            'fname'=>"$fname",
            'lname'=>"$lname",
            'email'=>"$email",
            'phone'=>"$phone",
            'password'=>"$encrptedPass",
            'account_status'=>"1",
        ];
        
        if($operation->updateData($table,$data,$where) == 1){
            echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
        }else{
            echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later!"));
        } 
    }else{
           $table = "admins";
        $data = [
            'city_id'=>"$city_id",
            'access_level'=>"$access_level",
            'fname'=>"$fname",
            'lname'=>"$lname",
            'email'=>"$email",
            'phone'=>"$phone",
            'account_status'=>"1",
        ];
        if($operation->updateData($table,$data,$where) == 1){
            echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
        }else{
            echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later!"));
        } 
    }
    //delete driver
}elseif(isset($_POST['del_id']) && !empty($_POST['del_id'])){
    $id = addslashes($_POST['del_id']);
    $where = "user_id = '$id'";
    $table = "admins";
    if($operation->deleteData($table,$where) == 1){
        echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
    }else{
        echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later"));
    }
    
//    change account status
}elseif(isset($_POST['status_id']) && !empty($_POST['status_id'])){
    $id = addslashes($_POST['status_id']);
    $where = "user_id = '$id'";
    
    //get current status
    $status = '';
    $response = '';
    $getStatus = $operation->retrieveSingle("SELECT * FROM `admins` WHERE user_id = '$id'");
    if($getStatus['account_status'] == 0){
        $status = 1;
        $response = "Deactivate";
    }else{
        $status = 0;
        $response = "Activate";
    }
    
    $table = "admins";
    $data = [
        'account_status'=>"$status"
    ];
    if($operation->updateData($table,$data,$where) == 1){
        echo json_encode(array("code"=>1,"msg"=>"Admin account ".$response."d","btnMessage"=>"$response"));
    }else{
        echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later"));
    }
}

 


?>