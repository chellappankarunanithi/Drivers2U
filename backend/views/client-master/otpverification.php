<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\SuperviserMaster;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\ClientMaster */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Add New Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customer Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 
 
$data="";
if(array_key_exists('data', $_GET)){
  if ($_GET['data']!="") {
    $data=$_GET['data'];
  } 
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
   
   .upper {
   text-transform: uppercase;
   }
   
   .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #f4f4f4!important;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #129cec !important;
    border: 1px solid #aaa;
    }
</style>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Url::base(true)?>/dist/css/select2.css" />
 <script  src="<?php echo Url::base(true)?>/dist/js/select2.js"></script>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
		  <?php $form = ActiveForm::begin(); ?>
            <div class="panel-body   ">

   
<div class="row">
     <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'client_name')->textInput(['maxlength' => true,'readonly'=>true])->label('Customer Name') ?>
        <div id="customererror" style="color: #e61717;" class="help-block"></div>
    </div>
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => 10, 'class'=>'form-control without_decimal12','readonly'=>true]) ?>
        <div id="mobile_noerror" style="color: #e61717;" class="help-block"></div>
    </div>
    <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'email_id')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    </div>
</div>
<div class="row">

 <div class='col-sm-4 form-group' >
        <?= $form->field($model, 'Landmark')->textInput(['maxlength' => true,'readonly'=>true]) ?>
        <div id="landmarkerror" style="color: #e61717;" class="help-block"></div>
    </div>
 <div class='col-sm-4 form-group' >
    <?= $form->field($model, 'address')->textarea(['rows' => 3,'readonly'=>true]) ?>
    <div id="addresserror" style="color: #e61717;" class="help-block"></div>
</div>
<div class='col-sm-4 form-group' >
    <?= $form->field($model, 'pincode')->textInput(['maxlength' => 6,'readonly'=>true]) ?>
    <div id="pincodeerror" style="color: #e61717;" class="help-block"></div>
    <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
</div>
 
</div>
 
</div>

 <div class="card-header">
        <h3 class="card-title text-center" style="margin-top: 0px;">Customer OTP Verification</h3> 
      </div>  
      <div class="card-body" style="border: 1px solid #c7c6c6;padding: 10px;">
        <div class="row beforeverification">
          <div class="col-sm-12"> 
            <center>
            <div class="form-group"> 
              <input type="text" name="otp_number" id="otp_number" maxlength="4" class="form-control" style="width: 150px;font-size: 21px;text-align: center;">
              <p id="requiredotp" style="color: #e01818; padding-top: 10px;"></p> 
              <p class="invalidotp" style="color: #e01818; padding-top: 10px;"></p>
                <h3 class="YourOtp" style="margin-top: -15px !important;"></h3>
                <button class="btn btn-primary" id="otpsend" type="button">SEND OTP</button><br>
                <button class="btn btn-success" style="display: none;" id="otpverify" type="button">VERIFY OTP</button>
                <h4 class="mt-10 otpsendmsg" style="display: none;">OTP have been sent to customer's mobile number. Please call and verify the OTP. </h4>
                <h4 class="mt-10 otpresendmsg" style="display: none;">OTP have been resent to customer's mobile number. Please call and verify the OTP. </h4>
                <h5 class="otpalertmsg"  style="color: brown; display: none;">*** don't refresh this page or go back. *** </h5>
                <br>
                <button class="btn btn-xs btn-info" style="display: none;" id="resendotp" type="button">RESEND OTP</button>
              </div>  
            </center> 
      </div>
    </div>
     <div class="row afterverification" style="display: none;">  
            <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>
           <div class="col-sm-12"> 
            <h3 class="text-center">OTP Verified and  Customer is activated Successfully!</h3><br>
          </div>
           <div class="text-center" style="width: 100%;"> 
          <?php  if ($data=="09") { ?>
           <a href="<?php echo Url::base(true).'/trip-c/'.$model->id.'/09'; ?>" class="btn btn-sm btn-primary" type="button">Go to Trip Booking Page</a>
          <?php }else{ ?>
            <a href="<?php echo Url::base(true)?>/customer-management" class="btn btn-sm btn-primary" type="button">Go to Customer Management</a>
         <?php } ?>
           </div>
          </div>  
    </div>
 


  <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
</div>
<?php $id="";
  if(array_key_exists('id', $_GET)){
    $id = $_GET['id'];
  }

 ?>
<script type="text/javascript">
  $('body').on('click','#otpsend,#resendotp',function(){  
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'otpsave/'.$id; ?>',
              type:'post',
              data:$("#w0").serialize(),
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
  });

   $('body').on('click','#otpverify',function(){
         $id = '<?php echo $_GET['id']; ?>';
         $otp_number = $("#otp_number").val();
         $otpfor = 'Activate';
       

         $(".invalidotp").html("");
        if($otp_number!=''){
          $("#requiredotp").hide();
          $.ajax({
              url: '<?php echo Yii::$app->homeUrl . 'otpverification'; ?>',
              type:'post',
              data:$('#w0').serialize()+'&otpfor='+$otpfor+'&otp_number='+$otp_number+'&id='+$id,
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

    $(".without_decimal12").on("input", function(evt) { 
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
 });    

    $("#clientmaster-pincode").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
 });

   
  $("#clientmaster-client_name").on("keypress", function(e) {  
  if(e.which === 8){
     return true;
  }else if ((!/^[a-zA-Z\. ]*$/.test(String.fromCharCode(e.which )))) {
        return false;
    }
}); 
         
</script>
