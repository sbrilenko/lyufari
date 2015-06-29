
$(document).ready(function() {
        var istouch;
        var total=0,totaldeliv=0
        if((!!('ontouchstart' in window)))
        {
            istouch='touchstart';
        }
        else
        {
            istouch='click';
        }
        var folder,type="png",img,img_delim="~",ajax=false,prefolder;
        var next,prev;
        var current=0;
        var length=0;
        var fungal={
            ajaxs:function(data,f)
            {
                $.ajax({
                    type: "POST",
                    url: "../lib/img.php",
                    data: data,
                    success: f
                });
            },
            fsizegalch:function()
            {
                var size =('innerWidth' in window) ? window.innerWidth : document.body.offsetWidth;
                if (size<=1200) {css='sgal1';prefolder="size1";}
                else
                if (size>1200 && size<1600) {css='sgal2';prefolder="size2";}
                else {css='sgal3';prefolder="size3";}
                document.getElementById('galsize').setAttribute('href', 'css/'+css+'.css');
                return prefolder;
            },
            left:function()
            {
                if(length>1 && $('.gallery img:animated').length==0)
                {
                    if(current<1)
                    {
                        current=length-1;
                    }
                    else
                    {
                        current--;
                    }
                    $('.preloader').fadeIn(500)
                    $('#for-map img').fadeOut(500,function()
                    {
                        $(this).remove();
                        $('#for-map').append('<img style="display:none" src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>');
                        $('#for-map img').load(function()
                        {
                            $('#for-map img').fadeIn(500)
                            $('.preloader').fadeOut(500)
                        })
                    })

                    $('#count').text((current+1)+' / '+length)
                }
            },
            right:function()
            {
                if(length>1 && $('.gallery img:animated').length==0)
                {
                    current++;
                    if(current>length-1)
                    {
                        current=0;
                    }
                    $('.preloader').fadeIn(500)
                    $('#for-map img').fadeOut(500,function()
                    {
                        $(this).remove();
                        $('#for-map').append('<img style="display:none" src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>');
                        $('#for-map img').load(function()
                        {
                            $('#for-map img').fadeIn(500)
                            $('.preloader').fadeOut(500)
                        })

                    })
                    $('#count').text((current+1)+' / '+length)

                }
            }
        }
        fungal.fsizegalch();
        $(document).on(istouch,'.gal',function()
        {
            var  db=$(this).data('db')
            folder=$(this).data('folder')
            type=(typeof($(this).attr('data-type'))!=="undefined")?$(this).attr('data-type'):type;
            current=parseInt((typeof($(this).attr('data-current'))!=="undefined")?$(this).attr('data-current'):current);
            ajax=(typeof($(this).data('ajax'))!=="undefined")?$(this).data('ajax'):ajax
            if(ajax) {
                fungal.ajaxs({dir:folder,db:db},function(data)
                {
                    img=eval(data)
                    console.log(img)
                    length=img.length;
                    if(current>length-1) current=length-1
                    $('.preloader').fadeIn(500)
                    $('#for-map').append('<img src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>')
                    $('#for-map img').load(function()
                    {
                        $('#for-map img').fadeIn(500)
                        $('.preloader').fadeOut(500)
                    })
                    $('#count').text((current+1)+' / '+length)
                    if(length<=1)
                    {
                        $('.gal_arrow').addClass('display-none')
                    }
                    else
                    {
                        $('.gal_arrow').removeClass('display-none')
                    }
                })

            }
            else
            {
                img_delim=(typeof($(this).data('img-delim'))!=="undefined")?$(this).data('img-delim'):img_delim
                img=$(this).data('img');
                if(img.indexOf(img_delim)==-1)
                {
                    img=[$(this).data('img')];
                }
                else
                {
                    img=img.split(img_delim);
                }

                length=img.length
                current=length-1
                $('.preloader').fadeIn(500)
                $('#for-map').append('<img style="display:none;" src="'+folder+fungal.fsizegalch()+'/'+img[current]+'"/>')
                $('#for-map img').load(function()
                {
                    $('#for-map img').fadeIn(500)
                    $('.preloader').fadeOut(500)
                })
                $('#count').text(current+1+' / '+length)
                if(length<=1)
                {
                    $('.gal_arrow').addClass('display-none')
                }
                else
                {
                    $('.gal_arrow').removeClass('display-none')
                }
            }
            $('.gallery').removeClass('display-none');

        })
        $(document).on(istouch,'.top_right_arrow div',function()
        {
            fungal.right();
        })
        $(document).on(istouch,'.top_left_arrow div',function()
        {
            fungal.left();
        })
        $(document).on(istouch,'.galery_back',function(){
            $('.gallery').addClass('display-none')
            $('#for-map img,#for-map div').remove();
            $('#count').text('')
            $('.gal_arrow').removeClass('display-none')
        })
        $(document).on(istouch,'.close_photos_gal',function()
        {
            $('.gallery').addClass('display-none')
            $('#for-map img,#for-map div').remove();

            $('#count').text('')
            $('.gal_arrow').removeClass('display-none')
        })
        $(window).resize(function()
        {
            $('.galery_back').trigger(istouch);
            fungal.fsizegalch();
        })
        $(document).keydown(function(e)
        {
            if(e.keyCode==27)
            {
                $('.galery_back').trigger(istouch)
            }
            if(e.keyCode==39)
            {
                //?????
                fungal.right()
            }
            if(e.keyCode==37)
            {
                //????
                fungal.left()
            }

        })


}
    );
