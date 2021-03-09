<?php
use yii\helpers\Html;
use yii\helpers\Url;
//echo $model->assigned_service_advisor;

if(!empty($model->assigned_service_advisor))
{
$command = Yii::$app->db->createCommand("SELECT sa_name FROM swim_service_advisor WHERE sa_autoid = ".$model->assigned_service_advisor);
      $advisor = $command->queryScalar();
}

$session = Yii::$app->session;
$branchid=$session['branch_id'];
$today_date=date("Y-m-d");

$command = Yii::$app->db->createCommand("SELECT customer_avg_time FROM swim_customer_avg_time WHERE customer_branchid = '".$branchid."' and customer_date='".$today_date."'");
 $time = $command->queryScalar();
 


 if($time>=60)
 {
    
  $avg_time=gmdate("i:s", $time);
  $avg_time1=$avg_time. " Mins";

 }
 else
 {
     $avg_time=round($time);
    $avg_time1=$avg_time. " Sec";
 }

?>
<style>
	
	.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
</style>
<!-- menu-toggle waves-effect waves-block toggled --> 
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

	<div class="card ">
                        <div class="header bg-red menu-toggle waves-block toggled ">
                            <h2>
                                <?= $model->customer_token_value; ?> <small><?= $model->customer_name;?></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="#">
                                    	<?php 
                                    	$c_status='G';
                                    	if($model->customer_current_status=='generated'){
                                    		$c_status='G';
                                    	}elseif($model->customer_current_status=='next_in_queue'){
                                    		$c_status='N';
                                    	}elseif($model->customer_current_status=='allocated'){
                                    		$c_status='A';
                                    	}elseif($model->customer_current_status=='waitingforcustomer'){
                                    		$c_status='W';
                                    	}elseif($model->customer_current_status=='inprogress'){
                                    		$c_status='P';
                                    	}elseif($model->customer_current_status=='completed'){
                                    		$c_status='C';
                                    	}?> 

                                        <h4><span class="label label-warning"><?= $c_status ?></span></h4>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                            <ul class="dropdown-menu pull-right">



                 <?php if($model->customer_current_status=='customerin')
                 
{
                  ?>           
                                
                                <li><a href="<?php echo Yii::$app->homeUrl . 'index.php/swimcustomerstatus?id='.$model->customer_autoid.'&status=N'.'&branch='.$model->customer_branch.'&advisorid='; ?>" class=" waves-effect waves-block" onclick="return confirm('Are you sure want to move this token to Next In Queue?')">Next in Queue</a></li>

                                

<input type="hidden" name="customerid" id="customerid" value="<?php echo $model->customer_autoid; ?>"/>

<li><a href="#" data="<?php echo $model->customer_autoid; ?>" class="waves-effect waves-block customershow" >Assign</a></li> 

                                <li><a href="<?php echo Yii::$app->homeUrl . 'index.php/swimcustomerstatus?id='.$model->customer_autoid.'&status=D'.'&branch='.$model->customer_branch.'&advisorid=';  ?>" class=" waves-effect waves-block" onclick="return confirm('Are you sure want to cancel this token?')">Cancel Token</a></li>
<?php } ?>



<?php if($model->customer_current_status=='next_in_queue')
                 
{
                  ?>           
            
<input type="hidden" name="customerid" id="customerid" value="<?php echo $model->customer_autoid; ?>"/>

<li><a href="#" data="<?php echo $model->customer_autoid; ?>" class="waves-effect waves-block customershow" >Assign</a></li> 

                                <li><a href="<?php echo Yii::$app->homeUrl . 'index.php/swimcustomerstatus?id='.$model->customer_autoid.'&status=D'.'&branch='.$model->customer_branch.'&advisorid=';  ?>" class=" waves-effect waves-block" onclick="return confirm('Are you sure want to cancel this token?')">Cancel Token</a></li>
<?php } ?>


<?php if($model->customer_current_status=='allocated')
                 
{
                  ?>   
<li>
<a href="<?php echo Yii::$app->homeUrl . 'index.php/swimcustomerstatus?id='.$model->customer_autoid.'&status=H'.'&branch='.$model->customer_branch.'&advisorid='.$model->assigned_service_advisor;  ?>" class=" waves-effect waves-block" onclick="return confirm('Are you sure want to change this token?')">Customer No Show</a></li>


<li><a href="<?php echo Yii::$app->homeUrl . 'index.php/swimcustomerstatus?id='.$model->customer_autoid.'&status=C'.'&branch='.$model->customer_branch.'&advisorid='.$model->assigned_service_advisor;  ?>" class=" waves-effect waves-block" onclick="return confirm('Are you sure want to complete this token?')">Complete Token</a></li>

                                <li><a href="<?php echo Yii::$app->homeUrl . 'index.php/swimcustomerstatus?id='.$model->customer_autoid.'&status=D'.'&branch='.$model->customer_branch.'&advisorid=';  ?>" class=" waves-effect waves-block" onclick="return confirm('Are you sure want to cancel this token?')">Cancel Token</a></li>
<?php } ?>
                            </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body row clearfix demo-icon-container ">     
                          <div class="demo-google-material-icon "> <i class="material-icons">contact_phone</i> <span class="icon-name"><?= $model->customer_mobilenumber;?></span> </div>
                          <div class="demo-google-material-icon "> <i class="material-icons">directions_car</i> <span class="icon-name"><?= $model->customer_vehicle_number;?></span> </div>
                          <div class="demo-google-material-icon "> <i class="material-icons">timelapse</i> <span class="icon-name"><?= $model->customer_mobilenumber;?></span> </div>
                  <?php if(empty($advisor)) 
                  {
                  ?>
                  <div class="demo-google-material-icon "> <i class="material-icons">accessible</i> <span class="icon-name"><?= $model->preferred_service_advisor;?></span> </div>
                  <?php } ?>
                          <?php
                          if(!empty($advisor))
                          {
                          ?>
                          <div class="demo-google-material-icon "> <i class="material-icons">accessible</i> <span class="icon-name"><?= $advisor;?></span> </div>
                          <?php } ?>

                          <div class="demo-google-material-icon "> <i class="material-icons">alarm</i> <span class="icon-name"><?= $avg_time1;?></span> </div>
                     </div>
                    </div>
                </div>





                 <script>

    $(document).ready(function(){
    	// $('.swimcustomtoggle').click(function(){
    		 // $(".swimcustomtoggle").stop().slideToggle();
    		 // return false;
    	// });
        
         
         $('.customershow').click(function(){
             //var PageUrl = $(this).attr('value');
             //var iddata = $(this).attr('data');
             var iddata = $(this).attr('data');

           // var PageUrl = '<?php //echo Yii::$app->homeUrl . 'index.php/swimcustomerpopup&sa_autoid='; ?>' + iddata       // $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
            //$('#operationalheader').html('<span> <i class="fa fa-fw fa-building-o"></i> Branch Admin View</span>');   
                   //$('#textContent').html('<h4>test</h4>');
            //var PageUrl='swimcustomerpopup&sa_autoid=' + iddata ;  
           // var PageUrl='swimcustomerpopup' ; 
           var PageUrl='<?= Url::toRoute(["index.php/swimcustomerpopup", "id"=>'']) ?>'+iddata;
           //alert(PageUrl);
           //return false;
           $('#operationalheader').html('ASSIGN ADVISOR');
            $('#modalContenttwo').html("<div id='customtwo'><input type='hidden' class='data2'></div>");
            $('.data2').val('iddata');
            var custid=$("#customerid").val(); 
            jQuery('#del_id').val(custid);

             $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl);
             return false();

         });

        // sa_autoid;

    });

</script>   
