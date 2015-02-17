<?php 

            session_start(); 

            $mysession=new mySession($_SESSION["user_name"]);

            if($mysession->user_ID!="1004"){

            toSignOutPage();

            }else{

            echo "hello, ";

            }

            ?>