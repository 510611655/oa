<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {
    //字段定义
    protected $fields=array(
        'id','username','truename','password','sex','dept_id','tel','birthday','email','photo','add_time',"role_id",'_pk'=>'id'
    );

    //表单验证
    protected $_validate = array(
        array('username','5,10','登录名要5-10位',0,'length ',3),
        array('username','','登录名已存在',0,'unique',3),
        array('truename','2,5','真名要2-5位',0,'length',3),
        array('birthday','/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/','日期格式为YYYY-mm-dd',0,'regex',3),
        array('email','/^[A-Za-zd]+([-_.][A-Za-zd]+)*@([A-Za-zd]+[-.])+[A-Za-zd]{2,5}$/','请填入合法的邮箱格式',0,'regex',3),

    );
}