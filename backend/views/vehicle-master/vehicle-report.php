<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\VehicleMaster;
use backend\models\SuperviserMaster;
use backend\models\ClientMaster;
use backend\models\BunkMaster;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehicleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicle Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-master-index">

      <div class="box box-primary">
        <div class=" box-header with-border box-header-bg"> 
   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3> 
    </div>

    <?php   echo $this->render('_reportsearch', ['model' => $searchModel]); ?>
     <hr>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
       'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
            
                 ['attribute'=>'vehicle_name',
                  'label'=>'Vehicle Number',
                  'format'=>'html',
                'value'=>function($key, $model, $val){  
                $vehic= VehicleMaster::find()->where(['reg_no'=>$key['reg_no']])->asArray()->one();
                if(!empty($vehic)){
                  return $vehic['reg_no'];
                }else{
                  return '-';
                }
              }],

              ['attribute'=>'superviser_id',
                  'label'=>'Supervisor Number',
                  'format'=>'html',
                'value'=>function($key, $model, $val){
               $super= SuperviserMaster::find()->where(['id'=>$key['superviser_id']])->asArray()->one(); 
                if(!empty($super)){
                  return $super['name'];
                }else{
                  return '-';
                }
              }],

               ['attribute'=>'clientname',
                  'label'=>'Client Name',
                  'format'=>'html',
                'value'=>function($key, $model, $val){
              $super= ClientMaster::find()->where(['client_name'=>$key['client_name']])->asArray()->one();
              // echo "<pre>"; print_r($key); die;
                if(!empty($super)){
                  return $super['company_name'];
                }else{
                  return '-';
                }
             }
                ],

              ['attribute'=>'bunk_name',
                  'label'=>'Bunk Name',
                  'format'=>'html',
                'value'=>function($key, $model, $val){
              $super= BunkMaster::find()->where(['id'=>$key['bunk_name']])->asArray()->one();
               //echo "<pre>"; print_r($key); die;
                if(!empty($super)){
                  return $super['bunk_agency_name'];
                }else{
                  return '-';
                }
              }],
             
              'coupon_amount',
              'refuel_amount',
              ['attribute'=>'coupon_status',
                  //'label'=>'Vehicle Number',
                  'format'=>'html',
                'value'=>function($key, $model, $val){   
                if($key['coupon_status']=="C"){
                  return "Closed";
                }else{
                  return "Pending";
                }
              }],

              
           /*['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{view}{update}',
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
                                        return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                              
                                'delete' => function ($url, $model, $key) {
                                   
                                    
                                        return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                                  },
                          ] ],*/
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
</script>