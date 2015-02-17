<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/16
 * Time: 16:18
 */
session_start();
require("../include/Alex.php");
if(!isset($_SESSION["user_name"])){
    toWrongPage(18);
}
$str=$_POST["forum_index"];
$arr=explode("_",$str);
$sub_forum_index=$arr[0];
$blog_index=$arr[1];
$page_num=$arr[2];
$content=htmlspecialchars(addslashes($_POST["forum_content"]));

if(empty($content)){
    header("location:".$server_ip_addr."Alex/login/warning_info.php?location=http://localhost/Alex/forums/sub_forum_".$sub_forum_index."/forum_blog_".$blog_index.".php?page_num=".$page_num."&warning_message=\"回复内容不能为空。\"");
    exit;
}
$mysession=new mySession($_SESSION["user_name"]);

$session_UID=$mysession->user_ID;                                           //用户ID
$name=$mysession->name;                                             //用户昵称
$account=$mysession->account;                                       //用户帐号
$priority=$mysession->priority;                                     //优先级
$date=date("Y-m-d H:i:s");
$tb_main="tb_forum_main_".$sub_forum_index;
$tb_blog="tb_forum_blog_".$sub_forum_index."_".$blog_index;
$mysql=new mysqli("localhost","forum_reader","forumread","forums");
$mysql->query("insert into $tb_blog
              (`content`,`creator`,`creator_ID`,`create_time`)
              VALUES
              ('$content','$name','$session_UID','$date')")or die(mysqli_error($mysql));
$mysql->query("update $tb_main set `forum_reply_num`=(`forum_reply_num`+1),`forum_last_replier`='$name',`forum_last_reply_time`='$date' where `forum_index`=$blog_index")or die(mysqli_error($mysql));
$result=$mysql->query("select max(`floor`) as `num` from $tb_blog");
$obj=$result->fetch_object();
$floor=($obj->num%20==0?20:$obj->num%20);
$page_count=ceil(($obj->num)/20);
$result->close();
$mysql->close();
$user_sql=new mysqli("localhost","alex","z198569l","my_page");
$user_sql->query("update tb_user_login_info set `reply_blog_nums`=(`reply_blog_nums`+1) WHERE `user_ID`=$session_UID");
$user_sql->close();
header("location:".$server_ip_addr."Alex/forums/sub_forum_".$sub_forum_index."/forum_blog_".$blog_index.".php?page_num=".$page_count."#floor_".$floor);