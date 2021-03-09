<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VehicleMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-master-view">
 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'vehicle_name',
            //'vehicle_uniqe_name',

            'reg_no',
            ['attribute'=>'driver_name',
              'format'=>'html'],
              ['attribute'=>'client_name',
              'format'=>'html'],

            'fc_expire_date',
            'status', 
        ],
    ]) ?>

</div>
