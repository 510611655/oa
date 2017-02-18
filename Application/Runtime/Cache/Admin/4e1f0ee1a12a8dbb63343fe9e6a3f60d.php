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

    #dept_id-error{
        position: absolute;
    }
    #role_id-error{
        position: absolute;
    }
	
</style>
</head>

<body>
<div class="title"><h2>职员信息登记</h2></div>
<form action="/index.php/Admin/User/add" id="theform" method="post" enctype="multipart/form-data">
<div class="main">
    <p class="short-input ue-clear">
    	<label>登录名：</label>
        <input name="username" type="text" placeholder="登录名长度为5-10位" />
    </p>
	<p class="short-input ue-clear">
    	<label>真名：</label>
        <input name="truename" type="text" placeholder="名字长度为2-5位" />
    </p>
    <p class="short-input ue-clear">
        <label>头像：</label>
        <input name="photo" id="f" type="file" placeholder="头像" onchange="change()" />
    </p>
    <p style="display: inline">预览:</p >
    <p style="display: inline">
        <img id="preview" name="pic" style="display: inline;margin-left: 22px;width:200px;"/>
    </p>
    <div class="short-input select ue-clear">
    	<label>所属部门：</label>
        <select name="dept_id">
        	<option value="0">请选择</option>
            <?php if(is_array($depts)): $i = 0; $__LIST__ = $depts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v['id']); ?>"><?php echo (str_repeat("&nbsp",$v['level']*3)); echo ($v['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
    <div class="short-input select ue-clear">
        <label>角色：</label>
        <select name="role_id">
            <option value="0">请选择</option>
            <?php if(is_array($roles)): $i = 0; $__LIST__ = $roles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><option value="<?php echo ($r['id']); ?>"><?php echo ($r['role_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
	<p class="short-input ue-clear">
    	<label>性别：</label>
    	<input name="sex" type="radio" style="float:none;" value="0" checked='checked' />男
		<input name="sex" type="radio" style="float:none;" value="1" />女
    </p>
	<p class="short-input ue-clear">
    	<label>生日：</label>
        <input id="birthday" name="birthday" type="text" placeholder="格式:YYYY-MM-DD" />
    </p>
	<p class="short-input ue-clear">
    	<label>联系电话：</label>
        <input type="text" name="tel" placeholder="联系电话" />
    </p>
	<p class="short-input ue-clear">
    	<label>邮箱：</label>
        <input type="text" name="email" placeholder="电子邮箱" />
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
<script type="text/javascript" src="/Public/Admin/js/placeImage.js?1"></script>

<script type="text/javascript">
    //初始化表单验证插件
    $("#theform").validate({
        //设置验证规则
        rules: {
            dept_id:{checkDept:""},
            role_id:{checkRole:""},
            username : { required : true,rangelength:[5,10] },
            truename:{required:true,rangelength:[2,5]},
            birthday:{required:true,dateISO:true},
            email:{required:true,email:true},
            tel:{required:true,checkTel:""}

        },
        //设置验证不通过的中文提示
        messages:{
            username:{
                required:"必填",
                rangelength:"登录名长度为5-10位!"
            },
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
            tel:{
                required:"必填"
            }
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