<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/13
 * Time: 9:18
 */
$search_value=addslashes($_POST["search_txt"]);
$mysql_forum_read=new mysqli("localhost","forum_reader","forumread","forums");
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title>帖子搜索</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="http://localhost/Alex/include/forum_main.css">
    <script src="../include/jquery-1.11.1.min.js"></script>
    <script src="include/forum_main.js"></script>
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
                $mysql_forum_read_select=$mysql_forum_read->query("select `forum_index`,`forum_title`,`forum_creator`,`forum_create_date` from tb_forum_main_1 where `forum_type`=1 ");
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
        <div id="top_div" class="forum_div">
            <div class="line"><div id='top_btn' class="btn_1">隐藏置顶栏</div></div>
            <div id="top_bright">
                <?php
                $mysql_forum_read_select=$mysql_forum_read->query("select `forum_index`,`forum_title`,`forum_creator`,`forum_create_date`,`forum_last_replier`,`forum_last_reply_time` from tb_forum_main_1 where `forum_type`=2 ");
                $result_num=$mysql_forum_read_select->num_rows;
                for($i=0;$i!=$result_num;$i++){
                    while($result_obj=$mysql_forum_read_select->fetch_object()){
                        echo "<div class=\"item\">";
                        echo "<div class=\"icon\">置顶</div>";
                        echo "<div class=\"title\">".$result_obj->forum_title."</div>";
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
        <div id="nor_divide"></div>
        <div id="nor_div" class="forum_div">
            <div id="nor_bright">
                <?php
                $mysql_forum_read_select=$mysql_forum_read->query("select `forum_index`,`forum_title`,`forum_creator`,`forum_create_date`,`forum_reply_num`,`forum_last_replier`,`forum_last_reply_time` from tb_forum_main_1 where `forum_type`=4 and `forum_title` regexp '$search_value'");
                $result_num=$mysql_forum_read_select->num_rows;
                for($i=0;$i!=$result_num;$i++){
                    while($result_obj=$mysql_forum_read_select->fetch_object()){
                        echo "<div class=\"item\">";
                        echo "<div class=\"icon\">".$result_obj->forum_reply_num."</div>";
                        echo "<div class=\"title\">".$result_obj->forum_title."</div>";
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
        <div id="foot_1">
            <input type="button" id="btn_forum_title_search" value="返回论坛">
            <input type="button" id="btn_forum_create" value="快速发帖">
            <input type="button" id="btn_foot_hidden" value="隐藏">
        </div>
        <div id="foot_2"></div>
        <div id="foot_3"></div>
    </div>
</div>
</body>
<script>
    $("#announcement_btn").click(function(){displayAnnouncement()});
    $("#top_btn").click(function(){displayTop()});
    $("#foot_2").click(function(){footMoveToHidden()});
    $("#btn_forum_create").click(function(){footMoveToShow()});
    $("#btn_foot_hidden").click(function(){footBack()});
    $("#foot_3").click(function(){footCome()});
    $("#btn_forum_title_search").click(function(){history.go(-1)});
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