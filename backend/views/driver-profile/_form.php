<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DriverProfile */
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
   .checkbox label{padding-left:0;}
   
</style>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
		    <?php $form = ActiveForm::begin(); ?>
            <div class="panel-body">

    
<div class="row">
    <div class='col-sm-4 form-group' >
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
      <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'FatherName')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'MotherName')->textInput(['maxlength' => true]) ?>
    </div>

</div>
<div class="row">
    <div class='col-sm-3 form-group' >
    <?php if ($model->DOB=="0000-00-00" || $model->DOB=="" || $model->DOB==NULL) {
                    echo $form->field($model, 'DOB')->textInput(['maxlength' => true,'class'=>'form-control dob datepicker','placeholder'=>true,'value'=>""]);
                  }else{   
                    $date = date('d-m-Y', strtotime($model->DOB));  //echo $date; die;
                    echo $form->field($model, 'DOB')->textInput(['maxlength' => true,'class'=>'form-control dob datepicker','placeholder'=>true,'value'=>$date]);
                  } ?>
    </div>
      <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'Gender')->dropDownList(['Male'=>'Male','Female'=>'Female','Transgender'=>'Transgender',],array('prompt'=>'--Select--')) ?>
    </div>
    <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'MaritalStatus')->dropDownList(['Single'=>'Single','Married'=>'Married','Widow'=>'Widow'],array('prompt'=>'--Select--')) ?>
    </div>
    <div class='col-sm-3 form-group spouse' style="display: none;" >
        <?= $form->field($model, 'SpouseName')->textInput(['maxlength'=>true]) ?>
    </div>

</div>
<div class="row">
    <div class='col-sm-2 form-group' >
    <?= $form->field($model, 'HouseDetails')->dropDownList(['Own'=>'Own','Rental'=>'Rental','Lease'=>'Lease'],array('prompt'=>'--Select--')) ?>
    </div>
      <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'Qualification')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'PostAppliedFor')->dropDownList(['Parttime'=>'Part Time','Fulltime'=>'Full Time'],array('prompt'=>'--Select--')); ?>
    </div>
      <div class='col-sm-2 form-group' >
        <?= $form->field($model, 'Experience')->textInput(['maxlength' => true]) ?>
    </div>
     <div class='col-sm-2 form-group' >
    <?= $form->field($model, 'BackgroundCheck')->dropDownList(['Yes'=>'Yes','No'=>'No'],array('prompt'=>'--Select--')); ?>
    </div>
</div>
<div class="row">
 
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'LicenceNumber')->textInput(['maxlength' => true]) ?>
    </div>
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'VoteridNumber')->textInput(['maxlength' => true]) ?>
    </div>
     <div class='col-sm-4 form-group' >
     <?= $form->field($model, 'aadhar_no')->textInput(['maxlength' => 16,'class'=>'without_decimal12 form-control']) ?>
</div>

</div>
<div class="row">
   
      <div class='col-sm-3 form-group' >
        <?= $form->field($model, 'mobile_number',['enableAjaxValidation'=>true])->textInput(['maxlength' => 10,'class'=>'without_decimal12 form-control']) ?>
    </div>
  
  <div class='col-sm-5 form-group' >
    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
  </div>
 <div class='col-sm-2 form-group WorkingStatus' style="display: none;">
        <?= $form->field($model, 'workstart_time')->textInput()->label("Work Start Time"); ?>
    </div>
  
  <div class='col-sm-2 form-group WorkingStatus' style="display: none;">
    <?= $form->field($model, 'workend_time')->textInput()->label("Work Start Time");; ?>
  </div>
</div>
  
 
 <?php
             echo  $form->field($model, 'profile_photos')->hiddenInput(['maxlength' => true,'value'=>$model->profile_photo])->label(false);
            echo  $form->field($model, 'licence_copys')->hiddenInput(['maxlength' => true,'value'=>$model->licence_copy])->label(false);
            echo  $form->field($model, 'aadhar_copys')->hiddenInput(['maxlength' => true,'value'=>$model->aadhar_copy])->label(false);
            echo  $form->field($model, 'RationcardCopys')->hiddenInput(['maxlength' => true,'value'=>$model->RationcardCopy])->label(false);
            echo  $form->field($model, 'PoliceVerificationLetterCopys')->hiddenInput(['maxlength' => true,'value'=>$model->PoliceVerificationLetterCopy])->label(false);

  ?>
