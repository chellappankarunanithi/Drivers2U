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


   <h3 class="box-title pull-left " ><?= Html::encode("Completed Trips") ?></h3>
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
           // 'VehicleNo',
            'CustomerName',  
            'CustomerContactNo', 
            'DriverName', 
            'DriverContactNo', 
            'TripType',
            'TripStatus', 
           // 'rating', 
            //'Review',

           ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:200px;color:#337ab7;'],
               'template'=>'{view}{rating}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                                
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                },  
                                'rating' => function ($url, $model, $key) {
                                 // if ($model->rating=="") {
                                    $url = Url::base(true).'/trip-rating/'.$model->id;
                                   return Html::button('<span class="fa fa-star"></span> Rating', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs view view gridbtncustom rating', 'data-toggle'=>'tooltip', 'title' =>'Rate the Trip' ]); 
                                 // }
                                },
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
  
</div></div>
</div></div>

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
</script>