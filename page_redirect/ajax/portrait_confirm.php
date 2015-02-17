<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/8
 * Time: 20:58
 */
$src_x=$_POST["src_x"];
$src_y=$_POST["src_y"];
$src_width=$_POST["src_width"];
$src_height=$_POST["src_height"];
$UID=$_POST["UID"];
$file_type=$_POST["type"];
$portrait_tmp="../".$_POST["portrait_tmp"];
$output=array();
$rand=rand(0,999);
$portrait_confirm_L_location="../../media/images/portrait/".$UID."/".$rand."_L.".$file_type;
$portrait_confirm_M_location="../../media/images/portrait/".$UID."/".$rand."_M.".$file_type;
$portrait_confirm_S_location="../../media/images/portrait/".$UID."/".$rand."_S.".$file_type;
$portrait_confirm_L=imagecreatetruecolor(400,400);
$portrait_confirm_M=imagecreatetruecolor(200,200);
$portrait_confirm_S=imagecreatetruecolor(100,100);
switch($file_type){
    case "jpg":
        array_map("unlink",array_filter(glob("../../media/images/portrait/".$UID."/*"), "is_file"));
        $src_img=imagecreatefromjpeg($portrait_tmp);
        imagecopyresampled($portrait_confirm_L,$src_img,0,0,$src_x,$src_y,400,400,$src_width,$src_height);
        imagecopyresampled($portrait_confirm_M,$src_img,0,0,$src_x,$src_y,200,200,$src_width,$src_height);
        imagecopyresampled($portrait_confirm_S,$src_img,0,0,$src_x,$src_y,100,100,$src_width,$src_height);
        imagejpeg($portrait_confirm_L,$portrait_confirm_L_location,100);
        imagejpeg($portrait_confirm_M,$portrait_confirm_M_location,100);
        imagejpeg($portrait_confirm_S,$portrait_confirm_S_location,100);

        break;
    case "png":
        array_map("unlink",array_filter(glob("../../media/images/portrait/".$UID."/*"), "is_file"));
        $src_img=imagecreatefrompng($portrait_tmp);
        $color=imagecolorallocate($img_new,255,255,255);  //上色
        imagecolortransparent($img_new,$color);           //设置透明
        imagefill($img_new,0,0,$color);                   //设置透明
        imagecopyresampled($portrait_confirm_L,$src_img,0,0,$src_x,$src_y,400,400,$src_width,$src_height);
        imagecopyresampled($portrait_confirm_M,$src_img,0,0,$src_x,$src_y,200,200,$src_width,$src_height);
        imagecopyresampled($portrait_confirm_S,$src_img,0,0,$src_x,$src_y,100,100,$src_width,$src_height);
        imagepng($portrait_confirm_L,$portrait_confirm_L_location,8);
        imagepng($portrait_confirm_M,$portrait_confirm_M_location,8);
        imagepng($portrait_confirm_S,$portrait_confirm_S_location,8);
        break;
}
unlink($portrait_tmp);
$portrait_confirm_L_location=substr($portrait_confirm_L_location,6);
$portrait_confirm_M_location=substr($portrait_confirm_M_location,6);
$portrait_confirm_S_location=substr($portrait_confirm_S_location,6);
$mysql=new mysqli("localhost","alex","z198569l","my_page");
$mysql->query("update tb_user_login_info set `user_portrait_L`='$portrait_confirm_L_location',`user_portrait_M`='$portrait_confirm_M_location',`user_portrait_S`='$portrait_confirm_S_location' WHERE `user_ID`='$UID'");
$mysql->close();
$output["status"]="OK";
$output["rand_num"]=$rand;
echo json_encode($output);


