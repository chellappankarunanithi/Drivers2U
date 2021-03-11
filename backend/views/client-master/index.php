<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\ClientMaster;
use backend\models\SuperviserClientMap;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-management-index">

    <div class="box box-primary  ">
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?= Html::a('Add New Customer', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
      <div class="box-body">
      <div class="table-responsive"> 
<?php Pjax::begin(['id' => 'grid', 'timeout' => false , 'clientOptions' => ['method' => 'POST'] ]); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       /* 'pager' => [ 
          'linkOptions' => [

            'data-pjax' => 0

        ]  
        ],*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             
            'company_name',
            'client_name',  
            'mobile_no', 
            'Landmark',
            'address:ntext',
            'pincode',
            'status',

           ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{update}{customer-otp}',
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
                                    'customer-otp' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-primary btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Otp Verification'),
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                        ]);
                                        $url = Url::base(true).'/customer-otp/'.$model->id;
                                        if ($model->status!="Active") {
                                        return Html::a('<span class="fa fa-check"></span>', $url, $options);
                                        }
                                    },
                              
                                'delete' => function ($url, $model, $key) {
                                   
                                    
                                        return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                                  },
                          ] ],
        ],
 
    ]);
     ?>
<?php Pjax::end(); ?>
 
</div></div>
</div></div>
<script type="text/javascript">

     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Customer Management </span>');
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