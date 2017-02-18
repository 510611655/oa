<?php
namespace Admin\Controller;

class RoleController extends CommonController{
    //角色列表
    public function index(){
        //获取登录用户的权限
        $three_auth=$this->auth_ids("Role");

        //获取员工总数
        $count=M("Role")->where(array("id"=>array("neq",1)))->count();

        //实例化一个分页类
        $page=new \Think\Page($count,C("role_pagesize"));

        //获取所有的角色信息除了超级管理员的信息除外
        $data=M("Role")->where(array("id"=>array("neq",1)))->limit($page->firstRow.','.$page->listRows)->select();

        //设置分页的样式
        $page->setconfig('header','<div class="pxofy">总共<b>%TOTAL_ROW%</b>条记录</div>');
        $page->setconfig('prev','上一页');
        $page->setconfig('next','下一页');
        $page->setconfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $page->rollPage=5;
        //显示分页
        $pages=$page->show();

        $this->assign('three_auth',$three_auth);
        $this->assign('pages',$pages);
        $this->assign('data',$data);
        $this->display();
    }

    //分配权限
    public function allocation($id){
        //判断是否表单传值
        if(IS_POST){
            $this->_allocation();
            die;
        }


        //获取相对应的角色信息
        $roles=M("Role")->find($id);

        //获取所有的权限信息
        //获取一级权限
        $one_auth=M("Auth")->field("name,id,pid")->where(array("level"=>0))->select();
        //获取二级权限
        $two_auth=M("Auth")->field("name,id,pid")->where(array("level"=>1))->select();
        //获取三级权限
        $three_auth=M("Auth")->field("name,id,pid")->where(array("level"=>array("in","2,3")))->select();

        $this->assign("one_auth",$one_auth);
        $this->assign("two_auth",$two_auth);
        $this->assign("three_auth",$three_auth);
        $this->assign("roles",$roles);
        $this->display();
    }

    public function _allocation(){
        //接受数据
        $auth_ids=I("post.ids");
        $data['id']=I("post.id");

        //将auth_ids转换成字符串
        $data['auth_ids']=implode(",",$auth_ids);

        if(M("Role")->save($data)){
            $this->success('分配成功',"index");
        }else{
            $this->error("分配失败");
        }

    }

    //添加角色
    public function add(){
//判断是否表单传值
        if(IS_POST){
            $this->_add();
            die;
        }


        //获取所有的权限信息
        //获取一级权限
        $one_auth=M("Auth")->field("name,id,pid")->where(array("level"=>0))->select();
        //获取二级权限
        $two_auth=M("Auth")->field("name,id,pid")->where(array("level"=>1))->select();
        //获取三级权限
        $three_auth=M("Auth")->field("name,id,pid")->where(array("level"=>array("in","2,3")))->select();

        $this->assign("one_auth",$one_auth);
        $this->assign("two_auth",$two_auth);
        $this->assign("three_auth",$three_auth);
        $this->display();
    }

    public function _add(){
        //接受数据
        $data=I("post.");
        $data["auth_ids"]=implode(",",$data["auth_ids"]);



        if(M("Role")->add($data)){
            $this->success("添加成功","index");
        }else{
            $this->error("添加失败");
        }

    }

    //删除公文
    public function del($id){

        //将相对应的角色信息删除
        if(D("Role")->delete($id)){
            echo json_encode(array(
                "error"=>0,
                "info"=>"删除成功！"
            ));
        }else{
            echo json_encode(array(
                "error"=>1,
                "info"=>"删除失败！"
            ));
        }

    }
}