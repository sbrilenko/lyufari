<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance();
$editorClass = new editorClass();
function rusDoubleQuotes($string) {
					$string=str_replace('«', '&laquo;', $string);
					$string=str_replace('»', '&raquo;', $string);
//					$string=preg_replace("/(?:\"([^\"]+)\")/","&laquo;\\1&raquo;",$string);
					
					$vowels = array('"');
					$string=str_replace($vowels, '&quot;', $string);
					return $string;		
						  
				}
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description); 
if(isset($_POST ['description_star'])) 
    if (!$description_star = $editorClass->replaceToInsert($_POST['description_star']))
       unset($description_star);
if($_POST['datepicker']==null)
{
	if(!empty($all_err))
	{
		$all_err.="<p style='color:red;'>, дата начала</p>";
	}
	else
	{
		$all_err.="<p style='color:red;'>дата начала</p>";
	}
	
}
if($_POST['title']==null)
{
	if(!empty($all_err))
	{
		$all_err.="<p style='color:red;'>, название события</p>";
	}
	else
	{
		$all_err.="<p style='color:red;'>название события</p>";
	}
}
//есть ли баннер
$sql_select_banners_photo='SELECT * FROM banners WHERE md5_mictotime="'.$_POST['temp'].'"';
$db->query($sql_select_banners_photo);
if($db->getCount()==0)
{
    if(!empty($all_err))
    {
        $all_err.="<p style='color:red;'>, баннер</p>";
    }
    else
    {
        $all_err.="<p style='color:red;'>баннер</p>";
    }
}
if($_POST['id']=='')
{

//если preview_photo>=3, но отмеченно <3 считаем это ошибкой
//проверим сколько отмеченных фото
		$count_checked_preview_photo=0;
		foreach($_POST as $index=>$rez)
		{
			$explode_index=explode('_',$index);
			if($explode_index[0]=='preview')
				{
					$count_checked_preview_photo++;
				}
		}
	    //а есть ли вообще фото для галереи, проверим
	    $sql_select_preview_photo_is='SELECT * FROM preview_photo WHERE md5_mictotime="'.$_POST['temp'].'"';
	   $db->query($sql_select_preview_photo_is);
	   if($db->getCount()>=3 AND $count_checked_preview_photo>0 AND $count_checked_preview_photo<3)
		{
			//if(empty($all_err))	$all_err.="<p style='color:red;'>отметьте 3 фотографии для превью фотогалереи</p>";
		}
}
else //если это редактировние
{
	//если preview_photo>=3, но отмеченно <3 считаем это ошибкой
    //проверим сколько отмеченных фото
		$count_checked_preview_photo=0;
		foreach($_POST as $index=>$rez)
		{
			$explode_index=explode('_',$index);
			if($explode_index[0]=='preview')
				{
					$count_checked_preview_photo++;
				}
		}
	    //а есть ли вообще фото для галереи, проверим
	    $sql_select_preview_photo_is='SELECT * FROM preview_photo WHERE md5_mictotime="'.$_POST['temp'].'"';
	   $db->query($sql_select_preview_photo_is);
	   if($db->getCount()>=3 AND $count_checked_preview_photo>0 AND $count_checked_preview_photo<3)
		{
//			if(empty($all_err))	$all_err.="<p style='color:red;'>отметьте 3 фотографии для превью фотогалереи</p>";
		}
}

