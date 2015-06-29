
(function($) {
	$.fn.stockanim = function(options){
	   	this.each(function(){
	   	    var istouch;
            var time=250;
            var touchtrue=false;
            if((!!('ontouchstart' in window)))
            {
                istouch='touchend';
            }
            else
            {
                istouch='hover';
            }
    		if(options) $.extend(settings, options);
            var th=$('.bottom-block-anim-back',$(this));
            function anim(th)
            {
                  if(touchtrue)
                  {
                    th.stop()
                    th.animate({bottom:'-189px'},time)
                    touchtrue=false;
                  }
                  else
                  {
                    th.stop()
                    th.animate({bottom:0},time)
                    touchtrue=true;
                  }
            }
             function stockbottomblockremove()
            {
                var size =('innerWidth' in window) ? window.innerWidth : document.body.offsetWidth;
                 if(size<1366)
                 {
                    $('.stock-bottom-block li:eq(2)').addClass('display-none').removeAttr('style');
                 }
                 else
                 {
                    $('.stock-bottom-block li:eq(2)').removeClass('display-none').removeAttr('style');
                 }
            }
             stockbottomblockremove()
             $(window).resize(function()
             {
                stockbottomblockremove()
             })
            $('a',$(this)).on('touchstart',function()
            {
                return true;
            })
            $(this).on(istouch,function()
            {
                anim(th)  
                return false;
                
            })
            
      })
	  
	}
}
)(jQuery);
$(function()
{
	$('.border-1-928054').stockanim();
})
