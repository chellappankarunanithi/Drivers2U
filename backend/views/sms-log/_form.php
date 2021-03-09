<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SmsLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tripId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'messageContent')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'driverId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
