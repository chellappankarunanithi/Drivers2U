<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TripDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trip Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="trip-details-view">

   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'tripcode',
            'CustomerName',
            'CustomerContactNo',
            'DriverName',
            'DriverContactNo', 
            'TripType',
            //'TripScheduleType',
            //'ChangeTrip',
           // 'Changeof',
            //'ChangeReason:ntext',
            'TripStartLoc:ntext',
            'TripEndLoc:ntext',
            'StartDateTime',
            'EndDateTime',
            'TripCost',
            'CommissionType',
            'AdminCommission',
            'DriverCommission',
            'rating',
            'Review:ntext',
            'TripStatus',
            'CreatedDate',
            //'UpdatedDate',
            //'UpdatedIpaddress:ntext',
        ],
    ]) ?>

</div>
