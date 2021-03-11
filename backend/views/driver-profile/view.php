<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DriverProfile */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Driver Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-profile-view">

  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'employee_id',
            'name',
            'mobile_number',
            'email:email',
            'address:ntext', 
            'FatherName',
            'MotherName',
            'DOB',
            'Gender',
            'MaritalStatus',
            'SpouseName',
            'HouseDetails',
            'Qualification',
            'PostAppliedFor',
            'Experience',
            'BackgroundCheck',
            'aadhar_no',
            'LicenceNumber',
            'VoteridNumber',
            
        ],
    ]) ?>

</div>
