<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ClientMaster */

$this->title = 'Add New Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customer Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 
?>
<div class=" ">
<div class="category-management-create">
  <div class="box-body no-pad">
    <?php if (Yii::$app->controller->action->id=="create") { ?>
       <div class="box box-primary">
        <div class="box-header with-border box-header-bg">
           <h3 class="box-title pull-left"> <i class="fa fa-fw fa-plus-square"></i> <?= Html::encode($this->title) ?></h3>
          </div>
       </div>
    <?php } ?>

      <?php if (Yii::$app->controller->action->id=="create") { 
        echo $this->render('_form', ['model' => $model,
        'token_name' => $token_name,]); 
      }else{
        echo $this->render('_customerform', ['model' => $model,'token_name' => $token_name,]); 
      } ?>
 </div>
</div>
</div>
