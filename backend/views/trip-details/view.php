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
            'TripStartLoc1:ntext',
            'TripStartLoc2:ntext',
            'TripEndLoc1:ntext',
            'TripEndLoc2:ntext',
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
