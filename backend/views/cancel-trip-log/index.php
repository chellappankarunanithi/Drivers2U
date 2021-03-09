<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CancelTripLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cancel Trip Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancel-trip-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cancel Trip Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'TripId',
            'CustomerId',
            'DriverId',
            'CancelFees',
            //'CancelReason:ntext',
            //'PaymentStatus',
            //'CreatedDate',
            //'UpdatedIpaddress',
            //'UpdatedDate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
