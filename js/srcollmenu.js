$(function()
{
    var sticky_navigation_offset_top = $('#sticky_navigation').offset().top-5;
	var sticky_navigation = function(){
	
		var scroll_top = $(window).scrollTop(); 
		if (scroll_top > sticky_navigation_offset_top) {
			if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) { 
				$('#sticky_navigation').css({ 'position': 'absolute', 'top':scroll_top, 'left':0});
                if($('#sticky_navigation').css('background-image')=='none') $('#sticky_navigation').css({'background-image': 'url("../img/menu-back.jpg") ','background-color':'#4d4135','background-repeat':'repeat'})
			}
			else
			{
				$('#sticky_navigation').css({ 'position': 'fixed', 'top':0, 'left':0 });	
                if($('#sticky_navigation').css('background-image')=='none') $('#sticky_navigation').css({'background-image': 'url("../img/menu-back.jpg") ','background-color':'#4d4135','background-repeat':'repeat'})		
			}
		} else {
			$('#sticky_navigation').css({ 'position': 'relative','top': 0,'background': 'none'}); 
            if($('#sticky_navigation').css('background-image')!='none') $('#sticky_navigation').css({'background-image': 'none ','background-color':'none','background-repeat':'none'})
		}   
	};
	sticky_navigation();
	$(window).scroll(function() {
		 sticky_navigation();
	});
})