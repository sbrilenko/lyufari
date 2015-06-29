<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/class.invis.db.php";
$db = db :: getInstance();
if(isset($_POST['type']))
{
    if($_POST['type']==0)
    {
        $sql="SELECT * FROM services ORDER BY priority DESC";

    }
    else
    {
        $sql="SELECT * FROM services WHERE type=".$_POST['type']." ORDER BY priority DESC";
    }
    echo $sql;
    $db -> query($sql);
    if($db ->getCount()>0)
    {
        $arr = $db -> getArray();
        foreach($arr as $arr_index=>$arr_val)
        {
            echo "<tr>";
            echo "<td width='20px'>";
            echo "<a href='/admin/serviceseditor/edit/".$arr_val['id']."'><img title='Редактировать' src='../img/admin/e.png' /></a><br /><br /><a href='/admin/serviceseditor/delete/".$arr_val['id']."'><img class='del' title='Удалить' src='../img/admin/d.png' /></a>";
            echo "</td>";
            echo "<td>";
            echo $arr_val['name'];
            echo "</td>";
            echo "</tr>";
        }
    }
    else
    {
        echo '<tr><td style="text-align:center;">Записей не найдено</td></tr>';
    }
}
?>