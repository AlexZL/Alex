<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-9
 * Time: 上午11:11
 */
session_start();
require("../include/Alex.php");
cookieCheck();
sessionUserNameCheck();
?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../include/index_style.css">
    <script src="../include/myJS.js"></script>
</head>
<body>
<div id="background"><img id="background_img" src="../media/images/index_background/index_background4.gif"></div>
<div id="background_div">
    <div id="register_background_div"></div>
    <div id="register" style="display: none">
        <form id="form_sign_in" action="../page_redirect/user_register.php" method="post">
            <label for="register_name_input" id="register_name_input_title">帐号（必填）：</label>
            <input id="register_name_input" type="text" name="register_user_name">
            <div id="register_name_input_info"></div>
            <label for="register_password_input" id="register_password_input_title">请输入密码（必填）：</label>
            <input id="register_password_input" type="password" name="register_user_password">
            <div id="register_password_input_info"></div>
            <label for="register_password_input2" id="register_password_input_title2">请再次输入密码（必填）：</label>
            <input id="register_password_input2" type="password" name="register_user_password2">
            <div id="register_password_input_info2"></div>
            <label for="register_email_input" id="register_email_input_title">电子邮箱：</label>
            <input id="register_email_input" type="text" name="register_user_email">
            <div id="register_email_input_info"></div>
            <input id="key_checkbox" type="checkbox" name="key_checkbox" value="1"><label for="key_checkbox" id="key_checkbox_label">我有注册码</label>
            <label for="register_key_input" id="register_key_input_title">我的注册码</label>
            <input id="register_key_input" type="text" name="register_user_key">
            <div id="register_key_input_info"></div>
            <div id="register_btn_back"></div>
            <input id="btn_sign_up" type="submit" value="注&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;册">
        </form>
    </div>
    <div id="login">
        <form action="../page_redirect/login_check.php" method="post">
            <label for="input_login_user_name" id="input_login_name_note">帐号</label>
            <input id="input_login_user_name" type="text" name="login_user_name" class="input">
            <label for="input_login_user_password" id="input_login_password_note">密码</label>
            <input id="input_login_user_password" type="password" name="login_user_password" class="input">
            <input id="cookie" type="checkbox" value=1 name="cookie"><label for="cookie" id="label_cookie">记住用户名和密码</label>
            <input id="btn_sign_in" type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录">
        </form>
        <div id="login_user_name_info"></div>
    </div>
    <div id="login_icon" class="login_icon_2">登录</div>
    <div id="register_icon" class="register_icon_2">注册</div>
    <div id="pull" class="pull_2">收起</div>

</div>


