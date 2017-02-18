<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{


    public function login(){


        $this->display();
    }

    public function verify(){

        //设置验证码配置
        $config=array(
            "length"=>3,
            "useCurve"=>false,
            "useNoise"=>false,
            "bg"=>array(90,202,27)

        );

        //生成验证码
        $verify=new \Think\Verify($config);
        $verify->entry();
    }

    public function checkVerify(){

        //判断是否表单传值
        if(IS_POST){
            //首先验证验证码是否正确
            $code=I("post.code");

            $verify=new \Think\Verify();


            if(!$verify->check($code)){
                $this->error("验证码不正确","login");
            }

            $password=md5(md5(I("post.password")).C('salt'));

            //验证有户名和密码是否正确
            $where=array(
                "username"=>I('post.username'),
                "password"=>$password
            );

            $user=D('User')
                ->field("t1.*,t2.id as role_id")
                ->where($where)
                ->join("t1 left join oa_role as t2 on t1.role_id=t2.id")
                ->find();
            if(!$user){
                $this->error("用户名不存在或者密码不匹配","login");
            }

            //将数据存入session中
            session("oa_username",$user['username']);
            session("oa_user_id",$user['id']);
            session("oa_role_id",$user['role_id']);


            //判断用户是否有记住密码
            if(I("post.remember")=="on"){
                cookie("user_id",$user['id'],3600*24*7);
            }else{
                cookie("user_id",null);
            }
            $this->redirect("Admin/index/index");


        }
    }

    public function logout(){
        //删除用户的session信息
        session("oa_username",null);
        session("oa_user_id",null);
        session("oa_role_id",null);
        cookie("user_id",null);

        $this->success("退出成功",U("login"),3);

    }

}