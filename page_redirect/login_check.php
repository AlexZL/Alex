<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14-12-31
 * Time: 上午10:25
 */
session_start();
require("../include/Alex.php");
$user_name=$_POST["login_user_name"];
$user_password=$_POST["login_user_password"];
$page_code="";
if(isset($_GET["page_code"])){
    $page_code=$_GET["page_code"];
    $go_page=myCode($page_code);
}                             //根据不同的code验证后跳转到不同页面

$user_name_check=check_name($user_name);
$user_password_check=check_password("$user_password");
if(empty($user_name)||empty($user_password)){
    toWrongPage(0,$page_code);
}
if($user_name_check===2){
    toWrongPage(2,$page_code);

}
if($user_name_check===3){
    toWrongPage(3,$page_code);

}
if($user_name_check===4){
    toWrongPage(4,$page_code);

}

if($user_password_check===2){
    toWrongPage(6,$page_code);

}
if($user_password_check===3){
    toWrongPage(7,$page_code);

}
if($user_password_check===4){
    toWrongPage(8,$page_code);

}

$user_name_check=mb_strtolower($user_name_check,"UTF-8");
setMyCookie($user_name_check);

//检查数据库匹配
$login_date=date("Y-m-d H:i:s");
$mysql=new mysqli("localhost","alex","z198569l","my_page");
$result=$mysql->query("select `user_ID`,`user_name`,`user_password`,`register_time`,`last_user_agent`,`last_login_IP`,`priority` from tb_user_login_info where `user_account`='$user_name_check'");
$obj=$result->fetch_object();
$date=$obj->register_time;
if($obj->user_password==sha1($user_password_check.$date)){  //验证通过
    if(preg_match("/^alex$/",$user_name_check)){
        $_SESSION["user_name"]=$user_name_check.":".$obj->user_ID.":".$obj->priority.":".$obj->user_name;
        setMyCookie($user_name_check);
        $result->close();
        $mysql->query("update tb_user_login_info set `last_login_time`='$login_date' WHERE `user_account`='$user_name_check'")or die(mysqli_error($mysql));
        $mysql->close();
        if(!isset($_GET["page_code"])){
            header("location:".$server_ip_addr."Alex/Users/User_main.php");
            exit;
        }else{
            header("location:".$go_page);
            exit;
        }
    }
    if(preg_match("/^fiona$/",$user_name_check)){
        $_SESSION["user_name"]=$user_name_check.":".$obj->user_ID.":".$obj->priority.":".$obj->user_name;
        setMyCookie($user_name_check);
        $result->close();
        $mysql->query("update tb_user_login_info set `last_login_time`='$login_date' WHERE `user_account`='$user_name_check'");
        $mysql->close();
        if(!isset($_GET["page_code"])){
            header("location:".$server_ip_addr."Alex/Users/User_main.php");
            exit;
        }else{
            header("location:".$go_page);
            exit;
        }
    }
    if($obj->priority==9){ //普通用户
        $_SESSION["user_name"]=$user_name_check.":".$obj->user_ID.":".$obj->priority.":".$obj->user_name;
        setMyCookie($user_name_check);
        $result->close();
        $mysql->query("update tb_user_login_info set `last_login_time`='$login_date' WHERE `user_account`='$user_name_check'");
        $mysql->close();
        if(!isset($_GET["page_code"])){
            header("location:".$server_ip_addr."Alex/Users/User_main.php");
            exit;
        }else{
            header("location:".$go_page);
            exit;
        }
    }
    if($obj->priority==6){ //VIP用户
        $_SESSION["user_name"]=$user_name_check.":".$obj->user_ID.":".$obj->priority.":".$obj->user_name;
        setMyCookie($user_name_check);
        $result->close();
        $mysql->query("update tb_user_login_info set `last_login_time`='$login_date' WHERE `user_account`='$user_name_check'");
        $mysql->close();
        if(!isset($_GET["page_code"])){
            header("location:".$server_ip_addr."Alex/Users/User_main.php");
            exit;
        }else{
            header("location:".$go_page);
            exit;
        }
    }
}else{
    $result->close();
    $mysql->close();
    toWrongPage(14,$page_code);
}