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
if(empty($_POST['select_2']) OR empty($_POST['select_2_2']))
{
    $err="Выберите дату выезда";
}
else
if(empty($_POST['count']))
{
    $err="Выберите количество человек";
}
else
if(empty($_POST['name']))
{
    $err="Как к вам обращаться?";
}
else
if(empty($_POST['phonecode']))
{
    $err="Введите код для телефона";
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
else
if(((strtotime($dataend[1].'-'.$dataend[0].'-'.$_POST['select_2']) - strtotime($dataprov[1].'-'.$dataprov[0].'-'.$_POST['select_1']))/3600/24)<=0)
{
    $err="Введите корректные данные даты заезда и даты выезда";
}
if(empty($err))
{
        $dataprov=explode('.',$_POST['select_1_1']);
        $dataprovmail=$dataprov[1].'-'.($dataprov[0]+1).'-'.$_POST['select_1'];
        $dataprov=$dataprov[1].'-'.($dataprov[0]+1).'-'.$_POST['select_1'].' '.'00:00:00';

        $dataend=explode('.',$_POST['select_2_2']);
        $dataendmail=$dataend[1].'-'.($dataend[0]+1).'-'.$_POST['select_2'];
        $dataend=$dataend[1].'-'.($dataend[0]+1).'-'.$_POST['select_2'].' '.'00:00:00';


        $name=trim($_POST['name']);
        $days=(strtotime($dataend[1].'-'.($dataend[0]+1).'-'.$_POST['select_2']) - strtotime($dataprov[1].'-'.($dataprov[0]+1).'-'.$_POST['select_1']))/3600/24;
        $col=$_POST['count'];
        $price=800;
        if($_POST['roomtype']=="delux")
        {
            $typenomer='standart';
            $price=800;
            if($col<2) $nomer=1;
            else $nomer=2;
            $typenomertext="Тип номера - ДЕ ЛЮКС<br />";
        }
        else
        {
            $price=1600;
            $typenomer='king';
            if($col<2) $nomer=1;
            else $nomer=3;
            $typenomertext="Тип номера - АПАРТАМЕНТЫ<br />";
        }

//      $itogo=abs(ceil($col/$nomer)*$price*$days);
        $itogo=abs($price*ceil($days));
        $phone=trim($_POST['phonecode'].$_POST['phone']);
        $transfer=($_POST['transfer'])?1:0;
        if($transfer==1)
        {
            $itogo+=100;
        }
        $comm=trim($_POST['comm']);
        
        $smsid='';
        $total=0;
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
        $text_sms_manger='Бронь ';
        $text_sms_manger.=$_POST['roomtype']=="delux"?'"номер де люкс" ':'"номер апартаменты" ';
        $text_sms_manger.='на сумму '.$itogo.' грн';
        if($sms->auth())
        {
          $phone_who=$_POST['phonecode'].$_POST['phone'];
          $sms->sendsms('lyufari',$phone_who,"Спасибо. Бронь #".$uid."\nМы свяжемся с вами в ближайшее время.");
          $sms->sendsms('lyufari','+380505870147',$text_sms_manger);
          $sms->sendsms('lyufari','+380951727272',$text_sms_manger);
//          $sms->sendsms('lyufari','+380951727272',"Бронь с сайта #".$uid." на сумму ".$itogo);
          $smsid=$sms->smsresultbynumb(1);//id
        }
        $sql="INSERT INTO orderd (uid,smsid,data_create,date,name,phone,nameevent,peoplecount,comment,address,zakaz,type) VALUES('%s','%s','".date('Y-m-d H:i:s')."','','%s','".$_POST['phonecode'].$_POST['phone']."','','','','','','notrest')";
        $query = sprintf($sql,$uid, $smsid,$name);
        $db->query($query);
        
        //отправляем на почту


        $dan_f.="Дата вьезда - ".$dataprovmail."<br />";
        $dan_f.="Дата выезда - ".$dataendmail."<br />";

        
        $dan_f.="Количество дней - ".ceil($days)."<br />";

        if(!empty($_POST['count']))
        {
            $dan_f.="Количество человек - ".$_POST['count']."<br />";
        }
        $dan_f.=$typenomertext;
        if($transfer==1)
        {
             $dan_f.="Трансфер - да<br />";
        }
        else
        {
            $dan_f.="Трансфер - нет<br />";
        }
        $_POST['name']=preg_replace("/'/",'"',$_POST['name']);
        if(!empty($_POST['name']))
        {
            $dan_f.="ФИО (как к вам обращаться) - ".$_POST['name']."<br />";
        }
        $dan_f.="Контактный телефон - ".$_POST['phonecode'].$_POST['phone']."<br />";
        
        $_POST['comm']=preg_replace("/'/",'"',$_POST['comm']);
        if(!empty($_POST['comm']))
        {
            $dan_f.="Комментарии - ".$_POST['comm']."<br />";
        }
        $dan_f.="Итого - ".$itogo."<br />";
        $message = $dan_f."<br />"; 
        
        $header="Content-type: text/html; charset=\"utf-8\"";
        $subject = '=?utf-8?B?'.base64_encode("Предварительное бронирование с сайта «Люфари»").'?=';
        $headers = "From: ".$subject." mail ".$to." \n";

        mail('abz@inbox.ru', $subject, $message, $header);
//        mail('emelsv@list.ru', $subject, $message, $header);
        mail('reception@lyufari.com', $subject, $message, $header);
        mail('lyufari@mail.ru', $subject, $message, $header);
//    }
//    else
//    {
//        if(strlen(trim($_POST['phone']))<11)
//        {
//            echo "<div class='error'>Короткий номер телефона (минимум 10 цифр)</div>";
//            exit;
//        }
//        if(trim($_POST['phone'])=='')
//        {
//            echo "<div class='error'>Укажите ваш контактный номер телефона</div>";
//            exit;
//        }
//
//    }
}
else
{
    echo "<div class='error'>".$err."</div>";

}

?>