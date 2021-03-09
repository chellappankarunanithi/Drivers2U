<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VehicleMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-master-view">
 <?php
 if(!empty($ClientMaster)){
  $i=1;
  echo "<table class='table table-bordered table-responsive'><tr><thead><th>S.NO</th><th>Client Name</th><th>Contact Person Name</th></tr></<thead>";
  foreach ($ClientMaster as $key => $value) {
   echo "<tbody><tr><td>".$i."</td><td>".$value['company_name']."</td><td>".$value['client_name']."</td></tr></<tbody>";
   $i++;
  }
  echo "</table>";
 }else{
  echo "<table><tr><th>No Clients Found</td></tr></table>";
 }
  ?>

</div>
