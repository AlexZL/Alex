<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/3
 * Time: 15:46
 */
session_start();
require("../include/Alex.php");
require("../include/page_maker.php");
if(!isset($_SESSION["user_name"])){
    toWrongPage(18,"");
    exit;
}

$mysession=new mySession($_SESSION["user_name"]);
$account=$mysession->account;
$name=$mysession->name;
$UID=$mysession->user_ID;
$priority=$mysession->priority;
$mysql=new mysqli("localhost","alex","z198569l","my_page");
$result=$mysql->query("select `user_account`,`user_name`,`user_sex`,`user_email`,`user_qq`,`user_portrait_L` from tb_user_login_info where `user_ID`='$UID'");
$obj=$result->fetch_object();
$user_email=$obj->user_email;
$user_qq=$obj->user_qq;
$user_name=$obj->user_name;
$user_sex=$obj->user_sex;
switch ($user_sex){
    case "F";
        $user_sex_decode="女";
        break;
    case "M";
        $user_sex_decode="男";
        break;
    case "X";
        $user_sex_decode="保密";
    break;
}
$user_account=$obj->user_account;
$user_portrait_L=$obj->user_portrait_L;
if(isset($_POST["original_portrait"])){
    $original_portrait=$_POST["original_portrait"];
}
$page_maker=new page_maker(1,0,0,1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>用户设置</title>
    <script type="text/javascript" src="../include/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../include/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../include/ajaxfileupload.js"></script>
    <link type="text/css" rel="stylesheet" href="user_main.css">
    <link type="text/css" rel="stylesheet" href="../include/jquery-ui.min.css">
</head>
<body>
<div id="window">
    <div id="ad_page">
        <div id="ad1"></div>
    </div>
    <div id="main_page">
            <?php $page_maker->makeHeadPage(); ?>
        <?php $page_maker->makeNavigatorPage(5,1,2,9,9,9) ?>
        <div id="container">
<!--            <div id="sub_navigator">-->
<!--                <div><a href="../forums/index.php">论坛</a></div>-->
<!--            </div>-->
            <div id="select_item">
                <ul>
                    <li id="page_1"><a href="#container_1">基本设置</a></li>
                    <li id="page_2"><a href="#container_2">联系方式</a></li>
                    <li id="page_3"><a href="#container_3">头像签名</a></li>
                </ul>
                <div id="container_1">
                    <div id="user_base_setting_page">
                        <div id="user_account_line">
                            <div id="user_account_label">帐号:</div>
                            <input type="text" id="user_account" disabled="disabled" value="<?php echo $user_account;?>">
                            <div id="user_account_info">无法更改!</div>
                        </div>
                        <form action="../page_redirect/user_info_setting.php" method="post" id="form_basement_info">
                            <div id="input_user_name_line">
                                <?php if(empty($user_name)||empty($name)){ ?>
                                    <label id="input_user_name_label" for="input_user_name">用户名:</label>
                                    <input id="input_user_name" name="user_name" type="text" autocomplete="off" title="长度为4-14个字节，最长7个汉字或14个字母。不要包含特殊字符。">
                                    <label id="input_user_name_note" for="input_user_name">请输入用户名</label>
                                    <div id="input_user_name_info"></div>
                                <?php }else{ ?>
                                    <div id="input_user_name_label">用户名:</div>
                                    <input id="input_user_name" type="text" disabled="disabled" value="<?php echo $name; ?>">
                                    <div id="input_user_name_info">用户名已设置，不能更改</div>
                                <?php } ?>
                                <div style="clear: both"></div>
                            </div>
                            <?php if(empty($user_name)||empty($name)){ ?>
                            <div id="input_user_name_warning">请注意，用户名一旦提交将无法更改！</div>
                            <?php } ?>
                            <div id="input_user_sex_line">
                                <div id="input_user_sex_label">性别:</div>
                                <?php if(empty($user_sex)||$user_sex=="X"){ ?>
                                    <div id="sex_radio">
                                        <label for="input_user_sex_female" id="input_user_sex_female_label">女</label>
                                        <input type="radio" id="input_user_sex_female" name="user_sex" value="女">
                                        <label for="input_user_sex_male" id="input_user_sex_male_label">男</label>
                                        <input type="radio" id="input_user_sex_male" name="user_sex" value="男">
                                        <label for="input_user_sex_secret" id="input_user_sex_secret_label">秘密</label>
                                        <input type="radio" id="input_user_sex_secret" name="user_sex" value="保">
                                    </div>
                                <?php }else{ ?>
                                    <div id="input_user_sex_show"><?php echo $user_sex_decode; ?></div>
                                <?php } ?>
                                <div style="clear: both"></div>
                            </div>
                            <?php if(empty($user_sex)||$user_sex=="保"){ ?>
                            <div id="input_user_sex_warning">请注意，性别一旦选定男女，将无法更改!</div>
                            <?php } ?>

                            <div id="password_change_checkbox_line">
                                <label for="password_change_checkbox" id="password_change_checkbox_label">修改密码</label>
                                <input type="checkbox" id="password_change_checkbox">
                            </div>
                            <div id="user_password_line0">
                                <label for="user_password0" id="user_password_label0">原密码:</label>
                                <input type="password" id="user_password0" name="user_password0">
                            </div>
                            <div id="user_password_line">
                                <label for="user_password" id="user_password_label">输入密码:</label>
                                <input type="password" id="user_password" name="user_password" title="第一个必须为大写字母，密码长度为6-22，可以包含特殊字符.">
                                <div id="user_password_info"></div>
                            </div>
                            <div id="user_password_line2">
                                <label for="user_password2" id="user_password_label2">确认密码:</label>
                                <input type="password" id="user_password2" name="user_password2">
                                <div id="user_password2_info"></div>
                            </div>

                            <div id="submit">
                                <input id="btn_user_info_submit" type="submit" value="提交" >
                            </div>
                        </form>
                    </div>
                </div>
                <div id="container_2">
                    <div id="user_contact_page">
                        <form action="../page_redirect/user_info_setting.php" method="post">
                            <div id="input_user_email_line">
                                <label id="input_user_email_label" for="input_user_email">邮箱：</label>
                                <input id="input_user_email" name="user_email" type="text" autocomplete="off">
                                <label id="input_user_email_note" for="input_user_email">请输入邮箱地址</label>
                                <div id="input_user_email_info"></div>
                                <div style="clear: both"></div>
                            </div>
                            <div id="input_user_qq_line">
                                <label id="input_user_qq_label" for="input_user_qq">qq号：</label>
                                <input id="input_user_qq" name="user_qq" type="text" autocomplete="off">
                                <label id="input_user_qq_note" for="input_user_qq">请输入qq号</label>
                                <div id="input_user_qq_info"></div>
                                <div style="clear: both"></div>
                            </div>
                            <div id="submit2">
                                <input id="btn_user_info_submit2" type="submit" value="提交" >
                            </div>
                        </form>
                    </div>
                </div>
                <div id="container_3">
                    <div id="user_protrait_page">
                        <form action="../page_redirect/user_info_setting.php" method="post">
                            <div id="input_user_portrait_line">
                                <div id="label_user_portrait_original">设置头像</div>
                                <div id="line_1"></div>
                                <input id="user_portrait_original" name="user_portrait_original" type="file" accept="image/gif,image/jpeg,image/png,image/jpg" onchange="return portraitUpload()">
                                <div id="fake_button">上传头像</div>
                                <div id="input_user_portrait_info">
                                    <div id="uploading">
                                        <img id="upload_wait_img" src="../media/images/system/user_main.php/1.gif">
                                        <div id="upload_wait_note">上传图像中。。。。。</div>
                                    </div>
                                    <div id="select_info_line">
                                        <div id="select_info"></div>
                                    </div>
                                </div>
                                <div id="portrait_select_area">
                                    <img id="img_user_portrait_original" src="">
                                    <div id="select_window_area">
                                        <div id="top_cover" class="cover" ></div>
                                        <div id="left_cover" class="cover" ></div>
                                        <div id="select_window"></div>
                                        <div id="right_cover" class="cover" ></div>
                                        <div id="bottom_cover" class="cover" ></div>
                                    </div>
                                </div>
                                <div id="fake_button_2">重新上传</div>
                                <input id="btn_confirm_portrait" type="button" value="选定头像" onclick="return portraitConfirm()">
                                <div id="confirm_user_portrait_line">
<!--                                    <div id="label_confirm_user_protrait">用户头像</div>-->
                                    <img id="confirm_user_portrait" src="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="foot"></div>
    </div>
</div>

</body>
<script src="user_main.js"></script>
<script>
    var UID=<?php echo $UID; ?>;
    var cover_left=0;
    var cover_right=0;
    var cover_top=0;
    var cover_bottom=0;
    var cover_width=0;
    var cover_height=0;
    var img_height=0;
    var portrait_tmp="";
    var portrait_file_type="";
    var input_value="";
    var user_name_check=1;
    var user_email_check=1;
    var user_password_check=1;
    var user_qq_check=1;

    $("#select_item").tabs();
    $("#sex_radio").buttonset();
    $("#password_change_checkbox").button();
    $("#fake_button").button();
    $("#fake_button").on("click",function(){ $("#user_portrait_original").click() });
    $("#fake_button_2").button();
    $("#fake_button_2").on("click",function(){ $("#user_portrait_original").click() });
    $("#btn_confirm_portrait").button();
//    $("#head_login_btn").button();
//    $("#head_logout_btn").button();
    var tooltips = $( "[title]" ).tooltip({
        position: {
            my: "left top",
            at: "right+5 top-5"
        }
    });

    $(document).ready(function(){
        $("#uploading").on({
            ajaxStart:function(){ $(this).show(); },
            ajaxComplete:function(){  $(this).hide(); }
        })
        <?php if(isset($_GET["code"])){
        switch($_GET["code"]){
            case 2:
            ?>alert("邮箱已被使用，请更换。"); <?php
            break;
            case 3:
            ?>alert("邮箱格式不对，请更换。"); <?php
            break;
            case 4:
            ?>alert("用户名长度错误，请更换。"); <?php
            break;
            case 5:
            ?>alert("该用户名已被使用，请更换。"); <?php
            break;
            case 6:
            ?>alert("密码格式不合规，请更换。"); <?php
            break;
            case 7:
            ?>alert("两次密码输入不一致，请更换。"); <?php
            break;
            case 8:
            ?>alert("原密码输入错误。"); <?php
            break;
            case 9:
            ?>alert("QQ号已被占用。"); <?php
            break;
            case 10:
            ?>alert("qq号只能为数字。"); <?php
            break;
        }
        } ?>
//        $("#btn_user_portrait_upload").click(function(){portraitUpload()});
//        $("#user_portrait_original").on("change",function(){portraitUpload();});
//        document.getElementById("user_portrait_original").addEventListener("change",function(){portraitUpload();});
//        $("#fake_portrait_input").on("change",function(){portraitUpload()});
        <?php if(!empty($obj->user_portrait_L)){ ?>
            $("#confirm_user_portrait_line").css("display","block");
            $("#confirm_user_portrait").attr("src","../<?php echo $user_portrait_L ; ?>" );
        <?php }else{
            switch ($user_sex){
                case "F":
                    ?> $("#confirm_user_portrait_line").css("display","block");
                       $("#confirm_user_portrait").attr("src","../media/images/portrait/x/female.jpg" ); <?php
                           break;
                       case "M":
                    ?> $("#confirm_user_portrait_line").css("display","block");
                       $("#confirm_user_portrait").attr("src","../media/images/portrait/x/male.jpg" ); <?php
                           break;
                       default:
                    ?> $("#confirm_user_portrait_line").css("display","block");
                       $("#confirm_user_portrait").attr("src","../media/images/portrait/x/x.jpg" ); <?php
                   }
               } ?>

        <?php if(empty($name)||empty($user_name)){ ?>
            $("#input_user_name_info").css("color","red");
            $("#input_user_name_note").css("display","block");
            $("#input_user_name").css("color","grey");
            $("#input_user_name").on({
                click:function(){ $("#input_user_name_note").css("display","none"); },
                blur:function(){
                    if($("#input_user_name").val()==""){
                        $("#input_user_name_note").css("display","block");
                    }
                },
                keyup:function(){ checkUserNameInput(); }
            });

        <?php }else{ ?>
            $("#input_user_name").attr("disabled","disabled");
        <?php } ?>


        $("#password_change_checkbox").on("click",function(){  password_line_display() });
        $("#user_password").on("keyup",function(){ if($("#user_password2").val()!=""){checkPasswordDuplication()}});
        $("#user_password").on("keyup",function(){ checkPasswordType() });
        $("#user_password2").on("keyup",function(){ checkPasswordDuplication()});
        $("input:submit").button();

        <?php    if(!empty($user_email)){ ?>
        $("#input_user_email").val("<?php echo $user_email; ?>");
        $("#input_user_email").on("keyup",function(){
            checkUserEmailInput()
        });
        <?php    }else{  ?>
        $("#input_user_email_note").css("display","block");
        $("#input_user_email").on({
            keyup:function(){ checkUserEmailInput() },
            click:function(){ $("#input_user_email_note").css("display","none")   },
            blur:function(){
                if($("#input_user_email").val()==""){
                    $("#input_user_email_note").css("display","block")
                }
            }
        });
        <?php }        ?>
        <?php    if(!empty($user_qq)){ ?>
        $("#input_user_qq").val("<?php echo $user_qq; ?>");
        $("#input_user_qq").on("keyup",function(){
            checkUserQQInput()
        });
        <?php    }else{  ?>
        $("#input_user_qq_note").css("display","block");
        $("#input_user_qq").on({
            keyup:function(){ checkUserQQInput() },
            click:function(){ $("#input_user_qq_note").css("display","none")   },
            blur:function(){
                if($("#input_user_qq").val()==""){
                    $("#input_user_qq_note").css("display","block")
                }
            }
        });
        <?php }        ?>

            $("#select_window").resizable({
            minHeight:100,
            minWidth:100,
            maxWidth:800,
            aspectRatio:1,
            containment:"#select_window_area"
            });
        $("#select_window").draggable({
            containment:"#select_window_area",
            scroll:false,
            drag:function(){
                cover_top=$("#select_window")[0].offsetTop;
                cover_left=$("#select_window")[0].offsetLeft;
                cover_right=800-cover_width-cover_left;
                cover_bottom=img_height-cover_height-cover_top;
                $("#top_cover").css("height",cover_top+"px");
                $("#bottom_cover").css("height",cover_bottom+"px");
                $("#left_cover").css({
                    "top":cover_top+"px",
                    "width":cover_left+"px"
                });
                $("#right_cover").css({
                    "top":cover_top+"px",
                    "width":cover_right+"px"
                })
            }
        });
        $("#select_window").on("resize",function(){
            cover_width=parseInt($("#select_window").css("width"));
            cover_height=parseInt($("#select_window").css("height"));
            cover_right=800-cover_width-cover_left;
            cover_bottom=img_height-cover_height-cover_top;
            $("#top_cover").css("height",cover_top+"px");
            $("#bottom_cover").css("height",cover_bottom+"px");
            $("#left_cover").css({
                "height":cover_height+"px"
            });
            $("#right_cover").css({
                "top":cover_top+"px",
                "width":cover_right+"px",
                "height":cover_height+"px"
            })
        })
    })
</script>
</html>