<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html charset='utf-8'>
<head>
    <title>角色添加</title>
    <style>
        .mydiv{margin-top: -10px;margin-left: 10px}
        .mydiv ul{list-style:none;font-size: 16px}
        .mydiv ul li{list-style: none;  margin-bottom: 0px;  margin-left: 23px;}
        .mydiv ul li input{height: 30px;width: 20px;}

        body form .error{
            width:300px;
            color:#ff0000;
        }


    </style>
</head>
<body>
<div id="content">

    <div class="mydiv">
        <h2>[<span style="color:#ff804a">角色添加</span>]</h2>

            <form action="/index.php/Admin/Role/add" method="post" id="theform">
                <div>角色名：<input type="text" name="role_name"></div>

                <input type="hidden" auth_ids="<?php echo ($roles['auth_ids']); ?>"/>
                <hr/>
                <div>权限分配</div>
                <div class="info">
                    <!--一级遍历-->
                    <?php if(is_array($one_auth)): $i = 0; $__LIST__ = $one_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><ul style="width: 300px;">
                            <span><?php echo ($one['name']); ?></span><input class="onemenu auth" type="checkbox" name="auth_ids[]"  value="<?php echo ($one['id']); ?>"  style="height: 30px;width: 20px;margin-bottom: 6px;" />
                            <li>
                                <!--二级遍历-->
                                <?php if(is_array($two_auth)): $i = 0; $__LIST__ = $two_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$two): $mod = ($i % 2 );++$i; if($one['id'] == $two['pid']): ?><ul style="width: 120px;">
                                            <span><?php echo ($two['name']); ?></span><input name="auth_ids[]"  class="twomenu auth"   value="<?php echo ($two['id']); ?>" type="checkbox"  />
                                            <!--三级遍历-->
                                            <?php if(is_array($three_auth)): $i = 0; $__LIST__ = $three_auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i; if($two['id'] == $three['pid']): ?><li>
                                                        <!--<span class="name">--><span><?php echo ($three['name']); ?></span><input name="auth_ids[]"  class="threemenu auth"   value="<?php echo ($three['id']); ?>" type="checkbox"  />
                                                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </ul><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </li>
                        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <hr/>
                <input type="submit"  value="确定"/>
                <input type="reset"  value="重置"/>
            </form>
    </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.validate.min.js"></script>
<script>

    //验证表单
    $("#theform").validate({
        rules:{
            role_name:{required:true,maxlength:7},
            "ids[]":{checkAuth:""}
        },
        messages:{
            role_name:{
                required:"角色名必填",
                maxlength:"角色名最多7位"
            }
        }

    })

    $.validator.addMethod("checkAuth",function(v,ele,params){
        if($(".auth:checked").length==0){
            return false;
        }else{
            return true;
        }

    },'至少选择一个权限')


    //获取对应角色的权限,将字符串转化成数组
    var auth_ids=$("input[type='hidden']").attr("auth_ids");
    auth_ids=auth_ids.split(",");

    //先将默认的权限选上
    $("input[type='checkbox']").each(function(){
        if($.inArray($(this).attr("value"),auth_ids)>=0){
            $(this).attr("checked",true);
        }
    })

    //权限选择特效
    //如果点击了一级权限，其下面的2级权限被选中
    //获取所有的一级权限
    $(".onemenu").click(function(){
        var onemenu=$(this).attr("checked");

        $(this).parent().find(".twomenu").attr("checked",onemenu?true:false);
       $(this).parent().find(".threemenu").attr("checked",onemenu?true:false);

    });

    //获取所有的二级权限
    $(".twomenu").click(function(){
        var twomenu=$(this).attr("checked");
        var sibling=$(this).parents('ul').find(".twomenu:checked").length;

       $(this).parent().find(".threemenu").attr("checked",twomenu?true:false);
       $(this).parents('ul').find(".onemenu").attr("checked",sibling?true:false);
    });

    //获取所有的三级权限
    $(".threemenu").click(function(){
        /*var threemenu=$(this).attr("checked");*/
        var sibling=$(this).parents('ul').find(".threemenu:checked").length;

        $(this).parent().parent("ul").find(".twomenu").attr("checked",sibling?true:true);

        var parent=$(this).parents('ul').find(".twomenu:checked").length;
        $(this).parents('ul').find(".onemenu").attr("checked",parent?true:false);

    });

</script>
</html>