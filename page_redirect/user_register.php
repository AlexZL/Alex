<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14-12-31
 * Time: 上午10:26
 */
session_start();
require("../include/Alex.php");
if(!$_POST['register_user_name']||!$_POST['register_user_password']){
    toWrongPage(0);
}
$register_user_name=$_POST['register_user_name'];
$register_user_password=$_POST['register_user_password'];
$register_user_password2=$_POST['register_user_password2'];
$register_user_email=$_POST["register_user_email"];
$register_user_key=$_POST["register_user_key"];
if(isset($_GET["page_code"])){
    $page_code=$_GET["page_code"];
    $go_page=myCode($page_code);
}
$name_check_return=check_name($register_user_name);
$password_check_return=check_password($register_user_password);
$email_check_return=check_email($register_user_email);
$key_check_return=check_key($register_user_key);
switch($name_check_return){
    case 2:
        toWrongPage(2);

    case 3:
        toWrongPage(3);
    case 4:
        toWrongPage(4);
}
switch($password_check_return){
    case 2:
        toWrongPage(6);
    case 3:
        toWrongPage(7);
    case 4:
        toWrongPage(8);
}
if($email_check_return==2){
    toWrongPage(9);
}
if($register_user_password!=$register_user_password2){
    toWrongPage(20);
}

if($key_check_return==4){
    toWrongPage(11);
}
if($key_check_return==2){
    toWrongPage(12);
}
if($key_check_return==3){
    toWrongPage(13);
}

$password_add=date("Y-m-d H:i:s");
$password_input=sha1($password_check_return.$password_add);
$register_ip=$_SERVER['REMOTE_ADDR'];
$register_agent=$_SERVER['HTTP_USER_AGENT'];
$name_check_return=mb_strtolower($name_check_return,"UTF-8");

if(empty($key_check_return)){
    $prio=9;
    $mysql=new mysqli("localhost","alex","z198569l","my_page");
    $mysql->query("insert into tb_user_login_info
                (`user_account`,`user_password`,`user_email`,`register_time`,`last_user_agent`,`last_login_IP`,`priority`)
                values
                ('$name_check_return','$password_input','$email_check_return','$password_add','$register_agent','$register_ip','$prio')");
    $result=$mysql->query("select `user_ID`,`user_name` from tb_user_login_info where `user_account` = '$name_check_return'");
    $obj=$result->fetch_object();
    $mysql->close();
    if(!file_exists("../media/images/portrait/".$obj->user_ID)){
        mkdir("../media/images/portrait/".$obj->user_ID);
        mkdir("../media/images/cache/".$obj->user_ID);
    }
    $_SESSION['user_name']=$user_name_check.":".$obj->user_ID.":".$prio.":".$obj->user_name;
//    creareCommonUserPage($obj->user_ID,$obj->user_name);
    if(isset($_GET["page_code"])){
        header("location".$go_page);
        exit;
    }else{
        header("location:".$server_ip_addr."Alex/Users/User_main.php");
        exit;    }
}else{
    $prio=6;
    $mysql=new mysqli("localhost","alex","z198569l","my_page");
    $mysql->query("update tb_user_login_info set
                    `user_account`='$name_check_return',
                    `user_password`='$password_input',
                    `user_email`='$email_check_return',
                    `register_time`='$password_add',
                     `last_user_agent`='$register_agent',
                     `last_login_IP`='$register_ip',
                     `priority`='$prio'
                    WHERE `key_summary`='$key_check_return'");
    $result=$mysql->query("select `user_ID`,`user_name` from tb_user_login_info where `user_account` = '$name_check_return'");
    $obj=$result->fetch_object();
    $mysql->close();
    if(!file_exists("../media/images/portrait/".$obj->user_ID)){
        mkdir("../media/images/portrait/".$obj->user_ID);
        mkdir("../media/images/cache/".$obj->user_ID);
    }
    $_SESSION['user_name']=$user_name_check.":".$obj->user_ID.":".$prio.":".$obj->user_name;
//    createVIPUserPage($obj->user_ID,$obj->user_name);
    if(isset($_GET["page_code"])){
        header("location".$go_page);
        exit;
    }else{
        header("location:".$server_ip_addr."Alex/Users/User_main.php");
        exit;
    }
}