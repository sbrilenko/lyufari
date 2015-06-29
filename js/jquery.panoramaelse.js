/*
 * changed and adding by Sergey Brilenko
*/
(function($) {
	$.fn.panoramaelse = function(options){
			var settings = {
				start_position: 0, // initial start position for the view
				image_width: 0,
				image_height: 0,
				mouse_wheel_multiplier: 20,
				bind_resize: true, // determine if window resize affects panorama viewport
				is360: true, // glue left and right and make it scrollable
				right_click: false 
				
			};
			var istouchstart,istouchend,istouchmove;
            if((!!('ontouchstart' in window)))
            {
                istouchstart='touchstart';
                istouchend='touchend';
                istouchmove='touchmove';
            }
            else
            {
                istouchstart='mousedown';
                istouchend='mouseup';
                istouchmove='mousemove';
            }
		function w_size(ret_value)
			{
					var index_arr,size_h;
					var size_h;
                    var size =('innerWidth' in window) ? window.innerWidth : document.body.offsetWidth;
                    if (size<=1200) {css='fsize1';index_arr=0; size_h=459;}
                    else
                	if (size>1200 && size<1600) {css='fsize2'; index_arr=1; size_h=576;}
                    else {css='fsize3'; index_arr=2; size_h=720;}
					if(ret_value=='size') return css;
					else if(ret_value=='size_h') return size_h;
					else return index_arr;
			}
			var swf = $(this).data('swf');
			var data_w = $(this).data('width');
			var data_h = $(this).data('height');
			var data_360 = parseInt($(this).data('360'));
			var viewport= $('.pan');
			var	$gal_back = $('.galery_back',viewport);
			function close(){
				viewport.addClass('display-none').find('.panorama-view').empty()
				$gal_back.addClass('display-none');
			}
			var Keyboard = {
			init: function(){
				$(document).bind('keyup',function(e){
					switch (e.keyCode){
						case 27: close(); break;						
					}
				 $gal_back.bind(istouchstart,function()
				 {
				 	close()
				 })
				});
			}
		}
		$('.galery_back,.close_photos_gal').bind(istouchstart,function(){close(); })
        $('.panorama-view',viewport).append('<div class="panorama-container z_index_9999" style="position:relative;"><img style="display:none;left:0px;height:'+ w_size('size_h')+'px" src="../img/pan/'+w_size('size')+'/'+swf+'" data-width="'+data_w+'" data-height="'+data_h+'" data-360="'+data_360+'" alt="" /></div></div>');
        
			$('#count',viewport).replaceWith('<div id="count"></div>');
  			Keyboard.init();
			viewport.removeClass('display-none');
			$gal_back.removeClass('display-none');
			
			var css;
			
			var panoramaContainer = $('.panorama-container',viewport);
			var viewportImage = $('img:first-child',panoramaContainer);
			if(data_360==0) {  settings.is360=false; }
			if(settings.image_width<=0 && settings.image_height<=0){
				settings.image_width = data_w.split('~')[w_size()];
				settings.image_height = data_h.split('~')[w_size()];
				if (!(settings.image_width) || !(settings.image_height)) return;
			}
			var image_ratio = settings.image_height/settings.image_width;
			if(!settings.is360) {settings.start_position=settings.image_width/3;}
			else { settings.start_position=settings.image_width; }
			var elem_height =  w_size('size_h');
			var elem_width = parseInt(elem_height/image_ratio);
			var image_map = viewportImage.attr('usemap');
			var image_areas;
			var isDragged = false;
			var mouseXprev = 0;
			var scrollDelta = 0;
			if (settings.is360) {  var clone_img=$('<img/>').css({left:elem_width,height:elem_height}).attr('src','../img/pan/'+css+'/'+swf);panoramaContainer.append(clone_img)}
			var time = Math.round(settings.image_width/150*1000);
			
            $('img',viewport).load(function()
            {
               $('img',viewport).show();
               start()
              
            })
            function start()
            {
                if (settings.is360)
    			{
    				panoramaContainer.css({
    				'margin-left': '0px',
    				'width': (elem_width*2)+'px',
    				'height': (elem_height)+'px'
    				}).animate({'margin-left': '-'+settings.start_position+'px'}, time,"linear",  function(){});
    			}
    			else
    			{
    				panoramaContainer.css({
    				'margin-left': '0px',
    				'width': (elem_width)+'px',
    				'height': (elem_height)+'px'
    				}).animate({'margin-left': '-'+settings.start_position+'px'}, time,"linear",  function(){});
    			}
            }
			var timeout;
			function animate_arrows(stop,delta_)
			{
				if(stop!=0)
				{
					timeout=setInterval( function() {
					scrollView(panoramaContainer, elem_width, delta_, settings);
					}, 1);
				}
				else
				{
					clearTimeout(timeout);
					return false;
				}
			}
			$('.gal_arrow_right',viewport).bind('contextmenu',stopEvent).bind(istouchstart,function()
			{
				if(!settings.right_click)
				{
					animate_arrows(1,-2)
				}
			}).bind(istouchend,function()
			{
				settings.right_click=false;
				panoramaContainer.stop(1,0)
				animate_arrows(0,2)
			}).bind('mouseleave',function(e){
				clearTimeout(timeout);
			}).bind('touchmove',function(e){
				clearTimeout(timeout);
			})
			
			$('.gal_arrow_left',viewport).bind('contextmenu',stopEvent).bind(istouchstart,function()
			{
				if(!settings.right_click)
				{
					animate_arrows(1,2)
				}
			}).bind(istouchend,function()
			{
				settings.right_click=false;
				panoramaContainer.stop(1,0)
				animate_arrows(0,10)
			}).bind('mouseleave',function(e){
				clearTimeout(timeout);
			}).bind('touchmove',function(e){
				clearTimeout(timeout);
			});
			viewport.unbind('mousedown mouseup mousemove mouseout mousewheel contextmenu touchstart touchmove touchend');
                        
			viewport.bind(istouchstart,function(e){
				panoramaContainer.stop(1,0);
				if (!isDragged) 
				{
					$(this).addClass("grab");
					isDragged = true;
					mouseXprev =(istouchstart=='touchstart')?e.originalEvent.touches[0].pageX:e.clientX;
					scrollOffset = 0;
				}
				return false;
                
			}).bind(istouchend,function(){
				isDragged = false;
				$(this).removeClass("grab");
				scrollDelta = scrollDelta * 0.45;
				return false;
			}).bind(istouchmove,function(e){
				if(isDragged)
				{
				    e.preventDefault();
    				panoramaContainer.stop(1,0)
    				clearTimeout(timeout);
				    if(istouchmove=='touchmove')
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
					scrollView(panoramaContainer, elem_width, scrollDelta,settings);
				}
				return false;
			}).bind('mouseleave',function(e){
				isDragged = false;
				return false;
			}).bind("mousewheel",function(e,distance){
				panoramaContainer.stop(1,0)
				clearTimeout(timeout);
				var delta=Math.ceil(Math.sqrt(Math.abs(distance)));
				delta=distance<0 ? -delta : delta;
				scrollDelta = scrollDelta + delta * 5;
				scrollView(panoramaContainer,elem_width,delta*settings.mouse_wheel_multiplier,settings);
				return false;
			}).bind('contextmenu',stopEvent)

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
        $(window).resize(function()
        {
            close();
        })
		function stopEvent(e){
			e.preventDefault();
			return false;
		}
		function scrollView(panoramaContainer,elem_width,delta,settings){
			var newMarginLeft = parseInt(panoramaContainer.css('marginLeft'))+delta;
			if(settings.is360){
				if (newMarginLeft > 0) {  newMarginLeft = -elem_width;}
				else
				if (newMarginLeft < -elem_width) {newMarginLeft = 0; }
			}
			else{
				var right = -(elem_width - panoramaContainer.parent().width());
				if (newMarginLeft > 0) newMarginLeft = 0;
				if (newMarginLeft < right) newMarginLeft = right;
			}
			panoramaContainer.css('marginLeft', newMarginLeft+'px');
		}
	}
})(jQuery);
$(document).ready(function()
{
    $('.virt').bind('click',function()
    {
      $(this).panoramaelse();  
    })
})