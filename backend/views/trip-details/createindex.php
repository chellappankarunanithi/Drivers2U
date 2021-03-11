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
   <h3 class="box-title pull-left " ><?= Html::encode("Booked Trips") ?></h3>
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
            'TripType',
            'TripStatus', 

           ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:200px;color:#337ab7;'],
               'template'=>'{view}{activate}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                               
                                   // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
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
                                        return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                              
                                'activate' => function ($url, $model, $key) { 
                                   
                                      if ($model->TripStatus=="Booked") {  
                                        $url = Url::base(true).'/activate/'.$model->id;

                                        if (!strpos('0000', $model->StartDateTime) && !strpos('1970', $model->StartDateTime)) {
                                            $startdate = strtotime($model->StartDateTime); 
                                            $todaydate = date('Y-m-d H:i:s');
                                            $tempdate = date('Y-m-d H:i:s', strtotime('-1 day', $startdate));
                                            $temp = date('d-m-Y h:i A', strtotime('+1 day', $startdate));
                                           // echo $tempdate; die;
                                            if ($todaydate>=$tempdate) {
                                                    $options = array_merge([
                                                        'class' => 'btn btn-success btn-xs update gridbtncustom',
                                                        'data-toggle'=>'tooltip',
                                                        'title' => Yii::t('yii', 'Activate the Trip'),
                                                        'aria-label' => Yii::t('yii', 'Activate the Trip'),
                                                        'data-pjax' => '0',
                                                    ]); 

                                            return Html::a('<span class="fa fa-refresh"></span> Activate', $url, $options);
                                            }else{
                                                 return Html::button('<span class="fa fa-refresh"></span> Activate', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom  ', 'data-toggle'=>'tooltip', 'title' =>'Trip activate before 24 Hours from trip start date. trip activate enable at '.$temp ]);
                                                return '-';
                                            }
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
                                        return Html::a('<span class="fa fa-refresh"></span> Complete', $url, $options);
                                      }
                                  }, 
                                   'cancel' => function ($url, $model, $key) { 
                                   
                                      if ($model->TripStatus=="Booked") {
                                        
                                        $options = array_merge([
                                            'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Cancel the Trip'),
                                            'aria-label' => Yii::t('yii', 'Cancel the Trip'),
                                            'data-pjax' => '0',
                                        ]);

                                        $url = Url::base(true).'/canceltrip/'.$model->id;
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
       $('body').on("click",".details",function(){
            
             var id = $(this).attr('id'); // alert(id);
            var url = "<?php echo Yii::$app ->homeUrl . '?r=vehicle-master/superviserdetails&id='?>"+id;
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Supervisor Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>