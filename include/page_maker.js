/**
 * Created by Administrator on 2015/1/19.
 */
$("#login_btn").hover(function(){
    $(this).attr("class","login_btn_2")},
    function(){$(this).attr("class","login_btn_1")}
);
$("#register_btn").hover(function(){
    $(this).attr("class","login_btn_2")},
    function(){$(this).attr("class","login_btn_1")}
);
$("#login_3").click(function(){
    $("#login_1").css("display","block");
    $("#login_2").css("display","none");
    $("#login_4").attr("class","login_4_1");
    $("#login_3").attr("class","login_3_1");
    $("#login_account_input")[0].focus();
});
$("#login_4").click(function(){
    $("#login_2").css("display","block");
    $("#login_1").css("display","none");
    $("#login_4").attr("class","login_4_2");
    $("#login_3").attr("class","login_3_2");
    $("#register_account_input")[0].focus();
});
$("#login_page_hide").click(function(){hideLoginPage()});
function showLoginPage(){
    $("#login_page_container").css("display","block");
    $("#login_account_input")[0].focus();
}
function hideLoginPage(){
    $("#login_page_container").css("display","none");
}