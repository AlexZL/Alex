<?php 

            session_start(); 

            if(($_SESSION['user_name']!=xampp)){

            echo "hello, xampp.";

            }else{

            toSignOutPage();} 

            ?>