<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/Admin/css/base.css" />
	<link rel="stylesheet" href="/Public/Admin/css/login.css?1" />
	<title>移动办公自动化系统</title>
</head>
<body>
<form action="/index.php/Admin/Login/checkVerify" method="post">
	<div id="container">
		<div id="bd">
			<div class="login1">
            	<div class="login-top"><h1 class="logo"></h1></div>
                <div class="login-input">
                	<p class="user ue-clear">
                    	<label>用户名</label>
                        <input type="text" id="username" name="username"/>
                    </p>
                    <p class="password ue-clear">
                    	<label>密&nbsp;&nbsp;&nbsp;码</label>
                        <input type="password" id="password" name="password" />
                    </p>
                    <p class="yzm ue-clear">
                    	<label>验证码</label>
                        <input type="text" name="code" id="code"/>
                        <cite><img id="verify"  width="80" height="40" src="/index.php/Admin/Login/verify"></cite>
                    </p>
                </div>
                <div class="login-btn ue-clear">
                	<a href="javascript:;" id="login" class="btn">登录</a>
                    <div class="remember ue-clear">
                    	<input type="checkbox" name="remember" id="remember" />
                        <em></em>
                        <label for="remember">记住密码</label>
                    </div>
                </div>
            </div>
		</div>
	</div>
</form>
    <div id="ft">CopyRight&nbsp;2014&nbsp;&nbsp;版权所有&nbsp;&nbsp;uimaker.com专注于ui设计&nbsp;&nbsp;苏ICP备09003079号</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript">

    //给登录页面绑定回车提交事件
    $(document).keyup(function(e){
        if(e.keyCode==13){
            //表单验证
            //获取要验证的字段
            var username=$('#username').val();
            var password=$('#password').val();
            var code=$('#code').val();

            //验证表单
            if($.trim(code)==""){
                alert("验证码不能为空");
                return false;
            }

            if(code.length!=3){
                alert("验证码必须为3位");
                return false;
            }

            if($.trim(username)=="" || $.trim(password)==""){
                alert("用户名或者密码不能为空");
                return false;
            }

            $("form").submit();
        }

    })

    //给表单提交绑定单击事件
    $("#login").click(function(){
        //表单验证
        //获取要验证的字段
        var username=$('#username').val();
        var password=$('#password').val();
        var code=$('#code').val();

        //验证表单
        if($.trim(code)==""){
            alert("验证码不能为空");
            return false;
        }

        if(code.length!=3){
            alert("验证码必须为3位");
            return false;
        }

        if($.trim(username)=="" || $.trim(password)==""){
            alert("用户名或者密码不能为空");
            return false;
        }

        $("form").submit();

    });

    $("#verify").click(function(){
        $(this).attr("src","/index.php/Admin/Login/verify/"+new Date().getTime());
    })

var height = $(window).height();
$('#container').height(height);
$("#bd").css("padding-top",height/2 - $("#bd").height()/2);

$(window).resize(function(){
	var height = $(window).height();
	$("#bd").css("padding-top",$(window).height()/2 - $("#bd").height()/2);
	$("#container").height(height);
	
});

$('#remember').focus(function(){
   $(this).blur();
});

$('#remember').click(function(e) {
	checkRemember($(this));
});

function checkRemember($this){
	if(!-[1,]){
		 if($this.prop("checked")){
			$this.parent().addClass('checked');
		}else{
			$this.parent().removeClass('checked');
		}
	}
}
</script>
</html>