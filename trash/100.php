<?php
session_start();
require("../include/blog.php");
$my_session=new mySession($_SESSION['user_name']);
$session_name=$my_session->name;
$session_ID=$my_session->user_ID;
$sub_forum_index=2;
$blog_index=10;

$page_num=$_POST["page_num"];

$tb_main="sub_forum_main_".$sub_forum_index;
$tb_blog="tb_forum_blog_".$sub_forum_index."_".$index;
$tb_reply="tb_forum_reply_".$sub_forum_index."_".$index;
$mysql=new mysqli("localhost","forum_reader","forumread","forums");
$result=$mysql->query("select `forum_title`,`creator_ID` from $tb_main WHERE `forum_index`=$blog_index");
$obj=$result->fetch_object();
$title=stripslashes($obj->forum_title);
$creator_ID=$obj->creator_ID;
$result->close();
$mysql->close();
$mysql=new mysqli("localhost","forum_reader","forumread","forums");
$user_sql=new mysqli("localhost","alex","z198569l","my_page");
$result=$mysql->query("select MAX(`floor`) as `blog_count` from $tb_blog");
$obj=$result->fetch_object();
$blog_count=$obj->num;
$page_count=ceil($blog_count/20);
$result->close();
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <script src="../include/jquery-1.11.1.min.js"></script> <!--警告，页面完成后更换地址-->
    <script src="../forums/include/forum_blog.js"></script>        <!--警告，页面完成后更换地址-->
    <link rel="stylesheet" type="text/css" href="../forums/include/forum_blog.css">
</head>
<body>
<div id="head"></div>
<div id="navigator"></div>
<div id="container">



    <div id="page_navigator">
<?php
page_navigator_display($page_num,$page_count);
?>
    </div>
    <div id="line_forum_title">
        <div id="forum_title"><?php echo $title;?></div>
    </div>
<?php

for($i=0;$i!=$blog_count;$i++){
    $result=$mysql->query("select `creator_ID`,`content`,`creator`,`create_time` from $tb_blog WHERE `floor`=$i");
    $obj=$result->fetch_object();
    $UID=$obj->creator_ID;
    $content=stripslashes($obj->content);
    $creator=$obj->creator;
    $create_time=$obj->create_time;
    $result->close();
    $result=$user_sql->query("select `user_name`,`forum_privilege`,`forum_level`,`blog_nums` from tb_user_login_info WHERE `user_ID`=$UID");
    $obj=$result->fetch_object();
?>
    <div class="content_line">
        <div class="bloger_back">
            <div class="bloger"><?php echo $obj->user_name;?></div>
            <div class="bloger_pic"></div>
            <div class="UID"><?php echo $UID;?></div>
            <?php if($UID==$creator_ID){
                echo "<div class=\"blog_owner\">楼主</div>";
            }?>
            <div class="bloger_level"><?php echo $obj->forum_level;?></div>
            <div class="bloger_forum_num"><?php echo $obj->blog_nums;?></div>
        </div>
        <div class="content_back">
            <div class="content"><?php echo $content;?></div>
            <div class="create_time"><?php echo $create_time;?></div>
        </div>
        <div class="reply_btn_<?php echo $i ?>"
        <div class="replies_back">
    <?php
    $result->close();
    $result=$mysql->query("select `replier`,`replier_ID`,`reply_to_who`,`reply_to_who_ID`,`reply_content`,`reply_time` from $tb_reply where `reply_to_floor`=$i");
    $reply_num=$result->num_rows;
    $j=0;
    while($obj=$result->fetch_object()){?>
        <div class="one_reply_back">
            <div class="replier"><?php echo $obj->replier; ?></div>
            <input type="hidden" name="replier_ID" value="<?php echo $obj->replier_ID; ?>">
            <div class="huifu_str">&nbsp;回复&nbsp;:</div>
            <div class="replied"><?php echo $obj->reply_to_who; ?></div>
            <input type="hidden" name="replied_ID" value="<?php $obj->reply_to_who_ID; ?>">
            <div class="reply"><?php echo $obj->reply_content; ?></div>
            <div class="reply_time"><?php echo $obj->reply_time; ?></div>

        </div>
    <?php
    };
    ?>
        </div>
    </div>
<?php
}
?>

</div>
<div id="foot"></div>
</body>
<script>
</script>
</html>