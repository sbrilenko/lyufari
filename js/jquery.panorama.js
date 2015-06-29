$(document).ready(function(){






(function($) {
	$.fn.panorama = function(options){
		this.each(function(){
			var settings = {		 
				width_slider_dv_val:0,
				start_position: 0, // initial start position for the view
				image_width: 0,
				image_height: 0,
				mouse_wheel_multiplier: 20,
				bind_resize: true, // determine if window resize affects panorama viewport
				is360: false, // glue left and right and make it scrollable
				right_click: false 
			};
            var w_h=$(window).height()
			var css;
            var touchstart,touchend,touchmove
             if((!!('ontouchstart' in window)))
             {
                touchstart='touchstart';
                touchend='touchend';
                touchmove='touchmove';
             } 
             else
             {
                touchstart='mousedown';
                touchend='mouseup';
                touchmove='mousemove';
             }
			
			var viewport = $(this);
			var delimSlider=$('.pandelim',viewport );
			if(options) $.extend(settings, options);
			
			var panoramaContainer = $('.panorama-container',viewport);
			var viewportImage = $('img:first-child',panoramaContainer);
			if(settings.image_width<=0 && settings.image_height<=0){
				settings.image_width = viewportImage.data("width");
				settings.image_height = viewportImage.data("height");
				if (!(settings.image_width) || !(settings.image_height)) return;
			}
            var datatimeout;
            if(viewportImage.data('timeout'))
            {
                datatimeout=viewportImage.data('timeout');
            }
            
			var image_ratio = settings.image_height/settings.image_width;
			
			var image_areas;
			var isDragged = false;
			var isDraggedButton = false;
			var mouseXprev = 0;
			var scrollDelta = 0;
			var timeoutID=undefined;
			var time = Math.round(settings.image_width/150*2000);
            var m_l=(-1)*(settings.image_width-parseInt($(this).width())+2);//+2 пикселя обводка золотистая
            
            panoramaContainer.css({'width': settings.image_width,'margin-left': settings.start_position})
            
                //$('.centertop').remove()
                //$('.centerbottom').remove()   
                
               // $('body').append("<div class='centertop' style='background-color:red;position:absolute;left:0;width:5px;height:5px;top:"+centertop+"px'></div>");
                //$('body').append("<div class='centerbottom' style='background-color:red;position:absolute;left:0;width:5px;height:5px;top:"+centerbottom+"px'></div>");
                
            function getscrollandcenter()
            {
              /*  console.log($(window).scrollTop())*/
                var ststicgalh=settings.image_height;
                var ststicgalt=viewport.offset().top;
                var polovina=(w_h/3)
                var centertop=$(window).scrollTop()+polovina
                var centerbottom=$(window).scrollTop()+w_h-polovina
                if(typeof(timeoutID)==='undefined')
                {
                    if((centertop>ststicgalt && centertop<ststicgalt+ststicgalh) || (centerbottom>ststicgalt && centerbottom<ststicgalt+ststicgalh))
                    {
                        if($(':animated',viewport).length==0 && parseInt(panoramaContainer.css('margin-left'))!=m_l)
                        {
                            if(datatimeout>0 )
                            {
                                timeoutID = setTimeout(function(){
                			           anim()
                                        datatimeout=null                                        
                			     },datatimeout)
                            }
                            else
                            {
                               anim()
                            }
                        }
                    }
                }
                
            }
             getscrollandcenter()         
            $(window).scroll(function()
            {
               getscrollandcenter()

                if($(window).height()>300)
                {
                   if($(window).scrollTop()+w_h>=viewport.offset().top && $(window).scrollTop()<viewport.offset().top+settings.image_height )
                    {

                    }
                    else
                    {
                        clearTimeout(timeoutID)
                        timeoutID=undefined
        				panoramaContainer.stop(0,0);
        				delimSlider.stop(0,0);
                        panoramaContainer.css({
            				'margin-left': settings.start_position,
            				'width': settings.image_width
            				})
                        delimSlider.css({left:0})
                    }
                }

            })
            
            
			anim()
			function anim()
            {
                panoramaContainer.css({
				'margin-left': settings.start_position,
				'width': settings.image_width
				}).animate({marginLeft: m_l}, time,"linear");
				delimSlider.css({left:0}).animate({left:474 },time,'linear');
            }
			var timeout;
			
			viewport.unbind('mousedown mouseup mousemove mouseout mousewheel contextmenu touchstart touchmove touchend');
			viewport.on(touchstart,function(e){
				clearTimeout(timeoutID)
                timeoutID=undefined
				panoramaContainer.stop(0,0);
				delimSlider.stop(0,0);
				if (!isDragged) 
				{
					isDragged = true;
                    if(touchstart=='touchstart')
                    {
                        mouseXprev = e.originalEvent.touches[0].pageX;
                    }
                    else
                    {
                   	    mouseXprev = e.clientX;
                    }
					scrollOffset = 0;
				}
				return false;
			}).on(touchend,function(){
				isDragged = false;
				return false;
                
			}).on(touchmove,function(e){
			    
				if (isDragged)
				{
				    clearTimeout(timeoutID)
                    timeoutID=undefined
    				panoramaContainer.stop(0,0);
    				delimSlider.stop(0,0);
				    if(touchmove=='touchmove')
                    {
                        var touch_x = e.originalEvent.touches[0].pageX;
    					scrollDelta = parseInt((touch_x - mouseXprev));
    					mouseXprev = touch_x;
                    }
                    else
                    {
                        scrollDelta = parseInt((e.clientX - mouseXprev));
					   mouseXprev = e.clientX;
                    }
					
					scrollView(panoramaContainer, panoramaContainer.width(), scrollDelta,settings);
				}
				return false;
			}).mouseleave(function(e){
				isDragged = false;
				return false;
			}).bind('contextmenu',stopEvent)
			
			///button
			
			$('.panline>div',viewport).on(touchstart,function(e)
			{
				clearTimeout(timeoutID)
                timeoutID=undefined
				panoramaContainer.stop(0,0);
				delimSlider.stop(0,0);
                if(touchstart=='touchstart')
                {
                    
                    if((e.originalEvent.touches[0].pageX-parseInt($(this).offset().left))>=0 && (e.originalEvent.touches[0].pageX-parseInt($(this).offset().left)-35<=509))
                   {
                   if(e.originalEvent.touches[0].pageX-parseInt($(this).offset().left)<=35)
                    {
                        delimSlider.css('left',0)
                    }
                    else
                    if(e.originalEvent.touches[0].pageX-parseInt($(this).offset().left)>474)
                    {
                        delimSlider.css('left',474)
                    }
                    else
    					delimSlider.css('left',e.originalEvent.touches[0].pageX-parseInt($(this).offset().left)-17)
    					panoramaContainer.css('marginLeft',(e.originalEvent.touches[0].pageX-parseInt($(this).offset().left))*(-(panoramaContainer.width() - panoramaContainer.parent().width()+2))/509);
    				}
                }
                else
                if((e.clientX-parseInt($(this).offset().left))>=0 && ((e.clientX-parseInt($(this).offset().left)-35)<=509))
                {
                    if(e.clientX-parseInt($(this).offset().left)<=35)
                    {
                        delimSlider.css('left',0)
                    }
                    else
                    if(e.clientX-parseInt($(this).offset().left)>474)
                    {
                        delimSlider.css('left',474)
                    }
                    else delimSlider.css('left',e.clientX-parseInt($(this).offset().left)-17)
                    panoramaContainer.css('marginLeft',(e.clientX-parseInt($(this).offset().left))*(-(panoramaContainer.width() - panoramaContainer.parent().width()+2))/509);
				    
				}
                
				if (!isDraggedButton) 
				{
					
					isDraggedButton = true;
                    if(touchstart=='touchstart')
                    {
                        mouseXprev = e.originalEvent.touches[0].pageX;
                    }
                    else
                    {
                        mouseXprev = e.clientX;
                    }
					
					scrollOffset = 0;
				}
				return false;
			}).on(touchend,function(){
				isDraggedButton = false;
				return false;
			}).on(touchmove,function(e){
			    
				if (isDraggedButton)
				{
				     clearTimeout(timeoutID)
                    timeoutID=undefined
    				panoramaContainer.stop(0,0);
    				delimSlider.stop(0,0);
				        if(touchmove=='touchmove')
                        {
                       	    var touch_x = e.originalEvent.touches[0].pageX;
        					scrollDelta = parseInt((touch_x - mouseXprev));
        					if ((touch_x-parseInt($(this).offset().left))>=17 && ((touch_x-parseInt($(this).offset().left))<=492))
        					{
        						mouseXprev = touch_x;
        					   delimSlider.css('left',touch_x-parseInt($(this).offset().left)-17)
        					   panoramaContainer.css('marginLeft',(touch_x-parseInt($(this).offset().left))*(-(panoramaContainer.width() - panoramaContainer.parent().width()+2))/509);
            				    
                            }
                        }
                        else
                        {
                           scrollDelta = parseInt((e.clientX - mouseXprev));
						   mouseXprev = e.clientX;
                           if((e.clientX-parseInt($(this).offset().left))>=17 && ((e.clientX-parseInt($(this).offset().left))<492))
                           {
                                 delimSlider.css('left',e.clientX-parseInt($(this).offset().left)-17)
                                panoramaContainer.css('marginLeft',(e.clientX-parseInt($(this).offset().left))*(-(panoramaContainer.width() - panoramaContainer.parent().width()+2))/509);
            				    
            				}
    						/*else
    						{
    							isDraggedButton=false;
    						} */
                        }
						
				}
				
			}).bind('mouseleave',function()
			{
			}).bind('contextmenu',stopEvent)
			
            $('.panline').bind(touchstart,function(){
                isDraggedButton=false;
                	return false
            }).bind(touchmove,function(){
                if(isDraggedButton!=true)
                {
                    isDraggedButton=false;
               	    return false
                }
                
            }).bind('mouseleave',function(){
                isDraggedButton=false;
                	return false
            }).bind(touchend,function()
            {
                isDraggedButton = false;
				return false;
            })
			if (settings.bind_resize){
				$(window).resize(function(){
				  /*  console.log('resize')*/
				    w_h=$(window).height();
                    if(touchstart!='touchstart')
                    {
                        panoramaContainer.stop(0,0);
    					delimSlider.stop(0,0);
    					$('.panorama .panorama-container').css({marginLeft:0,width:$('.pan_corsar .panorama-container img').data("width")})
    					
    					delimSlider.css({left:0})
                    }
					
				});
			}
			if (settings.loaded && $.isFunction(loaded)) {
				settings.loaded();
			}
			if (settings.callback && $.isFunction(settings.callback)) {
				var img = 0;
				$('.panorama-container img').load(function(e){
					img += 1;
					if (img == 2) settings.callback();
				});
			}
            function stopEvent(e){
			e.preventDefault();
			return false;
		}
		function scrollView(panoramaContainer,panoramaContainerwidth,delta,settings){
			var newMarginLeft = parseInt(panoramaContainer.css('marginLeft'))+delta;
			var right = -(panoramaContainerwidth - panoramaContainer.parent().width());
			if (newMarginLeft > 0) {newMarginLeft = 0;}
			if (newMarginLeft < right) {newMarginLeft = right;}
			var razmer_peredvizhen_dliy_lin_scroll=0;
			razmer_peredvizhen_dliy_lin_scroll=(474*delta/right);
			if (parseInt(delimSlider.css('left'))+razmer_peredvizhen_dliy_lin_scroll<0 || parseInt(delimSlider.css('left'))+razmer_peredvizhen_dliy_lin_scroll >474) { }
			else
			{
				delimSlider.css('left',Math.round(parseInt(delimSlider.css('left'))+razmer_peredvizhen_dliy_lin_scroll));
			}	
			panoramaContainer.css('marginLeft', newMarginLeft+'px');
		}
		});

		

	}
}
)(jQuery);

    $('.preload').css({display:'none'})



    var img_src = $('.preload').attr('src')


    var img = new Image();
    img.src = img_src;

    img.onload =function(){
        $('.panorama').panorama();
        $('.preload').fadeIn(800)


    }


})