<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommissionMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commission Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-management-index">

    <div class="box box-primary  ">
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?= Html::a('Add New Commission', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
      <div class="box-body">
      <div class="table-responsive">
   

<?php Pjax::begin(['id' => 'grid', 'timeout' => false ,'clientOptions' => ['method' => 'POST'] ]); ?> 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'CommissionValue',
             'format'=>'raw',
             'value' => function ($model, $key){
                return $model->CommissionValue.'%';
             },
             'contentOptions'=>['style'=>'text-align:right;']],
            'Status',
           // 'CreatedDate',
           // 'UpdatedDate',

            ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{update}',
                            'buttons'=>[ 
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
                              
                                
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div> 
</div>

<script type="text/javascript">
   
</script>