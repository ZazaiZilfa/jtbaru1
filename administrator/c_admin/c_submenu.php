<?php
$submenu = query("SELECT usm.*,um.menu FROM user_sub_menu as usm JOIN user_menu as um ON usm.menu_id = um.id ORDER BY usm.id ASC ");
$menu = query("SELECT menu,id FROM user_menu");
