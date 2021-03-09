<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\LeftmenuManagement */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Leftmenu Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leftmenu-management-view">
    <div class="page-header">
                <h4 class="page-title">Left Menu Management</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><?= Html::encode($this->title) ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Elements</li>
                </ol>
            </div>
 <div class="row">
<div class="col-md-12 col-lg-12">
<div class="card">
 


<div class="card-header "> 
<h3 class="card-title ">Left Management</h3> 
<div class="card-options"> 


        <?= Html::a('Delete', ['delete', 'id' => $model->menuId], [

            'class' => 'btn btn-square btn-outline-primary btn-sm ',

            'data' => [

                'confirm' => 'Are you sure you want to delete this item?',

                'method' => 'post',

            ],

        ]) ?>
		<?= Html::a('Update', ['update', 'id' => $model->menuId], ['class' => 'btn btn-square btn-primary btn-sm ml-2 mr-2']) ?>
</div> 
</div>

<div class="card-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'menuId',
            'menuTpe',
            'Name',
            'userUrl',
            'groupId',
            'groupCode',
            'sortOrder',
            'faIcon',
            'activeStatus',
            'createdAt',
            'updatedAt',
        ],
    ]) ?>
</div>
</div>
</div>
</div>
</div>
