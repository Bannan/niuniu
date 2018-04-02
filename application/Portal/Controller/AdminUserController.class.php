<?php

// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------

namespace Portal\Controller;

use Common\Controller\AdminbaseController;

class AdminUserController extends AdminbaseController {

    protected $user_model;
    protected $all_record;

    public $parent_arr = array();
    protected $card; //排单币
    protected $award;

    public function _initialize() {
        parent::_initialize();
        $this->user_model = D("Portal/User");
        $this->all_record = M('AllRecord');

        $this->assign("taxonomys", $this->taxonomys);
    }


    /**
     * 得到父节点
     * @param type $username
     */
    public function getParent1($username) {
        $where['user_login'] = $username;
        $res = $this->user_model->where($where)->field('parent_user')->find();
        if($res){
        $this->parent_arr[]=$res['parent_user'];
            $this->getParent1($res['parent_user']);
        }
    }
    public function getParentId($parrent_arr) {
        $j = count($parrent_arr) - 1;
        foreach ($parrent_arr as $key => $value) {
            $p = $this->getUserDetailByUname($parrent_arr[$j]);
            if ($p) {
                $arr[] = $p['id'];
            }
            $j--;
        }
        $ids_str = implode('-', $arr);
        return $ids_str;
    }
        public function getUserDetailByUname($uname) {
        $res = $this->user_model->where(array('user_login' => $uname))->find();
        return $res;
    }
    public function insertPath() {
        $users = $this->user_model->select();
        foreach ($users as $key => $value) {
            $this->getParent1($value['user_login']);
            $ids = $this->getParentId($this->parent_arr);
            $this->parent_arr = array();
            if ($ids) {
                $path = "0-{$ids}-{$value['id']}";
                $p = $this->getUserDetailByUname($value['parent_user']);
                $parent = $p['id'];
            } else {
                $path = "0-{$value['id']}";
                $parent = 0;
            }
//            dump($path);分两次导入path parent
            $this->user_model->where(array('id' => $value['id']))->save(array('parent' => $parent));
        }
    }


    

    function index() {   
        $count = $this->user_model->count();
        $page = $this->page($count, 20);
        $users = $this->user_model
                ->order(array("id" => "asc"))
                ->limit($page->firstRow, $page->listRows)
                ->select();
        foreach ($users as $key => $value) {
            $parent = $this->getParent($value['parent']);
            if (empty($value['token'])) {
                $users[$key]['token'] = md5($value['id'].time());
                M('user')->where(array('id'=>$value['id']))->save(array('token'=>$users[$key]['token']));
            }
			$jifen = M('user_room')->where(array('uid' => $value['id']))->sum('jifen');
			$users[$key]['jifen'] = $jifen;
        }
		
        $this->assign('users', $users);
        $this->assign("page", $page->show('Admin'));
        $this->display();
    }

    public function soUser() {
        if($_POST){
        $_GET=$_POST;
        }
        $where='1=1';
        // if($_GET[user_login]){
        //     $user= $this->user_model
        //         ->where(array('user_login'=>$_GET[user_login]))->find();
        //     if(!$user){
        //         $where=$where." and user_login LIKE '%".$_GET[user_login]."%'";
        //     }
        //     else{
        //     $where=$where." and (user_login='".$_GET[user_login]."' or parent=".$user[id].") ";
        //     }
        // }
        if($_GET[user_login]){
            $where=$where." and user_login LIKE '%".$_GET[user_login]."%'";
        }
        if($_GET[nickname]){
            $where=$where." and nickname LIKE '%".$_GET[nickname]."%'";
        }
        if($_GET[type]==1){
            $where=$where." and is_grade=1 ";
        }
        if($_GET[type]==2){
            $where=$where." and parent>0 ";
        }
        if($_GET[type]==3){
            $where=$where." and is_grade=0 ";
            $where=$where." and !(parent>0) ";
        }
        $count = $this->user_model->where($where)->count();
        $page = $this->page($count, 20);
        $users = $this->user_model
                ->where($where)
                ->limit($page->firstRow, $page->listRows)
                ->select();
        foreach ($users as $key => $value) {
            $parent = $this->getParent($value['parent']);
            if ($parent) {
                $users[$key]['parent_user'] = $parent['user_login'];
            }
			$jifen = M('user_room')->where(array('uid' => $value['id']))->sum('jifen');
			$users[$key]['jifen'] = $jifen;
        }
        $this->assign('users', $users);
        $this->display('index');
    }
    public function addUser(){
        $this->display();
    }
    public function add_post(){
        $post=I('post.');
        $post['password']=md5($post['password']);
        $post['create_time']=date('Y-m-d H:i:s',time());
        $src=$this->user_model->add($post);
        if($src){
            $this->success('添加成功！');
        }else{
            $this->error('添加失败！');
        }
    }

