<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerDetails */

$this->title = 'Create Customer Details';
$this->params['breadcrumbs'][] = ['label' => 'Customer Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-details-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
