<?php
include("../../connection/Functions.php");
$operation = new Functions();

if(isset($_FILES['profile1']) && isset($_POST['profile_id'])){
    /* Getting file name */
    $id = $_POST['profile_id'];
    $images = $_FILES['profile1']['name'];
    $image=strtolower(pathinfo($images,PATHINFO_EXTENSION));
    $filename=rand(1000, 1000000).".".$image;
    /* Location */
    $location = "../uploads/".$filename;
    $uploadOk = 1;
    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

    /* Valid Extensions */
    $valid_extensions = array("jpg","jpeg","png");
    /* Check file extension */
    if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
       $uploadOk = 0;
    }
    
    
    if($uploadOk == 0){
         echo json_encode(array("code"=>2,"msg"=>"✖ File type not supported, try jpg, jpeg or png!"));
    }else{
       /* Upload file */
       if(move_uploaded_file($_FILES['profile1']['tmp_name'],$location)){
        
           $checkImg = $operation->retrieveSingle("SELECT *FROM admins WHERE user_id = '$id'");
           
           if($checkImg['img_url'] == ""){
               $table = "admins";
               $data = [
                 'img_url' => "$filename"  
               ];
               $where = "user_id = '$id'";
               
               if($operation->updateData($table,$data,$where) == 1){
//                   echo $filename;
                   echo json_encode(array("code"=>1,"msg"=>$filename));
               }else{
//                   echo 0;
                   echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
               }
               
           }else{
               $directory = "../uploads/".$checkImg['img_url'];
               if(unlink($directory)){
                   $table = "admins";
                   $data = [
                     'img_url' => "$filename"  
                   ];
                   $where = "user_id = '$id'";

                   if($operation->updateData($table,$data,$where) == 1){
//                       echo $filename;
                       echo json_encode(array("code"=>1,"msg"=>$filename));
                   }else{
                       echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
                   }
               }else{
                    echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
               }
           }
          
       }else{
          echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
       }
    }
}


?>