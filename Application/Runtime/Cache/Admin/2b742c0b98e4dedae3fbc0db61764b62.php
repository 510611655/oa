<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/home.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div class="article toolbar">
	<div class="title ue-clear">
    	<h2>常用工具</h2>
        <a href="javascript:;" class="more">更多</a>
    </div>
    <div class="content">
    	<ul class="toollist ue-clear">
    		<li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon01.png" /></a>
                <p><a href="javascript:;">通知公告</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon02.png" /></a>
                <p><a href="javascript:;">知识库</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon03.png" /></a>
                <p><a href="javascript:;">密码修改</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon04.png" /></a>
                <p><a href="javascript:;">日程安排</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon05.png" /></a>
                <p><a href="javascript:;">添加文章</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon06.png" /></a>
                <p><a href="javascript:;">网络硬盘</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon07.png" /></a>
                <p><a href="javascript:;">参数信息</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon08.png" /></a>
                <p><a href="javascript:;">回收站</a></p>
            </li>
            <li>
            	<a href="javascript:;" class="img"><img src="/Public/Admin/images/icon09.png" /></a>
                <p><a href="javascript:;">系统配置</a></p>
            </li>
            <li class="add-btn">
            	<img src="/Public/Admin/images/add.png" />
            </li>
    	</ul>
        
    </div>
</div>
<div class="article half notice">
	<div class="wrap-l">
        <div class="title ue-clear">
            <h2>通知公告</h2>
            <a href="/index.php/Admin/Doc/index" class="more">更多</a>
        </div>
        <div class="content">
        	<ul class="notice-list">
                <?php if(is_array($doc)): $i = 0; $__LIST__ = $doc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><li class="ue-clear">
                        <a href="/index.php/Admin/Doc/index/id/<?php echo ($d['id']); ?>" class="notice-title"><?php echo ($d['title']); ?></a>
                        <div class="notice-time"><?php echo ($d['add_time']); ?></div>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>


    </div>
</div>
<div class="article half matter">
	<div class="wrap-r">
        <div class="title ue-clear">
            <h2 class="title-list">
                <ul class="ue-clear">
                    <li class="current"><a href="javascript:;">待办事项</a></li>
                    <li><a href="javascript:;">已办事项</a></li>
                </ul>
            </h2>
            <a href="javascript:;" class="more">更多</a>
        </div>
        <div class="content">
        	<div class="matter-content current ue-clear">
            	<div class="today">
                	<p class="year"><SCRIPT>  
   var d = new Date();  
  document.write(d.getFullYear() + "年" +(d.getMonth() + 1) + "月" );  
 </SCRIPT></p>
                    <p class="date"><SCRIPT>  
   var d = new Date();  
  document.write(d.getDate());  
 </SCRIPT></p>
                </div>
                <ul class="matter-list">
                	<li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">下午2点中国移动召开2014年工作会议</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">上交本年度市局工作报告提纲</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">领取南京政府办公室公务员津贴</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">南京2014年全国移动技术投标大会报名事宜</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">参加市政府举办的互动活动并宣传单位</a>
                    </li>
                </ul>
            </div>
            <div class="matter-content ue-clear">
            	<div class="today">
                	<p class="year">2014年5月</p>
                    <p class="date">10</p>
                </div>
                <ul class="matter-list">
                	<li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">领取南京政府办公室公务员津贴</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">南京2014年全国移动技术投标大会报名事宜</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">领取南京政府办公室公务员津贴</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">南京2014年全国移动技术投标大会报名事宜</a>
                    </li>
                    <li class="ue-clear">
                    	<span class="matter-time">05-08</span>
                        <a href="javascript:;" class="matter-title">参加市政府举办的互动活动并宣传单位</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="article half duty">
	<div class="wrap-l">
        <div class="title ue-clear">
            <h2>领导值岗</h2>
            <a href="javascript:;" class="more">更多</a>
        </div>
        <div class="content">
        	<table>
            	<thead>
                	<tr>
                    	<th class="date">日期</th>
                        <th class="week">星期</th>
                        <th class="leader">值班领导</th>
                        <th class="contact">联系方式</th>
                        <th class="remark">备注</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td class="date">05-08</td>
                        <td class="week">星期一</td>
                        <td class="leader">刘秀全</td>
                        <td class="contact">139039409876</td>
                        <td class="remark"></td>
                    </tr>
                    <tr>
                    	<td class="date">05-09</td>
                        <td class="week">星期一</td>
                        <td class="leader">刘秀全</td>
                        <td class="contact">139039409876</td>
                        <td class="remark"></td>
                    </tr>
                    <tr>
                    	<td class="date">05-10</td>
                        <td class="week">星期一</td>
                        <td class="leader">刘秀全</td>
                        <td class="contact">139039409876</td>
                        <td class="remark"></td>
                    </tr>
                    <tr>
                    	<td class="date">05-08</td>
                        <td class="week">星期一</td>
                        <td class="leader">刘秀全</td>
                        <td class="contact">139039409876</td>
                        <td class="remark"></td>
                    </tr>
                    <tr>
                    	<td class="date">05-08</td>
                        <td class="week">星期一</td>
                        <td class="leader">刘秀全</td>
                        <td class="contact">139039409876</td>
                        <td class="remark"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="article half email">
	<div class="wrap-r">
        <div class="title ue-clear">
            <h2>未读邮件</h2>
            <a href="/index.php/Admin/Email/receiver" class="more">更多</a>
        </div>

        <div class="content">
        	<table>
            	<thead>
                	<tr>
                    	<th class="icon"></th>
                        <th class="sender">发件人</th>
                        <th class="subject">主题</th>
                        <th class="time last-item">时间</th>
                    </tr>
                </thead>
                <tbody>
                	<tr class="tody">
                    	<td colspan="4"><div class="td-wrap"><em>今天</em><a href="javascript:;">(<?php echo ($email_num); ?>封)</a></div></td>
                    </tr>

                    <?php if(is_array($email)): $i = 0; $__LIST__ = $email;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$e): $mod = ($i % 2 );++$i;?><tr>
                            <td class="icon"><div class="td-wrap"></div></td>
                            <td class="sender"><div class="td-wrap"><?php echo ($e['username']); ?></div></td>
                            <td class="subject"><div class="td-wrap"><a href="/index.php/Admin/Email/receiver/id/<?php echo ($e['id']); ?>/is_read/<?php echo ($is_read); ?>"><?php echo ($e['title']); ?></a></div></td>
                           <td class="time"><div class="td-wrap">
                               <?php echo ($e['send_time']); ?>
                           </div></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript">
$(".title-list ul").on("click","li",function(){
	var aIndex = $(this).index();
	$(this).addClass("current").siblings().removeClass("current");
	$(".matter-content").removeClass("current").eq(aIndex).addClass("current");
});

$(".duty").find("tbody").find("tr:even").css("backgroundColor","#eff6fa");
</script>
</html>