<?php
namespace Admin\Controller;
class DocController extends CommonController{

    //添加公文
    public function add(){
        //判断是否表单传值、
        if(IS_POST){
            $this->_add();
            die;
        }

        $this->display();
    }

    public function _add(){
        $data=I('post.');
        $data['add_time']=date("Y-m-d");
        $data['author_id']=session("oa_user_id");

        //判断是否有文件上传
        if($_FILES['file']['error']==0){

            //获取的文件上传的存储路径
            $filepath="Docfile";
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
        if(D("Doc")->add($data)){
            $this->success("公文发布成功",U("index"));
        }else{
            $this->error("公文发布失败");
        }


    }

    //公文列表
    public function index(){

        if(I('get.id')){
            $this->assign('id',I('get.id'));
            $this->display('content');
            die;
        }

        //获取登录用户的权限
        $three_auth=$this->auth_ids("Doc");

        //获取员工总数
        $count=D('Doc')->count();

        //实例化一个分页类
        $page=new \Think\Page($count,C("doc_pagesize"));

        //取出所有的公文信息
        $data=D("Doc")
            ->field("t1.*,t2.username")
            ->order("id desc")
            ->join("t1 left join oa_user as t2 on t1.author_id=t2.id")
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

    //附件下载
    public function down($id){
        //取出附件的目录
        $file=D("Doc")->where(array("id"=>$id))->getField("file");

        if(!empty($file)){
            $path="./Uploads/Docfile/".$file;

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

    //获取公文内容
    public function getDocContent(){
        //判断是否是ajax传值
        if(IS_AJAX){
            $id=I("post.id");
            //获取响相应的公文内容
            $content=D("Doc")->where(array("id"=>$id))->getField("content");

            //对内容里面的标签进行解码
            $content=htmlspecialchars_decode($content);

            echo $content;

        }
    }

    //编辑公文
    public function edit($id){

        if(IS_POST){
            $this->_edit();
            die;
        }

        //获取当前公文的信息
        $doc=D("Doc")
            ->field("t1.*,t2.username")
            ->join("t1 left join oa_user as t2 on t1.author_id=t2.id")
            ->where(array("t1.id"=>$id))
            ->find();

        $doc['content']=htmlspecialchars_decode($doc['content']);

        $this->assign('doc',$doc);
        $this->display();
    }

    public function _edit(){
        //接受数据
        $data=I("post.");

        //判断是否有文件上传
        if($_FILES['file']['error']==0){

            //获取的文件上传的存储路径
            $filepath="Docfile";
            //设置上传文件的上传格式
            $filetype=array('png','jpg','txt','zip','rar','docx','xlsx'
            );
            //调用文件上传方法
            $file=$this->uploads($filepath,$filetype);
            //将文件上传路径提取出来
            $data['file']=$file['file']['savepath'].$file['file']['savename'];


            if($data['oldFile']!=""){
                //更改公文附件后将旧的附件删除
                unlink("./Uploads/Docfile/".$data['oldFile']);
            }

        }else{
            $data['file']=$data["oldFile"];
        }



        //将数据存入数据库
        if(D('Doc')->save($data)>0){
            $this->success('公文修改成功！',U("index"));
        }elseif(D('Doc')->save($data)==0){
            $this->success('公文未修改',U("index"));
        }else{
            $this->error('公文修改失败 ！');
        }

    }

    //删除公文
    public function del($id,$file){

        //先判断是否有附件
        if(!empty($file)){
            //将附件删除
            unlink("./Uploads/Docfile/".$file);
        }

        //将相对应的职员信息删除
        if(D("Doc")->delete($id)){
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