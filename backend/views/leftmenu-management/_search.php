<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LeftmenuManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leftmenu-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'menuId') ?>

    <?= $form->field($model, 'menuTpe') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'userUrl') ?>

    <?= $form->field($model, 'groupId') ?>

    <?php // echo $form->field($model, 'groupCode') ?>

    <?php // echo $form->field($model, 'sortOrder') ?>

    <?php // echo $form->field($model, 'faIcon') ?>

    <?php // echo $form->field($model, 'activeStatus') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
