
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
                    console.log(data)
                }
    		});
            console.log(sess)
            return sess;
        }
        $('.icons-menu-print,.icons-menu-mail,a.swimprint').on(istouch,function()
        {
            var get=getorder()
            if(get.length>0)
            {
                window.open("/rus/print","_blank");
            }
            else
            {
                $("<div>Сделайте заказ</div>" ).dialog({
                    modal:true,
                    resizable:false,
                    open: function() {
                        $('.ui-button').blur();
                        $(this).css({Height:'auto',minHeight:0})
                    },
                    position: { my: "center", at: "center", of: window },
                    close:function(){$(this).remove()},
                    buttons: [
                        { text: "Ок", click: function() {

                            $(this).remove()
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
        $('.oform-form-w input:radio').on('click',function()
        {
            if($(this).is(":checked"))
            {
                 $('.oform-form-w input:radio').removeAttr('checked')
                 $(this).attr('checked',true)
                 if($(this).attr('name')=='rest')
                 {
                    $('textarea[name="address"]').attr('disabled',true).addClass('disabled')
                    $('textarea[name="address"]').prev().addClass('disabled')
                 }
                 else
                 {
                    $('textarea[name="address"]').attr('disabled',false).removeClass('disabled')
                    $('textarea[name="address"]').prev().removeClass('disabled')
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
            $('.price-for-delivery,.swim-itogo-text-deliv').text('Сумма заказа для доставки: '+totaldeliv+'грн')
            if(totaldeliv>=250) { $('.free-delivery').addClass('actdeliv'); $('.swim-itogo-text-deliv').addClass('active')}
            else {$('.free-delivery').removeClass('actdeliv');$('.swim-itogo-text-deliv').removeClass('active')}
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
            $('.price-for-delivery,.swim-itogo-text-deliv').text('Сумма заказа для доставки: '+totaldeliv+'грн')
            if(totaldeliv>=250) {$('.free-delivery').addClass('actdeliv');$('.swim-itogo-text-deliv').addClass('active')} 
            else {$('.free-delivery').removeClass('actdeliv');$('.swim-itogo-text-deliv').removeClass('active')}
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
            var loadp = 
            {
                url:'../lib/zakaz.php',
                beforeSubmit: function(jqForm) 
                {
                    var o=new Object();o.name='order';o.value=getorder();jqForm.push(o)
                    $('.oforml-sub').attr('disabled',true)
                },
                success: function(responseText) 
                { 
                    if(responseText.indexOf('error')==-1)
                    {
                        $('.oform input:not(input[type="submit"],input[type="radio"]),.oform textarea').val('')
                        $('.oform input[type="radio"]').attr('checked',false)
                        $('.oform input[name="rest"]').attr('checked',true)
                        //$('.delete').removeAttr('style')
                        $('.textarea[name="address"]').addClass('disabled').attr('disabled',true)
                        $('.textarea[name="address"]').prev().addClass('disabled')
                        $(".oform select :nth-child(1)").attr("selected", "selected");
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1; //January is 0!
                        
                        var yyyy = today.getFullYear();
                        if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = dd+'.'+mm+'.'+yyyy;
                        $('input[name="data"]').val(today);
                        $("<div>Заказ успешно сделан. Мы свяжемсся с вами!</div>" ).dialog({
                            modal:true,
                            resizable:false,
                            open: function() {
                                $('.ui-button').blur();
                                $(this).css({Height:'auto',minHeight:0})
                            },
                            position: { my: "center", at: "center", of: window },
                            close:function(){$(this).remove()},
                            buttons: [
                                { text: "Ок", click: function() {
                                    $(this).remove()
                                    $('.oform').animate({height:0},1000,function()
                                    {
                                        $('.oform').hide();
                                        $('.oforml-sub').attr('disabled',false)
                                    })

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
                                { text: "Ок", click: function() {
                                    $(this).remove()
                                    $('.oforml-sub').attr('disabled',false)
//                                    $('.oform').animate({height:0},1000,function()
//                                    {
//                                        $('.oform').hide();
//                                        $('.oforml-sub').attr('disabled',false)
//                                    })

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
})
