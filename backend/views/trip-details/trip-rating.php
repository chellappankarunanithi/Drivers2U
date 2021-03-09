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
if ($model->TripStatus=="Activated") {
$driver =  ArrayHelper::map(DriverProfile::find()->where(['OR',['available_status'=>"0"],['id'=>$model->DriverId]])->asArray()->all(),'id','name'); 
  
}else{
  $driver =  ArrayHelper::map(DriverProfile::find()->where(['available_status'=>"0"])->asArray()->all(),'id','name');
}
$customer =  ArrayHelper::map(ClientMaster::find()->where(['id'=>$model->CustomerId])->asArray()->all(),'id','client_name'); 
$CustomerId= $model->CustomerId;
$contact  = "";
$address  = "";
$email_id = "";
$pincode  = "";
$company_name  =""; 

$driverid  = "";
$drivercontact  = "";
$driveraddress = "";
$driveraadhar  = "";
$profile_photo  = "";

if (array_key_exists('id', $_GET) && array_key_exists('data', $_GET)) { //echo "as"; die;
  $CustomerId = $_GET['id'];
}
  
  $newcustomer = ClientMaster::find()->where(['id'=>$CustomerId])->asArray()->one();
  if (!empty($newcustomer)) {
    $client_name  = $newcustomer['client_name'];
    $contact  = $newcustomer['mobile_no'];
    $address  = $newcustomer['address'];
    $email_id = $newcustomer['email_id'];
    $pincode  = $newcustomer['pincode'];
    $company_name  = $newcustomer['company_name'];
  }

   $drivermodel = DriverProfile::find()->where(['id'=>$model->DriverId])->asArray()->one();
   //echo "<pre>"; print_r($model->DriverId); die;
  if (!empty($drivermodel)) {
    $driverid  = $drivermodel['employee_id'];
    $drivercontact  = $drivermodel['mobile_number'];
    $driveraddress = $drivermodel['address'];
    $driveraadhar  = $drivermodel['aadhar_no'];
    $profile_photo  = Url::base(true).'/'.$drivermodel['profile_photo'];
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
 
.rating-stars .rating-stars-container {
  font-size: 0;
}
.rating-stars .rating-stars-container .rating-star {
  display: inline-block;
  font-size: 32px;
  cursor: pointer;
  padding: 5px 8px;
  color: #ebeefb;
}
.rating-stars .rating-stars-container .rating-star.sm {
  display: inline-block;
  font-size: 14px;
  color: #83829c;
  cursor: pointer;
  padding: 1px;
}
.rating-stars .rating-stars-container .rating-star.is--active, .rating-stars .rating-stars-container .rating-star.is--hover {
  color: #f1c40f;
}
.rating-stars .rating-stars-container .rating-star.is--no-hover {
  color: #3e4b5b;
}
.rating-stars .rating-stars-container .rating-star .fa-heart .is--no-hover {
  color: #3e4b5b;
}
.rating-stars input {
  display: none;
  margin: 0 auto;
  text-align: center;
  padding: .375rem .75rem;
  font-size: .9375rem;
  line-height: 1.6;
  color: #3d4e67;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #e0e5f3;
  border-radius: 3px;
  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.rating-stars.star input {
  display: none;
}

  

</style>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Url::base(true); ?>/dist/css/select2.css" />
 <script  src="<?php echo Url::base(true); ?>/dist/js/select2.js"></script>
<script src="<?php echo Url::base(true); ?>/dist/js/jquery.rating-stars.js"></script>

<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body">

    <?php $form = ActiveForm::begin(['id'=>'my_submit']); ?>
      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Customer Name</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'CustomerId')->textInput(['class'=>'form-control input-sm','value'=>$client_name,'readonly'=>true])->label(false)?>
                </div>
              </div>
             
               <div class="col-sm-3"> 
            <div class="f orm-group"> 
             <label class="form-label">Rating</label>
                   <div class="rating-stars mb-4 mt-0 d-flex">
                                      <?php $rating="5";
                                      if ($model->rating!="") {
                                        $rating=$model->rating;
                                      }
                                        ?> 
                                    <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" value="<?php echo $rating; ?>" />
                                    <div class="rating-stars-container mr-2 mt-3">
                                        <div class="rating-star sm fs-16"> <input type="radio" name="stars" value="1" /><i class="fa fa-star fa-2x"></i></div>
                                        <div class="rating-star sm fs-16"> <input type="radio" name="stars" value="2" /><i class="fa fa-star fa-2x"></i></div>
                                        <div class="rating-star sm fs-16"> <input type="radio" name="stars" value="3" /><i class="fa fa-star fa-2x"></i></div>
                                        <div class="rating-star sm fs-16"> <input type="radio" name="stars" value="4" /><i class="fa fa-star fa-2x"></i></div>
                                        <div class="rating-star sm fs-16"> <input type="radio" name="stars" value="5" /><i class="fa fa-star fa-2x"></i></div>
                                    </div>
                                </div>
            </div>
          </div>  
              <div class="col-sm-5">
                <div class="f orm-group">
                  <label class="form-label">Review</label>
                     <?php echo $form->field($model, 'Review')->textarea(['row'=>3])->label(false); ?> 
                </div>
              </div>
           
        </div>
      </div> 
    
    
     <div class="card-footer">
        <div class="row">
          <div class="col-sm-12">
    <div class="col-sm-12"> 
                <div class="form-group"> 
                 <?php echo Html::submitButton('Save', ['class' => 'btn btn-success pull-right savesub','id'=>'savesub']); ?>
              </div> 
        </div>
      </div>
    </div>
  </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
<?php //echo Yii::$app->homeUrl; die;?>
<script type="text/javascript">
$(function() { 
  $(".rating-stars").ratingStars();
});
  
 


  </script>