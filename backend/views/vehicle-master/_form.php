<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\VehicleMaster;
use backend\models\ClientMaster;
use backend\models\DriverProfile;
use yii\helpers\ArrayHelper;
   use yii\helpers\Url;
//use yii\jui\Autocomplete;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
//use yii\helpers\AutoComplete;
/* @var $this yii\web\View */
/* @var $model backend\models\VehicleMaster */
/* @var $form yii\widgets\ActiveForm */
?>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
   <!--script src="https://code.jquery.com/jquery-1.12.4.js"></script--> 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="<?php echo Url::base(); ?>/dist/js/bootstrap3-typeahead.js"></script>
   <script type="text/javascript" src="<?php echo Url::base(); ?>/dist/js/bootstrap3-typeahead.min.js"></script>
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
  /* .checkbox-custom input[type="checkbox"]:checked + label::before {
   background-color: #5fbeaa;
   border-color: #5fbeaa;
   }
   .checkbox label::before {
   -o-transition: 0.3s ease-in-out;
   -webkit-transition: 0.3s ease-in-out;
   background-color: #ffffff;
   /* border-radius: 3px;  
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
   } */
   .dropdown-menu {
    min-width:250px!important;
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
    <div class='col-sm-6 form-group' >
       <?php 
    $items= ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->all(), 'id', 'vehicle_name');
    $student_col_json = json_encode($items);
     ?>
    <?php echo $form->field($model, 'vehicle_name')->textInput(['maxlength' => true,"style"=>"text-transform: uppercase;"]) ?>
</div>
<div class='col-sm-6 form-group' >
     <?= $form->field($model, 'reg_no',['enableAjaxValidation' => true])->textInput(['maxlength' => true,"style"=>"text-transform: uppercase;",'class'=>'reg_no form-control','onkeyup'=>"Patient_details(this.value,event)" ]) ?>
    
</div>
</div>
 <div class="row">
        <div class='col-sm-4 form-group' >

    <?= $form->field($model, 'engine_number')->textInput(['maxlength' => true]) ?>
</div>
<div class='col-sm-4 form-group' >
    <?= $form->field($model, 'frame_number')->textInput(['maxlength' => true])->label('Chassis Number') ?>
</div>

<div class='col-sm-4 form-group' >
             <?php echo $form->field($model, 'fc_expire_date')->textInput(['class' => 'form-control datepicker', 'placeholder' => 'DD-MM-YYYY','bootstrap-datepicker data-date-autoclose' => "true", 'date' => [
            'pluginOptions' => [
                'todayHighlight'=>true,
                'autoclose' => true,
            ],
        ], 'data-required' => "true"])->label('FC Expired Date') ?>
     
        </div>
</div>

   <div class="row">
        <div class='col-sm-4 form-group' >
           <?php echo $form->field($model, 'ins_expired_date')->textInput(['class' => 'form-control datepicker', 'placeholder' => 'DD-MM-YYYY','bootstrap-datepicker data-date-autoclose' => "true", 'date' => [
            'pluginOptions' => [
                'todayHighlight'=>true,
                'autoclose' => true,
            ],
        ], 'data-required' => "true"])->label('Insurance Expired Date') ?>
     
        </div>
         <div class='col-sm-4 form-group' >
          <?php
          $clientlist = ArrayHelper::map(ClientMaster::find()->where(['status'=>"Active"])->asArray()->all(), 'id','company_name');
           ?>
    <?= $form->field($model, 'client_id')->dropDownList($clientlist,['options' => [$model->client_id => ['Selected'=>'selected']],'prompt'=>'Select','data-live-search'=>'true','multiple'=>'true',
         'data-style'=>"btn-default btn-custom1"])->label('Client Name'); ?>
</div>
<div class='col-sm-4 form-group' >
     <?php 
        $users =   ArrayHelper::map(DriverProfile::find()
            ->where(['status'=>'Active'])
           ->andWhere(['available_status'=>"0"])
            ->asArray()->all(),'id','name'); 

        $users1 =   ArrayHelper::map(DriverProfile::find()
            ->where(['id'=>$model->driver_id])
           ->andWhere(['available_status'=>"1"])
            ->asArray()->all(),'id','name'); 
        if(!empty($users1)){
          $users = $users+$users1;
        }
        
        echo $form->field($model, 'driver_id')->dropDownList($users,['options' => [$model->driver_id => ['Selected'=>'selected']],'prompt'=>'Select','data-live-search'=>'true',
         'data-style'=>"btn-default btn-custom1"])->label('Driver Name'); ?>
    <button type="button" class='btn btn-xs btn-success addcomposition'><i class="fa fa-plus"></i></button>
</div>
</div>

