<?php

$session = Yii::$app->session;
$session['user_logintype'];	

 $menu_data_array = array();
 if($session['user_logintype']=='T1')
 {
$menu_data_array[0] = array('one', 'Dashboard', Yii::$app -> homeUrl, '<i class="fa fa-dashboard"></i>', 'index');

$menu_data_array[1] = array('one', 'Customer Management', Yii::$app -> homeUrl.'customer-management', '<i class="fa fa-user"></i>', 'customer-management');

$menu_data_array[2] = array('one', 'Driver Management', Yii::$app -> homeUrl.'driver-management', '<i class="fa fa-users"></i>', 'driver-management');

$menu_data_array[3] = array('one', 'Trip Management', Yii::$app -> homeUrl.'trip-index', '<i class="fa fa-car"></i>', 'trip-index');



}
$html_menu_out = '';
$controler_url_id = Yii::$app ->controller->id;
$active_url_id = Yii::$app ->controller->action->id;	
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$session = Yii::$app->session;
$actual_link = explode('admin/', $actual_link);
// echo "<prE>";print_r($actual_link);die;
$actualUrl = '';
if(!empty($actual_link)){
	if(array_key_exists(1, $actual_link)){
		$actualUrl = $actual_link[1];
	}
}
$html_menu_out_tmp = $controler_url_id . "/" . $active_url_id;
foreach ($menu_data_array as $one_ig => $one_menus) {//echo "<pre>";print_r($one_menus);
	if (count($one_menus) > 0) {
		if ($one_menus[0] == 'more') {
			$isselct = '';
			if ($controler_url_id == $one_menus[4]) {$isselct = 'active';
			}//echo $isselct;
			$html_menu_out2 = '<ul class="treeview-menu">';
			foreach ($one_menus['sub'] as $one_submenus) {
				$isactive = '';
				if ($active_url_id == "index") {
					if ($actualUrl == $one_submenus[4]) {
						$isactive = 'class="active"';
						if ($isselct == '') {
							$isselct = 'active';
						}
					}
				} else {
					if ($actualUrl == $one_submenus[4]) {$isactive = 'class="active"';
					}
				}
				$html_menu_out2 .= '<li ' . $isactive . '><a href="' . $one_submenus[1] . '">' . $one_submenus[2] . '' . $one_submenus[0] . '</a></li>';
			}
			$html_menu_out1 = '<li class="treeview' . $isselct . '"><a href="#">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span><i class="fa fa-angle-left pull-right"></i></a>';
			$html_menu_out2 .= '</ul></li>';
			$isselct = '';
			$html_menu_out .= $html_menu_out1 . $html_menu_out2;
		} elseif ($one_menus[0] == 'one') {

			// echo "<pre>";print_r($controler_url_id);die;
				// echo "<pre>";print_r($actualUrl);die;
			$isselct = '';
			if ($active_url_id == "index") {
				if ($actualUrl == $one_menus[4]) {$isselct = 'active';
				}
			} else {
				if ($actualUrl == $one_menus[4]) {$isselct = 'active';
				}
			}
			$html_menu_out .= '<li class="treeview ' . $isselct . '"> 
		              <a href="' . $one_menus[2] . '">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span></a></li>';
		}elseif ($one_menus[0] == 'hr') {
			$html_menu_out .= '<li class="treeview"><div style="width:100%;border-top:1px solid #444;opacity:0.5;"></div></li>';
		}
	}
}
?>
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel
<div class="user-panel">
<div class="pull-left image">
<img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
</div>
<div class="pull-left info">
<p>Alexander Pierce</p>
<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
</div>
</div>-->
<!-- search form
<form action="#" method="get" class="sidebar-form">
<div class="input-group">
<input type="text" name="q" class="form-control" placeholder="Search...">
<span class="input-group-btn">
<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
</span>
</div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
<?php echo $html_menu_out; ?>

</ul>
</section>
<!-- /.sidebar -->
</aside>