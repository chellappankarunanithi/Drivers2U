<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CommissionMaster */

$this->title = 'Update Commission Management: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Commission Management', 'url' => ['index']]; 
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="commission-master-update"> 

    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>

</div>
