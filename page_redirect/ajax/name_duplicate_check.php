<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-5
 * Time: 下午3:55
 */
header("Content-Type:text/xml;charset=utf-8");
$name=trim(addslashes($_GET["name"]));
$mysql=mysqli_connect("localhost","alex","z198569l","my_page");
$result=mysqli_query($mysql,"select count(*) from tb_user_login_info where `user_account`='".$name."' limit 1");
$row=mysqli_fetch_row($result);
if($row[0]>0){
    echo "1";
    $result->close();
    $mysql->close();
    exit;
}
echo "0";
$result->close();
$mysql->close();
?>