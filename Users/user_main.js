/**
 * Created by Administrator on 2015/2/5.
 */
function checkUserNameInput(){
    $("#input_user_name_note").css("display","none");
    $("#input_user_name").css("color","#000000");
    $("#input_user_name_info").css("color","#000000");
    var user_name_input=$("#input_user_name").val();
    var byte_length=0;
    var one;
    for(var i=0;i!=user_name_input.length;i++){
        one=user_name_input.charAt(i);
        if(/\w/.test(one)){
            byte_length++;
        }else{
            if(/[\u4e00-\u9fa5]/.test(one)){
                byte_length+=2
            }else{
                byte_length+=100;
            }
        }
    }
    if(byte_length>100){
        //$("#btn_user_info_submit").attr("disabled","disabled");
        user_name_check=0;
        checkSubmitEnable();
        $("#input_user_name_info").text("不能包含特殊字符");
    }else{
        if(byte_length>14){
            //$("#btn_user_info_submit").attr("disabled","disabled");
            user_name_check=0;
            checkSubmitEnable();
            $("#input_user_name_info").text("用户名过长");
        }else{
            if(byte_length==0){
                //$("#btn_user_info_submit").attr("disabled","disabled");
                user_name_check=1;
                checkSubmitEnable();
                $("#input_user_name_note").css("display","block");
                $("#input_user_name").css("color","grey");
                $("#input_user_name_info").text("");
            }else{
                if(byte_length<4){
                    //$("#btn_user_info_submit").attr("disabled","disabled");
                    user_name_check=0;
                    checkSubmitEnable();
                    $("#input_user_name_info").text("用户名太短");
                }else{
                        $.ajax({
                            url:"../page_redirect/ajax/user_name_duplicate_check.php",
                            dataType:"json",
                            data:{
                                user_name:$("#input_user_name").val()
                            },
                            type:"POST",
                            success:function(data){
                                if(data.call_back===0){
                                    user_name_check=1;
                                    checkSubmitEnable();
                                    $("#input_user_name_info").text("");
                                }else{
                                    user_name_check=0;
                                    checkSubmitEnable();
                                    $("#input_user_name_info").text("用户名已被占用，请更换。");
                                }
                            },
                            error: function (data, status, e)
                            {
                                alert(e);
                                alert(data.call_back);
                            }
                        })
                }
            }
        }
    }
}
function checkUserEmailInput(){
    var user_email=$("#input_user_email").val();
    $("#input_user_email_note").css("display","none");
    if(/^[a-zA-Z0-9][a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+[a-zA-Z0-9]$/.test(user_email)){
        $.ajax({
            url:"../page_redirect/ajax/user_email_duplicate_check.php",
            dataType:"json",
            data:{
                user_email:$("#input_user_email").val()
            },
            type:"POST",
            success:function(data){
                if(data.call_back===0){
                    user_email_check=1;
                    checkSubmitEnable2();
                    $("#input_user_email_info").text("");
                }else{
                    user_email_check=0;
                    checkSubmitEnable2();
                    $("#input_user_email_info").text("该邮箱已被使用重复，请更换。");
                }
            },
            error: function (data, status, e)
            {
                alert(e);
                alert(data.call_back);
            }
        })
    }else{
        if(user_email==""){
            $("#input_user_email_note").css("display","block");
            $("#input_user_email_info").text("");
            user_email_check=1;
            checkSubmitEnable2();
        }else{
            $("#input_user_email_info").text("邮件地址不合规范");
            $("#btn_user_info_submit").attr("disabled","disabled");
            user_email_check=0;
            checkSubmitEnable2();
        }
    }
}

function checkUserQQInput(){
    var user_qq=$("#input_user_qq").val();
    $("#input_user_qq_note").css("display","none");
    if(/^[1-9][0-9]{3,11}$/.test(user_qq)){
        $.ajax({
            url:"../page_redirect/ajax/user_qq_duplicate_check.php",
            dataType:"json",
            data:{
                user_qq:$("#input_user_qq").val()
            },
            type:"POST",
            success:function(data){
                if(data.call_back===0){
                    user_qq_check=1;
                    checkSubmitEnable2();
                    $("#input_user_qq_info").text("");
                }else{
                    user_qq_check=0;
                    checkSubmitEnable2();
                    $("#input_user_qq_info").text("该QQ号已被使用重复，请更换。");
                }
            },
            error: function (data, status, e)
            {
                alert(e);
                alert(data.call_back);
            }
        })
    }else{
        if(user_qq==""){
            $("#input_user_qq_note").css("display","block");
            $("#input_user_qq_info").text("");
            user_qq_check=1;
            checkSubmitEnable2();
        }else{
            $("#input_user_qq_info").text("qq号只能为数字");
            $("#btn_user_info_submit").attr("disabled","disabled");
            user_qq_check=0;
            checkSubmitEnable2();
        }
    }
}

function portraitUpload()
{
    //console.log(portrait_tmp);
    //$("#loading")


    $.ajaxFileUpload
    (
        {
            url:'../page_redirect/ajax/user_portrait.php',
            secureuri:false,
            fileElementId:'user_portrait_original',
            dataType: 'json',
			data:{
                UID:UID,
                portrait_tmp:portrait_tmp
            },
            type:"POST",
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }else
                    {

                        $("#confirm_user_portrait_line").css("display","none");
                        $("#btn_confirm_portrait").css("display","block");
                        $("#portrait_select_area").css("display","block");
                        $("#select_info").text("选取头像范围");
                        $("#fake_button_2").css("display","block");
                        $("#img_user_portrait_original").attr("src","");
                        $("#img_user_portrait_original").attr("src",data.tmp);
                        var height=parseInt(data.height)+60;
                        portrait_tmp=data.tmp;
                        portrait_file_type=data.type;
                        $("#input_user_portrait_line").css("height",height+"px");
                        $("#portrait_select_area").css("height",data.height+"px");
                        $("#select_window_area").css("height",data.height+"px");
                        $("#select_window").css({
                            "width":"100px",
                            "height":"100px",
                            "top":"0px",
                            "left":"0px"
                        })
                        $("#right_cover").css({
                            "width":"700px",
                            "height":"100px",
                            "opacity":"0.5",
                            "top":"0px",
                            "right":"0px"
                        });
                        $("#bottom_cover").css({
                            "width":"800px",
                            "height":data.height-100+"px",
                            "opacity":"0.5"
                        });
                        $("#top_cover").css({
                            "width":"800px",
                            "height":"0px",
                            "opacity":"0.5"
                        });
                        $("#left_cover").css({
                            "width":"0px",
                            "height":"100px",
                            "opacity":"0.5",
                            "top":"0px"
                        });
                        cover_left=0;
                        cover_right=0;
                        cover_top=0;
                        cover_bottom=0;
                        cover_width=100;
                        cover_height=100;
                        img_height=data.height;
                        var container_3_height=parseInt(img_height)+200;
                        var fake_button_2_top=parseInt(img_height)+150;
                        $("#container_3").css("height",container_3_height+"px");
                        $("#fake_button_2").css("top",fake_button_2_top+"px");
                        $("#btn_confirm_portrait").css("top",fake_button_2_top+"px");
                        //$("#select_window").resizable({
                        //    minHeight:100,
                        //    minWidth:100,
                        //    maxWidth:1000,
                        //    aspectRatio:1/1,
                        //    containment:"#select_window_area"
                        //
                        //})
                        //alert(data.tmp+":"+data.type);
                        //$("#user_portrait_original").val(input_value);
                        $("#fake_portrait_input").val(Math.random(999));
                        //console.log(input_value+":"+$("#user_portrait_original").val());
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    );

    return false;

}
function portraitConfirm(data){
    //$("#loading")
    //    .ajaxStart(function(){
    //        $(this).show();
    //    })
    //    .ajaxComplete(function(){
    //        $(this).hide();
    //    });
    $.ajax(
        {
            url:'../page_redirect/ajax/portrait_confirm.php',
            dataType: 'json',
            data:{
                src_x:cover_left,
                src_y:cover_top,
                src_width:cover_width,
                src_height:cover_height,
                portrait_tmp:portrait_tmp,
                UID:UID,
                type:portrait_file_type
            },
            type:"POST",
            success:function(data){
                if(data.status=="OK"){
                    $("#portrait_select_area").css("display","none");
                    $("#btn_confirm_portrait").css("display","none");
                    $("#fake_button_2").css("display","none");
                    $("#confirm_user_portrait_line").css("display","block");
                    $("#confirm_user_portrait").attr("src","");
                    $("#confirm_user_portrait").attr("src","../media/images/portrait/"+UID+"/"+data.rand_num+"_L."+portrait_file_type)
                    $("#select_info").text("已选定");
                }
            },
            error: function (data, status, e)
            {
                alert(e+":"+data);
            }
        }
    );
    return false;
}

function password_line_display(){
    if($("#password_change_checkbox").is(":checked")){
        $("#user_password_line").css("display","block");
        $("#user_password_line2").css("display","block");
        $("#user_password_line0").css("display","block");
    }else{
        $("#user_password_line").css("display","none");
        $("#user_password_line2").css("display","none");
        $("#user_password_line0").css("display","none");
        $("#user_password0").val("");
        $("#user_password").val("");
        $("#user_password2").val("");
        $("#user_password_info").text("");
        $("#user_password2_info").text("");
        user_password_check=1;
        checkSubmitEnable();
    }
}
function checkPasswordType(){
    var regExp=/^[A-Z][a-zA-Z0-9\#\~\!\@\-\%\^\&\*\.,:;\\\$\(\)\"\[\]\{\}\<\>\?\/\\\\]{5,21}$/;
    var value=$("#user_password").val();
    if(value==""){
        $("#user_password_info").text("");
        user_password_check=1;
        checkSubmitEnable();
        return;
    }
    if(!regExp.test(value)){
           $("#user_password_info").text("密码格式不合规。");
           user_password_check=0;
           checkSubmitEnable();
    }else{
        $("#user_password_info").text("");
        if($("#user_password").val()==$("#user_password2").val()) {
            $("#user_password2_info").text("");
            user_password_check = 1;
            checkSubmitEnable();
        }else{
            $("#user_password2_info").text("两次密码输入不一致！");
            user_password_check=0;
            checkSubmitEnable()
        }
   }
}
function checkPasswordDuplication(){
    if($("#user_password").val()==$("#user_password2").val()){
        $("#user_password2_info").text("");
        user_password_check=1;
        checkSubmitEnable()
    }else{
        $("#user_password2_info").text("两次密码输入不一致！");
        user_password_check=0;
        checkSubmitEnable()
    }
}
function checkSubmitEnable(){
    if(user_name_check==1&&user_password_check==1){
        $("#btn_user_info_submit").attr("disabled",false)
    }else{
        $("#btn_user_info_submit").attr("disabled","disabled")
    }
}
function checkSubmitEnable2(){
    if(user_email_check==1&&user_qq_check==1){
        $("#btn_user_info_submit2").attr("disabled",false)
    }else{
        $("#btn_user_info_submit2").attr("disabled","disabled")
    }
}