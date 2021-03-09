<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster;
use backend\models\OthersVehicleDetails;
use backend\models\CustomerDetails;
use backend\models\ClientMaster;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */
/* @var $form yii\widgets\ActiveForm */
// echo "<pre>";print_r($model);die;
$cus1 = $tripcusadd = $cus2 = $genaddr = 'hidden';
if($model->trip_customer1!="" && $model->trip_customer1!=NULL){
  $cus1 = '';
  $tripcusadd = '';
}if($model->trip_customer2!="" && $model->trip_customer2!=NULL){
  $cus2 = '';
  $tripcusadd='hidden';
}
if($model->pickup_type=='general'){
  $genaddr="";
} 
$scua = CustomerDetails::find()->where(['company_name'=>$model->customer_name])->asArray()->all(); 
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
<link rel="stylesheet" type="text/css" media="screen" href="dist/css/select2.css" />
 <script  src="dist/js/select2.js"></script>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body">

    <?php $form = ActiveForm::begin();  ?>
        <div class="row">
            <div class='col-sm-3 form-group'> 
            <?= $form->field($trip_model, 'trip_title')->textInput(['name'=>'trip_title','maxlength' => 10]) ?>
            </div>
          
    </div>
    <div class="row">
        
     </div>
     <div class="row">
        <div class='col-sm-3 form-group'> 
            <?= $form->field($trip_model, 'driver_name')->textInput(['name'=>'driver_name','maxlength' => true,'readonly'=>true]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($trip_model, 'driver_contact')->textInput(['name'=>'driver_contact','maxlength' => 10,'readonly'=>true]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($trip_model, 'vehicle_number')->textInput(['name'=>'vehicle_number','maxlength' => 10,'readonly'=>true]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($trip_model, 'vehicle_name')->textInput(['name'=>'vehicle_name','maxlength' => true,'readonly'=>true]) ?>
        </div>
      </div>
      <?php // echo "asdas"; die; ?>
      <div class="row">
        <div class='col-sm-4 form-group'> 
            <?= $form->field($client_model, 'client_name')->textInput(['name'=>'client_name','maxlength' => true,'readonly'=>true]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
            <?= $form->field($client_model, 'mobile_no')->textInput(['name'=>'mobile_no','maxlength' => 10,'readonly'=>true]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
            <?= $form->field($client_model, 'address')->textArea(['name'=>'address','readonly'=>true]) ?>
        </div>
      </div> 
       <div class="row">
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'trip_start_time')->textInput(['name'=>'trip_start_time','maxlength' => true]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'trip_end_time')->textInput(['name'=>'trip_end_time','maxlength' => 10]) ?>
        </div>
         <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'enter_starting_km')->textInput(['name'=>'enter_starting_km','maxlength' => true]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'enter_close_km')->textInput(['name'=>'enter_close_km','maxlength' => 10]) ?>
        </div>
      </div>

      <div class="row">
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'package_km')->textInput(['name'=>'package_km','maxlength' => 10]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'package_type')->textInput(['name'=>'package_type','maxlength' => true]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'extra_km')->textInput(['name'=>'extra_km','maxlength' => 10]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'extra_hours')->textInput(['name'=>'extra_hours','maxlength' => 10]) ?>
        </div>
      </div>
      <div class="row">
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'driver_charges')->textInput(['name'=>'driver_charges','maxlength' => 10]) ?>
        </div>
        <div class='col-sm-3 form-group'> 
            <?= $form->field($model1, 'no_days_night')->textInput(['name'=>'no_days_night','maxlength' => 10]) ?>
        </div>
      </div>
      <div class="col-sm-6">
              <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
    <?php  ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>