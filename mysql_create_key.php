<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-6
 * Time: 下午1:15
 */
function addKey(){
    $mysql=mysqli_connect("localhost","alex","z198569l","my_page")or die(mysqli_error($mysql));
    $str="ilovealex1314";
//    $name="alex";
//    $password=sha1("z198569l");
//    $key=sha1("ilovemengting");
//    $keys=substr($key,0,20);
//    $name2="fiona";
//    $password2=sha1("2526fc");
//    $key2=sha1("ilovezhangli");
//    $keys2=substr($key2,0,20);
//    mysqli_query($mysql,"insert into tb_user_login_info (`user_account`,`user_password`,`key`,`key_summary`)VALUES ('".$name."','".$password."','".$key."','".$keys."'),('".$name2."','".$password2."','".$key2."','".$keys2."')");
    for($i=0;$i!=100;$i++){
        $in=sprintf("%02u",$i);
        $is=strval($in);
        $key0=sha1($str.$is."0");
        $key1=sha1($str.$is."1");
        $key2=sha1($str.$is."2");
        $key3=sha1($str.$is."3");
        $key4=sha1($str.$is."4");
        $key5=sha1($str.$is."5");
        $key6=sha1($str.$is."6");
        $key7=sha1($str.$is."7");
        $key8=sha1($str.$is."8");
        $key9=sha1($str.$is."9");
        $key0s=substr($key0,0,20);
        $key1s=substr($key1,0,20);
        $key2s=substr($key2,0,20);
        $key3s=substr($key3,0,20);
        $key4s=substr($key4,0,20);
        $key5s=substr($key5,0,20);
        $key6s=substr($key6,0,20);
        $key7s=substr($key7,0,20);
        $key8s=substr($key8,0,20);
        $key9s=substr($key9,0,20);
        $pri=6;
        mysqli_query($mysql,"insert into tb_user_login_info (`key`,`key_summary`,`priority`)VALUES ('$key0','$key0s','$pri'),('$key1','$key1s','$pri'),('$key2','$key2s','$pri'),('$key3','$key3s','$pri'),('$key4','$key4s','$pri'),('$key5','$key5s','$pri'),('$key6','$key6s','$pri'),('$key7','$key7s','$pri'),('$key8','$key8s','$pri'),('$key9','$key9s','$pri')")or die(mysqli_error($mysql));
    }
}
$stime=microtime(true);
addKey();
$etime=microtime(true);
echo $etime-$stime;

