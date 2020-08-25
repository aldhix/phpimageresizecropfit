<?php
$file = $_FILES['image'];
$filename = 'resize';
$type = str_replace('image/', '', $file['type']);
if($type == 'jpeg'){
	$orig_image = imagecreatefromjpeg($file['tmp_name']);
} else {
	$orig_image = imagecreatefrompng($file['tmp_name']);
}

list($width,$height) = getimagesize($file['tmp_name']);

if(max($width,$height) > 200){
  $scale = 200/max($width,$height);
  $new_width = floor($width*$scale);
  $new_height = floor($height*$scale);
  $save_image = imagecreatetruecolor($new_width,$new_height);
  $white = imagecolorallocate($save_image,255, 255, 255);
  imagefill($save_image, 0, 0, $white);
  imagecopyresampled($save_image,$orig_image,0,0,0,0, $new_width, $new_height, $width,$height);

  if($type == 'jpeg'){
  	imagejpeg($save_image,"images/{$filename}.jpg");
  } else {
  	imagejpeg($save_image,"images/{$filename}.png");
  }
  imagedestroy($save_image);
}