</body>
<script>
window.onload=function(){

    setTimeout('registerDivCome()',500);
    login_input_name_obj.addEventListener("input",function(){check_user_input_name1();});
    login_input_name_obj.addEventListener("blur",function(){displayInputBlock(login_input_name_obj,0.5);check_user_input_name1();});
    login_input_name_obj.addEventListener("focus",function(){displayInputBlock(login_input_name_obj,1);});
    login_input_password_obj.addEventListener("input",function(){check_user_input_name1();});
    login_input_password_obj.addEventListener("blur",function(){displayInputBlock(login_input_password_obj,0.5);check_user_input_name1()});
    login_input_password_obj.addEventListener("focus",function(){displayInputBlock(login_input_password_obj,1);check_user_input_name1()});
    login_icon.addEventListener("mouseover",function(){registerDivCome();if(register_div_state==1){login.style.display="block";register.style.display="none";login_icon.className="login_icon_1";register_icon.className="register_icon_2";pull.className="pull_2";register_icon.style.opacity="0.5";login_icon.style.opacity="1";pull.style.opacity="0.5"}});
    login_btn.addEventListener("mouseover",function(){login_btn.style.opacity="1"});
    login_btn.addEventListener("mouseout",function(){login_btn.style.opacity="0.5"});



    register_name_input.addEventListener("input",function(){check_register_name_input();});
    register_name_input.addEventListener("blur",function(){check_register_name_input();register_name_input.style.opacity="0.5"});
    register_name_input.addEventListener("focus",function(){check_register_name_input();register_name_input.style.opacity="1"});
    register_password_input.addEventListener("input",function(){checkRegisterPasswordInput();check_register_name_input()});
    register_password_input.addEventListener("blur",function(){checkRegisterPasswordInput();check_register_name_input();register_password_input.style.opacity="0.5"});
    register_password_input.addEventListener("focus",function(){checkRegisterPasswordInput();check_register_name_input();register_password_input.style.opacity="1"});
    register_password_input2.addEventListener("input",function(){checkRegisterPasswordInput();check_register_name_input();});
    register_password_input2.addEventListener("blur",function(){checkRegisterPasswordInput();check_register_name_input();register_password_input2.style.opacity="0.5"});
    register_password_input2.addEventListener("focus",function(){checkRegisterPasswordInput();check_register_name_input();register_password_input2.style.opacity="1"});
    register_background_div.addEventListener("mouseover", function(){check_register_name_input();checkRegisterPasswordInput();displayInputKey();check_user_input_name1()});
    register_email_input.addEventListener("input",checkEmailName);
    register_email_input.addEventListener("blur",function(){checkEmailName();register_email_input.style.opacity="0.5"});
    register_email_input.addEventListener("focus",function(){checkEmailName();register_email_input.style.opacity="1"});
    checkbox.addEventListener("click",displayInputKey);
    register_key_input.addEventListener("input",function(){checkKeyDuplicate()});
    register_key_input.addEventListener("blur",function(){checkKeyDuplicate();register_key_input.style.opacity="0.5"});
    register_key_input.addEventListener("focus",function(){checkKeyDuplicate();register_key_input.style.opacity="1"});
    register_icon.addEventListener("mouseover",function(){registerDivCome();if(register_div_state==1){register.style.display="block";login.style.display="none";register_icon.className="register_icon_1";login_icon.className="login_icon_2";pull.className="pull_2";register_icon.style.opacity="1";login_icon.style.opacity="0.5";pull.style.opacity="0.5"}});
    register_icon.addEventListener("click",function(){});
    register_btn.addEventListener("mouseover",function(){register_btn.style.opacity="1"});
    register_btn.addEventListener("mouseout",function(){register_btn.style.opacity="0.5"});
    pull.addEventListener("mouseover",function(){registerDivCome();if(register_div_state==1){pull.className="pull_1";register_icon.style.opacity="0.5";login_icon.style.opacity="0.5";pull.style.opacity="1"}});
    pull.addEventListener("mouseout",function(){registerDivCome();if(register_div_state==1){pull.classNames="pull_2";pull.style.opacity="0.5"}});
    pull.addEventListener("click",function(){registerDivBack();})


};
var login_input_name_obj=document.getElementById("input_login_user_name");
var login_input_password_obj=document.getElementById("input_login_user_password")
var login_name_note_obj=document.getElementById("input_login_name_note");
var login_password_note_obj=document.getElementById("input_login_password_note");
var login_info = document.getElementById("login_user_name_info");
var login_obj=document.getElementById("login_background_div");
var login_icon=document.getElementById("login_icon");
//    var login_submit=document.getElementById("div_btn_sign_in");
var login_btn=document.getElementById("btn_sign_in");

var register_name_input=document.getElementById("register_name_input");
var register_password_input=document.getElementById("register_password_input");
var register_password_input2=document.getElementById("register_password_input2");
var register_email_input=document.getElementById("register_email_input");
var register_key_input=document.getElementById("register_key_input");
var register_name_input_info=document.getElementById("register_name_input_info");
var register_password_input_info=document.getElementById("register_password_input_info");
var register_password_input_info2=document.getElementById("register_password_input_info2");
var register_email_input_info=document.getElementById("register_email_input_info");
var register_key_input_info=document.getElementById("register_key_input_info");
var register_icon=document.getElementById("register_icon");
var register_btn=document.getElementById("btn_sign_up");
var register_btn_back=document.getElementById("register_btn_back");
var register_background_div=document.getElementById("register_background_div");
var checkbox=document.getElementById("key_checkbox");
var background_div=document.getElementById("background_div");

var register=document.getElementById("register");
var login=document.getElementById("login");
var pull=document.getElementById("pull");

var register_name_state_num=0;
var register_password_state_num=0;
var register_password_state_num2=0;

var myreq=getXMLHTTPRequest();
var myreq2=getXMLHTTPRequest();

var login_location_num=0;
var t1=0;

function hideLoginInputNote(obj){
    obj.style.display="none";
}
function showLoginInputNote(check_obj,note_obj){
    if(check_obj.value==""){
        note_obj.style.display="block"
    }else{
        note_obj.style.display="none"
    }
}

