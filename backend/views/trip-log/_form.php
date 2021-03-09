<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TripLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trip-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tripId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tripStatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tripDetails')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'createdAt')->textInput() ?>

    <?= $form->field($model, 'updatedAt')->textInput() ?>

    <?= $form->field($model, 'updatedIpAddress')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
