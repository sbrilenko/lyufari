<?php
$param_date=$_POST['date_begin'];
$param_date_end=$_POST['date_end'];
if($_POST['time_start_hour']!='-1' AND $_POST['time_start_min']!='-1')
{
	$arr_evets_value_explode_time_start=$_POST['time_start_hour'].':'.$_POST['time_start_min'].':00';
}
else
{
	$arr_evets_value_explode_time_start='00:00:00';
}
if($_POST['time_end_hour']!='-1' AND $_POST['time_end_min']!='-1')
{
	$arr_evets_value_explode_time_end=$_POST['time_end_hour'].':'.$_POST['time_end_min'].':00';
}
else
{
	$arr_evets_value_explode_time_end='00:00:00';
}
if(!empty($param_date))
{
	$month_name_event=array('01'=>"января",'02'=> "февраля", '03'=>"марта",'04'=>"апреля",'05'=>"мая",'06'=>"июня",'07'=>"июля",'08'=>"августа",'09'=>"сентября",'10'=>"октября",'11'=>"ноября",'12'=>"декабря");

				 $param_date=explode('.',$param_date);
				 $param_date_end=explode('.',$param_date_end);
				 if($param_date[0]==$param_date_end[0])
				 {
				 	print ' c '.date('d',mktime(0,0,0,$param_date[1],$param_date[0],$param_date[2]))." ".$month_name_event[date('m',mktime(0,0,0,$param_date[1],$param_date[0],$param_date[2]))]." ";
				 }
				 else
				 {
				 	print date('d',mktime(0,0,0,$param_date[1],$param_date[0],$param_date[2]))." ".$month_name_event[date('m',mktime(0,0,0,$param_date[1],$param_date[0],$param_date[2]))]." ".$param_date[2]."г";
				 }
				 if($arr_evets_value_explode_time_start!='00:00:00')
				 {
				 	$arr_evets_value_explode_time_start=explode(':',$arr_evets_value_explode_time_start);
				 	print ' '.$arr_evets_value_explode_time_start[0].':'.$arr_evets_value_explode_time_start[1];
				 }
			if($param_date_end[0]!='' OR $arr_evets_value_explode_time_end!='00:00:00')
			{
				if($param_date_end[0]!='')
				{
					 print ' до ';
					 if($param_date[0]==$param_date_end[0])
					 {
					 	print date('d',mktime(0,0,0,$param_date_end[1],$param_date_end[0],$param_date_end[2]))." ".$month_name_event[date('m',mktime(0,0,0,$param_date_end[1],$param_date_end[0],$param_date_end[2]))]." ".$param_date_end[2]."г";
					 }
					 else
					 {
					 	print date('d',mktime(0,0,0,$param_date_end[1],$param_date_end[0],$param_date_end[2]))." ".$month_name_event[date('m',mktime(0,0,0,$param_date_end[1],$param_date_end[0],$param_date_end[2]))]." ".$param_date_end[2]."г";
					 }
					 if($arr_evets_value_explode_time_end!='00:00:00')
					 {
					 	 $arr_evets_value_explode_time_end=explode(':',$arr_evets_value_explode_time_end);
						 print ' '.$arr_evets_value_explode_time_end[0].':'.$arr_evets_value_explode_time_end[1];
					 }
					
				}
				else
				{
					print ' до ';
					 if($arr_evets_value_explode_time_end!='00:00:00')
					 {
					 	 $arr_evets_value_explode_time_end=explode(':',$arr_evets_value_explode_time_end);
						 print $arr_evets_value_explode_time_end[0].'.'.$arr_evets_value_explode_time_end[1];
					 }
				}
			}
}
				
?>