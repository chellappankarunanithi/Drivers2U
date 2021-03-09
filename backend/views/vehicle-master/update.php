<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VehicleMaster */

$this->title = 'Update Vehicle: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Management', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehicle-master-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
