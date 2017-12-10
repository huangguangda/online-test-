<?php
namespace app\admin\controller;
use app\admin\model\Score;
class ScoreController extends CommonController
{
    public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询学生表
        $score = new Score();
        $result = $score->all();
        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('menuName', 'score');
        $this->assign('result', $result);
        return view();
    }

    public function edit()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'score');
        // 学生信息
        $id = input('id');
        // 根据用户名和密码去查询帐号表
        $score = new Score();
        $query = array(
            'id' => $id
        );
        $row = $score->get($query);
        $this->assign('row', $row);
        return view();
    }

    public function editdo()
    {
        $data = input('post.');
        $score = new Score();
        $res = $score->save($data, array(
            'id' => $data['id']
        ));
        if ($res > 0) {
            $this->success("修改成功！！！",url('score/index'));
        } else {
            $this->success("修改失败！！！",url('score/index'));
        }
    }
    
    public function delete()
    {
        $id = input('id');
        $score = new Score();
        $res = $score->destroy($id);
        if ($res > 0) {
            $this->success("删除成功！！！",url('score/index'));
        } else {
            $this->success("删除失败！！！",url('score/index'));
        }
    }
    
    public function insert(){
        //表单处理
        if(request()->isPost()){
            //取出数据
            $data = input('post.');
            $score = new Score();
            $result = $score->allowField(true)->save($data);
            if($result){
                $this->success("数据保存成功！",url('score/index'));
            }else{
               $this->success("数据保存失败！",url('score/index'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'score');
        return view();
        //或者    return $this->fetch();
    }
}

?>