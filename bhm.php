<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];

require_once($root."/lib/class.invis.db.php");
require_once($root."/lib/class.sms.php");
$db=db :: getInstance();

$err="";
if(empty($_POST['select_1']) OR empty($_POST['select_1_1']))
{
    $err="Выберите дату заезда";
}
else
if(empty($_POST['count']))
{
    $err="Выберите количество человек";
}
else
if(empty($_POST['hour']))
{
    $err="Выберите количество часов";
}
else
if(empty($_POST['name']))
{
    $err="Как к вам обращаться?";
}
else
if(empty($_POST['phone']))
{
    $err="Введите номер телефона";
}
$dataprov=explode('.',$_POST['select_1_1']);
$dataend=explode('.',$_POST['select_2_2']);
if(((strtotime(date('Y-m-d')) > strtotime($dataprov[1].'-'.($dataprov[0]+1).'-'.$_POST['select_1']))))
{
    $err="Дата заезда не может быть в прошлом времени";
}
if(empty($err))
{
        $dataprov=explode('.',$_POST['select_1_1']);
        $dataprovmail=$dataprov[1].'-'.($dataprov[0]+1).'-'.$_POST['select_1'];
        $name=trim($_POST['name']); //имя
        $col=$_POST['count'];//количество человек
        $hour=$_POST['hour'];//количество часов
        if(isset($_POST['hamam']))
        {
            $typenomertext="хамам";
        }
        if(isset($_POST['bath']))
        {
            $typenomertext="баня на дровах";
        }
        if(isset($_POST['banquet']))
        {
            $typenomertext="мини-банкетный зал";
        }
        if(isset($_POST['hamam']) OR isset($_POST['bath']))
        {
            if($col>1)
            {
                $itogo=(($col-1)*50*$hour)+200*$hour;
            }
            else
            {
                $itogo=200*$hour;
            }
        }
        else
        if(isset($_POST['banquet']))
        {
            $itogo=150*$hour;
        }


        $phone=trim($_POST['phone']); //телефон
        $comm=trim($_POST['comm']); //комментарий
        if(isset($_POST['h']) AND !empty($_POST['h']) AND isset($_POST['min']) AND !empty($_POST['min']))//время посещения
        {
            $time=$_POST['h'].":".$_POST['min'].":00";
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
           $phone_who=$_POST['phone'];
            $sms->sendsms('lyufari',$phone_who,"Спасибо. Бронь # ".$uid." на «".$typenomertext."»\nМы свяжемся с вами в ближайшее время.");

//            $sms->sendsms('lyufari','+380954570088',"Бронь на «".$typenomertext."» на сумму ".$itogo." грн");
            $sms->sendsms('lyufari','+380505870147',"Бронь на «".$typenomertext."» на сумму ".$itogo." грн");
            $sms->sendsms('lyufari','+380951727272',"Бронь на «".$typenomertext."» на сумму ".$itogo." грн");

            $smsid=$sms->smsresultbynumb(1);//id
        }
        $sql="INSERT INTO orderd (uid,smsid,data_create,date,name,phone,nameevent,peoplecount,comment,address,zakaz,type) VALUES('%s','%s','".date('Y-m-d H:i:s')."','','%s','".$_POST['phone']."','','','','','','notrest')";
        $query = sprintf($sql,$uid, $smsid,$name);

        $db->query($query);
        
        //отправляем на почту

        $dan_f.="Заказ на: ".$typenomertext."<br />";
        $dan_f.="Дата  - ".$dataprovmail."<br />";
        if(!empty($time))
        {
            $dan_f.="Время - ".$time."<br />";
        }


        $dan_f.="Количество часов - ".$hour."<br />";
        $dan_f.="Количество человек - ".$col."<br />";
        $_POST['name']=preg_replace("/'/",'"',$_POST['name']);
        if(!empty($_POST['name']))
        {
            $dan_f.="ФИО (как к вам обращаться) - ".$_POST['name']."<br />";
        }
        $dan_f.="Контактный телефон - ".$_POST['phone']."<br />";
        
        $_POST['comm']=preg_replace("/'/",'"',$_POST['comm']);
        if(!empty($_POST['comm']))
        {
            $dan_f.="Комментарии - ".$_POST['comm']."<br />";
        }
        $dan_f.="Итого - ".$itogo." грн<br />";
        $message = $dan_f."<br />"; 
        
        $header="Content-type: text/html; charset=\"utf-8\"";
        $subject = '=?utf-8?B?'.base64_encode("Предварительное бронирование с сайта «Люфари»").'?=';
        $headers = "From: ".$subject." mail ".$to." \n";
        mail('Secret007@ukr.net', $subject, $message, $header);
}
else
{
    echo "<div class='error'>".$err."</div>";

}

?>