<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-9
 * Time: 下午1:16
 */
session_start();
require("../../include/Alex.php");
if(!isset($_SESSION["user_name"])){
    toWrongPage(18);
}
$mysession=new mySession($_SESSION["user_name"]);
if($mysession->user_ID!="1"){
    toSignOutPage(2);
}
$cookie_name2=strval(substr(sha1("mengting"),0,12));
$cookie_name="A".$cookie_name2;
if(isset($_COOKIE[$cookie_name])){
    echo $_COOKIE[$cookie_name];
    $arr=unserialize($_COOKIE[$cookie_name]);
    echo "<br/>".$arr[0]."<br/>".$arr[1]."<br/>".$arr[2];
}
?>
<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <title>alex_main_page</title>
    <script src="../../include/jquery-1.11.1.min.js"></script>
</head>
<body>
<input type="button" value="注销" id="btn_sign_out">
<input type="button" value="论坛" id="btn_to_forum">
</body>
<script>
    $("#btn_sign_out").click(function(){window.location.href="../../page_redirect/sign_out.php"});
    $("#btn_to_forum").click(function(){window.location.href="../../forums/sub_forum_1/"})
</script>
</html>