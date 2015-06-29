<?php
$root = $_SERVER['DOCUMENT_ROOT'];	
require_once $root."/lib/class.invis.db.php";
$db = db :: getInstance();		
if(isset($_POST['db']) AND !empty($_POST['db']))
{
    $sql="SELECT * FROM preview_photo WHERE event_id=".$_POST['db']." ORDER BY preview_bool DESC";
    $db->query($sql);
    $elements='[';
    if($db->getCount()>0)
    {
        $arr=$db->getArray();
        foreach($arr as $i=>$v)
        {
            $elements .= '"'.$v['md5_mictotime'].'_'.$v['id'].'.jpg'.'"';
            if ($i+1!=count($arr)) $elements .= ",";
        }
    }
    $elements.=']';
    echo $elements;
}
else
if(isset($_POST['dir'])AND !empty($_POST['dir']))
{
    $elements='[';
    if($_POST['action']==-1)
    {
        //по всем папкам
    }
    else
    {
        $dir = $root."/".$_POST['dir']."size1";
        	$array=null;
            if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                   // echo "файл: $file : тип: " . filetype($dir . $file) . "";
                    if(substr(strrchr($file, '.'), 1)=='jpg')
        			{
        				 $array[]=$file;
        				 /*$elements .= '"'.$file.'"';
                   		 if ($count!=$number) $elements .= ",";
        				 $number++;*/
        			}	
                } 
            }
            sort($array);
            for($i=0;$i<count($array);$i++)
            {
            	 $elements .= '"'.$array[$i].'"';
                 if ($i+1!=count($array)) $elements .= ",";
            }
            closedir($dh);
        }
        $elements.="]";
        echo $elements;
    }

}

 
?>