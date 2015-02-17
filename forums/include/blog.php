<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/16
 * Time: 10:55
 */
$server_ip_addr="http://localhost/";
class mySession {
    public $account;
    public $user_ID;
    public $priority;
    public $name;
    function __construct($str){
        $arr=explode(":",$str);
        $this->account=$arr[0];
        $this->user_ID=$arr[1];
        $this->priority=$arr[2];
        $this->name=$arr[3];
    }
}
class makePage{
    public $page_num;
    function __construct($page_num){
        $this->page_num=$page_num;
    }
    public function to_page($num,$show){
        echo "<form action=\"#head\" method='get'>";
        echo "<input type='hidden' name='page_num' value=\"".$num."\">";
        echo "<input type='submit' value=\"".$show."\"  class='page_btn'>";
        echo "</form>";
    }

    public    function to_this_page(){
        echo "<form action=\"#head\" method='get'>";
        echo "<input type='hidden' name='page_num' value=\"".$this->page_num."\" class='page_btn'>";
        echo "<input type='submit' value=\"".$this->page_num."\"  class='page_btn_this' disable=\"disabled\">";
        echo "</form>";
    }
    public function to_page_blank(){
        echo "<div class='page_btn_blank'>.....</div>";
    }
    public function to_page_blank_1(){
        echo "<div class='page_btn_blank'></div>";
    }
    public  function to_page_blank_2(){
        echo "<div class='page_btn_blank_2'></div>";
    }
    public function page_num_input($page_count){
        echo "<form action=\"#head\" method='get'>";
        echo "<div class='page_btn_word_3'>共 ".$page_count." 页</div>";
        echo "<div class='page_btn_word_1'>至第</div>";
        echo "<input type='text' name='page_num' class='page_num_input'>";
        echo "<div class='page_btn_word_2'>页</div>";
        echo "<input type='submit' class='page_num_input_btn' value=\"跳转\">";
        echo "</form>";
    }

}
function page_navigator_display($page_num,$page_count)
{
    $make_page = new makePage($page_num);
    if ($page_count == 1) {
        $make_page->to_page_blank_2();
        $make_page->to_page_blank_1();
        $make_page->to_this_page();
        $make_page->to_page_blank_1();
        $make_page->to_page_blank_2();
        return;
    }
    if ($page_count == 2) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count == 3) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            return;
        }
        if ($page_num == 3) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count == 4) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(2, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "尾页");
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(3, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "尾页");
            return;
        }
        if ($page_num == 3) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(2, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page(4, "4");
            $make_page->to_page(4, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "尾页");
            return;
        }
        if ($page_num == 4) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(3, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count == 5) {
        if ($page_num == 1) {
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(2, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 2) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(3, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 3) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(2, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(4, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 4) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(3, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_this_page();
            $make_page->to_page(5, "5");
            $make_page->to_page(5, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page(5, "尾页");
            return;
        }
        if ($page_num == 5) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(4, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            return;
        }
    }
    if ($page_count > 5) {
        if ($page_num == $page_count) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page(($page_num - 1), "上页");
            $make_page->to_page(($page_num - 4), ($page_num - 4));
            $make_page->to_page(($page_num - 3), ($page_num - 3));
            $make_page->to_page(($page_num - 2), ($page_num - 2));
            $make_page->to_page(($page_num - 1), ($page_num - 1));
            $make_page->to_this_page();
            $make_page->to_page_blank_1();
            $make_page->to_page_blank_2();
            $make_page->page_num_input($page_count);
            return;
        }
        if ($page_num == ($page_count - 1)) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page(($page_num - 1), "上页");
            $make_page->to_page(($page_num - 3), ($page_num - 3));
            $make_page->to_page(($page_num - 2), ($page_num - 2));
            $make_page->to_page(($page_num - 1), ($page_num - 1));
            $make_page->to_this_page();
            $make_page->to_page(($page_count), ($page_count));
            $make_page->to_page($page_count, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if ($page_num == ($page_count - 2)) {
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page(($page_num - 1), "上页");
            $make_page->to_page(($page_num - 2), ($page_num - 2));
            $make_page->to_page(($page_num - 1), ($page_num - 1));
            $make_page->to_this_page();
            $make_page->to_page(($page_num + 1), ($page_num + 1));
            $make_page->to_page(($page_num + 2), ($page_num + 2));
            $make_page->to_page($page_num + 1, "下页");
            $make_page->to_page_blank_1();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if($page_num==1){
            $make_page->to_page_blank_2();
            $make_page->to_page_blank_1();
            $make_page->to_this_page();
            $make_page->to_page(2, "2");
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(2, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if($page_num==2){
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(1, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_this_page();
            $make_page->to_page(3, "3");
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(3, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }
        if($page_num==3){
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank_1();
            $make_page->to_page(2, "上页");
            $make_page->to_page(1, "1");
            $make_page->to_page(2, "2");
            $make_page->to_this_page();
            $make_page->to_page(4, "4");
            $make_page->to_page(5, "5");
            $make_page->to_page(4, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
            return;
        }else{
            $make_page->to_page(1, "首页");
            $make_page->to_page_blank();
            $make_page->to_page($page_num-1, "上页");
            $make_page->to_page($page_num-2, $page_num-2);
            $make_page->to_page($page_num-1, $page_num-1);
            $make_page->to_this_page();
            $make_page->to_page($page_num+1, $page_num+1);
            $make_page->to_page($page_num+2, $page_num+2);
            $make_page->to_page($page_num+1, "下页");
            $make_page->to_page_blank();
            $make_page->to_page($page_count, "尾页");
            $make_page->page_num_input($page_count);
        }
    }
}
//function oneReplyPage($floor,$reply_page_to,$show){
//    echo "<div id='reply_navigator_'".$floor."_".$reply_page_to." class=\"reply_navigator_div\" onclick=\"getXML(myreq".$floor.",".$floor.",".$reply_page_to.")\">".$show."</div>";
//
//}
//function oneReplyPagethis($floor,$reply_page_to,$show){
//    echo "<div id='reply_navigator_'".$floor."_".$reply_page_to." class=\"reply_navigator_this_div\" onclick=\"getXML(myreq".$floor.",".$floor.",".$reply_page_to.")\">".$reply_page_to."</div>";
//}
class makeReply {
    public $floor_index;
    public $rep_page_num;
    function __construct($floor,$rep_page_num){
        $this->floor_index=$floor;
        $this->rep_page_num=$rep_page_num;
    }
    function  toReply($rep_page_to){
        echo "<div id='reply_navigator_".$this->floor_index."_".$rep_page_to."' class=\"reply_navigator_div\" onclick=\"getXML(myreq".$this->floor_index.",".$this->floor_index.",".$rep_page_to.")\"></div>";
    }
    function toReplyThis(){
        echo "<div id='reply_navigator_".$this->floor_index."_".$this->rep_page_num."' class=\"reply_navigator_div_this\" onclick=\"getXML(myreq".$this->floor_index.",".$this->floor_index.",".$this->rep_page_num.")\">".$this->rep_page_num."</div>";
    }
    function replyBlank(){
        echo "<div class='reply_navigator_div_blank'>.....</div>";
    }
}
function replyPageNavigatorDisplay($floor,$rep_page_num,$rep_page_count){
    $oneReply=new makeReply($floor,$rep_page_num);
    if($rep_page_count==1){
        $oneReply->toReplyThis();
        return;
    }
    if($rep_page_count==2){
        if($rep_page_num==1){
            $oneReply->toReplyThis();
            $oneReply->toReply(2);
            return;
        }
        if($rep_page_num==2){
            $oneReply->toReply(1);
            $oneReply->toReplyThis();
            return;
        }
    }
    if($rep_page_count==3){
        if($rep_page_num==1){
            $oneReply->toReplyThis();
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            return;
        }
        if($rep_page_num==2){
            $oneReply->toReply(1,"1");
            $oneReply->toReplyThis();
            $oneReply->toReply(3,"3");
            return;
        }
        if($rep_page_num==3){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReplyThis();
            return;
        }
    }
    if($rep_page_count==4){
        if($rep_page_num==1){
            $oneReply->toReplyThis();
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            return;
        }
        if($rep_page_num==2){
            $oneReply->toReply(1,"1");
            $oneReply->toReplyThis();
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            return;
        }
        if($rep_page_num==3){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReplyThis();
            $oneReply->toReply(4,"4");
            return;
        }
        if($rep_page_num==4){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            $oneReply->toReplyThis();
            return;
        }

    }
    if($rep_page_count==5){
        if($rep_page_num==1){
            $oneReply->toReplyThis();
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            $oneReply->toReply(5,"5");
            return;
        }
        if($rep_page_num==2){
            $oneReply->toReply(1,"1");
            $oneReply->toReplyThis();
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            $oneReply->toReply(5,"5");
            return;
        }
        if($rep_page_num==3){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReplyThis();
            $oneReply->toReply(4,"4");
            $oneReply->toReply(5,"5");
            return;
        }
        if($rep_page_num==4){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            $oneReply->toReplyThis();
            $oneReply->toReply(5,"5");
            return;
        }
        if($rep_page_num==5){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            $oneReply->toReplyThis();
            return;
        }

    }
    if($rep_page_count>5){
        if($rep_page_num==$rep_page_count){
            $oneReply->toReply(1,"1");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count-4,$rep_page_count-4);
            $oneReply->toReply($rep_page_count-3,$rep_page_count-3);
            $oneReply->toReply($rep_page_count-2,$rep_page_count-2);
            $oneReply->toReply($rep_page_count-1,$rep_page_count-1);
            $oneReply->toReplyThis();
            return;
        }
        if($rep_page_num==$rep_page_count-1){
            $oneReply->toReply(1,"1");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count-3,$rep_page_count-3);
            $oneReply->toReply($rep_page_count-2,$rep_page_count-2);
            $oneReply->toReply($rep_page_count-1,$rep_page_count-1);
            $oneReply->toReplyThis();
            $oneReply->toReply($rep_page_count,$rep_page_count);
            return;
        }
        if($rep_page_num==$rep_page_count-2){
            $oneReply->toReply(1,"1");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count-2,$rep_page_count-2);
            $oneReply->toReply($rep_page_count-1,$rep_page_count-1);
            $oneReply->toReplyThis();
            $oneReply->toReply($rep_page_count+1,$rep_page_count+1);
            $oneReply->toReply($rep_page_count+2,$rep_page_count+2);
            return;
        }
        if($rep_page_num==1){
            $oneReply->toReplyThis();
            $oneReply->toReply(2,"2");
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            $oneReply->toReply(5,"5");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count,$rep_page_count);
            return;
        }
        if($rep_page_num==2){
            $oneReply->toReply(1,"1");
            $oneReply->toReplyThis();
            $oneReply->toReply(3,"3");
            $oneReply->toReply(4,"4");
            $oneReply->toReply(5,"5");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count,$rep_page_count);
            return;
        }
        if($rep_page_num==3){
            $oneReply->toReply(1,"1");
            $oneReply->toReply(2,"2");
            $oneReply->toReplyThis();
            $oneReply->toReply(4,"4");
            $oneReply->toReply(5,"5");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count,$rep_page_count);
            return;
        }else{
            $oneReply->toReply(1,"1");
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_num-1,$rep_page_num-1);
            $oneReply->toReply($rep_page_num-2,$rep_page_num-2);
            $oneReply->toReplyThis();
            $oneReply->toReply($rep_page_num+1,$rep_page_num+1);
            $oneReply->toReply($rep_page_num+2,$rep_page_num+2);
            $oneReply->replyBlank();
            $oneReply->toReply($rep_page_count,$rep_page_count);
            return;
        }
    }
}
function makeReplyDiv($floor,$reply_page_count){
    for($i=1;$i!=$reply_page_count+1;$i++){
        echo "<div id='reply_navigator_".$floor."_".$i."' class=\"reply_navigator_div\" onclick=\"getXML(myreq".$floor.",".$floor.",".$i.",".$reply_page_count.")\">".$i."</div>";
        if($i==2){
            echo "<div class=\"reply_navigator_blank\"></div>";
        }
        if($reply_page_count>5){
            if($i=$reply_page_count-2){
                echo "<div class=\"reply_navigator_blank\"></div>";
            }
        }
    }
}
function pictureCodeReplace($str){
    preg_match_all("/\[img\](?<host>[\w\/\:\.\(\)]*)\[\/img\]/",$str,$match);
    for($i=0;$i!=count($match["host"]);$i++){
        $par="[img]".$match["host"][$i]."[/img]";
        $rep="<img src=\"".$match["host"][$i]."\">";
        $str=str_replace($par,$rep,$str);
    }
    return $str;
}