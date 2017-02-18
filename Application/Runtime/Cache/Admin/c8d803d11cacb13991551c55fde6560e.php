<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<title>移动办公自动化系统</title>
    <style>
        body form label.error{
            width:300px;
            color:#ff0000;
        }
        #content-error{
            float: right;
            margin-right: 170px;
        }
    </style>
</head>

<body>
<div class="title"><h2>日程添加</h2></div>
<form action="/index.php/Admin/Plan/add" method="POST" id="theform">
<div class="main">
    <p class="short-input ue-clear">
    	<label>日程标题：</label>
        <input type="text"  name="title" placeholder="日程标题" />
    </p>
    <p class="short-input ue-clear">
    	<label>提示时间：</label>
        <input type="text" name="plan_time" id="plan_time" autocomplete="off"/>
    </p>
    <p class="short-input ue-clear">
    	<label>日程内容：</label>
        <textarea placeholder="请输入内容" name="content"></textarea>
        <input type="hidden">
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
<script type="text/javascript">

    //初始化表单验证插件
    $('#theform').validate({
        //设置验证规则
        rules:{
            title:{required:true,rangelength:[4,30]},
            content:{required:true,minlength:5},
            plan_time:{required:true,dateISO:true}
        },

        //设置验证不通过的提示
        messages:{
            title:{
                required:'必填',
                rangelength:'标题长度在4-30位'
            },
            content:{
                required:'必填',
                minlength:'内容至少要5个字'
            },
            plan_time:{
                required:'必填',
                dateISO:'日期格式为xxxx-xx-xx xx:xx:xx'
            }

        }

    })


    //初始化时间插件
    laydate({
        'elem': '#plan_time', //需显示日期的元素选择器
        'event': 'click', //触发事
        'format': 'YYYY-MM-DD' //日期格式
    })


</script>
</html>