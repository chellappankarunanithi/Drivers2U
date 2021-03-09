<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TripLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trip Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Trip Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'logId',
            'tripId',
            'customerId',
            'tripStatus',
            'tripDetails:ntext',
            //'createdAt',
            //'updatedAt',
            //'updatedIpAddress',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
