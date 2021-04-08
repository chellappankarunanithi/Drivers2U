<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use backend\models\DriverProfile;
use backend\models\CommissionMaster;
use backend\models\ClientMaster;
use backend\models\TripDetails;
/* @var $this yii\web\View */
/* @var $model backend\models\DriverProfile */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Driver Management', 'url' => ['driver-management']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-profile-view">
<div class="row">
<div class="col-md-12">
    <div class="box">
    <div class="box-header">
        <h3><?php echo $model->name; ?>'s Commission List</h3>
    </div>
    <div class="box-body">
        
    
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Booking Code</th>
      <th scope="col">Customer Name</th>
      <th scope="col">Trip Status</th>
      <th scope="col">Trip Completed Date</th>
      <th scope="col">Commission Type</th>
      <th scope="col">Commission %</th>
      <th scope="col"  style="text-align:right;">Trip Cost</th>
      <th scope="col"  style="text-align:right;">Driver Commission</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $tripmodel = TripDetails::find()->where(['TripStatus'=>"Completed"])->andWhere(['DriverId'=>$model->id])->asArray()->all();
   $customer = ArrayHelper::map(ClientMaster::find()->asArray()->all(),'id','client_name');
   $commission = ArrayHelper::map(CommissionMaster::find()->where(['Status'=>"Active"])->asArray()->all(),'id','CommissionValue');
   if (!empty($tripmodel)) { $i=1;
       foreach ($tripmodel as $key => $value) {
                $customername = "";
                if (array_key_exists($value['CustomerId'], $customer)) {
                  $customername = $customer[$value['CustomerId']];
                }
                $commissionvalue = $value['DriverCommission'];
                if (array_key_exists($value['CommissionId'], $commission)) {
                  $commissionvalue = $commission[$value['CommissionId']];
                }
           echo '<tr>
                  <th scope="row">'.$i.'</th>
                  <td>'.$value['tripcode'].'</td>
                  <td>'.ucfirst($customername).'</td>
                  <td>'.$value['TripStatus'].'</td>
                  <td>'.date('d-m-Y h:i A', strtotime($value['TripCompleteDate'])).'</td>
                  <td>'.$value['CommissionType'].'</td>
                  <td>'.$commissionvalue.'</td>
                  <td style="text-align:right;"><span class="fa fa-rupee"></span> '.$value['TripCost'].'</td>
                  <td style="text-align:right;"><span class="fa fa-rupee"></span> '.$value['DriverCommission'].'</td>
                </tr>';
           $i++;
       }
   }else{
                echo '<tr> <th colspan="8" style="text-align:center;" scope="row">No trips found!</th></tr>';
   }
    ?>
     
  </tbody>
</table>
     
</div>
</div>
</div>
</div>
</div>
