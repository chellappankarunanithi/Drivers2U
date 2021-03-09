<?php
  
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;  
$session = Yii::$app->session;
?>
 

<div class="row">
  <div class="col-sm-12">
    <div class="panel">
        <div class="panel-body iconfont text-center">
       
           <?php if ($status=="Activated") { ?>
           <div class="row">  
            <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>
           <div class="col-sm-12"> <h3 class="text-center">This trip is already activated Successfully!</h3></div>
           <div class="text-center" style="width: 100%;"> <a href="<?php echo Url::base(true)?>/active-index" class="btn btn-sm btn-primary" type="button">Go to Trip Details</a> </div>
          </div>   
          <?php } elseif ($status=="Completed") { ?>
           <div class="row">  
            <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>
           <div class="col-sm-12"> <h3 class="text-center">This trip is Completed Successfully!</h3></div>
           <div class="text-center" style="width: 100%;"> <a href="<?php echo Url::base(true)?>/complete-index" class="btn btn-sm btn-primary" type="button">Go to Trip Details</a> </div>
          </div>   
          <?php  } elseif ($status=="Cancelled") { ?>
           <div class="row">  
            <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div>
           <div class="col-sm-12"> <h3 class="text-center">This trip is Cancelled Successfully!</h3></div>
           <div class="text-center" style="width: 100%;"> <a href="<?php echo Url::base(true)?>/cancel-index" class="btn btn-sm btn-primary" type="button">Go to Trip Details</a> </div>
          </div>   
          <?php } ?>
        </div>
    </div>
  </div>
</div>
 

  
                    