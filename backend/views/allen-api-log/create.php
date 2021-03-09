<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AllenApiLog */

$this->title = 'Create Allen Api Log';
$this->params['breadcrumbs'][] = ['label' => 'Allen Api Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allen-api-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
