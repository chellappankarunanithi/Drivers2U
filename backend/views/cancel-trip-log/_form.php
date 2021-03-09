<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CancelTripLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cancel-trip-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TripId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CustomerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DriverId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CancelFees')->textInput() ?>

    <?= $form->field($model, 'CancelReason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PaymentStatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreatedDate')->textInput() ?>

    <?= $form->field($model, 'UpdatedIpaddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UpdatedDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
