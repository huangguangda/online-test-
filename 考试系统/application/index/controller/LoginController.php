<?php
namespace app\index\controller;

use think\Controller;
use app\admin\model\Student;

class LoginController extends Controller
{

    public function index()
    {
        return view();
    }

    public function loginDo()
    {
        if (!request()->isPost()) {
            $this->redirect("index");
        } else {
            if (session('tester')) {
                session(null);
            }
            $studentId = $_POST['studentId'];
            $password = $_POST['password'];
            // 计算摘要
            $password2 = sha1($password);            
            $student = new Student();
            // 根据用户名和密码去查询帐号表
            $data = array(
                'studentId' => $studentId,
                'password' => $password2
            );
            // 返回单记录，或者为空
            $result = $student->get($data);
            if ($result) {
                // 使用 authority 保存用户和权限信息
                $tester = array(
                    'studentId' => $studentId,
                    'userName' => $result['name'],
                    'role' => 'student'
                );
                session('tester', $tester);
                $this->success('登录成功', url("index/index"));
            } else {
                $this->error('登录失败,用户名或密码错误!', url("login/index"));
            }
        }
    }

    public function loginout()
    {
        session(null);
        $this->success('退出成功', url("login/index"));
    }
}

?>