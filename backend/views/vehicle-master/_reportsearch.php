<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\Coupon;
use backend\models\VehicleMaster;
use backend\models\SuperviserMaster;
use backend\models\ClientMaster;

/* @var $this yii\web\View */
/* @var $model backend\models\TrophyRegSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" type="text/css" media="screen" href="dist/css/select2.css" />
 <script  src="dist/js/select2.js"></script>
 <style type="text/css">
     .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 0px;
    height: 34px;
}
 </style>
 <?php 
 $fromdate = $todate = $reg_no=$superviser=$client=$coupon_status='';
if(isset($_GET['fromdate']) && $_GET['fromdate']!=""){
  $fromdate = $_GET['fromdate'];
}
if(isset($_GET['todate']) && $_GET['todate']!=""){
  $todate = $_GET['todate'];
}
if(isset($_GET['reg_no']) && $_GET['reg_no']!=""){
  $reg_no = $_GET['reg_no'];
}
if(isset($_GET['superviser']) && $_GET['superviser']!=""){
  $superviser = $_GET['superviser'];
}
if(isset($_GET['client']) && $_GET['client']!=""){
  $client = $_GET['client'];
}
if(isset($_GET['coupon_status']) && $_GET['coupon_status']!=""){
  $coupon_status = $_GET['coupon_status'];
}
  ?>
<div class="trophy-reg-search">

    <?php $form = ActiveForm::begin([
        'action' => ['vehicle-report'],
        'id'=>'vehicle_report_form',
        'method' => 'get',
    ]); ?>

     <div class="col-md-12">
        <div class="col-md-2">
     <?= $form->field($model, 'created_at')->textInput(['class' => 'form-control datepickercr', 'placeholder' => 'DD-MM-YYYY', 'bootstrap-datepicker data-date-autoclose' => "true", 'data-required' => "true",
     'data-provide' => "datepicker", 'name'=>'fromdate', 'value'=>$fromdate, 'id'=>'fromdate', 'data-date-format' => "dd-mm-yyyy",'required'=>false])->label('Coupon Start Date') ?>
     </div>

    <div class="col-md-2">
          <?= $form->field($model, 'created_at')->textInput(['class' => 'form-control datepickerup', 'placeholder' => 'DD-MM-YYYY', 'bootstrap-datepicker data-date-autoclose' => "true", 'data-required' => "true", 'name'=>'todate', 'id'=>'todate', 'value'=>$todate,
         'data-provide' => "datepicker", 'data-date-format' => "dd-mm-yyyy",'required'=>false])->label('Coupon End Date') ?>
    </div>

     <div class="col-md-2">  
    <?php $models= VehicleMaster::find()->where(["status"=>"Active"])->AsArray()->all();
          $list =ArrayHelper::map($models,'id','reg_no');
     ?>
       <?= $form->field($model, 'reg_no')->dropDownList($list,['prompt'=>'Select','data-live-search'=>'true','data-style'=>"btn-default btn-custom1",'name'=>'reg_no', 'value'=>$reg_no, 'id'=>'reg_no', 'style'=>'width:150px;'])->label('Vehicle No') ;?>
</div>

  <div class="col-md-2">  
    <?php $models= SuperviserMaster::find()->where(["status"=>"Active"])->AsArray()->all();
          $array1=array();
          $list1 =ArrayHelper::map($models,'id','name');
          $list3 =ArrayHelper::map($models,'id','employee_id');  
        foreach ($list1 as $key => $value) {

            $array1[$key] =  ucwords($value).'-'.$list3[$key];
        }
        //  echo "<pre>"; print_r($array1); die;
     ?>
       <?= $form->field($model, 'reg_no')->dropDownList($array1,['prompt'=>'Select','data-live-search'=>'true','data-style'=>"btn-default btn-custom1", 'name'=>'superviser', 'id'=>'superviser', 'value'=>$superviser, 'style'=>'width:150px;'])->label('Supervisor') ;?>
</div>
   <div class="col-md-2">  
    <?php $models= ClientMaster::find()->where(["status"=>"Active"])->AsArray()->all();
          $list2 =ArrayHelper::map($models,'id','company_name');
     ?>
       <?= $form->field($model, 'reg_no')->dropDownList($list2,['prompt'=>'Select','data-live-search'=>'true','data-style'=>"btn-default btn-custom1", 'value'=>$client, 'name'=>'client', 'id'=>'client','style'=>'width:160px;'])->label('Client') ;?>
</div>
 <div class="col-md-2">  
     <?php
         // echo "<pre>"; print_r($array1); die;
     ?>
       <?= $form->field($model, 'reg_no')->dropDownList(['C'=>'Closed','P'=>'Pending'],['prompt'=>'All', 'name'=>'coupon_status', 'value'=>$coupon_status, 'id'=>'coupon_status','style'=>'width:150px;'])->label('Coupon Status') ;?>
</div>
    </div> 
    <div class="col-md-12 col-xs-12">
        <div class="col-md-4" style="margin-top: 25px;">
        </div>
          <div class="col-md-3" style="margin-top: 25px; width: 18%;">
       
 <?= Html::submitButton('<i class="fa fa-fw fa-search "></i> Search', ['class'=>'btn btn-primary search'], ['class' => 'btn btn-primary btn-sm search pull-right']); ?>
 <?= Html::a('Reset', ['vehicle-report'], ['class' => 'btn btn-default']) ?>
</div>

<div class="col-md-2" style="margin-top: 25px;">
       
 <?= Html::Button('<i class="fa fa-fw fa-download "></i> Download', ['class'=>'btn btn-info download'], ['class' => 'btn btn-info download btn-sm pull-right']); ?>
</div>
    </div>
    <?php ActiveForm::end(); ?> 
</div>
 <script type="text/javascript">
     $("#reg_no").select2({ placeholder: "All"}); 
     $("#superviser").select2({ placeholder: "All"}); 
     $("#client").select2({ placeholder: "All"}); 


 $('body').on('click', '.download',function() {
  var from=$('#fromdate').val();
  var to=$('#todate').val();
  var reg_no=$('#reg_no').val();
  var client=$('#client').val();
  var supervisor=$('#superviser').val();
  var coupon_status=$('#coupon_status').val();
  //alert(branch);
  /*if(from=="" || to==""){
    alert('All Fields or Required');
  }else{*/
    window.location = '<?php echo Yii::$app->homeUrl .'?r=vehicle-master/vehicle-wise-report&fromdate='; ?>'+from+'&todate='+to+'&reg_no='+reg_no+'&client='+client+'&superviser='+supervisor+'&coupon_status='+coupon_status;
 // }
});

    /* $('body').on('click','.search',function(){   
            
            $.ajax({
                url: '<?php echo Yii::$app->homeUrl . '?r=vehicle-master/vehicle-report'; ?>',
                type:'post',
                data:$('#vehicle_report_form').serialize(),
                success:function(response){
                    //window.location.href=response;
                    
                }
            });
            
        })*/
 </script>