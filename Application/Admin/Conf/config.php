<?php
return array(
    //'配置项'=>'配置值'
    /*数据库配置*/
    'DB_TYPE'       =>  'mysql',            //数据库类型
    'DB_HOST'       =>  'localhost',        //服务器地址
    'DB_PORT'       =>  '3306',             //端口号
    'DB_USER'       =>  'root',             //用户名
    'DB_PWD'        =>  '510611655',        //密码
    'DB_NAME'       =>  'oa',               //数据库名
    'DB_PREFIX'     =>  'oa_',              //数据库前缀


    "default_pass"  =>  "123456",           //设置默认的职员登录密码
    "salt"          =>  "#$^&&^$#$@$%$s",   //给密码加“盐”
    "user_pagesize" =>  5,                  //员工列表每页显示的记录数
    "dept_pagesize" =>  5,                  //部门列表每页显示的记录数
    "email_pagesize" =>  5,                  //邮件列表每页显示的记录数
    "role_pagesize" =>  2,                  //角色列表每页显示的记录数
    "doc_pagesize" =>  5,                  //公文列表每页显示的记录数

);