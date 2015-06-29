<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance(); //Подключение базы
if($_POST['delvideo'])
{
    $id=$_POST['id'];
    $sql_del_pre="DELETE FROM events_video WHERE id=".$id;
    $db->query($sql_del_pre);
}
else
{
   if(!empty($_POST['youtube']))
    {
        //удаляем если есть старое
        $sql_delvideo='DELETE FROM events_video WHERE md5_mictotime="'.$_POST['temp'].'"';
        $db->query($sql_delvideo);
    	$str=strpos($_POST['youtube'],'v=');
    	$str2=strpos($_POST['youtube'],'feature');
    	if($str>$str2)
    	{$video_url=substr($_POST['youtube'], $str+2, $str.length);}
    	else 
    	{$video_url=substr($_POST['youtube'], $str+2, $str2-$str-3);}
    	$video_url='http://www.youtube.com/v/'.$video_url;
    	$qwery_video ="INSERT INTO events_video (id,md5_mictotime,event_id,data_create,temp,youtube) VALUES (NULL,'".$_POST['temp']."',0,'".date('Y-m-d')."',1,'".$video_url."')";
    	$db->query($qwery_video);
    	
    }
    
    //достаем все фотки к этому md5
    	$sql_select_all_preview_photo='SELECT * FROM events_video WHERE md5_mictotime="'.$_POST['temp'].'"';
    	$db->query($sql_select_all_preview_photo);
    	if($db->getCount()>0)
    	{
    		$arr=$db->getArray();
    		foreach($arr as $index=>$value)
    		{
    			print '<object style="width: 250px;height: 150px;float:left; " wmode="transparent"><param name="wmode" value="transparent" /><param name="movie" value="'.$value['youtube'].'?version=3&feature=player_detailpage"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="'.$value['youtube'].'?version=3&feature=player_detailpage" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="250" height="150" wmode="transparent"></object>';
    			print '<div class="edit_image_controll_button">
    				   <span class="del_video" data-id="'.$value['id'].'"> <img src="/img/admin/d.png" alt="Удалить" title="Удалить"></span>';
    		    print '</div>';
    			print '<div style="height:15px;clear:both;"></div>';
    		}
    	} 
}



			 
?>  
