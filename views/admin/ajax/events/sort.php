<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$targetPath = $root . '/img/calendar/';	
require_once $root."/lib/class.invis.db.php";
$db = db :: getInstance();
    $start=explode('.',$_POST['date_begin']);
    $start=$start[2]."-".$start[1]."-".$start[0];
    $end=explode('.',$_POST['date_end']);
    $end=$end[2]."-".$end[1]."-".$end[0];
    
	$sql="select * from events where start_date between '".$start."' and '".$end."' ORDER BY start_date DESC";
    echo $start." ".$end;
    echo $sql;
	$db->query($sql);
	$arr=$db->getArray();
	$db->query($sql);
	if($db->getCount()>0)
	{
		$arr=$db->getArray();
		foreach($arr as $index=>$value)
		{
			print "<tr><td></td></tr><tr><td style='border:1px solid #dedede'>";
			$select_photo_banner='SELECT md5_mictotime FROM banners WHERE event_id='.$value['id'];
			$db->query($select_photo_banner);
			if($db->getCount()>0)
			{
				print "<img style='float:left;width:75px;height:50px;' src='/img/stock/".$db->getValue().".jpg'/>";
			}
			else
			{
				print "<img style='float:left;width:75px;height:50px;' src='/img/admin/zaglushka.jpg'/>";
			}
			
			print "<div style='float:left;margin-left:10px;'>
					<p><a class='delevent' href='/admin/event/editor/delete/".$value['id']."' style='margin-right:7px;'>
		          		<img src='img/admin/d.png' alt='Удалить' title='Удалить'>
		        	</a></p><br />
		        	<p><a href='/admin/event/editor/edit/".$value['id']."' >
		          		<img src='img/admin/e.png' alt='Ред' title='Ред'>
		        	</a></p></div>";
		    print "<div style='float:left;margin-left:10px;width: 862px;'><b>Название:</b> ".$value['title'];
			$data_start=explode('-',$value['start_date']);

				print '<br /><b>Дата начала:</b> '.$data_start[2].'-'.$data_start[1].'-'.$data_start[0];
				if($value['time_start_zero']!=0) {$time_start=explode(':',$value['time_start']); print ' начало <span style="color:blue;"> '.$time_start[0].':'.$time_start[1].'</span>';}
				if($value['end_date']!='0000-00-00')  {
					if($value['end_date']==$value['start_date']) { }
					else {$data_end=explode('-',$value['end_date']); print ' - '.$data_end[2].'-'.$data_end[1].'-'.$data_end[0]; }
					}
				if($value['time_end_zero']!=0) {$time_end=explode(':',$value['time_end']); print ' завершение <span style="color:blue;"> '.$time_end[0].':'.$time_end[1].'</span>'; }
	        echo "<br /><b>Отображение на сайте: </b>";
            echo ($value['visible']==0)? "отображается":"не отображается";
                print "</div>";
			print "</td></tr>";
		}
	}
    else
    {
        echo '<tr><td style="font-weight: bold;color:#380b9f;text-align:center;">Записей не найдено</td></tr>';
                            }

?>