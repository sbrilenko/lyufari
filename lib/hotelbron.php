<?
$datescript = new DateTime(date('Y').'-'.date('m').'-'.date('d'));
$datescriptnext = new DateTime(date('Y').'-'.date('m').'-'.date('d'));
$datescriptnext ->modify('+1 day');
?>
<script type="text/javascript">
    function appendtoselects(selector)
    {
        selector.hide()
        date = selector.datepicker('getDate'),
        day  = date.getDate(),
        month = date.getMonth() + 1,
        year =  date.getFullYear();
        var colofmonth=new Date(year, month, 0).getDate()
        var opt_1="",opt_2="";
        var arrofday=["Чт", "Пт", "Сб", "Вс", "Пн", "Вт", "Ср"]
        var vareia="";
        var arrayofmonth=['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь']
        opt_1+="<option value=''>День</option>";
        for(var i=1;i<=colofmonth;i++)
        {
            vareia=arrofday[new Date(year, month, i).getDay()];
            if(day==i)
            {
                opt_1+="<option selected value='"+i+"'>"+vareia+" "+i+"</option>";
            }
            else
            {
                opt_1+="<option value='"+i+"'>"+vareia+" "+i+"</option>";
            }
        }
        $('select',selector.parents('.hotel_bron')).eq(0).empty().append(opt_1)
        opt_2+="<option value=''>Месяц</option>";
        for(var j=month-1;j<12;j++)
        {
            if(j==month-1)
            {
                opt_2+="<option selected value='"+(j)+"."+year+"'>"+arrayofmonth[j]+" "+year+"</option>";
            }
            else
            {
                opt_2+="<option value='"+(j)+"."+year+"'>"+arrayofmonth[j]+" "+year+"</option>";
            }
        }
        if(month>1)
        {
            for(var j=0;j<(month-1);j++)
            {
                opt_2+="<option value='"+(j)+"."+(year+1)+"'>"+arrayofmonth[j]+" "+(year+1)+"</option>";
            }
        }
        $('select',selector.parents('.hotel_bron')).eq(1).empty().append(opt_2)

        if($('.first-calenblok',selector.parent()).length>0)
        {
            $('.calendar',$('.second-calenblok').parent()).datepicker("option", "minDate", new Date(year,month-1,day+1))
            //$('.calendar',$('.second-calenblok').parent()).datepicker("option","maxDate", new Date(year+1,month-1,day))
        }

    }
    $(document).ready(function()
    {
        $(".calendar").eq(0).datepicker({minDate:new Date(<?=$datescript->format('Y').",".($datescript->format('m')-1).",".$datescript->format('d');?>),
            maxDate:new Date(<?=$datescript->format('Y')+1?>,<?=$datescript->format('m')-1?>,<?=$datescript->format('d')?>),
            'onSelect': function(i) {
                appendtoselects($(this))
                putprice()
            },
            onClose: function(){$(this).blur()}

        }).hide();
        $(".calendar").eq(1).datepicker({minDate:new Date(<?=$datescriptnext->format('Y').",".($datescriptnext->format('m')-1).",".$datescriptnext->format('d');?>),
            maxDate:new Date(<?=$datescriptnext->format('Y')+1?>,<?=$datescriptnext->format('m')-1?>,<?=$datescriptnext->format('d')?>),
            'onSelect': function(i) {
                appendtoselects($(this))
                putprice()
            },
            onClose: function(){$(this).blur()}

        }).hide();
    })

