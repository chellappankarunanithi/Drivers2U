<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
   
   .upper {
   text-transform: uppercase;
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
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Url::base(true)?>/dist/css/select2.css" />
 <script  src="<?php echo Url::base(true)?>/dist/js/select2.js"></script>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
		  <?php $form = ActiveForm::begin(); ?>
            <div class="panel-body   ">

   
<div class="row">

    <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'UserType')->dropDownList(array('Home'=>'Home','Company'=>'Company'),[/*'prompt' => "Select",*/'maxlength' => true])->label('Customer type') ?>
        <div id="customererror" style="color: #e61717;" class="help-block"></div>
    </div>
    <div class='col-sm-3 form-group' >

      
      <label class="form-label company" style="display: none;">Company Name<sub style="color:red; font-size:20px;">*</sub></label> 
      <label class="form-label home" style="display: none;">Customer Name<sub style="color:red; font-size:20px;">*</sub></label> 
        <?= $form->field($model, 'client_name')->textInput(['maxlength' => true])->label(false) ?>
        <div id="customererror" style="color: #e61717;" class="help-block"></div>
    </div>
    <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'mobile_no',['enableAjaxValidation'=>true])->textInput(['maxlength' => 10, 'class'=>'form-control without_decimal12']) ?>
        <div id="mobile_noerror" style="color: #e61717;" class="help-block"></div>
    </div>
    <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">

 <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'Landmark')->textInput(['maxlength' => true]) ?>
        <div id="landmarkerror" style="color: #e61717;" class="help-block"></div>
    </div>
 <div class='col-sm-4 form-group' >
    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
    <div id="addresserror" style="color: #e61717;" class="help-block"></div>
</div>
<div class='col-sm-4 form-group' >
    <?= $form->field($model, 'pincode')->textInput(['maxlength' => 6]) ?>
    <div id="pincodeerror" style="color: #e61717;" class="help-block"></div>
    <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
</div>



</div>
<div class=" ">
     <div class='col-sm-12   pull-right'  >
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
            'template' => "<div class='checkbox checkbox-custom' style='margin-top:10px; margin-left:20px; float:right;'>{input}<label>Active</label></div>{error}",
            ])->checkbox([],false)->label('Status'); ?>  
     
        
  
</div>
</div>
</div>
 
<div class="panel-footer text-right">
 
  <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>  
 
 
</div>

  <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    var vals = $("#clientmaster-usertype").val();
      if (vals=="Home"){
        $(".company").hide();
        $(".home").show();
      }else if(vals=="Company") {
        $(".home").hide();
        $(".company").show();
      }
    $("#clientmaster-usertype").on("change", function() {
      var vals = $(this).val();
      if (vals=="Home"){
        $(".company").hide();
        $(".home").show();
      }else if ("Company") {
        $(".home").hide();
        $(".company").show();
      }
    });
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
  if(e.which === 8){
     return true;
  }else if ((!/^[a-zA-Z\. ]*$/.test(String.fromCharCode(e.which )))) {
        return false;
    }
}); 
         
</script>
