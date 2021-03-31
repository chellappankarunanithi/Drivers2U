<?php

use backend\models\DriverProfile;
use backend\models\ClientMaster;
use backend\models\TripDetails;
/* @var $this yii\web\View */

$this->title = 'Drives2U - Dashboard';

$createtrips = TripDetails::find()->where(['TripStatus'=>'Created'])->asArray()->count();
$activetrips = TripDetails::find()->where(['TripStatus'=>'Activated'])->asArray()->count();
$completetrips = TripDetails::find()->where(['TripStatus'=>'Completed'])->asArray()->count();
$canceltrips = TripDetails::find()->where(['TripStatus'=>'Cancelled'])->asArray()->count();
$trips = TripDetails::find()->asArray()->count();

$customer = ClientMaster::find()->asArray()->count();
$drivers = DriverProfile::find()->asArray()->count();
$occupied = DriverProfile::find()->where(['available_status'=>'1'])->asArray()->count();
$available = DriverProfile::find()->where(['available_status'=>'0'])->asArray()->count();
//Set Default Timezone
date_default_timezone_set('Asia/Kolkata');
?>
<style type="text/css">
	.card {
    position: relative;
    border-radius: 3px;
    padding: 10px;
    background: #ffffff;
    /*border-top: 3px solid #d2d6de;*/
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
}
</style>
          	
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ol>
<section class="content-header">
  

<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Our Customers</span>
              <span class="info-box-number"><?php echo $customer; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div> 
        <div class="clearfix visible-sm-block"></div> 
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><!-- <img src="images/images.png"> --><i class="fa fa-gears"></i> </span>

            <div class="info-box-content">
              <span class="info-box-text">Our Drivers</span>
              <span class="info-box-number"><?php echo $drivers; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-smile-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Vacant Drivers</span>
              <span class="info-box-number"><?php echo $available; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user-secret"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Occupied Drivers</span>
              <span class="info-box-number"><?php echo $occupied; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-car"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">All Trips</span>
              <span class="info-box-number"><?php echo $trips; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-clock-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Created Trips</span>
              <span class="info-box-number"><?php echo $createtrips; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div> 
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-refresh"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Activated Trips</span>
              <span class="info-box-number"><?php echo $activetrips; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-check"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Completed Trips</span>
              <span class="info-box-number"><?php echo $completetrips; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
       <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-close"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Cancelled Trips</span>
              <span class="info-box-number"><?php echo $canceltrips; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div> 
        <div class="clearfix visible-sm-block"></div>
 
        <!-- /.col -->
      
        <!-- /.col -->
      </div>
</section>
<div class="site-index">

</div>
