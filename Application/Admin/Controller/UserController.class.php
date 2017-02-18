<?php
namespace Admin\Controller;

class UserController extends CommonController
{

    public function index(){
        //获取当前用户的权限
        $three_auth=$this->auth_ids("User");

        $where=array(
            "role_id"=>array('neq',1)
        );
        //获取员工总数
        $count=D('User')->field("u.*,d.name as dept_name")
            ->where($where)
            ->join("u left join oa_dept as d on u.dept_id=d.id")
            ->count();

        //实例化一个分页类
        $page=new \Think\Page($count,C("user_pagesize"));

        //获取所有的员工信息
        $data=D('User')->field("u.*,d.name as dept_name")
            ->where($where)
            ->join("u left join oa_dept as d on u.dept_id=d.id")
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

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

    public function add(){
        //判断是否是POST传值
        if(IS_POST){
            $this->_add();
            die;
        }

        //获取所有的部门分类
        //先加载无限极分类方法
        load("@/getDeptSons");
        $depts=D("Dept")->select();
        $depts=getDeptSons($depts);



        //获取所有的角色信息
        //先清空无限极方法里面的数组

        $roles=M("Role")->select();

        $this->assign("roles",$roles);
        $this->assign("depts",$depts);
        $this->display();
    }

    public function _add(){
        //设置默认的字段值
        $data=I("post.");
        $data['add_time']=date("Y-m-d");
        $data['password']=md5(md5(C('default_pass')).C('salt'));

        //判断是否有文件上传
        if($_FILES['photo']['error']==0){


            $filetype = array('jpg',  'png', 'jpeg');// 设置附件上传类型
            $filepath= 'Photo'; // 设置附件上传根目录

            $upload=$this->uploads($filepath,$filetype);
            $data['photo']=$upload['photo']['savepath'].$upload['photo']['savename'];

            //创建图片的缩略图
            //1,实例化对象
            $image=new \Think\Image();
            //2,打开对应的图片
            $image->open("./Uploads/Photo/".$data['photo']);
            //3,按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
            $thumb_path=$upload['photo']['savepath']."thumb_".$upload['photo']['savename'];
            $image->thumb(60,60,2)->save("./Uploads/Photo/".$thumb_path);


            //将原图和缩略图的路径通过Json字符串的方式存入数据库中
            $data['photo'].= ",".$thumb_path;

        }else{
            $data['photo']="";
        }

        //验证表单的合法性和合理性
        if(!D('User')->create()){
            $this->error(D('User')->getError());
        }else{
            //将数据存入数据库
            if(D('User')->add($data)){
                $this->success('信息登记成功！',U("index"));
            }else{
                $this->error('信息登记失败！');
            }
        }


    }

    public function del($id,$photo){

        //先判断是否有头像图片
        if(!empty($photo)){
            //首先先将头像删除了
            $photo=explode(",",$photo);
            $image=$photo[0];
            $thumb_image=$photo[1];
            unlink("./Uploads/Photo/".$image);
            unlink("./Uploads/Photo/".$thumb_image);
        }

        //将相对应的职员信息删除
        if(D("User")->delete($id)){
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

    public function edit($id){
        //判断是否是POST传值
        if(IS_POST){
            $this->_edit();
            die;
        }

        //获取当前职员的个人信息
        $data=D('User')->find($id);
        if(empty($data['photo'])){
            $data['photo']="";
        }else{
            $photo=explode(",",$data['photo']);
            $data['photo1']="/Uploads/Photo/".$photo[0];
        }


        //获取所有的部门分类
        //先加载无限极分类方法
        load("@/getDeptSons");
        $depts=D("Dept")->select();
        $depts=getDeptSons($depts);

        //获取所有的角色信息
        //先清空无限极方法里面的数组

        $roles=M("Role")->select();

        $this->assign("roles",$roles);
        $this->assign('data',$data);
        $this->assign("depts",$depts);
        $this->display();
    }

    public function _edit(){

        $data=I("post.");

        //判断是否有文件上传
        if($_FILES['photo']['error']==0){

            //判断是否有头像
            if($data["photo"]!=""){
                $photo=explode(",",$data["photo"]);

                //将旧图片删除
                unlink("./Uploads/Photo/".$photo[0]);
                unlink("./Uploads/Photo/".$photo[1]);
            }

            $filetype = array('jpg',  'png', 'jpeg');// 设置附件上传类型
            $filepath= 'Photo'; // 设置附件上传根目录

            $upload=$this->uploads($filepath,$filetype);
            $data['photo']=$upload['photo']['savepath'].$upload['photo']['savename'];



            //创建图片的缩略图
            //1,实例化对象
            $image=new \Think\Image();
            //2,打开对应的图片
            $image->open("./Uploads/Photo/".$data['photo']);
            //3,按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
            $thumb_path=$upload['photo']['savepath']."thumb_".$upload['photo']['savename'];
            $image->thumb(60,60,2)->save("./Uploads/Photo/".$thumb_path);


            //将原图和缩略图的路径通过Json字符串的方式存入数据库中
            $data['photo'].= ",".$thumb_path;

        }

        //判断有没有修改密码
        if(!empty($data['newpassword']) && !empty($data['repassword'])){
            $data['password']=md5(md5($data['newpassword']).C('salt'));

        }


        //验证表单的合法性和合理性
        if(!D('User')->create()){
            $this->error(D('User')->getError());
        }else{
            //将数据存入数据库
            if(D('User')->save($data)>0){
                $this->success('信息修改成功！',U("index"));
            }elseif(D('User')->save($data)==0){
                $this->success('信息未修改',U("index"));
            }else{
                $this->error('信息修改失败 ！');
            }
        }
    }

}