     function edit() {
        $id = intval(I("get.id"));
        $user = $this->user_model->find($id);
        $parent = $this->user_model->find($user['parent']);
        $user['parent_user'] = $parent['user_login'];
        $this->assign('post', $user);
        $this->display();
    }

    function edit_post() {
        if (IS_POST) {

            $data = I('post.');
            // $password = I('post.user_pass');
            // $two_password = I('post.user_two_pass');
            $user_status = I('post.user_status');
            $user = $this->user_model->where(array('id' => I('post.id')))->find();
            if ($user_status == 0) {
                $data['disable_notice'] = "系统操作";
            }
            if($user['password']!=$data['password']){
                $data['password']=md5($data['password']);
            }
            //如果修改了透视或者修改了到期时间
            if(isset($user['id']))
            {
                if($data['is_grade'] != $user['is_grade']) {
                    $txt = ['关闭透视','开启透视'];
                    $type = 1;
                    $result['content'] = $txt[$data['is_grade']];
                }
                if($data['create_time'] != $user['create_time']){
                    $type = 2;
                    $result['content'] = $data['create_time'];
                    if(isset($txt))
                    {
                        $type = 3;
                        $result['content'] = $txt[$data['is_grade']].'<br>'.$data['create_time'];
                    }
                }

                if(isset($type))
                {

                    $result['user_id'] = $user['id'];
                    $result['user_name'] = $user['user_login'];
                    $result['opertion_type'] = $type;
                    $result['create_time']  = time();
                    $result['admin_name']  = session('name');
                    $result['ip']   =  get_client_ip();
                    $result['nick_name'] = $user['nickname'];
                    M('opertion_history')->add($result);
                }
            }


            // if ($password!=$user['user_pass']) {
            //     $data['user_pass'] = md5($data['user_pass']);
            // }
            // if ($two_password!=$user['user_two_pass']) {
            //     $data['user_two_pass'] = md5($data['user_two_pass']);
            // }
            $res = $this->user_model->where(array('id' => $data['id']))->save($data);
            if ($res) {
                $this->success("修改成功！");
            } else {
                $this->error('修改失败');
            }
        }
    }
    /*修改记录，穿透和到期时间修改*/
    public function  change_history()
    {
            $where = '';//print_r(I('get.'));
           // $date = strpos(I('get.date'),'%2F') !== false? str_replace('%2F','/',I('get.date')) : I('get.date');
        $date = I('get.date');
            if($date !='' && $date != '~')
            {
                $arr = explode('~',$date);
                $time1 = strtotime($arr[0]);
                $time2 = strtotime($arr[1]);
                $where = '`create_time` > '.$time1.' AND `create_time` < '.($time2+3600*24);
                if($arr[0]=='' || $arr[1] == '')
                    $where = '`create_time` > '.strtotime(str_replace('~','',$date)).' AND `create_time` < '.(strtotime(str_replace('~','',$date))+3600*24);
            }

            if($id = I('get.id'))
            {
                $where =  $where ? "user_id = $id AND ".$where : "user_id = $id";
            }
            if($t = I('get.type'))
            {
                $where =  $where ? "opertion_type = $t AND ".$where : "opertion_type = $t";
            }
           // if($where){echo $where;}
        $page = $this->page(M('opertion_history')->where($where)->count(), 20);
        $data =  M('opertion_history')->where($where)->limit($page->firstRow, $page->listRows)->order('id desc')->select();

        $this->assign("page", urldecode($page->show('Admin')));
        $this->assign('data',$data);


       $this->display();
    }
    /*修改统计*/
    public function change_statis()
    {
        $select = M('opertion_history')->field("create_time as creattime,user_id as member_id")->select();
       // print_r($select);die;
        foreach ($select as $k=>$v)
        {
            $select[$k]['creattime'] = date('Y-m-d',$v['creattime']);
        }
        $array = $this->unique($select);
        $date_arr = [];
        foreach ($array as $k=>$v)
        {
            unset($array[$k]['member_id']);
            $date_arr[] = $array[$k]['creattime'];
        }
        $arr_val = array_count_values($date_arr);
        $start_date = date('Y-m-d',strtotime('-10 days'));
        $end_date = date('Y-m-d');
        if(I('get.date') != '' && I('get.date') != '~')
        {
            $arr = explode('~',I('get.date'));
            if(isset($arr[0]) || isset($arr[1]) || $arr[0] < $arr[1])
            {
                $start_date = $arr[0];
                $end_date   = $arr[1];

            }
        }
        $date_list = array_flip($this->prDates($start_date,$end_date));

        foreach($date_list as $k=>$v)
        {
            if(isset($arr_val[$k]))
            {
                $date_list[$k] = $arr_val[$k];
            }else{
                $date_list[$k] = 0;
            }
        }
        foreach ($date_list as $k=>$v)
        {
            $date_list1[] = [$k,$v];
        }
        //  $list = str_replace("{","[",json_encode($date_list1));
        $this->assign('datelist',json_encode($date_list1));

      $this->display();
    }
    //日期循环
    public function prDates($start,$end){
        $dt_start = strtotime($start);
        $dt_end = strtotime($end);
        while ($dt_start<=$dt_end){
            $data[] = date('Y-m-d',$dt_start);
            $dt_start = strtotime('+1 day',$dt_start);
        }
        return $data;
    }
    public  function unique($data = array()){
        $tmp = array();
        foreach($data as $key => $value){
            //把一维数组键值与键名组合
            foreach($value as $key1 => $value1){
                $value[$key1] = $key1 . '_|_' . $value1;//_|_分隔符复杂点以免冲突
            }
            $tmp[$key] = implode(',|,', $value);//,|,分隔符复杂点以免冲突
        }

        //对降维后的数组去重复处理
        $tmp = array_unique($tmp);

        //重组二维数组
        $newArr = array();
        foreach($tmp as $k => $tmp_v){
            $tmp_v2 = explode(',|,', $tmp_v);
            foreach($tmp_v2 as $k2 => $v2){
                $v2 = explode('_|_', $v2);
                $tmp_v3[$v2[0]] = $v2[1];
            }
            $newArr[$k] = $tmp_v3;
        }
        return $newArr;
    }
    public function getParent($pid) {
        $user = $this->user_model->where(array('id' => $pid))->find();
        return $user;
    }

