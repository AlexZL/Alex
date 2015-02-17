<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-10
 * Time: 下午5:49
 */
move_uploaded_file($_FILES['upload']['tmp_name'],"x.png");
//list($width,$height)=getimagesize("x.jpeg");
//echo $width;echo $height;
//$img_new=imagecreatetruecolor(200,200);
//$img_old=imagecreatefromjpeg("x.jpeg");
//imagecopyresampled($img_new,$img_old,0,0,0,0,200,200,$width,$height);
//imagejpeg($img_new,"y.jpeg",100);

$img_old=imagecreatefrompng("x.png");
$arr=getimagesize("x.png");
$old_width=$arr[0];
$old_height=$arr[1];
$percent=round(600/$old_width,3);
$new_width=600;
$new_height=$old_height*$percent;
$img_new=imagecreatetruecolor($new_width,$new_height);
imagecopyresampled($img_new,$img_old,0,0,0,0,$new_width,$new_height,$old_width,$old_height);
imagepng($img_new,"y.png",100);
?>