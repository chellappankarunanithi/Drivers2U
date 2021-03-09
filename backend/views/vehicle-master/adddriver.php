<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
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
</style>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">

    <?php $form = ActiveForm::begin([
                                  'id' => 'payufomx',
                                   'enableClientValidation' => true, 
                                  'enableAjaxValidation' => false,
                                  'options' => ['enctype' => 'multipart/form-data',
                                ],
                                  
                              ]); ?>
<div class="row">
    <div class='col-sm-6 form-group' >
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</div>
  <div class='col-sm-6 form-group' >
    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true]) ?>
     <input type="hidden" id="ror" style="color:red;margin-top: -5px;" /> <div id="error" style="color:##a94442;margin-top: -5px; display: none;">This Employee Id Has Been Already Taken.</div>
</div>
</div>
<div class="row">
    <div class='col-sm-4 form-group' >
    <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => 10,'class'=>'without_decimal12 form-control']) ?>
</div>
<div class='col-sm-4 form-group' >
     <?= $form->field($model, 'aadhar_no')->textInput(['maxlength' => 16,'class'=>'without_decimal12 form-control']) ?>
</div>
<div class='col-sm-4 form-group' >
     <?= $form->field($model, 'pancard_no')->textInput(['maxlength' => 10,'class'=>'form-control']) ?>
</div>
  
</div>
<div class="row">
<div class='col-sm-6 form-group' >
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
</div>
    <div class='col-sm-6 form-group' >
    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
</div>
</div>
<div class="row">
    <div class='col-sm-6 form-group' >
    <?php // $form->field($model, 'profile_photo')->fileInput(['maxlength' => true,'value'=>$model->profile_photo, 'class' => 'btn btn-primary']) ?>
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'profile_photo')->fileInput(['id'=> 'imgInp', 'value'=>$model->profile_photo, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'profile_photo')->fileInput(['id'=> 'imgInp', 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->profile_photo!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo $model->profile_photo;  ?>" />
      <?php } ?>
</div>
<div class='col-sm-6 form-group' >
    
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'licence_copy')->fileInput(['id'=> 'imgInp1', 'value'=>$model->licence_copy, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'licence_copy')->fileInput(['id'=> 'imgInp1', 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->licence_copy!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo $model->licence_copy;  ?>" />
      <?php } ?>
</div>
</div>
   <div class="row">
    <div class='col-sm-6 form-group' >
    <?php // $form->field($model, 'profile_photo')->fileInput(['maxlength' => true,'value'=>$model->profile_photo, 'class' => 'btn btn-primary']) ?>
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'aadhar_copy')->fileInput(['id'=> 'imgInp3', 'value'=>$model->aadhar_copy, 'class' => 'btn btn-primary'])->label('Aadhaar Copy');  
             }else{     ?>                          
             <?= $form->field($model, 'aadhar_copy')->fileInput(['id'=> 'imgInp3', 'class' => 'btn btn-primary'])->label('Aadhaar Copy')?>
           <?php } 
           if($model->aadhar_copy!=''){?>
            <img id="blah3" class="profile-user-img img-responsive img-circle" src="<?php echo $model->aadhar_copy;  ?>" />
      <?php } ?>
</div>
<div class='col-sm-6 form-group' >
    
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'pancard_copy')->fileInput(['id'=> 'imgInp4', 'value'=>$model->pancard_copy, 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'pancard_copy')->fileInput(['id'=> 'imgInp4', 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->pancard_copy!=''){?>
            <img id="blah4" class="profile-user-img img-responsive img-circle" src="<?php echo $model->pancard_copy;  ?>" />
      <?php } ?>
</div>
</div>
   
<div class="row"> 
     <div class='col-sm-6 form-group' style="margin-top: 25px;">
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
            'template' => "<div class='checkbox checkbox-custom' style='margin-top:0px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
            ])->checkbox([],false)->label('Status'); ?>  
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right composition' : 'btn btn-primary pull-right composition']) ?>
        <span id="load" style="display: none;"><img src="<?= Url::to('@web/loader.gif') ?>" />Loading...</span>
     <span id="loadtex" style="display: none; "></span>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
 
   $('#driverprofile-employee_id').on('change', function() {
    
    var emp = $(this).val();
   
     $.ajax({
                     url:'<?php  echo Yii::$app->homeUrl ?>?r=driver-profile/empid&id='+emp,
                     type: 'POST',  
                     data : $('#login-form').serialize(),    
                     success: function (result) {
                     $('#ror').val(result);
                     if(result!=""){
                      $('#error').show();
                     }else{
                      $('#error').hide();
                     }
                     },
                     error: function (error) {
                      
                     }
                     
                 });
           
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
 <script>


//$('.composition').on('click', function(e) 
//$("#payufomx").on('submit',(function(e)
 $('#payufomx').on('beforeSubmit', function(e) {  
   // e.preventDefault();
    $("#load").show(); 
   // var formData = new FormData($('#payufomx')); 
 //   var formData = $('#payufomx').serialize();
     //  console.log(formData);
    $.ajax({
        url: '<?php echo Yii::$app->homeUrl . "?r=vehicle-master/driver-create";?>',
        type: 'POST',
         data : new FormData(this),  
         contentType: false,
         cache: false,
         processData:false,  
       
        success: function (data) 
        {
          $("#load").hide(4);
          var data = $.parseJSON(data);
        if(data[0]=="Y")
        {  
          $('#vehiclemaster-driver_id').children('option:not(:first)').remove();
          var datalength=data[1];
          var appendhtml='<option value="">--Select Composition--</option>';
          for (x in datalength) 
        {
          appendhtml=appendhtml+'<option value='+datalength[x]['id']+' selected="selected">'+datalength[x]['name']+'</option>';
        }
          console.log(appendhtml);
          $("#vehiclemaster-driver_id").append(appendhtml);
          $("#loadtex").text("Successfully Saved.");
          $("#loadtex").css('color','green ');
          $("#loadtex").show(4);
          $('#operationalmodal').modal('hide');
      }       
      else if(data[0]=="E")
      {
        $("#loadtex").text("Data Already Exists.");
        $("#loadtex").css('color','red ');
        $("#loadtex").show();
        }
      else if(data[0]=="W")
      {
        $("#loadtex").text("Age From Must be Less than Age To.");
        $("#loadtex").css('color','red ');
        $("#loadtex").show();
        }
      else
      {
        $("#loadtex").text("Data Not Saved.");
        $("#loadtex").css('color','red ');
        $("#loadtex").show();
      } 
        },
        error: function () 
        {
                alert("Something went wrong");
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});
</script>