<div class="row">
    <div class='col-sm-4 form-group' >
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'rc_book')->fileInput(['id'=> 'imgInp1', 'value'=>$model->rc_book]);  
             }else{     ?>                          
             <?= $form->field($model, 'rc_book')->fileInput(['id'=> 'imgInp1']) ?>
           <?php } 
           if($model->rc_book!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo $model->rc_book;  ?>" />
      <?php } ?>
</div>
<div class='col-sm-4 form-group' >
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'insurance_copy')->fileInput(['id'=> 'imgInp2', 'value'=>$model->insurance_copy]);  
             }else{     ?>                          
             <?= $form->field($model, 'insurance_copy')->fileInput(['id'=> 'imgInp2']) ?>
           <?php } 
           if($model->insurance_copy!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo $model->insurance_copy;  ?>" />
      <?php } ?>
</div>
<div class='col-sm-4 form-group' >
      <?php if(isset($_GET['id'])){
                
               echo $form->field($model, 'tax_copy')->fileInput(['id'=> 'imgInp3', 'value'=>$model->tax_copy]);  
             }else{     ?>                          
             <?= $form->field($model, 'tax_copy')->fileInput(['id'=> 'imgInp3']) ?>
           <?php } 
           if($model->tax_copy!=''){?>
            <img id="blah" class="profile-user-img img-responsive img-circle" src="<?php echo $model->tax_copy;  ?>" />
      <?php } ?>
</div>
</div>


  
  <div class="row">
    
    <div class='col-sm-8'> </div>
      <div class='col-sm-1 form-group' style="margin-top: 25px">
        <?php // echo $model->status; die;
        $ischeck = "";
          if($model->isNewRecord){
            $model->status = 1;
          }else{
            if($model->status=="Active"){
              $ischeck = 'checked';
              $model->status = 1;
            }else{

              $model->status = 0;
            }
          } 
        ?> 
          
            <label class="container-checkbox">Active
              <input type="checkbox" name="VehicleMaster[status]" checked=<?php echo $ischeck; ?>>
  <span class="checkmark-check"></span>
</label>
      </div>
      <div class='col-sm-2 form-group' style="margin-top: 25px">
        <?php // echo $model->status; die;
        $isch = "";
          if($model->isNewRecord){
            $model->is_trip_asign = 1;
            $isch = 'checked';
          }else{
            if($model->is_trip_asign=="yes"){
              $model->is_trip_asign = 1;
              $isch = 'checked';
            }else{
              $model->is_trip_asign = 0;
            }
          } 
        ?> 
        <label class="container-checkbox">On Call
            <input type="checkbox" name="VehicleMaster[is_trip_asign]" <?php echo $isch; ?> >
            <span class="checkmark-check"></span>
        </label>
      </div>
   
  </div>
  <div class="row">
    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
  </div>
  <?php ActiveForm::end(); ?>
  </div>
</div>
</div>
</div>
</div>
 
 
<script type="text/javascript">
  function Patient_details(data,event)
{  
  if(data === '')
  {
    $('#reg_no').val('');
    
  }
}
$('body').on("click",".addcomposition",function(){
             var PageUrl = '<?php echo Yii::$app->homeUrl;?>?r=vehicle-master/driver-create';
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-plus"></i>Add Driver</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl);
             return false; });
 $("#vehiclemaster-vehicle_name").typeahead({   
  source: function(query,result) {  
        $.ajax({
          url:'<?php echo Yii::$app->homeUrl . "?r=vehicle-master/ajaxfetch";?>',
          method:'POST',
          data:{query:query},
          dataType:'json',
          success:function(data)
          { 
            result($.map(data, function(item){ 
              return item.vehicle_name;
            }));
            
          }
        })
  },
  autoSelect: false,
 /* displayText: function(result)
  {

     return result;
  },*/
   
});
  //  Inputmask("A{2} 9{2} A{2} 9{4}").mask($(":input.reg_no"));

 /*   $('.datepicker').datepicker({
            format: 'dd-mm-yyyy', 
            autoclose:true,
            startDate: "today",
            todayHighlight: true

        })*/
        $('#vehiclemaster-fc_expire_date').datepicker({
            format: 'dd-mm-yyyy'
        });
          $('#vehiclemaster-ins_expired_date').datepicker({
            format: 'dd-mm-yyyy'
        });

             $("#supervisermaster-name").on("keypress", function(e) {  
                if(e.which === 8){
                   return true;
                }else if ((!/^[a-zA-Z\. ]*$/.test(String.fromCharCode(e.which )))) {
                      return false;
                  }
              });


             $("#vehiclemaster-driver_id").select2({ placeholder: "Select a Driver Name"}); 
             $("#vehiclemaster-client_id").select2({ placeholder: "Select a Client Name"}); 
         
</script>
