<?php
session_start();
require("../include/Alex.php");
$code=$_GET['code'];
if(empty($_GET["page_code"])){
    $go_page="./index.php";
}else{
    $go_page=myCode($_GET["page_code"]);
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Wrong Input</title>
    <script src="../include/myJS.js"></script>
</head>
<body>
<div><?php
    switch($code){
        case 0:
            echo "用户名或密码不能为空，请重新输入。";
            break;
        case 2:
            echo "用户名长度在4-20之间，请重新输入。";
            break;
        case 3:
            echo "用户名只能是字母和下划线组合，且必须以字母开头，请重新输入。";
            break;
        case 4:
            echo "用户名必须以字母开头，请重新输入";
            break;
        case 5:
            echo "用户名已被占用，请重新输入";
            break;
        case 6:
            echo "密码长度在6-22之间，请重新输入";
            break;
        case 7:
            echo "密码不能包含空格或者汉字，请重新输入。";
            break;
        case 8:
            echo "密码第一个必须是大写字母，请重新输入。";
            break;
        case 9:
            echo "电子邮件格式不正确，请重新输入";
            break;
        case 10:
            echo "数据库无法连接，请稍候重试。";
            break;
        case 11:
            echo "注册码格式错误，请重新输入";
            break;
        case 12:
            echo "注册码已使用！";
            break;
        case 13:
            echo "注册码错误";
            break;
        case 14:
            echo "帐号或密码错误，请重新输入。";
            break;
        case 15:
            echo "cookie验证错误！";
            break;
        case 16:
            echo "登录过期，请重新登录.";
            break;
        case 17:
            echo "ceshi";
            break;
        case 18:
            echo "您还未登录，请登录";
            break;
        case 20:
            echo "两次输入密码不一样。";
            break;
        case 21:
            echo "用户名过长或过短";
            break;
        case 22:
            echo "用户名不能为空";
            break;
        default:
            echo "页面不存在";
    }
    setcookie(substr(sha1("mengting"),0,12),"",time()-1);
    unset($_SESSION['user_name']);
    session_destroy();
    echo $code;
    ?></div><br/>
<div id="change_to_index_info"></div>
<input type="button" value="Go now" id="btn_go_now">
</body>
<script>
    var timer=5;
    var btn_go_now_obj=document.getElementById("btn_go_now");
    btn_go_now_obj.addEventListener("click",function(){window.location.href="<?php echo $go_page; ?>";});
    function Page_change_to_index_delayed(){
        var info_obj=document.getElementById("change_to_index_info");
        if(timer!=-1){
            info_obj.innerHTML="Page will redirect to login page in "+timer+" seconds";
            setTimeout("Page_change_to_index_delayed()",1000);
            timer--;
        }else{
            window.location.href="<?php echo $go_page; ?>";
        }
    }
    Page_change_to_index_delayed();
</script>
</html>