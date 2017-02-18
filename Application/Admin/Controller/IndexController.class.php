<?php
namespace Admin\Controller;

class IndexController extends CommonController
{
    public function index(){


        //获取当前用户的权限
        $auth_ids=M('Role')->where(array("id"=>session("oa_role_id")))->getField("auth_ids");



        //如果是超级管理员就开放所有权限
        if($auth_ids=="*"){
            //组装where判断语句
            $where1=array(
                "level"=>0
            );
            $where2=array(
                "level"=>1
            );

            $one_auth=M("Auth")->where($where1)->select();
            $two_auth=M("Auth")->where($where2)->select();
        }else{
            //组装where判断语句
            $where1=array(
                "id"=>array("in",$auth_ids),
                "level"=>0
            );
            $where2=array(
                "id"=>array("in",$auth_ids),
                "level"=>1
            );

            $one_auth=M("Auth")->where($where1)->select();
            $two_auth=M("Auth")->where($where2)->select();
        }



        //获取当前用户所有的未读邮件的总数
        $where=array(
            "receiver_id"=>session("oa_user_id"),
            "is_read"=>0
        );
        $count=D('Email')->where($where)->count();




        $this->assign("one_auth",$one_auth);
        $this->assign("two_auth",$two_auth);
        $this->assign('count',$count);
        $this->display();
    }

    public function home(){

        //获取最新的五条公文信息
        $doc=D('Doc')
            ->order('id desc')
            ->limit('0,5')
            ->select();

        //获取当天未读邮件数量
        $where=array(
            "receiver_id"=>session("oa_user_id"),
            'is_read'=>0,
            'UNIX_TIMESTAMP(send_time)'=>array('gt',strtotime("today"))
        );
        $email_num=D('Email')->where($where)->count();


        //获取当天未读邮件信息
        $where=array(
            "receiver_id"=>session("oa_user_id"),
            'is_read'=>0,
            'UNIX_TIMESTAMP(send_time)'=>array('gt',strtotime("today"))
        );
        $email=D('Email')
            ->field("t1.*,t2.username")
            ->join("t1 left join oa_user as t2 on t1.send_id=t2.id")
            ->limit("0,5")
            ->order('id desc')
            ->where($where)
            ->select();

        $_email=array();
        //将邮件的发送时间转换成时间戳
        foreach ($email as $k=>$v) {
            $_email[$k]=$v;
            $_email[$k]['send_time']=date("H:i:s",strtotime($v['send_time']));

        }


        $this->assign('email',$_email);
        $this->assign('email_num',$email_num);
        $this->assign('doc',$doc);
        $this->display();
    }

    //获取当前用户所有未读邮件的数量
    public function getEmailNum(){
        //判断是不是ajax传值
        if(IS_AJAX){
            //获取数据
            $oldNum=I('post.oldNum');
            $where=array(
                "receiver_id"=>session("oa_user_id"),
                "is_read"=>0
            );
            $newNum=D('Email')->where($where)->count();

            echo ($newNum-$oldNum);
        }
    }

}
