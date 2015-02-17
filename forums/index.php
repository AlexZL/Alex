<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/13
 * Time: 9:17
 */
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <title>Forum</title>
    <meta charset="utf-8">
</head>
<body>
<input id="btn_sub_forum_1" type="button" value="sub_forum_1">

</body>
</html>
<script>
    var btn_sub_forum_1 = document.getElementById("btn_sub_forum_1");
    btn_sub_forum_1.addEventListener("click",function(){
        window.location.href="sub_forum_1/index.php"
    })
</script>