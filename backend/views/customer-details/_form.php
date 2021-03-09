<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\ClientMaster;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerDetails */
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
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class='col-sm-4 form-group' >
              <?php $items= ArrayHelper::map(ClientMaster::find()->where(['status'=>'Active'])->all(), 'id', 'company_name'); ?>
                <?= $form->field($model, 'company_name')->dropdownlist($items,['prompt' =>"Select"]) ?>
            </div>
            <div class='col-sm-4 form-group' >
                <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
            </div>
            <div class='col-sm-4 form-group' >
                <?= $form->field($model, 'contact_person_designation')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-6 form-group' >
                 <?= $form->field($model, 'company_contact_no')->textInput(['maxlength' => 10]) ?>
            </div>
            
            <div class='col-sm-6 form-group' >
                <?= $form->field($model, 'company_address')->textarea(['rows' => 2]) ?>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-6 form-group' >
                <?= $form->field($model, 'personal_contact_no')->textInput(['maxlength' => 10]) ?>
            </div>
          
            <div class='col-sm-6 form-group' >
                <?= $form->field($model, 'personal_address')->textarea(['rows' => 2]) ?>
            </div>
        </div>
        <div class="row">
          
            <div class='col-sm-12 form-group' >
                <div class="form-group pull-right">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                        <?php ActiveForm::end(); ?>
                </div>
        </div>
</div>
</div>
</div>
</div></div>
<script type="text/javascript">
    $("#customerdetails-contact_person").on("keypress", function(e) { 
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