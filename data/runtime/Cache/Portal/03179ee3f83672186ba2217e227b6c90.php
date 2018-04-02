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
			<li><a href="<?php echo U('AdminYouxi/hall');?>">总大厅路由</a></li>
			<li class="active"><a href="<?php echo U('AdminYouxi/Add_Hall',['type'=>'add']);?>">添加路由</a></li>
		</ul>
		<form class="form-horizontal js-ajax-form" action="<?php echo ($action); ?>" method="post">
			<fieldset>

				<div class="control-group" >
					<label class="control-label">路由名称:</label>
					<div class="controls" >
                        <input type="text" style="color: red" name="theme_name" value="<?php echo ($data["theme_name"]); ?>" required >
					</div>
				</div>
				<div class="control-group" >
					<label class="control-label">路由地址:</label>
					<div class="controls" >
						<input type="text" style="color: red" name="url" value="<?php echo ($data["url"]); ?>" required >
					</div>
				</div>
				<div class="control-group" >
					<label class="control-label">主题参数:</label>
					<div class="controls" >
						关闭<input type="radio" style="color: red" name="status" value="0" <?php if($data['status'] == 0) echo 'checked';?>  >
						&nbsp;&nbsp;&nbsp;&nbsp;
						开启<input type="radio" style="color: red" name="status" value="1"  <?php if($data['status'] == 1) echo 'checked';?> >
					</div>
				</div>
				<div class="control-group" >
					<label class="control-label">主题参数:</label>
					<div class="controls" >
						<input type="text" style="color: red" name="skin" value="<?php echo ($data["skin"]); ?>" required >
					</div>
				</div>



			</fieldset>
			<div class="form-actions">
				<?php $opertion = ['delete'=>'删除','add'=>'添加','update'=>'修改'];?>
				<button type="submit" class="btn btn-primary  js-ajax-submit"><?php echo $opertion[$_GET['type']] ? $opertion[$_GET['type']] :'添加'; ?></button>
				<a class="btn" href="javascript:history.back(-1);">返回</a>
			</div>
		</form>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>