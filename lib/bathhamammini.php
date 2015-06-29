<?
$datescript = new DateTime(date('Y').'-'.date('m').'-'.date('d'));
//$page->addScript('js/mask.js','js/jquery.restbron.js');
$page->addScript('js/mask.js');
?>
<script type="text/javascript">

    $(document).ready(function()
    {
        $(".calendar").eq(0).datepicker({minDate:new Date(<?=$datescript->format('Y').",".($datescript->format('m')-1).",".$datescript->format('d');?>),
            maxDate:new Date(<?=$datescript->format('Y')+1?>,<?=$datescript->format('m')-1?>,<?=$datescript->format('d')-1?>),
            'onSelect': function(i) {
                    $(this).hide()
                    date = $(this).datepicker('getDate'),
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
                    $('select').eq(0).empty().append(opt_1)
                    $("[name=select_1_1] option").removeAttr('selected').trigger('refresh')
                    $('[name=select_1_1] [value="'+(month)+'.'+year+'"]').attr("selected", "selected").trigger('refresh')
//                    for(var j=month-1;j<12;j++)
//                    {
//                        if(j==month-1)
//                        {
//                            opt_2+="<option selected value='"+(j+1)+"."+year+"'>"+arrayofmonth[j]+" "+year+"</option>";
//                        }
//                        else
//                        {
//                            opt_2+="<option value='"+(j+1)+"."+year+"'>"+arrayofmonth[j]+" "+year+"</option>";
//                        }
//                    }
//                    if(month>1)
//                    {
//                        for(var j=0;j<(month-1);j++)
//                        {
//                            opt_2+="<option value='"+(j+1)+"."+(year+1)+"'>"+arrayofmonth[j]+" "+(year+1)+"</option>";
//                        }
//                    }
//                    $('select').eq(1).empty().append(opt_2)


            },
            onClose: function(){$(this).blur()}

        }).hide();
    })

