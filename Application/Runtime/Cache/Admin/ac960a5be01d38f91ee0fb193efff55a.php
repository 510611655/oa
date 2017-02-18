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
        #intro-error{
            float: right;
            margin-right: 170px;
        }
    </style>
</head>

<body>
<div class="title"><h2>部门添加</h2></div>
<form action="/index.php/Admin/Dept/add" method="POST" id="theform">
<div class="main">
    <p class="short-input ue-clear">
    	<label>部门名称：</label>
        <input type="text"  name="name" placeholder="部门名称" />
    </p>
    <div class="short-input select ue-clear">
    	<label>上级部门：</label>
        <div class="select-wrap">

			 <select name="pid" style=" width: 262px; height: 32px;" class="select-title ue-clear"  id="">
                <option value="0">顶级部门</option>
                 <?php if(is_array($depts)): $i = 0; $__LIST__ = $depts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dept): $mod = ($i % 2 );++$i;?><option value="<?php echo ($dept['id']); ?>"><?php echo (str_repeat("&nbsp",$dept['level']*3)); echo ($dept['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>



            </select>
        </div>
    </div>
    <p class="short-input ue-clear">
        <label>排序</label>
        <input type="text" name="sort" value="50" placeholder="50"  />
    </p>
    <p class="short-input ue-clear">
    	<label>添加时间：</label>
       <!-- <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />-->
        <input type="text" name="add_time" id="add_time" autocomplete="off"/>
    </p>
    <p class="short-input ue-clear">
    	<label>部门描述：</label>
        <textarea placeholder="请输入内容" name="intro"></textarea>
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
            name:{required:true,rangelength:[4,10]},
            sort:{required:true,digits:true},
            intro:{required:true,minlength:5},
            add_time:{required:true,dateISO:true}
        },

        //设置验证不通过的提示
        messages:{
            name:{
                required:'必填',
                rangelength:'部门长度在4-10位'
            },
            sort:{
                required:'必填',
                digits:'必须为整数'
            },
            intro:{
                required:'必填',
                minlength:'描述至少要5个字'
            },
            add_time:{
                required:'必填',
                dateISO:'日期格式为xxxx-xx-xx'
            }

        }

    })


    //初始化时间插件
    laydate({
        'elem': '#add_time', //需显示日期的元素选择器
        'event': 'click', //触发事
        'format': 'YYYY-MM-DD' //日期格式
    })


</script>
</html>