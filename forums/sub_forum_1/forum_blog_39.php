<?php
session_start();
require("../include/blog.php");
if(isset($_SESSION['user_name'])){
    $my_session=new mySession($_SESSION['user_name']);
    $session_name=$my_session->name;
    $session_ID=$my_session->user_ID;
}

$sub_forum_index=1;
$blog_index=39;
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
<?php if(!isset($_SESSION["user_name"])){?>
    <div id="login_page_back">
        <div id="login_page">
            <form action="../../page_redirect/login_check.php?code=2_<?php echo $sub_forum_index."_".$blog_index ;?>">
                <div id="login_account">
                    <label id="login_account_label">用户名</label>
                    <input id="login_account_input" type="text" name="login_user_name">
                </div>
                <div id="login_password">
                    <label id="login_password_label">密码</label>
                    <input id="login_password_input" type="password" name="login_user_password">
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<div id="head"></div>
<div id="navigator"></div>
<div id="container">

    <div id="blog_location">
        <a href="<?php echo $server_ip_addr."Alex/forums/"; ?>" ><div id="main_forum">论坛首页</div></a>
        <div class="forum_navigator_division"></div>
        <a href="<?php echo $server_ip_addr."Alex/forums/sub_forum_".$sub_forum_index."/"; ?>" ><div id="sub_forum_name">Sub_forum_1</div></a>
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
    $blog_start_num=($page_num-1)*20;
    $result_blog=$mysql->query("select `floor`,`creator_ID`,`content`,`creator`,`create_time` from $tb_blog ORDER BY `floor` limit $blog_start_num,20");
    while($obj_blog=$result_blog->fetch_object()){
        $floor = $obj_blog->floor;
        $UID = $obj_blog->creator_ID;
        $content = stripslashes($obj_blog->content);
        $creator = $obj_blog->creator;
        $create_time = $obj_blog->create_time;
        $result_user = $user_sql->query("select `user_name`,`forum_privilege`,`forum_level`,`blog_nums` from tb_user_login_info WHERE `user_ID`=$UID");
        $obj_user = $result_user->fetch_object();
        ?>
        <div class="content_line">
            <div class="bloger_back">
                <div class="bloger"><?php echo $obj_user->user_name; ?></div>
                <div class="bloger_pic"></div>
                <div class="UID"><?php echo $UID; ?></div>
                <?php if ($UID == $creator_ID) {
                    echo "<div class=\"blog_owner\">楼主</div>";
                }?>
                <div class="bloger_level"><?php echo $obj_user->forum_level; ?></div>
                <div class="bloger_forum_num"><?php echo $obj_user->blog_nums; ?></div>
            </div>
            <div class="floor_num_show_line">
                <div id="floor_<?php echo $floor; ?>" class="floor_num_show"><?php echo $floor; ?></div>
            </div>
            <div class="content_back">
                <div class="content"><?php echo $content; ?></div>
                <div class="create_time"><?php echo $create_time; ?></div>
            </div>
            <div class="reply_btn_background">
                <div class="reply_btn"></div>
                <div id="reply_btn_<?php echo $floor ?>">收起回复</div>
            </div>
            <div id="my_reply_<?php echo $floor ?>" class="my_reply">
                <?php if(isset($_SESSION["user_name"])){?>
                    <div class="my_reply_btn_line">
                        <input id="my_reply_btn_<?php echo $floor ?>" type="button" value="小纸条" onclick="myReply(<?php echo $floor ?>)">
                        <input id="my_reply_btn_hide_<?php echo $floor ?>" type="button" value="收起" onclick="myReplyHide(<?php echo $floor ?>)" style="display: none">
                    </div>
                <?php }else{?>
                    <div class="my_reply_btn_line">
                        <input id="my_reply_btn_<?php echo $floor ?>" type="button" value="登录发送小纸条" onclick="showLoginPage()">
                        <!--                    <input id="my_reply_btn_hide_--><?php //echo $floor ?><!--" type="button" value="收起" onclick="myReplyHide(--><?php //echo $floor ?>//)" style="display: none">
                    </div>
                <?php } ?>

                <div id="my_reply_content_<?php echo $floor ?>" class="my_reply_content" style="display: none">

                    <form action="../forum_create_reply.php" method="post">
                        <input name="reply_to_index" type="hidden" value="<?php echo $sub_forum_index."_".$blog_index."_".$floor."_".$page_num; ?>">
                        <input name="replier" type="hidden" value="<?php echo $session_name; ?>">
                        <input name="replier_ID" type="hidden" value="<?php echo $session_ID; ?>">
                        <input id="my_reply_input_content_<?php echo $floor; ?>" class="reply_input_content" type="text" name="reply_input_content">
                        <input type="submit" value="回复">
                    </form>
                </div>
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
                    if($g%10==0){
                        $rep_page_num=10;
                    }else{
                        $rep_page_num=$g%10;
                    }
                }
                $rep = 1;
                if (!isset($_SESSION["user_name"])) {
                    while ($rep <= $rep_page_num) {
                        ?>
                        <div id="reply_<?php echo $floor . "_" . $rep; ?>">
                            <div id="replier_<?php echo $floor . "_" . $rep; ?>"></div>
                            <div id="replied_<?php echo $floor. "_" . $rep; ?>"></div>
                            <div id="reply_content_<?php echo $floor . "_" . $rep; ?>"></div>
                            <div id="reply_time_<?php echo $floor . "_" . $rep; ?>"></div>
                        </div>
                        <?php    $rep++;
                    }
                } else {
                    while ($rep <= $rep_page_num) {
                        ?>
                        <div id="reply_<?php echo $floor . "_" . $rep; ?>">
                            <label for="reply_input_content_<?php echo $floor . "_" . $rep; ?>" id="replier_<?php echo $floor . "_" . $rep; ?>" onclick="replierMethod(<?php echo $floor . "," . $rep; ?>)"></label>
                            <div id="replier_ID_<?php echo $floor . "_" . $rep; ?>"></div>
                            <label for="reply_input_content_<?php echo $floor . "_" . $rep; ?>" id="replied_<?php echo $floor . "_" . $rep; ?>" onclick="repliedMethod(<?php echo $floor . "," . $rep; ?>)"></label>
                            <div id="replied_ID_<?php echo $floor . "_" . $rep; ?>"></div>
                            <div id="reply_content_<?php echo $floor . "_" . $rep; ?>"></div>
                            <div id="reply_time_<?php echo $floor . "_" . $rep; ?>"></div>
                            <div id="reply_input_back_<?php echo $floor . "_" . $rep; ?>" style="display: none">
                                <form action="../forum_create_reply.php" method="post">
                                    <input name="reply_to_index" type="hidden" value="<?php echo $sub_forum_index."_".$blog_index."_".$floor."_".$page_num; ?>">
                                    <input name="replier" type="hidden" value="<?php echo $session_name; ?>">
                                    <input name="replier_ID" type="hidden" value="<?php echo $session_ID; ?>">
                                    <input id="reply_input_replied_<?php echo $floor . "_" . $rep; ?>" name="replied" type="hidden">
                                    <input id="reply_input_replied_ID_<?php echo $floor . "_" . $rep; ?>" name="replied_ID" type="hidden">
                                    <div id="reply_input_note_<?php echo $floor . "_" . $rep; ?>" class="reply_input_note"></div>
                                    <input id="reply_input_content_<?php echo $floor . "_" . $rep; ?>" class="reply_input_content" type="text" name="reply_input_content">
                                    <input type="submit" value="回复">
                                </form>
                            </div>
                        </div>
                        <?php    $rep++;
                    }
                }?>
                <div id="reply_navigator_<?php echo $floor ?>" class="reply_navigator">
                    <?php makeReplyDiv($floor,$rep_page_count) ?>
                </div>
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
    $("#btn_forum_create").click(function(){showLoginPage()});

    <?php
    }
    ?>

    $("#btn_foot_hidden").click(function(){footBack()});
    $("#foot_3").click(function(){footCome()});
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
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
        }
        if(rep_page_count==2||rep_page_count==3||rep_page_count==4||rep_page_count==5){
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
            $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_show");
        }
        if(rep_page_count>5){
            if(rep_page_num==rep_page_count){
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_show");
            }
            if(rep_page_num==(rep_page_count-1)){
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_show");
            }
            if(rep_page_num==(rep_page_count-2)){
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_show");
            }
            if(rep_page_num==1){
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_3").attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_show");
            }
            if(rep_page_num==2){
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_3").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_4").attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_show");
            }
            if(rep_page_num==3){
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_4").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_5").attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_show");
            }else{
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).attr("class","reply_navigator_this");
                $("#reply_navigator_"+floor_index+"_"+rep_page_num).siblings().attr("class","reply_navigator_hide");
                $("#reply_navigator_"+floor_index+"_1").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_2").attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+rep_page_count).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_count-1)).attr("class","reply_navigator_show");
                $(".reply_navigator_blank").css("display","block");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-1)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num-2)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num+2)).attr("class","reply_navigator_show");
                $("#reply_navigator_"+floor_index+"_"+(rep_page_num+1)).attr("class","reply_navigator_show");

            }
        }
        var page=server_ip_addr+"Alex/forums/reply_ajax.php?";
        var rand=parseInt(Math.random()*999999);
        var sub_forum_index_j=<?php echo $sub_forum_index;?>;
        var blog_index_j=<?php echo $blog_index; ?>;
        var url=page+"rand="+rand+"&reply_page_num="+rep_page_num+"&sub_forum_index="+sub_forum_index_j+"&blog_index="+blog_index_j+"&floor_index="+floor_index;
        console.log(url);
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
        console.log(url);
        myRequest.open("GET",url,true);
        myRequest.onreadystatechange=function(){theHttpResponseXML(myRequest,floor_index)};
        myRequest.send(null);
    }
    function theHttpResponseXML(myRequest,floor_index){
        if(myRequest.readyState==4){
            if(myRequest.status==200){
                var xml=myRequest.responseXML;
                for(var l=1;l!=(xml.getElementsByTagName("reply").length+1);l++) {
                    console.log(xml.getElementsByTagName("reply").length);
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
        <?php
        $i=20*($page_num-1)+1;
        $ii=$blog_count;
        while($i!=$ii+1){
                $rep_count="floor_rep_".strval($i);
                echo "getXML(myreq".$i.",".$i.",1,".$$rep_count.");";
                $i++;
            }
            ?>
    })
</script>
</html>