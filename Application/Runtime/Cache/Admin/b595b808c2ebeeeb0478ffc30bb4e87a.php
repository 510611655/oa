<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/jquery.dialog.css" />
<link rel="stylesheet" href="/Public/Admin/css/index.css?1" />
<link rel="stylesheet" href="/Public/Admin/lobibox/dist/css/lobibox.min.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div id="container">
  <div id="hd">
    <div class="hd-wrap ue-clear">
      <div class="top-light"></div>
      <h1 class="logo"></h1>
      <div class="login-info ue-clear">
        <div class="welcome ue-clear"><span>欢迎您,</span><a href="javascript:;" class="user-name"><?php echo (session('oa_username')); ?></a></div>
        <div class="login-msg ue-clear"> <a href="/index.php/Admin/Email/receiver" target="iframe" class="msg-txt">消息</a> <a href="/index.php/Admin/Email/receiver" target="iframe" class="msg-num"><?php echo ($count); ?></a> </div>
      </div>
      <div class="toolbar ue-clear"> <a href="/index.php/Admin/Index/index" class="home-btn">首页</a> <a href="javascript:;" class="quit-btn exit"></a> </div>
    </div>
  </div>
  <div id="bd">
    <div class="wrap ue-clear">
      <div class="sidebar">
        <h2 class="sidebar-header">
          <p>功能导航</p>
        </h2>
        <ul class="nav">
          <?php if(is_array($one_auth)): $i = 0; $__LIST__ = $one_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><li class="nav-info">
              <div class="nav-header" auth_id="<?php echo ($one['id']); ?>"><a href="javascript:;" class="ue-clear"><span><?php echo ($one['name']); ?></span><i class="icon"></i></a></div>
              <ul class="subnav">

                <?php if(is_array($two_auth)): $i = 0; $__LIST__ = $two_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$two): $mod = ($i % 2 );++$i; if($one['id'] == $two['pid']): ?><li><a href="javascript:;" date-src="/<?php echo ($two['m_name']); ?>/<?php echo ($two['c_name']); ?>/<?php echo ($two['a_name']); ?>"><?php echo ($two['name']); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

              </ul>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
      <div class="content">
        <iframe src="/index.php/Admin/Index/home" name="iframe" id="iframe" width="100%" height="100%" frameborder="0"></iframe>
      </div>
    </div>
  </div>
  <div id="ft" class="ue-clear">
    <div class="ft-left"> <span>中国移动</span> <em>Office&nbsp;System</em> </div>
    <div class="ft-right"> <span>Automation</span> <em>V2.0&nbsp;2014</em> </div>
  </div>
</div>
<div class="exitDialog">
  <div class="dialog-content">
    <div class="ui-dialog-icon"></div>
    <div class="ui-dialog-text">
      <p class="dialog-content">你确定要退出系统？</p>
      <p class="tips">如果是请点击“确定”，否则点“取消”</p>
      <div class="buttons">
        <input type="button" class="button long2 ok" value="确定" />
        <input type="button" class="button long2 normal" value="取消" />
      </div>
    </div>
  </div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/core.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.dialog.js"></script>
<script type="text/javascript" src="/Public/Admin/js/index.js?2"></script>
<script type="text/javascript" src="/Public/Admin/lobibox/dist/js/lobibox.min.js"></script>
<script>

  //获取auth_id为1的对象,将他父类添加class="current",并且将其子类ul标签移除
  $("div[auth_id='1']").parent().addClass("current").find("ul").remove();

  //获取auth_id为1的对象
  $("div[auth_id='1']").find("a").attr("date-src","/index.php/Admin/Index/home");


    //先设置一个定时器，每隔3秒就获取一次未读邮件的值，然后和数据库里面的未读邮件进行比对
    //首先获取页面上未读邮件的总数量,通过ajax发送到后台去验证,和数据库最新的未读邮件的数量做个对比
    //有新邮件:最新的未读邮件的数量>页面上未读邮件的总数量,页面上未读邮件的总数量+1
    //查看内容:最新的未读邮件的数量<页面上未读邮件的总数量,页面上未读邮件的总数量-1

    setInterval("getEmailNum()",3000);

    function getEmailNum(){
        //先获取页面上旧的未读邮件的值
        var oldNum=$(".msg-num").html();

        //然后在通过ajax获取数据库里面的未读邮件的数量
        $.ajax({
            url:"/index.php/Admin/Index/getEmailNum",
            type:"post",
            data:{"oldNum":oldNum},
            success:function(data){

                if(data>0){
                    //有新的邮件接收
                    //页面显示的未读邮件数量增加相应的数量
                    $(".msg-num").html(parseInt(oldNum)+parseInt(data));

                    Lobibox.notify('info', {
                        size: 'mini',
                        title: '您有'+data+"封新邮件",
                        msg: "<a href='/index.php/Admin/Email/receiver' target='iframe'>点击立即查看</a>"
                    });
                }else if(data<0){
                    //有查看未读的邮件
                    //页面显示的未读邮件数量减少相应的数量
                    $(".msg-num").html(parseInt(oldNum)+parseInt(data));


                }
            }
        });
    }
</script>
</html>