<?php
require("../../mailing/vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("../../mailing/vendor/phpmailer/phpmailer/src/SMTP.php");
require("../../mailing/vendor/phpmailer/phpmailer/src/Exception.php");
include("../../connection/Functions.php");
$operation = new Functions();
// print_r($_POST);die();
 if(isset($_POST['reset_email']) && !empty($_POST['reset_email'])){
     $email = addslashes($_POST['reset_email']);
     //check email
     $countEmail = $operation->countAll("SELECT * FROM `admins` WHERE email = '$email'");
     if($countEmail > 0 ){
        
      	    $expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+1, date("Y"));
	        $expDate = date("Y-m-d H:i:s",$expFormat);
	        $code = rand(1111,3333);
            $role = "admin";
            $table = "password_reset";
            $data = [
                'email' =>"$email",
                'code' => "$code",
                'expiry_date' => "$expDate",
                'role' => "$role",
            ];
            

        if($operation->insertData($table,$data) == 1){
            $output='<p>Dear '.$email.',</p>';
           $output.='<p>Please enter the following code on the prompt to reset your password:</p>';
           $output.='<br/><p align="center">	
               '.$code.'
           </p><br/>'; 
           $output.='<p>
           The reset session will expire after 1 day for security reason.</p>';
           $output.='<p>If you did not request this forgotten password email, no action 
           is needed, your password will not be reset. However, you may want to log into 
           your account and change your security password.</p>';   
           $output.='<p>Regards,</p>';
           $output.='<p><strong>OrderIn Team</strong></p>';
           $body = $output; 
           $subject = "Password Recovery - OrderIn";

           //echo $output;
           //die();

           $email_to = $email;
           $fromserver = "noreply@Dyuni"; 

   
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
                echo json_encode(array("code"=>2,"msg"=>"An error occured please try again later!"));
            }else{
                echo json_encode(array("code"=>1,"msg"=>"A reset code has been sent to your email address"));
            } 
        }else{
           echo json_encode(array("code"=>2,"msg"=>"An error occured please try again later!"));
        }
      
		 
		
     }else{
       echo json_encode(array("code"=>2,"msg"=>"Sorry, the entered email not found!"));
     }
    //check the code sent
 }elseif(isset($_POST['cemail']) && !empty($_POST['cemail']) && isset($_POST['code'])){
     $email = addslashes($_POST['cemail']);
     $code = addslashes($_POST['code']);
     //check email
     $getEmail = $operation->retrieveSingle("SELECT * FROM `password_reset` WHERE email = '$email' AND role='admin' ORDER BY id DESC");
     $expDate = $getEmail['expiry_date'];
     $curDate = date("Y-m-d H:i:s");
    

  
     if ($expDate >= $curDate){
      if($getEmail['code'] == $code ){
       
         echo json_encode(array("code"=>1,"msg"=>"Success, please wait"));
             
         }else{
            echo json_encode(array("code"=>2,"Sorry, the entered code is wrong!"));
         }



      }else{
        echo json_encode(array("code"=>2,"msg"=>"Sorry, the entered code has expired!"));
      }
    }elseif(isset($_POST['pass1']) && isset($_POST['remail'])){
      $email = addslashes($_POST['remail']);
      $pass = addslashes($_POST['pass1']);
    
      $passwordHash = password_hash($pass,PASSWORD_DEFAULT);
      $table = 'admins';
     $data = [
      'password'=>"$passwordHash"
     ];
     $where = "email = '$email'";
    if($operation->updateData($table,$data,$where) == 1){
       echo json_encode(array("code"=>1,"msg"=>"Success, redirecting!"));
    }else{
      echo json_encode(array("code"=>2,"Sorry, password reset failed, try again later!"));
    }
    
   }



?>