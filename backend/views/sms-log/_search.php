<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SmsLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'logId') ?>

    <?= $form->field($model, 'tripId') ?>

    <?= $form->field($model, 'customerId') ?>

    <?= $form->field($model, 'event') ?>

    <?= $form->field($model, 'messageContent') ?>

    <?php // echo $form->field($model, 'driverId') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
