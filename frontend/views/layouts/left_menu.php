<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\SwimServiceAdvisor;
use backend\models\SwimBranchAdmin;
use yii\helpers\ArrayHelper;

use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

use backend\models\SwimServiceAdvisorSearch;


/* @var $this yii\web\View */
/* @var $model backend\models\UserRole */
/* @var $form yii\widgets\ActiveForm */
// $news_details = SwimServiceAdvisor::find()->where(['sa_status'=>'A'])->all();   
$news_details = SwimServiceAdvisor::find()->all();  
//print_r($news_details);

$session = Yii::$app->session;
$branchid = $session['branch_id'];

$branchadmin = SwimBranchAdmin::find()->where(['ba_branchid'=>$branchid])->one();
$ba_name=$branchadmin->ba_name;
?>

<?php $searchModel = new SwimServiceAdvisorSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider1 = $searchModel->search3(Yii::$app->request->queryParams);

        ?>

<?php $menu_data_array = array();
$menu_data_array[0] = '';

$menu_data_array[1]=array('more','User Account','#','<i class="fa fa-fw fa-building"></i>','');


$menu_data_array[1]['sub'][0]=array('View User',Yii::$app->homeUrl.'?r=user-account','<i class="fa fa-fw fa-plus"></i>','swim-service-centre','create');
$menu_data_array[1]['sub'][1]=array('Add User',Yii::$app->homeUrl.'?r=user-account/create','<i class="fa fa-fw fa-table"></i>','swim-service-centre','swim-service-centre');		  


$menu_data_array[2]=array('more','Branch Management','#','<i class="fa fa-fw fa-cube"></i>','swim-baranch');
$menu_data_array[2]['sub'][0]=array('View',Yii::$app->homeUrl.'?r=branch-management','<i class="fa fa-fw fa-plus"></i>','swim-baranch','create');
$menu_data_array[2]['sub'][1]=array('Add Branch Detail',Yii::$app->homeUrl.'?r=branch-management/create','<i class="fa fa-fw fa-table"></i>','swim-baranch','swim-baranch');		  

$menu_data_array[3]=array('more','User Profile','#','<i class="fa fa-fw fa-user"></i>','swim-branch-admin');
$menu_data_array[3]['sub'][0]=array('View User Profle',Yii::$app->homeUrl.'?r=user-profile','<i class="fa fa-fw fa-plus"></i>','swim-branch-admin','crate');
$menu_data_array[3]['sub'][1]=array('Add User',Yii::$app->homeUrl.'?r=user-profile/create','<i class="fa fa-fw fa-table"></i>','swim-branch-admin','swim-branch-admin');		  

/*
$menu_data_array[1]=array('more','Service centre','#','<i class="fa fa-fw fa-building"></i>','');


$menu_data_array[1]['sub'][0]=array('Add Service centre',Yii::$app->homeUrl.'?r=swim-service-centre/create','<i class="fa fa-fw fa-plus"></i>','swim-service-centre','create');
$menu_data_array[1]['sub'][1]=array('Managa Service centre',Yii::$app->homeUrl.'?r=swim-service-centre','<i class="fa fa-fw fa-table"></i>','swim-service-centre','swim-service-centre');		  

$menu_data_array[2]=array('more','Branch','#','<i class="fa fa-fw fa-cube"></i>','swim-baranch');
$menu_data_array[2]['sub'][0]=array('Add Branch centre',Yii::$app->homeUrl.'?r=swim-baranch/create','<i class="fa fa-fw fa-plus"></i>','swim-baranch','create');
$menu_data_array[2]['sub'][1]=array('Managa Branch',Yii::$app->homeUrl.'?r=swim-baranch','<i class="fa fa-fw fa-table"></i>','swim-baranch','swim-baranch');		  

$menu_data_array[3]=array('more','Branch admin','#','<i class="fa fa-fw fa-user"></i>','swim-branch-admin');
$menu_data_array[3]['sub'][0]=array('Add Branch admin',Yii::$app->homeUrl.'?r=swim-branch-admin/create','<i class="fa fa-fw fa-plus"></i>','swim-branch-admin','crate');
$menu_data_array[3]['sub'][1]=array('Managa Branch admin',Yii::$app->homeUrl.'?r=swim-branch-admin','<i class="fa fa-fw fa-table"></i>','swim-branch-admin','swim-branch-admin');		  

$menu_data_array[4]=array('more','Service Advisor','#','<i class="fa fa-fw fa-tripadvisor"></i>','swim-service-advisor');
$menu_data_array[4]['sub'][0]=array('Add Service Advisor',Yii::$app->homeUrl.'?r=swim-service-advisor/create','<i class="fa fa-fw fa-plus"></i>','swim-service-advisor','crate');
$menu_data_array[4]['sub'][1]=array('Managa Service Advisor',Yii::$app->homeUrl.'?r=swim-service-advisor','<i class="fa fa-fw fa-table"></i>','swim-service-advisor','swim-service-advisor');		  

$menu_data_array[5]=array('one','SWiM',Yii::$app -> homeUrl . '?r=swim-customer','<i class="fa fa-fw fa-history"></i>','swim-customer');  
*/

