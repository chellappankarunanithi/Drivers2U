<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'contact_person') ?>

    <?= $form->field($model, 'contact_person_designation') ?>

    <?= $form->field($model, 'company_contact_no') ?>

    <?php // echo $form->field($model, 'company_email') ?>

    <?php // echo $form->field($model, 'company_address') ?>

    <?php // echo $form->field($model, 'personal_contact_no') ?>

    <?php // echo $form->field($model, 'personal_email') ?>

    <?php // echo $form->field($model, 'personal_address') ?>

    <?php // echo $form->field($model, 'company_pincode') ?>

    <?php // echo $form->field($model, 'personal_pincode') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_ipaddress') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
