<?php
namespace app\index\controller;
/*
 * 控制器内所有为号库操作
 */
class index extends Common
{
    private $api_pass = 'jjxy610';

    public function index()
    {
        echo "/index/index/hkcz.html";
        //echo md5('QAZwsx123');
    }
    //号库概览
    public function hkgl(){
         $data["number"] = 0;//账号数
      $data["8day"] = 0;//8日号
       $data["half_a_moon"] = 0;//半月号
       $data["full_moon"] = 0;//满月号
      $data["half_a_year"] = 0;//半年号
       $daya["zc_num"] = 0;
      foreach(db("register")->select() as $k=>$v)
        {
        $data["zc_num"] = $data["zc_num"]+$v["zc_num"];  
            $data["number"] = $data["number"]+$v["registrations"];  
            if($v["date"] < date("Y-m-d H:i:s",strtotime("-8 day")))
            {
                $data["8day"] = $data["8day"]+$v["registrations"];
            }
            if($v["date"] < date("Y-m-d H:i:s",strtotime("-15 day")))
            {
$data["half_a_moon"] = $data["half_a_moon"]+$v["registrations"];
            }
            if($v["date"] < date("Y-m-d H:i:s",strtotime("-30 day")))
            {
$data["full_moon"] = $data["full_moon"]+$v["registrations"];
            }
            if($v["date"] < date("Y-m-d H:i:s",strtotime("-182 day")))
            {
$data["half_a_year"] = $data["half_a_year"]+$v["registrations"];
            }

        }


      
   
      
      
      
        $this->assign('data',$data);
        return view();
    }
    //号库查询
   
  public function hkcx(){

        $searcha =  isset($_GET['searcha']) ? $_GET['searcha'] : "";
        $searchb =  isset($_GET['searchb']) ? $_GET['searchb'] : "";
        if($searcha && $searchb)
        {
    $db = db('register');
        $a = date("Y-m-d H:i:s",strtotime('-'.$searcha.' day'));
        $b = date("Y-m-d H:i:s",strtotime('-'.$searchb.' day'));
         $data = $db->where(" date between '".$b."' AND '".$a."'")->select();
         echo $db->getLastSql();
    

            $this->assign('data',$data);

        }
        $this->assign('search',['searcha'=>$searcha,'searchb'=>$searchb]);
        return view();
    }
    
    //号库详情
  
    public function hkxq(){
        $this->assign('data',$this->ku_list());
        return view();
    }
   
    //注册
    public function zc(){
        $post = input('post.');
        if($post)
        {
            $find = isset($post["id"]) ? db('register')->where("id='".$post["id"]."'")->find() :"";
            if(isset($post["liucun"]))
            {
                $bf = $find["registrations"]-$post["liucun"]+$find["bf_num"];
                if($bf < 0)exit();
                 echo     db('register')->where("id='".$post["id"]."'")->update(["registrations"=>$post["liucun"],"bf_num"=>$bf,"liucun_time"=>date("Y-m-d H:i:s")]) ? json_encode(['status'=>1]) : json_encode(['status'=>0]);die;
            }else if(isset($post["delete"]))
            {
            db('register')->where("id='".$post['delete']."'")->delete();
            
            }else if(isset($post["liucun2"])){
                db('register')->where("id='".$post["id"]."'")->update([
                    "registrations"=>$post["liucun2"],"bf_num"=>$post["bf"] ]);
            }else if(isset($post["ck"]))
            {

                
                    $ck = $find["registrations"]-$post["ck"];
            
                    if($ck < 0)exit();
                  db("order")->insert([
                        "num"=>$post["ck"],
                        "registrations"=>$post["pid"],
                        "date"=>date("Y-m-d H:i:s"),
                    "reg_date"=>$post["date"],
                    "reg_id"=>$post["id"],
                    ]);
                echo     db('register')->where("id='".$post["id"]."'")->update([
                    "registrations"=>$ck ,
                    "ck_num"=>$post["ck"]+$find["ck_num"],


                    ]) ? json_encode(['status'=>1]) : json_encode(['status'=>0]);die;

            }else{
                $post["zc_num"] = $post["registrations"];
                 echo     db('register')->insert(array_merge($post,['date'=>date("Y-m-d H:i:s")])) ? json_encode(['status'=>1]) : json_encode(['status'=>0]);die;
            }
            
           
        }
        $where = $_GET['num']  ? ["base_number"=>$_GET['num']] :  "";
        $list =  db('register')->where($where)->order("id desc")->paginate(15,false,[
            "query"=>["num"=>$_GET["num"]??""]

            ]);
   
        $this->assign('list',$list);
        return view();
    }