</script>
<div class="get_direction get_bron <?=$form;?>" >
    <form method="post">
    <img class="img_bg" src="../img/bg_get_bron.png">
    <div class="f-l left">
        <p>Забронировать</p>
        <div class="arrow"></div>
    </div>
    <div class="f-l right">
        <div class="title" style="margin:-3px 0 10px -103px;">
            Предварительная<br/>
            бронь номера
        </div>
        <div>
            <?php
            $arrayofday=array('Вс','Пн','Вт','Ср','Чт','Пт','Сб');
            $arrayofdmonth=array('Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
            ?>
            <div class="hotel_bron">
                <div class="oform-input-text">Дата вьезда</div>
                <div style="position: absolute;margin-top: 27px;z-index: 999;" class="calendar"></div>
                <div class="f-l calend first-calenblok" style="margin-left: 0;"></div><div class="p-r f-l">
                    <select style="margin-left: 3px;margin-right: 4px;line-height: 21px;" class="" name="select_1">
                        <option value="">День</option>
                        <?
                        $colday=date("t");
                        for($i=0;$i<$colday;$i++)
                        {
                            $tempDate = date('Y').'-'.date('m').'-'.($i+1);
                            if(($i+1)==date('d'))
                            {
                                echo "<option selected value='".($i+1)."'>".$arrayofday[date('w', strtotime( $tempDate))]." ".($i+1)."</option>";
                            }
                            else
                            {
                                echo "<option value='".($i+1)."'>".$arrayofday[date('w', strtotime( $tempDate))]." ".($i+1)."</option>";
                            }
                        }
                        ?>

                    </select></div>
                <div class="p-r f-l"><select name="select_1_1" class="select_big" style="width: 162px;margin-top: 1px;line-height: 22px;">
                        <option value="">Месяц</option>
                        <?
                        echo "<option selected value='".((int)date('m')-1).".".date('Y')."'>".$arrayofdmonth[(int)date('m')-1]." ".date('Y')."</option>";

                        for($j=(int)date('m');$j<12;$j++)
                        {
                            echo "<option value='".($j).".".date('Y')."'>".$arrayofdmonth[$j]." ".date('Y')."</option>";

                        }
                        if((int)date('m')>1)
                        {
                            for($j=0;$j<(int)date('m');$j++)
                            {
                                echo "<option value='".($j).".".(date('Y')+1)."'>".$arrayofdmonth[$j]." ".(date('Y')+1)."</option>";
                            }
                        }
                        ?>

                    </select></div>

            </div>
            <div class="clear"></div>
            <div style="margin-top: 15px;">
                <div class="hotel_bron">
                    <div class="oform-input-text">Дата выезда</div>
                    <?php
                    $date = new DateTime(date('Y').'-'.date('m').'-'.date('d'));
                    $date->modify('+1 day');
                    ?>
                    <div style="position: absolute;margin-top: 27px;z-index: 999;" class="calendar"></div>
                    <div class="f-l calend second-calenblok" style="margin-left: 0;"></div><div class="p-r f-l"><select  style="margin-left: 3px;margin-right: 4px;line-height: 21px;" name="select_2">
                            <option value="">День</option>
                            <?
                            $colday=date("t",strtotime($date->format('Y-m-d')));
                            for($i=0;$i<$colday;$i++)
                            {
                                $tempDate = $date->format('Y').'-'.$date->format('m').'-'.($i+1);
                                if(($i+1)==$date->format('d'))
                                {
                                    echo "<option selected value='".($i+1)."'>".$arrayofday[date('w', strtotime( $tempDate))]." ".($i+1)."</option>";
                                }
                                else
                                {
                                    echo "<option value='".($i+1)."'>".$arrayofday[date('w', strtotime( $tempDate))]." ".($i+1)."</option>";
                                }
                            }
                            ?>
                        </select></div>
                    <div class="p-r f-l"><select name="select_2_2" class="select_big" style="width: 162px;margin-top: 1px;line-height: 22px;">
                            <option value="">Месяц</option>
                            <?
                            echo "<option selected value='".((int)$date->format('m')-1).".".date('Y')."'>".$arrayofdmonth[(int)$date->format('m')-1]." ".date('Y')."</option>";
                            for($j=(int)$date->format('m');$j<12;$j++)
                            {
                                echo "<option value='".($j).".".$date->format('Y')."'>".$arrayofdmonth[$j]." ".$date->format('Y')."</option>";

                            }
                            if((int)$date->format('m')>1)
                            {
                                for($j=0;$j<(int)$date->format('m');$j++)
                                {
                                    echo "<option value='".($j).".".($date->format('Y')+1)."'>".$arrayofdmonth[$j]." ".($date->format('Y')+1)."</option>";
                                }
                            }
                            ?>

                        </select></div>

                </div>
                <div class="clear"></div>
            </div>
            <div class="cl" style="margin-top: 22px;"></div>

            <?php
            if($form=='delux')
            {
            ?>
                <div class="oform-input-text f-l" style="line-height: 30px;margin-right: 13px;">Количество человек<div style="font-size:12px;line-height: 12px;">Количество номеров - 5 шт</div></div>
            <?php
            } else {
            ?>
                <div class="oform-input-text f-l" style="line-height: 30px;margin-right: 13px;">Количество человек</div>
            <?php
            }
            ?>

            <div class="hotel_bron"><div class="selecth f-l">
                        <select name="count"><option value=""></option>
                        <?
                        if($form=='delux')
                        {
                            echo ' <option selected value="1">1</option>';
                            echo ' <option selected value="2">2</option>';
//                            for($i=2;$i<11;$i++)
//                            {
//                                echo ' <option value="'.$i.'">'.$i.'</option>';
//                            }
                        }
                        else
                        {
                            echo ' <option selected value="1">1</option>';
                            for($i=2;$i<7;$i++)
                            {
                                echo ' <option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                        ?>
                    </select></div>
            </div>

            <div class="cl"></div>
            <input class="chek" type="checkbox" id="checkbox-id" name="transfer">
            <?php
            if($form=='delux')
            {
            ?>
                <label class="chekleb" for="checkbox-id" style="margin-top: 10px;">Трансфер - 100 грн</label >
            <?php
            } else {

             ?>
                <label class="chekleb" for="checkbox-id" style="margin-top: 10px;">Трансфер</label >
            <?php
            }
            ?>


            <div class="cl"></div>
            <div class="oform-input-text" style="margin-top: 9px;">ФИО (как к вам обращаться)*</div>
            <div><input name="name" class="input_oform " style="width:280px"></div>



            <div class="oform-after-input"></div>
            <div class="cl"></div>

        </div>

        <div class=" number" style="width: 300px;">
            <div class="oform-input-text" style="margin-top: 8px;">Контактный телефон *  </div>
            <input class="input_oform r_o" type="text" value="" name="phonecode">
            <input class="input_oform" type="text" style="width: 222px;"  name="phone">
            <div class="clr"></div>
            <span class="text_gray">*Номер телефона в международном формате <br/> (+380 95 123 22 33)</span>


        </div>
        <div class="clear"></div>
        <div class="oform-input-text" style="font-size: 16px;margin-top: 13px;">Комментарий</div>
        <textarea name="comm" class="input_oform" style="width: 278px !important;resize: none;height: 90px;line-height: 18px;"></textarea>

        <p class="total">Завтрак включен<br/>
            <?php
            if($form=="delux")
            {?>
            <span class="price">Цена за <?=abs(strtotime($datescriptnext->format('Y-m-d')) - strtotime($datescript->format('Y-m-d')))/ 86400;?> сутки  <?=(abs(strtotime($datescriptnext->format('Y-m-d')) - strtotime($datescript->format('Y-m-d')))/ 86400)*1*800?> грн<span></p>
            <?php
            }else {
            ?>
                 <span class="price">Цена за <?=abs(strtotime($datescriptnext->format('Y-m-d')) - strtotime($datescript->format('Y-m-d')))/ 86400;?> сутки  <?=(abs(strtotime($datescriptnext->format('Y-m-d')) - strtotime($datescript->format('Y-m-d')))/ 86400)*1*1600?> грн<span></p>
            <?}?>


        <input type="submit" class="button bron-sub" value="Бронировать" style="margin-top: 26px;">
        </form>
    </div>
</div>