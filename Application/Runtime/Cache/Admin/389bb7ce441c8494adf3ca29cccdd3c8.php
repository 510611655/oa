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

        #seek{
            background-color:#fff;
            display: none;
            position: absolute;
            left: 114px;
            border: 1px solid #C5D6E0;
            border-top:none;
            width: 260px;
        }
    </style>
</head>

<body>
<div class="title"><h2>回复邮件</h2></div>
<form action="/index.php/Admin/Email/send" method="POST" id="theform" enctype="multipart/form-data">
<div class="main">
    <p class="short-input ue-clear">
    	<label>邮件标题</label>
        <input type="text"  name="title" placeholder="邮件标题"/>
    </p>
    <p class="short-input ue-clear">
        <label>附件</label>
        <input type="file" name="file"/>
    </p>
    <p class="short-input ue-clear" style="position:relative">
        <label>收件人</label>
        <input type="text" name="receiver_name" value="<?php echo ($data['username']); ?>" disabled />
        <input type="hidden" name="receiver_id" value="<?php echo ($data['send_id']); ?>"/>
    </p>

    <p class="short-input ue-clear">
    	<label>发送内容</label>
        <textarea name="content" id="content"></textarea>
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
<script type="text/javascript" src="/Public/Admin/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/Public/Admin/layer/layer.js"></script>
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
    $("#theform").validate({
        rules:{
            title:{required:true},
            receiver_name:{required:true,ajax:""
            }
        },
        messages:{
            title:{
                required:"邮件标题必填"
            },
            receiver_name:{
                required:"收件人必填"
            }
        },
        //判断是否附件和内容都为空，为空就不提交
        submitHandler:function(){
            //先获取附件信息和邮件内容信息
            var file=$("input[name='file']").val();
            var content=$("input[name='content']").val();

            if(file=="" && content==""){
                layer.msg("不能发送空邮件",{time:2000});
                return false;
            }
            return true;

        }
    });


</script>
</html>