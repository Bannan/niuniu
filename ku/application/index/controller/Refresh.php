<?php
namespace app\index\controller;

//用于定时刷新
use think\Controller;
use think\Db;
class refresh extends Controller
{
    protected $api_pass = "jjxy610";
    public function __construct()
    {
    
      global $a;
      $a = 123;
      // $key = isset($_GET['key']) ? $_GET['key'] : 1 ;
       //$key == md5('QWEasd!~1123!@#') ? " " : die;
        parent::__construct();
    }

    public function read_dir(){  
      
     
 //if(is_numeric("01231a23"))echo 1;;
    // echo  implode(".",array(1,2,3,4));
//$a= <<<EOF
 //   "abc"
//    "123"
//EOF;
		//$arr = ["a"=>10,"b"=>20];
      //	$arr["a"] +=6;
     // print_r($arr);
     // $i = 10;
     // echo $i--;
    //  echo $i;
     // $a = 10;
      //echo $b??1;//如果$b不存在那么久等于1
      //太空操作符
     // $c = $a <=> $b;// 如果 $a > $b, $c 的值为 1
 						//如果 $a == $b, $c 的值为 0
 						//如果 $a < $b, $c 的值为-1
//echo unicode_decode("\u91ca\u653e\u5931\u8d25\u6216\u8005\u5df2\u7ecf\u91ca\u653e");die;
    	//$a=array("key1"=>"val1","key6"=>"val6","key3"=>"val1","key5"=>"val6","key4"=>"val8");
		//rsort($a);数组排序
      //global $a;  echo $a;调取的全局变量
  // echo __FILE__ ;echo __line__;
      
      $dir = __ROOT__."/w";
		read_dir($dir);

    }  
    public function json_arr(){

    $json1 = '{"BSSID":"14:ba:87:bb:29:0c","IpAddress":"192.168.61.89","P2p0Mac":"1f:9a:e8:88:61:93","SSID":"Netcore_298326","androidId":"fa916efa6c52c5c6","batteryLevel":33,"btAddress":"9d:b8:19:e5:25:59","btName":"HUAWEI HN3-T00","buildAbi":"armeabi-v7a","buildAbi2":"armeabi","buildBoard":"p700","buildBrand":"HUAWEI","buildCodename":"REL","buildDescription":"HUAWEI HN3-T00-user 6.0.1 MMB29T ae3e48ba release-keys","buildDevice":"HUAWEI HN3-T00","buildFingerprint":"HUAWEI/HUAWEI HN3-T00/HUAWEI HN3-T00:6.0.1/MMB29T/ae3e48ba:user/release-keys","buildHardware":"qcom","buildHost":"SEP-68","buildId":"MMB29T","buildIncremental":"ae3e48ba","buildManufacturer":"HUAWEI","buildModel":"HUAWEI HN3-T00","buildName":"HUAWEI","buildProduct":"HUAWEI HN3-T00","buildRadioVersion":"rixtpamhew","buildRelease":"6.0.1","buildSdk":"23","buildSerialno":"c32e83b6","buildTags":"release-keys","buildType":"user","buildUser":"lgmobile","buildUtc":1474793491639,"cellScan":["39694,162627122","33296,134540292","33296,134742787","33045,118480929","33296,39181"],"ci":39181,"contacts":["奶奶,14701981382","姑妈,13508663398","外婆,13708158060","外公,13504294098","舅舅,14705605569","舅妈,13806035860","姨父,18902468151","姨娘,13201625274","亲爱的,13605681669","老弟,13800808711","老妹,15602255988","小明,18702576799","小李子,13902380365","裘永伊,15807106333","Sam Hernandez,13400118330","王麟,15306207106","杨虹思,15804417457","陈扬,18907080168","Jack Gibson,13302679001","韦锐利,13902292977","韦龙敬,15708751674","花木奇,13605657215","Ernest Pierce,13701250397","施平添,15800022205","杨锦航,13103338082","茅校野,13605884176","Laurie Shaw,13503964848","王盈炎,15507885064","许珀渠,13304964812","余全竞,15503953136","Mike Price,13103943338","杨童琦,18602591337","李诗,18804277434","魏意屏,15808663386","Craig Myers,15805270584","于宏雍,13405712415","陈夏,13501897309","于竞倩,18606082404","Joyce Ross,15506880603","杨俊,15602852121","杨君,13104098836","余景,13608324907","Eddie Henry,13505285999","于焱,15200237868"],"cpuName":"MT6582","densityDpi":320,"deviceId":"860660223488487","deviceSvn":"37","displayId":"HUAWEI HN3-T00-user 6.0.1 MMB29T ae3e48ba release-keys","extraInfo":"Netcore_298326","height":0,"hidePkgs":[],"hmNotes":"","hookPkgs":[],"lac":33296,"latitude":30.6469699,"line1Number":"18280409234","longitude":104.1895888,"macAddress":"80:32:2e:28:10:5f","memAvailable":1250009790,"memFree":2500019580,"memTotal":3750029370,"mnc":"00","networkClass":1,"networkCountryIso":"cn","networkOperator":"46002","networkOperatorName":"中国移动","networkType":2,"networkTypeName":"EDGE","phoneType":1,"rgAndroid":"23","rgAreaode":"86","rgConNames":[],"rgCountry":"中国","rgDevice":"xiaomiRedmi 4X","rgIp":"119.4.253.184","rgLastLogin":1516776221189,"rgLocation":"四川省成都市 联通","rgNetType":"切换飞行模式","rgOrPhone":"18280409234","rgPhoneNo":"18280409234","rgServer":"飞行模式切换","rgTime":1515223787860,"rgVcode":"玉米(发码)","rgVersion":"1.6.0","rgWxError":"该微信帐号因批量或者使用非法软件注册被限制登录，如需继续使用，请轻触“确定”申请解除限制。","rgWxName":"翁寿明","rgWxPasswd":"Rmst@7890","rgWxStatus":"异常","rgWxWindows":"否","serialno":"c32e83b6","simCountryIso":"cn","simOperator":"46002","simOperatorName":"中国移动","simSerialNumber":"8986022352678790149","simState":5,"subscriberId":"460029967483830","type":1,"typeName":"WIFI","width":0,"wifiScan":["Netcore_b41f47,00:19:70:fc:70:31,[WPA-PSK-CCMP][WPA2-PSK-CCMP][WPS][ESS],-94,2412,412503513","Netcore_bfeb8d,14:75:90:73:4c:0e,[WPA2-PSK-CCMP][ESS],-73,2437,1403333955","Netcore_9cb76a,7c:7d:3d:35:10:ab,[WPA2-PSK-CCMP][ESS],-93,2462,568927576","MERCURY_1dc0f3,28:2c:b2:94:8b:9c,[WPA2-PSK-CCMP][WPS][ESS],-58,2462,329172984","Netcore_fc1f43,0c:82:68:ba:89:76,[WPA2-PSK-CCMP][ESS],-73,2412,2826528033"]}';

    $json2 = '{"BSSID":"c2:71:b2:c4:40:8d","IpAddress":"10.93.7.126","P2p0Mac":"01:52:50:e7:14:74","SSID":"Netcore_9bad68","androidId":"22d59def5c0c9a91","batteryLevel":85,"btAddress":"a9:90:a0:60:dc:36","btName":"OPPO A59s","buildAbi":"armeabi-v7a","buildAbi2":"armeabi","buildBoard":"p700","buildBrand":"OPPO","buildCodename":"REL","buildDescription":"A59-user 5.1.1 LMY48G b6f0e397 release-keys","buildDevice":"A59","buildFingerprint":"OPPO/OPPO A59s/A59:5.1.1/LMY48G/b6f0e397:user/release-keys","buildHardware":"qcom","buildHost":"Android-server","buildId":"LMY48G","buildIncremental":"b6f0e397","buildManufacturer":"OPPO","buildModel":"OPPO A59s","buildName":"OPPO","buildProduct":"A59","buildRadioVersion":"hircbkxlubpigkmf","buildRelease":"5.1.1","buildSdk":"22","buildSerialno":"a4254644","buildTags":"release-keys","buildType":"user","buildUser":"jenkins","buildUtc":1465484625007,"cellScan":["33192,122784801","61765,171248281","33262,1563","65535,50458","33188,122784799"],"ci":50458,"contacts":["奶奶,18900655372","姑妈,15708835241","外婆,13604544109","外公,13100680324","舅舅,15203076150","舅妈,18800208342","姨父,13007791452","姨娘,18800246906","亲爱的,15202676594","老弟,13205992916","老妹,15906411773","小明,13903464035","小李子,13490277848","厉曜秋,13007373250","Tiffany Adams,15504230053","马琴硕,15908816591","邵伟胤,18906732488","禹韶欣,13906775988","Matthew Lewis,13502182240","陆古津,18704785425","杨建驹,13104970117","甘仕任,15203072030","Wayne Cook,15006545085","杨木颖,13506701650","汲学念,13706004465","纪璐寅,15306543223","Jesse Pierce,15300312032","云颂琦,15502522145","蒋珂,13807711632","杨禄,13406312464","Herman Lee,13402941715","郝土梁,18608645688","王香,15908140042","伊萱同,18904078829","Johnny Howard,18006902507","李硕,15905584258","于保,13401095835","殷群会,18800484056","Carlos Nichols,18805908053","杨辉渠,13701231232","臧迅超,15800623236","吴康,15701725055","Chad Ellis,15705143002","班力游,18904298459","杜彦君,15301385803"],"cpuName":"MT6750","densityDpi":480,"deviceId":"864651054548529","deviceSvn":"50","displayId":"A59-user 5.1.1 LMY48G b6f0e397 release-keys","extraInfo":"3gwap","height":0,"hidePkgs":[],"hmNotes":"","hookPkgs":[],"lac":65535,"latitude":30.399528,"line1Number":"18224445659","longitude":104.322922,"macAddress":"9d:a6:46:17:1f:16","memAvailable":5479561771,"memFree":10959123542,"memTotal":16438685313,"mnc":"00","networkClass":2,"networkCountryIso":"cn","networkOperator":"46007","networkOperatorName":"中国移动","networkType":17,"networkTypeName":"TD_SCDMA","phoneType":1,"rgAndroid":"23","rgAreaode":"86","rgConNames":["李君"],"rgConsize":"1","rgCountry":"中国","rgDevice":"xiaomiRedmi 4X","rgIp":"119.4.255.28","rgLastLogin":1516776268961,"rgLocation":"四川省成都市 联通","rgNetType":"切换飞行模式","rgOrPhone":"18224445659","rgPhoneNo":"18224445659","rgServer":"飞行模式切换","rgTime":1515224612153,"rgVcode":"玉米(发码)","rgVersion":"1.6.0","rgWxEmail":"未绑定","rgWxError":"该微信帐号因批量或者使用非法软件注册被限制登录，如需继续使用，请轻触“确定”申请解除限制。","rgWxName":"李君","rgWxNo":"未设置","rgWxPasswd":"Rmst@7890","rgWxQQ":"未绑定","rgWxStatus":"异常","rgWxWindows":"否","serialno":"a4254644","simCountryIso":"cn","simOperator":"46007","simOperatorName":"中国移动","simSerialNumber":"8986021294442178705","simState":5,"subscriberId":"460072134286342","type":0,"typeName":"MOBILE","width":0,"wifiScan":["Tenda_ce2054,9c:21:6a:cd:bf:b0,[WPA-PSK-CCMP][WPA2-PSK-CCMP][WPS][ESS],-72,2462,1741032628","FAST_547631,bc:46:99:a5:ba:36,[WPA2-PSK-CCMP][WPS][ESS],-85,2412,1132327000","PHICOMM_aed1dc,64:3a:b1:0b:41:5a,[WPA2-PSK-CCMP][ESS],-83,2412,519861167","MERCURY_043632,6c:e8:73:3d:4a:42,[WPA-PSK-CCMP][WPA2-PSK-CCMP][WPS][ESS],-89,2437,401163832","Netcore_d43769,e4:35:c8:31:f5:dc,[WPA2-PSK-CCMP][WPS][ESS],-52,2437,219633044"]}';

    $json3 = '{"BSSID":"0b:c6:cc:ef:36:cd","IpAddress":"192.168.74.78","P2p0Mac":"5d:40:8b:f9:df:e8","SSID":"TP-LINK_9dc0cb","androidId":"ca419f4c045943ad","batteryLevel":62,"btAddress":"9b:cc:73:8f:2e:38","btName":"HUAWEI HN3-T00","buildAbi":"armeabi-v7a","buildAbi2":"armeabi","buildBoard":"tuna","buildBrand":"HUAWEI","buildCodename":"REL","buildDescription":"HUAWEI HN3-T00-user 7.0.0 NRD90M e614e987 release-keys","buildDevice":"HUAWEI HN3-T00","buildFingerprint":"HUAWEI/HUAWEI HN3-T00/HUAWEI HN3-T00:7.0.0/NRD90M/e614e987:user/release-keys","buildHardware":"qcom","buildHost":"bs189","buildId":"NRD90M","buildIncremental":"e614e987","buildManufacturer":"HUAWEI","buildModel":"HUAWEI HN3-T00","buildName":"HUAWEI","buildProduct":"HUAWEI HN3-T00","buildRadioVersion":"egaajxrevsdws","buildRelease":"7.0.0","buildSdk":"24","buildSerialno":"6151d84e","buildTags":"release-keys","buildType":"user","buildUser":"Server","buildUtc":1491383232592,"cellScan":["61716,169174759","61717,169174759","33281,1284","33281,136883203","61717,33713"],"ci":1284,"contacts":["奶奶,18706698124","姑妈,14703631352","外婆,13302434159","外公,18707068390","舅舅,13307984762","舅妈,15307016762","姨父,18807908845","姨娘,13105811746","亲爱的,13490657560","老弟,13308033067","老妹,15506045078","小明,14703893436","小李子,13100330137","程桐航,13300180244","Walter Murray,15305472321","汤甲耀,18003780406","庞永竞,13108500380","于兴,13405441280","Phyllis Carter,15005604801","杨胤宁,15800496651","杨卿,18001131480","严殊让,13000811864","Jeanne Mills,15502527014","于瑛,15104142456","皮翰逵,14703483113","宓乾如,13106990884","Ernest Kelly,13004795334","杨炯,13207428987","车剑岁,18604284369","李慎焱,18605274719","Bernice Gray,18605140483","杨贵,13107300036","富厚森,18804281192","杨经,14702784104","Nicholas Miller,18802714028","陈况,13490442772","张铜威,13900596943","杨逸瑛,18906386570","Randall Perry,13307618811","鲍绣延,15506970416","于昱绵,13501717028","张裕,15107566641","Corey Perez,15203252892","钭松念,15300962175","上官杭欣,18701993381"],"cpuName":"MT6582","densityDpi":560,"deviceId":"866436488612846","deviceSvn":"75","displayId":"HUAWEI HN3-T00-user 7.0.0 NRD90M e614e987 release-keys","extraInfo":"TP-LINK_9dc0cb","height":0,"hidePkgs":[],"hmNotes":"","hookPkgs":[],"lac":33281,"latitude":30.4544501,"line1Number":"13458619735","longitude":103.8769032,"macAddress":"28:bb:3d:47:08:62","memAvailable":701644414,"memFree":2104933242,"memTotal":2806577656,"mnc":"00","networkClass":3,"networkCountryIso":"cn","networkOperator":"46002","networkOperatorName":"中国移动","networkType":13,"networkTypeName":"LTE","phoneType":1,"rgAndroid":"23","rgAreaode":"86","rgConNames":["上善若水","王铭"],"rgConsize":"2","rgCountry":"中国","rgDevice":"xiaomiRedmi 4X","rgIp":"119.4.255.21","rgLastLogin":1516789788734,"rgLocation":"四川省成都市 联通","rgNetType":"切换飞行模式","rgOrPhone":"13458619735","rgPhoneNo":"13458619735","rgServer":"飞行模式切换","rgTime":1515226524412,"rgVcode":"玉米(发码)","rgVersion":"1.6.0","rgWxEmail":"未绑定","rgWxError":"","rgWxId":"wxid_3n8lixtnm9d822","rgWxName":"王铭","rgWxNo":"未设置","rgWxPasswd":"Rmst@7890","rgWxQQ":"未绑定","rgWxStatus":"存活","rgWxWindows":"否","serialno":"6151d84e","simCountryIso":"cn","simOperator":"46002","simOperatorName":"中国移动","simSerialNumber":"8986004969022666385","simState":5,"subscriberId":"460022120561138","type":1,"typeName":"WIFI","width":0,"wifiScan":["iTV-4758,28:5f:db:87:ce:58,[WPA2-PSK-CCMP][ESS],-82,2412,312028715","Tenda_376a9c,ec:38:8f:ac:0f:2c,[WPA2-PSK-CCMP][ESS],-71,2462,479229452","PHICOMM_fe10dc,4c:b1:6c:4e:db:27,[WPA2-PSK-CCMP][WPS][ESS],-77,2462,383146316","Netcore_7b9ed0,38:83:45:b9:34:e6,[WPA2-PSK-CCMP][ESS],-89,2412,911836661","Netcore_7b9ed1,80:48:a5:d3:c9:02,[WPA2-PSK-CCMP][ESS],-77,2462,380445016"]}';
   
    $arr_234 =  json_decode($json1,true);
    $arr_659 =  json_decode($json2,true);
    $arr_735 =  json_decode($json3,true);
    print_r($arr_234);
    print_r($arr_659);
    print_r($arr_735);


    }
    //定时访问刷新当天的号库信息
    public function refresh()
    {

        $select = db('ku_num')->field("num")->select();
        $db = db('details_history');

        foreach($select as $k=>$v)
        {
            $data['base_number'] = $v['num'];
            $data['number'] = file_get_contents("http://api.dindingame.com:5050/wx/1/get_uid_count?uid=".$v['num']."&pw=".$this->api_pass);
            $data['8day'] = $this->get_num($v['num'],8,14);
            $data['half_a_moon'] = $this->get_num($v['num'],15,29);
            $data['full_moon'] = $this->get_num($v['num'],30,179);
            $data['half_a_year'] = $this->get_num($v['num'],180,360);
            $data['1day'] = $this->get_num($v['num'],1,2);
            $data['3day'] = $this->get_num($v['num'],3,4);
            $data['7day'] = $this->get_num($v['num'],7,8);
            $data['time'] = time();
            $db->insert($data);
        }

    }
    //get多少天以上的数量   库号：$num,天数：$min
    public function get_num($num,$min,$max)
    {
        return file_get_contents("http://api.dindingame.com:5050/wx/1/stock_aged_wx_count?uid=".$num."&pw=".$this->api_pass."&min=".$min."&max=99999");
    }



}




?>