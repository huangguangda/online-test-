<?php
namespace app\index\controller;

use app\student\model\Student;
use app\index\model\AnswerPaper;
use app\admin\model\Paper;
use app\admin\model\Score;
use think\Db;

class IndexController extends CommonController
{

    public function index()
    {
        // 获取用户名
        $userName = session('tester')['userName'];
        $userName = session('tester')['userName'];
        $studentid = session('tester')['studentId'];
        
        // 查询试卷表,如果该生有成绩，就查询出来
        $papers = db('paper')->select();
        // 查询试卷表,如果该生有成绩，就查询出来
        for ($i = 0; $i < count($papers); $i ++) {
            $score = Score::get([
                'paper_id' => $papers[$i]['id'],
                'studentid' => $studentid
            ]);
            $papers[$i]['mark'] = $score['mark'];
        }
        
        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('result', $papers);
        return view();
    }

    public function test()
    {
        // 变量初始化
        $paperId = input("test_paper_id");
        $studentid = session('tester')['studentId'];
        // 是否已有个人试卷
        $whereFindPaper = [
            'studentid' => $studentid,
            'paper_id' => $paperId
        ];
        if (! AnswerPaper::where($whereFindPaper)->value('id')) {
            // ======================================================
            // 创建试卷
            // ======================================================
            $studentid = session('tester')['studentId'];
            // 将试卷的内容写入答题卷
            $paper = Paper::get($paperId);
            // 查询选择题内容
            $content = $paper['content'];
            $questionNo = explode(',', $content);
            $answerNull = serialize([
                'a' => 0
            ]);
            // 写入空卷
            foreach ($questionNo as $no) {
                $data = [
                    'studentid' => $studentid,
                    'paper_id' => $paperId,
                    'select_question_id' => $no,
                    'answer' => ""
                ];
                $answerPaper = new AnswerPaper();
                $answerPaper->save($data);
            }
        }
        // ======================================================
        // 开始考试
        // ======================================================
        // 查询试卷
        $paper = Paper::get($paperId);
        $content = $paper['content'];
        $questionNo = explode(',', $content);
        // 查询题目及选项状态
        $query = "select select_question_id,type,title,answer 
        from select_question,answer_paper where select_question.id = answer_paper.select_question_id 
        and answer_paper.paper_id= $paperId and select_question.id in($content)";
        $result = Db::query($query);
        // 在选项表中查询选项内容
        for ($i = 0; $i < count($result); $i ++) {
            $result[$i]['answer'] = unserialize($result[$i]['answer']);
            $sql = "select id,select_item.content from select_item where select_question_id = ?";
            $result[$i]['items'] = Db::query($sql, [
                $result[$i]['select_question_id']
            ]);
        }
        
        // 传递参数
        $this->assign("selectQuestion", $result);
        // 获取用户名
        $userName = session('tester')['userName'];
        $this->assign('userName', $userName);
        $this->assign('paperId', $paperId);
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
            $this->success("修改成功！！！", url('index/index'));
        } else {
            $this->success("修改失败！！！", url('index/index'));
        }
    }

    public function insert()
    {
        // 表单处理
        if (request()->isPost()) {
            // 取出数据
            $answer['studentid'] = session('tester')['studentId'];
            $answer['paper_id'] = input('paperId');
            $answer['select_question_id'] = input('selectQuestionId');
            $select_status = input('selectStatus') == 'true' ? 1 : 0;
            $where = [
                'studentid' => $answer['studentid'],
                'paper_id' => $answer['paper_id'],
                'select_question_id' => $answer['select_question_id']
            ];
            $oldAnswerPaper = AnswerPaper::get($where);
            $oldAnswer = unserialize($oldAnswerPaper['answer']);
            if ('单' == input('type')) {
                if (is_array($oldAnswer)) {
                    foreach ($oldAnswer as $key => $value) {
                        $oldAnswer[$key] = 0;
                    }
                }
                $oldAnswer[input('itemid')] = 1;
            } else {
                $oldAnswer[input('itemid')] = $select_status;
            }
            $answer['answer'] = serialize($oldAnswer);
            $answerPaper = new AnswerPaper();
            $result = $answerPaper->save($answer, $where);
            $data = [
                'selectQuestionId' => input('selectQuestionId')
            ];
            return json($data);
        }
    }

    public function gameOver()
    {
        // 评分
        // 变量初始化
        $paperId = input("test_paper_id");
        $studentid = session('tester')['studentId'];
        // 是否已有个人试卷
        $whereFindPaper = [
            'studentid' => $studentid,
            'paper_id' => $paperId
        ];
        $answerPaper = db('AnswerPaper')->where($whereFindPaper)->select();
        $a = [];
        $b = [];
        foreach ($answerPaper as $value) {
            $atest = unserialize($value['answer']);
            foreach ($atest as $atestkey => $atestvalue) {
                $a[$atestkey] = $atestvalue;
            }
            $b[] = $value['select_question_id'];
        }
        // 查询所有答案
        $resultStandAnswer = db('select_item')->where('select_question_id', 'in', $b)->select();
        foreach ($resultStandAnswer as $value) {
            $standA[$value['select_question_id']][$value['id']] = $value['isanswer'];
        }
        $countCorrectNumber = 0;
        foreach ($standA as $key1 => $standValue) {
            // 批改一题
            $answerCorrect = true;
            foreach ($standValue as $itemid => $value2) {
                if (isset($a[$itemid])) {
                    echo $value2 . " " . $a[$itemid] . "<br/>";
                    if ($a[$itemid] != $value2) {
                        $answerCorrect = false;
                        break;
                    }
                } else {
                    if ($value2 != 0) {
                        $answerCorrect = false;
                        break;
                    }
                }
            }
            if ($answerCorrect) {
                $countCorrectNumber ++;
            }
        }
        // 记分
        // 查询试卷
        $paper = Paper::get($paperId);
        $scoreRecord = [
            'studentId' => $studentid,
            'test_name' => $paper['name'],
            'subject' => $paper['subject'],
            'paper_id' => $paperId,
            'mark' => $countCorrectNumber
        ];
        $score = new Score();
        $scoreFind = [
            'studentId' => $studentid,
            'paper_id' => $paperId
        ];
        
        $fandScore = $score->where($scoreFind)->value('id');
        if ($fandScore) {
            $score->save($scoreRecord, $scoreFind);
        } else {
            $score->save($scoreRecord);
        }
        $this->redirect('index');
    }
}
?>