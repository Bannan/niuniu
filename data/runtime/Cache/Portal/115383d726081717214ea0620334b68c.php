<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="javascript:;">游戏玩法</a></li>
        <li><a href="<?php echo U('AdminYouxi/Add_Hall');?>">添加玩法</a></li>
    </ul>

    <form class="js-ajax-form">

        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
                <th width="50">ID</th>
                <th>路由名称</th>
                <th>路由地址</th>
                <th>主题参数</th>
                <th>状态</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <?php $status['1']='开启'; $status['0']='关闭'; ?>

            <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
                    <td><b><?php echo ($vo["id"]); ?></b></td>
                    <td><?php echo ($vo["theme_name"]); ?></td>
                    <td><?php echo ($vo["url"]); ?></td>
                    <td><?php echo ($vo["skin"]); ?></td>
                    <td><?php echo ($status[$vo['status']]); ?></td>

                    <td><?php echo date('Y-m-d H:i:s',$vo['update_time']);?></td>
                    <td>
                        <!-- <a href="<?php echo U('AdminPost/edit',array('id'=>$vo['id']));?>"><?php echo L('EDIT');?></a> | -->

                        <a href="<?php echo U('AdminYouxi/Add_Hall',['id'=>$vo['id'],'type'=>'update']);?>">修改</a>

                        <a  href="<?php echo U('AdminYouxi/Add_Hall',['id'=>$vo['id'],'type'=>'delete']);?>" class="js-ajax-delete" >删除</a>
                    </td>
                </tr><?php endforeach; endif; ?>

        </table>

    </form>
</div>
<script src="/public/js/common.js"></script>


</body>
</html>