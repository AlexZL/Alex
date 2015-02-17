<?php
session_start();
require("../../include/blog.php");
$my_session=new mySession($_SESSION['user_name']);
$session_name=$my_session->name;
$session_ID=$my_session->user_ID;
$sub_forum_index=1;
$blog_index=36;
if(isset($_GET["page_num"])){
    $page_num=$_GET["page_num"];
}else{
    $page_num=1;
}

$tb_main="tb_forum_main_".$sub_forum_index;
$tb_blog="tb_forum_blog_".$sub_forum_index."_".$blog_index;
$tb_reply="tb_forum_reply_".$sub_forum_index."_".$blog_index;
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
$blog_count=$obj->blog_count;
$page_count=ceil($blog_count/20);
$result->close();
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <script src="../include/jquery-1.11.1.min.js"></script> <!--警告，页面完成后更换地址-->
    <script src="../include/forum_main.js"></script>        <!--警告，页面完成后更换地址-->
    <link rel="stylesheet" type="text/css" href="../include/forum_blog.css"><!--警告，页面完成后更换地址-->
</head>
<body>
<div id="head"></div>
<div id="navigator"></div>
<div id="container">

    <div id="blog_location">
        <a href="<?php echo $server_ip_addr."Alex/forums/"; ?>" ><div id="main_forum">论坛首页</div></a>
        <div class="forum_navigator_division"></div>
        <a href="<?php echo $server_ip_addr."Alex/forums/sub_forum_".$sub_forum_index."_main.php"; ?>" ><div id="sub_forum_name">Sub_forum_1</div></a>
        <div class="forum_navigator_division"></div>
        <div id="blog_name"><?php echo $title;?></div>
    </div>
    <div id="page_navigator">
        <?php
        page_navigator_display($page_num,$page_count);
        ?>
    </div>
    <div id="line_forum_title">
        <div id="forum_title"><?php echo $title;?></div>
    </div>
<?php
$i=1;
$blog_start_num=($page_num-1)*20;
    $result_blog=$mysql->query("select `floor`,`creator_ID`,`content`,`creator`,`create_time` from $tb_blog ORDER BY `floor` limit $blog_start_num,20");
    while($obj_blog=$result_blog->fetch_object()){
    $floor=$obj_blog->floor;
    $UID=$obj_blog->creator_ID;
    $content=stripslashes($obj_blog->content);
    $creator=$obj_blog->creator;
    $create_time=$obj_blog->create_time;
    $result_user=$user_sql->query("select `user_name`,`forum_privilege`,`forum_level`,`blog_nums` from tb_user_login_info WHERE `user_ID`=$UID");
    $obj_user=$result_user->fetch_object();
?>
    <div class="content_line">
        <div class="bloger_back">
            <div class="bloger"><?php echo $obj_user->user_name;?></div>
            <div class="bloger_pic"></div>
            <div class="UID"><?php echo $UID;?></div>
            <?php if($UID==$creator_ID){
                echo "<div class=\"blog_owner\">楼主</div>";
            }?>
            <div class="bloger_level"><?php echo $obj_user->forum_level; ?></div>
            <div class="bloger_forum_num"><?php echo $obj_user->blog_nums; ?></div>
        </div>
        <div class="floor_num_show_line">
            <div id="floor_<?php echo $i; ?>" class="floor_num_show"><?php echo $floor; ?></div>
        </div>
        <div class="content_back">
            <div class="content"><?php echo $content;?></div>
            <div class="create_time"><?php echo $create_time;?></div>
        </div>
        <div class="reply_btn_background">
            <div class="reply_btn"></div>
            <div class="reply_btn_<?php echo $i ?>">收起回复</div>
        </div>

        <div class="replies_back_<?php echo $i;
        if($i==20){
            $i=0;
        }else{
            $i++;
        } ?>">
    <?php
    $result_user->close();
    $result_reply=$mysql->query("select `replier`,`replier_ID`,`reply_to_who`,`reply_to_who_ID`,`reply_content`,`reply_time` from $tb_reply where `reply_to_floor`=($i+1)");
    $reply_num=$result_reply->num_rows;
    $j=0;
    while($obj_reply=$result_reply->fetch_object()){?>
        <div class="one_reply_back">
            <div class="replier"><?php echo $obj_reply->replier; ?></div>
            <input type="hidden" name="replier_ID" value="<?php echo $obj_reply->replier_ID; ?>">
            <div class="huifu_str">&nbsp;回复&nbsp;:</div>
            <div class="replied"><?php echo $obj_reply->reply_to_who; ?></div>
            <input type="hidden" name="replied_ID" value="<?php $obj_reply->reply_to_who_ID; ?>">
            <div class="reply"><?php echo $obj_reply->reply_content; ?></div>
            <div class="reply_time"><?php echo $obj_reply->reply_time; ?></div>

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
<div id="foot_back">
    <div id="foot_1">             <!--底部提示页-->
            <input type="button" id="btn_forum_create" value="快速发帖">
            <input type="button" id="btn_foot_hidden" value="隐藏">
    </div>
    <div id="foot_2">         <!--快速发帖页-->
        <form action="../forum_create_blog.php" method="post">
            <div id="foot_2_content_line">
                <label for="forum_content_input">回复本帖</label>
                <textarea id="forum_content_input" name="forum_content"></textarea>
            </div>
            <div id="foot_2_button_line">
                <input id="forum_submit_btn" type="submit" value="提交">
                <input id="forum_abandon_btn" type="button" value="放弃编辑">
                <input id="foot_2_hidden" type="button" value="隐藏">
                <input type="hidden" name="forum_index" value="<?php echo $sub_forum_index."_".$blog_index."_".$page_num."_".$page_count;?>">
            </div>
        </form>
    </div>
    <div id="foot_3"></div>       <!--底部隐藏页显示按钮-->
    <div id="foot_4"></div>       <!--底部登录页-->
</div>
</body>
<script>
    <?php
    if(isset($_SESSION['user_name'])){
    ?>

    $("#foot_2_hidden").click(function(){foot2MoveToHidden()});
    $("#btn_forum_create").click(function(){foot2MoveToShow()});


    <?php
    }else{
    ?>
    $("#foot_4").click(function(){foot4MoveToHidden();console.log("123")});
    $("#btn_forum_create").click(function(){foot4MoveToShow();console.log("123")});

    <?php
    }
    ?>

    $("#btn_foot_hidden").click(function(){footBack()});
    $("#foot_3").click(function(){footCome()});

</script>
</html>