<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CancelTripLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cancel-trip-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'TripId') ?>

    <?= $form->field($model, 'CustomerId') ?>

    <?= $form->field($model, 'DriverId') ?>

    <?= $form->field($model, 'CancelFees') ?>

    <?php // echo $form->field($model, 'CancelReason') ?>

    <?php // echo $form->field($model, 'PaymentStatus') ?>

    <?php // echo $form->field($model, 'CreatedDate') ?>

    <?php // echo $form->field($model, 'UpdatedIpaddress') ?>

    <?php // echo $form->field($model, 'UpdatedDate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
