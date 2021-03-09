<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Triplogin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Triplogins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="triplogin-view">

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            'first_name',
            'last_name',
            'contact_no',
           // 'email:email',
           // 'profile_photo',
            'username',
           // 'password',
           // 'authkey',
            'vehicle_number',
          //  'driver_name',
           // 'created_at',
          //  'updated_ipaddress',
          //  'updated_at',
          //  'user_id',
        ],
    ]) ?>

</div>
