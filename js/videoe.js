(function( $ ){
  $.fn.videoe = function() {
    var clott=(!!('ontouchstart' in window))?'touchstart':'click';
    var v=$(this).attr('ref');
    
    $('.gallery').removeClass('display-none')
    $('.gal_arrow').addClass('display-none')
    $('#for-map').append('<div><object class="object-video"><param name="wmode" /><param name="movie" value="'+v+'?version=3&feature=player_detailpage&autoplay=1"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="'+v+'?version=3&feature=player_detailpage&autoplay=1" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" class="object-video" ></object></div>')
  };
 
})( jQuery );
$(document).ready(function() {
    var clott=(!!('ontouchstart' in window))?'touchstart':'click';
	$(document).on(clott,'.isvideo',function()
    {
        $(this).videoe()
    }) 
})