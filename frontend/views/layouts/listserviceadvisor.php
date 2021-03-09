        <?php
use yii\helpers\Html;
use yii\helpers\Url;
//$model->active_status;
//echo $model->work_status;
//echo $model->customername;


?>
<style>
	
	.morecontent span {
    display: none;
}
.morelink {
    display: block;
}



</style>

<div class="col-lg-12 col-md-12 col-sm-6 col-xs-10 advisorshow" id="<?php echo $model->sa_autoid; ?>" >



                   
                <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">

                           <button class="btn btn-warning waves-effect alignbtn" type="button">
                            <?= $model->work_status; ?>
                            </button>

                        </div>
                        <div class="content" role="button" data="<?php echo $model->sa_autoid; ?>">
                          
                           
                           <span>Code : <?= $model->sa_code; ?></span>
                               

                 <!--    <button class="btn btn-warning waves-effect alignbtn" type="button">
                            <?= $model->work_status; ?>
                    </button> -->

                           <!-- <span class="label label-warning"><?= $model->work_status; ?></span> -->

                             <div class="text">Name : <?= $model->sa_name; ?></div>


                            <?php if(!empty($model->customername)){
                                if($model->work_status=='C')
                                {
                                ?>
                            <div class="text">Cust : <?= $model->customername; ?></div>

                        <?php } }?>

                            
                        </div>
                </div>

                        <!--<div class="icon bg-pink" >
                            <!-- <i class="material-icons">email</i> -->
                            

                        <!-- <h4><span class="label label-warning"><?= $model->work_status; ?></span></h4>
                        <h5><span >Code : <?= $model->sa_code; ?></span></h5>

                    
                        </div>
                        
                       <!--  <div class="content" role="button" data="<?php echo $model->sa_autoid; ?>">
                            <!-- <div class="text">Code : <?= $model->sa_code; ?></div> -->
                            <!-- <div class="text">Name : <?= $model->sa_name; ?></div>


                            <?php if(!empty($model->customername)){
                                if($model->work_status=='C')
                                {
                                ?>
                            <div class="text">Cust : <?= $model->customername; ?></div>

                        <?php } }?>

                        </div>-->
                        
                        


                

                </div> 

                 <script>

    $(document).ready(function(){

         
         $('.advisorshow').click(function(){
             
             var iddata = $(this).attr('id');
            

           
           var PageUrl='<?= Url::toRoute(["index.php/swimservicedetail", "id"=>'']) ?>'+iddata;
           //alert(PageUrl);
           //return false;
           $('#operationalheader').html('CHANGE ADVISOR STATUS');
            $('#modalContenttwo').html("<div id='customtwo'><input type='hidden' class='data2'></div>");
            $('.data2').val('iddata');
           // var custid=$("#customerid").val(); 
            //jQuery('#del_id').val(custid);
         //  alert(PageUrl);
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(PageUrl);
             return false();

         });

        // sa_autoid;

 $('.modal-content').addClass('modal-col-grey');
    });

</script>  


                    


