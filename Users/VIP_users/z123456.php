<?php 

            session_start(); 

            if(($_SESSION['user_name']!="z123456")){

            echo "hello, z123456.";

            }else{

            toSignOutPage();} 

            ?>