<?php 

            session_start(); 

            if(($_SESSION['user_name']!="zhangsan")){

            echo "hello, zhangsan.";

            }else{

            toSignOutPage();} 

            ?>