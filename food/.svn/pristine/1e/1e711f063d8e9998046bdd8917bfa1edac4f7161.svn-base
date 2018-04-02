<?php
namespace app\index\controller;
use think\Controller;
use think\Session;

class login extends Controller
{
    public function index()
    {
        if(input('post.'))
        {
            if(!captcha_check(input('captcha')))
            {
                $this->error('验证码错误！');
            }
            // echo md5('QAZwsx123');
            if($d = db('admin')->where(['pass'=>md5(input('post.pass')),'name'=>input('post.name')])->find())
            {

                Session::set('admin',$d);

                $this->redirect("stock/index");
            }else
            {
                $this->error('账号或者密码错误！');
            }
        }
        return view();
    }
    //简单暴力的退出登录
    public function loginout()
    {
        Session::delete('admin');
        $this->redirect("login/index");
    }



}

?>