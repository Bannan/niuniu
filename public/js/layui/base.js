$(function() {

	//限制表单只能输入数字
	$(".number_ipt").keyup(function () {
	    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
	}).bind("paste", function () {  //CTR+V事件处理    
	    $(this).val($(this).val().replace(/[^0-9.]/g, ''));
	}).css("ime-mode", "disabled"); //CSS设置输入法不可用

	//删除用户
	$('.btn-delete').on('click', function() {
		var url = $(this).attr('data-url');
		var id = $(this).attr('data-id');
		console.log(url);
		layer.confirm('你确定删除？', {
		  btn: ['确定','取消'] //按钮
		}, function(){

		  $.post(url, {}, function(result) {
		  	if (result.status==1) {
		  		layer.msg('删除成功', {icon: 1});
		  		$('.delete-id-'+id).remove();
		  	} else {
		  		layer.msg(result.con, {icon: 1});
		  	}
		  });

		});
	});

	
});
