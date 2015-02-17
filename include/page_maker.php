<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/1/20
 * Time: 8:39
 */

class page_maker{
    public $css_src;
    public $js_src;
    public $login_page_location;
    public $register_page_location;
    public $sign_out_page_location;
    public $user_main_page;
    public $forum_page;
    public $back_page;
    public $logo_img_location;
    public $name;
    public $priority;
    public $UID;
    public $suf;
    public $pre;

    function __construct($code1,$code2,$code3,$directory_level){
        $this->back_page=$code1."_".$code2."_".$code3;
        switch ($directory_level){
            case 0:
                $this->pre="./";
                break;
            case 1:
                $this->pre="../";
                break;
            case 2:
                $this->pre="../../";
                break;
            case 3:
                $this->pre="../../../";
                break;
            case 4:
                $this->pre="../../../../";
                break;
            default:
                $this->pre="XXXXXXX";
        }
        $this->css_src=$this->pre."include/page_maker.css";
        $this->js_src=$this->pre."include/page_maker.js";
        $this->login_page_location=$this->pre."page_redirect/login_check.php";
        $this->sign_out_page_location=$this->pre."page_redirect/sign_out.php";
        $this->register_page_location=$this->pre."page_redirect/user_register.php";
        $this->user_main_page=$this->pre."Users/User_main.php";
        $this->forum_page=$this->pre."forums/index.php";
        $this->logo_img_location=$this->pre."media/images/system/logo/head_logo.png";
        $this->suf="?page_code=".$code1."_".$code2."_".$code3;
        if(isset($_SESSION["user_name"])){
            $arr=explode(":",$_SESSION["user_name"]);
            $this->name=$arr[3];
            $this->priority=$arr[2];
            $this->UID=$arr[1];
//            switch($this->priority){
//                case 1:
//                    $this->user_main_page=$pre."Users/Admin/".$this->UID.".php";
//                    break;
//                case 6:
//                    $this->user_main_page=$pre."Users/VIP_users/".$this->UID.".php";
//                    break;
//                case 9:
//                    $this->user_main_page=$pre."Users/common_users/".$this->UID.".php";
//                    break;
//            }
        }
    }
    public function makeLoginPage(){
        if(!isset($_SESSION["user_name"])){?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->css_src;?>">
            <div id="login_page_container">
                <div id="login_page_back"></div>
                <div id="login_page">
                    <div id="login_page_hide"></div>
                    <div id="login_1">
                        <form action="<?php echo $this->login_page_location.$this->suf ;?>?page_code=<?php echo $this->back_page; ?>" method="post">
                            <div id="login_account_line">
                                <div id="login_account">
                                    <label id="login_account_label" for="login_account_input"><strong>帐号</strong></label>
                                    <input id="login_account_input" type="text" name="login_user_name">
                                </div>
                            </div>
                            <div id="login_password_line">
                                <div id="login_password">
                                    <label id="login_password_label" for="login_password_input"><strong>密码</strong></label>
                                    <input id="login_password_input" type="password" name="login_user_password">
                                </div>
                            </div>
                            <button id="login_btn" class="login_btn_1"><strong>登&nbsp;录</strong></button>
                        </form>
                    </div>
                    <div id="login_2">
                        <form action="<?php echo $this->register_page_location.$this->suf ;?>?page_code=<?php echo $this->back_page; ?>" method="post">
                            <div id="register_account_line">
                                <div id="register_account">
                                    <label id="register_account_label" for="register_account_input"><strong>帐号</strong></label>
                                    <input id="register_account_input" type="text" name="register_user_name">
                                </div>
                            </div>
                            <div id="register_password_line">
                                <div id="register_password">
                                    <label id="register_password_label" for="register_password_input"><strong>密码</strong></label>
                                    <input id="register_password_input" type="password" name="register_user_password">
                                </div>
                            </div>
                            <div id="register_password_line_2">
                                <div id="register_password_2">
                                    <label id="register_password_label_2" for="register_password_input_2"><strong>密码</strong></label>
                                    <input id="register_password_input_2" type="password" name="register_user_password2">
                                </div>
                            </div>
                            <button id="register_btn" class="register_btn_1"><strong>注&nbsp;册</strong></button>
                        </form>
                    </div>
                    <!--            <div id="icon_back"></div>-->
                    <div id="login_3" class="login_3_1"><strong>登&nbsp;录</strong></div>
                    <div id="login_4" class="login_4_1"><strong>注&nbsp;册</strong></div>
                </div>
            </div>
            <script src=<?php echo $this->js_src;?>></script>
        <?php }
    }
    public function makeHeadPage(){?>
        <div id="head">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->css_src;?>">
            <div id="logo_line">
                <img id="logo" src="<?php echo $this->logo_img_location; ?>">
            </div>
            <div id="head_welcome_note_line">
                <?php if(isset($_SESSION["user_name"])){ ?>
                <div id="user_note"><a href="<?php echo $this->user_main_page ;?>"><?php echo $this->name;?></a></div>
            <?php }else{ ?>
                <div id="head_nologin_info">您还未登录。</div>
            <?php } ?>
            </div>
            <?php
            if(isset($_SESSION["user_name"])){?>
                <div id="head_login_btn_line">
                    <button id="head_logout_btn" class="head_logout_btn_1">退出</button>
                </div>
            <?php
            }else{ ?>
                <div id="head_login_btn_line">
                    <button id="head_login_btn" class="head_login_btn_1">登录</button>
                </div>

        <?php
        }  ?>
        </div>
        <?php
        if(isset($_SESSION["user_name"])){?>
            <script>
                $("#head_logout_btn").hover(function(){
                    $(this).attr("class","head_logout_btn_2")
                },function(){
                    $(this).attr("class","head_logout_btn_1")
                });
                $("#head_logout_btn").click(
                    function(){
                        var conf=confirm("确定退出么？");
                        if(conf==true){
                            window.location.href = "<?php echo $this->sign_out_page_location.$this->suf;?>";
                        }
                    }
                )
            </script>
        <?php
        }else{?>
            <script>
                $("#head_login_btn").hover(function(){
                    $("#head_login_btn").attr("class","head_login_btn_2")
                },function(){
                    $("#head_login_btn").attr("class","head_login_btn_1")
                })
                $("#head_login_btn").click(function(){
                    showLoginPage();
                })

            </script>
        <?php
        }
    }
    public  function makeNavigatorPage($sub_num,$code1=10,$code2=10,$code3=10,$code4=10,$code5=10,$code6=10,$code7=10,$code8=10){
        $sub_width=floor((999-$sub_num)/$sub_num-31);

        ?>
        <div id="navigator">
            <?php for($i=1;$i!=$sub_num+1;$i++){
            $code="code".strval($i);
            switch($$code){
                case 1:
                    echo "<a href=\"".$this->user_main_page."\"><label id=\"user_setting\" class=\"navigator_sub_block\">用户设置</label></a>";
                    break;
                case 2:
                    echo "<a href=\"".$this->forum_page."\"><label id=\"forum\" class=\"navigator_sub_block\">论坛</label></a>";
                    break;
                case 9:
                    echo "<a href='#' ><label id='test' class=\"navigator_sub_block\">测试</label></a>";
                    break;
                case 10:
                    break;
            }
        } ?>
        </div>
        <script>
            $(".navigator_sub_block").css("width","<?php echo $sub_width; ?>px")
            $("#navigator").buttonset();
        </script>
    <?php }
}