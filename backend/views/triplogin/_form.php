<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster;
use backend\models\OthersVehicleDetails;
/* @var $this yii\web\View */
/* @var $model backend\models\Triplogin */
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

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-sm-4 form-group'> 
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-sm-4 form-group'>  
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>     
        <div class='col-sm-4 form-group'>  
            <?php
             $user1 =   ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->asArray()->all(),'reg_no','reg_no'); 
              $use =   OthersVehicleDetails::find()->where(['status'=>'Active'])->asArray()->all(); 
              $user2 = array();
              foreach ($use as $key => $value) {
                $user2[$value['reg_no']] = $value['reg_no'].' - RENT'; 
              }
              //  echo "<pre>"; print_r($user2); die;
              $user = array_merge($user1,$user2);
             ?>
             <?= $form->field($model, 'vehicle_number',['enableAjaxValidation'=>true])->dropDownList($user,['prompt' => 'Select','class'=>'form-control reg_no']); ?>
        </div>    
    </div>
    <div class="row">
        <div class='col-sm-4 form-group'> 
            <?= $form->field($model, 'contact_no')->textInput(['maxlength' => 10]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
             <?php if(isset($_GET['id'])){ 
               echo $form->field($model, 'profile_photo')->fileInput(['id'=> 'imgInp', 'class' => 'btn btn-primary']);  
             }else{     ?>                          
             <?= $form->field($model, 'profile_photo')->fileInput(['id'=> 'imgInp', 'class' => 'btn btn-primary']) ?>
           <?php } 
           if($model->profile_photo!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo $model->profile_photo;  ?>" />
      <?php } ?>
        </div>
    </div>
     <div class="row">
        <!-- <div class='col-sm-4 form-group'> 
            <?php //echo $form->field($model, 'username',['enableAjaxValidation'=>true])->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
            <?php //echo $model->isNewRecord ?$form->field($model, 'password')->passwordInput(['placeholder' => 'Password','value'=>'']) : ''; ?>
        </div> -->

    <div class="form-group col-sm-8">
    </div>
    <div class="form-group col-sm-4" style="margin-top: 25px;">
         <?php 
          if($model->isNewRecord){
          $model->status = 1;
          }else{
            if($model->status=="A"){
              $model->status = 1;
            }else{
              $model->status = 0;
            }
          } ?> 
         <?= $form->field($model, 'status', [
            'template' => "<div class='checkbox checkbox-custom' style='margin-top:10px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
            ])->checkbox([],false)->label('Status'); ?>  
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>

</div>
</div>
</div>
</div>

