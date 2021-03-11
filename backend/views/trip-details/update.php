<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */

$this->title = 'Update Trip Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trip Details', 'url' => ['trip-index']]; 
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trip-details-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
