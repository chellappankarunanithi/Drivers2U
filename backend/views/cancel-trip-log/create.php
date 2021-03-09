<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CancelTripLog */

$this->title = 'Create Cancel Trip Log';
$this->params['breadcrumbs'][] = ['label' => 'Cancel Trip Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancel-trip-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
