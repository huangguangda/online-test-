<?php
namespace app\admin\controller;

use app\admin\model\Student;

class IndexController extends CommonController
{

    public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询学生表
        $student = new Student();
        $result = $student->all();
        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('menuName', 'index');
        $this->assign('result', $result);
        return view();
    }

    public function edit()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'index');
        // 学生信息
        $id = input('id');
        // 根据用户名和密码去查询帐号表
        $student = new Student();
        $query = array(
            'id' => $id
        );
        $row = $student->get($query);
        $this->assign('row', $row);
        return view();
    }

    public function editdo()
    {
        $data = input('post.');
        $student = new Student();
        $res = $student->save($data, array(
            'id' => $data['id']
        ));
        if ($res > 0) {
            $this->success("修改成功！！！",url('index/index'));
        } else {
            $this->success("修改失败！！！",url('index/index'));
        }
    }
    
    public function delete()
    {
        $id = input('id');
        $student = new Student();
        $res = $student->destroy($id);
        if ($res > 0) {
            $this->success("删除成功！！！",url('index/index'));
        } else {
            $this->success("删除失败！！！",url('index/index'));
        }
    }
    
    public function insert(){
        //表单处理
        if(request()->isPost()){
            //取出数据
            $data = input('post.');
            $student = new Student();
            $result = $student->allowField(true)->save($data);
            if($result){
                $this->success("数据保存成功！",url('index/index'));
            }else{
               $this->success("数据保存失败！",url('index/index'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'index');
        return view();
        //或者    return $this->fetch();
    }
}

?>