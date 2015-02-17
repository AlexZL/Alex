<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/13
 * Time: 9:18
 */
session_start();
require("../../include/Alex.php");
if(isset($_GET["page_num"])){
    $page_num=$_GET["page_num"];
}else{
    $page_num=1;
}
$mysql_forum_read=new mysqli("localhost","forum_reader","forumread","forums");
$mysql_forum_read_select=$mysql_forum_read->query("select max(`forum_index`) as `num` from tb_forum_main_1");
$obj=$mysql_forum_read_select->fetch_object();
$page_count=ceil($obj->num/25);
$page_start_num=($page_num-1)*25;
$mysql_forum_read_select->close();
?>
<!DOCTYPE html>
    <html>
<head lang="en">
    <title>Sub_forum_1</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo $server_ip_addr; ?>Alex/forums/include/forum_main.css">
    <script src="../../include/jquery-1.11.1.min.js"></script>
    <script src="../include/forum_main.js"></script>
</head>

<body>
<div id="background">
    <div id="title"></div>
    <div id="navigator"></div>
    <div id="container">
        <div id="announcement_div" class="forum_div">
            <div class="line"><div id='announcement_btn' class="btn_1">隐藏公告栏</div></div>
                <div id="announcement_bright" class="bright">
                    <?php
                    $mysql_forum_read_select=$mysql_forum_read->query("select `forum_index`,`forum_title`,`forum_creator`,`forum_create_date` from tb_forum_main_1 where `forum_type`regexp '^1$' ");
                    $result_num=$mysql_forum_read_select->num_rows;
                    for($i=0;$i!=$result_num;$i++){
                        while($result_obj=$mysql_forum_read_select->fetch_object()){
                            echo "<div class=\"item\">";
                            echo "<div class=\"icon\">公告</div>";
                            echo "<div class=\"title\">".$result_obj->forum_title."</div>";
                            echo "<div class=\"creator\">".$result_obj->forum_creator."</div>";
                            echo "<div class=\"replier\"></div>";
                            echo "<div class=\"date\">".substr($result_obj->forum_create_date,0,10)."</div>";
                            echo "<div class=\"reply_time\"></div>";
                            echo "<div class='clear'></div></div>";
                        }
                    }
                    $mysql_forum_read_select->close();
                    ?>
                </div>
        </div>
        <div id="page_navigator">
            <?php
            page_navigator_display($page_num,$page_count);
            ?>
        </div>
        <div id="nor_divide"></div>
        <div id="nor_div" class="forum_div">
            <div id="nor_bright">
                <?php
//                $mysql_forum_read_select=$mysql_forum_read->query("select max(`forum_index`) as `num` from tb_forum_main_1");
//                $obj=$mysql_forum_read_select->fetch_object();
//                $page_count=ceil($obj->num/25);
//                $page_start_num=($page_count-1)*25;
//                $mysql_forum_read_select->close();
                $mysql_forum_read_select=$mysql_forum_read->query("select `forum_page_location`,`forum_index`,`forum_title`,`forum_creator`,`forum_create_date`,`forum_reply_num`,`forum_last_replier`,`forum_last_reply_time` from tb_forum_main_1 where `forum_type` IN (2,4) ORDER BY field(`forum_type`,2,4) , `forum_last_reply_time` DESC limit $page_start_num,25");
                $result_num=$mysql_forum_read_select->num_rows;
                for($i=0;$i!=$result_num;$i++){
                    while($result_obj=$mysql_forum_read_select->fetch_object()){
                        echo "<div class=\"item\">";
                        echo "<div class=\"icon\">".$result_obj->forum_reply_num."</div>";
                        echo "<div class=\"title\"><a href=\"".$result_obj->forum_page_location."\">".$result_obj->forum_title."</a></div>";
                        echo "<div class=\"creator\">".$result_obj->forum_creator."</div>";
                        echo "<div class=\"replier\">".$result_obj->forum_last_replier."</div>";
                        echo "<div class=\"date\">".substr($result_obj->forum_create_date,0,10)."</div>";
                        echo "<div class=\"reply_time\">".substr($result_obj->forum_last_reply_time,0,10)."</div>";
                        echo "<div class='clear'></div></div>";
                    }
                }
                $mysql_forum_read_select->close();
                ?>
            </div>
        </div>
    </div>
    <div id="foot_back">
        <div id="foot_1">             <!--底部提示页-->
            <form action="../forum_search.php" method="post">
            <input type="text" id="input_forum_title_search" name="search_txt">
            <input type="hidden" name="sub_forum_index" value="1">
            <input type="submit" id="btn_forum_title_search" value="搜贴">
            <input type="button" id="btn_forum_create" value="快速发帖">
            <input type="button" id="btn_foot_hidden" value="隐藏">
            </form>
        </div>
        <div id="foot_2">         <!--快速发帖页-->
            <form action="../forum_create_page.php" method="post">
                <div id="foot_2_title_line">
                    <label for="forum_title_input">标题</label>
                    <input id="forum_title_input" name="forum_title" type="text">
                    <label for="forum_label_input">标签</label>
                    <select id="forum_label_input" name="forum_label">
                        <option value="" selected></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div id="foot_2_content_line">
                    <label for="forum_content_input">帖子正文</label>
                    <textarea id="forum_content_input" name="forum_content"></textarea>
                </div>
                <div id="foot_2_button_line">
                    <input id="forum_submit_btn" type="submit" value="提交">
                    <input id="forum_abandon_btn" type="button" value="放弃编辑">
                    <input id="foot_2_hidden" type="button" value="隐藏">
                    <input type="hidden" name="forum_index" value="1">
                </div>
            </form>
        </div>
        <div id="foot_3"></div>       <!--底部隐藏页显示按钮-->
        <div id="foot_4"></div>       <!--底部登录页-->
    </div>
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


    $("#announcement_btn").click(function(){displayAnnouncement()});
    $("#top_btn").click(function(){displayTop()});
    $("#btn_foot_hidden").click(function(){footBack()});
    $("#foot_3").click(function(){footCome()});
    function displayAnnouncement(){
        if($("#announcement_bright").css("display")=="none"){
            $("#announcement_bright").css("display","block");
            $("#announcement_btn").html("隐藏公告栏");
        }else{
            $("#announcement_bright").css("display","none");
            $("#announcement_btn").html("显示公告栏");
        }
    }
    function displayTop(){
        if($("#top_bright").css("display")=="none"){
            $("#top_bright").css("display","block");
            $("#top_btn").html("隐藏置顶栏");
        }else{
            $("#top_bright").css("display","none");
            $("#top_btn").html("显示置顶栏");
        }
    }
</script>
    </html>