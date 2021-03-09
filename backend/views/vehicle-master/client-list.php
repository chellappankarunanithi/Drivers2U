<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\DriverProfile;
use backend\models\ClientMaster;
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
            <div class="panel-body">
                <?php
                $clientid= explode(',', $model->client_id);
                $ClientMaster = ClientMaster::find()->where(['IN','id',$clientid])->asArray()->all();
                
                if($vehiclient)
                if (!empty($ClientMaster)) {
                  /*<input type="hidden" name="client_id" value="'.$value['id'].'" id="client_id">*/
                  foreach ($ClientMaster as $key => $value) {
                    
                    echo ' <div class="row">
                        <div class="col-sm-8 form-group">
                        <span class="">Previous Client: <b>'.$value['company_name'] .'</b> </span></div>
                        
                      <div class="col-sm-4 form-group">
                         <button type="button" class="btn btn-danger btn-xs removeclient" value="'.$value['id'].'" data_type='.$model->id.'><i class="fa fa-close"></i></button> 
                      </div>
                        </div>'; 
                  }
                }
                ?>

    <?php $form = ActiveForm::begin([
        'action' => ['client-mapping'],
        'method' => 'post',
    ]); ?> 
    <hr>
    <div class="row">
     <div class='col-sm-8 form-group'>
    <?php // $form->field($model, 'vehicle_name') ?>
     <?php 
        $users =   ArrayHelper::map(ClientMaster::find()
            ->where(['status'=>'Active']) 
            ->asArray()->all(),'id','company_name'); 
        
        echo $form->field($model, 'client_id')->dropDownList($users,['options' => [$model->client_id => ['Selected'=>'selected']],'prompt'=>'Select','data-live-search'=>'true','multiple'=>true,
         'data-style'=>"btn-default btn-custom1", 'required'=>true,'style'=>'width:200px;'])->label('Client Name'); ?>
        <input type="hidden" name="getid" value="<?php echo $model->id; ?>">
     
</div>
  
 <div class='col-sm-4 form-group'> 
      
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-sm']) ?> 
    </div>
</div>  
    <?php ActiveForm::end(); ?>

</div></div>
</div>
</div>
</div>
<script>
        $("#vehiclemaster-client_id").select2({ placeholder: "Select a Client Name"}); 
        $('body').on("click",".removeclient",function(e){
            e.preventDefault();  //stop the browser from following 
            var data= $(this).attr('data_type');
            var client_id= $(this).val();
           window.location.href = "<?php echo Yii::$app ->homeUrl . '?r=vehicle-master/removeclient&id='?>"+data+"&client_id="+client_id;
        });
    </script>
