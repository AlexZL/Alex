<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/18
 * Time: 10:05
 */
header("Content-type: text/xml");
$sub_forum_index=$_GET["sub_forum_index"];
$blog_index=$_GET["blog_index"];
$floor_index=$_GET["floor_index"];
if(isset($_GET["reply_page_num"])){
    $page_num=$_GET["reply_page_num"];
}else{
    $page_num=1;
}
$reply_table_name="tb_forum_reply_".$sub_forum_index."_".$blog_index;

$reply_sql=new mysqli("localhost","forum_reader","forumread","forums");
$reply_sql_result=$reply_sql->query("select max(`index`) as num from $reply_table_name");
$obj=$reply_sql_result->fetch_object();
$num=$obj->num;
$page_count=ceil($num/10);
$reply_sql_result->close();
$page_start_num=($page_num-1)*10;
$regexp1="^".$floor_index."\$";
$reply_sql_result=$reply_sql->query("select * from $reply_table_name WHERE `reply_to_floor` =$floor_index ORDER BY `reply_time` DESC limit $page_start_num,10");
echo "<ajax>";
$i=1;
while($obj=$reply_sql_result->fetch_object()){
    echo "<reply
        reply_index=\"".$i."\"
        replier=\"".$obj->replier."\"
        replier_ID=\"".$obj->replier_ID."\"
        replied=\"".$obj->reply_to_who."\"
        replied_ID=\"".$obj->reply_to_who_ID."\"
        reply_content=\"".$obj->reply_content."\"
        reply_time=\"".$obj->reply_time."\"></reply>";
    if($i==10){
        $i=1;
    }else{
        $i++
;    }
}
echo "</ajax>";
$reply_sql_result->close();
$reply_sql->close();