<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	select {
		background: rgba(0, 0, 0, 0) ;
	    border: 1px solid #c5d6e0;
	    height: 28px;
	    outline: medium none;
	    padding: 0 8px;
	    width: 240px;
	}

    body form label.error{
        width:300px;
        color:#ff0000;
    }
	
</style>
</head>

<body>
<div class="title"><h2>职员信息登记</h2></div>
<form action="/index.php/Admin/User/edit" id="theform" method="post" enctype="multipart/form-data">
<div class="main">
    <input type="hidden" name="id" value="<?php echo ($data['id']); ?>">
    <p class="short-input ue-clear">
    	<label>登录名：</label>
        <input name="username"  type="text"  value="<?php echo ($data['username']); ?>" readonly/>
    </p>
	<p class="short-input ue-clear">
    	<label>真名：</label>
        <input name="truename" type="text" value="<?php echo ($data['truename']); ?>" />
    </p>
    <p class="short-input ue-clear">
        <label>头像：</label>
        <input name="photo" id="f" type="file" placeholder="头像" onchange="change()" />
    </p>
    <p style="display: inline">预览:</p >
    <p style="display: inline">
        <img id="preview" name="pic" src="<?php echo ((isset($data['photo1']) && ($data['photo1'] !== ""))?($data['photo1']):'/Uploads/Photo/default_photo/default_photo.jpg'); ?>" style="display: inline;margin-left: 22px;width:200px;"/>
        <input type="hidden" name="photo" value="<?php echo ($data['photo']); ?>">
    </p>
    <p class="short-input ue-clear">
        <label>密码：</label>
        <input id="updatepass" name="password" type="button" value="修改密码" />
    </p>
    <p class="short-input ue-clear password">
        <label>新密码：</label>
        <input name="newpassword" id="newpassword"  type="text"  />
    </p>
    <p class="short-input ue-clear password">
        <label>确认密码：</label>
        <input name="repassword" id="repassword" type="text"  />
    </p>

    <div class="short-input select ue-clear">
    	<label>所属部门：</label>
        <select name="dept_id">
            <?php if(is_array($depts)): $i = 0; $__LIST__ = $depts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['id'] == $data['dept_id']): ?><option selected value="<?php echo ($v['id']); ?>"><?php echo (str_repeat("&nbsp",$v['level']*3)); echo ($v['name']); ?></option>
                    <?php else: ?>
                    <option value="<?php echo ($v['id']); ?>"><?php echo (str_repeat("&nbsp",$v['level']*3)); echo ($v['name']); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
    <div class="short-input select ue-clear">
        <label>角色：</label>
        <select name="role_id">
            <?php if(is_array($roles)): $i = 0; $__LIST__ = $roles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if($r['id'] == $data['role_id']): ?><option selected value="<?php echo ($r['id']); ?>"><?php echo ($r['role_name']); ?></option>
                    <?php else: ?>
                    <option value="<?php echo ($r['id']); ?>"><?php echo ($r['role_name']); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>

        </select>
    </div>
	<p class="short-input ue-clear">
    	<label>性别：</label>
        <?php if($data['sex'] == 0): ?><input name="sex" type="radio" style="float:none;" value="0" checked='checked' />男
            <input name="sex" type="radio" style="float:none;" value="1" />女
            <?php else: ?>
            <input name="sex" type="radio" style="float:none;" value="0"  />男
            <input name="sex" type="radio" style="float:none;" value="1" checked='checked'/>女<?php endif; ?>
    </p>
	<p class="short-input ue-clear">
    	<label>生日：</label>
        <input id="birthday" name="birthday" type="text" value="<?php echo ($data['birthday']); ?>" />
    </p>
	<p class="short-input ue-clear">
    	<label>联系电话：</label>
        <input type="text" name="tel" value="<?php echo ($data['tel']); ?>" />
    </p>
	<p class="short-input ue-clear">
    	<label>邮箱：</label>
        <input type="text" name="email" value="<?php echo ($data['email']); ?>" />
    </p>
    
</div>
<div class="btn ue-clear">
    <input type="submit" class="confirm" value="确定"/>
    <input type="reset" class="clear" value="清空内容"/>
</div>
</form>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/laydate/laydate.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/placeImage.js"></script>

<script type="text/javascript">
    //将新密码和确认密码隐藏
    $('.password').hide();

    //给修改密码按钮绑定事件
    $('#updatepass').toggle(function(){
        ////将新密码和确认密码显示
        $('.password').show();
        $(this).val("取消修改");

        $('#newpassword').removeAttr("disabled");
        $('#repassword').removeAttr("disabled");

    },function(){

        $('.password').hide();
        $(this).val("修改密码");

        //将新密码和确认密码隐藏
        $('#newpassword').attr("disabled","disabled");
        $('#repassword').attr("disabled","disabled");



    });

    //初始化表单验证插件
    $("#theform").validate({
        //设置验证规则
        rules: {
            truename:{required:true,rangelength:[2,5]},
            birthday:{required:true,dateISO:true},
            email:{
                required:true,
                email:true,
                remote:{
                    url:"/index.php/Admin/User/checkEmail",
                    type:"post",
                    dataType:"json",
                    data:{
                        id:function(){
                            return $("input[name='id']").val();
                        }
                    }
                }
            },
            newpassword:{required:true,rangelength:[6,11]},
            repassword:{required:true,equalTo:"#newpassword"},
            tel:{requied:true,checkTel:""},
            dept_id:{checkDept:""},
            role_id:{checkRole:""}
        },
        //设置验证不通过的中文提示
        messages:{
            truename:{
                required:"必填",
                rangelength:"姓名长度为2-5位!"
            },
            birthday:{
                required:'必填',
                dateISO:'日期格式为xxxx-xx-xx'
            },
            email:{
                required:"必填",
                email:"输入合法的邮箱格式"
            },
            newpassword:{
                required:"必填",
                rangelength:"密码长度在6-11位"
            },
            repassword:{
                required:"必填",
                equalTo:"两次输入的密码不一致"
            },
            tel:{requied:"必填"},
        }
    })

    //自定义验证部门
    $.validator.addMethod("checkDept",function(v,ele,params){
        return v==0?false:true;

    },"请选择部门")

    //自定义验证角色
    $.validator.addMethod("checkRole",function(v,ele,params){
        return v==0?false:true;

    },"请选择角色")

    //自定义验证手机
    $.validator.addMethod("checkTel",function(v,ele,params){
        var regex=/^1[0-9]{10}$/;

        return regex.test(v)?true:false;

    },"不符合的手机格式")

    //初始化时间插件
    laydate({
        'elem': '#birthday', //需显示日期的元素选择器
        'event': 'click', //触发事
        'format': 'YYYY-MM-DD' //日期格式
    })

showRemind('input[type=text], textarea','placeholder');
</script>
</html>