<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
	<link href="/public/simpleboot/themes/flat/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/layui/base.css" rel="stylesheet">
</head>
<body>
    <div class="wrap">
    	<ul class="nav nav-tabs">
            <li class="active"><a href="#">修改记录</a></li>
        </ul>
        <form class="well form-search" method="GET">
            类型： 
        	<select name="typelx" style="width: 120px;" id="type" >
                <option value="0" <?php if($_GET['type'] == 0) echo 'selected ';?>>全部</option>
                <option value="1" <?php if($_GET['type'] == 1) echo 'selected ';?>>透视</option>
                <option value="2" <?php if($_GET['type'] == 2) echo 'selected ';?>>到期时间</option>
                <option value="3" <?php if($_GET['type'] == 3) echo 'selected ';?>>两者</option>
            </select>
            会员ID：
            <input type="text"  id="id" value="<?php if(isset($_GET['id']))echo $_GET['id'];?>" style="width: 200px;line-height: 35px;height: 35px;" required="" placeholder="请输入会员ID" class="layui-input">
            按时间段搜索：
            <input type="text"  value="<?php if(isset($_GET['date'])) echo explode('~',$_GET['date'])[0];?>" style="width: 140px;line-height: 35px;height: 35px;" id="time_1" required="" placeholder="" lay-key="1">
            <input type="text"  value="<?php if(isset($_GET['date']))echo explode('~',$_GET['date'])[1];?>" style="width: 140px;line-height: 35px;height: 35px;" id="time_2" required="" placeholder="" lay-key="2">
            <input type="button" class="btn btn-primary js-ajax-submit" value="查找" class="layui-input" onclick = "search_history()">
        </form>
        <div class="well form-search">
			<label class="control-label col-md-2" style="line-height: 35px;width: auto;">快捷搜索：</label>
			<a href="javascript:" class="btn btn-success btn-small" onclick="time_href(1,this);">1天</a>
			<a href="javascript:" class="btn btn-success btn-small" onclick="time_href(3,this);">3天</a>
			<a href="javascript:" class="btn btn-success btn-small" onclick="time_href(7,this);">7天</a>
			<a href="javascript:" class="btn btn-success btn-small" onclick="time_href(15,this);">15天</a>
			<a href="javascript:" class="btn btn-success btn-small" onclick="time_href(30,this);">30天</a>
        </div>
        <table class="table table-hover table-bordered table-list">
            <thead>
                <tr>
                    <!--<th width="50">排序</th>-->
                    <th width="50">用户ID</th>
                    <th>用户名</th>
                    <th>昵称</th>
                    <th>操作类型</th>
                    <th>操作内容</th>
					<th>操作管理员</th>
					<th>修改时间</th>
					<th>IP地址</th>
                </tr>
            </thead>
            <tbody>
            <?php $txt = [' ','透视','功能到期时间','两者同时修改']; ?>
			<?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
                    <td><?php echo ($vo["user_id"]); ?></td>
                    <td><?php echo ($vo["user_name"]); ?></td>
                    <td><?php echo ($vo["nick_name"]); ?></td>
                    <td><?php echo $txt[$vo['opertion_type']];?></td>
                    <td><?php echo ($vo["content"]); ?></td>
                    <td><?php echo ($vo["admin_name"]); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$vo['create_time']);?></td>
                    <td><?php echo ($vo["ip"]); ?></td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
        <div class="pagination"><?php echo ($page); ?></div>
    </div>

    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/layui/laydate/laydate.js"></script>
	<script src="/public/js/layui/layer/layer.js"></script>
	<script>
		//操作管理修改记录查询
		laydate.render({
		  elem: '#time_1'
		});

		laydate.render({
		  elem: '#time_2'
		});
	</script>
    <script>
        function search_history() {
        	var type = $("#type option:selected").val();
        	var id = document.getElementById("id").value;
        	var time_1 = document.getElementById("time_1").value;
        	var time_2 = document.getElementById("time_2").value;
        	var url = "<?php echo U('AdminUser/change_history');?>";

        	window.location.href = url+"?date="+time_1+"~"+time_2+"&id="+id+'&type='+type;
        }
    </script>
    <script>
    	function time_href(days,_this) {
			var d=new Date(); 

			var new_time = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate(); //新的时间

			d.setDate(d.getDate() - days); 
			var month = d.getMonth() + 1; 
			var day = d.getDate(); 
			if(month<10){ 
				month = "0" + month; 
			} 
			if(day<10){ 
				day = "0" + day; 
			} 
			var old_time = d.getFullYear() + "-" + month + "-" + day; //过去的时间

			//获取浏览器中的url
			var win_url = "<?php echo U('AdminUser/change_history');?>";
			_this.href = win_url + "?date=" + old_time + "~" + new_time;
		}
    </script>
</body>
</html>