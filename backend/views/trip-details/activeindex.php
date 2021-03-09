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


   <h3 class="box-title pull-left " ><?= Html::encode("Active Trips") ?></h3>
   <?= Html::a('Add New Trip', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
      <div class="box-body">
      <div class="table-responsive">
    
<?php Pjax::begin(['id' => 'grid', 'timeout' => false ,'clientOptions' => ['method' => 'POST'] ]); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tripcode',
            [ 'attribute'=>'StartDateTime',
              'label'=>'Trip Date time',
              'format'=>'raw',
            'value'=> function($model,$key){
                if (strpos('0000', $model->StartDateTime) || strpos('1970', $model->StartDateTime)) {
                  return '-';
                }else{  
                  return date('d-m-Y h:i A', strtotime($model->StartDateTime));
                }
            },
          ],
            'CustomerName',  
            'CustomerContactNo', 
            'DriverName', 
            'DriverContactNo', 
            'TripType',
            'TripStatus', 

           ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:200px;color:#337ab7;'],
               'template'=>'{view}{activate}{change-trip}{cancel}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                               
                                   // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
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
                                        if ($todaydate<$tempdate) {
                                           return Html::a('<span class="fa fa-edit"></span> Change trip', $url, $options);
                                         }else{
                                           return Html::button('<span class="fa fa-refresh"></span> Change trip', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom  ', 'data-toggle'=>'tooltip', 'title' =>'You can change trip details before 2 hours from trip start time.']);
                                         }
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
                                      if ($model->TripStatus=="Activated") {

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
       $('body').on("click",".details",function(){
            
             var id = $(this).attr('id'); // alert(id);
            var url = "<?php echo Yii::$app ->homeUrl . '?r=vehicle-master/superviserdetails&id='?>"+id;
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Supervisor Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>