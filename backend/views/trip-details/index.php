<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\SuperviserMaster;
use backend\models\SuperviserClientMap;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trip Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-management-index">
  <div class="row"> 
<div class="card">
    <div class="card-header" >
         <?php echo $this->render("_search.php", ['model' => $searchModel]); ?> 
    </div> 
</div>
</div>
    <div class="box box-primary  ">
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?= Html::a('Add New Trip', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
      <div class="box-body">
      <div class="table-responsive">
  
<?php Pjax::begin(['id' => 'grid', 'timeout' => false ,'clientOptions' => ['method' => 'POST'] ]); ?>     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tripcode',
            [ 'attribute'=>'StartDateTime',
              'label'=>'Trip Date Time',
              'format'=>'raw',
            'value'=> function($model,$key){
                if (strpos('0000', $model->StartDateTime) || strpos('1970', $model->StartDateTime)) {
                  return '-';
                }else{  
                  return date('d-m-Y h:i A', strtotime($model->StartDateTime));
                }
            },
          ],
          
          'UserType',
          "GuestName",
          'GuestContact',
          [ 'attribute'=>'CustomerName',
              'label'=>'Company Name'],
               
            'CustomerContactNo', 
            'DriverName', 
            'DriverContactNo', 
           // 'TripType',
            'TripStatus', 

           ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:200px;color:#337ab7;'],
               'template'=>'{view}{update}{activate}{change-trip}{cancel}{rating}{dutyslip}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                              }, 
                              'update' => function ($url, $model, $key) {
                                  $options = array_merge([
                                      'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                      'data-toggle'=>'tooltip',
                                      'title' => Yii::t('yii', 'Update'),
                                      'aria-label' => Yii::t('yii', 'Update'),
                                      'data-pjax' => '0',
                                  ]);
                                  if ($model->TripStatus=="Booked") {
                                  return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                  }
                              },
                              'change-trip' => function ($url, $model, $key) {
                                 
                                  if ($model->TripStatus=="Activated") {
                                     $url = Url::base(true).'/change-trip/'.$model->id;
                                     $options = array_merge([
                                      'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                      'data-toggle'=>'tooltip',
                                      'title' => Yii::t('yii', 'Change trip'),
                                      'aria-label' => Yii::t('yii', 'Change trip'),
                                      'data-pjax' => '0',
                                  ]); 
                                 if (!strpos('0000', $model->StartDateTime) && !strpos('1970', $model->StartDateTime)) {
                                        $startdate = strtotime($model->StartDateTime); 
                                        $todaydate = date('Y-m-d H:i:s');
                                        $tempdate = date('Y-m-d H:i:s', strtotime('-2 hours', $startdate));
                                        $my_date_time = date("Y-m-d H:i:s", strtotime("+1 hours"));

                                      //  echo $tempdate; die;
                                        $temp = date('d-m-Y h:i A', strtotime('+1 day', $startdate)); 
                                       // if (true) {
                                       // if ($todaydate<$tempdate) {
                                           return Html::a('<span class="fa fa-edit"></span> Change trip', $url, $options);
                                        /* }else{
                                           return Html::button('<span class="fa fa-refresh"></span> Change trip', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom  ', 'data-toggle'=>'tooltip', 'title' =>'You can change trip details before 2 hours from trip start time.']);
                                         }*/
                                       }
                                  }
                              },
                              
                                'activate' => function ($url, $model, $key) { 
                                    $options = array_merge([
                                            'class' => 'btn btn-success btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Activate the Trip'),
                                            'aria-label' => Yii::t('yii', 'Activate the Trip'),
                                            'data-pjax' => '0',
                                        ]);
                                       if ($model->TripStatus=="Booked") {  
                                        $url = Url::base(true).'/activate/'.$model->id;

                                        if (!strpos('0000', $model->StartDateTime) && !strpos('1970', $model->StartDateTime)) {
                                            $startdate = strtotime($model->StartDateTime); 
                                            $todaydate = date('Y-m-d H:i:s');
                                            $tempdate = date('Y-m-d H:i:s', strtotime('-1 day', $startdate));
                                            $temp = date('d-m-Y h:i A', strtotime('+1 day', $startdate));
                                           // echo $tempdate; die;
                                           // if ($todaydate>=$tempdate) {
                                                    $options = array_merge([
                                                        'class' => 'btn btn-success btn-xs update gridbtncustom',
                                                        'data-toggle'=>'tooltip',
                                                        'title' => Yii::t('yii', 'Activate the Trip'),
                                                        'aria-label' => Yii::t('yii', 'Activate the Trip'),
                                                        'data-pjax' => '0',
                                                    ]); 

                                            return Html::a('<span class="fa fa-refresh"></span> Activate', $url, $options);
                                           /* }else{
                                                 return Html::button('<span class="fa fa-refresh"></span> Activate', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom  ', 'data-toggle'=>'tooltip', 'title' =>'Trip activate before 24 Hours from trip start date. trip activate enable at '.$temp ]); 
                                            }*/
                                        }else{ 
                                            return '-';
                                        }
                                      }else if ($model->TripStatus=="Activated") {

                                        $options = array_merge([
                                            'class' => 'btn btn-success btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Complete the Trip'),
                                            'aria-label' => Yii::t('yii', 'Complete the Trip'),
                                            'data-pjax' => '0',
                                        ]);

                                        $url = Url::base(true).'/complete/'.$model->id;
                                        return Html::a('<span class="fa fa-check"></span> Complete', $url, $options);
                                      }
                                      else if ($model->TripStatus=="Cancelled") {  
                                       if ($model->CancelFeeStatus=="No") {  
                                          $url = Url::base(true).'/cancel-payment/'.$model->id;
                                            return Html::button('<span class="fa fa-inr"></span> Cancel Payment', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-success btn-xs view view gridbtncustom Cancelpayment', 'data-toggle'=>'tooltip', 'title' =>'Cancel Payment' ]); 
                                        }
                                      }
                                       
                                  }, 

                                  'rating' => function ($url, $model, $key) {
                                        if ($model->TripStatus=="Completed") {  
                                           $url = Url::base(true).'/trip-rating/'.$model->id;
                                           return Html::button('<span class="fa fa-star"></span> Rating', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs view view gridbtncustom rating', 'data-toggle'=>'tooltip', 'title' =>'Rate the Trip' ]);
                                         }
                                  },
                                  'dutyslip' => function ($url, $model, $key) {
                                        if ($model->TripStatus!="Booked" && $model->TripStatus!="Cancelled") {  
                                            

                                           $options = array_merge([
                                            'class' => 'btn bg-black btn-xs',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Duty Slip'),
                                            'aria-label' => Yii::t('yii', 'Duty Slip'),
                                            'data-pjax' => '0',
                                            'target'=>"_blank",
                                        ]); 
                                        $url = Url::base(true).'/dutyslip?id='.base64_encode($model->id);
                                         
                                        return Html::a('<span class="fa fa-print"></span>&nbsp;Duty Slip', $url, $options); 
                                         }
                                  },
                                  'cancel' => function ($url, $model, $key) {   
                                        $options = array_merge([
                                            'class' => 'btn btn-danger btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Cancel the Trip'),
                                            'aria-label' => Yii::t('yii', 'Cancel the Trip'),
                                            'data-pjax' => '0',
                                        ]); 
                                        if ($model->TripStatus=="Activated") {
                                          $url = Url::base(true).'/cancel/'.$model->id;
                                          return Html::a('<span class="fa fa-close"></span> Cancel', $url, $options);
                                        } 
                                  },
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
  </div> 
</div>
</div>
</div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Trip Information </span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
     $('body').on("click",".rating",function(){
             var url = $(this).attr('value');
             $('#operationalheader_large').html('<span> <i class="fa fa-fw fa-th-large"></i>Rate the trip</span>');
             $('#operationalmodal_large').modal('show').find('#modalContenttwo_large').load(url);
             return false;
         });

       $('body').on("click",".details",function(){ 
             var id = $(this).attr('id'); // alert(id);
            var url = "<?php echo Yii::$app ->homeUrl . '?r=vehicle-master/superviserdetails&id='?>"+id;
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Supervisor Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
        $('body').on("click",".Cancelpayment",function(){ 
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Cancel Payment</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>