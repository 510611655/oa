<?php
namespace Admin\Model;
use Think\Model;
class DeptModel extends Model{
    protected $fields=array('id','name','pid','sort','add_time','intro','_pk'=>'id');

    //TP框架自带的自动验证
    protected $_validate=array(
      //array(验证字段，验证规则，错误提示，[验证条件，附加规则，验证时间])
      //第一个参数，验证字段有字段映射就写数据表的字段，否则就写表单name字段
      array('name','4,10','部门名称必须在4-10位！',0,'length',3),
      array('name','','部门名称已存在！',0,'unique',3),
      array('sort','/^[0-9]+$/','排序数字必须为正整数',0,'regex',3),
      array('add_time','/([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))/','时间格式为xxxx-xx-xx',0,'regex',3),
      array('intro','minlength','部门描述最少5个字！',0,'callback',3)

    );

    //自定义个验证部门描述的数据长度
    public function minlength($intro){
        if(strlen($intro)>=5){
            return true;//验证通过直接返回true，失败返回false
        }
        return false;
    }


}