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
   <h3 class="box-title pull-left " ><?= Html::encode("Cancelled Trips") ?></h3>
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
            'VehicleNo',
            'CustomerName',  
            'CustomerContactNo', 
            'DriverName', 
            'DriverContactNo', 
            'TripType',
            'TripStatus', 

           ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:200px;color:#337ab7;'],
               'template'=>'{view}{update}{cancel-payment}',
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
                              
                                'cancel-payment' => function ($url, $model, $key) { 
                                   
                                      if ($model->CancelFeeStatus=="No") {  
                                        $url = Url::base(true).'/cancel-payment/'.$model->id;
                                         return Html::button('<span class="fa fa-inr"></span> Cancel Payment', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-success btn-xs view view gridbtncustom Cancelpayment', 'data-toggle'=>'tooltip', 'title' =>'Cancel Payment' ]); 
                                      }
                                  }, 
                                  
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-inr"></i>View Trip Information </span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });


     $('body').on("click",".Cancelpayment",function(){ 
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Cancel Payment</span>');
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