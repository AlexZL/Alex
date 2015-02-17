<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/14
 * Time: 10:40
 */
session_start();
require("../include/Alex.php");
if(!isset($_SESSION["user_name"])){
    toWrongPage(18);
}
$mysession=new mySession($_SESSION["user_name"]);

$session_UID=$mysession->user_ID;                                           //用户ID
$name=$mysession->name;                                             //用户昵称
$account=$mysession->account;                                       //用户帐号
$priority=$mysession->priority;                                     //优先级
$date=date("Y-m-d H:i:s");
$forum_type=4;
$title_danger=$_POST["forum_title"];                                //帖子标题
$label_danger=$_POST["forum_label"];                                //帖子标签
$content_danger=$_POST["forum_content"];                            //帖子内容
$sub_forum_index=$_POST["forum_index"];                             //分论坛代号
if(empty($title_danger)||empty($content_danger)){
    header("location:".$server_ip_addr."Alex/login/warning_info.php?location=http://localhost/Alex/forums/sub_forum_".$sub_forum_index."/&warning_message=\"标题和内容不能为空。\"");
    exit;
}
if(!is_numeric($sub_forum_index)){
    toWrongPage(20);
}
//用户输入过滤
$title=htmlspecialchars(addslashes($title_danger));
$label=htmlspecialchars(addslashes($label_danger));
$content=htmlspecialchars(addslashes($content_danger));

$sub_forum_table_name="tb_forum_main_".$sub_forum_index;
$mysql=new mysqli("localhost","forum_reader","forumread","forums");
$result=$mysql->query("select MAX(`forum_index`) as num from $sub_forum_table_name");
$obj=$result->fetch_object();
$index=$obj->num+1;
$result->close();
$mysql->close();                                                        //获取帖子的index

$blog_table_content_name="tb_forum_blog_".$sub_forum_index."_".$index;             //主帖数据库名称
$blog_table_reply_name="tb_forum_reply_".$sub_forum_index."_".$index;             //主帖数据库名称
$createsql=new mysqli("localhost","forum_creator","forumcreate","forums");

//创建数据库，
$createsql->query("CREATE TABLE $blog_table_content_name
                    ( `floor` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `content` TEXT NOT NULL ,
                      `creator` VARCHAR(30) NOT NULL,
                      `creator_ID` SMALLINT UNSIGNED NOT NULL ,
                      `create_time` VARCHAR(25) NOT NULL ,
                      PRIMARY KEY (`floor`)
                    )ENGINE=InnoDB;")or die(mysqli_error($createsql));
$createsql->query(" CREATE TABLE $blog_table_reply_name
                    ( `index` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `reply_to_floor` SMALLINT UNSIGNED NOT NULL ,
                      `reply_content` TEXT NOT NULL ,
                      `replier` VARCHAR(30) NOT NULL ,
                      `replier_ID` SMALLINT UNSIGNED NOT NULL ,
                      `reply_to_who` VARCHAR(30) NOT NULL,
                      `reply_to_who_ID` SMALLINT UNSIGNED NOT NULL ,
                       `reply_time` VARCHAR(25) NOT NULL ,
                       PRIMARY KEY(`index`)
                    )ENGINE=InnoDB;")or die(mysqli_error($createsql));
$createsql->close();

$new_forum_page_location=$server_ip_addr."Alex/forums/sub_forum_".$sub_forum_index."/forum_blog_".$index.".php";

//更新数据库
$mysql=new mysqli("localhost","forum_reader","forumread","forums");
$mysql->query("insert into $blog_table_content_name
            (`content`,`creator`,`creator_ID`,`create_time`)
            values
            ('$content','$name','$session_UID','$date')")or die(mysqli_error($mysql));
$mysql->query("insert into $sub_forum_table_name
            (`forum_type`,`forum_title`,`forum_label`,`forum_creator`,`creator_ID`,`forum_create_date`,`forum_page_location`,`forum_last_reply_time`)
            values
            ('$forum_type','$title','$label','$name','$session_UID','$date','$new_forum_page_location','$date')")or die(mysqli_error($mysql));
$mysql->close();
$user_sql=new mysqli("localhost","alex","z198569l","my_page");
$user_sql->query("update tb_user_login_info set `blog_nums`=(`blog_nums`+1) WHERE `user_ID`='$session_UID'");
$user_sql->close();
//创建帖子主页
$fp=fopen("./blog_tempet.php","r");
flock($fp,LOCK_EX);
$fc=fread($fp,filesize("./blog_tempet.php"));
$fi=str_replace("\"yyyxxx\"",$sub_forum_index,$fc);
$fii=str_replace("\"xxxyyy\"",$index,$fi);
flock($fp,LOCK_UN);
fclose($fp);
$loc="./sub_forum_".$sub_forum_index."/forum_blog_".$index.".php";
$fp=fopen($loc,"w");
flock($fp,LOCK_EX);
fwrite($fp,$fii);
flock($fp,LOCK_UN);
fclose($fp);

header("location:".$new_forum_page_location);
exit();