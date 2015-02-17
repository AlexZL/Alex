<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-5
 * Time: 下午3:55
 */
$check=trim(addslashes($_POST["user_email"]));
$output=array();
$mysql=mysqli_connect("localhost","alex","z198569l","my_page");
$result=mysqli_query($mysql,"select count(*) from tb_user_login_info where `user_email`='".$check."' limit 1");
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