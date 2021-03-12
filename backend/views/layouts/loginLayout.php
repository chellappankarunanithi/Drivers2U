<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
    .login-box, .register-box {
          width: 360px;
          margin: 25% auto;
        }
    .navbar-inverse {
        background-color: #0d62ae !important;
        border-color: #080808;
    }
    .login-page{background-color:#000;}
    .navbar-inverse {
         background-color: rgba(247, 247, 247, 0) !important;
        border-color: rgba(230, 234, 235, 0);
    }

    .wrap > .container {
    /*  padding: 61px 15px 20px !important; */
    }
  /*  .wrap{
        background-image: url('nasalogo2.png');
        background-size: cover;

    }*/
    .login-box-body, .register-box-body {
   /*  background: rgba(26, 25, 21, 0.95) !important; */
   background-color:#1f1e1e;
  
   
    }
    .wrap > .container{padding:15px;}


    .footer {
    height: 60px;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    padding-top: 20px;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
}
    </style>
</head>
<body class="hold-transition login-page" style=" background-image: url('images/lo go.png'); background-repeat: no-repeat; background-position: 50% 17%;opacity: 0.9;">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    /*NavBar::begin([
        'brandLabel' => '',//My Company
        'brandUrl' => '',//Yii::$app->homeUrl
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],

    ]);
   /* $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
      //  $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => '', 'url' => []];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([

        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end(); */
    ?>

    <div class="container">      
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= date('Y') ?> Drives2u.</strong>     All rights reserved.</p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
