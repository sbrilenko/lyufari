<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance();
$editorClass = new editorClass();
function rusDoubleQuotes($string) {
					$string=str_replace('«', '&laquo;', $string);
					$string=str_replace('»', '&raquo;', $string);
					$string=preg_replace("/(?:\"([^\"]+)\")/","&laquo;\\1&raquo;",$string);
					
					$vowels = array("'", '"', );
					$string=str_replace($vowels, '&quot;', $string);
					return $string;		
						  
				}
if(isset($_POST ['name'])) 
    if (!$name = $editorClass->replaceToInsert($_POST['name']))
       unset($name);
if(isset($_POST ['description'])) 
    if (!$description = $editorClass->replaceToInsert($_POST['description']))
       unset($description);
$name=rusDoubleQuotes($name);
$description=rusDoubleQuotes($description);
if(!empty($name) AND $_POST['type']!=0) /*Проверяем чтобы название и текст были введены*/
{
					$show_on_site=($_POST['invisible'])?0:1;
                    if( preg_match('/\d+/', $_POST['price'], $matches) ) {
                            $price = $matches[0];
                    }
                    else
                    {
                        $price =0;
                    }
                    if( preg_match('/\d+/', $_POST['priority'], $matches) ) {
                            $priority = $matches[0];
                    }
                    else
                    {
                        $priority =0;
                    }
					if(!$_POST['id'])
					{  
    					 $qwery ="INSERT INTO services (id,name,description,invisible,price,priority,type) VALUES (NULL,'".$name."','".$description."',".$show_on_site.",".$price.",".$priority.",".$_POST['type'].")";
    			    }
					else
					{
						 $qwery ="UPDATE services SET type=".$_POST['type'].",name='".$name."',description='".$description."',invisible=".$show_on_site.",price=".$price.",priority=".$priority." WHERE id=".$_POST['id'];
					}
                    echo $qwery;
                    $db->query($qwery);	
}
else
{
    $err="";
    if(empty($name))
    {
        $err.="<div class='error'>Обязательное поле название услуги</div>";
    }
    else
    if($_POST['type']==0)
    {
        if(!empty($err)) $err.="<br />";
        $err.="<div class='error'>Выберите тип услуги</div>";
    }
    if(!empty($err))
    {
        echo $err;
    }

}
?>
 