function check_user_input_name1(){
    var code=input_name_code1();
    switch (code){
        case 0:
            login_info.innerHTML="";
            change_username_class1("black");
            login_btn.style.display="none";
            break;
        case 1:
            check_input_name_dupicate1();
            break;
        case 2:
            change_username_class1("black");
            login_info.innerHTML="用户名长度必须在4-20之间。";
            login_btn.style.display="none";
            break;
        case 3:
            change_username_class1("black");
            login_info.innerHTML="用户名只能包含字母数字和下划线。";
            login_btn.style.display="none";
            break;
        case 4:
            change_username_class1("black");
            login_info.innerHTML="用户名必须以字母开头。";
            login_btn.style.display="none";
            break;
    }
}
function input_name_code1(){
    var input_str=login_input_name_obj.value;
    var check_return_code=1;
    if(input_str==""){
        check_return_code = 0;
        return check_return_code;
    }
    if(input_str.length<4||input_str.length>20){
        check_return_code=2;
        return check_return_code;
    }
    var regexp=/^[a-zA-Z0-9_]{4,20}$/i;
    if(!regexp.test(input_str)){
        check_return_code=3;
        return check_return_code;
    }
    var regexp2=/^[a-z]$/i;
    if(!regexp2.test(input_str.substr(0,1))){
        check_return_code=4;
        return check_return_code;
    }
    return check_return_code;
}
function check_input_name_dupicate1(){
    var thePage="../page_redirect/ajax/name_duplicate_check.php";
    var name=document.getElementById("input_login_user_name").value;
    myRand=parseInt(Math.random()*99999999);
    var url=thePage+"?rand="+myRand+"&name="+name;
    myreq.open("GET",url,true);
    myreq.onreadystatechange=theHTTPResponse1;
    myreq.send(null);
}
function theHTTPResponse1(){
    if(myreq.readyState==4){
        if(myreq.status==200){
            var code=myreq.responseText;
            if(code==1){
                change_username_class1("green")
                login_info.innerHTML="欢迎，"+login_input_name_obj.value+"，请别忘了输入密码。";
                login_btn.style.display="block";
            }else{
                change_username_class1("red");
                login_info.innerHTML="请确认没有写错用户名";
                login_btn.style.display="none";
            }
        }
    }
}
function change_username_class1(color){
    document.getElementById("input_login_user_name").style.color=color;
}



