<?php
namespace app\index\controller;
use think\Controller;

class CommonController extends Controller
{
    public function _initialize(){
        if(!session('tester')){
            $this->error("请先登录",url("login/index"));
        }
    }
}
?>