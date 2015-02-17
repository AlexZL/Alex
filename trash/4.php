<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15-1-10
 * Time: 下午9:16
 */
require("../forums/include/blog.php");
$str="1234566785gebnsrthban[img]http://localhost/Alex/MerryChristmas/media/image/gif/1.gif[/img]3tga4y3hu[img]http://localhost/Alex/MerryChristmas/media/image/gif/2s.png[/img]";
//if(preg_match_all("/\[img\](?<host>[\w\/\:\.]*)\[\/img\]/",$str,$match)){
////if(preg_match_all("/^\[img\]http\:\/\/localhost\/Alex\/MerryChristmas\/media\/image\/gif\/1\.gif\[\/img\]$/",$str,$match)){
//        echo "preg!:<br/>";
//    echo "<br/>";
//}else{
//    echo "no preg";
//}
//for($i=0;$i!=count($match["host"]);$i++){
//    $par="[img]".$match["host"][$i]."[/img]";
//    $rep="<img src=\"".$match["host"][$i]."\">";
//    $str=str_replace($par,$rep,$str);
//}
////$str1=preg_replace($par,$rep,$str);
//echo $str."<br/>";
//print_r($par);
$str1=pictureCodeReplace($str);
echo $str1;