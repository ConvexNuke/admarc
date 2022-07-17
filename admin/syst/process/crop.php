<?php

if(isset($_POST['image_name']) && isset($_POST['x']) && isset($_POST['y']) && isset($_POST['h']) && isset($_POST['w']) ){
    $targ_w = $targ_h = 150;
  $jpeg_quality = 90;

  $src = 'uploads/'.$_POST['image_name'];
  $img_r = imagecreatefromjpeg($src);
  $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

  imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
      $targ_w,$targ_h,$_POST['w'],$_POST['h']);

  //header('Content-type: image/jpeg');
  //imagejpeg($dst_r, null, $jpeg_quality);
  imagejpeg($dst_r, $_POST['image_name'], $jpeg_quality);
}



?>