    protected function getChild($uid) {

        $me = $this->user_model->where(array('id' => $uid))->find();
        $child = $this->user_model->where(array('parent' =>$uid))
                ->select();
        $child[] = $me;
        return $child;
    }

    /**
     * 金币赠送
     */
    public function editMoney() {
        $where['type']='systerm';
        $count = $this->all_record->where($where)->count();
        $page = $this->page($count, 20);
        $record = $this->all_record
                ->where($where)
                ->order(array("id" => "desc"))
                ->limit($page->firstRow, $page->listRows)
                ->select();

        $this->assign('record', $record);
        $this->assign("page", $page->show('Admin'));
        $this->display();
    }

    public function editMoneyPost() {

        $wallet = I('post.wallet');
        $user_login = I('post.user_login');
        $number = I('post.number');
        $data = I('post.');
        $data['create_time'] = $this->time;
        $data['type'] = 'systerm';
        $data['wallet'] = $wallet;
        $data['notice'] = '系统操作';
        if ($user_login && $number > 0) {
            $user = $this->getUserDetailByUname($user_login);
            if (empty($user)) {
                $this->error('用户名不存在。。');
            }
            $type = I('post.type');
            if ($type == 1) {//赠送
                $data['number'] = "+{$number}";
                $this->all_record->add($data);
                $res = $this->user_model->where(array('user_login' => $user_login))->setInc($wallet, $number);
            } elseif ($type == 2) {//扣除
                $data['number'] = "-{$number}";
                $this->all_record->add($data);
                $res = $this->user_model->where(array('user_login' => $user_login))->setDec($wallet, $number);
            }
            if ($res) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('参数错误。。');
        }
    }
    


