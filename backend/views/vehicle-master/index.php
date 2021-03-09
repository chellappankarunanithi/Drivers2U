<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\models\ClientMaster;
use backend\models\ClientVehicleMap;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehicleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->title = 'Vehicle Management';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.details{
  color: red !important;
  cursor: pointer;
}
</style>
<div class="vehicle-master-index">
      <div class="box box-primary  ">
      
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'vehicle_name',
           'vehicle_uniqe_name',
            'reg_no',
             
            ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{select}',
                            'buttons'=>[
                              'select' => function ($url, $model, $key) {
                                   return Html::button('<i class="fa fa-plus" aria-hidden="true"></i> Select', ['value' => $model->id, 'style'=>'margin-right:4px;','class' => 'btn btn-success btn-xs view view gridbtncustom Selectfortrip', 'data-toggle'=>'tooltip', 'title' =>'Select for Trip' ]);
                                }, 
                            
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div>

<script type="text/javascript">

     $('body').on("click",".modalView",function(){ 
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Vehicle Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });

      $('body').on("click",".details",function(){
            
             var id = $(this).attr('id'); // alert(id);
            var url = "<?php echo Yii::$app ->homeUrl . '?r=vehicle-master/clientdetails&id='?>"+id;
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Clients Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>