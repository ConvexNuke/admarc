<?php
require("../../mailing/vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("../../mailing/vendor/phpmailer/phpmailer/src/SMTP.php");
require("../../mailing/vendor/phpmailer/phpmailer/src/Exception.php");
include("../../connection/Functions.php");
$operation = new Functions();
//edit personal info
if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['phone'])  && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['personal_id']) && !empty($_POST['personal_id'])){
    $fname = addslashes($_POST['fname']);
    $lname = addslashes($_POST['lname']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $personal_id = addslashes($_POST['personal_id']);
    $table = "admins";
    $data = [
        'fname'=>"$fname",
        'lname'=>"$lname",
        'email'=>"$email",
        'phone'=>"$phone",
    ];
    $where = "user_id = '$personal_id'";
  
    //check if email is free
    if($operation->countAll("SELECT *FROM admins WHERE email = '$email'") == 0){
        if($operation->updateData($table,$data,$where) == 1){
          echo json_encode(array("code"=>1,"msg"=>"Success, refreshing, please wait..."));
        }else{
          echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later!"));
        } 
    }else{
        //check if the email owner is someone other than this one  
        $User = $operation->retrieveSingle("SELECT *FROM admins WHERE email = '$email' ");
          if($User['user_id'] == $personal_id){
            if($operation->updateData($table,$data,$where) == 1){
              echo json_encode(array("code"=>1,"msg"=>"Success, refreshing, please wait..."));
            }else{
              echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later!"));
            } 
          }else{
             echo json_encode(array("code"=>2,"msg"=>"Email is already taken, use a different one!"));
          }
        
    }
    
    //edit password
}elseif(!empty($_POST['cpass']) && !empty($_POST['npass']) && !empty($_POST['pass_id']) && isset($_POST['cpass']) && isset($_POST['npass']) && isset($_POST['pass_id']) ){
    $cpass = addslashes($_POST['cpass']);
    $npass = addslashes($_POST['npass']);
    $pass_id = addslashes($_POST['pass_id']);

    
    $where = "user_id = '$pass_id'";
    $getUser = $operation->retrieveSingle("SELECT *FROM admins WHERE user_id = '$pass_id'");
  
    if(password_verify($cpass,$getUser['password'])){
        $encrptedPass=password_hash($npass, PASSWORD_DEFAULT);
        $table = "admins";
        $data = [
            'password'=>"$encrptedPass",
        ];
        
        if($operation->updateData($table,$data,$where) == 1){
            echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
        }else{
            echo json_encode(array("code"=>2,"msg"=>"An error occured, please try again later!"));
        } 
    }else{
      echo json_encode(array("code"=>2,"msg"=>"Wrong current password"));
    }
  
 
    
    //delete driver
}
   


?>