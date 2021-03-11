<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */

$this->title = 'Create Trip Details';
$this->params['breadcrumbs'][] = ['label' => 'Trip Details', 'url' => ['trip-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-details-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
