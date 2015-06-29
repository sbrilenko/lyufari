(function($) {
	$.fn.galstatic = function(options){
	   var istouch;
       current=0
       var total=0,totaldeliv=0;
       var time=1300;
       if((!!('ontouchstart' in window)))
       {
            istouch='touchend';
       }
       else
       {
            istouch='click';
       }
		this.each(function(){
			var settings = {};
             		
		});
        var galfirst=0;
        $(window).scroll(function()
        {
             //$('.centertop').remove()
            // $('.centerbottom').remove()   
            if(galfirst==0 && $(window).height()>300)
            {
                var ststicgalh=$('.static-gal').height();
                var ststicgalt=$('.static-gal').offset().top;
                var polovina=($(window).height()/3)
                var centertop=$(window).scrollTop()+polovina
                var centerbottom=$(window).scrollTop()+$(window).height()-polovina
                if((centertop>ststicgalt && centertop<ststicgalt+ststicgalh) || (centerbottom>ststicgalt && centerbottom<ststicgalt+ststicgalh))
                {
                    $('.gallery-arrow-next').parent().trigger(istouch)
                    galfirst=1;
                }       
            
                //$('body').append("<div class='centertop' style='background-color:red;position:absolute;left:0;width:5px;height:5px;top:"+centertop+"px'></div>");
                //$('body').append("<div class='centerbottom' style='background-color:red;position:absolute;left:0;width:5px;height:5px;top:"+centerbottom+"px'></div>");
               
            }
           
        })
        var images=$(this).attr('ref')
        if(images)
        {
            images=images.split('~')
        }
        var th=$(this).parent();
        $('.gallery-arrow-next',th).parent().on(istouch,function()
        {
            if(!$('.images img:animated').length)
            {
                if(current>=images.length-1) current=0;
                else current++;
                $('<img src="../img/photos/rest/'+images[current]+'" class="width-h-p p-a" style="top:0;z-index:-1;"/>').insertBefore($('.images>img'))
                $('.images img:eq(0)').load(function()
                {
                    $('.thisimage').fadeOut(time,function()
                    {
                            $(this).remove()
                            $('.images img').addClass('thisimage')
                        
                    })
                })
                
            }
        })
        $('.gallery-arrow-prev',th).parent().on(istouch,function()
        {
            if(!$('.images img:animated').length)
            {
                
                if(current==0) current=images.length-1;
                else current--;
                $('<img src="../img/photos/rest/'+images[current]+'" class="width-h-p p-a" style="top:0;z-index:-1;"/>').insertBefore($('.images>img'))
                 $('.images img:eq(0)').load(function()
                 {
                     $('.thisimage').fadeOut(time,function()
                    {
                            $(this).remove()
                            $('.images img').addClass('thisimage')
                    
                    })
                })
               
            }
        })
	}
}
)(jQuery);
$(function()
{
	$('.images').galstatic();
})
