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
use think\Db;

error_reporting(E_ERROR | E_PARSE );
// 应用公共文件
function read_dir($dir){  
	//echo date("Y-m-d H:i:s",strtotime("20171212"));die;
    $files=array();  
    $dir_list=scandir($dir);  
    foreach($dir_list as $file){  
        if($file!='..' && $file!='.'){  
            if(is_dir($dir.'/'.$file)){  
                $files[$file]=read_dir($dir.'/'.$file);  
            }else{  
            	$kh = explode("/",$dir)[6]; //库号
            	//$date = explode("/",$dir)[7]; //日期
             	$date = substr($file,-13);
              	$date = substr($date,0,8);
            	$content = file_get_contents($dir."/".$file);
            	if($kh && $date)
            	{
            		if(!Db::table('register')->where(["base_number"=>$kh,"date"=>date("Y-m-d H:i:s",strtotime($date))])->find())
            		{
            		
            			$save = [
							"base_number"=>$kh,
							"date"=>date("Y-m-d H:i:s",strtotime($date)),
							"registrations" =>0,
						];
						Db::table('register')->insert($save);
						//print_r($save);
            		}

						$z = json_decode($content,true)["rgWxStatus"] == "存活" ? "registrations" : "bf_num";
						$data = array(
							  $z=>array('exp',$z.'+1'),
							  'zc_num'=>array('exp','zc_num+1'),
						);
	        			Db::table('register')->where(["base_number"=>$kh,"date"=>date("Y-m-d H:i:s",strtotime($date))])->update($data);
            		
            	}
            	
			//echo '库号：'.$kh."日期：".$date."文件：".$file."内容：".."<br>";
            	

            	
                $files[]=$file;  
            }  
        }  
    }  
    return $files;  
}  
//队列方式   
function read_dir_queue($dir){  
    $files=array();  
    $queue=array($dir);  
    while($data=each($queue)){  
        $path=$data['value'];  
        if(is_dir($path) && $handle=opendir($path)){  
            while($file=readdir($handle)){  
                if($file=='.'||$file=='..') continue;  
                $files[] = $real_path=$path.'/'.$file;  
                if (is_dir($real_path)) $queue[] = $real_path;  
            }  
        }  
        closedir($handle);  
    }  
     return $files;  
} 

/**
* $str 原始中文字符串
* $encoding 原始字符串的编码，默认utf-8
* $prefix 编码后的前缀，默认"&#"
* $postfix 编码后的后缀，默认";"
*/
function unicode_encode($str, $encoding = 'utf-8', $prefix = '&#', $postfix = ';') {
    //将字符串拆分
    $str = iconv("UTF-8", "gb2312", $str);
    $cind = 0;
    $arr_cont = array();
 
    for ($i = 0; $i < strlen($str); $i++) {
        if (strlen(substr($str, $cind, 1)) > 0) {
            if (ord(substr($str, $cind, 1)) < 0xA1) { //如果为英文则取1个字节
                array_push($arr_cont, substr($str, $cind, 1));
                $cind++;
            } else {
                array_push($arr_cont, substr($str, $cind, 2));
                $cind+=2;
            }
        }
    }
    foreach ($arr_cont as &$row) {
        $row = iconv("gb2312", "UTF-8", $row);
    }
 
    //转换Unicode码
    foreach ($arr_cont as $key => $value) {
        $unicodestr.= $prefix . base_convert(bin2hex(iconv('utf-8', 'UCS-4', $value)), 16, 10) .$postfix;
    }
 
    return $unicodestr;
}
 
/**
* $str Unicode编码后的字符串
* $decoding 原始字符串的编码，默认utf-8
* $prefix 编码字符串的前缀，默认"&#"
* $postfix 编码字符串的后缀，默认";"
*/
function unicode_decode($unistr, $encoding = 'utf-8', $prefix = '&#', $postfix = ';') {
    $arruni = explode($prefix, $unistr);
    $unistr = '';
    for ($i = 1, $len = count($arruni); $i < $len; $i++) {
        if (strlen($postfix) > 0) {
            $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
        }
        $temp = intval($arruni[$i]);
        $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
    }
    return iconv('UCS-2', $encoding, $unistr);
}