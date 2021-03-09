<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AllenOtpLog */

$this->title = 'Create Allen Otp Log';
$this->params['breadcrumbs'][] = ['label' => 'Allen Otp Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allen-otp-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
