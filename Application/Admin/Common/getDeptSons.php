<?php
//部门分类利用无限极分类方法分类
/*
 * param $arr array 数据源
 * param $pid int 父类ID
 * param $level int 分类的层级
 * return $limits array 返回一个处理好的层级关系的数组
 */
function getDeptSons($arr,$pid=0,$level=0){

    foreach($arr as $v){
        //定义一个静态数组存储分类好的数据
        static $limits=array();


        if($v['pid']==$pid){
            $v['level']=$level;
            $limits[]=$v;
            getDeptSons($arr,$v['id'],$level+1);
        }
    }
    return $limits;
}