<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ClientMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-master-view">

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'UserType',
            'company_name',
            'client_name',
            'mobile_no',
            'email_id:email',
            'address:ntext',
            'pincode', 
            
        ],
    ]) ?>

</div>
