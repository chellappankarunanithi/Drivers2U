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
$customer =  ArrayHelper::map(ClientMaster::find()->where(['status'=>'Active'])->asArray()->all(),'id','client_name'); 
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
        <div class="card-options">
          <?= Html::a('<i class="fa fa-refresh"></i> Refresh', ['/trip-c'], ['class' => 'btn btn-outline-primary btn-sm  ' ]) ?> 
        </div>
      </div> 

      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Customer Name</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'CustomerId')->dropDownList($customer,['class'=>'form-control input-sm','prompt'=>"Select",'value'=>$CustomerId])->label(false)?>
                </div>
              </div>
              <div class="col-sm-1" id="tripcusadd" hidden="" style="margin-top: 30px; display: block;">
                        <button type="button" id="addmore" data-toggle="tooltip" data-title="Add New Customer" class="btn btn-xs btn-info fa-fa-search" name="search"  value="search"><i class="fa fa-fw fa-plus"></i></button>      
              </div>
               <div class="col-sm-4"> 
            <div class="f orm-group"> 
             <label class="form-label">Customer ID</label>
                  <input type="text" id="tripdetails-company_name" class="form-control input-sm" name="TripDetails[company_name]" placeholder="Customer Id" readonly value="<?php echo $company_name; ?>" aria-invalid="false">
            </div>
          </div>  
              <div class="col-sm-3">
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
            <div class="f orm-group"> 
             <label class="form-label">Customer Email ID</label>
                  <input type="text" id="tripdetails-emailid" class="form-control input-sm" name="TripDetails[EmailId]" placeholder="Email ID" value="<?php echo $email_id; ?>" readonly aria-invalid="false">
            </div>
          </div> 
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Customer Address</label>
                     <textarea id="tripdetails-address" class="form-control input-sm" name="TripDetails[Address]" placeholder="Address" aria-invalid="false" value="<?php echo $address; ?>" readonly rows="3"><?php echo $address; ?></textarea>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="f orm-group">
                  <label class="form-label">Customer Pincode</label>
                        <input type="text" id="tripdetails-pincode" class="form-control input-sm" name="TripDetails[Pincode]" maxlength="6" placeholder="Pincode" value="<?php echo $pincode; ?>" readonly aria-invalid="false">
                </div>
              </div>
              
        </div>
      </div>
    </div>
    <br>
    <div class="card-header">
        <h3 class="card-title" style="margin-top: 0px;">Vehicle Information</h3> 
      </div>  
      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
             <div class="col-sm-2" id="tripcusadd" hidden="" style="margin-top: 30px; display: block;">
                        <button type="button" id="carsmore" data-toggle="tooltip" data-title="Existing cars of Customer" class="btn btn-xs btn-primary fa-fa-search" name="search"  value="search"><i class="fa fa-fw fa-car"></i> Vehicle List</button>      
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label class="form-label required">Vehicle Type</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'VehicleType')->dropDownList(array('Hatchback'=>'Hatchback', 'Sedan'=>'Sedan','Luxury'=>'Luxury', 'Premium'=>'Premium'),['class'=>'form-control input-sm','prompt'=>"Select"])->label(false)?>
                </div>
              </div>
             
               <div class="col-sm-4"> 
            <div class="f orm-group"> 
             <label class="form-label">Vehicle Made</label>
                  <?= $form->field($model, 'VehicleMade')->textInput(['class'=>'form-control input-sm','style'=>'text-transform:uppercase;'])->label(false)?>
            </div>
          </div>  
              <div class="col-sm-3">
                <div class="f orm-group">
                   <label class="form-label">Vehicle No</label><span style="color: red; font-size: 15px;">*</span>
                  <?= $form->field($model, 'VehicleNo')->textInput(['maxlength'=>10,'class'=>'form-control input-sm','style'=>'text-transform:uppercase;'])->label(false)?>
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
                    <?= $form->field($model, 'DriverId')->dropDownList($driver,['value'=>$model->DriverId, 'class'=>'form-control input-sm','prompt'=>"Select",'style'=>'width: 100%;'])->label(false)?>
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
        <h3 class="card-title" style="margin-top: 0px;">Trip Information</h3> 
      </div>  
      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row">
          <div class="col-sm-12">
              <div class="col-sm-2">
                <div class="form-group">
                  <label class="form-label required">Trip Type</label><span style="color: red; font-size: 15px;">*</span>
                    <?= $form->field($model, 'TripType')->dropDownList(array('One Way'=>'One Way','Round Trip'=>'Round Trip'),['class'=>'form-control input-sm','prompt'=>"Select"])->label(false)?>
                </div>
              </div>
              <div class="col-sm-5"> 
                <div class="f orm-group"> 
                 <label class="form-label">Pickup Location</label>
                       <?= $form->field($model, 'TripStartLoc')->textarea(['row'=>3,'class'=>'form-control input-sm'])->label(false)?>
                </div>
              </div>  
              <div class="col-sm-5"> 
                <div class="f orm-group"> 
                 <label class="form-label">Drop Location</label>
                       <?= $form->field($model, 'TripEndLoc')->textarea(['row'=>3,'class'=>'form-control input-sm'])->label(false)?>
                </div>
              </div> 
          </div>

          <div class="col-sm-12">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="form-label required">Trip Start Date & Time</label><span style="color: red; font-size: 15px;">*</span>
                    <?php
                     $date = date('d-m-Y h:i:s A', strtotime($model->StartDateTime));
                      if (strpos($date, '0000') || strpos($date, '1970')) {
                          $date = "-";
                      }
                     ?>
                       <?= $form->field($model, 'StartDateTime')->textInput(['maxlength' => true,'value'=>$date,'class'=>'form-control input-sm'])->label(false); ?>
                </div>
              </div> 
             
              <div class="col-sm-4"> 
                <div class="f orm-group"> 
                 <label class="form-label">Trip End Date & Time</label><span style="color: red; font-size: 15px;">*</span>
                      <?php 
                       $date = date('d-m-Y h:i:s A', strtotime($model->EndDateTime));
                      if (strpos($date, '0000') || strpos($date, '1970')) {
                          $date = "-";
                      }
                      
                      echo $form->field($model, 'EndDateTime')->textInput(['maxlength' => true, 'value'=>$date, 'class'=>'form-control input-sm'])->label(false); 
                      ?>

                </div>
              </div> 
             
      </div> 
    </div>
  </div>
    
     <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
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

  $('body').on('change','#tripdetails-customerid',function(){
        var CustomerId =  $(this).val();
        if(CustomerId!=''){
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'get-customer'; ?>',
              type:'post',
              data:'CustomerId='+CustomerId,
              success:function(response){
                var data = JSON.parse(response);
                $('#tripdetails-company_name').val(data.company_name);
                $('#tripdetails-contactno').val(data.mobile_no);
                $('#tripdetails-emailid').val(data.email_id);
                $('#tripdetails-address').val(data.address);
                $('#tripdetails-pincode').val(data.pincode);
              }
          });
        }
  });


  $('body').on('change','#tripdetails-driverid',function(){
        var driverid =  $(this).val();
        if(driverid!=''){
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'get-driver'; ?>',
              type:'post',
              data:'driverid='+driverid,
              success:function(response){
                var data = JSON.parse(response);
                $('#tripdetails-driver_id').val(data.employee_id);
                $('#tripdetails-driver_contact').val(data.mobile_number);
                $('#tripdetails-driveraddress').val(data.address);
                $('#tripdetails-aadharno').val(data.aadhar_no);
                $('#blah2').attr("src", "<?php echo Url::base(true);?>/"+data.profile_photo);
              }
          });
        }
  });
 
  $('body').on('click','.Selectfortrip',function(){
        var vehicleid =  $(this).val();
        if(vehicleid!=''){
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'get-vehicle'; ?>',
              type:'post',
              data:'vehicleid='+vehicleid,
              success:function(response){
                var data = JSON.parse(response);
                $('#tripdetails-vehicletype').val(data.vehicle_name);
                $('#tripdetails-vehiclemade').val(data.vehicle_uniqe_name);
                $('#tripdetails-vehicleno').val(data.reg_no); 
                 $('#operationalmodal').modal('hide');
              }
          });
        }
  });
 
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
  
     $('#tripdetails-startdatetime').datetimepicker({ format: 'DD-MM-YYYY hh:mm:ss A', minDate: new Date()});
     $('#tripdetails-enddatetime').datetimepicker({ format: 'DD-MM-YYYY hh:mm:ss A',minDate: $('#tripdetails-startdatetime').val()});

 
      $("#tripdetails-customerid").select2({ placeholder: "Select a Customer"}); 
      $("#tripdetails-driverid").select2({ placeholder: "Select a Driver"});  


$("#tripdetails-driver_contact").on("input", function(evt) {

  var self = $(this);
  self.val(self.val().replace(/[^0-9]/g, ''));
  if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
  {
    evt.preventDefault();
  }
});
  </script>