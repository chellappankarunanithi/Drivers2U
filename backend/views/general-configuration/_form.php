<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GeneralConfiguration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="general-configuration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'config_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'config_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'modified_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
