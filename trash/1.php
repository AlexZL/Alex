<?php
$sub_forum_index=10;
$index=6;
$blog_table_main_name="tb_forum_main_".$sub_forum_index."_".$index;             //主帖数据库名称
$blog_table_reply_name="tb_forum_replies_".$sub_forum_index."_".$index;             //主帖数据库名称
$createsql=new mysqli("localhost","forum_creator","forumcreate","forums");
$createsql->query("CREATE TABLE $blog_table_main_name
                    ( `floor` SMALLINT NOT NULL AUTO_INCREMENT,
                      `title` TINYTEXT NOT NULL,
                      `content` TEXT NOT NULL ,
                      `creator` VARCHAR(30) NOT NULL,
                      `creator_ID` VARCHAR(20) NOT NULL ,
                      `create_time` VARCHAR(20) NOT NULL ,
                      PRIMARY KEY (`floor`)
                    )ENGINE=InnoDB;")or die(mysqli_error($createsql));
$createsql->query("
                    CREATE TABLE $blog_table_reply_name
                    ( `index` SMALLINT NOT NULL AUTO_INCREMENT,
                      `reply_to_floor` SMALLINT NOT NULL ,
                      `reply_content` TEXT NOT NULL ,
                      `replier` VARCHAR(30) NOT NULL ,
                      `replier_ID` INT NOT NULL ,
                      `repliy_to_who` VARCHAR(30) NOT NULL,
                       `reply_time` VARCHAR(25) NOT NULL ,
                       PRIMARY KEY(`index`)
                    )ENGINE=InnoDB;")or die(mysqli_error($createsql));
?>