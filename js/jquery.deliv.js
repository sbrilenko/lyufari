
(function($) {
	$.fn.delivery = function(options){
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
		this.each(function(){
			var settings = {};
             		
		});
         if($(window).scrollTop()+$(window).height()-44>=$('form').parent().offset().top && $(window).scrollTop()<$('form').parent().offset().top+$('form').parent().height() && $('form').parent().offset().top+$('form').parent().height()>$(window).scrollTop()+$(window).height()-44)
            {
                $('.scrollmenu').show()
            }
            else
            {
                $('.scrollmenu').hide()
            }
         $(window).scroll(function()
        {
        if($(window).scrollTop()+$(window).height()-44>=$('form').parent().offset().top && $(window).scrollTop()<$('form').parent().offset().top+$('form').parent().height() && $('form').parent().offset().top+$('form').parent().height()>$(window).scrollTop()+$(window).height()-44)
            {
                $('.scrollmenu').show()
            }
            else
            {
                $('.scrollmenu').hide()
            }
        })
        function getorder()
        {
            var sess=[];
            var ob
            $('.menu-col').each(function(i)
            {
                if(parseInt($(this).val())>0)
                {
                    ob=new Object(); ob.id=$('input[name="id"]',$(this).parent()).val();ob.col=parseInt($(this).val());sess.push(ob);
                }
            })
            $.ajax({
            type: "POST",
			url: "../lib/savezakaz.php",
			data: {z:sess},
			success: function(data)
                {
                }
    		});
            return sess;
        }
        $('.icons-menu-print,.icons-menu-mail,a.swimprint').on(istouch,function()
        {
            var get=getorder()
            if(get.length>0)
            {
                window.open("/print","_blank");
            }
            else
            {
                $("<div>Сделайте заказ!</div>" ).dialog({
                    modal:true,
                    resizable:false,
                    open: function() {
                        $('.ui-button').blur();
                        $(this).css({Height:'auto',minHeight:0})
                    },
                    position: { my: "center", at: "center", of: window },
                    close:function(){$(this).remove()},
                    buttons: [
                        { text: "Ok", click: function() {
                            $(this).remove()
                            $('.oforml-sub').attr('disabled',false)

                        }}
                    ]
                })
            }
            return false;
        })
        $('.mainname>div').on(istouch,function()
        {
            
            if($(">ul",$(this).parent()).hasClass('visible'))
            {
                $(".submainname ul",$(this).parent()).removeClass('visible')
                $(".submainname .menu-arrow-little",$(this).parent()).removeClass('active')
                $(".backbottom",$(this).parent()).removeClass('backbottom')
            }
            else
            {
                $(this).toggleClass('backbottom')
            }
            $(">ul",$(this).parent()).toggleClass('visible')
            $('>div',$(this)).toggleClass('active')
            if($(window).scrollTop()+$(window).height()-44>=$('form').parent().offset().top && $(window).scrollTop()<$('form').parent().offset().top+$('form').parent().height() && $('form').parent().offset().top+$('form').parent().height()>$(window).scrollTop()+$(window).height()-44)
            {
                $('.scrollmenu').show()
            }
            else
            {
                $('.scrollmenu').hide()
            }
        })
        $('.delete').on(istouch,function()
        {
            $('.date').val('')
            $(this).addClass('display-none');
            return false;
        })
        $('.submainname>div').on(istouch,function()
        {
            if($(">ul",$(this).parent()).hasClass('visible'))
            {
                $(".submainname ul",$(this).parent()).removeClass('visible')
                $(".backbottom",$(this).parent()).removeClass('backbottom')
            }
            else
            {
                $(this).toggleClass('backbottom')
            }
            $(">ul",$(this).parent()).toggleClass('visible')
            $('>div',$(this)).toggleClass('active')
            if($(window).scrollTop()+$(window).height()-44>=$('form').parent().offset().top && $(window).scrollTop()<$('form').parent().offset().top+$('form').parent().height() && $('form').parent().offset().top+$('form').parent().height()>$(window).scrollTop()+$(window).height()-44)
            {
                $('.scrollmenu').show()
            }
            else
            {
                $('.scrollmenu').hide()
            }
        })
        $('input:radio').on('change',function()
        {
            if($(this).is(":checked"))
            {
                 $('input:radio').not( this) .removeAttr('checked')
                 $(this).attr('checked',true)
                 if($(this).attr('name')=='rest')
                 {
                    $('textarea[name="address"]').attr('disabled',true).addClass('disabled')
                    $('textarea[name="address"]').parent().addClass('disabled')
                 }
                 else
                 {
                    $('textarea[name="address"]').attr('disabled',false).removeClass('disabled')
                    $('textarea[name="address"]').parent().removeClass('disabled')
                 }
            }

        })
        
        $('.icons-menu-zakaz').on(istouch,function()
        {
            if($(this).hasClass('swim-oformit'))
            {
                if(!$('.oform:animated').length)
                {
                    if($('.oform').is(':visible'))
                    {    
                    }
                    else
                    {
                       $('.oform').show().animate({height:362},1000)
                    }
                }
            }
            else
            {
              if(!$('.oform:animated').length)
                {
                    if($('.oform').is(':visible'))
                    {              
                        $('.oform').animate({height:0},1000,function()
                        {
                            $('.oform').hide()
                          
                        })
                    }
                    else
                    {
                       $('.oform').show().animate({height:362},1000)
                    }
                }  
            }
                     
                
            
            
        })
        
        $('.menu-plus').on(istouch,function()
        {
            var ct=$(this).prev()
            var c=parseInt(ct.val());
            if(!$('>div',$(this).parent().prev()).hasClass('back-none'))
            {
                totaldeliv-=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            }
            total-=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            if(c<99) c++;
            else c=0
            ct.val(c)
            var pr=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            if(!$('>div',$(this).parent().prev()).hasClass('back-none'))
            {
                totaldeliv+=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            }
            
            total+=pr
            $('.total,.swim-itogo-text').text('Итого: '+total+'грн')
            $('.oform-block-all-price').text(total)
            $('[name=h_price]').val(total)
            $('.price-for-delivery,.swim-itogo-text-deliv').text('Сумма заказа для доставки: '+totaldeliv+'грн')
            $('.oform-block-deliv-price').text(totaldeliv)
            $('[name=h_delivery_price]').val(totaldeliv)
            if(totaldeliv>=250) { $('.price-for-delivery').addClass('green_restoran');}
            else {$('.price-for-delivery').removeClass('green_restoran');}
//            if(totaldeliv>=250) { $('.free-delivery').addClass('actdeliv'); $('.swim-itogo-text-deliv').addClass('active')}
//            else {$('.free-delivery').removeClass('actdeliv');$('.swim-itogo-text-deliv').removeClass('active')}
        })
        $('.menu-minus').on(istouch,function()
        {
            var ct=$(this).next()
            var c=parseInt(ct.val());
            if(!$('>div',$(this).parent().prev()).hasClass('back-none'))
            {
                totaldeliv-=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            }
            total-=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            
            if(c>0) c--;
            else c=99
            ct.val(c)
            var pr=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            if(!$('>div',$(this).parent().prev()).hasClass('back-none'))
            {
                totaldeliv+=parseFloat($('input[name="pr"]',$(this).parent()).val())*c
            }
            total+=pr
            $('.total,.swim-itogo-text').text('Итого: '+total+'грн')
            $('.oform-block-all-price').text(total)
            $('[name=h_price]').val(total)
            $('.price-for-delivery,.swim-itogo-text-deliv').text('Сумма заказа для доставки: '+totaldeliv+'грн')
            $('.oform-block-deliv-price').text(totaldeliv)
            $('[name=h_delivery_price]').val(totaldeliv)
            if(totaldeliv>=250) { $('.price-for-delivery').addClass('green_restoran');}
            else {$('.price-for-delivery').removeClass('green_restoran');}
//            if(totaldeliv>=250) {$('.free-delivery').addClass('actdeliv');$('.swim-itogo-text-deliv').addClass('active')}
//            else {$('.free-delivery').removeClass('actdeliv');$('.swim-itogo-text-deliv').removeClass('active')}
        })
        $('.hide-all').on(istouch,function()
        {
            $('.mainname .menu-arrow-big,.mainname .menu-arrow-little').removeClass('active')
            $('.mainname ul').removeClass('visible')
             if($(window).scrollTop()+$(window).height()-44>=$('form').parent().offset().top && $(window).scrollTop()<$('form').parent().offset().top+$('form').parent().height() && $('form').parent().offset().top+$('form').parent().height()>$(window).scrollTop()+$(window).height()-44)
            {
                $('.scrollmenu').show()
            }
            else
            {
                $('.scrollmenu').hide()
            }
        })
        $('.show-all').on(istouch,function()
        {
            $('.mainname .menu-arrow-big,.mainname .menu-arrow-little').addClass('active')
           $('.mainname ul').addClass('visible')
            if($(window).scrollTop()+$(window).height()-44>=$('form').parent().offset().top && $(window).scrollTop()<$('form').parent().offset().top+$('form').parent().height() && $('form').parent().offset().top+$('form').parent().height()>$(window).scrollTop()+$(window).height()-44)
            {
                $('.scrollmenu').show()
            }
            else
            {
                $('.scrollmenu').hide()
            }
            
        })
        $('form').on('submit',function()
        {
            var order=getorder();
            var loadp =
            {
                url:'../lib/zakaz.php',
                beforeSubmit: function(jqForm)
                {
                    var o=new Object();o.name='order';o.value=order;jqForm.push(o)
                    $('form input[type=submit]').attr('disabled',true)
                },
                success: function(responseText)
                {
                    if(responseText.indexOf('error')==-1)
                    {
                        $('input:not(input[type="submit"],input[type="radio"]),.oform textarea').val('')
                        $('input[type="deliv"]').attr('checked',false)
                        $('input[name="rest"]').attr('checked',true)
                        //$('.delete').removeAttr('style')
                        $('.textarea[name="address"]').addClass('disabled').attr('disabled',true)
                        $('.textarea[name="address"]').prev().addClass('disabled')

                        $("<div>Заказ успешно сделан. Мы свяжемся с вами!</div>" ).dialog({
                            modal:true,
                            resizable:false,
                            open: function() {
                                $('.ui-button').blur();
                                $(this).css({Height:'auto',minHeight:0})
                            },
                            position: { my: "center", at: "center", of: window },
                            close:function(){$(this).remove()},
                            buttons: [
                                { text: "Ok", click: function() {
                                    $(this).remove()
                                    $('form input[type=submit]').attr('disabled',false)
                                    window.location.href="/restaurant"

                                }}
                            ]
                        })


                    }
                    else
                    {
                        $("<div>"+responseText.replace(/<.*?>/g, '')+"</div>" ).dialog({
                            modal:true,
                            resizable:false,
                            open: function() {
                                $('.ui-button').blur();
                                $(this).css({Height:'auto',minHeight:0})
                            },
                            position: { my: "center", at: "center", of: window },
                            close:function(){$(this).remove()},
                            buttons: [
                                { text: "Ok", click: function() {
                                    $(this).remove()
                                    $('form input[type=submit]').attr('disabled',false)

                                }}
                            ]
                        })

                    }
                }
            };
            $(this).ajaxSubmit(loadp);
            return false
        })
	}
}
)(jQuery);
$(function()
{
	$('.menu-inside-container').delivery();
    $('[name=phonecode]').mask('+999')
    $('[name=phone]').mask('999999999999')
    $('[name=col]').mask('999')
})
