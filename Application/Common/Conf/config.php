<?php
return array(
    //'配置项'=>'配置值'
    'URL_CASE_INSENSITIVE'  =>  true,       // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'             =>  1,          // URL访问模式,可选参数0、1、2、3,代表以下四种模式：

    'TMPL_L_DELIM'          =>  '{',        // 模板引擎普通标签开始标记
    'TMPL_R_DELIM'          =>  '}',        // 模板引擎普通标签结束标记
    'TMPL_DENY_PHP'         =>  false,      // 默认模板引擎是否禁用PHP原生代码
    //模板替换常量
    'TMPL_PARSE_STRING'=>array(
        '__ADMIN__'=>"/Public/Admin"        // 斜杠 /代表网站根目录(依据虚拟主机的配置)
    ),

    //配置默认的访问路径
    'DEFAULT_MODULE'        =>  'Admin',    //默认的模块（平台）
    'DEFAULT_CONTROLLER'    =>  'index',    //默认的控制器
    'DEFAULT_ACTION'        =>  'index',    //默认的方法

    // 显示页面Trace信息
    'SHOW_PAGE_TRACE'       =>  true,       //显示页面调试工具

);