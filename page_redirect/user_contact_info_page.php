<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/13
 * Time: 9:35
 */
session_start();
require("../include/Alex.php");

$out_put=array();
$output["code"]=0;
$my_session=new mySession($_SESSION["user_name"]);
$name=$my_session->name;
$account=$my_session->account;
$priority=$my_session->priority;
$UID=$my_session->user_ID;