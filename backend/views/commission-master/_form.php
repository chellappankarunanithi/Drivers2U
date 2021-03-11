<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CommissionMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
         	  <div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class='col-sm-4 form-group'>
    <?= $form->field($model, 'CommissionValue',['enableAjaxValidation'=>true])->textInput(['maxlength' => 2,'style'=>'text-align:right;']) ?>
	</div>
	 <div class='col-sm-4 form-group' >
    <?= $form->field($model, 'Status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive']) ?>
    <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
	</div>
	 <div class='col-sm-4 form-group' style="margin-top: 22px;" >
	 	  <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>  
    </div>
</div>

    <?php ActiveForm::end(); ?>
		   </div>
		</div>
	  </div>
    </div>
  </div>