<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Triplogin */

$this->title = 'Update Triplogin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Triplogins', 'url' => ['index']]; 
$this->params['breadcrumbs'][] = 'Update';
?> 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
