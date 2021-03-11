<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DriverProfile */

$this->title = 'Update Driver Management: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Driver Management', 'url' => ['driver-management']]; 
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="driver-profile-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
