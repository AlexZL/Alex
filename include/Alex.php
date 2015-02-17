<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14-12-31
 * Time: 上午10:34
 */

$server_ip_addr="http://localhost/";
    function check_password($user_password){
        if(strlen(trim($user_password))<6||strlen(trim($user_password))>22){
            //长度在6-22；
            $return_password=2;
        }elseif(!preg_match("/^[a-zA-Z0-9\#\~\!\@\-\%\^\&\*\.,:;\\\$\(\)\"\[\]\{\}\<\>\?\/\\\\]{6,22}$/",trim($user_password))){
            //不能包含空格和汉字。
            $return_password=3;
        }elseif(!preg_match("/^[A-Z]$/",substr(trim($user_password),0,1))){
            //首字母大写;
            $return_password=4;
        }else{
            //输入正确
            $return_password=trim($user_password);
        }
        return $return_password;
    }
    function check_name($user_name){
        if(strlen(trim($user_name))<4||strlen(trim($user_name))>20){
            //长度在4-20；
            $return_name=2;
        }elseif(!preg_match("/^[a-zA-Z0-9_]{4,20}$/",trim($user_name))){
            //只能是字母数字下划线组合。
            $return_name=3;
        }elseif(!preg_match("/^[a-zA-Z]$/",substr(trim($user_name),0,1))){
            //首字必须为字母;
            $return_name=4;
        }else{
            //输入正确
            $return_name=trim($user_name);
        }
        return $return_name;
    }