/*
$menu_data_array[1] = array('more', 'Staff Management', '-', '<i class="fa fa-user"></i>', 'user-data');
// $menu_data_array[1]['sub'][0]=array('Rights Management',Yii::$app->homeUrl.'?r=rights','<i class="fa fa-fw fa-check-circle-o"></i>','rights','rights');
$menu_data_array[1]['sub'][0] = array('Add New Staff', Yii::$app -> homeUrl . '?r=user-data/create', '<i class="fa fa-fw fa-user-plus"></i>', 'user-data', 'create');
$menu_data_array[1]['sub'][1] = array('Manage Staffs', Yii::$app -> homeUrl . '?r=user-data', '<i class="fa fa-fw fa-street-view"></i>', 'user-data', 'user-data');


$menu_data_array[6]=array('one','Log Reports',Yii::$app -> homeUrl . '?r=log-details','<i class="fa fa-fw fa-history"></i>','log-details');  */

$html_menu_out = '';
$controler_url_id = Yii::$app -> controller -> id;
$active_url_id = Yii::$app -> controller -> action -> id;
$html_menu_out_tmp = $controler_url_id . "/" . $active_url_id;
//$html_menu_out .= $html_menu_out_tmp;
foreach ($menu_data_array as $one_ig => $one_menus) {//echo "<pre>";print_r($one_menus);
	if (count($one_menus) > 0) {
		if ($one_menus[0] == 'more') {
			$isselct = '';
			if ($controler_url_id == $one_menus[4]) {$isselct = 'active';
			}//echo $isselct;
			$html_menu_out2 = '<ul  class="ml-menu">';
			foreach ($one_menus['sub'] as $one_submenus) {
				$isactive = '';
				if ($active_url_id == "index") {
					if ($active_url_id == $one_submenus[4] || $controler_url_id == $one_submenus[4]) {
						$isactive = 'class="active"';
						if ($isselct == '') {
							$isselct = 'active';
						}
					}
				} else {
					if ($active_url_id == $one_submenus[4]) {$isactive = 'class="active"';
					}
				}
				$html_menu_out2 .= '<li ' . $isactive . '><a href="' . $one_submenus[1] . '">' . $one_submenus[2] . '' . $one_submenus[0] . '</a></li>';
			}
			$one_menus[3] ='<i class="material-icons">layers</i>';
			$html_menu_out1 = '<li ' . $isselct . '"><a href="javascript:void(0);" class="menu-toggle">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span></a>';
			$html_menu_out2 .= '</ul></li>';
			$isselct = '';
			$html_menu_out .= $html_menu_out1 . $html_menu_out2;
		} elseif ($one_menus[0] == 'one') {
			$isselct = '';
			if ($active_url_id == "index") {
				if ($controler_url_id == $one_menus[4] || $active_url_id == $one_menus[4]) {$isselct = 'active';
				}
			} else {
				if ($html_menu_out_tmp == $one_menus[4]) {$isselct = 'active';
				}
				//if($controler_url_id==$one_menus[4]){$isselct='active';}
			}			
			$html_menu_out .= '<li ' . $isselct . '"> 
		              <a href="' . $one_menus[2] . '">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span></a></li>';

		}

	}
}
?>  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">               
  
    <section>

        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
             
            <!-- #User Info -->
            <!-- Menu -->
            <?php
      //       $command = Yii::$app->db->createCommand("SELECT ba_name FROM swim_branch_admin WHERE ba_branchid = ".$branchid);

      // $advisor = $command->queryScalar();

            ?>
            
            <div class="menu">
                <ul class="list">
				<!-- <li class="header">MAIN NAVIGATION</li> -->
                	<?php //echo $html_menu_out; ?>  

                    <?php Pjax::begin(); ?> <div align="center">
                    <div class=" header block-header"> 
                   
                    <h2> AVAILABLE ADVISORS</h2>

                    </div>
                    </div> <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->customer_autoid), ['view', 'id' => $model->customer_autoid]);
        },*/
        'itemView' => 'listserviceadvisor',





    ]) ?>

<?php Pjax::end(); ?>   

<?php Pjax::begin(); ?> <div align="center"><div class=" header block-header"> <h2>UNAVAILABLE ADVISORS</h2></div></div>   <?= ListView::widget([
        'dataProvider' => $dataProvider1,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->customer_autoid), ['view', 'id' => $model->customer_autoid]);
        },*/
        'itemView' => 'listserviceadvisor',





    ]) ?>

<?php Pjax::end(); ?>    
                    
                        
                </ul>
                <ul>
                    
                    <li style="display: block;height:100px;"></li>
                    
                    
                </ul>



            </div>
            
            


              <!-- <div class="legal">
                <div class="copyright">
                    &copy; 2016 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.3
                </div>
            </div> -->
            <!-- #Menu -->          
        </aside>
        <!-- #END# Left Sidebar -->        
    </section>

    
 