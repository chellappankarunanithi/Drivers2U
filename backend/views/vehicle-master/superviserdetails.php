<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VehicleMaster */
// /echo "<pre>"; print_r($ClientMaster); die;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-master-view">
 <?php
 if(!empty($ClientMaster)){
  $i=1;
  echo "<table class='table table-bordered table-responsive'><tr><thead><th>S.NO</th><th>Supervisor Name</th><th>Contact No</th></tr></<thead>";
  foreach ($ClientMaster as $key => $value) {
   echo "<tbody><tr><td>".$i."</td><td>".$value['name']."</td><td>".$value['mobile_no']."</td></tr></<tbody>";
   $i++;
  }
  echo "</table>";
 }else{
  echo "<table><tr><th>No Supervisors Found</td></tr></table>";
 }
  ?>

</div>
