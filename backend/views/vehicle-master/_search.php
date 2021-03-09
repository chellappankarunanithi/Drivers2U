<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\VehicleMasterSearch */
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
<link rel="stylesheet" type="text/css" media="screen" href="dist/css/select2.css" />
 <script  src="dist/js/select2.js"></script>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">


    <?php $form = ActiveForm::begin([
        'action' => ['vehicle-mapping'],
        'method' => 'get',
    ]); ?> 
    <div class="row">
     <div class='col-sm-4 form-group' >
    <?php // $form->field($model, 'vehicle_name') ?>
     <?php 
        $users =   ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->asArray()->all(),'vehicle_name','vehicle_name'); 
        echo $form->field($model, 'vehicle_name')->dropDownList($users,['prompt' => 'Select','id'=>'name','class'=>'form-control']); ?>
</div>
 <div class='col-sm-4 form-group' > 
    <?php 
        $user =   ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->asArray()->all(),'reg_no','reg_no'); 
        echo $form->field($model, 'reg_no')->dropDownList($user,['prompt' => 'Select','id'=>'reg_no','class'=>'form-control']); ?>
    
</div>
<div class='col-sm-3 form-group' style="margin-top: 25px;" > 
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', '?r=vehicle-master/vehicle-mapping', ['class' => 'btn btn-default']) ?>
    </div>
</div>  
    <?php ActiveForm::end(); ?>

</div></div>
</div>
</div>
</div>
<script>
        $("#name").select2({ placeholder: "Select a Vehicle Name"}); 
          $("#reg_no").select2({ placeholder: "Select a Reg Number"}); 
    </script>
