<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\DropdownManagement;
/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    
    .box-header {
    color: #fff;
    background-color: #ff0000;
</style>
<section class="content">
<!-- Info boxes -->
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
            <div class="box-header with-border">
                     <h3 class="box-title"><?= $model->isNewRecord ? '<i class="fa fa-fw fa-user-plus"></i>' : '<i class="fa fa-fw fa-user"></i>' ?>  <?= Html::encode($this->title) ?></h3>
              </div><!-- /.box-header -->
<div class="userdetails-form">
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">

    <div class="form-group col-md-6">
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name']) ?>
    </div>
        <div class="form-group col-md-6">

	<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name']) ?>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group col-md-6">
	<?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'placeholder' => 'Designation']) ?>
	</div>
	<div class="form-group col-md-6">
	<?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true, 'placeholder' => 'Mobile Number']) ?>
	</div>
	</div>
	<div class="col-md-12">
	  <div class="form-group col-md-6">
	 <?php $list1 = ArrayHelper::map(DropdownManagement::find()->where(['dropdown_key' => 'user_level'])->orderBy('dropdown_order')->all(), 'dropdown_id', 'dropdown_value'); ?>
	<?= $form->field($model, 'user_level')->dropDownList($list1, ['prompt' => 'Select']) ?>
		</div>
	 <div class="form-group col-md-6">

	<?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'City']) ?>
	</div>
	</div>
	<div class="col-md-12">
	</div>

	 <div class="col-md-12">
	    <div class="form-group col-md-6">

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login Username']) ?>
    </div>
  <!--  	    <div class="form-group col-md-4">

    <?php //echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email id']) ?>
    </div> -->

    <div class="form-group col-md-6">
    <?php echo $model->isNewRecord ?$form->field($model, 'password_hash')->passwordInput(['placeholder' => 'Password','value'=>'']) : ''; ?>
    <?php //echo  $form->field($model, 'password_hash')->passwordInput(['placeholder' => 'Password','value'=>'']) ?>
    </div>    
	</div>

   <div class="box-footer pull-right">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
</div>
</div>
</div>
</section>



<script type="text/javascript">
    $(".datepicker").datepicker();
    </script>