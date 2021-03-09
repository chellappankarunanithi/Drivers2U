<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AllenApiLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allen Api Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-management-index">

    <div class="box box-primary  ">
      <div class=" ">
   
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
 
    </div>
    </div> 
    <?php Pjax::begin(); ?>
     

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          [
               
                 'attribute' => 'data',
            'headerOptions' =>['style'=>'color:#ff0000;'],
            'format' => 'html',
                
                'headerOptions' => ['class' => 'actionPartnername'],
                 'value' => function($model, $key, $index)
            {   
                if($model->data!='')
                {
                    return  "<pre style='white-space:normal;width:200px;height:200px;'> ".$model->data ."</pre>";
                }
        
                
            },
            ],
      
      
            'event',
           // 'response',
           
           [
               
                 'attribute' => 'response',
            'headerOptions' =>['style'=>'color:#ff0000;'],
            'format' => 'html',
                
                'headerOptions' => ['class' => 'actionPartnername'],
                 'value' => function($model, $key, $index)
            {   
                if($model->response!='')
                {
                    return  "<pre style='white-space:normal;width:200px;height:200px;'> ".$model->response ."</pre>";
                }
        
                
            },
            ],
            'created_at',
         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div></div>
