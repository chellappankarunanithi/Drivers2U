<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehicleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coupon Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-master-index">

      <div class="box box-primary">
        <div class=" box-header with-border box-header-bg"> 
   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3> 
    </div>

    <?php   echo $this->render('_couponsearch', ['model' => $searchModel]); ?>
     <hr>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
    ]); ?>
<?php Pjax::end(); ?></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Vehicle Details</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>