if(($_POST['title']!=null) AND($_POST['datepicker']!=null) AND empty($all_err)) /*Проверяем чтобы название и текст были введены*/
{
                    $data_start=explode('.',$_POST['datepicker']);
                    $_POST['datepicker']=$data_start[2].'-'.$data_start[1].'-'.$data_start[0];
					if($count_checked_preview_photo==3)
					{
					    $sql_update_preview_photo_preview_bool='UPDATE preview_photo SET preview_bool=0 WHERE  md5_mictotime="'.$_POST['temp'].'"';
                        $db->query($sql_update_preview_photo_preview_bool);
						foreach($_POST as $index=>$rez)
						{
								$explode_index=explode('_',$index);
								if($explode_index[0]=='preview')
								{
									$sql_update_preview_photo_preview_bool='UPDATE preview_photo SET preview_bool=1 WHERE id='.$explode_index[1];
									$db->query($sql_update_preview_photo_preview_bool);
								}
						}
					}
					else //если не отмеченно ничего , просто сохраняем первые 3 в базе с preview_bool=1
					{
					    //обнулим все 
                        $sql_update_preview_photo_preview_bool='UPDATE preview_photo SET preview_bool=0 WHERE  md5_mictotime="'.$_POST['temp'].'"';
                        $db->query($sql_update_preview_photo_preview_bool);
            			$sql_get_first_3_record_from_preview_photo='SELECT * FROM preview_photo WHERE md5_mictotime="'.$_POST['temp'].'" LIMIT 0,3';
						$db->query($sql_get_first_3_record_from_preview_photo);
						if($db->getCount()>0)
						{
							$arr=$db->getArray();
							foreach($arr as $index=>$value)
							{
								$sql_update_preview_photo_preview_bool='UPDATE preview_photo SET preview_bool=1 WHERE id='.$value['id'].' AND md5_mictotime="'.$_POST['temp'].'"';
								$db->query($sql_update_preview_photo_preview_bool);
							}
						}
						
					}
      
					if(($_POST['time_start_hour']=='-1') OR ($_POST['time_start_min'])=='-1')
					{
						$time_start='00:00:00';
						$time_start_zero=0;
					}
					else
					{
						$time_start=$_POST['time_start_hour'].':'.$_POST['time_start_min'].':00';
						$time_start_zero=1;
					}
					if(($_POST['time_end_hour']=='-1') OR ($_POST['time_end_min'])=='-1')
					{
						$time_end='00:00:00';
						$time_end_zero=0;
					}
					else
					{
						$time_end=$_POST['time_end_hour'].':'.$_POST['time_end_min'].':00';
						$time_end_zero=1;
					}
					if($_POST['datepicker2']!='')
					{
						$data_end=explode('.',$_POST['datepicker2']);
                        $data_end=$data_end[2].'-'.$data_end[1].'-'.$data_end[0];
					}
					else
					{
						$data_end="0000-00-00";
					}

					$show_on_site=($_POST['visible'])?0:1;
                    //режим банер

                    $handle = new upload($root.'/img/stock/'.$_POST['temp'].".jpg");
                    $handle->file_new_name_body   = $_POST['temp'];
                    $handle->image_resize          = true;
                    $handle->image_y               = 360;
                    $handle->image_x               = 720;
                    $handle->image_precrop = (int)($_POST['cy']*$handle->image_src_y/360).' '.($handle->image_src_x-(int)($_POST['cx2']*$handle->image_src_x/720)).' '.($handle->image_src_y-(int)($_POST['cy2']*$handle->image_src_y/360)).' '.(int)($_POST['cx']*$handle->image_src_x/720);

                    $handle->jpeg_quality = 100;
            		$handle->image_unsharp = false;
                    $handle->file_auto_rename = false;
                    $handle->file_overwrite = true;
                    $handle->process($root.'/img/stock');
                    //$handle->clean();

    if(!$_POST['id'])
					{  
		   				 $next_group=$db->getai('events');
						 $sql_banner='UPDATE banners SET event_id='.$next_group.' WHERE md5_mictotime="'.$_POST['temp'].'"';
						 $sql_preview_photo='UPDATE preview_photo SET event_id='.$next_group.' WHERE md5_mictotime="'.$_POST['temp'].'"';
					     $title=rusDoubleQuotes($_POST['title']);
    					 $description=rusDoubleQuotes($description);
    					 $description_star=rusDoubleQuotes( $description_star);
    					 $qwery ="INSERT INTO events (id,title,description,description_star,start_date,time_start,time_start_zero,end_date,time_end,time_end_zero,photo,visible) VALUES (NULL,'".$title."','".$description."','".$description_star."','".$_POST['datepicker']."', '".$time_start."', ".$time_start_zero.", '".$data_end."', '".$time_end."', ".$time_end_zero.", '".$_POST['temp']."',".$show_on_site.")";
    			    }
					else
					{
						 $sql_banner='UPDATE banners SET event_id='.$_POST['id'].' WHERE md5_mictotime="'.$_POST['temp'].'"';
						 $sql_preview_photo='UPDATE preview_photo SET event_id='.$_POST['id'].' WHERE md5_mictotime="'.$_POST['temp'].'"';
						 $title=rusDoubleQuotes($_POST['title']);
						 $description=rusDoubleQuotes( $description);
						 $description_star=rusDoubleQuotes( $description_star);
						 $qwery ="UPDATE events SET title='".$title."',description='".$description."',description_star='".$description_star."',start_date='".$_POST['datepicker']."',time_start='".$time_start."',time_start_zero=".$time_start_zero.",end_date='".$data_end."',time_end='".$time_end."',time_end_zero=".$time_end_zero.", visible=".$show_on_site." WHERE id=".$_POST['id'];
						
					}
				 }
//вывод
echo $qwery;
if($all_err=='')
{
		$db->query($sql_banner);
		$db->query($sql_preview_photo);
		$db->query($qwery);	
}
else
	{
		$all_err='Обязательные поля: '.$all_err;
		print $all_err;
	}
?>
 
