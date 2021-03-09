<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\DashboardAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use  yii\web\Session;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use backend\models\SwimServiceCentre;
use backend\models\SwimBaranch;
use yii\helpers\ArrayHelper;
use backend\models\SwimBranchServiceCentre;
use common\models\Frontend;



DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  
    <style>
      .modal-header > h3{
        margin-top: 1px;
        margin-bottom: -6px;

    }
    .modal-header > h2{
        margin-top: 1px;
        margin-bottom: -6px;
    }
    /* .content-wrapper{
       background-image: url('control_images/nasa-bg.png');
        background-size: cover;
    }*/
    </style>
</head>
<body class="theme-grey">
<?php $this->beginBody() ?>

<!-- Grid view overflow style -->
 <style>
 .cgridoverlap{
      overflow-x: scroll;
 }
</style>
<?php 
   $session = Yii::$app->session;
   /* $profile = Frontend::find()->select('branch_id')->where(['id'=>$userId])->one();
	$profiles = SwimBaranch::find()->select('branch_name')->where(['branch_autoid'=>$profile])->all();
	foreach($profiles as $result){
			$id=$result->branch_autoid;
		$name=$result->branch_name;
	}
	$profile1 = SwimBranchServiceCentre::find()->select('service_center_id')->where(['branch_id'=>$profile])->one();
	$profile2 = SwimServiceCentre::find()->select('service_center_name')->where(['center_autoid'=>$profile1])->all();
	 foreach($profile2 as $result2){
			
		$centername=$result2->service_center_name;
	}*/
	
?>
<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="md-preloader pl-size-md">
                <svg viewbox="0 0 75 75">
                    <circle cx="37.5" cy="37.5" r="33.5" class="pl-red" stroke-width="4" />
                </svg>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
   

    <?php
    echo Html::a('<i class="fa fa-fw fa-sign-out"></i> <span id="txtOneLogout">Logout</span>', ['index.php/logout'], [
                       'class' => 'highlight-button btn btn-medium button xs-margin-bottom-five',
                       'data' => [
                           'method' => 'post',
                       ],
                       ]);

    ?>
    <?= Url::to('@web/frontend/web/img/user-img.png') ?>
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header" >
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= Url::to('@web/index.php/dashboard') ?>"><img style="margin-top: -12px; margin-left: 0px;" src="<?= Url::to('@web/frontend/web/images/swim_logo1.png') ?>" height="45" alt="Swim" /></a>
            </div>            
             <div class="navbar-header centername">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#"><?php echo $session['servicecenter_name']." : ". $session['branch_name']; ?></a>
            </div>

             <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">account_circle</i>
                         
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href='#' ><i class="material-icons">person</i> Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Edit Profile</a></li>
                            <!-- <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li> -->
                            <!-- <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li> -->
               <!-- <li><a href='<?php echo Yii::$app->homeUrl."?r=users-profile/update&id=".Yii::$app->user->getId(); ?>' ><i class="material-icons">group</i> Edit Profile</a></li>
               <li><a href='<?php echo Yii::$app->homeUrl."?r=users-profile/password&id=".Yii::$app->user->getId(); ?>' ><i class="material-icons">lock</i> Change Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li> -->
                            <li role="seperator" class="divider"></li>
                             <li><?= Html::a('<i class="material-icons">input</i>Log Out', ['index.php/login'], [
                       
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?></li> 
                   <!--  <li>
                        <?php
                        echo '<a>'
                                . Html::beginForm(['index.php/login'], 'post')
                                . Html::submitButton(
                                    '<i class="fa fa-fw fa-sign-out"></i> Logout',
                                    ['class' => 'btn btn-default btn-flat']
                                )
                                . Html::endForm()
                                . '</a>';

                        ?>

                    </li> -->
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                   
                </ul>
            </div>
            
            
        </div>
    </nav>
    <!-- #Top Bar -->

  
    <!-- Left side column. contains the logo and side
      <!-- Content Wrapper. Contains page content -->

     <div align="center"></div>
     <div class="content-wrapper">
      <section class="content" style="margin: 45px 15px 0 315px!important;">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-md-12">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        
    </div>
    </div>
    </section>
    
    </div>
     <?php $this->beginContent('@frontend/views/layouts/fooder.php'); ?>
<?php $this->endContent(); ?>
</div>
<!--
  <footer class="footer">
  
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>-->

<?php 

 $this->endBody() ?>
 </body>
</html>
<?php $this->endPage() ?>