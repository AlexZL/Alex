<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/13
 * Time: 9:59
 */
$check=trim(addslashes($_POST["user_qq"]));
$output=array();
$mysql=mysqli_connect("localhost","alex","z198569l","my_page");
$result=mysqli_query($mysql,"select count(*) from tb_user_login_info where `user_qq`='".$check."' limit 1");
$row=mysqli_fetch_row($result);
if($row[0]>0){
    $output["call_back"]=1;
}else{
    $output["call_back"]=0;
}
echo json_encode($output);
$result->close();
$mysql->close();
?>