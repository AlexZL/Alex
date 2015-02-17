<?php
session_start();
require("../include/blog.php");
require("../../include/page_maker.php");
if(isset($_SESSION['user_name'])){
    $my_session=new mySession($_SESSION['user_name']);
    $session_name=$my_session->name;
    $session_ID=$my_session->user_ID;
}

$sub_forum_index="yyyxxx";
$blog_index="xxxyyy";
$page_maker=new page_maker(2,$sub_forum_index,$blog_index,2);
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
    <script src="../../include/jquery-1.11.1.min.js"></script> <!--警告，页面完成后更换地址-->
    <script src="../include/forum_main.js"></script>        <!--警告，页面完成后更换地址-->
    <link rel="stylesheet" type="text/css" href="../include/forum_blog.css"><!--警告，页面完成后更换地址-->
</head>
<body>
<?php    $page_maker->makeLoginPage();      ?>
<div id="window">
<div id="ad_page">
    <div id="ad1"></div>
</div>
<div id="main_page">
    <div id="head">
        <?php    $page_maker->makeHeadPage();      ?>
    </div>
    <div id="navigator"></div>
    <div id="container">

        <div id="blog_location">
            <a href="<?php echo $server_ip_addr."Alex/forums/"; ?>" ><div id="main_forum">论坛首页</div></a>
            <div class="forum_navigator_division"></div>
            <a href="<?php echo $server_ip_addr."Alex/forums/sub_forum_".$sub_forum_index."/"; ?>" ><div id="sub_forum_name">Sub_forum_1</div></a>
            <div class="forum_navigator_division"></div>
            <div id="blog_name"><?php echo $title;?></div>
        </div>
        <div class="page_navigator">
            <?php   page_navigator_display($page_num,$page_count);    ?>
        </div>
        <div id="line_forum_title">
            <div id="forum_title"><?php echo $title;?></div>
        </div>
        <?php
        $blog_start_num=($page_num-1)*20;
        $result_blog=$mysql->query("select `floor`,`creator_ID`,`content`,`creator`,`create_time` from $tb_blog ORDER BY `floor` limit $blog_start_num,20");
        while($obj_blog=$result_blog->fetch_object()){
        $floor = $obj_blog->floor;
        $UID = $obj_blog->creator_ID;
        $content = stripslashes($obj_blog->content);
        $content = pictureCodeReplace($content);
        $creator = $obj_blog->creator;
        $create_time = $obj_blog->create_time;
        $result_user = $user_sql->query("select `user_name`,`forum_privilege`,`forum_level`,`blog_nums` from tb_user_login_info WHERE `user_ID`=$UID");
        $obj_user = $result_user->fetch_object();
        ?>
        <div class="content_line">
            <div class="bloger_back">
                <div class="bloger_pic_top_line"></div>
                <div class="bloger_pic">
                    <img src="../../MerryChristmas/media/image/we/2ss.jpg">

                </div>
                <?php if ($UID == $creator_ID) {
                    echo "<div class=\"blog_owner\">楼主</div>";
                }?>
                <div class="bloger"><?php echo $obj_user->user_name; ?></div>
                <div class="order_line">
                    <div id="order_1" class="order"></div>
                    <div id="order_2" class="order"></div>
                    <div id="order_3" class="order"></div>
                    <div id="order_4" class="order"></div>
                    <div id="order_5" class="order"></div>
                </div>
                <div class="bloger_level_line">
                    <div class="bloger_level_label">等级：</div>
                    <div class="bloger_level"><?php echo $obj_user->forum_level; ?></div>
                </div>
                <div class="bloger_forum_num_line">
                    <div class="bloger_forum_num_label">发帖数：</div>
                    <div class="bloger_forum_num"><?php echo $obj_user->blog_nums; ?></div>
                </div>
            </div>
            <div class="floor_num_show_line">
                <div class="floor_num_show_front_blank"></div>
                <div id="floor_<?php echo $floor; ?>" class="floor_num_show"><?php echo $floor; ?>楼</div>
                <div class="create_time"><?php echo $create_time; ?></div>
                <div class="floor_num_show_back_blank"></div>
            </div>
            <div class="content_back">
                <div class="content_top_blank"></div>
                <div class="content"><?php echo $content; ?></div>
            </div>
            <div class="content_to_reply_blank"></div>
            <div class="reply">
                <div class="reply_btn_background">
                    <div class="reply_btn_front_blank"></div>
                    <?php if(isset($_SESSION["user_name"])){?>
                    <div class="my_reply_btn_line">
                        <input id="my_reply_btn_<?php echo $floor ?>" class="reply_btn_j" type="button" value="小纸条" onclick="myReply(<?php echo $floor ?>)">
                        <input id="my_reply_btn_hide_<?php echo $floor ?>" class="reply_btn_j" type="button" value="收起" onclick="myReplyHide(<?php echo $floor ?>)" style="display: none">
                    </div>
                    <input type="button" id="reply_btn_<?php echo $floor ?>" class="reply_btn_k" value="隐藏回复">
                </div>

                <div id="my_reply_content_<?php echo $floor ?>" class="my_reply_content">
                    <form action="../forum_create_reply.php" method="post">
                        <input name="reply_to_index" type="hidden" value="<?php echo $sub_forum_index."_".$blog_index."_".$floor."_".$page_num; ?>">
                        <input name="replier" type="hidden" value="<?php echo $session_name; ?>">
                        <input name="replier_ID" type="hidden" value="<?php echo $session_ID; ?>">
                        <input id="my_reply_input_content_<?php echo $floor; ?>" class="reply_input_content_main" type="text" name="reply_input_content">
                        <input type="submit" value="回复" class="reply_input_content_main_btn">
                    </form>
                </div>
                <?php }else{?>
                <div class="my_reply_btn_line">
                    <input id="my_reply_btn_<?php echo $floor ?>" type="button" value="登录发送小纸条" onclick="showLoginPage()" class="reply_btn_j">
                </div>
                <input type="button" id="reply_btn_<?php echo $floor ?>" class="reply_btn_k" value="隐藏回复" >
            </div>

            <?php } ?>
            <div id="my_reply_<?php echo $floor ?>" class="my_reply">

            </div>
            <div id="replies_back_<?php echo $floor ?>" class="replies_back"><?php
                $reply_sql=new mysqli("localhost","forum_reader","forumread","forums");
                $reply_result=$reply_sql->query("select count(*) as `num` from $tb_reply WHERE `reply_to_floor`=$floor");
                $reply_obj=$reply_result->fetch_object();
                $rep_page_count=ceil(($reply_obj->num)/10);
                $floor_rep="floor_rep_".strval($floor);
                $$floor_rep=$rep_page_count;
                $g=$reply_obj->num;
                if(empty($g)){
                    $rep_page_num=0;
                }else{
                    if($rep_page_count==1){
                        if($g%10==0){
                            $rep_page_num=10;
                        }else{
                            $rep_page_num=$g%10;

                        }
                    }else{
                        $rep_page_num=10;
                    }
                }
                $rep = 1;
                if (!isset($_SESSION["user_name"])) {
                    while ($rep <= $rep_page_num) {
                        ?>
                        <div id="reply_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line">
                            <div class="reply_content_one_line_blank"></div>
                            <div id="replier_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_replier" onclick="showLoginPage()"></div>
                            <div class="reply_content_one_line_middle_blank">回复</div>
                            <div class="reply_content_one_line_blank"></div>
                            <div id="replied_<?php echo $floor. "_" . $rep; ?>" class="reply_content_one_line_replied"  onclick="showLoginPage()"></div>
                            <div id="reply_content_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_content"></div>
                            <div id="reply_time_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_time"></div>
                        </div>
                        <?php    $rep++;
                    }
                } else {
                    while ($rep <= $rep_page_num) {
                        ?>
                        <div id="reply_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line">
                            <label for="reply_input_content_<?php echo $floor . "_" . $rep; ?>" id="replier_<?php echo $floor . "_" . $rep; ?>" onclick="replierMethod(<?php echo $floor . "," . $rep; ?>)" class="reply_content_one_line_replier"></label>
                            <div class="reply_content_one_line_blank"></div>
                            <div id="replier_ID_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_ID"></div>
                            <div class="reply_content_one_line_middle_blank">回复</div>
                            <div class="reply_content_one_line_blank"></div>
                            <label for="reply_input_content_<?php echo $floor . "_" . $rep; ?>" id="replied_<?php echo $floor . "_" . $rep; ?>" onclick="repliedMethod(<?php echo $floor . "," . $rep; ?>)" class="reply_content_one_line_replied"></label>
                            <div id="replied_ID_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_ID"></div>
                            <div id="reply_content_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_content"></div>
                            <div id="reply_time_<?php echo $floor . "_" . $rep; ?>" class="reply_content_one_line_time"></div>
                            <div id="reply_input_back_<?php echo $floor . "_" . $rep; ?>" style="display: none" class="reply_input_back">
                                <form action="../forum_create_reply.php" method="post">
                                    <input name="reply_to_index" type="hidden" value="<?php echo $sub_forum_index."_".$blog_index."_".$floor."_".$page_num; ?>">
                                    <input name="replier" type="hidden" value="<?php echo $session_name; ?>">
                                    <input name="replier_ID" type="hidden" value="<?php echo $session_ID; ?>">
                                    <input id="reply_input_replied_<?php echo $floor . "_" . $rep; ?>" name="replied" type="hidden">
                                    <input id="reply_input_replied_ID_<?php echo $floor . "_" . $rep; ?>" name="replied_ID" type="hidden">
                                    <div id="reply_input_note_<?php echo $floor . "_" . $rep; ?>" class="reply_input_note"></div>
                                    <input id="reply_input_content_<?php echo $floor . "_" . $rep; ?>" class="reply_input_content" type="text" name="reply_input_content">
                                    <input type="submit" value="回复" class="reply_input_btn" onmouseover="replyBtnToClass2(this)" onmouseout="replyBtnToClass1(this)">
                                </form>
                                <input type="button" id="hide_reply_input_content_<?php echo $floor . "_" . $rep; ?>" class="reply_input_btn" value="隐藏" onclick="hideReplyMethod(<?php echo $floor . "," . $rep; ?>)"  onmouseover="replyBtnToClass2(this)" onmouseout="replyBtnToClass1(this)">
                            </div>
                        </div>
                        <?php    $rep++;
                    }
                }?>
                <div id="reply_navigator_<?php echo $floor ?>" class="reply_navigator">
                    <?php makeReplyDiv($floor,$rep_page_count) ?>
                    <div class="reply_navigator_blank_j"></div>
                </div>
                <div class="rep_num_info"><?php echo $reply_obj->num."条回复&nbsp;&nbsp;&nbsp;共".$rep_page_count."页" ?></div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    <?php
    }
    ?>
    <div class="page_navigator">
        <?php
        page_navigator_display($page_num,$page_count);
        ?>
    </div>
