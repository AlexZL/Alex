<?php 

            require("../../include/Alex.php");

            session_start(); 

            $mysession=new mySession($_SESSION["user_name"]);

            if($mysession->user_ID!="1007"){

            toSignOutPage();

            }else{

            echo "hello, ";

            }

            ?>