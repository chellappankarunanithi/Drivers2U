<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */

$this->title = 'User Detail View';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
  
  .box-header {
    color: #fff;
    background-color: #ff0000;
}
</style>
<div class="box-body">
    <div class="box box-primary cgridoverlap">
     <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-street-view"></i> <?= Html::encode($this->title) ?></h3>
    </div><!-- /.box-header -->
<div class="userdetails-view">


  <!--   <p class="pull-right">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
 -->

    <div class="col-md-12">

              <!-- Profile Image -->
              
                  <img class="profile-user-img img-responsive img-circle" src="dist/img/user2-160x160.jpg" alt="User profile picture">
                  <h3 class="profile-username text-center"><?= $model->first_name .' '. $model->last_name  ?></h3>
                  <p class="text-muted text-center"><?php echo $model->user_type == 'A' ? 'Admin' : "Others"; ?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>User Name</b> <a class="pull-right"><?= $model->username ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Date of Birth</b> <a class="pull-right"><?php if($model->dob !="0000-00-00"){  echo date('d-m-Y', strtotime($model->dob)); }else{ echo "-"; } ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>City</b> <a class="pull-right"><?= $model->city ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Status</b> <a class="pull-right"><?= $model->status_flag == 'A'? 'Active' : 'Inactive' ?></a>
                    </li>
                  </ul>

                
              
            </div><!-- /.col -->

    
</div>
</div>
</div>