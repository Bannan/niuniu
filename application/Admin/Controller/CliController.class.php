<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
/**
 */
namespace Admin\Controller;

use Think\Controller;

class CliController extends Controller {

    public function _initialize() {
		$isCli = preg_match("/cli/i", php_sapi_name()) ? true : false;
		if(!$isCli) {
			die('Is Must Cli Mode' . PHP_EOL);
		}
    }
	
	public function index(){
		while(true) {
			M('User')->where(array('gailv_expire' => array('lt', date('Y-m-d H:i', time())), 'gailv' => array('gt', 0)))->save(array('gailv' => '0'));
			M('User')->where(array('gailv_expire' => array('lt', date('Y-m-d H:i', time())), 'is_grade' => array('gt', 0)))->save(array('is_grade' => '0'));
			echo date('Y-m-d H:i', time()) . ' - clear expire user' . PHP_EOL;
			sleep(10);
		}
	}

}