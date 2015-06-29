<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root."/lib/class.invis.db.php");
require_once($root."/lib/class.sms.php");
 $db=db :: getInstance();
$err="";
$_POST['name']=trim($_POST['name']);
if(!isset($_POST['rest']) AND !isset($_POST['deliv']))
{
    $err="Укажите место проведения";
}
else
if(empty($_POST['phonecode']))
{
    $err="Введите код телефона";
}
else
if(empty($_POST['phone']))
{
    $err="Введите номер телефона";
}
else
if(empty($_POST['name']))
{
    $err="Введите имя/организация";
}
if(empty($err))
{
        $name=trim($_POST['name']);
        $event=trim($_POST['event']);
        $col=$_POST['col'];
        $address=trim($_POST['address']);
        $comm=trim($_POST['comm']);
        $dataprov=$_POST['data'];
        $smsid='';
        $total=0;
//        if(isset($_POST['order'])) $_SESSION['z']=$_POST['order'];
        if(isset($_SESSION['z']))
        {
            $order='<table style="margin:10px auto 10px auto;" width="662" cellpadding="0" cellspacing="0" class="mail_to">
    <tbody><tr>
        <td>
        <table border="0" cellpadding="0" cellspacing="0" width="600" style="0px solid transparent;">
            <tbody><tr>    
                    <td align="left" style="padding-bottom:15px;">
                       <a href="http://'.$_SERVER["HTTP_HOST"].'"><img src="http://'.$_SERVER["HTTP_HOST"].'/img/p-l.jpg"></a>
                  </td>  
                   <td valign="top" align="right" nowrap="" style="line-height: 12px;font-family:Arial;font-size:12px;color:#b4afa1;">
                        <table>
                            <tr>
                                <td style="line-height: 12px;font-family:Arial;font-size:12px;color:#b4afa1;text-align: right;">Гостинично - ресторанный комплекс «Люфари»</td>
                            </tr>
                            <tr>
                                <td style="line-height: 14px;font-family:Times New Roman;font-size:14px;color:#736655;text-align: right;">Донецк, ул. Калинина, 118</td>
                            </tr>
                            <tr>
                                <td style="line-height: 14px;font-family:Times New Roman;font-size:14px;color:#736655;text-align: right;">(095)&nbsp;172&nbsp;72&nbsp;72</td>
                            </tr>
                            <tr>
                                <td style="line-height: 12px;font-family:Georgia;font-size:12px;color:#736655;text-align: right;"><a style="color:#736655;" href="html://lyufari.com">lyufari.com</a></td>
                            </tr>
                        </table>
                        
                        
                  </td>
                 
            </tr>
            <tr>
                <td colspan="2" align="middle" style="padding:15px 0 30px 0;font-size:24px;line-height:24px;font-family:Georgia;color:#5e4731;">
                       Оформление заказа
                  </td>
            </tr>
            <tr>
                <td colspan="2" style="border-collapse: separate;">';

    $order.='<table border="0" cellpadding="0" cellspacing="0" style="width:600px;"><tbody><tr align="left" style="font-family:tahoma;font-size:12px;color:#9b9b9b;"><th style="border-bottom: 1px solid #EEECEC;">&nbsp;&nbsp;</th><th style="border-bottom: 1px solid #EEECEC;width:275px;">Наименование</th><th style="border-bottom: 1px solid #EEECEC;width:92px;">Выход</th><th style="border-bottom: 1px solid #EEECEC;width:72px;">Цена</th><th style="border-bottom: 1px solid #EEECEC;width:72px;">Кол-во</th><th style="border-bottom: 1px solid #EEECEC;width:65px;">Стоимость</th></tr><tr><td></td></tr>';
    

    foreach($_SESSION['z'] as $index=>$val)
    {
        $sql="SELECT * FROM menu_m WHERE id='".$val['id']."'";
        $db->query($sql);
        if($db->getCount()>0)
        {
//            $arritem=$db->getArray();
//            $total+=$val['col']*$arritem[0]['PRICE'];
//            $order.='<tr valign="top" style="border-collapse: collapse;border:0px solid transparent;line-height: 22px;font-family:tahoma;font-size:12px;color:#303030;"><td style="padding: 5px 0;width: 25px;text-align:center;">'.($index+1).'</td><td style="padding: 5px 0;">'.$arritem[0]['NAME'].'</td><td style="padding: 5px 0;">'.(int)$arritem[0]['RATE'].'</td><td style="padding: 5px 0;">'.$arritem[0]['PRICE'].'&nbsp;грн.</td><td style="padding: 5px 0;">'.$val['col'].'</td><td style="padding: 5px 0;">'.($arritem[0]['PRICE']*$val['col']).' грн</td></tr>';
            $arritem=$db->getArray();
            $total+=$val['col']*$arritem[0]['price'];
            $order.='<tr valign="top" style="border-collapse: collapse;border:0px solid transparent;line-height: 22px;font-family:tahoma;font-size:12px;color:#303030;"><td style="padding: 5px 0;width: 25px;text-align:center;">'.($index+1).'</td><td style="padding: 5px 0;">'.$arritem[0]['name'].'</td><td style="padding: 5px 0;">'.(int)$arritem[0]['weight'].'</td><td style="padding: 5px 0;">'.$arritem[0]['price'].'&nbsp;грн.</td><td style="padding: 5px 0;">'.$val['col'].'</td><td style="padding: 5px 0;">'.($arritem[0]['price']*$val['col']).' грн</td></tr>';

        }
    }
    $order.='</tbody></table></td>';


                $order.='</tr> <tr>
                <td colspan="2">
                <table style="margin-top: 63px;width:100%;">
                    <tr>
                         <td align="left" style="color: #7b797c;font: 14px/14px Arial;">
                                Цены в грн.&nbsp;на&nbsp;19.11.2012                
                         </td>
                         <td align="right" style="color: #3d3828;font: 18px/18px Arial;text-align:right;">
                                Общая стоимость заказа: '.$total.'&nbsp;грн
                         </td>
                    </tr>
                </table>
               </td>
                
            </tr>
            <tr>
                <td colspan="2"><img style="margin-top:23px;" src="http://'.$_SERVER["HTTP_HOST"].'/img/p-f.jpg"/></td>
            </tr>
            <tr>
                <td colspan="2" height="44"></td>
            </tr>
        </tbody>
        </table>';
        }
        $sql="SELECT count(id) FROM orderd WHERE YEAR(data_create)='".date('Y')."' AND MONTH(data_create)='".date('m')."' AND DAY(data_create)='".date('d')."'";
        $db->query($sql);
        $val=$db->getValue();
       
        if($val+1<10)
        {
         $dopol='00';
        }
        else if($val+1>=10 AND $val+1<100)
        {
         $dopol='0';
        }
        else
        {
           $dopol='';
        }
        $uid=date('ymd').$dopol.$val+1;
        $sms=new sms();
        $sms->setLogin('lyufari');
        $sms->setPass('zayaccool');
        if($sms->auth())
        {
           $phone_who=$_POST['phonecode'].$_POST['phone'];
           if(date('G')>=10 AND date('G')<=23)
            {
                $sms->sendsms('lyufari',$phone_who,"Спасибо. Заказ #".$uid."\nМы свяжемся с вами в ближайшее время.");
            }
            else
            {
                if(date('G')>=5 AND date('G')<=10)
                {
                    $sms->sendsms('lyufari',$phone_who,"Спасибо. Заказ #".$uid."\nМы свяжемся с вами после 10:00.");
                }
                else
                {
                    $sms->sendsms('lyufari',$phone_who,"Спасибо. Заказ #".$uid."\nМы свяжемся с вами завтра после 10:00.");
                }
                
            }
//           $sms->sendsms('lyufari','+380954570088',"Заказ с сайта #".$uid." на сумму ".$total);
        $text_sms_manager='Бронь ';
        if($_POST['rest']) $text_sms_manager.='"ресторан столик"';
        if($_POST['deliv']) $text_sms_manager.='"ресторан доставка"';
        $text_sms_manager.='на сумму '.$total.' грн';
           $sms->sendsms('lyufari','+380505870147',$text_sms_manager);
           $sms->sendsms('lyufari','+380951727272',$text_sms_manager);
           $smsid=$sms->smsresultbynumb(1);//id
        }
        $sql="INSERT INTO orderd (uid,smsid,data_create,date,name,phone,nameevent,peoplecount,comment,address,zakaz) VALUES('%s','%s','".date('Y-m-d H:i:s')."','%s','%s','".$_POST['phonecode'].$_POST['phone']."','%s',%d,'%s','%s','%s')";
        //$sql = "SELECT * FROM `user` WHERE `login`='%s' AND `password`='%d'";
        $query = sprintf($sql, $uid, $smsid,$dataprov,$name,$event,$col,$comm,$address,$order);
        $db->query($query);
        
        //отправляем на почту
        
        $dan_f="Место проведения - ";
        if($_POST['rest']) $dan_f.="ресторан";
        if($_POST['deliv']) $dan_f.="доставка";
        $dan_f.="<br />";
        if(!empty($_POST['data']))
        {
          $dan_f.="Дата проведения - ".$_POST['data']."<br />";
        }

        $_POST['name']=preg_replace("/'/",'"',$_POST['name']);
        if(!empty($_POST['name']))
        {
            $dan_f.="Имя/организация - ".$_POST['name']."<br />";
        }
        
        $_POST['event']=preg_replace("/'/",'"',$_POST['event']);
        if(!empty($_POST['event']))
        {
            $dan_f.="Событие - ".$_POST['event']."<br />";
        }
        $dan_f.="Контактный телефон - ".$_POST['phonecode'].$_POST['phone']."<br />";
        
        if(!empty($_POST['col']) AND is_numeric($_POST['col']) AND (int)$_POST['col']>0)
        {
            $dan_f.="Количество человек - ".$_POST['col']."<br />";
        }
        $_POST['address']=preg_replace("/'/",'"',$_POST['address']);
        if(!empty($_POST['address']))
        {
            $dan_f.="Адресс доставки - ".$_POST['address']."<br />";
        }
        $_POST['comm']=preg_replace("/'/",'"',$_POST['comm']);
        if(!empty($_POST['comm']))
        {
            $dan_f.="Комментарии - ".$_POST['comm']."<br />";
        }
        if(!empty($order))
        {
            $message = $order."<br />".$dan_f."<br />"; 
        }
        else
        {
            $message = $dan_f."<br />"; 
        }
        $header="Content-type: text/html; charset=\"utf-8\"";
        $subject = '=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?=';
        $headers = "From: ".$subject." mail ".$to." \n";
        mail('abz@inbox.ru', $subject, $message, $header);
        mail('emelsv@list.ru', $subject, $message, $header);
////        mail('reception@lyufari.com', $subject, $message, $header);
        mail('lyufari@mail.ru', $subject, $message, $header);
}
else
{
    echo "<div class='error'>".$err."</div>";
}

?>