</div>
<div id="mood_line_1">
    <div id="mood_line">
        <div id="mood_package">
            <div id="mood_package_tusiji" class="mood_package_name">兔斯基</div>
            <div id="mood_package_Azai" class="mood_package_name">A仔</div>
            <div id="mood_package_ali" class="mood_package_name">阿狸</div>
            <div id="mood_package_gongtingyulu" class="mood_package_name">宫廷语录</div>
        </div>
        <div id="mood_content_window">
            <div id="mood_content"></div>
        </div>
    </div>
</div>
<div id="foot_back">
    <div id="foot_1">            <!--底部提示页-->
        <?php if(isset($_SESSION["user_name"])){?>
            <input type="button" id="btn_forum_create" value="快速发帖">
        <?php }else{ ?>
            <input type="button" id="btn_forum_create" value="登录发帖">
        <?php } ?>
        <input type="button" id="btn_foot_hidden" value="隐藏">
    </div>
    <div id="foot_2">         <!--快速发帖页-->
        <div id="input_tool_line">
            <div id="mood_select" class="input_tool_element">系统表情</div>
        </div>
        <form action="../forum_create_blog.php" method="post">
            <div id="foot_2_content_line">
                <label id="forum_content_input_label" for="forum_content_input">回复本帖</label>
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
</div>
</div>
</div>
</body>
<script>
$("input[type='text']").attr("autocomplete","off");
$(".reply_btn_k").hover(function(){replyBtnToClass2_2(this)},function(){replyBtnToClass2_1(this)})
$(".reply_btn_j").hover(function(){replyBtnToClass3_2(this)},function(){replyBtnToClass3_1(this)})
$(".page_num_input_btn").hover(function(){$(this).attr("class","page_num_input_btn_2")},function(){$(this).attr("class","page_num_input_btn")})
<?php
if(isset($_SESSION['user_name'])){
?>
$("#foot_2_hidden").click(function(){
    foot2MoveToHidden();
    $("#mood_line").css("display","none");
});
$("#btn_forum_create").click(function(){foot2MoveToShow()});
<?php
}else{
?>
$("#btn_forum_create").click(function(){showLoginPage()});
$("#login_page_hide").click(function(){hideLoginPage()});
<?php
}
?>
$("#btn_foot_hidden").click(function(){footBack()});
$("#foot_3").click(function(){footCome()});
var img_count=0;
$("#mood_select").click(function(){
    $("#mood_line").toggle("200");
    <?php
    $img_count=count(scandir("../../media/images/biaoqing/tusiji"))-2;
        ?>
    img_count=<?php echo $img_count;?>;
    $("#mood_content").css("width",60*img_count+"px")
    $("#mood_content").html("");
    for(var i=0;i!=img_count;i++){
        $("#mood_content").append("<img id=\"tusiji_"+i+"_gif\" class=\"mood_img\" src=../../media/images/biaoqing/tusiji/"+i+".gif>")
    }
    $(".mood_img").click(function(){
        appendPicCode(this)
    });
})
$("#mood_package_tusiji").click(function(){
    <?php $img_count=count(scandir("../../media/images/biaoqing/tusiji"))-2; ?>
    img_count=<?php echo $img_count;?>;
    $("#mood_content").css("width",60*img_count+"px")
    $("#mood_content").html("");
    for(var i=0;i!=img_count;i++){
        $("#mood_content").append("<img id=\"tusiji_"+i+"_gif\" class=\"mood_img\" src=../../media/images/biaoqing/tusiji/"+i+".gif>")
    }
    $(".mood_img").click(function(){
        appendPicCode(this)
    });
})
$("#mood_package_Azai").click(function(){
    <?php $img_count=count(scandir("../../media/images/biaoqing/Azai"))-2; ?>
    img_count=<?php echo $img_count;?>;
    $("#mood_content").css("width",60*img_count+"px")
    $("#mood_content").html("");
    for(var i=0;i!=img_count;i++){
        $("#mood_content").append("<img id=\"Azai_"+i+"_gif\" class=\"mood_img\" src=\"../../media/images/biaoqing/Azai/"+i+".gif\">")
    }
    $(".mood_img").click(function(){
        appendPicCode(this)
    });
})
$("#mood_package_ali").click(function(){
    <?php $img_count=count(scandir("../../media/images/biaoqing/ali"))-2; ?>
    img_count=<?php echo $img_count;?>;
    $("#mood_content").css("width",60*img_count+"px")
    $("#mood_content").html("");
    for(var i=0;i!=img_count;i++){
        $("#mood_content").append("<img id=\"ali_"+i+"_gif\" class=\"mood_img\" src=\"../../media/images/biaoqing/ali/"+i+".gif\">")
    }
    $(".mood_img").click(function(){
        appendPicCode(this)
    });
})
$("#mood_package_gongtingyulu").click(function(){
    <?php $img_count=count(scandir("../../media/images/biaoqing/gongtingyulu"))-2; ?>
    img_count=<?php echo $img_count;?>;
    $("#mood_content").css("width",60*img_count+"px")
    $("#mood_content").html("");
    for(var i=0;i!=img_count;i++){
        $("#mood_content").append("<img id=\"gongtingyulu_"+i+"_png\" class=\"mood_img\" src=\"../../media/images/biaoqing/gongtingyulu/"+i+".png\">")
    }
    $(".mood_img").click(function(){
        appendPicCode(this)
    });
})

