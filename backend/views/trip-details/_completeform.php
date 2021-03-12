<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster; 
use backend\models\CustomerDetails;
use backend\models\CommissionMaster;
use backend\models\CancelTripLog;
use backend\models\DriverProfile;
use backend\models\ClientMaster;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */
/* @var $form yii\widgets\ActiveForm */
// echo "<pre>";print_r($model);die;
$this->title = 'Activate Trip'; 
$this->params['breadcrumbs'][] = $this->title;
$driver =  ArrayHelper::map(DriverProfile::find()->where(['status'=>'Active'])->asArray()->all(),'id','name'); 
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
  
  $newcustomer = ClientMaster::find()->where(['id'=>$CustomerId])->asArray()->one();
  if (!empty($newcustomer)) {
    $CustomerName  = $newcustomer['client_name'];
    $contact  = $newcustomer['mobile_no'];
    $address  = $newcustomer['address'];
    $email_id = $newcustomer['email_id'];
    $pincode  = $newcustomer['pincode'];
    $company_name  = $newcustomer['company_name'];
  }

   $drivermodel = DriverProfile::find()->where(['id'=>$model->DriverId])->asArray()->one();
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
        <h3 class="card-title" style="margin-top: 0px;">Customer Informations</h3> 
      </div> 

      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Customer Name</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'CustomerId')->textInput(['class'=>'form-control input-sm','value'=>$CustomerName, 'readOnly'=>true])->label(false)?>
                </div>
              </div>
           
               <div class="col-sm-4"> 
            <div class="f orm-group"> 
             <label class="form-label">Customer ID</label>
                  <input type="text" id="tripdetails-company_name" class="form-control input-sm" name="TripDetails[company_name]" placeholder="Customer Id" readonly value="<?php echo $company_name; ?>" aria-invalid="false">
            </div>
          </div>  
              <div class="col-sm-4">
                <div class="f orm-group">
                  <label class="form-label">Customer Contact No</label>
                    <input type="text" id="tripdetails-contactno" class="form-control input-sm" name="TripDetails[ContactNo]" maxlength="10" placeholder="Contact No" readonly value="<?php echo $contact; ?>" aria-invalid="false">
                </div>
              </div>
           
        </div>
      </div>
      <div class="row">
          <div class="col-sm-12">
             
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Vehicle Type</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'VehicleType')->textInput(['class'=>'form-control input-sm','readOnly'=>true])->label(false)?>
                </div>
              </div>
             
               <div class="col-sm-4"> 
            <div class="f orm-group"> 
             <label class="form-label">Vehicle Made</label>
                  <?= $form->field($model, 'VehicleMade')->textInput(['class'=>'form-control input-sm', 'readOnly'=>true])->label(false)?>
            </div>
          </div>  
              <div class="col-sm-4">
                <div class="f orm-group">
                   <label class="form-label">Vehicle No</label><span style="color: red; font-size: 15px;">*</span>
                  <?= $form->field($model, 'VehicleNo')->textInput(['class'=>'form-control input-sm', 'readOnly'=>true])->label(false)?>
                </div>
              </div>
           
        </div>
      </div>    
    </div>
    <br>
    <div class="card-header driverclass">
        <h3 class="card-title" style="margin-top: 0px;">Driver Informations</h3> 
      </div>  
      <div class="card-body driverclass" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
              <div class="col-sm-3">
                <div class="form-group">
                  <label class="form-label required">Driver Name</label>
                  <?php $driver =  ArrayHelper::map(DriverProfile::find()->where(['id'=>$model->DriverId])->asArray()->all(),'id','name');  ?>
                    <?= $form->field($model, 'DriverId')->dropDownList($driver,['class'=>'form-control input-sm','readonly'=>true,'style'=>'width: 100%;'])->label(false)?>
                    <div id="driveriderror" style="color: #e61717;" class="help-block"></div>
                </div>
              </div> 
              <div class="col-sm-3"> 
                <div class="f orm-group"> 
                 <label class="form-label">Driver ID</label>
                      <input type="text" id="tripdetails-driver_id" class="form-control input-sm" name="TripDetails[DriverCode]" placeholder="Driver Id" value="<?php echo $driverid; ?>" readonly aria-invalid="false">
                </div>
              </div>  
              <div class="col-sm-3"> 
                <div class="f orm-group"> 
                 <label class="form-label">Driver Contact</label>
                      <input type="text" id="tripdetails-driver_contact" class="form-control input-sm" name="TripDetails[DriverContact]" placeholder="Driver Contact" value="<?php echo $drivercontact; ?>"  readonly aria-invalid="false">
                </div>
              </div> 
               <div class="col-sm-3"> 
                <div class="f orm-group"> 
                 <label class="form-label">Driver Photo</label>
                      <img id="blah2" class="profile-user-img img-responsive img-circle" src="<?php echo $profile_photo;  ?>" />
                </div>
              </div> 
          </div>

      </div> 
    </div>
    <br>

    <div class="card-header">
        <h3 class="card-title text-center" style="margin-top: 0px;">TRIP Completion</h3> 
      </div>  
      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12"> 
           <div class="col-sm-2">    
            <?php //echo "<pre>"; print_r($model); die; ?>
              <?= $form->field($model, 'CommissionType')->dropDownList(array('Percentage'=>'Percentage','Flat'=>'Flat'),['class'=>'form-control input-sm','style'=>'width: 100%;','prompt'=>'Select'])->label("Commission Type"); ?>         
           </div> 
           <div class="col-sm-2 CommissionPercentage" style="display: none;">   
              <?php $commission =  ArrayHelper::map(CommissionMaster::find()->where(['Status'=>"Active"])->asArray()->all(),'id','CommissionValue');  ?>
              <?= $form->field($model, 'CommissionId')->dropDownList($commission,['class'=>'form-control input-sm','style'=>'width: 100%;','prompt'=>'Select'])->label("Commission Value %"); ?>         
           </div>
           <div class="col-sm-2 CommissionValue" style="display: none;">        
               <?= $form->field($model, 'CommissionValue')->textInput(['class'=>'form-control input-sm','style'=>'text-align:right;'])->label("Commission Value");?>
           </div>
            <div class="col-sm-3">         
                 <label class="form-label">Trip Closing Date & Time</label><span style="color: red; font-size: 15px;">*</span>
                      <?php 
                       $date = date('d-m-Y h:i:s A', strtotime($model->EndDateTime)); 
                       
                      if (strpos($date, '0000') || strpos($date, '1970')) {  
                          $date = "-";
                      } 
                      echo $form->field($model, 'EndDateTime')->textInput(['maxlength' => true, 'value'=>$date, 'class'=>'form-control input-sm'])->label(false); 
                      ?> 
           </div>
           <div class="col-sm-2">        
               <?= $form->field($model, 'TripHours')->textInput(['class'=>'form-control input-sm'])->label("Total Trip Hours");?>
           </div>
            <div class="col-sm-2">      
                 <?= $form->field($model, 'TripCost')->textInput(['class'=>'form-control input-sm','style'=>'text-align:right;'])->label("Trip Closing Amount");?>
           </div>
      </div>
    </div> 

          <?php 
            $pendinglog = CancelTripLog::find()->where(['CustomerId'=>$model->CustomerId])->andWhere(['PaymentStatus'=>"No"])->asArray()->all();
                    $CancelLogId="";
                    $pendingamount=0;
            if (!empty($pendinglog)) {
              foreach ($pendinglog as $key => $value) {
                    $pendingamount +=$value['CancelFees'];
                    $CancelLogId =$value['id'];
              }
            
           ?>
    <div class="row">
      <div class="col-sm-12"> 
           <div class="col-sm-3">    
                     
           </div> 
            <div class="col-sm-3">        
             
                <?= $form->field($model, 'CancelLogId')->hiddenInput(['class'=>'form-control input-sm', 'readonly'=>true, 'value'=>$CancelLogId, 'style'=>'text-align:right;'])->label(false);?>
           </div>
           <div class="col-sm-3">        
               <?= $form->field($model, 'PreviousPending')->textInput(['class'=>'form-control input-sm', 'readonly'=>true, 'value'=>$pendingamount, 'style'=>'text-align:right;'])->label("Previous Cancel Fees");?>
           </div>
            <div class="col-sm-3">      
                 <?= $form->field($model, 'TotalAmountPaid')->textInput(['class'=>'form-control input-sm','readonly'=>true,'style'=>'text-align:right;'])->label("Total Amount");?>
           </div>
          </div>
      </div>
       <?php } ?>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group" style="margin-top: 10px;">
            <?php echo Html::submitButton('Save', ['class' => 'btn btn-success pull-right savesub','id'=>'savesub']); ?>
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

