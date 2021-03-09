<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster;
use backend\models\OthersVehicleDetails;
use backend\models\CustomerDetails;
use backend\models\ClientMaster;
/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */
/* @var $form yii\widgets\ActiveForm */
// echo "<pre>";print_r($model);die;
$cus1 = $tripcusadd = $cus2 = 'hidden';
if($model->trip_customer1!="" && $model->trip_customer1!=NULL){
  $cus1 = '';
  $tripcusadd = '';
}if($model->trip_customer2!="" && $model->trip_customer2!=NULL){
  $cus2 = '';
  $tripcusadd='hidden';
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
            <div class="panel-body   ">

    <?php $form = ActiveForm::begin(['id'=>'my_submit']); ?>
        <div class="row">
            <!-- <div class='col-sm-6 form-group'>  -->
    <?php // $form->field($model, 'trip_title')->textInput(['maxlength' => true]) ?>
           <!--  </div> -->
            <div class='col-sm-4 form-group'> 
            <?php
              $clientlist = ArrayHelper::map(ClientMaster::find()->asArray()->all(), 'id','company_name');
            ?>
            <?= $form->field($model,'customer_name')->dropDownList($clientlist,['prompt'=>'Select','onchange'=>'
                $.post("'.'index.php?r=customer-details/contact-persons&id='.'" +$(this).val(),function(data){
                $("select#tripdetails-trip_customer1").html(data);
                $("select#tripdetails-trip_customer2").html(data);
                 })'])->label('Company Name'); ?> 
            </div>
            <div class='col-sm-3 form-group' id="tripcus1" <?php echo $cus1; ?>> 
              <?php
                $selectcus = ArrayHelper::map($scua,'id','contact_person');
              ?>
              <?= $form->field($model,'trip_customer1')->dropDownList($selectcus,['prompt'=>'Select','name'=>"trip_customer1",'onchange'=>'
                $.post("'.'index.php?r=customer-details/contact-persons2&id='.'" +$(this).val(),function(data){
                $("select#tripdetails-trip_customer2").html(data);
                 })'])->label('Trip Customer'); ?> 
            </div>
            <div class="col-md-1 col-xs-1" id="tripcusadd" <?php echo $tripcusadd; ?> style="margin-top: 30px;">
                        <?= Html::button('<i class="fa fa-fw fa-plus"></i>',['class' => 'btn btn-xs btn-info fa-fa-search','id'=>'addmore','name'=>'search','value'=>'search'])?>
                    </div>
            <div class='col-sm-3 form-group' id="tripcus2" <?php echo $cus2; ?>> 
              <?php
                $selectcus = ArrayHelper::map($scua,'id','contact_person');
              ?>
              <?= $form->field($model, 'trip_customer2')->dropDownList($selectcus,['prompt'=>'Select','name'=>"trip_customer2"])->label('Trip Customer'); ?> 
            </div>
            <div class="form-group" id="alicedev">
              
            </div>
            
        </div>
    <div class="row">  
       <div class='col-sm-2 form-group'> 
                  <?= $form->field($model, 'pickup_type')->dropDownList([ 'airport' => 'Airport', 'general' => 'General'], ['prompt' => 'Select'])->label('Pickup Type') ?>
            </div>
            <div class='col-sm-2 form-group'> 
              <?= $form->field($model, 'trip_type')->dropDownList([ 'pickup' => 'Pickup', 'drop' => 'Drop', ], ['prompt' => 'Select'])->label('Trip Type') ?>
            </div>
            <div class='col-sm-3 form-group'> 
              <?php  $date='';
              $date = date('d-m-Y H:i:s',strtotime($model->trip_date_time));
              if(strpos('1970', $date) || $date=="" || $date==NULL || strpos('0000', $date)){   
                $date = "-";
              } 
              echo $form->field($model, 'trip_date_time')->textInput(['class' => 'form-control','value'=>$date]) ?>
            </div>
             <div class='col-sm-2 form-group'> 
             <?= $form->field($model, 'vehicle_type')->dropDownList([ 'own' => 'Own', 'rent' => 'Rent']) ?>
        </div>
        <div class='col-sm-3 form-group own' > 
            <?php
             $user =   ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->andWhere(['is_trip_asign'=>'yes'])->asArray()->all(),'reg_no','reg_no'); 
              // echo "<pre>";print_r($model);die;

             ?>
             <?= $form->field($model, 'user_id')->dropDownList($user,['class'=>'form-control reg_no','name'=>'own_vehicle','prompt'=>"Select",'value'=>$model->vehicle_number])->label('Vehicle Number'); ?>
             <div id="vehicle_num_own"></div>
        </div> 
        <div class='col-sm-4 form-group rent' style="display: none;"> 
            <?php
             $user =   ArrayHelper::map(OthersVehicleDetails::find()->where(['status'=>'Active'])->asArray()->all(),'reg_no','reg_no'); 

             ?>
             <?= $form->field($model, 'vehicle_number')->dropDownList($user,['prompt'=>"Select",'class'=>'form-control other_reg_no','name'=>'rent_vehicle','value'=>$model->vehicle_number]); ?>
             <div id="vehicle_num"></div>
             <button type="button" class='btn btn-xs btn-success addcomposition'><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="row">
        
     </div>
     <div class="row">
        <div class='col-sm-6 form-group'> 
            <?= $form->field($model, 'driver_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-sm-6 form-group'> 
            <?= $form->field($model, 'driver_contact')->textInput(['maxlength' => 10]) ?>
        </div>
      </div>
<div class="row">
        <div class='col-sm-4 form-group flight' style="display: none;"> 
            <?= $form->field($model, 'flight_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
            <?= $form->field($model, 'remarks')->textarea(['rows' => 2]) ?>
        </div>
        <div class='col-sm-4 form-group'> 
            <?= $form->field($model, 'image_upload')->fileInput(['id'=> 'imgInput', 'class' => '']) ?>
        </div>
        <div class='col-sm-4 form-group' style="margin-top: 25px;">    
          <?php if($model->trip_current_status=="S"){  
       
            echo Html::Button('Trip in Progress', ['class' => 'btn btn-warning pull-right']);
       } else if($model->trip_current_status=="C"){  
          echo Html::Button('Trip Completed', ['class' => 'btn btn-warning pull-right']);
        }
        else{   
        echo Html::button('Save', ['class' => 'btn btn-success pull-right savesub','id'=>'savesub']);

       } ?>
      </div>
</div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">

  $('body').on('change','#tripdetails-customer_name',function(){
    var company =  $("#tripdetails-customer_name").val();
    if(company!="" && company!="undefined"){
      $('#tripcus1').show();
      $('#tripcusadd').show();
    }
  });

  $('body').on('click','.savesub',function(){
    $('#vehicle_num').html('');
    $('#vehicle_num_own').html('');
    var ty = $('#tripdetails-vehicle_type').val();
    if(ty=="own"){
      var frt = $('#tripdetails-user_id').val();
      if(frt=="" && frt=="undefined"){
        $('#vehicle_num').html('Vehicle Number Required');
        return false;
      }
    }else if(ty=='rent'){
      var hjy = $('#tripdetails-vehicle_number').val();
      if(hjy=="" && hjy=="undefined"){
        $('#vehicle_num_own').html('Vehicle Number Required');
        return false;
      }
    }
    $('#my_submit').submit();

  });
  $('body').on('click','#addmore',function(){
    $('#tripcus2').show();
    $('#tripcusadd').hide();
  });


  $('body').on('change','#tripdetails-user_id',function(){
    var regno = $('#tripdetails-user_id').val();
    var vehitype = $('#tripdetails-vehicle_type').val();
    if(vehitype=='own'){
      $.ajax({
          url: '<?php echo Yii::$app->homeUrl . '?r=vehicle-master/vehi-details'; ?>',
          type:'post',
          data:'regno='+regno,
          success:function(response){
            var data = JSON.parse(response);
            $('#tripdetails-driver_name').val(data.name);
            $('#tripdetails-driver_contact').val(data.mobile_number);
          }
      });
    }
                
            })

$val = $("#tripdetails-vehicle_type").val();
     if($val=="own"){
        $(".own").show();
        $(".rent").hide();
      }else{
         $(".rent").show();
         $(".own").hide();
      }

  $val = $("#tripdetails-pickup_type").val();
     if($val=="airport"){
        $(".flight").show();
        
      }else{ 
         $(".flight").hide();
      }
$('body').on("click",".addcomposition",function(){
             var PageUrl = '<?php echo Yii::$app->homeUrl;?>?r=others-vehicle-details/vehicle-create';
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-plus"></i>Add Vehicle</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl);
             return false; });

     $('#tripdetails-trip_date_time').datetimepicker({ format: 'DD-MM-YYYY hh:mm:ss A', minDate: new Date()});

     $('body').on("change","#tripdetails-vehicle_type",function(){
      $val = $(this).val();
      if($val=="own"){
        $(".own").show();
        $(".rent").hide();
      }else{
         $(".rent").show();
         $(".own").hide();
      }
     });
     $('body').on("change","#tripdetails-pickup_type",function(){
      $val = $("#tripdetails-pickup_type").val();
     if($val=="airport"){
        $(".flight").show();
        
      }else{ 
         $(".flight").hide();
      }
     });
     /* $('body').on("change","#tripdetails-pickup_type",function(){
      $val = $(this).val();
      if($val=="own"){
        $(".own").show();
        $(".rent").hide();
      }else{
         $(".rent").show();
         $(".own").hide();
      }
     });
*/
</script>
  <script>
      $("#name").select2({ placeholder: "Select a Vehicle Name"}); 
      $(".reg_no").select2({ placeholder: "Select a Reg Number"}); 
  </script>