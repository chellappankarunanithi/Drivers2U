<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Triplogin */

$this->title = 'Create Triplogin';
$this->params['breadcrumbs'][] = ['label' => 'Triplogins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="triplogin-create">
 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
