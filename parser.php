<?php 
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root.'/lib/class.dbf.php';
    require_once $root.'/lib/class.invis.db.php';
    $db=db :: getInstance();
    $dir=$root."/dbf/";
	$array=array();
    if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(substr(strrchr($file, '.'), 1)=='dbf')
			{
                 $lovercase=strtolower($file);
                 if( $lovercase=='section.dbf' OR  $lovercase=='itemgroup.dbf' OR  $lovercase=='item.dbf')
                 {
                    array_push($array,$file);
                 }
			}	
        } 
    }
}
//начинаем парсить
//print_r($array);
if(!empty($array))
{
    
    for($z=0;$z<count($array);$z++)
{
    $file= $root."/dbf/".$array[$z];
    $dbf = new dbf_class($file);
    //echo "<br />".$array[$i];
    //echo str_replace('.dbf', '', $array[$z]);
    $num_rec=$dbf->dbf_num_rec;
    $header=$dbf->getheader();
    //echo "<br />";
    $num_field=$dbf->dbf_num_field;
    for($i=0; $i<$num_rec; $i++){
        $row = $dbf->getRow($i);
        $sql="SELECT CODE2 FROM ".strtolower(str_replace('.dbf', '', $array[$z]))." WHERE CODE2='".iconv('windows-1251', 'utf-8', $row[0])."'";
        $db->query($sql);
        if($db->getCount()>0)
        {
            //если есть обновляем данные
            for($j=0; $j<$num_field; $j++){
            $row[$j]=trim($row[$j]);
            if(!empty($row[$j]))
            {
                //echo iconv('windows-1251', 'utf-8', $row[$j])." | ";
                $field=array();
            $field_val=array();
            for($j=0; $j<$num_field; $j++){
                $row[$j]=trim($row[$j]);
                if(!empty($row[$j]))
                {
                    array_push($field,iconv('windows-1251', 'utf-8', $header[$j]));
                    array_push($field_val,iconv('windows-1251', 'utf-8', $row[$j]));
                }
            } 
            $f='';
            $v='';
            for($sql=0;$sql<count($field);$sql++)
            {
                if($sql==count($field)-1)
                {
                    $f.=$field[$sql]."='".$field_val[$sql]."'";
                }
                else
                {
                    $f.=$field[$sql]."='".$field_val[$sql]."',";
                }
                
            }
            $sql_update="UPDATE ".strtolower(str_replace('.dbf', '', $array[$z]))." SET ".$f." WHERE CODE2='".iconv('windows-1251', 'utf-8', $row[0])."'";
            
            $db->query($sql_update);
            } 
        }    
        }
        else
        {
            //если нет токого айди то добавляем
            //
            $field=array();
            $field_val=array();
            for($j=0; $j<$num_field; $j++){
                $row[$j]=trim($row[$j]);
                if(!empty($row[$j]))
                {
                    array_push($field,iconv('windows-1251', 'utf-8', $header[$j]));
                    array_push($field_val,iconv('windows-1251', 'utf-8', $row[$j]));
                }
            } 
            $f='';
            $v='';
            for($sql=0;$sql<count($field);$sql++)
            {
                if($sql==count($field)-1)
                {
                    $f.=$field[$sql];
                    $v.="'".$field_val[$sql]."'";
                }
                else
                {
                    $f.=$field[$sql].",";
                    $v.="'".$field_val[$sql]."',";
                }
                
            }
            $sql_insert="INSERT INTO ".strtolower(str_replace('.dbf', '', $array[$z]))." (".$f.") VALUES(".$v.")";
            $db->query($sql_insert);
        }
    }
}
echo "Дело сделано";
sleep(10);
}
else
{
    echo "Нет файлов";
}

?>
