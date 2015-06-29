<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance();

 $sql="UPDATE item SET DELETED=1 WHERE id=".$_POST['id'];
 $db->query($sql);            
        
   
?>
 
