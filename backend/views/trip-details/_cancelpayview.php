<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster;
use backend\models\OthersVehicleDetails;
use backend\models\CustomerDetails;
use backend\models\DriverProfile;
use backend\models\ClientMaster;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */
/* @var $form yii\widgets\ActiveForm */
//echo "<pre>";print_r($model);die;
$this->title = 'Activate Trip'; 
$this->params['breadcrumbs'][] = $this->title;
$driver =  ArrayHelper::map(DriverProfile::find()->where(['status'=>'Active'])->andWhere(['available_status'=>'0'])->asArray()->all(),'id','name'); 
$customer =  ArrayHelper::map(ClientMaster::find()->where(['status'=>'Active'])->asArray()->all(),'id','client_name'); 
$CustomerId= $model->CustomerId;
$contact  = "";
$address  = "";
$email_id = "";
$pincode  = "";
$company_name  =""; 
$CustomerName="";

$driverid  = "";
$drivercontact  = "";
$driveraddress = "";
$driveraadhar  = "";
$profile_photo  = "";

if (array_key_exists('id', $_GET) && array_key_exists('data', $_GET)) { //echo "as"; die;
  $CustomerId = $_GET['id'];
}
  
  $newcustomer = ClientMaster::find()->where(['id'=>$model->CustomerId])->asArray()->one();
  if (!empty($newcustomer)) {
    $CustomerName  = $newcustomer['client_name'];
    $contact  = $newcustomer['mobile_no'];
    $address  = $newcustomer['address'];
    $email_id = $newcustomer['email_id'];
    $pincode  = $newcustomer['pincode'];
    $company_name  = $newcustomer['company_name'];
  }
 
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
   .checkbox input[type="checkbox"]:checked + label::after {
    content: "\f00c";
    font-family: 'FontAwesome';
    color: #fff;
    position: relative;
    right: 131px;
    bottom: 1px;
}

</style>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Url::base(true); ?>/dist/css/select2.css" />
 <script  src="<?php echo Url::base(true); ?>/dist/js/select2.js"></script>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body"> 
    <?php $form = ActiveForm::begin(['id'=>'my_submit']); ?>
      <div class="card-header">
      <!--   <h3 class="card-title" style="margin-top: 0px;">Customer Informations</h3>  -->
      </div> 

      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="f orm-group"> 
                    <label class="form-label required">Customer Name</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'CustomerId')->textInput(['class'=>'form-control input-sm', 'value'=>$CustomerName, 'readOnly'=>true])->label(false)?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Cancel Fees</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'CancelFees')->textInput(['class'=>'form-control input-sm', 'readOnly'=>true])->label(false)?>
                </div>
              </div>
           
          <div class="col-sm-4"> 
            <div class="f orm-group"> 
             <label class="form-label">Payment Status</label>
                <?= $form->field($model, 'PaymentStatus')->dropDownList(array('Yes'=>'Yes','No'=>'No'),['class'=>'form-control input-sm','prompt'=>"Select",'style'=>'width: 100%;'])->label(false)?>
            </div>
          </div>   
        </div>
      </div> 
      <div class="row">
        <center>
           <div class="form-group" style="margin-top: 25px;"> 
                 <?php echo Html::submitButton('Update', ['class' => 'btn btn-success savesub','id'=>'savesub']); ?>
              </div> 
        </center>
      </div>
    </div>
 
    <br>
    
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
</div>

