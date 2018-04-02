<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//防止异常抛出
error_reporting(E_ERROR | E_PARSE );
//查询食品信息
function food_name($id = "",$field = "*")
{
    return  $id ? db("food_name")->where(['id'=>$id])->find() : db("food_name")->field($field)->select();
}
//查询原料
function yl_name($id = "",$field = "*")
{
    return  $id ? db("yl_name")->where(['id'=>$id])->find() : db("yl_name")->field($field)->select();
}
//渠道查询
function channel_name($id = "",$field = "*")
{
    return  $id ? db("channel_price")->where(['id'=>$id])->find() : db("channel_price")->field($field)->select();
}
function order_name($id = "",$field = "*")
{
    return  $id ? db("order")->where(['id'=>$id])->find() : db("order")->field($field)->select();
}
