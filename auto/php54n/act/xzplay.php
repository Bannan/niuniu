<?php
    $id=$data2['id'];
    $msg=array();
    $msg['id']='selectBanker'.$data2['id'];
    $msg['html']='active';
    act('active',$msg,$connection);
    $play=$db->getOne("select * from jz_rule where id='".$id."' and zt=1 order by sort");


    $msg=array();
    $msg['id']='setting';
    $msg['html']='';

    if($play['df']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle nameText-cl">底分（计分牌）</div>
                <div class="selectList selectList-cl">
                    <div class="flex-cont flex-item">
                        <div class="prev"></div><div class="radio flex-item">';
        $list=explode(',',$play['df']);
        foreach ($list as $key => $value) {
            isset($value1) ? '' : $value1 = $value;
            $msg['html'].='<div class="selectItem" style="display:none;" id="df'.$key.'" onclick="send(\'rule\',{id:\'df\',key:'.$key.'})">
                            <div class="selectBox selectBox-cl"></div>
                            <div class="selectText">'.$value.'分</div>
                           </div>
                            <div class="on cl" data-item="'.$value.'" data-pos="'.$key.'"></div>
                            '
                           ;
            }
        $msg['html'].='<span class="showNumber" data-pos="1" data-item=""><i>'.$value1.'</i></span></div><div class="next"></div></div></div><div style="clear: both;"></div>
            </div>';
    }

    /*if($play['df']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">底分：</div>
                <div class="selectList">';
        $list=explode(',',$play['df']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="df'.$key.'" onclick="send(\'rule\',{id:\'df\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'分</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }*/

    if($play['gz']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">规则：</div>
                <div class="selectList">';
        $list=explode(',',$play['gz']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="gz'.$key.'" onclick="send(\'rule\',{id:\'gz\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }

    if($play['gz2']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">规则：</div>
                <div class="selectList">';
        $list=explode(',',$play['gz2']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="gz2'.$key.'" onclick="send(\'rule\',{id:\'gz2\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }


    if($play['px']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">牌型：</div>
                <div class="selectList">';
        $list=explode(',',$play['px']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="px'.$key.'" onclick="send(\'rule\',{id:\'px\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl-fk"></div>
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }

    if($play['js']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">局数：</div>
                <div class="selectList">';
        $list=explode(',',$play['js']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="js'.$key.'" onclick="send(\'rule\',{id:\'js\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'</div>
                        <img class="mask-inning-card" src="http://cdn.lfzgame.com/images/index/mask-inning-card.png">
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }

    if($play['sz']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">上庄：</div>
                <div class="selectList">';
        $list=explode(',',$play['sz']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="sz'.$key.'" onclick="send(\'rule\',{id:\'sz\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }


    if($play['cm']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">筹码：</div>
                <div class="selectList">';
        $list=explode(',',$play['cm']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="cm'.$key.'" onclick="send(\'rule\',{id:\'cm\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }


    if($play['sx']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">上限：</div>
                <div class="selectList">';
        $list=explode(',',$play['sx']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="sx'.$key.'" onclick="send(\'rule\',{id:\'sx\',key:'.$key.'})">
                        <div class="selectBox selectBox-cl"></div>
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }

    if($play['zm']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">抓马：</div>
                <div class="selectList">';
        $list=explode(',',$play['zm']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="zm'.$key.'" onclick="send(\'rule\',{id:\'zm\',key:'.$key.'})">
                        <div class="selectBox"></div>
                        <img src="/app/style-cl/img/feiying/mask-checked.png" class="mask-img">
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }


    if($play['gp']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">鬼牌：</div>
                <div class="selectList">';
        $list=explode(',',$play['gp']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="gp'.$key.'" onclick="send(\'rule\',{id:\'gp\',key:'.$key.'})">
                        <div class="selectBox"></div>
                        <img src="/app/style-cl/img/feiying/mask-checked.png" class="mask-img">
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }

    if($play['gd']){
        $msg['html'].='<div class="selectPart">
                <div class="selectTitle">锅底：</div>
                <div class="selectList">';
        $list=explode(',',$play['gd']);
        foreach ($list as $key => $value) {
            $msg['html'].='<div class="selectItem" id="gd'.$key.'" onclick="send(\'rule\',{id:\'gd\',key:'.$key.'})">
                        <div class="selectBox"></div>
                        <img src="/app/style-cl/img/feiying/mask-checked.png" class="mask-img">
                        <div class="selectText">'.$value.'</div>
                    </div> ';
        }
        $msg['html'].='</div><div style="clear: both;"></div>
            </div>';
    }
    act('html',$msg,$connection);


    $data=array();
    $data['act']='rule';
    $data['play']=$play;
    reqact($data,$connection);
        