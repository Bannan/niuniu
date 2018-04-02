<?php
namespace app\index\controller;


use think\Controller;
use think\Session;
class Common extends Controller
{
    public function __construct()
    {

        if(!Session::get('admin'))
        {
            $this->redirect('Login/index');
        }

        parent::__construct();
        $this->assign('action',request()->action());
    }


}




?>