<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AllenApiLog */

$this->title = 'Update Allen Api Log: ' . $model->autoid;
$this->params['breadcrumbs'][] = ['label' => 'Allen Api Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->autoid, 'url' => ['view', 'id' => $model->autoid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allen-api-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
