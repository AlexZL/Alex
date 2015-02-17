<?php 

            session_start(); 

            $mysession=new mySession($_SESSION["user_name"]);

            if($mysession->user_ID!=""){

            toSignOutPage();

            }else{

            echo "hello, ";

            }

            ?>