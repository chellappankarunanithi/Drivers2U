<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TripLog */

$this->title = 'Update Trip Log: ' . $model->logId;
$this->params['breadcrumbs'][] = ['label' => 'Trip Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->logId, 'url' => ['view', 'id' => $model->logId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trip-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
