<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];	
require_once $root."/lib/class.invis.db.php";
require_once $root."/lib/uservar.php";
$db = db :: getInstance();	
switch($_POST['action'])
{
    case 'user':
        $name=$_POST['name_'];
        $arrayname[$_SESSION['active']]=$name;
        $_SESSION['arrayname']=$arrayname;
        echo json_encode($arrayname);
    break;
    case 'trpricepm':
        echo json_encode($arrayname);
    break;
    case 'phonediscount':
        $arr=array();
        if(empty($_SESSION['client']['id']))
        {
            $val = htmlspecialchars(strip_tags($_POST['val']));
            $sql_get_phone="SELECT * FROM clients WHERE phone='".$val."'";
            $db->query($sql_get_phone);
            if($db->getCount()>0)
            {
                $discount=$db->getArray();
                $_SESSION['client']['id']=$discount[0]['id'];
                $_SESSION['client']['n']=$discount[0]['name'];
                $_SESSION['client']['nc']=$discount[0]['namberCard'];
                $_SESSION['client']['p']=$discount[0]['phone'];
                $_SESSION['client']['d']=$discount[0]['discount'];
                $_SESSION['client']['ad']=$discount[0]['address'];
                $_SESSION['client']['porc']=$discount[0]['cardorphone'];
                $discount=$discount[0]['discount'];
            }
            else
            {
                $discount=0;
            }
            
        }
        else $discount=0;
        
        $arr=array_merge($arr,array('discount'=>$discount),$_SESSION['client']);
        echo json_encode($arr);
    break;
    case 'oform':
    $phone = htmlspecialchars(strip_tags($_POST['p']));
    $fio = htmlspecialchars(strip_tags($_POST['fio']));
    $address= htmlspecialchars(strip_tags($_POST['ad']));
    $discount=(!empty($_SESSION['client']['d']))?$_SESSION['client']['d']:0;
    if(!empty($phone) AND !empty($fio) AND !empty($address))
    {
        $arr=array();
        foreach($_POST['a'] as $index=>$val)
            {
                array_push($arr,$val);
                if(!empty($val))
                {
                    $_SESSION['arrayorder'][$index]=array();
                    foreach($val as $val_index=>$val_val)
                    {
                        array_push($_SESSION['arrayorder'][$index],array('id'=>$val_val['id'],'k'=>$val_val['k']));
                    }
                    //$_SESSION['arrayorder'][$index]=$val;
                    //array_push($_SESSION['arrayorder'][$index+1],$val);
                }
            }
         //запись в базу
         $order=serialize($_SESSION['arrayorder']);
         $orderoname=serialize($_SESSION['arrayname']);
         //проверим есть ли такой клиент по номеру телефона
         $sql="SELECT * FROM clients WHERE phone='".$phone."'";
         $db->query($sql);
         if($db->getCount()>0)
         {
            $clarray=$db->getArray();
            $idcl=$clarray[0]['id'];
            $sql="UPDATE clients SET name='{$fio}',address='".$address."'";
            $db->query($sql);
            $sql="INSERT INTO orders  (discount,ordero,idClient,idAddress,dtOrder,orderoname) VALUES ({$discount},'".$order."',{$idcl},'".$address."','".date('Y-m-d H:i:s')."','".$orderoname."')";
            $db->query($sql);
           
         }
         else
         {
            $sql="INSERT INTO clients (name,address,phone) VALUES('".$fio."','".$address."','".$phone."')";
            $db->query($sql);
            $idcl=$db->last();
            $sql="INSERT INTO orders (discount,ordero,idClient,idAddress,dtOrder,orderoname) VALUES ({$discount},'".$order."',{$idcl},'".$address."','".date('Y-m-d H:i:s')."','".$orderoname."')";
            $db->query($sql);
         }
        $arrayname=array();
        $arrayorder=array();
        for($i=1;$i<=20;$i++)
        {
            array_push($arrayname,"Имя(".$i.")");
            array_push($arrayorder,array());
        }
        $_SESSION['active']=0;
        $active=0;
        $_SESSION['arrayname']=$arrayname;
        $_SESSION['arrayorder']=$arrayorder;
         
         $arr = array_merge($arr, array('order'=>$_SESSION['arrayorder']),array('names'=>$_SESSION['arrayname']),array('ord'=>$order)); 
         echo json_encode($arr);
    }
    else
    {
        if(empty($phone))
        {
            echo json_encode(array('err'=>'Введите телефон'));
        }
        else
        if(empty($fio))
        {
            echo json_encode(array('err'=>'Введите ФИО'));
        }
        else
        if(empty($address))
        {
            echo json_encode(array('err'=>'Введите адрес доставки'));
        }
    }
    break;
    case 'depprouser':
        if(count($_SESSION['arrayorder'][$_POST['user_']])>0)
        {
            foreach($_SESSION['arrayorder'][$_POST['user_']] as $index=>$val)
            {
                if($val['id']==$_POST['id_'])
                {
                    unset($_SESSION['arrayorder'][$_POST['user_']][$index]);
                }
            }
        }
        echo json_encode($_SESSION['arrayorder']);
    break;
    case 'delall':
        if(count($_SESSION['arrayorder'][$_POST['id']])>0)
        {
            $_SESSION['arrayorder'][$_POST['id']]=array();
        }
        echo json_encode($_SESSION['arrayorder']);
    break;
    case 'userofor':
        $name=$_POST['name_'];
        $arrayname[$_POST['n_']]=$name;
        $_SESSION['arrayname']=$arrayname;
        echo json_encode($arrayname[$_POST['n_']]);
    break;
    case 'usernext':
        $arr=array();
        $_SESSION['active']++;
        $active=$_SESSION['active'];
        $summ=0;
        $total=0;
        $koltovar=0;
        $ids=array();
        for($i=0;$i<20;$i++)
        {
            foreach($_SESSION['arrayorder'][$i] as $index=>$val)
            {
                //достанем цену по id
                $sql="SELECT price FROM products WHERE id=".$val['id'];
                $db->query($sql);
                if($db->getCount()>0)
                {
                    $total+=$val['k']*$db->getValue();
                }
            }
        }
        foreach($_SESSION['arrayorder'][$_SESSION['active']] as $index=>$val)
        {
            //достанем цену по id
            $sql="SELECT price FROM products WHERE id=".$val['id'];
            $db->query($sql);
            if($db->getCount()>0)
            {
                $summ+=$val['k']*$db->getValue();
                array_push($ids,array('id'=>$val['id'],'k'=>$val['k'],'price'=>$val['price']));
            }
            $koltovar+=$val['k'];
        }
        if(empty($_SESSION['client']['d']))
        {
            $discount=0;
        }
        else
        {
            $discount=$_SESSION['client']['d'];
            if($total!=0)
            {
                $total=number_format($total*1-$total*1*$discount/100,2, '.', '');
            }
            if($summ!=0)
            {
                $summ=number_format($summ*1-$summ*1*$discount/100,2, '.', '');
            }
            
        }
        $arr = array_merge($arr,array('discount'=>$discount), array('active'=>$active),array('name'=>$arrayname[$_SESSION['active']]),array('kol'=>$koltovar),array('price'=>$summ),array('total'=>$total),array('ids'=>$ids)); 
        echo json_encode($arr);
    break;
    case 'userprev':
        $arr=array();
        $_SESSION['active']--;
        $active=$_SESSION['active'];
        $summ=0;
        $total=0;
        $koltovar=0;
        $ids=array();
        for($i=0;$i<20;$i++)
        {
            foreach($_SESSION['arrayorder'][$i] as $index=>$val)
            {
                //достанем цену по id
                $sql="SELECT price FROM products WHERE id=".$val['id'];
                $db->query($sql);
                if($db->getCount()>0)
                {
                    $total+=$val['k']*$db->getValue();
                }
            }
        }
        foreach($_SESSION['arrayorder'][$_SESSION['active']] as $index=>$val)
        {
            //достанем цену по id
            $sql="SELECT price FROM products WHERE id=".$val['id'];
            $db->query($sql);
            if($db->getCount()>0)
            {
                $summ+=$val['k']*$db->getValue();
                array_push($ids,array('id'=>$val['id'],'k'=>$val['k'],'price'=>$val['price']));
            }
            $koltovar+=$val['k'];   
        }
        if(empty($_SESSION['client']['d']))
        {
            $discount=0;
        }
        else
        {
            $discount=$_SESSION['client']['d'];
            if($total!=0)
            {
                $total=number_format($total*1-$total*1*$discount/100,2, '.', '');
            }
            if($summ!=0)
            {
                $summ=number_format($summ*1-$summ*1*$discount/100,2, '.', '');
            }
        }
        $arr = array_merge($arr,array('discount'=>$discount),array('active'=>$active),array('name'=>$arrayname[$_SESSION['active']]),array('kol'=>$koltovar),array('price'=>$summ),array('total'=>$total),array('ids'=>$ids)); 
        echo json_encode($arr);
    break;
    case 'buy':
        
        $arr=array();
        $k=$_POST['k_'];
        $id=$_POST['id_'];
        array_push($arrayorder[$_SESSION['active']],array('k'=>$k,'id'=>$id));
        $_SESSION['arrayorder']=$arrayorder;
        $summ=0;
        $total=0;
        $koltovar=0;
        $ids=array();
        for($i=0;$i<20;$i++)
        {
            foreach($_SESSION['arrayorder'][$i] as $index=>$val)
            {
                //достанем цену по id
                $sql="SELECT price FROM products WHERE id=".$val['id'];
                $db->query($sql);
                if($db->getCount()>0)
                {
                    $total+=$val['k']*$db->getValue();
                }
            }
        }
        foreach($_SESSION['arrayorder'][$_SESSION['active']] as $index=>$val)
        {
            //достанем цену по id
            $sql="SELECT price FROM products WHERE id=".$val['id'];
            $db->query($sql);
            if($db->getCount()>0)
            {
                $summ+=$val['k']*$db->getValue();
                array_push($ids,array('id'=>$val['id'],'k'=>$k));
            }
            $koltovar+=$val['k'];   
        }
        $arr = array_merge($arr, array('name'=>$arrayname[$_SESSION['active']]),array('kol'=>$koltovar),array('price'=>$summ),array('total'=>$total),array('ids'=>$ids)); 
        
        echo json_encode($arr);
    break;
}
?>
