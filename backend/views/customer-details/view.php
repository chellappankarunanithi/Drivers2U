<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-details-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            'clientname',
            'contact_person',
            'contact_person_designation',
            'company_contact_no',
           // 'company_email:email',
            'company_address:ntext',
            'personal_contact_no',
            //'personal_email:email',
            'personal_address:ntext',
            //'company_pincode',
            //'personal_pincode',
           // 'created_at',
           // 'updated_at',
           // 'updated_ipaddress',
        ],
    ]) ?>

</div>
