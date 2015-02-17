<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/5
 * Time: 20:34
 */
session_start();
require("../include/Alex.php");

$out_put=array();
$output["code"]=0;
$my_session=new mySession($_SESSION["user_name"]);
$name=$my_session->name;
$account=$my_session->account;
$priority=$my_session->priority;
$UID=$my_session->user_ID;
$mysql=new mysqli("localhost","alex","z198569l","my_page");
$result=$mysql->query("select `register_time`,`user_password` from tb_user_login_info where `user_ID`='$UID'");
$obj=$result->fetch_object();
$register_time=$obj->register_time;
$password=$obj->user_password;
$result->close();
if(!isset($_SESSION["user_name"])){
    header("location:../login/wrong_page.php?code=16");
    exit;
}
if(!empty($_POST["user_name"])){
        $changed_name=trim($_POST["user_name"]);
        $mysql_user_name1=formSqlInput($_POST["user_name"]);
        $result=$mysql->query("select count(*) from tb_user_login_info WHERE `user_name`='$mysql_user_name1'");
        $row=$result->fetch_row();
        if($row[0]>0){
            $output["code"] = 5;
        }else{
            $char_length=0;
            for($i=0;$i!=mb_strlen($changed_name,"utf-8");$i++){
                $char=mb_substr($changed_name,$i,1,"utf-8");
                if(preg_match("/[a-zA-Z0-9_]/",$char)){
                    $char_length++;
                }elseif(preg_match("/[\x{4e00}-\x{9fa5}]/u",$char)){
                    $char_length+=2;
                }else{
                    toWarningPage(23,"1_0_0");
                    exit;
                }
            }
            if($char_length>14||$char_length<4){
                $output["code"]=4;
            }else{
                $mysql_user_name=$mysql_user_name1;
                $_SESSION["user_name"]=$account.":".$UID.":".$priority.":".$changed_name;
            }
        }
    $result->close();
}

if(!empty($_POST["user_sex"])){
    if($_POST["user_sex"]=="女"){
        $mysql_user_sex="F";
    }
    if($_POST["user_sex"]=="男"){
        $mysql_user_sex="M";
    }
}
if(!empty($_POST["user_password0"])) {
    if (sha1($_POST["user_password0"] . $register_time) == $password) {
        if ($_POST["user_password"] == $_POST["user_password2"]) {
            if (preg_match("/^[A-Z][a-zA-Z0-9\#\~\!\@\-\%\^\&\*\.,:;\\\$\(\)\"\[\]\{\}\<\>\?\/\\\\]{5,21}$/", trim($_POST["user_password2"]))) {
                $mysql_user_password = sha1($_POST["user_password2"] . $register_time);
            } else {
                $output["code"] = 6;
            }
        } else {
            $output["code"] = 7;
        }
    } else {
        $output["code"] = 8;
    }
}
if(!empty($_POST["user_email"])){
    $user_email=trim($_POST["user_email"]);
    $mysql_user_email1=formSqlInput($_POST["user_email"]);
    if(!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+[a-zA-Z0-9]$/",trim($user_email))||strlen($_POST["user_email"])>40){
        $output["code"]=3;
    }else{
        $result=$mysql->query("select count(*) from tb_user_login_info WHERE `user_email`='$mysql_user_email1'");
        $row=$result->fetch_row();
        if($row[0]>0){
            $output["code"] = 2;
        }else{
            $mysql_user_email=formSqlInput($_POST["user_email"]);
        }
    }
}
if(!empty($_POST["user_qq"])){
    $user_qq=trim($_POST["user_qq"]);
    $mysql_user_qq1=formSqlInput($_POST["user_qq"]);
    if(!preg_match("/^[1-9][0-9]{3,11}$/",trim($user_qq))){
        $output["code"]=10;
    }else{
        $result=$mysql->query("select count(*) from tb_user_login_info WHERE `user_qq`='$mysql_user_qq1'");
        $row=$result->fetch_row();
        if($row[0]>0){
            $output["code"] = 9;
        }else{
            $mysql_user_qq=formSqlInput($_POST["user_qq"]);
        }
    }
}

if(empty($output["code"])){
    if(isset($mysql_user_name)){
        $mysql->query("update tb_user_login_info set `user_name`='$mysql_user_name' WHERE `user_ID`='$UID'");
    }
    if(isset($mysql_user_password)){
        $mysql->query("update tb_user_login_info set `user_password`='$mysql_user_password' WHERE `user_ID`='$UID'");
    }
    if(isset($mysql_user_sex)){
        $mysql->query("update tb_user_login_info set `user_sex`='$mysql_user_sex' WHERE `user_ID`='$UID'");
    }
    if(isset($mysql_user_email)){
        $mysql->query("update tb_user_login_info set `user_email`='$mysql_user_email' WHERE `user_ID`='$UID'");
    }
    if(isset($mysql_user_qq)){
        $mysql->query("update tb_user_login_info set `user_qq`='$mysql_user_qq' WHERE `user_ID`='$UID'");
    }
    $mysql->close();
    header("location:../Users/User_main.php");
    exit;
}else{
    header("location:../Users/User_main.php?code=".$output["code"]);
    exit;
}









//if(empty($my_session->name)){
//    if(empty($changed_name)){
//        towarningPage(22,"1_0_0");
//        exit;
//    }
//    $char_length=0;
//    for($i=0;$i!=mb_strlen($changed_name,"utf-8");$i++){
//        $char=mb_substr($changed_name,$i,1,"utf-8");
//        if(preg_match("/\w/",$char)){
//            $char_length++;
//        }elseif(preg_match("/[\x{4e00}-\x{9fa5}]/u",$char)){
//            $char_length+=2;
//        }else{
//            toWarningPage(23,"1_0_0");
//            exit;
//        }
//    }
//    if($char_length>14||$char_length<4){
//        toWarningPage(21,"1_0_0");
//        exit;
//    }
//    $mysql_user_name=htmlspecialchars($changed_name);
//    $mysql_user_name=addslashes($mysql_user_name);
//    $mysql->query("update tb_user_login_info set `user_name`='$mysql_name' WHERE `user_ID`='$UID'");
//    $name=$mysql_name;
//    $_SESSION["user_name"]=$account.":".$UID.":".$priority.":".$name;
//if(!empty($_POST["user_email"])){
//    $user_email=trim($_POST["user_email"]);
//    if(!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+[a-zA-Z0-9]$/",trim($user_email))){
//        toWarningPage(24,"1_0_0");
//        exit;
//    }else{
//        $mysql_email=htmlspecialchars($user_email);
//        $mysql_email=addslashes($mysql_email);
//        $mysql->query("update tb_user_login_info set `user_email`='$mysql_email' WHERE `user_ID`='$UID'");
//    }
//}
//if(!empty($_POST["user_sex"])&&($_POST["user_sex"]=="保"||$_POST["user_sex"]=="男"||$_POST["user_sex"]=="女")){
//    $user_sex=$_POST["user_sex"];
//    $mysql->query("update tb_user_login_info set `user_sex`='$user_sex' WHERE `user_ID`='$UID'");
//
