<?php
 if($_POST['print'])
    {
        $message = $_POST['data'];
//        $header.="Content-type: text/html; charset=\"utf-8\"";
        
        //$message = '=?utf-8?B?'.base64_encode($message).'?=';
//        $subject = '=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?=';
//        $headers = "From: ".$subject." mail ".$to." \n";
//        mail($_POST['email'], $subject, $message, $header);

        $header="Content-type: text/html; charset=\"utf-8\"";
        $subject = '=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?=';
        $header.= 'From:=?utf-8?B?'.base64_encode("Заказ с сайта «Люфари»").'?='. '<reception@lyufari.com>' . "\r\n" ;
        $header.= 'From: reception@lyufari.com' . "\r\n" .
            'Reply-To: reception@lyufari.com' . "\r\n";

        mail($_POST['email'], $subject, $message, $header);


    }
?>
