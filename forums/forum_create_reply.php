<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/18
 * Time: 18:15
 */
session_start();
require("../include/Alex.php");
if(!isset($_SESSION["user_name"])){
    toWrongPage(18);
}
$arr=explode("_",$_POST["reply_to_index"]);
$sub_forum_index=$arr[0];
$blog_index=$arr[1];
$reply_to_floor=$arr[2];
$page_num=$arr[3];
$replier=$_POST["replier"];
$replier_ID=$_POST["replier_ID"];
$content=$_POST["reply_input_content"];
if(isset($_POST["replied"])){
    $replied=$_POST["replied"];
}
if(isset($_POST["replied_ID"])){
    $replied_ID=$_POST["replied_ID"];
}
$date=date("Y-m-d H:i:s");
$reply_tb="tb_forum_reply_".$sub_forum_index."_".$blog_index;
$reply_sql=new mysqli("localhost","forum_reader","forumread","forums");
$reply_sql->query("insert into $reply_tb
                  (`reply_to_floor`,`reply_content`,`replier`,`replier_ID`,`reply_to_who`,`reply_to_who_ID`,`reply_time`)
                  VALUES
                  ('$reply_to_floor','$content','$replier','$replier_ID','$replied','$replied_ID','$date')
                  ")or die(mysqli_error($reply_sql));
$reply_sql->close();
header("location:".$server_ip_addr."Alex/forums/sub_forum_".$sub_forum_index."/forum_blog_".$blog_index.".php?page_num=".$page_num);