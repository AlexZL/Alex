<?php
$mysql=new mysqli("localhost","alex","z198569l","my_page");
$index=1013;
$password="Z123456";
$result=$mysql->query("select `register_time` from tb_user_login_info WHERE `user_ID`='$index'");
$obj=$result->fetch_object();
$date=$obj->register_time;
$mysql_password=sha1($password.$date);
$mysql->query("update tb_user_login_info set `user_password`='$mysql_password' where `user_ID`='$index'");
$mysql->close();

?>
