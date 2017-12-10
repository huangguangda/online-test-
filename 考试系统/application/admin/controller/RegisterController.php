<?php
namespace app\admin\controller;
use app\admin\model\User;


class RegisterController extends CommonController
{

    public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'register');
        return view();
    }
    
    public function edit(){
        if(request()->isPost()){
            $password = sha1(input('password'));
            $user = new User();
            $userName = session('authority')['userName'];
            $result = $user->save(['password'=>$password],['username'=>$userName]);
            if($result){
                $this->success("密码修改成功！",url('login/loginout'));
            }else{
                $this->success("密码修改失败！",url('index/index'));
            }
        }else{
            // 获取用户名
            $userName = session('authority')['userName'];
            $this->assign('userName', $userName);
            $this->assign('menuName', 'register');
            return view();
        }
    }
}
?>