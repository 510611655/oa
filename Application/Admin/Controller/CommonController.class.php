<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{

protected $level=2;

   public function _initialize(){

       //判断是否存在session值
       if(!session("?oa_user_id")){
           //判断用户有没有设置cookie值
           if(cookie("user_id")){

               //对cookie存的ID进行验证
               $user=D("User")->find(cookie("user_id"));

               //将用户的信息存入SESSION值
               session("oa_user_id",$user['id']);
               session("oa_role_id",$user['role_id']);
               session("oa_username",$user['username']);
               $this->redirect("Admin/index/index");

           }

            $this->redirect("Admin/Login/login");
       }else{
           $role_id=session("oa_role_id");
           //取出当前用户的权限
           $auth_ids=M("Role")->where("id=".$role_id)->getField("auth_ids");

           if($auth_ids!="*"){
               $auth_ids=explode(",",$auth_ids);

               //当前访问的控制器
               $now_con=strtolower(MODULE_NAME)."/".strtolower(CONTROLLER_NAME)."/".strtolower(ACTION_NAME);

               //要放行的权限、
               $mca=array(
                   "admin/dept/getdeptnum",
                   "admin/index/index",
                   "admin/index/getemailnum",
                   "admin/doc/down",
                   "admin/doc/getdoccontent",
                   "admin/email/checkemailuser",
                   "admin/email/getemailuser",
                   "admin/email/down",
                   "admin/email/getemailcontent",
               );

               //调用权限验证方法
               $auth_id=$this->checkAuth();
               //判断用户权限
               if(!in_array($auth_id,$auth_ids) && !in_array($now_con,$mca)){
                   $this->error("发生未知错误",U("Admin/index/index"));
               }
           }

       }
   }


   //权限验证方法
    public function checkAuth(){
       $where=array(
           "m_name"=>strtolower(MODULE_NAME),
           "c_name"=>strtolower(CONTROLLER_NAME),
           "a_name"=>strtolower(ACTION_NAME)
       );
       //获取当前权限ID
        return M("Auth")->where($where)->getField("id");

    }

   //公共文件上传方法
    public function uploads($filepath,$filetype=array(),$filesize=3145728){
        //1，首先先实例化一个文件上传类
        $upload = new \Think\Upload();// 实例化上传类
        //2，设置文件上传的必要参数
        $upload->maxSize =$filesize;// 设置附件上传大小
        $upload->exts = $filetype;// 设置附件上传类型
        $upload->rootPath = './Uploads/'.$filepath.'/'; // 设置附件上传根目录


        if(!is_dir('./Uploads/'.$filepath.'/')){
            mkdir('./Uploads/'.$filepath.'/');
        }

        //上传文件
        $info=$upload->upload();

        //判断文件是否上传成功
        if(!$info){
            $this->error($upload->getError());
        }else{
            return $info;
        }
    }

    //获取登录角色的控制权限
    public function auth_ids($c_name=""){

        $auth_ids=M('Role')->where(array("id"=>session("oa_role_id")))->getField("auth_ids");

        //如果是超级管理员就开放所有权限
        if($auth_ids=="*"){
            //组装where判断语句
            $where=array(
                "level"=>$this->level,
                "c_name"=>$c_name
            );

            $three_auth=M("Auth")->field("*,right(name,2) as s_name")->where($where)->select();

            return $three_auth;


        }else{
            //组装where判断语句
            $where=array(
                "id"=>array("in",$auth_ids),
                "level"=>$this->level,
                "c_name"=>$c_name
            );
            //right()函数，获取字符从右到左两位字符
            $three_auth=M("Auth")->field("*,right(name,2) as s_name")->where($where)->select();

            return $three_auth;
        }

    }
}