</script>
<form method="post">
    <div class="f_l left_block" >
        <p>Оформить заказ</p>

        <span>Стоимость аренды часа в бане на дровах или турецком хамаме составляет 250,00 грн/час (в расчете на 2 гостей) +50,00 грн/час на каждого следующего гостя; 200 грн/час (в расчете на 1 гостя). Минимальное время аренды - 2 часа. В стоимость входят необходимые аксессуары для приятного время проведения в бане или хамаме: полотенца, халаты, тапочки. Обязательно внесение предоплаты в размере 400 грн. Заказ и предоплата принимаются не позже, чем за 2 часа. За отдельную стоимость мы предоставляем веники и ароматницу (уточнять у администратора).</span>
        <span> Вы также можете заказать дополнительные услуги, аксессуары и порадовать себя изысканной кухней ресторана «Люфари». </span>
        <span>Стоимость аренды мини - банкетного зала с бильярдом - 150,00 грн/час. </span>

    </div>

    <div class='f-r right_block' style="width: 32%;">
        <div class="oform-input-text">ФИО (как к вам обращаться)*</div>
        <div><input name="name" class="input_oform" style="width: 100%;" /></div>
        <div class="cl"></div>
        <div class="oform-after-input"></div>
        <div class="cl"></div>

        <div class="oform-input-text">Ваш контактный номер телефона*</div>
        <div><input name="phone"  class="input_oform" style="width: 100%;" value=""/></div>
        <div class="clr"></div>
        <span class="text_gray">*Номер телефона в международном формате (+380 95 123 22 33)</span>
        <div class="cl"></div>
        <div class="oform-after-input" ></div>
        <div class="oform-input-text">Комментарий</div>
        <textarea name='comm' class="input_oform" style="width:100% !important;"></textarea>
        <div class="cl"></div>
        <div class="f-l bron-itogo" style="text-align:left;margin-top: 34px;overflow: hidden;">
            <span class="text price">
            <?php
             if($form=="bath" OR $form=="hamam")
             {
                echo "Цена за 2 часа на 1 человека 400 грн";
             }
             else
             {
                 echo "Цена за 1 час на 1 человека 150 грн";
             }
            ?>
            </span>
        </div>
        <input type='submit' class='button bron-sub' value='Бронировать'/>
    </div>
    <div  style="width: 288px;margin: 0 auto;overflow: hidden;">
        <?php
        $arrayofday=array('Вс','Пн','Вт','Ср','Чт','Пт','Сб');
        $arrayofdmonth=array('Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
        ?>
        <div class="" >
            <div class="oform-input-text">Дата </div>
            <div style="position: absolute;margin-top: 27px;z-index: 999;" class="calendar"></div>
            <div class="f-l calend" style="margin-left: 0;"></div><div class="p-r f-l">
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

                </select>

                </select></div>
            <div class="p-r f-l"><select name="select_1_1" class="select_big" style="width: 162px;margin-top: 1px;line-height: 22px;">
                    <option value="">Месяц</option>
                    <?
                    echo "<option selected value='".((int)date('m')-1).".".date('Y')."'>".$arrayofdmonth[(int)date('m')-1]." ".date('Y')."</option>";

                    for($j=(int)date('m');$j<12;$j++)
                    {
                        echo "<option value='".($j+1).".".date('Y')."'>".$arrayofdmonth[$j]." ".date('Y')."</option>";

                    }
                    if((int)date('m')>1)
                    {
                        for($j=0;$j<(int)date('m');$j++)
                        {
                            echo "<option value='".($j+1).".".(date('Y')+1)."'>".$arrayofdmonth[$j]." ".(date('Y')+1)."</option>";
                        }
                    }
                    ?>

                </select></div>
            <div style="clear:both"></div>
            <div class="oform-input-text " style="margin-top: 14px;">Время посещения</div>
            <div><div class="selecth f-l">
                        <select  style="padding-left: 22px;" name="h">
                        <option style="padding-left: 21px;line-height: 21px;" value=""></option>
                        <option value="01">1</option>
                        <option value="02">2</option>
                        <option value="03">3</option>
                        <option value="04">4</option>
                        <option value="05">5</option>
                        <option value="06">6</option>
                        <option value="07">7</option>
                        <option value="08">8</option>
                        <option value="09">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="00">00</option>
                    </select></div><div class='f-l oform-input-text' style="text-align: center;width: 16px;line-height: 38px;font: bold 28px/21px arial;color: #2e1911;margin-top: 2px;">:</div><div class="selecth f-l">
                        <select class='selecth' name="min" style="padding-left: 21px;line-height: 21px;">
                        <option value="00"> </option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                        <option value="00">00</option>
                    </select></div></div>
        </div>
        <div class="clr" style="margin-bottom: 14px;"></div>

        <div style="max-width: 236px;">
            <div class="oform-input-text f-l" style="line-height: 30px;">Количество часов</div>
            <div><div class="selecth f-r">
                        <select style="padding-left: 17px;"  class="midle_select" name="hour">
                         <?
                            if($form=="hamam" OR $form=="bath")
                            {
                                echo '<option value=""></option><option selected value="2">2</option>';
                                for($i=3;$i<11;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            }
                            else
                            {
                                echo '<option value=""></option><option selected value="1">1</option>';
                                for($i=2;$i<11;$i++)
                                {
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            }
                         ?>
                    </select></div>
            </div>

            <div class="clr" style="margin-bottom: 7px;"></div>
            <div class="oform-input-text f-l" style="line-height: 30px;">Количество человек</div>
            <div><div class="selecth f-r">
                        <select  style="padding-left: 17px;" class="midle_select" name="count">
                        <option value=""></option>
                        <?
                            echo '<option selected value="1">1</option>';
                            for($i=2;$i<11;$i++)
                            {
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        ?>

                    </select></div>
            </div>
        </div>
        <?php
        if($form=="hamam")
        {
            echo '<img style="margin: 2px 0 17px -7px" src="../img/restarea_pom_hamam.png"/>';
        }
        else
        if($form=="bath")
        {
            echo '<img style="margin: 2px 0 17px -7px" src="../img/restarea_pom.png"/>';
        }
        else
        if($form=="banquet")
        {
            echo '<img style="margin: 2px 0 17px -7px" src="../img/restarea_pom_banq.png"/>';
        }
        ?>

        <div style="display: none">
        <?
        if($form=="hamam")
        {
            echo '<input name="hamam" checked class="chek" type="checkbox" id="checkbox-hamam">';
        }
        else
        {
            echo '<input name="hamam" class="chek" type="checkbox" id="checkbox-hamam">';
        }
        ?>

        <label class="chekleb" for="checkbox-hamam">Турецкий хамам</label>
        <br/>

        <?
        if($form=="bath")
        {
            echo '<input name="bath" checked class="chek" type="checkbox" id="checkbox-bath">';
        }
        else
        {
            echo '<input name="bath" class="chek" type="checkbox" id="checkbox-bath">';
        }
        ?>

        <label class="chekleb" for="checkbox-bath">Баня на дровах</label><br/>

        <?
        if($form=="banquet")
        {
            echo '<input name="banquet" checked class="chek" type="checkbox" id="checkbox-banquet">';
        }
        else
        {
            echo '<input name="banquet" class="chek" type="checkbox" id="checkbox-banquet">';
        }
        ?>

        <label class="chekleb" for="checkbox-banquet">Мини-банкетный зал</label>
        </div>
        <div class="oform-after-input"></div>
        <div class="cl"></div>

    </div>

</form>