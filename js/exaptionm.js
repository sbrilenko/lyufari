$(function()
{
    function exaption()
    {
        ($(window).width()>1024)?$('.m-b').addClass('bigger'):$('.m-b').removeClass('bigger')
    }
    $(window).resize(function(){
        
        exaption()
    })
    exaption()
})