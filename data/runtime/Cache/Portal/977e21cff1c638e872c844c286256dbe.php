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
            <li class="active"><a href="#">修改统计</a></li>
        </ul>
        <form class="well form-search" method="GET">
            按时间段搜索：
            <input type="text" name="sdate" value="<?php if(isset($_GET['date'])) echo explode('~',$_GET['date'])[0];?>" style="width: 140px;line-height: 35px;height: 35px;" id="time_1" required="" placeholder="" lay-key="1">
            <input type="text" name="edate" value="<?php if(isset($_GET['date']))echo explode('~',$_GET['date'])[1];?>" style="width: 140px;line-height: 35px;height: 35px;" id="time_2" required="" placeholder="" lay-key="2">
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
       	<div class="form-group">
			<script src="/public/js/layui/echarts.min.js"></script>
			<div id="main_cl" style="width: auto;height: 430px;"></div>
			<script type="text/javascript">
		        // 基于准备好的dom，初始化echarts实例
		        var myChart = echarts.init(document.getElementById('main_cl'));

		        data = <?php echo ($datelist); ?>;

				var dateList = data.map(function (item) {
				    return item[0];
				});
				var valueList = data.map(function (item) {
				    return item[1];
				});

				option = {

				    // Make gradient line here
				    visualMap: [{
				        show: false,
				        type: 'continuous',
				        seriesIndex: 0,
				        min: 0,
				        max: 400
				    }],

				    title: [{
				        left: 'center',
				        text: '修改统计'
				    }],
				    tooltip: {
				        trigger: 'axis'
				    },
				    xAxis: [{
				        data: dateList
				    }],
				    yAxis: [{
				        splitLine: {show: false}
				    }],
				    grid: [{
				        bottom: '10%'
				    }],
				    series: [{
				        type: 'line',
				        showSymbol: false,
				        data: valueList,
				        lineStyle:{
				            normal:{
				                color: "#f5260f"  //连线颜色
				            }
				        }
					}]
				};
		        // 使用刚指定的配置项和数据显示图表。
		        myChart.setOption(option);
		    </script>
        </div>
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
        	var time_1 = document.getElementById("time_1").value;
        	var time_2 = document.getElementById("time_2").value;
        	var url = "<?php echo U('AdminUser/change_statis');?>";

        	if (time_1&&time_2) {
        		window.location.href = url+"?date="+time_1+"~"+time_2;
        	} 
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
			var win_url = "<?php echo U('AdminUser/change_statis');?>";
			_this.href = win_url + "?date=" + old_time + "~" + new_time;
		}
    </script>
    
	

</body>
</html>