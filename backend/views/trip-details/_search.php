<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TripDetails;
use yii\helpers\ArrayHelper;
use yii\db\Query;
/* @var $this yii\web\View */
/* @var $model backend\models\MerchantMasterSearch */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;
 
 $Created = TripDetails::find()->where(['TripStatus'=>'Booked'])->asArray()->count();
 $Activated = TripDetails::find()->where(['TripStatus'=>'Activated'])->asArray()->count();
 $cancelled = TripDetails::find()->where(['TripStatus'=>'Cancelled'])->asArray()->count();
 $completed = TripDetails::find()->where(['TripStatus'=>'Completed'])->asArray()->count();
 $all = TripDetails::find()->asArray()->count();

        
?>
<style type="text/css">
nav.nav-menu-tab a{
    background-color:#fff;
    
    padding: 8px;
    color: #000;
}
nav.nav-menu-tab a.active{
    background-color:#337ab7;
    color:#fff;
}
nav.nav-menu-tab a.active:hover{
    color:#fff;
}
nav.nav-menu-tab a:hover{
    color:#000;
}

</style>
   <div class="col-sm-12">
      <div class="panel">
        <div class="panel-body">
        <div class="merchant-master-search">
            <nav class="nav nav-menu-tab"> 
              <a class="nav-link" href="trip-index"><?php echo 'All Trips ('.$all.')'; ?></a>
              <a class="nav-link" href="create-index"><?php echo 'Booked Trips ('.$Created.')'; ?></a>
              <a class="nav-link" href="active-index"><?php echo 'On Trips ('.$Activated.')'; ?></a> 
              <a class="nav-link" href="cancel-index"><?php echo 'Cancelled Trips ('.$cancelled.')'; ?></a> 
              <a class="nav-link" href="complete-index"><?php echo 'Completed Trips ('.$completed.')'; ?></a> 
            </nav> 
        </div> 
    </div>
    </div>
</div>
    
<script type="text/javascript">
    $(document).ready(function () { 
        var action = '<?php echo $action; ?>';
        $( ".nav-link" ).each(function( index ) {
               var active = $(this).attr("href");
               if (active==action) {
                $(this).addClass("active");
               }

        });
    });
</script>