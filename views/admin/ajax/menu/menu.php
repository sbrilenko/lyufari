<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root."/lib/include.php";
$db = db :: getInstance();
  set_time_limit(0);
 $name = preg_replace("/insert|delete|update/i","", $_POST['name']);
 $name = preg_replace("/'/i",'"', $name);
 $description = preg_replace("/insert|delete|update/i","", $_POST['description']);
 $description = preg_replace("/'/i",'"',  $description);
 if( preg_match('/\d+/', $_POST['price'], $matches) ) {
    $price = $matches[0];
    }
    else
    {
        $price =0;
    }
 if( preg_match('/\d+/', $_POST['weight'], $matches) ) {
    $weight = $matches[0];
    }
    else
    {
        $weight =0;
    }
switch ($_POST['type'])
{
	case 'update_category_name':
        $invisible=isset($_POST['invisible'])?0:1;
        $prior=isset($_POST['prior'])?$_POST['prior']:20;
		if(empty($name))
		{
		  echo "<span class='error'>Обязательное поле название категории</span>";
		}
		else
		{
			$sql="UPDATE menu_m SET name='".$name."',invisible=$invisible, prior=".$_POST['prior']." WHERE id=".$_POST['id'];
			$db->query($sql);
            $sql_act_menu_="UPDATE actual_date_price SET date='".date('Y-m-d')."'";
            $db->query($sql_act_menu_);
            $invisible=($invisible==0)?"checked='checked'":"";
            $select="";
            $select.="<select name='prior' style='margin-top: 0px;height: 22px;' title='Приоритет'>";
            for($i=20;$i>=0;$i--)
            {
                $select.=($prior==$i)?"<option selected='selected' value='".$i."'>".$i."</option>":"<option value='".$i."'>".$i."</option>";
            }
            $select.="</select>";
			echo "<form method='post'><div style='font-size:15px;float:left;'><input type='hidden' name='type' value='update_category_name'/><input type='hidden' name='id' value='".$_POST[id]."'/><input name='name' title='название' style='width:730px;' value='".$name."'/>".$select."</div><div style='float:right'><img rel='".$_POST[id]."' class='drop_category' src='../img/admin/d.png' title='Удалить категорию'/><input type='checkbox' name='invisible' ".$invisible." /><input type='button' class='update_category' value='Обновить' /></div><div style='clear:both;'></div></form>";
            
		}
		
	break;
	case 'update_sub_category':
		if(empty($name))
		{
		   echo "<span class='error'>Обязательное поле название категории</span>";
		}
		else 
		{
		    $invisible=isset($_POST['invisible'])?0:1;
            $prior=isset($_POST['prior'])?$_POST['prior']:20;
			$sql="UPDATE menu_m SET name='".$name."',invisible=".$invisible.",prior=".$_POST['prior']." WHERE  id=".$_POST['id'];
			$db->query($sql);
			$sql_act_menu_="UPDATE actual_date_price SET date='".date('Y-m-d')."'";
            $db->query($sql_act_menu_);
            $invisible=($invisible==0)?"checked='checked'":"";
            $select="";
            $select.="<select name='prior' style='margin-top: 0px;height: 22px;' title='Приоритет'>";
            for($i=20;$i>=0;$i--)
            {
                $select.=($prior==$i)?"<option selected='selected' value='".$i."'>".$i."</option>":"<option value='".$i."'>".$i."</option>";
            }
            $select.="</select>";
            echo "<form method='post'><div style='font-size:15px;float:left;'><input type='hidden' name='type' value='update_sub_category'/><input type='hidden' name='id' value='".$_POST[id]."'/><input name='name' title='название' style='width:361px;' value='".$name."'/>".$select."</div><div style='float:right'><img class='drop_sub_category' src='img/admin/d.png' title='Удалить подкатегорию' rel='".$_POST['id']."'><input type='checkbox' title='Видимость' name='invisible' ".$invisible." /><input type='button' class='update_sub_category' value='Обновить' /></div><div style='clear:both;'></div></form>";
		}
		
	break;
	case 'bludo_update':
	     if(empty($name))
		 {
		  echo "<span class='error'>Обязательные поля: название блюдо</span>";
	 	 }
         else
         {
            $invisible=($_POST['vis'])?0:1;
            $delivery=($_POST['delivery'])?1:0;
			$sql="UPDATE menu_m SET delivery=".$delivery.",price=".$price.",weight=".$weight.",name='".$name."',description='".$description."',invisible=".$invisible." WHERE id=".$_POST['id'];
			$db->query($sql);
            $invisible=($invisible==0)?"checked='checked'":"";
            $delivery=($delivery==1)?"checked='checked'":"";
            echo '<form method="post"><div style="float:left;"><input type="hidden" name="type" value="bludo_update"><input type="hidden" name="parent" value="'.$_POST['parent'].'"><input type="hidden" name="id" value="'.$_POST['id'].'">*<input name="name" style="width:350px;" title="Название блюда" value="'.$name.'"><input name="weight" class="onlynumbers" title="Выход" value="'.$weight.'"><input name="price" class="onlynumbers" title="Цена" value="'.$price.'"><input type="checkbox" name="vis" title="Видимость" '.$invisible.'><input type="checkbox" name="delivery" title="Доставка" '.$delivery.'>Доставка</div><div style="float:right;"><img style="cursor:pointer;" rel="'.$_POST['id'].'" class="drop_bludo" title="Удалить блюдо" src="../img/admin/d.png"></div><div style="clear:both;"></div><div style="clear:both;"></div><input name="description" title="Описание" style="width:100%" value="'.$description.'"><div style="clear:both;"></div><div style="float:left;"><input type="file" name="image" accept="image/png,image/jpeg"><input type="button" class="load_image" value="Загрузить фото"><span style="width: 270px;display: inline-block;" class="img_loader_photo"></span><span class="img"></span></div><div style="float:right;"><input type="button" class="update_bludo" value="Обновить"></div><div style="clear:both;"></div></form>';
            //фотку обновляем если есть
            $sql_photo="UPDATE menuphoto SET temp=1 WHERE parent=".$_POST['id']." ORDER BY dtcreate DESC LIMIT 1";
            $db->query($sql_photo);
         }
	    
	break;
     case 'drop_bludo';
		$sql='SELECT * FROM menuphoto WHERE parent='.$_POST['id'];
		$db->query($sql);
		if($db->getCount()>0)
		{
			$arr=$db->getArray();
            foreach($arr as $arr_index=>$arr_val)
            {
                if(file_exists($root.'/img/menu/size1/'.$arr_val['name'].'_'.$arr_val[0]['id'].'.jpg'))
    			{
    				unlink($root.'/img/menu/size1/'.$arr_val['name'].'_'.$arr_val['id'].'.jpg');
    			}
    	        if(file_exists($root.'/img/menu/size2/'.$arr_val['name'].'_'.$arr_val['id'].'.jpg'))
    			{
    				unlink($root.'/img/menu/size2/'.$arr_val['name'].'_'.$arr_val['id'].'.jpg');
    			}
    	        if(file_exists($root.'/img/menu/size3/'.$arr_val['name'].'_'.$arr_val['id'].'.jpg'))
    			{
    				unlink($root.'/img/menu/size3/'.$arr_val['name'].'_'.$arr_val['id'].'.jpg');
    			}
            }
			
			//delete_from base
			$sql_delete='DELETE FROM menuphoto WHERE parent='.$_POST['id'];
			$db->query($sql_delete);
            
            //delete_from base
			$sql_delete='DELETE FROM menu_m WHERE parent='.$_POST['id'];
			$db->query($sql_delete);
            
            $sql_act_menu_="UPDATE act_menu_date SET date='".date('Y-m-d')."'";
            $db->query($sql_act_menu_);
		}
		//теперь саму запись в базе

			$sql_delete='DELETE FROM menu_m WHERE id='.$_POST['id'];
			$db->query($sql_delete);
	break; 
 
	case 'add_sub_category':
          if(empty($name))
          {
              echo "<span class='error'>Обзательные поля: название подкатегории</span>";
          }
          else
          {
              $invisible=isset($_POST['invisible'])?0:1;
              $prior=isset($_POST['prior'])?$_POST['prior']:20;
              $sql="INSERT INTO menu_m (parent,name,invisible,element_submenu) VALUES (".$_POST['parent'].",'".$name."',".$invisible.",1)";
              $db->query($sql);
              $id=$db->last();
              $select="";
              $select.="<select name='prior' style='margin-top: 0px;height: 22px;' title='Приоритет'>";
              for($i=20;$i>=0;$i--)
              {
                  $select.=($arr_sub_val['prior']==$i)?"<option selected='selected' value='".$i."'>".$i."</option>":"<option value='".$i."'>".$i."</option>";
              }
              $select.="</select>";
              $invisible=($invisible==0)?"checked='checked'":"";
              echo '<li class="submainname" style="margin-left:32px;"><div class="menunamebackpad"></div><form method="post"><div style="font-size:15px;float:left;"><input type="hidden" name="type" value="update_sub_category"><input type="hidden" name="id" value="'.$id.'"><input name="name" title="название" style="width:361px;" value="'.$name.'">'.$select.'</div><div style="float:right"><img class="drop_sub_category" src="img/admin/d.png" title="Удалить подкатегорию" rel="'.$id.'"><input title="Удалить подкатегорию" type="checkbox" name="invisible" '.$invisible.'><input type="button" class="update_sub_category" value="Обновить"></div><div style="clear:both;"></div></form><ul><li style="margin:6px 0;padding: 10px;"><div style="text-align:center;">Добавить блюдо в</div><form method="post"><div style="float:left;"><input type="hidden" name="type" value="bludo_add"><input type="hidden" name="parent" value="'.$id.'">*<input name="name" style="width:350px;" title="Название блюда" value=""><input name="weight" class="onlynumbers" title="Выход" value=""><input name="price" class="onlynumbers" title="Цена" value=""><input type="checkbox" name="vis" title="Видимость" checked="checked"><input type="checkbox" name="delivery" title="Доставка" checked="checked">Доставка</div><div style="float:right;"></div><div style="clear:both;"></div><div style="clear:both;"></div><input name="description" title="Описание" style="width:100%" value=""><div style="clear:both;"></div><div style="float:left;"><span class="img"></span></div><div style="float:right;"><input type="button" name="" class="add_bludo" value="Добавить"></div><div style="clear:both;"></div></form></li></ul></li>';
		 
          }
         
	break;
    case 'add_category':
          if(empty($name))
          {
              echo "<span class='error'>Обзательные поля: название категории</span>";
          }
          else
          {
            $invisible=($_POST['invisible'])?0:1;
            $sql="INSERT INTO menu_m (name,invisible,element_submenu,delivery) VALUES ('".$name."',".$invisible.",1,1)";
            $db->query($sql);
            $id=$db->last();
            $invisible=($invisible==0)?'checked="checked"':'';
            //echo '<li class="mainname"><div class="menunamebackpad"></div><form method="post"><div style="font-size:15px;float:left;"><input type="hidden" name="type" value="update_category_name"><input type="hidden" name="id" value="'.$id.'"><input name="name" title="название" style="width:350px;" value="'.$name.'"></div><div style="float:right"><img class="drop_category" src="img/admin/d.png" title="Удалить категорию" rel="'.$id.'" /><input type="checkbox" name="invisible" '.$invisible.'><input type="button" class="update_category" value="Обновить"></div><div style="clear:both;"></div></form><ul><li class="submainname" style="margin-left:32px;"><div style="text-align:center;">Добавить подкатегорию</div><form method="post"><div style="font-size:15px;float:left;"><input type="hidden" name="type" value="add_sub_category"><input type="hidden" name="parent" value="3510"><input name="name" title="название" style="width:361px;" value=""></div><div style="float:right"><input type="checkbox" name="invisible" checked="checked"><input type="button" class="add_sub_category" value="Добавить"></div><div style="clear:both;"></div></form></li></ul></li>';
            echo '<li class="mainname"><div class="menunamebackpad backbottom"></div><form method="post"><div style="font-size:15px;float:left;"><input type="hidden" name="type" value="update_category_name"><input type="hidden" name="id" value="'.$id.'"><input name="name" title="русское название" style="width:730px;" value="тест"></div><div style="float:right"><img class="drop_category" src="img/admin/d.png" title="Удалить категорию" rel="'.$id.'"><input type="checkbox" title="Видимость" name="invisible" '.$invisible.'><input type="button" class="update_category" value="Обновить"></div><div style="clear:both;"></div></form><ul class="visible"><li class="submainname" style="margin-left:32px;"><div style="text-align:center;">Добавить подкатегорию</div><form method="post"><div style="font-size:15px;float:left;"><input type="hidden" name="type" value="add_sub_category"><input type="hidden" name="parent" value="'.$id.'"><input name="name" title="русское название" style="width:361px;" value=""></div><div style="float:right"><input type="checkbox" name="invisible" checked="checked" title="Видимость"><input type="button" class="add_sub_category" value="Добавить"></div><div style="clear:both;"></div></form></li><li class="hover-bludo" style="margin:6px 0 6px 32px;padding:16px 10px;"><div style="text-align:center;">Добавить блюдо в '.$name.'</div><form method="post"><div style="float:left;"><input type="hidden" name="type" value="bludo_add"><input type="hidden" name="parent" value="'.$id.'">*<input name="name" style="width:350px;" title="Название блюда - русское" value=""><input name="weight" class="onlynumbers" title="Выход" value=""><input name="price" class="onlynumbers" title="Цена" value=""><input type="checkbox" name="vis" title="Видимость" checked="checked"><input type="checkbox" name="delivery" title="Доставка" checked="checked">Доставка</div><div style="float:right;"></div><div style="clear:both;"></div><div style="clear:both;"></div><input name="description" title="Описание" style="width:100%" value=""><div style="clear:both;"></div><div style="float:left;"><span class="img"></span></div><div style="float:right;"><input type="button" name="" class="add_bludo" value="Добавить"></div><div style="clear:both;"></div></form></li></ul></li>';
          }
          break;
    case 'drop_category':
         $id=$_POST['id'];
         $sql="SELECT * FROM menu_m WHERE id=".$id;
         $db->query($sql);
         if($db->getCount()>0)
         {
            $arr_all=$db->getArray();
            foreach($arr_all as $arr_all_index=>$arr_all_val)
            {
                //выбираем все подкатегории
                $sql_sub="SELECT * FROM menu_m WHERE parent=".$arr_all_val['id'];
                $db->query($sql_sub);
                if($db->getCount()>0)
                {
                    $arr_sub=$db->getArray();
                    foreach($arr_sub as $arr_sub_index=>$arr_sub_val)
                    {
                        //Удаляем фото на блюде
                        $sql_photo="SELECT * FROM menuphoto WHERE parent=".$arr_sub_val['id'];
                        $db->query($sql_photo);
                        if($db->getCount()>0)
                        {
                            $arr_photo=$db->getArray();
                            foreach($arr_photo as $arr_photo_index=>$arr_photo_val)
                            {
                                if(file_exists($root.'/img/menu/fsize1/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg'))
								{
									unlink($root.'/img/menu/fsize1/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg');
								}
        						if(file_exists($root.'/img/menu/fsize2/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg'))
								{
									unlink($root.'/img/menu/fsize2/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg');
								}
        						if(file_exists($root.'/img/menu/fsize3/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg'))
								{
									unlink($root.'/img/menu/fsize3/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg');
								}
                                $sql_del_photo="DELETE FROM menuphoto WHERE id=".$arr_photo_val['id'];
                                $db->query($sql_del_photo);
                            }
                            
                        }
                        //удаляем все блюда
                        $delete="DELETE FROM menu_m WHERE id=".$arr_sub_val['id'];
                        $db->query($delete);
                    }
                }
                $delete="DELETE FROM menu_m WHERE id=".$arr_all_val['id'];
                $db->query($delete);
            }
         }
         $delete="DELETE FROM menu_m WHERE id=".$id;
         $db->query($delete);
         
    break;
    case 'drop_sub_category':
         $id=$_POST['id'];
         $sql="SELECT * FROM menu_m WHERE parent=".$id;
         $db->query($sql);
         if($db->getCount()>0)
         {
            $arr_sub=$db->getArray();
            foreach($arr_sub as $arr_sub_index=>$arr_sub_val)
            {
                 //Удаляем фото на блюде
                $sql_photo="SELECT * FROM menuphoto WHERE parent=".$arr_sub_val['id'];
                echo $sql_photo." | ";
                $db->query($sql_photo);
                if($db->getCount()>0)
                {
                    $arr_photo=$db->getArray();
                    foreach($arr_photo as $arr_photo_index=>$arr_photo_val)
                    {
                        if(file_exists($root.'/img/menu/size1/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg'))
						{
							unlink($root.'/img/menu/size1/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg');
						}
						if(file_exists($root.'/img/menu/size2/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg'))
						{
							unlink($root.'/img/menu/size2/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg');
						}
						if(file_exists($root.'/img/menu/size3/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg'))
						{
							unlink($root.'/img/menu/size3/'.$arr_photo_val['name'].'_'.$arr_photo_val['id'].'.jpg');
						}
                         $sql_del_photo="DELETE FROM menuphoto WHERE id=".$arr_photo_val['id'];
                         echo $sql_del_photo;
                         $db->query($sql_del_photo);
                    }
                }
               
            }
                 
         }
        
          //удаляем все блюда
          $delete="DELETE FROM menu_m WHERE parent=".$id;
          $db->query($delete); 
          $delete="DELETE FROM menu_m WHERE id=".$id;
         $db->query($delete);
    break;
    
    case 'bludo_add':
         if(empty($name))
		 {
		  echo "<span class='error'>Обязательные поля: название блюдо</span>";
	 	 }
         else
         {
            $invisible=($_POST['vis'])?0:1;
            $delivery=($_POST['delivery'])?1:0;
            if(empty($_POST['parent'])) $_POST['parent']=0; 
			$sql="INSERT INTO menu_m (delivery,price,weight,name,description,invisible,parent,element_submenu) VALUES (".$delivery.",".$price.",".$weight.",'".$name."','".$description."',".$invisible.",".$_POST['parent'].",0)";
			$db->query($sql);
            $id=$db->last();
            $invisible=($invisible==0)?"checked='checked'":"";
            $delivery=($delivery==1)?"checked='checked'":"";
            echo '<form method="post"><div style="float:left;"><input type="hidden" name="type" value="bludo_update"><input type="hidden" name="parent" value="'.$_POST['parent'].'"><input type="hidden" name="id" value="'.$id.'">*<input name="name" style="width:350px;" title="Название блюда" value="'.$name.'"><input name="weight" class="onlynumbers" title="Выход" value="'.$weight.'"><input name="price" class="onlynumbers" title="Цена" value="'.$price.'"><input type="checkbox" name="vis" title="Видимость" '.$invisible.'><input type="checkbox" name="delivery" title="Доставка" '.$delivery.'>Доставка</div><div style="float:right;"><img style="cursor:pointer;" rel="'.$id.'" class="drop_bludo" title="Удалить блюдо" src="../img/admin/d.png"></div><div style="clear:both;"></div><div style="clear:both;"></div><input name="description" title="Описание" style="width:100%" value="'.$description.'"><div style="clear:both;"></div><div style="float:left;"><input type="file" name="image" accept="image/png,image/jpeg"><input type="button" class="load_image" value="Загрузить фото"><span style="width: 270px;display: inline-block;" class="img_loader_photo"></span><span class="img"></span></div><div style="float:right;"><input type="button" class="update_bludo" value="Обновить"></div><div style="clear:both;"></div></form>';
         }
    break;
}
?>
 
