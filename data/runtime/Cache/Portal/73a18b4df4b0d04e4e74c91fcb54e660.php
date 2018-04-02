<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="棋牌">
    <!-- Mobile Devices Support @begin -->
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" />
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <!-- Mobile Devices Support @end -->
    <title>聚贤娱乐</title>

    <link href="/app/css/hall_listnew.css" rel="stylesheet" media="all" />
    <link href="/app/css/hall_index.css" rel="stylesheet" media="all" />

    <link href="/app/css/hall_dialog1.css" rel="stylesheet" media="all" />

    <script src="/app/js/homepage/jq.js"></script>

    <style type="text/css">

    </style>
    <script type="text/javascript">
        $(function(){
            $('img[rrurl]').click(function(){
                location.href = $(this).attr('rrurl');
            });
            $('table').attr("cellpadding","0").attr("cellspacing","0");
            $('[fixed="fixed"]').css('position','fixed');
            resize();
            $(window).resize(function(){
                resize();
            });
            $('.add_qq_more').each(function(){
                var tourl = $.trim($(this).attr('toto'));
                if(tourl ==''){
                    tourl = 'javascript:;'
                }
                if(tourl.indexOf(':')==-1){
                    tourl = tourl+'.html';
                }
                if(tourl !=''){
                    if(tourl.indexOf('tel')!==0){
                        if(tourl.indexOf('?')>0){
                            tourl = tourl + '';
                        }else{
                            tourl = tourl + '';
                        }
                    }
                    if($(this).is('a')){
                        $(this).attr('href',tourl);
                    }else if($(this).find('a').size()>0){
                        $(this).find('a').each(function(){
                            if($.trim($(this).attr('href')).indexOf('http')==-1){
                                $(this).attr('href',tourl);
                            }
                        });
                    }else{
                        $(this).wrap('<a href="'+tourl+'"></a>');
                    }
                }
            });
            if($('.mainpicarea').is('div')){
                var tplth = $('.mainpicarea').find('td').length;
                $('#ppoool').append('<li class="on" style="margin-left:5px;"></li>');
                for(var i=1;i
                <tplth;i++){ $('#ppoool').append('<li style="margin-left:5px;"></li>');
                }
                $('.mainpicarea').qswipe({ stime:3600});
                $('.mainpicarea').on('dragok',function(e,msg){
                    if((msg+'').indexOf('.')>0){
                        msg = 0;
                    }
                    $('#ppoool').find('li').removeClass('on');
                    $('#ppoool').find('li').eq(msg).addClass('on');

                });
            }
        });
        function resize(){
            var ww = $(window).width();
            $('.picshowtop,.mainpicshow').css('width',ww+'px');
            $('#tpdhtr').children('td').css('width',ww+'px');
            $('#tpdhtr').children('td').find('img').css('width',ww+'px');
            $('img').each(function(){
                var pw = $(this).parent().width();
                var ppw = $(this).parent().parent().width();
                if($(this).width()>ppw){
                    $(this).width(ppw);
                }
            });
        }
    </script>



</head>
<body>

<div style="top:0px;left:0px;width: 100%;height: 100%;position: fixed;z-index:-999;background-image: url('/app/img/hall_6.jpg');background-size:100%,100%;">
</div>
<div class="picshowtop" style="position: relative;">
    <div class="mainpicshow" style="height: 170px;">
        <div class="mainpicarea" style="height: 170px;">
            <table cellpadding="0" cellspacing="0" style="border: medium; border-image: none; height: 170px;">
                <tbody>
                <tr id="tpdhtr"><td><img src="" rrurl=""></td></tr>
                </tbody>
            </table>
        </div>
    </div><div style="position: absolute;width: 100%;height: 20px;bottom: 0px;" id="ppooind">
    <ol id="ppoool"></ol>
</div>
</div>
<div class="mainshowtop" style="z-index:100;">
    <div id="mainmenu27" style="position:absolute;">
        <ul>


        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><li class='add_qq_more' toto='<?php echo ($vo["url"]); echo ($vo["skin"]); ?>'>
                <a href='javascript:;'>
                    <button class='wz_27_buttom m_text' type='button'><?php echo ($vo["theme_name"]); ?></button>
                </a>
            </li><?php endforeach; endif; ?>

            <div style="clear:both;"></div>
        </ul>
    </div>
</div>

</body>
</html>