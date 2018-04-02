window.onload = function(){ 

      //减分
      $('#room').on('click', '.prev', function() {
        var data_pos = $('.showNumber').attr('data-pos');

        data_pos--;
        if (data_pos < 1) {
          data_pos = 1;
        }

        $('.radio .cl').eq(data_pos-1).addClass('on').siblings().removeClass('on')
        var data_item = $('.radio .cl').eq(data_pos-1).attr('data-item'); 

        $('.showNumber').attr('data-pos', data_pos).attr('data-item', data_item).find('i').html(data_item);
        $('#df'+(data_pos-1)).click();
      });

      //加分
      $('#room').on('click', '.next', function() {
        var data_pos = $('.showNumber').attr('data-pos');
        var len = $('.radio .cl').size(); //获取元素个数

        data_pos++;
        if (data_pos > len) {
          data_pos = len;
        }

        $('.radio .cl').eq(data_pos-1).addClass('on').siblings().removeClass('on')
        var data_item = $('.radio .cl').eq(data_pos-1).attr('data-item'); 

        $('.showNumber').attr('data-pos', data_pos).attr('data-item', data_item).find('i').html(data_item);
        $('#df'+(data_pos-1)).click();
      });
    }