    //留存
    /*
  public function lc(){

        $data = db('details_history')->field("*,max(number)as max")->group("base_number")->select();
        foreach($data as $k=>$v)
        {
            $data[$k]['1day'] = $this->division($v['1day'],$v['max']);
            $data[$k]['3day'] = $this->division($v['3day'],$v['max']);
            $data[$k]['7day'] = $this->division($v['7day'],$v['max']);
            $data[$k]['half_a_moon'] = $this->division($v['half_a_moon'],$v['max']);
            $data[$k]['full_moon'] = $this->division($v['full_moon'],$v['max']);
        }
        $this->assign('list',$data);
        // print_r($data);die;
        return view();
    }
    */
    //订单
    public function dd(){
        /*$date = isset($_GET['date']) ? str_replace("-","",$_GET['date'] ? $_GET['date'] : date("Ymd")) : date("Ymd");
        
        $uid = isset($_GET['site_title']) ? $_GET['site_title'] : "4000";

        $this->assign('site_title',$uid);
        $data = file_get_contents("http://api.dindingame.com:5050/job/2/archive_new_user?uid=".$uid."&pname=wxstock&date=".$date);

        if($data)
        {
            $data =  explode("\n",substr($data,0,-1));
            foreach ($data as $k=>$v)
            {
                $data[$k] = explode(" ",$data[$k]);
                if(count($data[$k]) < 5)
                {
                    $data[$k][4] = $data[$k][3];
                    $data[$k][3] = '';
                }
            }
        }
        */
        $datesql = isset($_GET['date']) ? "  DATE_FORMAT(date,'%Y-%m-%d') = '".$_GET['date']."' AND" :  "";
        $uidsql = isset($_GET['site_title']) ? "   registrations = '".$_GET['site_title']."' AND" : "";
        $db = db("order");
        if($post = input("post."))
        {
            $find = $db->where("id='".$post["id"]."'")->find();
          $rdb = db("register");
            $reg_find = $rdb->where("id='".$post["reg_id"]."'")->find();
            $save["ck_num"] = $reg_find["ck_num"]-$find["num"];
            $save["registrations"] = $reg_find["registrations"]+$find["num"];
        // print_r($save);die;
            $rdb->where("id='".$post["reg_id"]."'")->update($save);
            $db->where("id='".$post["id"]."'")->delete();
        }
      
        $data = $db->where(substr($datesql.$uidsql,0,-3))->order("id desc")->select();
        //echo $db->getLastSql();



        $this->assign('list',$data);

        return view();
    }
    //号库操作
   /*
  public function hkcz(){
        $db = db('ku_num');

        if(input('post.'))
        {
            $where['num'] = input('num');
            $find = $db->where($where)->find();
            //更改已激活号库的对接码和地区   对接码  地区
            if($find && input('docking_code') && input('region')){
                $db->where($where)->update(input('post.')) ? $status = 1 : "" ;
            }
            //ajax查询当前号库的对接码和地址
            if($find && input('select'))
            {
                echo json_encode(['status'=>2,'data'=>$find]);die;
            }
            //激活号库
            if(input('post.jhhk')){
                if($find){
                    //yi ji huo
                    $status = 2;
                }else{
                    $db->insert(['num'=>input('num')]);
                    $status = 1;
                }
            }
            //迁移号库  源库  目标库
            if(input('post.qyhk') && input('yk_qy') && input('mb_qy'))
            {
                file_get_contents("http://api.dindingame.com:5050/wx/1/move_uid?uid=4000&pw=".$this->api_pass."&src=".input('post.yk_qy')."&dest=".input('post.mb_qy'));
                $status = 1;
            }

            echo json_encode(['status'=>isset($status) ? $status : 0]);die;
        }else{
            $this->assign('select',$db->select());
            return view();
        }

    }
    */
    //号库详情历史
    public function hkxq_history(){

        if(isset($_GET['ku']))
        {
            $list = db('details_history')->where(['base_number'=>input('get.ku')])->order("id desc")->paginate(15,false,['query'=>['ku'=>$_GET['ku']]]);
            $this->assign('list',$list);
            return view();
        }

    }
    //号库列表
    public function ku_list()
    {
        // foreach(db('ku_num')->select() as $k=>$v)
        // {
        //     $data[$k]['base_number'] = $v['num'];
        //     $data[$k]['number'] = file_get_contents("http://api.dindingame.com:5050/wx/1/get_uid_count?uid=".$v['num']."&pw=".$this->api_pass);
        //     $data[$k]['8day'] = $this->get_num($v['num'],7,99999);
        //     $data[$k]['half_a_moon'] = $this->get_num($v['num'],15,99999);
        //     $data[$k]['full_moon'] = $this->get_num($v['num'],30,99999);
        //     $data[$k]['half_a_year'] = $this->get_num($v['num'],180,99999);
        // }
        $db = db('register');
        $data = [];
        foreach($db->group("base_number")->select() as $k=>$v)
        {
            $data[$k]['base_number'] = $v['base_number'];
            $data[$k]['number'] = $db->where("base_number = '".$v['base_number']."'")->field("sum(`registrations`) as p")->find()["p"];
            $data[$k]['8day'] = $this->get_num($v['base_number'],7);
            $data[$k]['half_a_moon'] = $this->get_num($v['base_number'],15);
            $data[$k]['full_moon'] = $this->get_num($v['base_number'],30);
            $data[$k]['half_a_year'] = $this->get_num($v['base_number'],180);
        }



        return $data;
    }
//定时访问刷新当天的号库信息
    /*
    public function refresh()
    {
//  $this->get_num($v['num'],178);
        $select = db('ku_num')->field("num")->select();
        $db = db('details_history');
        foreach($select as $k=>$v)
        {
            $data['base_number'] = $v['num'];
            $data['number'] = file_get_contents("http://api.dindingame.com:5050/wx/1/get_uid_count?uid=".$v['num']."&pw=".$this->api_pass);
            $data['8day'] = $this->get_num($v['num'],7,99999);//8日
            $data['half_a_moon'] = $this->get_num($v['num'],15,99999);//半月
            $data['full_moon'] = $this->get_num($v['num'],30,99999);//满月
            $data['half_a_year'] = $this->get_num($v['num'],180,99999);//半年
            $data['1day'] = $this->get_num($v['num'],0,99999);//一日
            $data['3day'] = $this->get_num($v['num'],2,99999);//三日
            $data['7day'] = $this->get_num($v['num'],6,99999);//七日
            $data['time'] = time();
            $db->insert($data);
        }

    }
    */
    //百分比
    public function division($a,$c)
    {
        return    $c != 0 ? round(($a/$c)*100).'%': '0%';
    }
    //get多少天以上的数量   库号：$num,天数：$min
    public function get_num($num,$min,$max = "")
    {
        //echo $num."<>".$min;
       // return file_get_contents("http://api.dindingame.com:5050/wx/1/stock_aged_wx_count?uid=".$num."&pw=".$this->api_pass."&min=".$min."&max=".$max);
        if($max) $max = "AND  date > '".date("Y-m-d H:i:s",strtotime('-'.$max.' day'))."'";
        return db('register')->where("base_number = '".$num."' AND date < '".date("Y-m-d H:i:s",strtotime('-'.$min.' day'))."'  ".$max."")->field("sum(`registrations`) as p")->find()["p"];
    }

}
