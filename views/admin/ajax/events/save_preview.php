<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance(); //Подключение базы
if($_POST['del'])
{
        $id=$_POST['id'];
        $sql="SELECT * FROM preview_photo WHERE id=".$id;
        $db->query($sql);
        if($db->getCount()>0)
        {
            $arr_pre=$db->getArray();
            $md5=$arr_pre[0]['md5_mictotime'];
            foreach($arr_pre as $arr_pre_index=>$arr_preval)
            {
                 if(file_exists($root.'/img/stock-images/size1/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg'))
    						{
    							unlink($root.'/img/stock-images/size1/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg');
    						}
    				 if(file_exists($root.'/img/stock-images/size2/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg'))
    						{
    							unlink($root.'/img/stock-images/size2/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg');
    						}
    				 if(file_exists($root.'/img/stock-images/size3/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg'))
    						{
    							unlink($root.'/img/stock-images/size3/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg');
    						}
                      if(file_exists($root.'/img/stock-images/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg'))
    						{
    							unlink($root.'/img/stock-images/'.$arr_preval['md5_mictotime'].'_'.$arr_preval['id'].'.jpg');
    						}
                $sql_del_pre="DELETE FROM preview_photo WHERE id=".$id;
                $db->query($sql_del_pre);
            }
        }
        
        //достаем все остальные
        $sql_select_all_preview_photo='SELECT * FROM preview_photo WHERE md5_mictotime="'.$md5.'"';
        $db->query($sql_select_all_preview_photo);
        if($db->getCount()>0)
        {
        	$arr=$db->getArray();
        	foreach($arr as $index=>$value)
        	{
        		print '<img class="edit_image img" src="/img/stock-images/size1/'.$value['md5_mictotime'].'_'.$value['id'].'.jpg">';
        		print '<div class="edit_image_controll_button">
        			   <span class="delphotoprev" data-id="'.$value['id'].'"> <img src="img/admin/d.png" alt="Удалить" title="Удалить"></span>';
        		//($value['preview_bool']==0) ? $checked='' :  $checked='checked="checked"';
//        		print '<input type="checkbox" id="preview_'.$value['id'].'" name="preview_'.$value['id'].'" title="Поставить в превью" '.$checked.'></div>';
                echo '</div>';
        	}
        }
        ///
}
else
{
    $imageClass = new imageClass(); // класс ля работы с изображением
if(empty($_FILES['image_preview']['tmp_name'][0]))
{

	   $err.='<p style=\'color:red;\'>Файлы отсутствует или возможно файлы слишком большие! Попробуйте загрузить фотографии меньшего объема</p>';
	   print $err; 
	   return false;
}
else {

		$all_err=''; //все ошибки на выходе
		foreach ($_FILES['image_preview']['tmp_name'] as $index => $value) {
		        $err=''; //ошибки для каждого из файлов
                 
                    if($_FILES['image_preview']['type'][$index]!='image/jpeg' AND $_FILES['image_preview']['type'][$index]!='image/png')
                    {
                        echo '<p style=\'color:red;\'>Картинка должна быть jpg или png</p>'; 
                        exit;
                    }
                    $size=getimagesize($_FILES['image_preview']['tmp_name'][$index]);
                    if($size[1]<720)
                    {
                        echo '<p style=\'color:red;\'>высота картинки должна быть не меньше 720</p>'; 
                        exit;
                    }
                     
 	     set_time_limit(0);  
        $handle = new upload($value);           
		$id_preview_photo=$db->getai('preview_photo');
        
        ////
		$handle->file_new_name_body   = $_POST['temp'].'_'.$id_preview_photo;	
		$handle->image_convert = "jpg";
        if(459*$handle->image_src_x/$handle->image_src_y>459*16/9)
        {
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
        
		$handle->process($root.'/img/stock-images/size1');
		//
	
        //little preview
        $handle->file_new_name_body   = $_POST['temp'].'_'.$id_preview_photo;	
		$handle->image_convert = "jpg";
        if(720*$handle->image_src_x/$handle->image_src_y>720*16/9)
        {
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
        
		$handle->process($root.'/img/stock-images/size2');
        //
        $handle->file_new_name_body   = $_POST['temp'].'_'.$id_preview_photo;	
		$handle->image_convert = "jpg";
        if(720*$handle->image_src_x/$handle->image_src_y>720*16/9)
        {
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
        
		$handle->process($root.'/img/stock-images/size3');
        
        $handle->file_new_name_body   = $_POST['temp'].'_'.$id_preview_photo;	
		$handle->image_convert = "jpg";
        if(122*$handle->image_src_x/$handle->image_src_y>122*16/9)
        {
            //сколько нужно обрезать
             $crop=(-1)*(122*16/9-122*$handle->image_src_x/$handle->image_src_y);
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
		$handle->image_y               = 122;
		$handle->jpeg_quality = 100;
		$handle->image_unsharp = false;
        
		$handle->process($root.'/img/stock-images');
		$handle->clean();	
		//удаляем все записи из banners где restaurant_id=0 and event_id=0 and data_create< сегодняшняя дата-1 день
		//сначала удаляем фотки
		$sql_select_zero_banners_photo='SELECT * FROM preview_photo WHERE event_id=0 AND data_create <= "'.date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).'"';
        $db->query($sql_select_zero_banners_photo);
		if($db->getCount()>0)
		{
			$arr=$db->getArray();
			foreach($arr as $in=>$value2)
			{
				 if(file_exists('../../../img/stock-images/size1/'.$value2['md5_mictotime'].'_'.$value2['id'].'.jpg'))
						{
							unlink('../../../img/stock-images/size1/'.$value2['md5_mictotime'].'_'.$value2['id'].'.jpg');
						}
				 if(file_exists('../../../img/stock-images/size2/'.$value2['md5_mictotime'].'_'.$value2['id'].'.jpg'))
						{
							unlink('../../../img/stock-images/size2/'.$value2['md5_mictotime'].'_'.$value2['id'].'.jpg');
						}
				 if(file_exists('../../../img/stock-images/size3/'.$value2['md5_mictotime'].'_'.$value2['id'].'.jpg'))
						{
							unlink('../../../img/stock-images/size3/'.$value2['md5_mictotime'].'_'.$value2['id'].'.jpg');
						}
			}
		}
		$sql_delete_zero_records='DELETE FROM preview_photo WHERE event_id=0 AND data_create <="'.date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).'"';
		$db->query($sql_delete_zero_records);
		//записываем в базу кажудую фотку
		$sql_insert_into_table_banners='INSERT INTO preview_photo (id,md5_mictotime,event_id,data_create) VALUES (NULL,"'.$_POST['temp'].'",0,"'.date('Y-m-d').'")';      
		$db->query($sql_insert_into_table_banners);
                }              
        }
        if(!empty($all_err))
        {
            echo $all_err;
        }
        else
        {
            //достаем все фотки к этому md5
            $sql_select_all_preview_photo='SELECT * FROM preview_photo WHERE md5_mictotime="'.$_POST['temp'].'"';
            $db->query($sql_select_all_preview_photo);
            if($db->getCount()>0)
            {
            	$arr=$db->getArray();
            	foreach($arr as $index=>$value)
            	{
            		print '<img class="edit_image img" src="/img/stock-images/size1/'.$value['md5_mictotime'].'_'.$value['id'].'.jpg">';
            		print '<div class="edit_image_controll_button">
            			   <span class="delphotoprev" data-id="'.$value['id'].'" class="delphotoprev"> <img src="img/admin/d.png" alt="Удалить" title="Удалить"></span>';
            	     $maybe_checked_check_this_fact='preview_'.$value['id'];
            		(isset($_POST[$maybe_checked_check_this_fact])) ? $checked='checked="checked"' : $checked='';
            		//print '<input type="checkbox" id="preview_'.$value['id'].'" name="preview_'.$value['id'].'" title="Поставить в превью" '.$checked.'></div>';
                    echo '</div>';
            	}
            }
        }
}



			 
?>  
