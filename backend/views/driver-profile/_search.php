<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\DriverProfile;
use yii\helpers\ArrayHelper;
use yii\db\Query;
/* @var $this yii\web\View */
/* @var $model backend\models\MerchantMasterSearch */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;
 
 $availabe = DriverProfile::find()->where(['available_status'=>'0'])->asArray()->count();
 $unavailable = DriverProfile::find()->where(['available_status'=>'1'])->asArray()->count();  

        
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
              <a class="nav-link" href="driver-management"><?php echo 'Vacant Drivers ('.$availabe.')'; ?></a> 
              <a class="nav-link" href="unavailable-driver-management"><?php echo 'Occupied Drivers ('.$unavailable.')'; ?></a> 
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