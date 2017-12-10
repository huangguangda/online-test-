<?php
namespace app\admin\controller;

use app\admin\model\Paper;
use app\admin\model\SelectQuestion;

class PaperController extends CommonController
{

    public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询试卷表
        $paper = new Paper();
        $result = $paper->all();
        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('menuName', 'paper');
        $this->assign('result', $result);
        return view();
    }

    public function edit()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'paper');
        // 学生信息
        $id = input('id');
        // 根据用户名和密码去查询帐号表
        $score = new Paper();
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
        $score = new Paper();
        $res = $score->save($data, array(
            'id' => $data['id']
        ));
        if ($res > 0) {
            $this->success("修改成功！！！", url('paper/index'));
        } else {
            $this->success("修改失败！！！", url('paper/index'));
        }
    }

    public function delete()
    {
        $id = input('id');
        $paper = new Paper();
        $res = $paper->destroy($id);
        if ($res > 0) {
            $this->success("删除成功！！！", url('paper/index'));
        } else {
            $this->success("删除失败！！！", url('paper/index'));
        }
    }

    public function insert()
    {
        // 表单处理
        if (request()->isPost()) {
            // 取出数据
            $data = input('post.');
            //查询所有的题号
            $selectQuestion = new SelectQuestion;
            $questionNo = $selectQuestion->where(['subject'=>$data['subject']])->column('id');
            $content = '';
            for($i=0;$i<$data['total']-1;$i++){
                $content .= $questionNo[rand(0,count($questionNo)-1)].',';
            }
            $content .= $questionNo[rand(0,count($questionNo)-1)];
            $data['content'] = $content;
            $paper = new Paper();
            $result = $paper->allowField(true)->save($data);
            if ($result) {
                $this->success("数据保存成功！", url('paper/index'));
            } else {
                $this->success("数据保存失败！", url('paper/index'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'paper');
        return view();
    }
}

?>