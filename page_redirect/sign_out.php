<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-10
 * Time: 下午8:52
 */
session_start();
require("../include/Alex.php");
$cookie_name2=substr(sha1("mengting"),0,12);
$cookie_name="A".$cookie_name2;
setcookie($cookie_name,"",time()-1,"/");
unset($_SESSION['user_name']);
session_destroy();
if(isset($_GET["page_code"])){
    $page_code=$_GET["page_code"];
    $go_page=myCode($page_code);
    header("location:".$go_page);
    exit;
}else{
    toLoginPage();
}