    /**
     * 会员关系
     */
    public function relationship() {

        $user_login = I('get.user_login');
        if ($user_login) {
            $user = $this->getUserDetailByUname($user_login);
            $uid = $user['id'];
        }
        $user_id = I('get.id');
        if ($user_id) {
            $uid = $user_id;
        }
        $status[0]='正常';
        $status[1]='封号';
        if ($uid) {
            $res = $this->getChild($uid);
            foreach ($res as $key => $value) {
                $res[$key]['id'] = $value['id'];
                $res[$key]['pId'] = $value['parent'];
                $res[$key]['name'] = "{$value['user_login']} 状态：{$status[$value['user_status']]}  姓名：{$value['true_name']} 联系方式：{$value['mobile']}";
            }
            //        header('Content-Type:application/json; charset=utf-8');
            $res = json_encode($res);
            $this->assign('treeNodes', $res);
        }
        $this->display();
    }

   

    //排序
    public function listorders() {
        $status = parent::_listorders($this->user_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

    /**
     *  删除
     */
    public function delete() {
        $id = intval(I("get.id"));
        $count = $this->user_model->where(array("parent" => $id))->count();

        if ($count > 0) {
            $this->error("该会员下还有子类，无法删除！");
        }

        if ($this->user_model->delete($id) !== false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 加时卡
     */

    public function activationCode() {
        $count = $this->card->count();
        $page = $this->page($count, 20);
        $record = $this->card
                ->order(array("id" => "desc"))
                ->limit($page->firstRow, $page->listRows)
                ->select();

        $this->assign('record', $record);
        $excel=$record;
        foreach ($excel as $k => &$v) {
            if($excel[$k]['status']==1){
                $excel[$k]['sy']='已使用';
                unset($excel[$k]['status']);
               
            }elseif($excel[$k]['status']==0) {
                $excel[$k]['sy']='未使用';
                unset($excel[$k]['status']);
            }

        }

        //session('excel',$excel);
        $this->assign("page", $page->show('Admin'));
        $this->display();
    }

    public function soCode() {
        if(IS_POST){
            $_GET=$_POST;
        }
        $term=I('get.term',0);
        $status=I('get.status',0);
        $card=I('get.card',0);
        if($term){
        $where['num'] = $term;
        }
        if($card){
        $where['card'] = $term;
        }
        if($status){
        $where['status'] = $status-1;
        }
        $count = $this->card->where($where)->count();
        $page = $this->page($count, 20);
        $record = $this->card
                ->where($where)
                ->order(array("id" => "desc"))
                ->limit($page->firstRow, $page->listRows)
                ->select();


        $this->assign('record', $record);
        //session('excel',$excel);
        $this->assign("page", $page->show('Admin'));
        $this->display('activationCode');
    }


/*
 * 生成加时卡
 */
    public function makeActivationCode() {
        if (IS_POST) {
            $num=I('post.term');
            $number = I('post.number');
            $ok = 0;
            $list=array();
            if($num=='1'){
                $type="时卡";
            }elseif ($num==24) {
                $type="日卡";
            }elseif ($num==168) {
                $type="周卡";
            }elseif ($num==720) {
                $type="月卡";
            }elseif ($num==8760) {
                $type="年卡";
            }

            for ($i = 0; $i < $number; $i++) {
                $pin = md5(sprintf("%0" . strlen(9) . "d", mt_rand(0, 99999999999)));
                if (!$this->card->where(array('card' => $pin))->find()) {
                    $data['type'] = $type;
                    $data['num'] = $num;
                    $data['card'] = $pin;
                    $data['create_time'] = $this->time;
                    if ($record=$this->card->add($data)) {
                        $ok++;
                        $list[]=$data;
                    }
                }
            }

            //$list=json_decode($list);
            session('excel',$list);
            if ($ok > 0) {
                 $this->msg("操作成功,生成{$ok}个加时卡。");

                
            } else {
                $this->msg('操作失败');
            }
           
        } else {
            $this->display();
        }
    }
/**
 * 删除加时卡
 */
    public function deleteCode() {
        $id = I('get.id');
        $res = $this->card->delete($id);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }



    function expUser(){
        $data=$_SESSION[excel];

        //$title=array('id','使用用户','加时卡','添加时间','使用时间','使用状态','类型');
        $title=array('类型','增加时间','加时卡','生成时间',);
        $this->createExc($data,$title,'Activation');
    }

    //导出文件
    function createExc($data=array(),$title=array(),$filename='test'){
        ob_end_clean();
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . "_" . date('H:i:s') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t ", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t ", $data[$key]);
            }
            echo implode("\n",$data);
        } 

    }





  


    public function disable() {
        $id = I('get.id');
        $data['status'] = 1;
        $data['disable_notice'] = "系统操作";
        $res = $this->user_model->where(array('id' => $id))->save($data);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    public function unDisable() {
        $id = I('get.id');
        $data['status'] = 0;
        $data['disable_notice'] = "";
        $res = $this->user_model->where(array('id' => $id))->save($data);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
    /*
     * 限制登录
     */
    public function Limit() {
        $id = I('get.id');
        $data['status'] = 2;
        $res = $this->user_model->where(array('id' => $id))->save($data);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
    public function unLimit(){
        $id = I('get.id');
        $data['status'] = 0;
        $data['disable_notice'] = "系统操作";
        $res = $this->user_model->where(array('id' => $id))->save($data);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
    //充值时间
    public function recharge(){
        $user=$this->user_model->where("id=$_GET[id]")->find();
        $this->assign('user' , $user);
        $this->display();
    }

     public function uprecharge() {
        $url=U('Recharge');
        if (IS_POST) {
            $user_login = I('post.user_login');
            $term=I('post.term');
            $res = $this->getUserDetailByUname($user_login);
            if (empty($res)) {
                $this->error('用户不存在！');
            }
            $user=$this->user_model->where(array('user_login'=>$user_login))->find();
            $due_time=strtotime($user['due_time']);
            if($due_time<time()){
                $due_time=time();
            }
            $number = I('post.number');
            $hour= $number*3600;
            if($term==0){
                $due_time=$due_time+$hour;
                $time['due_time']=date('Y-m-d H:i:s' ,$due_time);
                $use=$this->user_model->where(array('user_login'=>$user_login))->save($time);
                $this->user_model->where(array('parent'=>$user[id]))->save($time);
                if($use){
                    $this->success('添加成功');
                }
            }elseif($term==1){
                $due_time=$due_time-$hour;
                 $time['due_time']=date('Y-m-d H:i:s' ,$due_time);
                $use=$this->user_model->where(array('user_login'=>$user_login))->save($time);
                $this->user_model->where(array('parent'=>$user[id]))->save($time);
                if($user){
                    $this->success('减少成功');
                }
            }else{
                $this->error('充值失败');
            }
            
        }
    }





    public function dologin() {
        $id=I('get.id');
        $result = $this->user_model->where(array('id'=>$id))->find();
        session('uid', $result["id"]);
        session('user_login', $result["user_login"]);
        session('user', $result);
        cookie("user_login", $name, 3600 * 24 * 30);
        $this->redirect("/portal/Home/index");
 
    }


    /**
     * 时时彩
     */









    /**
     * 大转盘
     */
    public function turntable() {
        if (IS_POST) {
            $user_login = I('post.user_login');
            $award_id = I('post.award_id');
            $this->assign('award_id', $award_id);
            if ($user_login) {
                $where['user_login'] = $user_login;
            }
            if ($award_id) {
                $where['award_id'] = $award_id;
            }
            session('awhere', $where);
            $count = $this->award->where($where)->count();
            $page = $this->page($count, 20);
            $record = $this->award
                    ->where($where)
                    ->order(array("id" => "desc"))
                    ->limit($page->firstRow, $page->listRows)
                    ->select();
            $this->assign('record', $record);
            $this->assign("page", $page->show('Admin'));
            $this->display();
        }elseif (session('awhere')) {
            $where = session('awhere');
            $count = $this->award->where($where)->count();
            $page = $this->page($count, 20);
            $record = $this->award
                    ->where($where)
                    ->order(array("id" => "desc"))
                    ->limit($page->firstRow, $page->listRows)
                    ->select();
            $this->assign('record', $record);
            $this->assign("page", $page->show('Admin'));
            $this->display();
        } else {
            $count = $this->award->count();
            $page = $this->page($count, 20);
            $res = $this->award
                    ->order(array("id" => "asc"))
                    ->limit($page->firstRow, $page->listRows)
                    ->select();
            $this->assign('record', $res);
            $this->assign("page", $page->show('Admin'));
            $this->display();
        }
    }

    /*
     * 删除
     */
    public function deleteAward() {
        $id = I('get.id');
        $res=$this->award->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功');
        }
    }
    
    public function giveAward() {
        $id = I('get.id');
        $res = $this->award->where(array('id' => $id))->save(array('status'=>1));
        if ($res) {
            $this->success('已派发');
        }
    }

}
