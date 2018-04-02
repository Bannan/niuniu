<?php
    $id=$data2['id'];
    $server=$db->getOne("select * from jz_server where type='".$id."' and zt=1 order by num asc");
    // if(!$server){
    //     act('zhengzkf','',$connection);
    //     return false;
    // }
    $playlist=$db->getAll("select * from jz_rule where type='".$id."' and zt=1 order by sort");
    $msg=array();
    $msg['id']='room';
    $msg['html']=' <div class="createRoomBack"></div>
    <div class="mainPart" style="height: auto;">  
    <div class="content-box">
    <i class="mask-icon mask-top"></i>
    <i class="mask-icon mask-right"></i>
    <i class="mask-icon mask-bottom"></i>
    <i class="mask-icon mask-left"></i>
    <div class="createB"></div>
    <div class="createTitle">
        <img src="/app/files/d_11/images/common/createroom2.png">
    </div>              
    <div class="cancelCreate" onclick="cancelCreate()"></div>';

    if(count($playlist)>1){
        $msg['html'].='<div class="scope xuanzefj-nav">';
        foreach ($playlist as $key => $value) {
            $msg['html'].='<div  id="selectBanker'.$value[id].'" onclick="send(\'xzplay\',{id:'.$value[id].'})" class="selectBanker'.($key+1).' bankerUnSelected">
                <div class="img niuniusz niuniuselect"></div>
                <div class="img niuniusz niuniuunselect"></div>
                <p class="xuanzefj-nav-1">'. mb_substr($value['name'],0,2,'utf-8').'</p>
                <p class="xuanzefj-nav-2" style="">'.mb_substr($value['name'],2,2,'utf-8').'</p>
            </div>';
        }
        $msg['html'].='</div>';
    }
    $msg['html'].='<div class="blueBack" style="height: auto;">
        <div class="bullRull scope" id="setting"></div>
        <div class="xuanzefj-top-zt" style="">
            <div class="selectTitle xuanzefj-top">
                创建房间,无人参与,半小时后返还房卡
            </div>
        </div>
    </div>
    <div class="createCommit" onclick="send(\'openroom\',{})"></div>';
    act('html',$msg,$connection);

    $msg=array();
    $msg['id']='room';
    act('showid',$msg,$connection);

    $data['act']='xzplay';
    $data['id']=$playlist['0']['id'];
    reqact($data,$connection);
