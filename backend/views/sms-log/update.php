<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SmsLog */

$this->title = 'Update Sms Log: ' . $model->logId;
$this->params['breadcrumbs'][] = ['label' => 'Sms Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->logId, 'url' => ['view', 'id' => $model->logId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sms-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
