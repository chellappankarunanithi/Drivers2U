<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\TripDetails;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DriverProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Driver Management';
$this->params['breadcrumbs'][] = $this->title;
?>
   
<div class="vehicle-master-index">
    <div class="row"> 
        <div class="card">
            <div class="card-header" >
                 <?php echo $this->render("_search.php", ['model' => $searchModel]); ?> 
            </div> 
        </div>
    </div>



      <div class="box box-primary"> 
        <div class=" box-header with-border box-header-bg">
   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   
<div  class="pull-right col-md-2">
        <?= Html::a('Add New Driver', ['create'], ['class' => 'btn btn-success btn-sm pull-right']) ?>
     </div>
    </div>
 <div class=" box-body">
<?php Pjax::begin(['id' => 'grid', 'timeout' => false ,'clientOptions' => ['method' => 'POST'] ]); ?>     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            'employee_id',
            'name',
            'mobile_number', 
            // 'address:ntext',
             [
                    'attribute' => 'profile_photo',
                    'format' => 'html',    
                    'value' => function ($data) {
                        return Html::img($data->profile_photo,
                            ['width' => '80px']);
                    },
                ],
            // 'profile_photo',
            // 'licence_copy',
            [
                'attribute' => 'id',
                'label' => 'Total Commission',
                'format' => 'html',    
                'filter' => false,    
                'value' => function ($data) {
                $tripdetails = TripDetails::find()->where(['DriverId'=>$data->id])->andWhere(['TripStatus'=>'Completed'])->asArray()->all();
                    $totalfare=0;
                    if (!empty($tripdetails)) { 
                        foreach ($tripdetails as $key => $value) {
                            $totalfare += $value['DriverCommission'];
                        }
                    }
                    return $totalfare;
                },
            ],
             'aadhar_no',
            // 'pancard_no',
            // 'created_at',
            // 'modified_at',
            // 'updated_ipaddress',

            ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{view}{update}{licence}{aadhar}{voterid}{rationcard}{policeverification}{profile}',
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
                                    
                                'resignation' => function ($url, $model, $key) {
                                        return Html::button('<i class="fa fa-sign-out"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalResign', 'data-toggle'=>'tooltip', 'title' =>'Resignation' ]);
                                  },

                                   'profile' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-success btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Profile Image'),
                                            'aria-label' => Yii::t('yii', 'Profile Image'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-download"></span>', $url, $options);
                                    },


                                     'licence' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn bg-navy btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Licence Copy'),
                                            'aria-label' => Yii::t('yii', 'Licence Copy'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-download"></span>', $url, $options);
                                    },


                                    /* 'voterid' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn bg-navy btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Voter Id'),
                                            'aria-label' => Yii::t('yii', 'Voter Id'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-download"></span>', $url, $options);
                                    },*/

                                     'policeverification' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn bg-navy btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Police Verification Copy'),
                                            'aria-label' => Yii::t('yii', 'Police Verification Copy'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-download"></span>', $url, $options);
                                    },

                                     'aadhar' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn bg-purple btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Adhaar Copy'),
                                            'aria-label' => Yii::t('yii', 'Adhaar Copy'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-download"></span>', $url, $options);
                                    },


                                     'rationcard' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-info btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Ration Card / Voter ID Copy'),
                                            'aria-label' => Yii::t('yii', 'Ration Card / Voter ID Copy'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-download"></span>', $url, $options);
                                    },
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Driver Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         }); 
         $('body').on("click",".modalResign",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Driver Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>
