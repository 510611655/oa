<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
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
<div class="title"><h2>公文管理</h2></div>
<!--<div class="table-operate ue-clear">
	&lt;!&ndash;<a href="/index.php/Admin/Doc/add" class="add">添加</a>&ndash;&gt;

</div>-->
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">公文标题</th>
				<th class="nickname">发布人</th>
				<th class="nickname">附件</th>
				<th class="birthday">公文内容</th>
                <th class="addtime">发送时间</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><tr>
            	<td class="id"><?php echo ($key+1); ?></td>
                <td class="name"><?php echo ($d['title']); ?></td>
				<td class="nickname"><?php echo ($d['username']); ?></td>
				<?php if($d['file'] == ''): ?><td class="dept_id">暂无附件</td>
					<?php else: ?>
					<td class="dept_id"><a href="/index.php/Admin/Doc/down/id/<?php echo ($d['id']); ?>" >点击下载</a></td><?php endif; ?>
				<?php if($d['content'] == ''): ?><td class="tel">暂无内容</td>
					<?php else: ?>
					<td class="tel "><a href="javascript:;" doc_id="<?php echo ($d['id']); ?>" class="content"  >查看内容</a></span>
						</td><?php endif; ?>
                <td class="addtime"><?php echo ($d['add_time']); ?></td>

				<td>
					<?php if(is_array($three_auth)): $i = 0; $__LIST__ = $three_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i; if($three['s_name'] != '删除'): ?><a href="/index.php/Admin/Doc/<?php echo ($three['a_name']); ?>/id/<?php echo ($d['id']); ?>"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;
							<?php else: ?>
							<a href="javascript:;" file="<?php echo ($d['file']); ?>" id="<?php echo ($d['id']); ?>" class="delete"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
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


//给查看内容绑定一个单击事件
$(".content").click(function(){
	    //获取当前公文内容
		var doc_id=$(this).attr("doc_id");

		//通过ajax获取邮件内容
		$.ajax({
		    url:"/index.php/Admin/Doc/getDocContent",
			type:'post',
			data:{"id":doc_id},
			success:function(data){
                //页面层
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['800px', '500px'], //宽高
                    content:data
                });
            }
		});

	});

//给删除链接绑定一个单击事件
$(".delete").bind("click",function() {
    //首先获取要删除的ID 和要删除的图片路径
    var id = $( this ).attr( "id" );
    var file = $( this ).attr( "file" );
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
            url : "/index.php/Admin/Doc/del" ,
            data : { 'id' : id , 'file' : file } ,
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

                }else{
                    //提示层
                    layer.msg(data.info);
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