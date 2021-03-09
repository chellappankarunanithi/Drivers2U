<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CancelTripLog */

$this->title = 'Update Cancel Trip Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cancel Trip Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cancel-trip-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