function check_register_name_input(){
    var code=input_name_code2();
    switch (code){
        case 0:
            register_name_input_info.innerHTML="";
            register_btn.style.display="none";
            register_btn_back.style.display="none";
            register_name_input.style.color="black";
            break;
        case 1:
            check_input_name_duplicate2();
            break;
        case 2:
            changeObjTextColor(register_name_input,"red");
            register_btn.style.display="none";
            register_btn_back.style.display="none";
            register_name_input_info.innerHTML="用户名长度必须在4-20之间";
            break;
        case 3:
            changeObjTextColor(register_name_input,"red");
            register_btn.style.display="none";
            register_btn_back.style.display="none";
            register_name_input_info.innerHTML="用户名只能包含数字和下划线";
            break;
        case 4:
            changeObjTextColor(register_name_input,"red");
            register_btn.style.display="none";
            register_btn_back.style.display="none";
            register_name_input_info.innerHTML="用户名必须以字母开头";
            break;
    }
}
function input_name_code2(){
    var input_str=register_name_input.value;
    var check_return_code=1;
    if(input_str==""){
        check_return_code = 0;
        return check_return_code;
    }
    if(input_str.length<4||input_str.length>20){
        check_return_code=2;
        return check_return_code;
    }
    var regexp=/^[a-zA-Z0-9_]{4,20}$/i;
    if(!regexp.test(input_str)){
        check_return_code=3;
        return check_return_code;
    }
    var regexp2=/^[a-z]$/i;
    if(!regexp2.test(input_str.substr(0,1))){
        check_return_code=4;
        return check_return_code;
    }
    return check_return_code;

}
function check_input_name_duplicate2(){
    var thePage="../page_redirect/ajax/name_duplicate_check.php";
    var name=register_name_input.value;
    myRand=parseInt(Math.random()*99999999);
    var url=thePage+"?rand="+myRand+"&name="+name;
    myreq.open("GET",url,true);
    myreq.onreadystatechange=theHTTPResponse2;
    myreq.send(null);
}
function theHTTPResponse2(){
    if(myreq.readyState==4){
        if(myreq.status==200){
            var code=myreq.responseText;
            if(code==1){
                changeObjTextColor(register_name_input,"red");
                register_name_input_info.innerHTML="用户名已被占用";
                register_btn.style.display="none";
                register_btn_back.style.display="none";
                register_name_state_num=0;
            }else{
                changeObjTextColor(register_name_input,"green");
                register_name_input_info.innerHTML="用户名可以使用";
                register_name_state_num=1;
                displayRegisterBtn();
            }
        }
    }
}
function checkRegisterPasswordInput(){
    var password_str1=register_password_input.value;
    var password_str2=register_password_input2.value;
    if(password_str1==""){
        register_password_input_info.innerHTML="";
        register_password_input.style.color="black";
        register_btn.style.display="none";
        register_btn_back.style.display="none";
        register_password_state_num=0;
        return;
    }
    if(password_str1.length<6||password_str1.length>22){
        register_password_input_info.innerHTML="密码长度在6-22之间";
        register_password_input.style.color="red";
        register_btn.style.display="none";
        register_btn_back.style.display="none";
        register_password_state_num=0;
        return;
    }
    var regexp=/^[a-zA-Z0-9\#\~\!\@\-\%\^\&\*\.,:;\\\$\(\)\"\[\]\{\}\<\>\?\/\\\\]{6,22}$/;
    if(!regexp.test(password_str1)){
        register_password_input_info.innerHTML="密码不能包含空格或者汉字";
        register_password_input.style.color="red";
        register_btn.style.display="none";
        register_btn_back.style.display="none";
        register_password_state_num=0;
        return;
    }
    var regexp1=/^[A-Z]$/;
    if(!regexp1.test(password_str1.substr(0,1))){
        register_password_input_info.innerHTML="密码第一个必须为大写字母";
        register_password_input.style.color="red";
        register_btn.style.display="none";
        register_btn_back.style.display="none";
        register_password_state_num=0;
        return;
    }
    register_password_input_info.innerHTML="";
    register_password_input.style.color="green";
    if(password_str1==password_str2){
        register_password_state_num=1;
        register_password_input_info2.innerHTML="";
        register_password_input2.style.color="green";
        displayRegisterBtn();
    }else{
        register_btn.style.display="none";
        register_btn_back.style.display="none";
        if(password_str2==""){
            register_password_input_info2.innerHTML="";
            register_password_input.style.color="black";
        }else{
            register_password_input_info2.innerHTML="两次密码输入不一样";
            register_password_input2.style.color="red";
        }
    }
}
function checkEmailName(){
    var regexp=/^[a-zA-Z0-9][a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+[a-zA-Z0-9]$/;
    var str=register_email_input.value;
    if(str==""){
        register_email_input_info.innerHTML="";
        register_email_input.style.color="black";
    }else{
        if(regexp.test(str)){
            register_email_input_info.innerHTML="";
            register_email_input.style.color="green";
        }else{
            register_email_input_info.innerHTML="格式错误";
            register_email_input.style.color="red";
        }
    }
}
function displayInputKey(){
    if(checkbox.checked){
        register_key_input.style.display="block";
        register_key_input_info.style.display="block"
    }else{
        register_key_input.style.display="none";register_key_input_info.style.display="none"
    }
}
function checkKeyDuplicate(){
    var page="../page_redirect/ajax/key_duplicate_check.php";
    var key=register_key_input.value;
    var rand=parseInt(Math.random()*99999999);
    var url=page+"?rand="+rand+"&key="+key;
    myreq2.open("GET",url,true);
    myreq2.onreadystatechange=keyDuplicateResponse;
    myreq2.send(null);
}
function keyDuplicateResponse(){
    if(myreq2.readyState==4){
        if(myreq2.status==200){
            var code=myreq2.responseText;
            if(code==0){
                register_key_input_info.innerHTML="没有此注册码";
                register_key_input.style.color="red";
                return;
            }
            if(code==2){
                register_key_input_info.innerHTML="注册码已被使用";
                register_key_input.style.color="red";
                return;
            }
            if(code==1){
                register_key_input_info.innerHTML="该注册码可以使用";
                register_key_input.style.color="green";
            }
        }
    }
}
function displayRegisterBtn(){
    if(register_name_state_num==1&&register_password_state_num==1){
        register_btn.style.display="block";
        register_btn_back.style.display="block";
    }
}
function displayInputBlock(obj,opacity){
    obj.style.opacity=opacity
}
function changeObjTextColor(obj,color_str){
    obj.style.color=color_str;
}

var t2=0;
var register_div_state=0;
function registerDivCome(){
    if(register_div_state==0){
        background_div.style.top=Math.round(Tween.Circ.easeOut(t2,-570,570,20))+"px";
        if(t2!=20){
            t2++;
            setTimeout('registerDivCome()',10);
            return;
        }
        if(t2==20){
            t2=0;
            register_div_state=1;
            register_icon.style.opacity="0.5";
            pull.style.opacity="0.5";
            login_icon.className="login_icon_1";
        }
    }
}
function registerDivBack(){
    if(register_div_state==1){
        background_div.style.top=Math.round(Tween.Circ.easeOut(t2,0,-570,20))+"px";
        if(t2!=20){
            t2++;
            setTimeout('registerDivBack()',10);
            return;
        }
        if(t2==20){
            t2=0;
            login_icon.style.opacity="1";
            register_div_state=0;
        }
    }
}
</script>
</html>