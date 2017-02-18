<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />

<title>移动办公自动化系统</title>
</head>

<body>
<div class="title"><h2>部门管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/index.php/Admin/Plan/add" class="add">添加</a>
    <a href="javascript:;" class="count">统计</a>
</div>
<div id="container" style="min-width:400px;height:400px;display: none;">sdfsdfs</div>

<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="num">序号</th>
                <th class="name">部门名称</th>
                <th class="process">上级部门</th>
                <th class="node">排序</th>
                <th class="node">描述</th>
                <th class="time">添加时间</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                    <td class="num"><?php echo ($key+1); ?></td>
                    <td class="name"><?php echo (str_repeat("&nbsp",$v['level']*3)); echo ($v['name']); ?></td>
                    <td class="process"><?php echo ($v['pname']?$v['pname']:'无'); ?></td>
                    <td class="node"><?php echo ($v['sort']); ?></td>
                    <td class="node"><?php echo ($v['intro']); ?></td>
                    <td class="time"><?php echo ($v['add_time']); ?></td>
                    <td class="operate">

                        <?php if(is_array($three_auth)): $i = 0; $__LIST__ = $three_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i; if($three['s_name'] != '删除'): ?><a href="/index.php/Admin/Plan/<?php echo ($three['a_name']); ?>/id/<?php echo ($v['id']); ?>"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;
                                <?php else: ?>
                                <a href="javascript:;" id="<?php echo ($v['id']); ?>" class="delete"><?php echo ($three['s_name']); ?></a>&nbsp;&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>


                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
    <div class="pagin-list">
        <?php echo ($pages); ?>
        <span id="count"><?php echo ($count); ?></span>条记录
    </div>

</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.pagination.js"></script>
<script type="text/javascript" src="/Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Admin/Highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="/Public/Admin/Highcharts/js/modules/exporting.js"></script>

<script type="text/javascript">

    //给删除链接绑定一个单击事件
    $(".delete").bind("click",function() {
        //首先获取要删除的ID 和要删除的图片路径
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
                url : "/index.php/Admin/Plan/del" ,
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
                        var num=$("#count").html()-1;
                        $("#count").html(num);

                    }else{
                        //提示层
                        layer.msg(data.info);
                    }
                }
            } )
        },function(){

        });
    })

    //给统计绑定一个单击事件
    $(".count").click(function(){
        //单击统计表时显示图表
        if($("#container").css('display')=="none"){
            $("#container").css('display',"block");

            //用AJAX进行数据请求
            $.ajax( {
                url : "/index.php/Admin/Plan/getDeptNum" ,
                type : "post" ,
                datatype : "json" ,
                success : function ( data ) {
                    var dept = [];

                    //将接受的数据进行JSON解码
                    data = JSON.parse( data )

                    //拼接图片所需的数组
                    for ( var i = 0 ; i < data.length ; i++ ) {
                        var array = [ data[ i ].name , parseInt( data[ i ].num ) ];
                        dept.push( array );
                    }
                    $('#container').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '各部门人数统计'
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '部门人数 (单位：人)'
                            }
                        },
                        legend: {
                            enabled: true
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} 人</b>'
                        },
                        series: [{
                            name: '人数',
                            data:dept,
                            dataLabels: {
                                enabled: true,
                                rotation: 360,
                                color: '#FFFFFF',
                                align: 'right',
                                format: '{point.y}', // one decimal
                                y: 10, // 10 pixels down from the top
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }]
                    });

                }

            });


        }else{
            $("#container").css('display',"none");
        }

    });





    $("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');
</script>
</html>