<div class="row">
    <div class='col-sm-6 form-group' >
   
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'profile_photo')->fileInput([ 'value'=>$model->profile_photo, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'profile_photo')->fileInput([ 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->profile_photo!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo Url::base(true).'/'.$model->profile_photo;  ?>" />
      <?php } ?>
</div>
<div class='col-sm-6 form-group' >
    
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'licence_copy')->fileInput([ 'value'=>$model->licence_copy, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'licence_copy')->fileInput([ 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->licence_copy!=''){?>
            <img id="blah2" class="profile-user-img img-responsive img-circle" src="<?php echo Url::base(true).'/'.$model->licence_copy;  ?>" />
      <?php } ?>
</div>
</div>
<div class="row">
    <div class='col-sm-6 form-group' >

      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'aadhar_copy')->fileInput([ 'value'=>$model->aadhar_copy, 'class' => 'btn btn-primary'])->label('Aadhaar Copy');  
             }else{     ?>                          
             <?= $form->field($model, 'aadhar_copy')->fileInput([ 'class' => 'btn btn-primary'])->label('Aadhaar Copy') ?>
           <?php } 
           if($model->aadhar_copy!=''){?>
            <img id="blah3" class="profile-user-img img-responsive img-circle" src="<?php echo Url::base(true).'/'.$model->aadhar_copy;  ?>" />
      <?php } ?>
</div>
<div class='col-sm-6 form-group' >
    
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'RationcardCopy')->fileInput([ 'value'=>$model->RationcardCopy, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'RationcardCopy')->fileInput([ 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->RationcardCopy!=''){?>
            <img id="blah4" class="profile-user-img img-responsive img-circle" src="<?php echo Url::base(true).'/'.$model->RationcardCopy;  ?>" />
      <?php } ?>
</div>
</div>
   <div class="row">
      <div class='col-sm-6 form-group' > 
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'PoliceVerificationLetterCopy')->fileInput([ 'value'=>$model->PoliceVerificationLetterCopy, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'PoliceVerificationLetterCopy')->fileInput([ 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->PoliceVerificationLetterCopy!=''){?>
            <img id="blah4" class="profile-user-img img-responsive img-circle" src="<?php echo Url::base(true).'/'.$model->PoliceVerificationLetterCopy;  ?>" />
        <?php } ?>
      </div>   
         <div class='col-sm-6 form-group' style="margin-top: 0px;">
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
           
          <?php  if($model->isNewRecord==true){  echo $form->field($model, 'status', [
            'template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
            ])->checkbox([],false)->label('Status'); } ?>  
 
      
    </div>
   </div>

    

</div>
<div class="panel-footer text-right">
  <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success  ' : 'btn btn-primary  ']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
  $(function() {
    $('#driverprofile-dob').datetimepicker({ format: 'DD-MM-YYYY',maxDate: new Date()});
    $('#driverprofile-workstart_time').datetimepicker({ format: 'hh:mm:ss A'});
    $('#driverprofile-workend_time').datetimepicker({ format: 'hh:mm:ss A'});
});

  $status = $('#driverprofile-postappliedfor').val();
      if ($status=='Parttime') {
        $('.WorkingStatus').show();
      }else{
        $('.WorkingStatus').hide();
      }
      
   $('#driverprofile-postappliedfor').on('change', function() {
      $status = $(this).val();
      if ($status=='Parttime') {
        $('.WorkingStatus').show();
      }else{
        $('.WorkingStatus').hide();
      }
  });


  $status = $('#driverprofile-maritalstatus').val();
      if ($status=='Married') {
        $('.spouse').show();
      }else{
        $('.spouse').hide();
      }


   $('#driverprofile-maritalstatus').on('change', function() {
      $status = $(this).val();
      if ($status=='Married') {
        $('.spouse').show();
      }else{
        $('.spouse').hide();
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

 $("#driverprofile-name").on("keypress", function(e) { 
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