var myreq1=getXMLHTTPRequest();
var myreq2=getXMLHTTPRequest();
var myreq3=getXMLHTTPRequest();
var myreq4=getXMLHTTPRequest();
var myreq5=getXMLHTTPRequest();
var myreq6=getXMLHTTPRequest();
var myreq7=getXMLHTTPRequest();
var myreq8=getXMLHTTPRequest();
var myreq9=getXMLHTTPRequest();
var myreq10=getXMLHTTPRequest();
var myreq11=getXMLHTTPRequest();
var myreq12=getXMLHTTPRequest();
var myreq13=getXMLHTTPRequest();
var myreq14=getXMLHTTPRequest();
var myreq15=getXMLHTTPRequest();
var myreq16=getXMLHTTPRequest();
var myreq17=getXMLHTTPRequest();
var myreq18=getXMLHTTPRequest();
var myreq19=getXMLHTTPRequest();
var myreq20=getXMLHTTPRequest();
function getXML(myRequest,floor_index,rep_page_num,rep_page_count){
    if(rep_page_count==1){
        $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
    }
    if(rep_page_count==2||rep_page_count==3||rep_page_count==4||rep_page_count==5){
        $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
        $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_div");
        if(rep_page_num==rep_page_count){
        }
    }
    if(rep_page_count>5){
        if(rep_page_num==rep_page_count){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_div_hide");
            $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_div");
        }
        if(rep_page_num==(rep_page_count-1)){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
            $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_div");
        }
        if(rep_page_num==(rep_page_count-2)){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
            $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_div");
        }
        if(rep_page_num==1){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
            $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_3").attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_div");
        }
        if(rep_page_num==2){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
            $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_3").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_4").attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_div");
        }
        if(rep_page_num==3){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
            $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_4").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_5").attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_div");
        }else{
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_div_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
            $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_div");
            $(".reply_navigator_blank").css("display","block");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num+2)).attr("class","reply_navigator_div");
            $("#reply_navigator_"+floor_index+"_"+(rep_page_num+1)).attr("class","reply_navigator_div");
        }
    }
    $("#replies_back_"+floor_index+" [class='reply_content_one_line']").css("display","none");
    var page=server_ip_addr+"Alex/forums/reply_ajax.php?";
    var rand=parseInt(Math.random()*999999);
    var sub_forum_index_j=<?php echo $sub_forum_index;?>;
    var blog_index_j=<?php echo $blog_index; ?>;
    var url=page+"rand="+rand+"&reply_page_num="+rep_page_num+"&sub_forum_index="+sub_forum_index_j+"&blog_index="+blog_index_j+"&floor_index="+floor_index;
    myRequest.open("GET",url,true);
    myRequest.onreadystatechange=function(){theHttpResponseXML(myRequest,floor_index)};
    myRequest.send(null);
}
function getXMLTo(myRequest,floor_index,rep_page_num){
    var page=server_ip_addr+"Alex/forums/reply_ajax.php?";
    var rand=parseInt(Math.random()*999999);
    var sub_forum_index_j=<?php echo $sub_forum_index;?>;
    var blog_index_j=<?php echo $blog_index; ?>;
    var url=page+"rand="+rand+"&reply_page_num="+rep_page_num+"&sub_forum_index="+sub_forum_index_j+"&blog_index="+blog_index_j+"&floor_index="+floor_index;
    myRequest.open("GET",url,true);
    myRequest.onreadystatechange=function(){theHttpResponseXML(myRequest,floor_index)};
    myRequest.send(null);
}
function theHttpResponseXML(myRequest,floor_index){
    if(myRequest.readyState==4){
        if(myRequest.status==200){
            var xml=myRequest.responseXML;
            for(var l=1;l!=(xml.getElementsByTagName("reply").length+1);l++) {
                $("#reply_"+floor_index+"_"+l).css("display","block");
                $("#replier_" + floor_index + "_"+l).html(xml.getElementsByTagName("reply")[(l-1)].getAttribute("replier"));
                $("#replier_ID_" + floor_index + "_"+l).html(xml.getElementsByTagName("reply")[(l-1)].getAttribute("replier_ID"));
                $("#replied_" + floor_index + "_"+l).html(xml.getElementsByTagName("reply")[(l-1)].getAttribute("replied"));
                $("#replied_ID_" + floor_index + "_"+l).html(xml.getElementsByTagName("reply")[(l-1)].getAttribute("replied_ID"));
                $("#reply_content_" + floor_index + "_"+l).html(xml.getElementsByTagName("reply")[(l-1)].getAttribute("reply_content"));
                $("#reply_time_" + floor_index + "_"+l).html(xml.getElementsByTagName("reply")[(l-1)].getAttribute("reply_time"));
            }
        }
    }
}
$(document).ready(function() {
    $(".reply_btn_k").click(function(){
        var floor=$(this).attr("id").substr(-1);
        $("#replies_back_"+floor).toggle(200);
        if($(this).val()=="显示回复"){
            $(this).val("隐藏回复")
        }else{
            $(this).val("显示回复")
        }
    })
    <?php
    if($page_count==1){
    $i=1;$ii=$blog_count;
    }else{
        if($page_num==ceil($blog_count/20)){
            $i=($page_num-1)*20+1;
            $ii=$blog_count;
        }else{
            $i=($page_num-1)*20+1;
            $ii=$page_num*20;
        }
    }
    $x=1;
    while($i!=$ii+1){
        if($x==21){
            $x=1;
        }
            $rep_count="floor_rep_".strval($i);
            echo "getXML(myreq".$x.",".$i.",1,".$$rep_count.");";
            $i++;
            $x++;
        }?>

})
</script>
</html>