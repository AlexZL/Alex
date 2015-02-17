/**
 * Created by Administrator on 2009/8/20.
 */
var server_ip_addr="http://localhost/";
var Tween = {
    Linear: function(t,b,c,d){ return c*t/d + b; },
    Quad: {
        easeIn: function(t,b,c,d){
            return c*(t/=d)*t + b;
        },
        easeOut: function(t,b,c,d){
            return -c *(t/=d)*(t-2) + b;
        },
        easeInOut: function(t,b,c,d){
            if ((t/=d/2) < 1) return c/2*t*t + b;
            return -c/2 * ((--t)*(t-2) - 1) + b;
        }
    },
    Cubic: {
        easeIn: function(t,b,c,d){
            return c*(t/=d)*t*t + b;
        },
        easeOut: function(t,b,c,d){
            return c*((t=t/d-1)*t*t + 1) + b;
        },
        easeInOut: function(t,b,c,d){
            if ((t/=d/2) < 1) return c/2*t*t*t + b;
            return c/2*((t-=2)*t*t + 2) + b;
        }
    },
    Quart: {
        easeIn: function(t,b,c,d){
            return c*(t/=d)*t*t*t + b;
        },
        easeOut: function(t,b,c,d){
            return -c * ((t=t/d-1)*t*t*t - 1) + b;
        },
        easeInOut: function(t,b,c,d){
            if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
            return -c/2 * ((t-=2)*t*t*t - 2) + b;
        }
    },
    Quint: {
        easeIn: function(t,b,c,d){
            return c*(t/=d)*t*t*t*t + b;
        },
        easeOut: function(t,b,c,d){
            return c*((t=t/d-1)*t*t*t*t + 1) + b;
        },
        easeInOut: function(t,b,c,d){
            if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
            return c/2*((t-=2)*t*t*t*t + 2) + b;
        }
    },
    Sine: {
        easeIn: function(t,b,c,d){
            return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
        },
        easeOut: function(t,b,c,d){
            return c * Math.sin(t/d * (Math.PI/2)) + b;
        },
        easeInOut: function(t,b,c,d){
            return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
        }
    },
    Expo: {
        easeIn: function(t,b,c,d){
            return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
        },
        easeOut: function(t,b,c,d){
            return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
        },
        easeInOut: function(t,b,c,d){
            if (t==0) return b;
            if (t==d) return b+c;
            if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
            return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
        }
    },
    Circ: {
        easeIn: function(t,b,c,d){
            return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
        },
        easeOut: function(t,b,c,d){
            return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
        },
        easeInOut: function(t,b,c,d){
            if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
            return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
        }
    },
    Elastic: {
        easeIn: function(t,b,c,d,a,p){
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (!a || a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        },
        easeOut: function(t,b,c,d,a,p){
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (!a || a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return (a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b);
        },
        easeInOut: function(t,b,c,d,a,p){
            if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
            if (!a || a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
            return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
        }
    },
    Back: {
        easeIn: function(t,b,c,d,s){
            if (s == undefined) s = 1.70158;
            return c*(t/=d)*t*((s+1)*t - s) + b;
        },
        easeOut: function(t,b,c,d,s){
            if (s == undefined) s = 1.70158;
            return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
        },
        easeInOut: function(t,b,c,d,s){
            if (s == undefined) s = 1.70158;
            if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
            return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
        }
    },
    Bounce: {
        easeIn: function(t,b,c,d){
            return c - Tween.Bounce.easeOut(d-t, 0, c, d) + b;
        },
        easeOut: function(t,b,c,d){
            if ((t/=d) < (1/2.75)) {
                return c*(7.5625*t*t) + b;
            } else if (t < (2/2.75)) {
                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
            } else if (t < (2.5/2.75)) {
                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
            } else {
                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
            }
        },
        easeInOut: function(t,b,c,d){
            if (t < d/2) return Tween.Bounce.easeIn(t*2, 0, c, d) * .5 + b;
            else return Tween.Bounce.easeOut(t*2-d, 0, c, d) * .5 + c*.5 + b;
        }
    }
};
var foot_t=0;
function foot2MoveToShow(){
    var height=Math.round(Tween.Linear(foot_t,50,250,15));
        if(foot_t!=15){
            $("#forum_content_input")[0].focus();
            $("#foot_2").css("display","block");
            $("#foot_1").css("display","none");
            $("#foot_2").css("height",height+"px");
            foot_t++;
            setTimeout("foot2MoveToShow()",20);
        }else{
            $("#foot_2").css("height",height+"px");
            foot_t=0;
        }
}
function foot2MoveToHidden(){
    var height=Math.round(Tween.Linear(foot_t,300,-250,15));
    if(foot_t!=15){
        $("#foot_1").css("display","block");
        $("#foot_2").css("display","none");
        $("#foot_1").css("height",height+"px");
        foot_t++;
        setTimeout("foot2MoveToHidden()",20);
    }else{
        $("#foot_1").css("height",height+"px");
        foot_t=0;
    }
}
function footCome(){
    var height=Math.round(Tween.Linear(foot_t,20,30,15));
    var width=Math.round(Tween.Linear(foot_t,20,980,15));
    $("#foot_3").css("display","none");
    if(foot_t!=15){
        $("#foot_1").css({
            "display":"block",
            "height":height+"px",
            "width":width
        });
        $("foot_3").css("display","none");
        foot_t++;
        setTimeout("footCome()",20);
    }else{
        $("#foot_1").css({
            "display":"block",
            "height":height+"px",
            "width":width
        });
        foot_t=0;
    }
}
function footBack(){
    var height=Math.round(Tween.Linear(foot_t,50,-30,15));
    var width=Math.round(Tween.Linear(foot_t,1000,-980,15));
    if(foot_t!=15){
        $("#foot_1").css({
            "display":"block",
            "height":height+"px",
            "width":width+"px"
        });
        $("foot_3").css("display","none");
        foot_t++;
        setTimeout("footBack()",20);
    }else{
        $("#foot_1").css({
            "height":height+"px",
            "width":width+"px",
            "display":"none"
        });
        $("#foot_3").css("display","block");
        foot_t=0;
    }
}
function foot4MoveToShow(){
    var height=Math.round(Tween.Linear(foot_t,50,250,15));
    if(foot_t!=15){
        $("#foot_4").css("display","block");
        $("#foot_1").css("display","none");
        $("#foot_4").css("height",height+"px");
        foot_t++;
        setTimeout("foot4MoveToShow()",20);
    }else{
        $("#foot_4").css("height",height+"px");
        foot_t=0;
    }
}
function foot4MoveToHidden(){
    var height=Math.round(Tween.Linear(foot_t,300,-250,15));
    if(foot_t!=15){
        $("#foot_1").css("display","block");
        $("#foot_4").css("display","none");
        $("#foot_1").css("height",height+"px");
        foot_t++;
        setTimeout("foot4MoveToHidden()",20);
    }else{
        $("#foot_1").css("height",height+"px");
        foot_t=0;
    }
}
function getXMLHTTPRequest(){
    var reg=false;
    try{
        reg = new XMLHttpRequest();
    }catch (e){
        try{
            reg=new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e){
            try {
                reg=new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){
                reg=false;
            }
        }
    }
    return reg;
}
function hideReplyMethod(floor,reply){
    $("#reply_input_back_"+floor+"_"+reply).css("display","none")
}
function replierMethod(floor,reply){
    var ID=$("#replier_ID_"+floor+"_"+reply).text();
    var name=$("#replier_"+floor+"_"+reply).text();
    $("#reply_input_replied_ID_"+floor+"_"+reply).val(ID);
    $("#reply_input_replied_"+floor+"_"+reply).val(name);
    $("#reply_input_note_"+floor+"_"+reply).text("回复:"+name);
    $("#reply_input_back_"+floor+"_"+reply).css("display","block")
}
function repliedMethod(floor,reply){
    var ID=$("#replied_ID_"+floor+"_"+reply).text();
    var name=$("#replied_"+floor+"_"+reply).text();
    $("#reply_input_replied_ID_"+floor+"_"+reply).val(ID);
    $("#reply_input_replied_"+floor+"_"+reply).val(name);
    $("#reply_input_note_"+floor+"_"+reply).text("回复:"+name);
    $(".reply_input_back").css("display","none");
    $("#reply_input_back_"+floor+"_"+reply).css("display","block")
}
function myReply(floor){
    $("#my_reply_content_"+floor).css("display","block");
    $("#my_reply_input_content_"+floor).focus();
    $("#my_reply_btn_"+floor).css("display","none");
    $("#my_reply_btn_hide_"+floor).css("display","block");
}
function myReplyHide(floor){
    $("#my_reply_content_"+floor).css("display","none");
    $("#my_reply_input_content_"+floor).val("");
    $("#my_reply_btn_"+floor).css("display","block");
    $("#my_reply_btn_hide_"+floor).css("display","none");
}
function replyBtnToClass2(obj){
    $(obj).attr("class","reply_input_btn_2")
}
function replyBtnToClass1(obj){
    $(obj).attr("class","reply_input_btn")
}
function replyBtnToClass2_1(obj) {
    $(obj).attr("class", "reply_btn_k")
}
function replyBtnToClass2_2(obj) {
    $(obj).attr("class", "reply_btn_k_2")
}
function replyBtnToClass3_1(obj) {
    $(obj).attr("class", "reply_btn_j")
}
function replyBtnToClass3_2(obj) {
    $(obj).attr("class", "reply_btn_j_2")
}
function appendPicCode(obj){
    var str=$("#forum_content_input").val();
    var id=$(obj).attr("id");
    var arr=id.split("_");
    var dir=arr[0];
    var number=arr[1];
    var suffix=arr[2];
    str+="[img]http://localhost/Alex/media/images/biaoqing/"+dir+"/"+number+"."+suffix+"[/img]";
    $("#forum_content_input").val(str)
}
