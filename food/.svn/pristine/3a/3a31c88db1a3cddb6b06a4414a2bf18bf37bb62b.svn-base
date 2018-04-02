<?php
namespace app\index\controller;
/*
 *  财务
 *
 */
class finance extends Common
{
    public $date_where = "";
    public function __construct()
    {
        parent::__construct();
        if(input("date") != "" && input("date") != '~'){
            $date_where = explode("~",input("date"));
            $this->date_where = "datea BETWEEN '".($date_where[0]?$date_where[0]:$date_where[1])."' AND '".($date_where[1]?$date_where[1]:$date_where[0])."'";
            $this->assign("date",$date_where);
        }
    }

    //营业收入
    public function index()
    {
        $db = db("order");
       // echo $this->date_where;die;
        $sum = $db->where($this->date_where)->field("sum(price) as price")->select()[0]['price'];
        $sum_a = $db->where("kuan = 2".($this->date_where ? " AND ".$this->date_where : ""))->field("sum(price) as price")->select()[0]['price'];
        $sum_b = $db->where("kuan = 1".($this->date_where ? " AND ".$this->date_where : ""))->field("sum(price) as price")->select()[0]['price'];

        $this->assign("data",["sum"=>$sum ? $sum : 0,"sum_a"=>$sum_a ? $sum_a : 0,"sum_b"=>$sum_b ? $sum_b : 0]);
        return view();
    }
    //应收账款
    public function account()
    {
        $data = db("order")->where("kuan = 2 ".($this->date_where ? " AND ".$this->date_where : ""))->paginate(15);
        $this->assign("list",$data);
        return view();
    }
    //已收账款
    public function account_ok()
    {
        $data = db("order")->where("kuan = 1 ".($this->date_where ? " AND ".$this->date_where : ""))->paginate(15);
        $this->assign("list",$data);
        return view();
    }


    //价格体系
    public function price()
    {
        $db = db('channel_price');
        $data = $db->where(isset($_GET['channel']) ? "id = ".$_GET['channel'] : "")->find();
            //当前渠道商的对应[品名，价格，毛利]
        $this->assign('data',$data);
        $this->assign('option',$db->field("id,channel")->select());
      //  print_r(json_decode($data['price'],true));die;
        return view();
    }
    //价格编辑   新增或者编辑
    public function price_edit()
    {
        $db = db('channel_price');
        $option = food_name();
          switch (input("type")){
              case 'add'://print_r(input('post.'));DIE;
                  $status = $db->insert(input('post.')) ? 1 : 0;
                  echo json_encode(["status"=>$status]);die;
                  break;
              case 'update':
                  $status = $db->where(["id"=>input("id")])->update(input("post."))? 1 : 0;
                  echo json_encode(["status"=>$status]);die;
                  break;
              case 'edit':
                  $data = $db->where(["id"=>input("id")])->find();
                  $price = json_decode($data['price'],true);

                    if($price)
                    {
                        foreach($price as $k=>$v)
                        {
                            //查看当前渠道商对所有的食品是否标注价格
                            foreach($option as $kk=>$vv)
                            {
                                if($v[0] == $vv['id'])
                                {
                                    $option[$kk]['p1'] = $v[1];
                                    $option[$kk]['p2'] = $v[2];
                                }
                            }
                        }
                    }
                  //  print_r($option);
                  break;
              default:

                  break;
          }
        $this->assign('data',isset($data) ? $data : "");
        $this->assign("type",input("type"));
        $this->assign('option',$option);
        return view();
    }

}




?>