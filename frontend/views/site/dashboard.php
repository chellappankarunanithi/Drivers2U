<?php
use backend\models\SwimCustomer;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use backend\models\SwimCustomerSearch;
//use backend\models\SwimCustomer;

$searchModel = new SwimCustomerSearch();

 $dataProvider3 = $searchModel->search3(Yii::$app->request->queryParams);
 $dataProvider2 = $searchModel->search2(Yii::$app->request->queryParams);
 $dataProvider1 = $searchModel->search1(Yii::$app->request->queryParams);
//$dataProvider1=


?>
<?php
$token_details = SwimCustomer::find()->select('customer_current_status')->andWhere(['customer_token_date'=>date('Y-m-d')])->all();
//print_r($token_details);die;
?>
<!-- <div class="card">

   <div class="card pull-right">
        <?= Html::a('Create Example', ['create'], ['class' => 'btn btn-success']) ?>
    </div> 
   </div> -->
   <style type="text/css">
       
    .btn-success, .btn-success:hover, .btn-success:active, .btn-success:focus {
    background-color: #e1e1e1 !important;
    color: black;
}
   </style>
   
    <div class="row clearfix">    	
    	<div class="col-md-6" >
                    <div class="form-group">
                       <h3>Generated Token List</h3> 
                   </div>
                </div>
                <div class="col-md-6" >

                <div class="pull-right">
                    <div class="form-group">
                       <?php //echo Html::button('<i class="material-icons">add</i> Manage Advisor', ['class' => 'btn btn-success waves-effect ']) ?> 

<?= Html::a('<i class="material-icons">view_carousel</i> Open Token', ['index.php/swimcustomeravgtime'], ['class'=>'btn bg-black waves-effect']) ?>

                   </div>
                </div>
                <div class="pull-right">
                    <div class="form-group">
                       <div style="width:20px;"></div>
                   </div>
                </div>
                <div class="pull-right">
                    <div class="form-group">
                       <?= Html::button('<i class="material-icons">note_add</i> Generate Token', ['class' => 'btn bg-black waves-effect customerdetail']) ?> 
                   </div>
                </div>
                <div class="pull-right">
                    <div class="form-group">
                       <div style="width:20px;"></div>
                   </div>
                </div>
                <div class="pull-right">
                    <div class="form-group">
                       <?php //echo Html::button('<i class="material-icons">add</i> Manage Advisor', ['class' => 'btn btn-success waves-effect ']) ?> 

<?= Html::a('<i class="material-icons">assignment_ind</i> Manage Advisor', ['index.php/swimadvisordetail'], ['class'=>'btn bg-black waves-effect']) ?>

                   </div>
                </div>
                </div>
                 </div> 
 <!-- <h3>Allocated</h3> -->
<div class="card">

 <div class="header bg-red ">
                <h2>ALLOCATED</h2>
            </div>
            <div class="body">
 <div class="row clearfix">

<?php Pjax::begin(); ?>    <?= ListView::widget([
        'dataProvider' => $dataProvider3,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->customer_autoid), ['view', 'id' => $model->customer_autoid]);
        },*/
        'itemView' => '_customerview',
    ]) ?>
<?php Pjax::end(); ?>
</div>  
</div>
</div>  
<div class="card">

<!-- <h3>Next In Queue</h3> -->
   <div class="header bg-red ">
                <h2>NEXT IN QUEUE</h2>
            </div>
            <div class="body">
 <div class="row clearfix">

<?php Pjax::begin(); ?>    <?= ListView::widget([
        'dataProvider' => $dataProvider2,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->customer_autoid), ['view', 'id' => $model->customer_autoid]);
        },*/
        'itemView' => '_customerview',
    ]) ?>
<?php Pjax::end(); ?>
</div>
</div>
</div>
<div class="card">

 <div class="header bg-red">
                <h2>CUSTOMER IN</h2>
            </div>
            
            <div class="body">
            	
 <div class="row clearfix">
    


<?php Pjax::begin(); ?>    <?= ListView::widget([
        'dataProvider' => $dataProvider1,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->customer_autoid), ['view', 'id' => $model->customer_autoid]);
        },*/
        'itemView' => '_customerview',
    ]) ?>
<?php Pjax::end(); ?>

</div>
</div>
</div>
 <script>

     $(document).ready(function(){

        jQuery.noConflict();
         $('.customerdetail').click(function(){
             $('.modal-content').addClass('modal-col-grey');
            var iddata = $(this).attr('data');

          
          var PageUrl='<?= Url::toRoute(["index.php/swimcustomerdetail"]) ?>';
           
           $('#operationalheader').html('<span> <i class="fa fa-fw fa-building-o"></i>Generate Token</span>');

             $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl);
           return false();

         });

        // sa_autoid;

    });


 
</script>  

