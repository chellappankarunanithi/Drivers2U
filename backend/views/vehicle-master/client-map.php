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

$this->title = 'Vehicle Client Assign';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.details{
  color: red !important;
  cursor: pointer;
}
</style>
<div class="vehicle-master-index">

      <div class="box box-primary  ">
      <div class=" ">
   
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?php // Html::a('Add Vehicle', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
    </div> 
     <?php  echo $this->render('_clientsearch', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'vehicle_name',
           // 'vehicle_uniqe_name',
            'reg_no',
             

             ['attribute'=>'driver_name',
              'format'=>'html'],

              ['attribute'=>'client_name',
              'format'=>'raw',
              'value'=>function($model,$keys,$data=''){
                if(!empty($model)){
                    $cl = explode(',', $model->client_id);
                  $clientmap = ClientVehicleMap::find()->where(['IN','client_id',$cl])
                  ->andWhere(['vehicle_id'=>$model->id])->asArray()->all();
                  $clientmaster = ClientMaster::find()->asArray()->all();
                  $clientval = ArrayHelper::map($clientmaster,'id','company_name');
                  $i=1;
                  if(!empty($clientmap)){
                foreach($clientmap as $value){
                //  $print[] = $i.'.&nbsp;'. $clientval[$value['client_id']].'<br>';
                  $print = $clientval[$value['client_id']].'... <span class="details"id="'.$model->id.'"><i class="fa fa-plus-circle"></i><br>';
                  $i++;
                }
                //$prints = implode('',$print);
                return $print;
              }else{
                return 'Not Set';
               }
              }
              }],

            ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{client}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                               
                                   // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                }, 
                             'assign' => function ($url, $model, $key) { 
                                if($model->driver_id==""){ 
                                  return Html::button('Assign  Driver', ['value' => $url, 'style'=>'margin-right:15px;','class' => 'btn btn-success btn-xs driver_assign gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Assign Driver' ]);
                                }else{  
                                  return Html::button('Change Driver', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs driver_assign gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Change Driver' ]);
                                } 
                                      //  return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    }, 

                                    'client' => function ($url, $model, $key) { 
                                if($model->client_id==""){ 
                                  return Html::button('Assign  Client', ['value' => $url, 'style'=>'margin-right:15px;','class' => 'btn btn-success btn-xs client_assign gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Assign Client' ]);
                                }else{  
                                  return Html::button('Change Client', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs client_assign gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Change Client' ]);
                                } 
                                      //  return Html::a('<span class="fa fa-edit"></span>', $url, $options);
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
     $('body').on("click",".driver_assign",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Driver Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });

     $('body').on("click",".client_assign",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Client Details</span>');
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