
(function($) {
	$.fn.bron = function(options){
	   var istouch;
       var total=0,totaldeliv=0
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
        $('form input[type=checkbox]').on('change',function()
        {
            $('[type=checkbox]').next().removeAttr('style')
            if($(this).is(':checked'))
            {
                $('input:checkbox').not( this) .removeAttr('checked').trigger('refresh')
                $(this).attr('checked',true).trigger('refresh')
                var hour=$('[name=hour]').val()
                var count=$('[name=count]').val()
                if(hour=="" || count=="")
                {
                    $('.price').html('&nbsp;')
                }
                else
                {
                    hour=parseInt($('[name=hour]').val())
                    count=parseInt($('[name=count]').val())
                    opt="<option value=''></option>";
                    if($(this).attr('name')=='hamam' || $(this).attr('name')=='bath')
                    {
                        if(count>1)
                        {
                            $('.price').text('Цена за '+hour+' '+get_hour_right_word(hour)+' на '+count+' '+get_human_right_word(count)+' '+(((count-1)*hour*50)+hour*200)+' грн')
                        }
                        else
                        {
                            $('.price').text('Цена за '+hour+' '+get_hour_right_word(hour)+' на '+count+' '+get_human_right_word(count)+' '+(hour*200)+' грн')
                        }

                        for(var i=2;i<11;i++)
                        {
                            if(i==hour)
                            {
                                opt+="<option selected value='"+i+"'>"+i+"</option>"
                            }
                            else
                            {
                                opt+="<option value='"+i+"'>"+i+"</option>"
                            }
                        }
                        $('[name=hour]').empty().append(opt).trigger('refresh');

                    }
                    else
                    if($(this).attr('name')=='banquet')
                    {

                        hour=parseInt($('[name=hour]').val())
                        count=parseInt($('[name=count]').val())
                        $('.price').text('Цена за '+hour+' '+get_hour_right_word(hour)+' на '+count+' '+get_human_right_word(count)+' '+(hour*150)+' грн')
                        for(var i=1;i<11;i++)
                        {
                            if(i==hour)
                            {
                                opt+="<option selected value='"+i+"'>"+i+"</option>"
                            }
                            else
                            {
                                opt+="<option value='"+i+"'>"+i+"</option>"
                            }
                        }
                        $('[name=hour]').empty().append(opt).trigger('refresh');

                    }
                }

            }
        })
        $('[name=hour],[name=count]').on('change',function()
        {
            var hour=$('[name=hour]').val()
            var count=$('[name=count]').val()
            if(hour=="" || count=="")
            {
                $('.price').html('&nbsp;')
            }
            else
            {
                hour=parseInt(hour)
                count=parseInt(count)
                opt="<option value=''></option>";

                if($('input:checked').attr('name')=='hamam' || $('input:checked').attr('name')=='bath')
                {
                    if(count>1)
                    {
                        console.log(count-1,50," "+hour*200)
                        $('.price').text('Цена за '+hour+' '+get_hour_right_word(hour)+' на '+count+' '+get_human_right_word(count)+' '+(((count-1)*50*hour)+hour*200)+' грн')
                    }
                    else
                    {
                        $('.price').text('Цена за '+hour+' '+get_hour_right_word(hour)+' на '+count+' '+get_human_right_word(count)+' '+(hour*200)+' грн')
                    }


                }
                else
                if($('input:checked').attr('name')=='banquet')
                {

                    hour=parseInt($('[name=hour]').val())
                    count=parseInt($('[name=count]').val())
                    $('.price').text('Цена за '+hour+' '+get_hour_right_word(hour)+' на '+count+' '+get_human_right_word(count)+' '+(hour*150)+' грн')


                }
            }


        })
//        $('.bron').on(istouch,function()
//        {
//            if($(this).hasClass('king'))
//            {
//                if($('input[name="standart"]').is(":checked"))
//                {
//                     $('.hotel-type-room input:radio').removeAttr('checked')
//                     $('input[name="king"]').attr('checked',true)
//                }
//                var numbers=$('input[name="col"]').val()
//                var nomer=$('.hotel-type-room input:checked').attr('name');
//                var days=$('input[name="days"]').val()
//                if(days=='') {days=1;$('input[name="days"]').val(days)}
//                if(numbers=='') {numbers=1;$('input[name="col"]').val(numbers)}
//
//                $('.bron-itogo').html(' <span class="text">Итого: </span>'+total_(numbers,nomer,days)+' грн')
//
//            }
//            else
//            {
//                if($('input[name="king"]').is(":checked"))
//                {
//                     $('.hotel-type-room input:radio').removeAttr('checked')
//                     $('input[name="standart"]').attr('checked',true)
//                }
//                var numbers=$('input[name="col"]').val()
//                var nomer=$('.hotel-type-room input:checked').attr('name');
//                var days=$('input[name="days"]').val()
//                if(days=='') {days=1;$('input[name="days"]').val(days)}
//                if(numbers=='') {numbers=1;$('input[name="col"]').val(numbers)}
//
//                $('.bron-itogo').html(' <span class="text">Итого: </span>'+total_(numbers,nomer,days)+' грн')
//            }
//        })


        function total_(col,nomer,days)
        {
            var trans=0
            if($('.transferradio input').is(':checked'))
            {
                trans=100
            }
            var price
            if(nomer=='standart') {price=800;
                if(col<2) nomer=1
                else nomer=2
            }
            else {price=1200;
                if(col<2) nomer=1
                else nomer=3
            }
            return Math.abs(Math.ceil(col/nomer)*price*days)+trans;
        }



        $('form').on('submit',function()
        {
            var loadp = 
            {
                url:'../lib/bhm.php',
                beforeSubmit: function(jqForm) 
                {
                    //var o=new Object();o.name='order';o.value=1;jqForm.push(o)
                    $('form input[type=submit]').attr('disabled',true)
                },
                success: function(responseText) 
                { 
                    if(responseText.indexOf('error')==-1)
                    {
                        if($('.oform').hasClass('hamam') || $('.oform').hasClass('bath'))
                        {
                            $('.oform input:not(input[type="submit"]),.oform textarea,.oform [name=name]').val('')
                            if($('.oform').hasClass('hamam'))
                            {
                                $('.oform input[type="checkbox"]').not($('.oform input[name="checkbox-hamam"]')).attr('checked',false).trigger('refresh')
                                $('.oform input[name="hamam"]').attr('checked',true).trigger('refresh').next().css('background-position','0 -24px')
                            }
                            if($('.oform').hasClass('bath'))
                            {
                                $('.oform input[type="checkbox"]').not($('.oform input[name="checkbox-bath"]')).attr('checked',false).trigger('refresh')
                                $('.oform input[name="bath"]').attr('checked',true).next().css('background-position','0 -24px')
                            }
                            $('.oform [name="hour"]').val('2').trigger('refresh')
                            $('.oform [name="count"]').val('1').trigger('refresh')
                            $('.oform input[name="phone"]').val('')
                            $('.price').text('Цена за 2 часа на 1 человека 200 грн')
                        }
                        else
                        if($('.oform').hasClass('banquet'))
                        {
                            $('.oform input:not(input[type="submit"]),.oform textarea,.oform [name=name]').val('')

                            $('.oform input[type=checkbox]').attr('checked',false)
                            $('input[name=banquet]').attr('checked',true).next().css('background-position','0 -24px')

                            $('.oform input[name="hour"]').val('1')
                            $('.oform input[name="count"]').val('1')
                            $('.oform input[name="phone"]').val('')
                            $('.price').text('Цена за 1 час на 1 человека 150 грн')
                        }

                        $("<div>Бронирование выполнено. Мы свяжемся с вами!</div>" ).dialog({
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
        $('.calend').on(istouch,function()
        {
            $('.calendar').show()

        })
        $(document).on('change','[name=select_1_1]',function()
        {
            var sname=$(this).attr('name')
            if(sname=="select_1_1")
            {
                var valsel1_day=$('[name=select_1]').val(),valsel1_m_y=$('[name=select_1_1]').val(),valsel1_m_y_split=valsel1_m_y.split('.');

                var colofmonth;
               colofmonth=new Date(valsel1_m_y_split[1], parseInt(valsel1_m_y_split[0]), 0).getDate()

                console.log(colofmonth)
                var arrofday=["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]
                var vareia="",opt_1="";
                opt_1+="<option value=''>День</option>";
                for(var i=1;i<=colofmonth;i++)
                {
                   vareia=arrofday[new Date(valsel1_m_y_split[1], valsel1_m_y_split[0], i).getDay()];
                    opt_1+="<option value='"+i+"'>"+vareia+" "+i+"</option>";

                }
                $('[name=select_1]').empty().append(opt_1)
            }


        })
        $(document).click(function(event) {
            var classname=$(event.target).attr('class');
            if (typeof(classname)=="undefined" || !$(event.target).hasClass('calend')) {
                if(!$(event.target).hasClass('ui-icon-circle-triangle-e') && !$(event.target).hasClass('ui-icon-circle-triangle-w') && $(event.target).parents('.calendar').length==0)
                {
                    $('.calendar').hide()
                }

            }
        });
	}
}
)(jQuery);
$(function()
{
	$(document).bron();
    $('[name=phone]').mask('+999999999999999')

})
function get_hour_right_word(count)
{
    if(count%10==1 && count!=11)
    {
        return 'час'
    }
    else
    if((count%10==2 || count%10==3 || count%10==4) && (count!=12 && count!=13 && count!=14))
    {
        return 'часа'
    }
    else
//    if(count%10==0 || count%10>4 || i==11 || i==12 || i==13 || i==14)
    {
        return 'часов'
    }

}
function get_human_right_word(count)
{

    if((count%10==1 || count%10==2 || count%10==3 || count%10==4) && (count!=2 && count!=3 && count!=4 && count!=11 && count!=12 && count!=13 && count!=14))
    {
        return 'человека'
    }
    else
    {
        return 'человек'
    }

}