<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\DashboardAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use  yii\web\Session;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\Model; 


DashboardAsset::register($this);

$session = Yii::$app->session; 
$service_center='';
/*if($user_data){
$service_center=$user_data->service_center_name;
}*/
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode("DRIVES2U") ?></title>
    <?php $this->head() ?>
  
    <style>
    .skin-purple-light .main-header .navbar {
		    background-color: #15167e !important;
	}
	.skin-purple-light .main-header li.user-header {
    background-color: #15167e !important;
	}
      .modal-header > h3{
        margin-top: 1px;
        margin-bottom: -6px;

    }
    .modal-header > h2{
        margin-top: 1px;
        margin-bottom: -6px;
    }
	
	.skin-purple-light .sidebar-menu>li:hover>a, .skin-purple-light .sidebar-menu>li.active>a {
    color: #fff;
    background: #e67a02;
}



    .skin-purple-light .main-header .navbar {
    background-color: #15167e;
}

.skin-purple-light .main-header .logo {
    background-color: #15167e;
    color: #fff;
    border-bottom: 0 solid transparent;
}
.skin-purple-light .main-header li.user-header {
    background-color: #15167e;
}
.skin-purple-light .main-header .logo:hover {
        background-color: #f39c12; 
}
.skin-purple-light .main-header .navbar .sidebar-toggle:hover {
    background-color: #15167e;
}
    /* .content-wrapper{
       background-image: url('control_images/nasa-bg.png');
        background-size: cover;
    }*/
    </style>
</head>
<body class="hold-transition skin-purple-light sidebar-mini">
<?php $this->beginBody() ?>

<!-- Grid view overflow style -->
 <style>
 .cgridoverlap{
      overflow-x: scroll;
 }
 
</style>
<?php 
   $session = Yii::$app->session;
?>
<div class="wrapper">
     <header class="main-header">
        <!-- Logo -->
        <!-- <a href="<?= Yii::$app->homeUrl ?>" class="logo"> -->
         <a class="logo" href="<?= Yii::$app->homeUrl ?>">
         <span class="logo-mini" style=" margin-top: -15px; margin-left: -15px;"><img src="<?php echo Url::base(true)?>/images/logo.png" width="50px;" height="50px;" style="margin-top: 15px;"></span>
           <span class="logo-lg"><b>DRIVES2U</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
         
        <span style="color:white;padding:40px;font-size:20px;"><b><?php echo $service_center;?></b></span>

          <div class="navbar-custom-menu">  

            <ul class="nav navbar-nav"> 
                  
              <!-- Chat Message View End  -->    
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo Url::base(true)?>/images/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo  $session['user_name'];  ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo Url::base(true)?>/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                     <?php echo  $session['user_name'];  ?>
                      
                    </p>
                  </li>
                  <!-- Menu Body -->
                    
                    
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left"> 
                    </div>
                    <div class="pull-right">                  
					<?php  if (Yii::$app->user->isGuest) {
					       echo  ['label' => 'Sign out', 'url' => ['/site/login']];
					    } else {
					        echo '<a>'
					            . Html::beginForm(['/site/logout'], 'post')
					            . Html::submitButton(
					                '<i class="fa fa-fw fa-sign-out"></i> Logout',
					                ['class' => 'btn btn-default btn-flat']
					            )
					            . Html::endForm()
					            . '</a>';
					    } ?>
                    </div>
                  </li>
                </ul>
              </li>
            
            </ul>
          </div>
        </nav>
      </header>
       
    <!-- Left side column. contains the logo and sidebar -->      
 	<?php  echo $this->render('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
     
     <div class="content-wrapper">
     	<section class="content">
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
     <?php $this->beginContent('@backend/views/layouts/footer.php'); ?>
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
