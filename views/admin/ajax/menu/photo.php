<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance();
$editorClass = new editorClass();
if($_POST['act']=='delp')
{
    $sql_s="SELECT * FROM menuphoto WHERE id=".$_POST['id'];
    $db->query($sql_s);
    if($db->getCount()>0)
    {
        $arr_p=$db->getArray();
        if(file_exists($root."/img/menu/size1/".$arr_p[0]['name']."_".$arr_p[0]['id'].".jpg"))
        {
            unlink($root."/img/menu/size1/".$arr_p[0]['name']."_".$arr_p[0]['id'].".jpg");
        }
        if(file_exists($root."/img/menu/size2/".$arr_p[0]['name']."_".$arr_p[0]['id'].".jpg"))
        {
            unlink($root."/img/menu/size2/".$arr_p[0]['name']."_".$arr_p[0]['id'].".jpg");
        }
        if(file_exists($root."/img/menu/size3/".$arr_p[0]['name']."_".$arr_p[0]['id'].".jpg"))
        {
            unlink($root."/img/menu/size3/".$arr_p[0]['name']."_".$arr_p[0]['id'].".jpg");
        }
        $sql="DELETE FROM menuphoto WHERE id=".$_POST['id'];
        $db->query($sql);
    }
   
    return false;
}
else
{
    if(empty($_FILES['image']['tmp_name']))
    {
    
    	   $err='Файлы отсутствует или возможно файлы слишком большие! Попробуйте загрузить фотографии меньшего объема';
    	  $arr=array();
          $arr=array_merge($arr,array('err'=>$err));
          echo json_encode($arr); 
    	   return false;
    }
    else
    {
            
            $handle = new Upload($_FILES['image']['tmp_name']);
            if ($handle -> uploaded) 
            {  
                if($_FILES['image']['type']!='image/jpeg' AND $_FILES['image']['type']!='image/png')
                {
                    echo json_encode(array('err'=>'Картинка должна быть jpg или png')); 
                    exit;
                }
                $size=getimagesize($_FILES['image']['tmp_name']);
                
                if($size[1]<720)
                {
                    echo json_encode(array('err'=>'высота картинки должна быть не меньше 720')); 
                    exit;
                }
                
                $namephoto=uniqid();
                $id=$db->getai('menuphoto');
                $namephoto_img=$namephoto.'_'.$id;
                if (!$handle -> processed) echo 'Картинка не была загружена <br />error : ' . $handle -> error;
                
                //проверим нужно ли обрезать по ширине
                /*if($handle->image_src_y!=720)
                {
                    echo "<div class='error'>Высота должна быть 720</div>";
                    die();
                }
                if($handle->file_src_size>1500000)
                {
                    echo "<div class='error'>Загрузите фотографию меньшего размера</div>";
                    die();
                }*/
               
                $handle -> file_new_name_body = $namephoto_img;
        		$handle->image_convert = "jpg";
               // echo 720*$handle->image_src_x/$handle->image_src_y." | ";
                //echo 720*16/9;
                 if(720*$handle->image_src_x/$handle->image_src_y>720*16/9)
                {
                    //обрезаем
                    //сколько нужно обрезать
                    $crop=(-1)*(720*16/9-720*$handle->image_src_x/$handle->image_src_y);
                     if ($crop%2 == 0){
                        $handle->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                    }
                    else
                    {
                        $handle->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                    }
                }
               
        		$handle->image_resize          = true;
        		$handle->image_ratio_x         = true;
        		$handle->image_y               = 720;
        		$handle->jpeg_quality = 100;
        		$handle->image_unsharp = false;
        		$handle->process($root.'/img/menu/size3');
                //fsize2
                
                $handle -> file_new_name_body = $namephoto_img;
        		$handle->image_convert = "jpg";
                if(576*$handle->image_src_x/$handle->image_src_y>576*16/9)
                {
                    //обрезаем
                    //сколько нужно обрезать
                    $crop=(-1)*(576*16/9-576*$handle->image_src_x/$handle->image_src_y);
                    if ($crop%2 == 0){
                        $handle->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                    }
                    else
                    {
                        $handle->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                    }
                    
                }
                
        		$handle->image_resize          = true;
        		$handle->image_ratio_x         = true;
        		$handle->image_y               = 576;
        		$handle->jpeg_quality = 100;
        		$handle->image_unsharp = false;
        		$handle->process($root.'/img/menu/size2');
                //fsize1
               
                $handle -> file_new_name_body = $namephoto_img;
        		$handle->image_convert = "jpg";
                 if(459*$handle->image_src_x/$handle->image_src_y>459*16/9)
                {
                    //обрезаем
                    //сколько нужно обрезать
                    $crop=(-1)*(459*16/9-459*$handle->image_src_x/$handle->image_src_y);
                     if ($crop%2 == 0){
                        $handle->image_crop            = '0 '.($crop/2).' 0 '.($crop/2);
                    }
                    else
                    {
                        $handle->image_crop            = '0 '.(int)($crop/2).' 0 '.((int)($crop/2)+1);
                    }
                }
                
        		$handle->image_resize          = true;
        		$handle->image_ratio_x         = true;
        		$handle->image_y               = 459;
        		$handle->jpeg_quality = 100;
        		$handle->image_unsharp = false;
        		$handle->process($root.'/img/menu/size1');
                
                
            if($_POST['id'])
            {
                $db -> query("INSERT INTO menuphoto SET dtcreate='".date('Y-m-d H:i:s')."', name = '".$namephoto."', temp = 0, parent = ".$_POST['id']);
            }
            else
            {
                $db -> query("INSERT INTO menuphoto SET dtcreate='".date('Y-m-d H:i:s')."', name = '".$namephoto."', temp = 0, parent = ".$_POST['id_code']);
            }
            $img=$namephoto_img;
            $arr=array();
            $arr=array_merge($arr,array('img'=>$img),array('id'=>$id));
            echo json_encode($arr); 
            }
           
    }
}

?>
 
