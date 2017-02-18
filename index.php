<?php

//设置字符集，防止乱码
header('Content-type:text/html;charset=utf-8');

//定义应用目录Application 目录后面要加斜杠/
define('APP_PATH',"./Application/");

//开启调试模式 开发阶段设置为true 会显示详细的错误信息
define('APP_DEBUG',false);

//引入框架的核心文件
require "./ThinkPHP/ThinkPHP.php";
