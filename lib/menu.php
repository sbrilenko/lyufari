<div style="text-align: center;cursor:default;"><a href='/admin/in' title='выход'>Выход</a></div>

<div class='bottom_menu'>
    <?php if($controller->is('index')) header('location: /admin/menu');?>
    <!--<?=($tut == 'index')? "<span style='cursor:default;'": "<a";?> 
    style='line-height:20px' href='/admin/index' title='Загрузка dbf файлов' <?php echo ($tut == 'index') ? "class='tut'" : ""; ?> >Загрузка dbf файлов
    <?=($tut=='index') ? "</span>" : "</a>";?> |-->
    <?=($tut == 'menu')? "<span style='cursor:default;'": "<a";?> 
    style='line-height:20px' href='/admin/menu' title='Меню' <?php echo ($tut == 'menu') ? "class='tut'" : ""; ?> >Меню
    <?=($tut=='menu') ? "</span>" : "</a>";?>  |
    <?=($tut == 'events')? "<span style='cursor:default;'": "<a";?> 
    style='line-height:20px' href='/admin/event' title='Меню' <?php echo ($tut == 'events') ? "class='tut'" : ""; ?> >События и акции
    <?=($tut=='events') ? "</span>" : "</a>";?> |
    <?=($tut == 'services')? "<span style='cursor:default;'": "<a";?> 
    style='line-height:20px' href='/admin/services' title='Меню' <?php echo ($tut == 'services') ? "class='tut'" : ""; ?> >Услуги
    <?=($tut=='services') ? "</span>" : "</a>";?> 
    
</div>