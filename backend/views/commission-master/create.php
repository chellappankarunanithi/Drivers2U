<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CommissionMaster */

$this->title = 'Add Commission Management';
$this->params['breadcrumbs'][] = ['label' => 'Commission Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commission-master-create">

    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>

</div>
