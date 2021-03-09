<?php

/* @var $this \yii\web\View */
/* @var $content string */ 
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use backend\assets\ThemeAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\LeftmenuManagement;
use backend\models\IntegratedFunctionMenuMapping;
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$session = Yii::$app->session;
$actual_link = explode('admin/', $actual_link);
$urlKey = "";
if(!empty($actual_link)){
    if(array_key_exists('1', $actual_link)){
        if(empty($actual_link['1'])){
            $actual_link['1'] = "index";
        }
        if(!empty($actual_link['1'])){
            $urlKey = $actual_link['1'];
            if(strpos($urlKey, '/')){
                $new = explode('/', $urlKey);
                if(!empty($new)){
                    $urlKey = "";
                    $count = count($new);
                    for ($i=0; $i < $count; $i++) { 
                        if(!is_numeric($new[$i])){
                            if($i>0){
                                $urlKey .= '/';
                            }
                            $urlKey .= $new[$i];

                        }
                    }
                }
            }            
        }
    }
}

$userType = $session['user_type'];
$cntsAr = array();


$isMenuMapped = IntegratedFunctionMenuMapping::find()->where(['LIKE','url','%'.$urlKey, false])->asArray()->one();

$activeMenuId = $activeGroupId = "";
if(!empty($isMenuMapped)){
    $activeMenuId = $isMenuMapped['menuId'];
    $activeGroupId = $isMenuMapped['groupId'];
}

$roleId = "";
if(isset($session['roleId'])){
    $roleId = $session['roleId'];
}


$menuFor = 'admin';

$leftMenuData = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuFor'=>$menuFor])->andWhere(['IN','menuTpe',array('group','menu')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

// echo "<pre>";print_r($leftMenuData);die;

$leftMenuDataSub = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuFor'=>$menuFor])->andWhere(['menuTpe'=>'submenu'])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();
$leftMenuDataSub = ArrayHelper::index($leftMenuDataSub,'menuId','groupId');


$returnContent = '';
$returnContent .= '<aside class="main-sidebar">';
$returnContent .= ' <section class="sidebar" style="height: auto;">
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
                '; 
                if(!empty($leftMenuData)){
                    foreach ($leftMenuData as $key => $oneData) {
                        if($oneData['menuTpe']=='menu'){                              
                            $isActive = "";
                            if($activeMenuId==$oneData['menuId']){
                                $isActive = "active";
                            }
                            $returnContent .= '
                                <li class="treeview '.$isActive.'"> 
                                    <a href="'.Url::base(true).'/'.$oneData['userUrl'].'">
                                        <i class="'.$oneData['faIcon'].'"></i>
                                        <span>'.$oneData['Name'].'</span>
                                    </a>
                                </li>
                            ';        
                        }else if($oneData['menuTpe']=='group'){
                            $expend = $isMenuOpen = "";
                            $displayOption = 'none';
                            if($activeGroupId==$oneData['menuId']){ 
                                $expend = "active";
                                $isMenuOpen = 'menu-open';
                                $displayOption = "block";
                            }
                            $returnContent .= '
                                <li class="treeview '.$expend.' '.$expend.' ">
                                    <a href="#"><i class="'.$oneData['faIcon'].'"></i>
                                        <span>'.$oneData['Name'].'</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu '.$isMenuOpen.'" style="display: '.$displayOption.';">
                                    ';
                                    if(array_key_exists($oneData['menuId'], $leftMenuDataSub) && !empty($leftMenuDataSub[$oneData['menuId']])){
                                        foreach ($leftMenuDataSub[$oneData['menuId']] as $key => $oneSubMenu) {
                                            $isActive = "";
                                            if($activeMenuId==$oneSubMenu['menuId']){
                                                $isActive = "active";
                                            }

                                            $returnContent .= '
                                            <li class="'.$isActive.'">
                                                <a href="'.Url::base(true).'/'.$oneSubMenu['userUrl'].'"><i class="'.$oneSubMenu['faIcon'].'"></i>'.$oneSubMenu['Name'].'</a>
                                            </li>';
                                        }                                        
                                    }
                                    $returnContent .= '
                                    </ul>
                                </li>
                            ';
                        }
                    }
                }
            $returnContent .= '
            </ul>
        </section>
    </aside>';
echo $returnContent;
?>

<style type="text/css">
    .treeview.active a{
        background-color: #ecf0f5!important;
    }

</style>