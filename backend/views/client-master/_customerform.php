<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\SuperviserMaster;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\ClientMaster */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
   .score {
   background-color: #0c9cce;
   color: #fff;
   font-weight: 600;
   border-radius: 50%;
   width: 40px;
   height: 40px;
   line-height: 40px;
   text-align: center;
   margin: auto;
   /* padding: 21% 14%;*/
   }
   .checkbox input[type="checkbox"] {
   cursor: pointer;
   opacity: 0;
   z-index: 1;
   outline: none !important;
   }
   .upper {
   text-transform: uppercase;
   }
   .checkbox-custom input[type="checkbox"]:checked + label::before {
   background-color: #5fbeaa;
   border-color: #5fbeaa;
   }
   .checkbox label::before {
   -o-transition: 0.3s ease-in-out;
   -webkit-transition: 0.3s ease-in-out;
   background-color: #ffffff;
   /* border-radius: 3px; */
   border: 1px solid #cccccc;
   content: "";
   display: inline-block;
   height: 17px;
   left: 0!important;
   margin-left: -20px!important;
   position: absolute;
   transition: 0.3s ease-in-out;
   width: 17px;
   outline: none !important;
   }
   .checkbox input[type="checkbox"]:checked + label::after {
   content: "\f00c";
   font-family: 'FontAwesome';
   color: #fff;
   position: relative;
   right: 59px;
   bottom: 1px;
   }
   .checkbox label {
   display: inline-block;
   padding-left: 5px;
   position: relative;
   }

   .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #f4f4f4!important;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #129cec !important;
    border: 1px solid #aaa;
    }
</style>
<link rel="stylesheet" type="text/css" media="screen" href="dist/css/select2.css" />
 <script  src="dist/js/select2.js"></script>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
     <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'client_name')->textInput(['maxlength' => true])->label('Customer Name') ?>
    </div>
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => 10, 'class'=>'form-control without_decimal12']) ?>
    </div>
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
    </div>
</div>
<div class="row">

 <div class='col-sm-4 form-group' >
    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
</div>
<div class='col-sm-4 form-group' >
    <?= $form->field($model, 'pincode')->textInput(['maxlength' => 6]) ?>
</div>


<div class='col-sm-4 form-group' style="margin-top: 25px;">
         <?php 
          if($model->isNewRecord){
          $model->status = 1;
          }else{
            if($model->status=="Active"){
              $model->status = 1;
            }else{
              $model->status = 0;
            }
          } ?> 
         <?= $form->field($model, 'status', [
            'template' => "<div class='checkbox checkbox-custom' style='margin-top:10px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
            ])->checkbox([],false)->label('Status'); ?>  
     
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?> 
    <?php ActiveForm::end(); ?>
</div>

</div>
<div class="row">
     
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    $(".without_decimal12").on("input", function(evt) {
    
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
 });  

  $("#clientmaster-pincode").on("input", function(evt) {
    
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
 });

   
  $("#clientmaster-client_name").on("keypress", function(e) { 
   /*if (!/[a-z]/i.test(String.fromCharCode(e.which))) {
        return false;
    }*/
  if(e.which === 8){
     return true;
  }else if ((!/^[a-zA-Z\. ]*$/.test(String.fromCharCode(e.which )))) {
        return false;
    }
});

           
 
         
</script>
