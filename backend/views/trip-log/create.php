<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TripLog */

$this->title = 'Create Trip Log';
$this->params['breadcrumbs'][] = ['label' => 'Trip Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
