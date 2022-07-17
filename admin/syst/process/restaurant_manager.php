<?php
include("../../connection/Functions.php");
$operation = new Functions();

//add restaurant
if(isset($_POST['city_name']) && isset($_POST['restaurant_name']) && isset($_POST['address']) && isset($_POST['restaurant_phone']) && !empty($_POST['city_name']) && !empty($_POST['restaurant_name']) && !empty($_POST['address']) && isset($_FILES['restaurant_icon']) ){
    $city_id = addslashes($_POST['city_name']);
    $restaurant_name = addslashes($_POST['restaurant_name']);
    $address = addslashes($_POST['address']);
    $phone = addslashes($_POST['restaurant_phone']);
//    $google_address = addslashes($_POST['pac-input']);
//    $place_id = addslashes($_POST['place_id']);
    
    //validate restaurant icon
    $images = $_FILES['restaurant_icon']['name'];
     $image=strtolower(pathinfo($images,PATHINFO_EXTENSION));
    $filename=rand(1000, 1000000).".".$image;
    /* Location */
    $location = "../../images/".$filename;
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
       if(move_uploaded_file($_FILES['restaurant_icon']['tmp_name'],$location)){
            //save into database
            $table = "restaurant_info";
            $data = [
                'city_id'=>"$city_id",
                'restaurant_name'=>"$restaurant_name",
                'restaurant_phone'=>"$phone",
                'restaurant_address'=>"$address",
                'img_url' => "$filename" 
        //        'placeID'=>"$place_id",
        //        'exact_location'=>"$google_address"
            ];

            if($operation->insertData($table,$data) == 1){
                echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
            }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured, please try again later"));
            }
       }else{
          echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
       }
        
    }  
//    edit restaurant
}else if(isset($_POST['ecity_name']) && isset($_POST['erestaurant_name']) && isset($_POST['erestaurant_phone']) && isset($_POST['eaddress']) && !empty($_POST['ecity_name']) && !empty($_POST['erestaurant_name']) && !empty($_POST['eaddress']) && isset($_POST['restaurant_id']) && !empty($_POST['restaurant_id']) ){
    $city_id = addslashes($_POST['ecity_name']);
    $restaurant_name = addslashes($_POST['erestaurant_name']);
    $address = addslashes($_POST['eaddress']);
    $phone = addslashes($_POST['erestaurant_phone']);
//    $google_address = addslashes($_POST['epac-input']);
//    $place_id = addslashes($_POST['eplace_id']);
    $restaurant_id = addslashes($_POST['restaurant_id']);
    $table = "restaurant_info";
    $where = "restaurant_id = '$restaurant_id'";
    $data = [
        'city_id'=>"$city_id",
        'restaurant_name'=>"$restaurant_name",
        'restaurant_phone'=>"$phone",
        'restaurant_address'=>"$address",
//        'placeID'=>"$place_id",
//        'exact_location'=>"$google_address"
    ];
    
    if($operation->updateData($table,$data,$where) == 1){
        echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
    }else{
        echo json_encode(array("code"=>2,"msg"=>"✖ An error occured, please try again later"));
    }
    
//    delete restaurant
}elseif(isset($_POST['del_id']) && !empty($_POST['del_id'])){
    $id = addslashes($_POST['del_id']);
    $where = "restaurant_id = '$id'";
    $table = "restaurant_info";
    
        //get current restaurant icon
    $getRestaurantInfo = $operation->retrieveSingle("SELECT * FROM `restaurant_info` WHERE restaurant_id = '$id'");
    
    if($getRestaurantInfo['img_url'] !=''){
        $directory = "../../images/".$getRestaurantInfo['img_url'];
        //delete old file
        if(unlink($directory)){
            if($operation->deleteData($table,$where) == 1){
                echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
            }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured, please try again later"));
            }  
        }else{
            echo json_encode(array("code"=>2,"msg"=>"✖ An error occured, please try again later"));
        }
    }else{
          if($operation->deleteData($table,$where) == 1){
                echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
            }else{
                echo json_encode(array("code"=>2,"msg"=>"✖ An error occured, please try again later"));
            } 
    }
    

    
    
    
  
    
    //change restaurant_icon
}elseif(isset($_POST['erestaurant_id']) && !empty($_POST['erestaurant_id']) && isset($_FILES['erestaurant_icon']) ){
    $restaurant_id = addslashes($_POST['erestaurant_id']);
    //validate restaurant icon
    $images = $_FILES['erestaurant_icon']['name'];
     $image=strtolower(pathinfo($images,PATHINFO_EXTENSION));
    $filename=rand(1000, 1000000).".".$image;
    /* Location */
    $location = "../../images/".$filename;
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
        //get current restaurant icon
        $getRestaurantInfo = $operation->retrieveSingle("SELECT * FROM `restaurant_info` WHERE restaurant_id = '$restaurant_id'");
        $directory = "../../images/".$getRestaurantInfo['img_url'];
        //delete old file
        if(unlink($directory)){
            
        /* Upload file */
       if(move_uploaded_file($_FILES['erestaurant_icon']['tmp_name'],$location)){
            //save into database
            $table = "restaurant_info";
            $data = [
                'img_url' => "$filename" 
            ];
           $where = "restaurant_id = '$restaurant_id'";

                if($operation->updateData($table,$data,$where) == 1){
                    echo json_encode(array("code"=>1,"msg"=>"Success, redirecting, please wait..."));
                }else{
                    echo json_encode(array("code"=>2,"msg"=>"✖ An error occured, please try again later"));
                }
           }else{
              echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
           }
  
        }else{
            echo json_encode(array("code"=>2,"msg"=>"✖ An error occured while saving the picture!"));
        } 
    }  
}



?>