<?php
namespace app\index\controller;
/*
 * 订单
 *
 */
class order extends  Common
{
    //订单记录
    public function index()
    {
        $list =  db('order')->order("id desc")->paginate(15);
        $this->assign("list",$list);
        return view();
    }

    //订单统计
    public function order_statis()
    {
            $start = explode("~",input("start"));
            $end   = explode("~",input("end"));
            $sql = "";
            if(!in_array("",$start))
            {
                $sql = "datea BETWEEN '".$start[0]."' AND '".$start[1]."'";
            }
            if(!in_array("",$end))
            {
                $sql = $sql ? $sql." AND ": "" ;
                $sql .= "dateb BETWEEN '".$end[0]."' AND '".$end[1]."'";
            }
            $db = db("order");
            //不同经办人的统计
            $data = $db
                ->where($sql)->field("*,count(id) as count,sum(price) as sum")
                ->group("admin_user")
                ->select();

            //不同食品的统计
            foreach ($db->where($sql)->select() as $k=>$v)
            {
                foreach(json_decode($v['json'],true) as $kk=>$vv)
                {
                    if(!isset($food[$vv[1]]))
                    {

                        $food[$vv[1]]["fid"] = $vv[1];//赋值食品id
                        $food[$vv[1]]["number"] = $vv[2];//赋值食品袋数
                        $food[$vv[1]]["price"]  = $vv[5];
                    }else{
                        $food[$vv[1]]["number"] = $vv[2]+$food[$vv[1]]["number"];
                        $food[$vv[1]]["price"]  = $vv[5]+$food[$vv[1]]["price"];
                    }
                }

            }

        $this->assign("date",["start"=>$start,"end"=>$end]);
        $this->assign("food_list",$food);
        $this->assign("food",order_name("","count(id) as count,sum(price) as price"));
        $this->assign("data",$data);
        return view();
    }
    //订单编辑/增加/修改
    public function order_edit()
    {
        switch(input("type")){
            case "edit"://编辑
                $edit = db("order")->where(["id"=>input("id")])->find();
                break;
            case "update"://更新
                $save["dateb"] = date("Y-m-d",strtotime("+".input("post.after_day")." day",strtotime(order_name(input("id"))["datea"])));
                $save["price"] = 0;
                $save["number"] = 0;
                foreach(json_decode(input("post.json"),true) as $k=>$v)
                {
                    $save["number"] = $save["number"]+$v[2];
                    $save["price"] = $save["price"]+$v[5];
                }
                $status = db("order")->where(["id"=>input("id")])->update(array_merge(input("post."),$save)) ? 1 : 0;
                echo json_encode(["status"=>$status]);die;
                break;
            case "add"://添加
                $date = date("Y-m-d");
                $save["order_num"] = date("Ymd").(db("order")->where(["datea"=>$date])->count()+1);
                $save["datea"] = $date;
                $save["dateb"] = date("Y-m-d",strtotime("+".input("post.after_day")." day"));
                $save["time"] = time();
                $save["price"] = 0;
                $save["number"] = 0;
                $save["admin_user"] = $this->admin["name"];
                foreach(json_decode(input("post.json"),true) as $k=>$v)
                {
                    $save["number"] = $save["number"]+$v[2];
                    $save["price"] = $save["price"]+$v[5];
                }
               // print_r($save);die;
                $status = db("order")->insert(array_merge(input("post."),$save)) ? 1 : 0;
                echo json_encode(["status"=>$status]);die;
                break;
            case "price"://清算价格
                $channel_arr = channel_name(input("post.cid"));
                foreach(json_decode($channel_arr['price'],true) as $k=>$v)
                {
                    if($v[0] == input("post.fid"))
                    {
                       $price = $v[1];
                       $price_result = input("post.times") && $price ? input("post.times")*$price : 0;

                    }
                }
                echo json_encode(["price"=>isset($price) ? $price : 0,"price_result"=>isset($price_result) ? round($price_result,1) :0 ]);
                die;
                break;
            default:
                break;
        }
        $this->assign("edit",isset($edit) ? $edit : []);

        return view();
    }
    //订单详情
    public function order_info()
    {
            $db =  db("order");
            switch (input("type"))
            {
                case "ku" :
                	///print_r(input("post."));die;
                    $status =  $db->where(['id'=>input("post.id")])->update(["ku"=>2,'running_num'=>input("post.running_num"),'company'=>input("post.company")]) ? 1 : 0;
                    break;
                case "kuan" :
                    $status =  $db->where(['id'=>input("post.id")])->update(["kuan"=>2]) ? 1 : 0;
                    break;
            }
        if(isset($status)){
              echo  json_encode(["status"=>$status]);die;
        }

        $edit = $db->where(["id"=>input("id")])->find();
        $this->assign("edit",$edit);
        return view();
    }
    //样品记录
    public function order_yp()
    {
        $list = db("order_yp")->paginate(5);
        $this->assign("list",$list);
        return view();
    }
    //订单样品编辑/增加/修改
    public function order_yp_edit()
    {
        $db = db("order_yp");
        switch (input("type"))
        {
            case 'edit':
                $this->assign("edit",$db->where(["id"=>input("id")])->find());
                break;
            case 'add':
                $add["yp_num"] = date("Ymd").($db->where(["date"=>date("Y-m-d")])->count()+1);
                $add["date"] = date("Y-m-d");
                $add["admin_user"] = $this->admin['name'];
                $add["number"] = 0;
                $add["price"] = 0;
//                print_r(json_decode(input("post.json"),true));die;
                foreach(json_decode(input("post.json"),true) as $k=>$v){
                    $add["number"] = $add["number"]+$v[2];//套数
                    $add["price"] = $add["price"]+$v[5];//金额
                }
                echo json_encode(["status"=>$db->insert(array_merge(input("post."),$add)) ? 1 :0 ]);die;
                break;
            case 'update':
                $save["number"] = 0;
                $save["price"] = 0;
//                print_r(json_decode(input("post.json"),true));die;
                foreach(json_decode(input("post.json"),true) as $k=>$v){
                    $save["number"] = $save["number"]+$v[2];//套数
                    $save["price"] = $save["price"]+$v[5];//金额
                }
                echo json_encode(["status"=>$db->where(["id"=>input("id")])->update(array_merge(input("post."),$save)) ? 1 :0 ]);die;
                break;
        }
        return view();
    }




}



?>