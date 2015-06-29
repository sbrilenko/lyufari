<?php
$message = "dsdsdsdsd";

//$message = '=?utf-8?B?'.base64_encode($message).'?=';
//        $subject = '=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?=';
//        $headers = "From: ".$subject." mail ".$to." \n";
//        mail($_POST['email'], $subject, $message, $header);

$header="Content-type: text/html; charset=\"utf-8\"";
$subject = '=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?=';
$header.= 'From:=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?='. '<reception@lyufari.com>' . "\r\n" ;
$header.= 'From: reception@lyufari.com' . "\r\n" .
    'Reply-To: reception@lyufari.com' . "\r\n";
$message='
    <table style="background: #1c0600 url("http://lyufari.com/img/new_bg.png") repeat;margin:0 auto;min-width:600px;max-width:600px;padding:0 15px;" width="600" cellpadding="0" cellspacing="0">

                                <tbody><tr>

                                    <td>
                                    <table>
                                        <tbody>
                                        <tr >
                                            <td align="left" style="padding-top: 25px;width: 216px;">
                                                <img src="http://lyufari.com/img/text_top.png" width="204"/>
                                            </td>
                                            <td align="center" style="padding-top: 20px">
                                                <img src="http://lyufari.com/img/logo_new.png" width="140"/>
                                            </td>
                                            <td align="right" style="font:14px/22px arial;color: #e5c887;padding-top: 25px">
                                                <span>+38 (067) 862 86 48</span><br/>
                                                <span>+38 (095) 172 72 72</span><br/>
                                                <a target="_blank" style="font:14px/22px arial;color: #e5c887;" href="http://lyufari.com/">lyufari.com</a>
                                            </td>
                                        </tr>

                                        <tr>

                                            <td colspan="3" style="padding-top: 40px"><img src="http://lyufari.com/img/mail_main.png" width="600"/> </td>
                                        </tr>

                                        <tr>

                                            <td colspan="3" style="padding-top: 20px;font:16px/24px Georgia;color: #e5c887;font-style: italic;">Гостинично-ресторанный комплекс «Люфари» расположен в спокойной части делового центра города Донецка. Благодаря удобному расположению усадьбы Вы легко доберетесь до аэропорта, железнодорожного вокзала, спортивных стадионов, бизнес-центров и других достопримечательностей города. </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" style="padding-top: 20px;"><img src="http://lyufari.com/img/mail_text.png" width="600"/></td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" align="center" style="padding-top: 20px;padding-bottom:10px;font: 24px/30px Georgia;color: #e5c887;text-transform: uppercase">Гостиница</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" align="center"><img src="http://lyufari.com/img/mail_hotel.png" style="border:1px solid #9c9c9c;"/></td>
                                        </tr>

                                        <tr>

                                            <td colspan="3" style="padding-top: 10px;font:16px/24px Georgia;color: #e5c887;">Удобное расположение гостиницы «Люфари» позволит Вам быстро добраться до центра Донецка, Отсутствие загруженной автомагистрали даст возможность отдохнуть от суеты города.</td>
                                        </tr>




                                        </tbody>
                                    </table>



    <table style="font:14px/22px Georgia;color: #e5c887;">
    <tbody>

                                <tr>
                                    <td   align="left" style="text-align:center;padding-top: 30px;padding-bottom:10px;font: 21px/30px Georgia;color: #e5c887;text-transform: uppercase">Ресторан</td>
                                    <td style="width: 20px;"></td>
                                    <td  align="right" style="text-align:center;padding-top: 30px;padding-bottom:10px;font: 21px/30px Georgia;color: #e5c887;text-transform: uppercase">Мини&nbsp;-&nbsp;банкетный&nbsp;зал</td>


                                </tr>
                                    <td  align="left" ><img src="http://lyufari.com/img/mail_img_1.png" width="288" style="border:1px solid #9c9c9c;"/>    </td>
                                    <td style="width: 20px;"></td>
                                    <td  align="right" ><img src="http://lyufari.com/img/mail_img_2.png" style="border:1px solid #9c9c9c;"/></td>

                                </tr>

                                </tr>
                                <td  align="left" style="padding-top: 10px" >     Люфари - это новый уровень среди ресторанов Донецка. Уютный зал на 50 человек позволит провести незабываемое торжество, детский праздник или просто дружескую встречу
</td>
                                <td style="width: 20px;"></td>
                                <td  align="left" style="padding-top: 10px"  >Небольшой уютный зал создает  непринужденную и конфедициальную обстановку вашей беседе, а русский бильярд поможет весело провести время Вам и Вашим гостям.</td>

                                </tr>





                                <tr>
                                    <td   align="left" style="text-align:center;padding-top: 40px;padding-bottom:10px;font: 21px/30px Georgia;color: #e5c887;text-transform: uppercase">Баня на дровах</td>
                                    <td style="width: 20px;"></td>
                                    <td  align="right" style="text-align:center;padding-top: 40px;padding-bottom:10px;font: 21px/30px Georgia;color: #e5c887;text-transform: uppercase">турецкий Хамам</td>


                                </tr>
                                <td  align="left" ><img src="http://lyufari.com/img/mail_img_3.png" width="288" style="border:1px solid #9c9c9c;"/>    </td>
                                <td style="width: 20px;"></td>
                                <td  align="right" ><img src="http://lyufari.com/img/mail_img_4.png" style="border:1px solid #9c9c9c;"/></td>

                                </tr>

                                </tr>
                                <td  align="left"  style="padding-top: 10px">    На протяжении нескольких веков баня является одним из любимых мест отдыха человека. Это прекрасная терапевтическая процедура, которая хорошо восполняет недостаток движения, очищает организм и повышает иммунитет.
                                </td>
                                <td style="width: 20px;"></td>
                                <td  align="left" style="padding-top: 10px">Хамам – источник истинного наслаждения, место, где царит расслабляющая тело и душу атмосфера. Процедура несет в себе оздоровление, омоложение тела и снимает накопившуюся усталость.</td>

                                </tr>



    </tbody>
    </table>

                                        <table>
                                            <tbody>
                                            <tr>
                                            <tr   >
                                                <td style="padding-top: 28px;"><img src="http://lyufari.com/img/bottom_mail.png" width="600"/></td>
                                            </tr>
                                            </tr>
                                            </tbody>
                                        </table>



                                        <table style="font:12px/19px arial;color: #e5c887">
                                            <tbody>

                                            <tr>
                                                <td style="padding-bottom: 30px">
    © 2013 Усадьба «Люфари»<br/>
                                                    <a target="_blank" href="http://lyufari.com/contacts" style="font:12px/19px arial;color: #e5c887">Украина, Донецк, ул. Калинина, 118</a><br/><br/>

                                                    Время работы:<br/>
                                                    Гостиница: круглосуточно<br/>
                                                    Ресторан и доставка: с 10:00 до 23:00<br/>
                                                    Зона отдыха: круглосуточно<br/>

                                                </td>
                                                <td style="width: 251px;"></td>

                                                <td align="right" style="vertical-align: top;">
    +38 (067) 862 86 48<br/>
                                                    +38 (095) 172 72 72<br/><br/>
                                                    Email:<br/>
                                                    reception@lyufari.com<br/>
                                                    head@lyufari.com<br/>


                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </td>

                                </tr>

                            </tbody></table>';
//inbox@gmail.com
if(mail("denis.podtykan@mail.ru", $subject, $message, $header));
{
    echo "Отправлено";
}
?>