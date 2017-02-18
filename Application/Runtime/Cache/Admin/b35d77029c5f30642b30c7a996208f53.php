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
<div class="title"><h2>角色管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/index.php/Admin/Role/add" class="add">添加</a>
    <a href="/index.php/Admin/Role/chart" class="count">统计</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">角色名</th>
				<th class="nickname">权限</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td class="id"><?php echo ($key+1); ?></td>
                    <td class="name"><?php echo ($vo['role_name']); ?></td>
                    <td class="nickname"><a href="/index.php/Admin/Role/allocation/id/<?php echo ($vo['id']); ?>">分配权限</a></td>
                    <td class="operate">

                        <?php if(is_array($three_auth)): $i = 0; $__LIST__ = $three_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i;?><a href="javascript:;"  id="<?php echo ($vo['id']); ?>" class="delete"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>

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
        //首先获取要删除的ID
        var id = $( this ).attr( "id" );

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
                url : "/index.php/Admin/Role/del" ,
                data : { 'id' : id} ,
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