<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\models\ClientMaster;
use backend\models\ClientVehicleMap;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehicleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Closed Coupons';
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
  
    </div>
    </div> 
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
          //  'vehicle_name',
           // 'vehicle_uniqe_name',
            //'reg_no',
            //'fc_expire_date',
             
           ['attribute'=>'vehiclename',
           'label'=>'Vehicle Name',
              'format'=>'html'],

              ['attribute'=>'supervisorname',
              'label'=>'Supervisor Name',
              'format'=>'html'],
             /* ['attribute'=>'client_name',
              'format'=>'html'],*/
              ['attribute'=>'clientname',
                'label'=>'Client Name',
              'format'=>'raw'
               ], 
              'coupon_amount',
              'refuel_amount',

            ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{download}',
                            'buttons'=>[

                              'download' => function ($url, $model, $key) {
                                 
                            
                                   if($model->refuel_receipt!=""){
                                    
                             $return_btu=" ".Html::button('<i class="fa fa-fw fa-download"></i>Receipt', ['value' => Url::to(['vehicle-master/downdata', 'id' => $model->id] ), 'class' => 'btn bg-gray btn-flat btn-xs gallerymultiples']);
                                     return $return_btu; 
                                     }
                                     
                          
                                 },

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
                              
                                'delete' => function ($url, $model, $key) {  
                                        return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
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

       $(document).on('click', '.gallerymultiples:button', function () {
     var PageUrl = $(this).attr('value');
    //  var PageUrl = '<?php echo Yii::$app->homeUrl . '?r=vehicle-master/downdata'; ?>';
      window.location.href=PageUrl;
        
  });
</script>