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

class AdminYouxiController extends AdminbaseController {
	

	function _initialize() {
        parent::_initialize();
    }
    /*游戏大厅路由管理*/
    public function hall()
    {

        if(IS_AJAX)
        {
                if(I('post.skin'))
                    if(!file_exists(SITE_PATH.'themes/game/portal/index/'.I('post.skin').'.html')){json_encode(['status'=>0,'con'=>'没有此皮肤！请联系开发人员！']);die;}
                $data = array_merge(I('post.'),['update_time'=>time(),'status'=>I('post.status') ? I('post.status') : 1]);
                if(I('post.get') == 'add')
                {
                    M('hall_branch')->add($data);
                }else{
                    unset($data['id']);
                    if(I('post.id'))M('hello_branch')->where(I('post.id'))->update($data);
                }
                echo json_encode(['status'=>1,'con'=>'操作成功！']);die;

        }else{
            $this->assign('data',M('hall_branch')->select());
            $this->display();
        }
    }
    public function Add_Hall()
    {
        if(I('get.')) {
            switch (I('get.type'))
            {
                case 'delete':
                    I('get.id') ? M('hall_branch')->where(['id' => I('get.id')])->delete() : $this->error("删除失败！");
                    break;
                case 'update':
                    if(I('get.id')) {
                        if (I('post.')) {
                            M('hall_branch')->where(['id' => I('get.id')])->save(array_merge(I('post.'), ['update_time' => time()]));
                        } else {
                            $this->assign('data', M('hall_branch')->where(['id' => I('get.id')])->find());
                        }
                    }
                    break;
                case 'add':
                    if(I('post.'))
                        M('hall_branch')->add(array_merge(I('post.'),['update_time'=>time()]))  ;
                    break;
            }

         I('post.') ? $this->success('操作成功！', U('AdminYouxi/hall')) : $this->assign('action',U('AdminYouxi/Add_Hall',['type'=>I('get.type'),'id'=>I('get.id')]));;

        }else{
            $this->assign('action',U('AdminYouxi/Add_Hall',['type'=>'add']));

        }
        $this->display();
    }
    /*
     * 游戏种类
     */
    public function GameList(){
    	 if($_POST){
            $_GET=$_POST;
        }
        $where=' 1=1 ';

        if($_GET['name']){
            $where=$where.' and name LIKE "%'.$_GET['name'].'%"';
        }
        $count = M('game')->where($where)->count();
        $page = $this->page($count, 10);
        $posts = M('game')
                ->where($where)
                ->order(array("id" => "desc"))
                ->limit($page->firstRow, $page->listRows)
                ->select();
        $this->assign('posts', $posts);
        $this->assign('page', $page->show('Admin'));

        $this->display();
    }
    public function Add_Game(){
    	$this->display();
    }
    public function Add_Game_Post(){
    	 if(IS_POST){
            $post=I("post.");
            $res=M('game')->add($post);
            if($res){
                $this->success('添加成功',U('AdminYouxi/GameList'));
            }
        }
    }
    public function Edit_Game(){
    	$id=I('get.id');
    	$post = M("game")->where(array('id'=>$id))->find();
    	$this->assign('post',$post);
    	$this->display();
    }
    public function Edit_Game_Post(){
    	$id=I('post.id');
    	$post=I('post.');
        $rs = M('game')->where(array("id" => $id))->find();
         if (IS_POST) {
            if (M('game')->where(array("id" => $id))->save($post) !== false) {
                $this->success("更新成功！");
            } else {
                $this->error("更新失败！");
            }
        }
    }
     /*
     * 游戏玩法
     */
    public function RuleList(){
    	 if($_POST){
            $_GET=$_POST;
        }
        $where=' 1=1 ';

        if($_GET['name']){
            $where=$where.' and name LIKE "%'.$_GET['name'].'%"';
        }
        if($_GET['type']){
            $where=$where.' and type="'.$_GET['type'].'"';
        }
        $count = M('rule')->where($where)->count();
        $page = $this->page($count, 10);
        $posts = M('rule')
                ->where($where)
                ->order(array("id" => "desc"))
                ->limit($page->firstRow, $page->listRows)
                ->select();
        $this->assign('posts', $posts);
        $this->assign('page', $page->show('Admin'));
        $game = M('game')->select();
        $this->assign('game',$game);
        $this->display();
    }
    public function Add_Rule(){
        $game = M('game')->select();
        $this->assign('game',$game);
    	$this->display();
    }
    public function Add_Rule_Post(){
    	 if(IS_POST){
            $post=I("post.");
            $res=M('rule')->add($post);
            if($res){
                $this->success('添加成功',U('AdminYouxi/RuleList'));
            }
        }
    }
    public function Edit_Rule(){
    	$id=I('get.id');
    	$post = M("rule")->where(array('id'=>$id))->find();
    	$this->assign('post',$post);
        $game = M('game')->select();
        $this->assign('game',$game);
    	$this->display();
    }
    public function Edit_Rule_Post(){
    	$id=I('post.id');
    	$post=I('post.');
        $rs = M('rule')->where(array("id" => $id))->find();
         if (IS_POST) {
            if (M('rule')->where(array("id" => $id))->save($post) !== false) {
                $this->success("更新成功！");
            } else {
                $this->error("更新失败！");
            }
        }
    }
}
