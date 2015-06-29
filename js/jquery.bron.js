//console.log(new Date(2013,11,0).getDate());
function putprice()
{
    var counth=$('.get_bron [name=count]').val()
    var transfer=0
    if($('[name=transfer]').is(':checked'))
    {
        transfer=1
    }
    var valsel1_day=$('[name=select_1]').val(),valsel1_m_y=$('[name=select_1_1]').val(),valsel1_m_y_split=valsel1_m_y.split('.');
    var valsel2_day=$('[name=select_2]').val(),valsel2_m_y=$('[name=select_2_2]').val(),valsel2_m_y_split=valsel2_m_y.split('.');
    if(valsel1_day=="" || valsel1_m_y=="" || valsel2_day=="" || valsel2_m_y=="" || counth=="") //если какое либо поле равняется пустоте, то в любом случаем скрываем поле
    {
        $('.price').empty().append("&nbsp;")
    }
    else
    if(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))<=0)
    {
        //скрываем поле цена
        $('.price').empty().append("&nbsp;")
    }
    else
    {
        var newprice=(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))*parseInt(counth)
        //показываем поле цена
        if($('.get_bron').hasClass('delux'))
        {
            var nomer="";
            if(parseInt(counth)<2) nomer=1;
            else nomer=2;
//            console.log(Math.ceil(parseInt(counth)/nomer)*800*Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))
            if(transfer==1)
            {
//                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+((newprice*800)+100)+" грн")
//                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+(Math.ceil(parseInt(counth)/nomer)*800*Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))+100)+" грн")
                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+(800*Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))+100)+" грн")
            }
            else
            {
//                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+newprice*800+" грн")
                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+(800*Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" грн")
            }

        }
        else
        {
            var nomer="";
            if(parseInt(counth)<2) nomer=1;
            else nomer=3;
            if(transfer==1)
            {
//                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+((newprice*1200)+100)+" грн")
                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+(1600*Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))+100)+" грн")
            }
            else
            {
//                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+newprice*1200+" грн")
                $('.price').empty().append("Цена за "+(Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" "+get_night_right_word((Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24))))+" "+(1600*Math.floor((new Date(valsel2_m_y_split[1],valsel2_m_y_split[0],valsel2_day).getTime() - new Date(valsel1_m_y_split[1],valsel1_m_y_split[0],valsel1_day).getTime())/(1000*60*60*24)))+" грн")
            }
        }

    }
}
$(function()
{
    $(document).click(function(event) {
        var classname=$(event.target).attr('class');
        if (typeof(classname)=="undefined" || !$(event.target).hasClass('calend')) {
            if(!$(event.target).hasClass('ui-icon-circle-triangle-e') && !$(event.target).hasClass('ui-icon-circle-triangle-w') && $(event.target).parents('.calendar').length==0)
            {
                $('.calendar').hide()
            }

        }
    });

    var istouch;
    if((!!('ontouchstart' in window)))
    {
        istouch='touchend';
    }
    else
    {
        istouch='click';
    }
    $('[name=transfer]').on('change',function()
    {
        putprice()


    })



    $('.get_bron form').on('submit',function()
    {

        var loadp =
        {
            url:'../lib/bron.php',
            beforeSubmit: function(jqForm)
            {
                var o=new Object();o.name='roomtype';
                o.value=($('.get_bron').hasClass('delux'))?"delux":"apartment";
                jqForm.push(o)
                $('form input[type=submit]').attr('disabled',true)
            },
            success: function(responseText)
            {
                $('form input[type=submit]').attr('disabled',false)

                if(responseText.indexOf('error')==-1)
                {
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
                            { text: "Ок", click: function() {

                                $(this).remove()
                            }}
                        ]
                    })
                    $('form input[type=submit]').attr('disabled',false)

                }
                else
                {
                    //alert(responseText.replace(/<.*?>/g, ''));
                        $("<div>"+responseText.replace(/<.*?>/g, '')+"</div>" ).dialog({
                            modal:true,
                            resizable:false,
                            open: function() {
                                $('.ui-button').blur();
                                $(this).css({Height:'auto',minHeight:0})
                            },
                            position: { my: "center", at: "center", of: window },
                            close:function(){console.log('close');$(this).remove()},
                            buttons: [
                                { text: "Ok", click: function() {
                                    $(this).remove()
                                }}
                            ]
                        })
                    $('form input[type=submit]').attr('disabled',false)
                }
            }
        };
        $(this).ajaxSubmit(loadp);
        return false
    })
    $('.calend').on(istouch,function()
    {
        $('.calendar').hide()
        $('.calendar',$(this).parents('.hotel_bron')).show()

    })
    $(document).on('change','.get_direction select',function()
    {
        var sname=$(this).attr('name')
        if(sname=="select_1_1" || sname=="select_2_2")
        {
            var valsel1_day=$('[name=select_1]').val(),valsel1_m_y=$('[name=select_1_1]').val(),valsel1_m_y_split=valsel1_m_y.split('.');
            var valsel2_day=$('[name=select_2]').val(),valsel2_m_y=$('[name=select_2_2]').val(),valsel2_m_y_split=valsel2_m_y.split('.');


            var colofmonth;
            if(sname=="select_1_1")
            {
               colofmonth=new Date(valsel1_m_y_split[1], parseInt(valsel1_m_y_split[0])+1, 0).getDate()
            }
            if(sname=="select_2_2")
            {
                colofmonth=new Date(valsel2_m_y_split[1], parseInt(valsel2_m_y_split[0])+1, 0).getDate()
            }
            console.log(colofmonth)
            var arrofday=["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]
            var vareia="",opt_1="";
            opt_1+="<option value=''>День</option>";
            for(var i=1;i<=colofmonth;i++)
            {
                if(sname=="select_1_1")
                {
                    vareia=arrofday[new Date(valsel1_m_y_split[1], valsel1_m_y_split[0], i).getDay()];
                }
                if(sname=="select_2_2")
                {
                    vareia=arrofday[new Date(valsel2_m_y_split[1], valsel2_m_y_split[0], i).getDay()];
                }

                opt_1+="<option value='"+i+"'>"+vareia+" "+i+"</option>";

            }
            $('select',$(this).parents('.hotel_bron')).eq(0).empty().append(opt_1)
        }
        //при смене селекта нужно посчитать количество дней
//        console.log(Math.floor((new Date(2014,5,5).getTime() - new Date(2013,5,7).getTime())/(1000*60*60*24)))
        putprice()
//        if($(this).attr('name')=="select_1" || $(this).attr('name')=="select_1_1")
//        {
//            if($(this).val()=="")
//            {
//                $('.calendar',$('.first-calenblok').parent()).datepicker("option", "minDate", new Date())
//                $('.calendar',$('.second-calenblok').parent()).datepicker("option", "minDate", new Date())
//                $('.calendar',$('.first-calenblok').parent()).datepicker("option","maxDate", new Date(new Date().getFullYear()+1,new Date().getMonth(),new Date().getDate()))
//                $('.calendar',$('.second-calenblok').parent()).datepicker("option","maxDate", new Date(new Date().getFullYear()+1,new Date().getMonth(),new Date().getDate()))
//            }
//        }
//        else
//        if($(this).attr('name')=="select_2" || $(this).attr('name')=="select_2_2")
//        {
//            if($(this).val()=="")
//            {
//                $('.calendar',$('.second-calenblok').parent()).datepicker("option", "minDate", new Date())
//                $('.calendar',$('.second-calenblok').parent()).datepicker("option","maxDate", new Date(new Date().getFullYear()+1,new Date().getMonth(),new Date().getDate()))
//            }
//        }

    })
    $('[name=phonecode]').mask('+999')
    $('[name=phone]').mask('999999999999')
})
function get_night_right_word(count)
{
//    if(count%10==1 && count!=11)
//    {
//        return 'ночь'
//    }
//    else
//    if((count%10==2 || count%10==3 || count%10==4) && (count!=12 && count!=13 && count!=14))
//    {
//        return 'ночи'
//    }
//    else
////    if(count%10==0 || count%10>4 || i==11 || i==12 || i==13 || i==14)
//    {
//        return 'ночей'
//    }
    if(count%10==1 && count!=11)
    {
        return 'сутки'
    }
    else
    {
        return 'суток'
    }
}

