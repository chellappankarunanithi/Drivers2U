<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerDetails */

$this->title = 'Update Customer Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Details', 'url' => ['index']]; 
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-details-update">
 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
