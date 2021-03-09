<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    
    <div align="center">
        <h1><?= Html::encode($this->title) ?></h1>
        <img src="dist/img/sad.png" style="width:120px;height:120px;">
    </div>
    <div class="alert alert-danger" align="center" style="margin-top:20px;">

       <h3> <?= nl2br(Html::encode($message)) ?> </h3>
    </div>

    <p align="center" style="font-size: 20px;">
        The above error occurred while the Web server was processing your request. <br/>
        Please contact us if you think this is a server error. Thank you.
    </p>
   

</div>