function check_email($user_email){
    if($user_email==""){
        $return_email="";
        return $return_email;
    }
    if(!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+[a-zA-Z0-9]$/",trim($user_email))){
        //需匹配电子邮箱格式
        $return_email=2;
        return $return_email;
    }else{
        //输入正确
        $return_email=trim($user_email);
        return $return_email;

    }
}
function check_key($user_key){
    if($user_key==""){
        //注册码空值，返回空值；
        $return_key="";
        return $return_key;
    }
//    if(strlen(trim($user_key))!=20){
//        //验证码长度不够
//        $return_key=0;
//        $return_key = 0;
//        return $return_key;
//    }
    if(!preg_match("/^[a-fA-F0-9]{20}$/",trim($user_key))) {
            //验证码格式不正确；
            $return_key = 4;
            return $return_key;
        }

    $mysql=new mysqli("localhost","alex","z198569l","my_page");
    $result=$mysql->query("select * from tb_user_login_info WHERE `key_summary`='$user_key' AND `user_account`=''");
    if($result->num_rows==1){
        //数据库存在未使用验证码；
        $return_key = $user_key;
        $mysql->close();
        return $return_key;
    }else{
        $result2=$mysql->query("select * from tb_user_login_info WHERE `key_summary`='$user_key'");
        if($result2->num_rows==1){
            //验证码已经使用；
            $return_key = 2;
            $mysql->close();
            return $return_key;
        }else{
            //不存在的验证码；
            $return_key=3;
            $mysql->close();
            return $return_key;
        }
    }
}
class mySession {
    public $account;
    public $user_ID;
    public $priority;
    public $name;
    function __construct($str){
        $arr=explode(":",$str);
        $this->account=$arr[0];
        $this->user_ID=$arr[1];
        $this->priority=$arr[2];
        $this->name=$arr[3];
    }
}
function setMyCookie($user_name_check){
    if(isset($_POST["cookie"])){
        $save_cookie=$_POST["cookie"];
        if($save_cookie==1){
            $arr=array();
            $arr[0]=$user_name_check;                                   //cookie 第一项记录用户名；
            $arr[1]=$_SERVER['HTTP_USER_AGENT'];                        //cookie 第二项记录浏览器信息；
            $ag=$_SERVER['HTTP_USER_AGENT'];                        //cookie 第二项记录浏览器信息；
            $arr[2]=substr(sha1($_SERVER['REMOTE_ADDR']),0,12);         //cookie 第三项记录用户IP,哈希加密后取前12位；
            $ip=$_SERVER['REMOTE_ADDR'];         //cookie 第三项记录用户IP,哈希加密后取前12位；
            $cookie_value=serialize($arr);
            $cookie_name2=strval(substr(sha1("mengting"),0,12));
            $cookie_name="A".$cookie_name2;
            setcookie($cookie_name,$cookie_value,time()+3600*24*10,"/");
            $mysql2=new mysqli("localhost","alex","z198569l","my_page");  //更新数据库中的user_agent 和 login_IP 两个信息，为了后期cookie验证;
            $mysql2->query("update tb_user_login_info set
                        `last_user_agent`='$ag',
                        `last_login_IP`='$ip'
                        WHERE
                        `user_account`='$user_name_check'");
        }
    }
}

function sessionUserNameCheck(){
    global $server_ip_addr;
    if(!isset($_SESSION['user_name'])){
        return;
    }else{
        header("location:".$server_ip_addr."Alex/Users/User_main.php");
        exit;
    }
//    $mysession=new mySession($_SESSION["user_name"]);

//    if($mysession->account=='alex'){
//        header("location:".$server_ip_addr."/Alex/Users/Admin/1.php");
//        exit;
//    }
//    if($mysession->account=='fiona') {
//        header("location:".$server_ip_addr."/Alex/Users/Admin/2.php");
//        exit;
//    }
//    if($mysession->priority=="6"){  //priority 为6的用户；VIP用户;
//        toVIPUserPage($mysession->user_ID);
//    }
//    if($mysession->priority=="9"){  //priority 为6的用户；普通用户;
//        toCommonUserPage($mysession->user_ID);
//    }else{ //priority 数值错误，清除sesseion，cookie，跳转到登录页；
//        $cookie_name2=strval(substr(sha1("mengting"),0,12));
//        $cookie_name="A".$cookie_name2;
//        setcookie($cookie_name,"",time()-1,"/");
//        unset($_SESSION['user_name']);
//        session_destroy();
//        return;
//    }
}
function checkCookieIP($IP){
    if(!preg_match("/^[a-fA-F0-9]{12}$/",$IP)){ //IP格式不匹配；
        $code=2;
        return $code;
    }else{
        $code=1;
        return $code;
    }
}
function cookieCheck(){
    $cookie_name2=strval(substr(sha1("mengting"),0,12));
    $cookie_name="A".$cookie_name2;
    if(isset($_COOKIE[$cookie_name])){
        $cookie_value=unserialize($_COOKIE[$cookie_name]);
        $user_name=$cookie_value[0];
        $user_agent=$cookie_value[1];
        $user_IP=$cookie_value[2];
        $name_code=check_name($user_name);
        if($name_code===2||$name_code===3||$name_code===4){
            setcookie($cookie_name,"",time()-1,"/");
            toWrongPage(15);
        }
        $IP_code=checkCookieIP($user_IP);
        if($IP_code==2){
            setcookie($cookie_name,"",time()-1,"/");
            toWrongPage(17);

        }
        $mysql=new mysqli("localhost","alex","z198569l","my_page");
        $result=$mysql->query("select `last_user_agent`,`last_login_IP` from tb_user_login_info WHERE `user_account`='$name_code'");
        $obj=$result->fetch_object();
        if($user_agent!=$obj->last_user_agent||$user_IP!=substr(sha1($obj->last_login_IP),0,12)){
            setcookie($cookie_name,"",time()-1,"/");
            toWrongPage(16);
        }
        $name_code=mb_strtolower($name_code,"UTF-8");
        $mysql=new mysqli("localhost","alex","z198569l","my_page");
        $result=$mysql->query("select `user_ID`,`user_name`,`priority` from tb_user_login_info where `user_account` = '$name_code'");
        $obj=$result->fetch_object();
        $_SESSION['user_name']=$name_code.":".$obj->user_ID.":".$obj->priority.":".$obj->user_name;
        $date=date("Y-m-d H:i:s");
        $mysql->query("update tb_user_login_info set `last_login_time`='$date' WHERE `user_account`='$name_code'");
        $mysql->close();
    }
}

function toWrongPage($code,$page_code=""){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/login/wrong_page.php?code=".$code."&page_code=".$page_code);
    exit;
}
function toWarningPage($code,$page_code){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/login/warning_info.php?code=".$code."&page_code=".$page_code);
    exit;
}
function toCommonUserPage($UID){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/Users/common_users/".$UID.".php");
    exit;
}
function toVIPUserPage($UID){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/Users/VIP_users/".$UID.".php");
    exit;
}
function toAdminPage($UID){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/Users/Admin/".$UID.".php");
    exit;
}
function toLoginPage(){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/login/index.php");
    exit;
}
function toSignOutPage($code){
    global $server_ip_addr;
    header("location:".$server_ip_addr."Alex/login/sign_out.php?code=".$code);
    exit;
}

class makePage{
    public $page_num;
    function __construct($page_num){
        $this->page_num=$page_num;
    }
    public function to_page($num,$show){
        echo "<form action=\"#head\" method='get'>";
        echo "<input type='hidden' name='page_num' value=\"".$num."\">";
        echo "<input type='submit' value=\"".$show."\"  class='page_btn'>";
        echo "</form>";
    }

    public    function to_this_page(){
        echo "<form action=\"#head\" method='get'>";
        echo "<input type='hidden' name='page_num' value=\"".$this->page_num."\" class='page_btn'>";
        echo "<input type='submit' value=\"".$this->page_num."\"  class='page_btn_this' disable=\"disabled\">";
        echo "</form>";
    }
    public function to_page_blank(){
        echo "<div class='page_btn_blank'>.....</div>";
    }
    public function to_page_blank_1(){
        echo "<div class='page_btn_blank'></div>";
    }
    public  function to_page_blank_2(){
        echo "<div class='page_btn_blank_2'></div>";
    }
    public function page_num_input($page_count){
        echo "<form action=\"#head\" method='get'>";
        echo "<div class='page_btn_word_3'>共 ".$page_count." 页</div>";
        echo "<div class='page_btn_word_1'>至第</div>";
        echo "<input type='text' name='page_num' class='page_num_input'>";
        echo "<div class='page_btn_word_2'>页</div>";
        echo "<input type='submit' class='page_num_input_btn' value=\"跳转\">";
        echo "</form>";
    }

}
function page_navigator_display($page_num,$page_count)
{
    $make_page = new makePage($page_num);
    if ($page_count == 1) {
        $make_page->to_page_blank_2();
        $make_page->to_page_blank_1();
        $make_page->to_this_page();
        $make_page->to_page_blank_1();
        $make_page->to_page_blank_2();
        return;
    }
    if ($page_count == 2) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count == 3) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            return;
        }
        if ($page_num == 3) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count == 4) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(2, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "尾页");
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(3, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "尾页");
            return;
        }
        if ($page_num == 3) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(2, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page(4, "4");
            $make_page->to_page(4, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "尾页");
            return;
        }
        if ($page_num == 4) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(3, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count == 5) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(2, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(3, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 3) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(2, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(4, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 4) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(3, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_this_page();
            $make_page->to_page(5, "5");
            $make_page->to_page(5, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 5) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count > 5) {
        if ($page_num == $page_count) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page(($page_num - 1), "上页");
            $make_page->to_page(($page_num - 4), ($page_num - 4));
            $make_page->to_page(($page_num - 3), ($page_num - 3));
            $make_page->to_page(($page_num - 2), ($page_num - 2));
            $make_page->to_page(($page_num - 1), ($page_num - 1));
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            $make_page->page_num_input($page_count);
            return;
        }
        if ($page_num == ($page_count - 1)) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page(($page_num - 1), "上页");
            $make_page->to_page(($page_num - 3), ($page_num - 3));
            $make_page->to_page(($page_num - 2), ($page_num - 2));
            $make_page->to_page(($page_num - 1), ($page_num - 1));
            $make_page->to_this_page();
            $make_page->to_page(($page_count), ($page_count));
            $make_page->to_page($page_count, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if ($page_num == ($page_count - 2)) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page(($page_num - 1), "上页");
            $make_page->to_page(($page_num - 2), ($page_num - 2));
            $make_page->to_page(($page_num - 1), ($page_num - 1));
            $make_page->to_this_page();
            $make_page->to_page(($page_num + 1), ($page_num + 1));
            $make_page->to_page(($page_num + 2), ($page_num + 2));
            $make_page->to_page($page_num + 1, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if($page_num==1){
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(2, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if($page_num==2){
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(3, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if($page_num==3){
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(2, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(4, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }else{
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page($page_num-1, "上页");
            $make_page->to_page($page_num-2, $page_num-2);
            $make_page->to_page($page_num-1, $page_num-1);
            $make_page->to_this_page();
            $make_page->to_page($page_num+1, $page_num+1);
            $make_page->to_page($page_num+2, $page_num+2);
            $make_page->to_page($page_num+1, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
        }
    }
}
function myCode($code){
    global $server_ip_addr;
    $location=$server_ip_addr."Alex/";
    $arr=explode("_",$code);
    $code1=intval($arr[0]);
    $code2=intval($arr[1]);
    $code3=intval($arr[2]);
    switch ($code1){
        case 1:
            $location.="Users/User_main.php";
            break;
        case 2:
            $location.="forums/";
            if(empty($code3)){
                $location.="sub_forum_";
                $location.=strval($code2);
            }else{
                $location.="sub_forum_".strval($code2)."/forum_blog_".strval($code3).".php";
            }
            break;
    }
    return $location;
}
function formSqlInput($str){
    $str0=trim($str);
    $str1=htmlspecialchars($str0);
    $str2=addslashes($str1);
    return $str2;
}
