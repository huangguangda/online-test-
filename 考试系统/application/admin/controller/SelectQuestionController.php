<?php
namespace app\admin\controller;

use app\admin\model\SelectQuestion;
use app\admin\validate\SelectValidate;
use app\admin\model\SelectItem;
use think\Db;

class SelectQuestionController extends CommonController
{

    public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询学生表
        $selectModel = new SelectQuestion();
        $result = $selectModel->all();
        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('menuName', 'select_question');
        $this->assign('result', $result);
        return view();
    }

    public function edit()
    {
        if (request()->isPost()) {
            // 取出数据
            $data = input('post.');
            $data['type'] = isset($data['answer1']) + isset($data['answer2']) + isset($data['answer3']) + isset($data['answer4']);
            // 使用验证器类完成有效性校验
            $validate = new SelectValidate();
            if (! $validate->check($data)) {
                $this->error($validate->getError(), url('select_question/insert'));
            }
            $selectq = new SelectQuestion();
            $result = 0;
            // 使用自动完成写入题型type
            $result += $selectq->allowField(true)->save($data, [
                'id' => $data['id']
            ]);
            $selectItem = new SelectItem();
            $result += $selectItem->isUpdate()->save([
                'select_question_id' => $data['id'],
                'isanswer' => isset($data['answer1']),
                'content' => $data['item1'],
                'memo' => ''
            ], [
                'id' => $data['id1']
            ]);
            $selectItem = new SelectItem();
            $result += $selectItem->save([
                'select_question_id' => $data['id'],
                'isanswer' => isset($data['answer2']),
                'content' => $data['item2'],
                'memo' => ''
            ], [
                'id' => $data['id2']
            ]);
            $selectItem = new SelectItem();
            $result += $selectItem->isUpdate()->save([
                'select_question_id' => $data['id'],
                'isanswer' => isset($data['answer3']),
                'content' => $data['item3'],
                'memo' => ''
            ], [
                'id' => $data['id3']
            ]);
            $selectItem = new SelectItem();
            $result += $selectItem->isUpdate()->save([
                'select_question_id' => $data['id'],
                'isanswer' => isset($data['answer4']),
                'content' => $data['item4'],
                'memo' => ''
            ], [
                'id' => $data['id4']
            ]);
            
            if ($result) {
                $this->success("数据保存成功！", url('select_question/index'));
            } else {
                $this->error("数据保存失败！", url('select_question/index'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'select_question');
        $id = input('id');
        $selectQuestion = SelectQuestion::get($id);
        $items = $selectQuestion->items;
        $this->assign('data', $selectQuestion);
        $this->assign('items', $items);
        return view();
    }
    
    // 事务处理
    public function delete()
    {
        $id = input('id');
        Db::startTrans();
        try {
            // 删除选项
            $selectItem = new SelectItem();
            $selectItem->destroy([
                'select_question_id' => $id
            ]);
            // 删除题干
            $selectModel = SelectQuestion::get($id);
            $res = $selectModel->destroy($id);
            Db::commit();
        } catch (\Exception $e) {
            $res = 0;
            // 回滚事务
            Db::rollback();
        }
        if ($res > 0) {
            $this->success("删除成功！！！", url('select_question/index'));
        } else {
            $this->error("删除失败！！！", url('select_question/index'));
        }
    }

    public function insert()
    {
        // 表单处理
        if (request()->isPost()) {
            // 取出数据
            $data = input('post.');
            $data['type'] = isset($data['answer1']) + isset($data['answer2']) + isset($data['answer3']) + isset($data['answer4']);
            // 使用验证器类完成有效性校验
            $validate = new SelectValidate();
            if (! $validate->check($data)) {
                $this->error($validate->getError(), url('select_question/insert'));
            }
            $selectq = new SelectQuestion();
            // 使用自动完成写入题型type
            $result = $selectq->allowField(true)->save($data);
            // 批量增加关联数据
            if ($result) {
                $result2 = $selectq->items()->saveAll([
                    [
                        'isanswer' => isset($data['answer1']),
                        'content' => $data['item1']
                    ],
                    [
                        'isanswer' => isset($data['answer2']),
                        'content' => $data['item2']
                    ],
                    [
                        'isanswer' => isset($data['answer3']),
                        'content' => $data['item3']
                    ],
                    [
                        'isanswer' => isset($data['answer4']),
                        'content' => $data['item4']
                    ]
                ]);
            } else {
                $result2 = false;
            }
            if ($result2) {
                $this->success("数据保存成功！", url('select_question/index'));
            } else {
                $this->error("数据保存失败！", url('select_question/index'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'select_question');
        return view();
        // 或者 return $this->fetch();
    }
}

?>