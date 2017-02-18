<?php
namespace Admin\Controller;


class EmailController extends CommonController{
    //创建一个发送邮件的方法
    public function send(){
        //判断是否是POST传值
        if(IS_POST){
            $this->_send();
            die;
        }
        $this->display();
    }

    //创建_send方法处理表单接受的数据
    public function _send(){

       $data=I("post.");
       $data['send_time']=date("Y-m-d H:i:s");
       $data['send_id']=session("oa_user_id");
       $data['is_read']=0;

        //判断是否有文件上传
        if($_FILES['file']['error']==0){

            //获取的文件上传的存储路径
            $filepath="EmailFile";
            //设置上传文件的上传格式
            $filetype=array('gif', 'jpg', 'jpeg', 'png', 'bmp','swf', 'flv','mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb','doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'
            );
            //调用文件上传方法
            $file=$this->uploads($filepath,$filetype);
            //将文件上传路径提取出来
            $data['file']=$file['file']['savepath'].$file['file']['savename'];
        }else{
            $data['file']="";
        }


        //将数据存入数据库
        if(D("Email")->add($data)){
            $this->success('发送成功',"receiver");
        }else{
            $this->error("发送失败");
        }

    }

    //创建一个验证收件人是否存在的方法
    public function checkEmailUser(){
        //判断是否是ajax传值
        if(IS_AJAX){
            //接受数据
            $receiver_name=I("post.receiver_name");

            //判断是否存在收件人
            $where=array(
                "username"=>$receiver_name
            );
            //调用模型进行查询
            $data=D("User")->field("id")->where($where)->find();

            if($data){
                $data['error']=0;
                echo json_encode($data);
            }else{
                echo json_encode(array("error"=>1));
            }
        }
    }

    //创建一个方法用于模糊查询收件人
    public function getEmailUser(){
        //判断是否ajax传值
        if(IS_AJAX){
            //获取用户名的值
            $receiver_name=I("post.receiver_name");
            //调用模型进行模糊查询
            $where=array(
                "username"=>array(
                    "like","$receiver_name%"
                )
            );
            $data=D('User')->field("username,id")->where($where)->select();
            if($data){
                $data['error']=0;
                echo json_encode($data);
            }else{
                $data['error']=1;
                echo json_encode($data);
            }
        }
    }

    //创建一个收件箱的方法
    public function receiver(){
        //判断是否有get传值
        if(I('get.id')){

            $this->assign('id',I('get.id'));
            $this->assign('is_read',I('get.is_read'));
            $this->display('content');
            die;
        }

        //获取当前用户的权限
        $three_auth=$this->auth_ids("Email");


        //获取当前用户的所有邮件信息
        $where=array(
            "receiver_id"=>session("oa_user_id"),
            "is_read"=>array("neq",2)
        );

        //获取当前用户的邮件总数
        $count=D('Email')
            ->where($where)
            ->count();

        //实例化一个分页类
        $page=new \Think\Page($count,C("email_pagesize"));

        $data=D('Email')
            ->field("t1.*,t2.username as send_name")
            ->join("t1 left join oa_user as t2 on t1.send_id=t2.id")
            ->where($where)
            ->order("id desc")
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
        $this->assign("data",$data);
        $this->display();
    }

    //附件下载
    public function down($id){
        //取出附件的目录
        $file=D("Email")->where(array("id"=>$id))->getField("file");

        if(!empty($file)){
            $path="./Uploads/EmailFile/".$file;

            //下载文件
            header("Content-type:application/octet-stream");//流文件

            //函数basename()是获取函数的名称
            header('Content-Disposition:attachment;filename="'.basename($path).'"');
            //函数filesize()获取文件的大小
            header("Content-Length:".filesize($path));

            //函数readfile()读取文件的内容
            header($path);
        }
    }

    //通过邮件id获取邮件内容
    public function getEmailContent(){
        //判断是不是ajax传值
        if(IS_AJAX){
            //获取数据
            $id=I('post.id');
            $is_read=I("post.is_read");


            if($is_read==0){
                $data=array(
                    "id"=>$id,
                    "is_read"=>1
                );
                D("Email")->save($data);
            }

            $where=array(
                "id"=>$id
            );

            $data=D("Email")->where($where)->getField('content');
            $data=htmlspecialchars_decode($data);
            echo $data;

        }
    }

    //删除邮件
    public function del(){
        //接受数据
        $data['id']=I("get.id");
        $data['is_read']=2;
        //将相对应的邮件状态改成2

        if(D("Email")->save($data)){
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

    //回复邮件
    public function reply($id){


        //获取当前邮件的信息
        $data=D("Email")
            ->field("t1.*,t2.username")
            ->join("t1 left join oa_user as t2 on t1.send_id=t2.id")
            ->where(array("t1.id"=>$id))
            ->find();

        $this->assign('data',$data);
        $this->display();
    }

    //垃圾箱
    public function dustbin(){
        //设置权限层级
        $this->level=3;

        //获取当前用户的权限
        $three_auth=$this->auth_ids("Email");

        //获取当前用户的所有邮件信息
        $where=array(
            "receiver_id"=>session("oa_user_id"),
            "is_read"=>array("eq",2)
        );

        //获取当前用户的邮件总数
        $count=D('Email')
            ->where($where)
            ->count();

        //实例化一个分页类
        $page=new \Think\Page($count,C("email_pagesize"));

        $data=D('Email')
            ->field("t1.*,t2.username as send_name")
            ->join("t1 left join oa_user as t2 on t1.send_id=t2.id")
            ->where($where)
            ->order("id desc")
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
        $this->assign("data",$data);
        $this->display();
    }

    //邮件彻底删除
    public function truedel($id,$file){
        //先判断是否有附件
        if(!empty($file)){
            //首先先将附件删除了
            unlink("./Uploads/EmailFile/".$file);
        }

        //将相对应的邮件信息删除
        if(D("Email")->delete($id)){
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

    //邮件还原
    public function restore(){
        //将相对应的邮件的状态改成1
        //接受数据
        $data['id']=I("get.id");
        $data['is_read']=1;


        if(D("Email")->save($data)){
            echo json_encode(array(
                "error"=>0,
                "info"=>"还原成功！"
            ));
        }else{
            echo json_encode(array(
                "error"=>1,
                "info"=>"还原失败！"
            ));
        }

    }

}