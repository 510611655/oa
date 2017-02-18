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
            margin-right: 380px;
        }
    </style>
</head>

<body>
<div class="title"><h2>编辑公文</h2></div>
<form action="/index.php/Admin/Doc/edit" method="POST" id="theform" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo ($doc['id']); ?>">
    <input type="hidden" name="oldFile" value="<?php echo ($doc['file']); ?>">
<div class="main">
    <p class="short-input ue-clear">
    	<label>公文标题</label>
        <input type="text"  name="title" value="<?php echo ($doc['title']); ?>" />
    </p>
    <p class="short-input ue-clear">
        <label>附件</label>
        <input type="file" name="file"/>
    </p>
    <p class="short-input ue-clear">
        <label>发布人</label>
        <input type="text" style="border:none;"  name="author" disabled value="<?php echo ($doc['username']); ?>" />
    </p>

    <p class="short-input ue-clear">
    	<label>公文内容</label>
        <textarea id="content" name="content"><?php echo ($doc['content']); ?></textarea>
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
<script type="text/javascript" src="/Public/Admin/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="/Public/Admin/kindeditor/lang/zh-CN.js"></script>
<script type="text/javascript">



    //初始化编辑器
    KindEditor.ready(function(K) {
        window.editor = K.create('#content',{
            width:'700px',
            height:"200px",
            //当编辑公文时要回显在输入框中
            afterBlur:function(){this.sync();}
        });

    });


    //初始化表单验证插件
    $('#theform').validate({
        //设置验证规则
        rules:{
            title:{required:true,rangelength:[4,30]},
        },

        //设置验证不通过的提示
        messages:{
            title:{
                required:'必填',
                rangelength:'标题长度要4-30位'
            }
        }

    })

    //给提交按钮绑定事件
    $("form").submit(function(){
        var file=$("input[name='file']").val();
        var content=$("input[name='content']").val();
        if(file=="" && content==""){
            alert("附件和公告内容不能同时为空");
            return false;
        }

        return true;
    });



    //初始化时间插件
    laydate({
        'elem': '#add_time', //需显示日期的元素选择器
        'event': 'click', //触发事
        'format': 'YYYY-MM-DD' //日期格式
    })


</script>
</html>