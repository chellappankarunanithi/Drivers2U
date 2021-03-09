<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSolutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    
    .box-header {
    color: #fff;
    background-color: #ff0000;
</style>

<div class="partner-solution-index">
    <div class="box-body">
    <div class="box box-primary cgridoverlap">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-fw fa-street-view"></i> <?= Html::encode($this->title) ?></h3>
        </div><!-- /.box-header -->
    <div class="box-body">
      <p>
     <?= Html::a('<i class="fa fa-plus"></i> Add User', ['create'], ['class' => 'btn btn-primary btn-md pull-right ']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
   <?php Pjax::begin(); ?>
          <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'first_name',
            'last_name',
            //'dob',
            // 'email:email',
            // 'city',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'rights:ntext',

            [
            'header'=> 'Actions',
            'class' => 'yii\grid\ActionColumn'

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
   </div>
  </div>
 </div>
</div>

