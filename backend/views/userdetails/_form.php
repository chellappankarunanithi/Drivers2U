<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
    background-color: #e67a02 !important;
}
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
             <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Login Username']) ?>
        </div>

        <div class="form-group col-md-6">
        <?php echo $form->field($model, 'password_hash')->passwordInput(['placeholder' => 'Password','value'=>'']); ?>
        </div>    
	</div>

   <div class="box-footer ">
     <div class="col-md-12">
     <div class='col-sm-6 form-group' >
   
      <?php if(isset($_GET['id'])){ 
               echo $form->field($model, 'profile_picture')->fileInput([ 'value'=>$model->profile_picture, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'profile_picture')->fileInput([ 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->profile_picture!=''){ ?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo Url::base(true).'/uploads/'.$model->profile_picture;  ?>" />
      <?php } ?>
    </div>
    <div class=" col-sm-6 form-group" style="margin-top: 15px;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
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