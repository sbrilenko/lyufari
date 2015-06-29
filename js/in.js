/*Created by Sergey Brilenko*/
(function( $ ){
	$.fn.ini = function(options){
       var istouch,ishover, arrowis;
       if((!!('ontouchstart' in window)))
       {
            istouch='touchend';
            ishover='focusout';
            arrowis='touchstart'
       }
       else
       {
            istouch='click';
            ishover='focusout';
            arrowis='click'
       }
		var ini={
		    init:function($this)
            {
                console.log($this)
                
                
            },
            ajaxsender:function(ajaxdata,f_)
            {
                $.ajax({
    			url: "/ajax.php",
    			type: "post",
                dataType: 'json',
                data:ajaxdata,
    			async: false,
    			success:f_
		      })
            }
		}
        this.on(istouch,function(){  ini.init($(this))}).attr('value','').mask("9999 9999 9999 9999");
        $('.after-disc-card-text').on(istouch,'.dotted',function()
        {
            var dotted=$('.dotted',$(this).parent())
            var nodotted=$('.nodotted',$(this).parent())
            dotted.addClass('nodotted').removeClass('dotted')
            nodotted.addClass('dotted').removeClass('nodotted')
            if($('.thiso').hasClass('dotted'))
            {
                console.log('по телефону')
                 $("input[name=in]").attr('value','').mask("+38 (999) 999 99 99");
                
            }
            else
            {
                console.log('по карте')
                $('input[name=in]').attr('value','').mask("9999 9999 9999 9999");
            }
            
        })
	}
})(jQuery);
$(function()
{
    $('input[name=in]').ini() 
})		