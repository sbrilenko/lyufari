<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance(); //Подключение базы
if($_FILES['image']['tmp_name']!=null) 
{
	    $err=''; //ошибки для каждого из файлов
        $handle = new Upload($_FILES['image']['tmp_name']);
	    if ($handle -> uploaded) 
            {  
                if($_FILES['image']['type']!='image/jpeg' AND $_FILES['image']['type']!='image/png')
                {
                    $err.='<p style=\'color:red;\'>Картинка должна быть jpg или png</p>'; 
                }
                $size=getimagesize($_FILES['image']['tmp_name']);
                if($size[1]<360)
                {
                    $err.='<p style=\'color:red;\'>Высота картинки должна быть не меньше 360</p>';
                }
                else
                if($size[0]<720)
                {
                    $err.='<p style=\'color:red;\'>Ширина должна быть 720</p>';
                }
                if (!$handle -> processed) echo '<p style=\'color:red;\'>Картинка не была загружена <br />error : ' . $handle -> error.'</p>';
        if(empty($err))
        {
		set_time_limit(0);
		if(file_exists($root.'/img/stock/'.$_POST['temp'].'.jpg'))
			{
			       unlink($root.'/img/stock/'.$_POST['temp'].'.jpg'); 
			}
		$handle = new upload($_FILES['image']);
		$handle->file_new_name_body   = $_POST['temp'];	
		$handle->image_convert = "jpg";
//        $handle->image_resize          = true;
//        $handle->image_ratio_x         = true;
//        $handle->image_y               = 360;
//        $handle->image_x               = true;
//		$handle->jpeg_quality = 100;
//		$handle->image_unsharp = false;
		$handle->process($root.'/img/stock');
        //
		$handle->clean();	
		//удаляем все записи из banners где event_id=0 and data_create< сегодняшняя дата-1 день
		//сначала удаляем фотки
		$sql_select_zero_banners_photo='SELECT * FROM banners WHERE event_id=0 AND data_create <= "'.date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).'"';
		$db->query($sql_select_zero_banners_photo);
		if($db->getCount()>0)
		{
			$arr=$db->getArray();
			foreach($arr as $in=>$value)
			{
				 if(file_exists($root.'/img/stock/'.$value['md5_mictotime'].'.jpg'))
						{
							unlink($root.'/img/stock/'.$value['md5_mictotime'].'.jpg');
						}
			}
		}
		$sql_delete_zero_records='DELETE FROM banners WHERE event_id=0 AND data_create <= "'.date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y"))).'"';
		$db->query($sql_delete_zero_records);
		//
		$sql_select_this_md5='SELECT * FROM banners WHERE md5_mictotime="'.$_POST['temp'].'"';
		$db->query($sql_select_this_md5);
		if($db->getCount()==0)
		{
			$sql_insert_into_table_banners='INSERT INTO banners (id,md5_mictotime,event_id,data_create) VALUES (NULL,"'.$_POST['temp'].'",0,"'.date('Y-m-d').'")';
		    $db->query($sql_insert_into_table_banners);
		}
		
		}
        else
		{
			 print $err;	
		}
        }
		else
		{
			 print $err;	
		}						
}
else
{
	   $err.='<p style=\'color:red;\'>Файл отсутствует</p>';
	   print $err; 
}
if(empty($err))
{

    echo json_encode(array('path'=>'/img/stock/'.$_POST['temp'].'.jpg','h'=>$handle->image_src_y,'w'=>$handle->image_src_x));
}		 
?>  
