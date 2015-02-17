<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-7
 * Time: 下午10:04
 */
$key=$_GET["key"];
$tkey=trim($key);
if(strlen(trim($key))!=20){
    echo "0";
    exit;
}
if(strlen(trim($key))==20){
    if(!preg_match("/^[a-fA-F0-9]{20}$/",trim($key))){
        echo "0";
        exit;
    }
    if(preg_match("/^[a-fA-F0-9]{20}$/",trim($key))){
        $mysql=mysqli_connect("localhost","alex","z198569l","my_page");
        $result=mysqli_query($mysql,"select count(*) from tb_user_login_info WHERE `key_summary`='".$tkey."' AND `user_account`='' limit 1");
        $row=mysqli_fetch_row($result);
        $count=$row[0];
        $result1=mysqli_query($mysql,"select count(*) from tb_user_login_info WHERE `key_summary`='".$tkey."' limit 1");
        $row1=mysqli_fetch_row($result1);
        $count1=$row1[0];
        if($count>0){
            echo "1";
        }else{
            if($count1>0){
                echo "2";
            }else{
                echo "0";
            }
        }
        $result->close();
        $result1->close();
        $mysql->close();
    }
}