<script type="text/javascript">

   if ($("#tripdetails-commissiontype").val()=="Percentage"){
          $(".CommissionValue").hide();
          $(".CommissionPercentage").show();
      }else if ($("#tripdetails-commissiontype").val()=="Flat"){
        $(".CommissionPercentage").hide();
        $(".CommissionValue").show();
      }
  $('body').on('click','#tripdetails-commissiontype',function(){
      if ($("#tripdetails-commissiontype").val()=="Percentage"){
          $(".CommissionValue").hide();
          $(".CommissionPercentage").show();
      }else if ($("#tripdetails-commissiontype").val()=="Flat"){
        $(".CommissionPercentage").hide();
        $(".CommissionValue").show();
      }
  });


  $('body').on('click','#otpsend',function(){
         $(".invalidotp").html("");
         $tripid = '<?php echo $_GET['id']; ?>';
         $CustomerId = '<?php echo $CustomerId; ?>';
         $contactno = $("#tripdetails-contactno").val();
         $otpfor = 'Activate';
        if($CustomerId!=''){
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'otpsave'; ?>',
              type:'post',
              data:'CustomerId='+$CustomerId+'&contactno='+$contactno+'&otpfor='+$otpfor+'&tripid='+$tripid,
              success:function(response){  
                if (response!=0) {
                    $("#otpsend").hide();
                    $("#otpverify").show();
                    $("#resendotp").show();
                    $(".YourOtp").html('Your OTP: '+response);
                    $(".otpsendmsg").show();
                    $(".otpalertmsg").show();
                }
              }
          });
        }
  });
  $('body').on('click','#resendotp', function(){
         $(".invalidotp").html("");
         $tripid = '<?php echo $_GET['id']; ?>';
         $CustomerId = '<?php echo $CustomerId; ?>';
         $contactno = $("#tripdetails-contactno").val();
         $otpfor = 'Activate';
        if($CustomerId!=''){
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'otpsave'; ?>',
              type:'post',
              data:'CustomerId='+$CustomerId+'&contactno='+$contactno+'&otpfor='+$otpfor+'&tripid='+$tripid,
              success:function(response){  
                if (response!=0) {

                    $("#otpsend").hide();
                    $("#otpverify").show();
                    $("#resendotp").show();
                    $(".YourOtp").html('Your OTP: '+response);
                    $(".otpresendmsg").show();
                    $(".otpsendmsg").hide();
                    $(".otprealertmsg").show();
                }
              }
          });
        }
  });
  $('body').on('click','#otpverify',function(){
         $tripid = '<?php echo $_GET['id']; ?>';
         $CustomerId = '<?php echo $CustomerId; ?>';
         $contactno = $("#tripdetails-contactno").val();
         $otp_number = $("#otp_number").val();
         $otpfor = 'Activate';
         $(".invalidotp").html("");
        if($otp_number!=''){
          $("#requiredotp").hide();
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'otpverification'; ?>',
              type:'post',
              data:'CustomerId='+$CustomerId+'&contactno='+$contactno+'&otpfor='+$otpfor+'&tripid='+$tripid+'&otp_number='+$otp_number,
              success:function(response){ 
                if (response==1) {
                    $(".afterverification").show();
                    $(".beforeverification").hide();
                }else if (response=="invalid") {
                    $(".invalidotp").html("Invalid OTP Number"); return false;
                }
              }
          });
        }else{
           $("#requiredotp").show();
          $("#requiredotp").html("OTP Number cannot be blank."); return false;
        }
  });

 
  var self = $("#tripdetails-tripcost").val();  
  var pendingamount = '<?php echo $pendingamount; ?>';
  if (pendingamount > 0) {
    var z = parseInt(self) + parseInt(pendingamount);
    $("#tripdetails-totalamountpaid").val(z);
  }

 

 $("#tripdetails-tripcost").on("input", function(evt) { 
  var self = $(this).val();  
  var pendingamount = '<?php echo $pendingamount; ?>';
  if (pendingamount > 0) {
    var z = parseInt(self) + parseInt(pendingamount);
    $("#tripdetails-totalamountpaid").val(z);
  }

});
 $('#tripdetails-enddatetime').datetimepicker({ format: 'DD-MM-YYYY hh:mm:ss A',minDate: new Date()});
  $('body').on('click','#addmore',function(){
             var PageUrl = '<?php echo Yii::$app->homeUrl;?>customer-trip-create';
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Add New Customer</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl);
             return false;
  });

  $('body').on('click','#carsmore',function(){
             var id = $('#tripdetails-customerid').val();
             if (id) {
               var PageUrl = '<?php echo Yii::$app->homeUrl;?>card-list/'+id;
               $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Vehicle List</span>');
               $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl); 
             }else{
                alert('Customer Name is Required');
             }
             return false;
  });
 
 
$("#tripdetails-tripcost").on("input", function(evt) { 
  var self = $(this); 
  self.val(self.val().replace(/[^0-9]/g, ''));
  if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
  {
    evt.preventDefault();
  }
});
 
  </script>