<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	table tr .id{ width:63px; text-align: center;}
	table tr .name{ width:118px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:17px;}
	table tr .dept_id{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:80px; padding-left:13px;}
	table tr .tel{ width:113px; padding-left:13px;}
	table tr .email{ width:160px; padding-left:13px;}
	table tr .addtime{ width:160px; padding-left:13px;}
	table tr .operate{ padding-left:13px;}
</style>
</head>

<body>
<div class="title"><h2>职员管理</h2></div>
<!--<div class="table-operate ue-clear">
	<a href="/index.php/Admin/User/add" class="add">添加</a>
    &lt;!&ndash;<a href="/index.php/Admin/User/chart" class="count">统计</a>&ndash;&gt;
</div>-->
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">登录名</th>
				<th class="nickname">姓名</th>
				<th class="nickname">头像</th>
                <th class="tel">所属部门</th>
				<th class="sex">性别</th>
				<th class="birthday">生日</th>
                <th class="tel">电话</th>
				<th class="email">邮箱</th>
                <th class="addtime">添加时间</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            	<td class="id"><?php echo ($key+1); ?></td>
                <td class="name"><?php echo ($vo['username']); ?></td>
				<td class="nickname"><?php echo ($vo['truename']); ?></td>
				<td class="nickname">
					<?php if(empty($vo['photo'])): ?><img src="/Uploads/Photo/default_photo/thumb_default_photo.jpg">
						<?php else: ?>
						<img src="/Uploads/Photo/<?php echo explode(',',$vo['photo'])[1]; ?>"><?php endif; ?>
				</td>
                <td class="dept_id"><?php echo ($vo['dept_name']); ?></td>
                <td class="sex"><?php echo ($vo['sex']?"女":"男"); ?></td>
				<td class="tel"><?php echo ($vo['birthday']); ?></td>
				<td class="tel"><?php echo ($vo['tel']); ?></td>
				<td class="email"><?php echo ($vo['email']); ?></td>
                <td class="addtime"><?php echo ($vo['add_time']); ?></td>
                <td class="operate">


					<?php if(is_array($three_auth)): $i = 0; $__LIST__ = $three_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i; if($three['s_name'] != '删除'): ?><a href="/index.php/Admin/User/<?php echo ($three['a_name']); ?>/id/<?php echo ($vo['id']); ?>"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;
							<?php else: ?>
							<a href="javascript:;" id="<?php echo ($vo['id']); ?>" photo="<?php echo ($vo['photo']); ?>" class="delete"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($pages); ?>
	</div>

</div>

</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/layer/layer.js"></script>
<script type="text/javascript">
//给删除链接绑定一个单击事件
$(".delete").bind("click",function() {
    //首先获取要删除的ID 和要删除的图片路径
    var id = $( this ).attr( "id" );
    var photo = $( this ).attr( "photo" );
    //用一个变量去存储当前对象，便于AJAX的回调函数使用
    var _this = $( this );

    //询问框
    layer.confirm( '是否确定要删除？' , {
        btn : [ '确定' , '取消' ] //按钮
    }, function () {
        //点击确定的回调函数
		//点击确定后把询问框关闭
		layer.closeAll();
        //用AJAX进行无刷新删除
        $.ajax( {
            type : "get" ,
            url : "/index.php/Admin/User/del" ,
            data : { 'id' : id , 'photo' : photo } ,
            dataType : "json" ,
			beforeSend:function(){
                //loading层
                var index = layer.load(1, {
                    shade: [0.3,'#666'] //0.1透明度的白色背景
                });
			},
            success : function ( data ) {
			    //将对应的加载层关闭
				layer.closeAll();


                if ( data.error == 0 ) {
                    //如果删除成功，就将对应的标签删除
                    _this.parent().parent().remove();

                    //重新对序号进行排序
                    //获取所有的tbody下的tr,进行遍历
                    $( "tbody tr" ).each( function ( k , v ) {
                        //对每一个tr下的第一个td进行重新赋值
                        $( this ).find( "td" ).eq( 0 ).html( k + 1 );
                    } )

					//总记录数减1
					var num=$(".pxofy b").html()-1;
                    $(".pxofy b").html(num);

                    //当将本页的所有数据删除了就刷新当前页面
					if($("tbody tr").length<1){
					    //重新加载URL地址
						location.reload();
					}

                }
            }
        } )
    },function(){

	});
})

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');
</script>
</html>