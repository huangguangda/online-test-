<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\User;

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
            if (session('authority')) {
                session(null);
            }
            $username = $_POST['username'];
            $passcode = $_POST['passcode'];
            // 计算摘要
            $password2 = sha1($passcode);
            
            $user = new User();
            // 根据用户名和密码去查询帐号表
            $data = array(
                'username' => $username,
                'password' => $password2
            );
            // 返回单记录，或者为空
            $result = $user->get($data);
            if ($result) {
                // 使用 authority 保存用户和权限信息
                $authority = array(
                    'userName' => $username,
                    'role' => 'manager'
                );
                session('authority', $authority);
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