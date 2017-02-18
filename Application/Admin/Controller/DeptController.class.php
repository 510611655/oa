<?php
namespace Admin\Controller;
class DeptController extends CommonController{

    //增加部门
    public function add(){
        //首先判断是否是POST请求
        //IS_GET  IS_POST  IS_AJAX
        if(IS_POST){
            $this->_add();
            die;
        }

        //取出所有的部门信息
        $depts=D('Dept')->select();
        //将部门信息进行无限极分类
        //先加载无限极分类方法
        load("@/getDeptSons");
        $depts=getDeptSons($depts);


        $this->assign('depts',$depts);
        $this->display();
    }

    //将新增部门信息入库
    public function _add(){
        //自动验证表单数据的合法性以及合理性
        if(!D('Dept')->create()){
            $this->error(D('Dept')->getError());
        }

        //使用I('post.')接受整个表单传过来的值(不包含域名$_FILES)
        $data=I('post.');
        //实例化模型入库操作
        if(D('Dept')->add($data)){
            $this->success('添加成功',U('index'));
        }else{
            $this->error('添加失败',U('add'),1);
        }
    }

    //部门列表
    public function index(){

        //获取当前用户的权限
        $three_auth=$this->auth_ids("Dept");

        //联表查询，将部门信息显示在模版上面
        //TP联表查询的时候，当前模型不需要加表名，只需要指定一个前缀就可以了
        $lists=D('Dept')
            ->field('t1.*,t2.name as pname')
            ->join('t1 left join oa_dept as t2 on t1.pid=t2.id')
            ->select();

        $count=count($lists);


        //将部门信息进行无限极分类
        //先加载无限极分类方法
        load("@/getDeptSons");
        $lists=getDeptSons($lists);

        $this->assign('three_auth',$three_auth);
        $this->assign('count',$count);
        $this->assign('lists',$lists);
        $this->display();
    }

    //删除部门
    //函数的参数名称要和传过来的参数名称一致，就可以直接接受数据了
    public function del($id){

        //如果要删除的部门有下属部门，则不能删除
        if(D("Dept")->where(array("pid"=>$id))->select()){
            echo json_encode(array(
                "error"=>1,
                "info"=>"该部门有下属部门，暂不能删除！"
            ));

            return false;
        }

        //将相对应的部门信息删除
        if(D("Dept")->delete($id)){
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

    //编辑部门
    public function edit(){
        //首先判断是否是POST请求
        //IS_GET  IS_POST  IS_AJAX
        if(IS_POST){
            $this->_edit();
            die;
        }

        //获取要编辑的部门ID
        $id=I('get.id');
        //取出要编辑的部门信息
        $data=D('Dept')->find($id);

        //取出所有的部门信息
        $where=array(
            "id"=>array("neq",$id),
            "pid"=>array("neq",$id)
        );
        $depts=D('Dept')->where($where)->select();
        //将部门信息进行无限极分类
        //先加载无限极分类方法
        load("@/getDeptSons");
        $depts=getDeptSons($depts);

        $this->assign('data',$data);
        $this->assign('depts',$depts);
        $this->display();
    }

    //对编辑的部门数据进行判断
    public function _edit(){
        //对要编辑的字段进行验证
        if(!D('Dept')->create()){
           $this->error(D('Dept')->getError());
        }else{
            //验证成功进行数据的更新
            if(D('Dept')->save()>0){
                $this->success('更新成功!','index');
            }elseif(D('Dept')->save()==0){
                $this->error('没有修改数据','index',1);
            }else{
                $this->error('更新失败!');
            }
        }
    }

    //获取部门人数
    public function getDeptNum(){
        $chart=D("Dept")
            ->field("t1.name,count(t2.id) as num")
            ->group("t1.name")
            ->join("t1 left join oa_user as t2 on t1.id=t2.dept_id")
            ->select();

        echo json_encode($chart);
    }
}