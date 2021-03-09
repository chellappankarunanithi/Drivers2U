<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\DriverProfile;
use backend\models\VehicleMaster;
use backend\models\SuperviserMaster;
use yii\web\UploadedFile;
use backend\models\CustomerDetails;
use backend\models\Triplogin;
use backend\models\TripDetails;
use backend\models\AllenTripTrack;
use backend\models\AllenTripTrackLog;
use backend\models\AllenApiLog;
use backend\models\StkCountLoginLog;

use yii\db\Expression;
class TripApiController extends Controller
{  
	/** 
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
   /* public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}*/
 public function beforeAction($action) {    
	$params = (Yii::$app->request->headers);
  //echo "<pre>"; print_r($params); die; 
	if($authorization=$params['authorization']){		
		$this->enableCsrfValidation = false;
    	return parent::beforeAction($action);
	}else{
		$list['status'] = 'error';
		$list['message'] = 'Bad Request ';
		$response=$list;
		echo json_encode($response);
		die;
	}
} 
function authorization(){  
	$params = (Yii::$app->request->headers);
	$authorization=$params['authorization'];
	$authorization=str_replace('Bearer', '', $authorization);
	$authorization=trim($authorization);
	$user_data_role = Triplogin::find()
					->where(['authkey'=>$authorization])
					->one(); 
	if($user_data_role){ 
		return $user_data_role;
	}else{
		return false;
  }
	}

  function sessioncheck($username){  
   
   
  $authorization=trim($username); 
  $login_log=StkCountLoginLog::find()->where(['login_username'=>$authorization])->andWhere(['allow_status'=>'blocked'])->count();

       if($login_log==1){ 
          return $login_log;
       }else{
         return false;
      }
  }


 /******          trip-list               ****************/
public function actionTripList()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 

  $log_model=new AllenApiLog();
  $log_model->event='trip-list'; 
  $log_model->data=$postd;
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key','login_name');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
      $login_key = $requestInput['login_key'];
      $username = $requestInput['login_name'];

      if($login_key!="" && $login_key=="T")
      { 
    if($usercheck = $this->sessioncheck($username)){  
      $customer_data = CustomerDetails::find()->asArray()->all(); 
      $multicustomAr = ArrayHelper::index($customer_data,'id');
      $comp_Arr = ArrayHelper::map($customer_data,'id','company_name');
      $cust_Arr = ArrayHelper::map($customer_data,'id','contact_person');
      $cust_contact_Arr = ArrayHelper::map($customer_data,'id','company_contact_no');
      $cust_per_cont_Arr = ArrayHelper::map($customer_data,'id','personal_contact_no');
      $cust_Address_Arr = ArrayHelper::map($customer_data,'id','company_address');
      $cust_PersAdd_Arr = ArrayHelper::map($customer_data,'id','personal_address');

      $vehicle_data = VehicleMaster::find()->asArray()->all();
      $vehi_name_Arr = ArrayHelper::map($vehicle_data,'id','vehicle_name');
      $vehi_no_Arr = ArrayHelper::map($vehicle_data,'id','reg_no');

      $driver_data = DriverProfile::find()->asArray()->all(); 
      $driver_name_Arr = ArrayHelper::map($driver_data,'id','driver_name');
      $mobile_no_Arr = ArrayHelper::map($driver_data,'id','mobile_number');
        
          $user_data_role = Triplogin::find()
          ->where(['username'=>$username])->asArray()
          ->one();
          $driver_name='';
          if($user_data_role){ 
            $driver_name = $user_data_role['first_name'].'  '.$user_data_role['last_name'];
          }

          $trip = TripDetails::find()->where(['status'=>"A"])
          ->andWhere(['vehicle_number'=>$username])
          ->andWhere(['trip_current_status'=>'S'])
          ->asArray()->one();
          $tripstatus='';
          $trip_code='';
        if(!empty($trip)){
          $tripstatus ="IN_TRIP";
          $trip_code = $trip['trip_title'];

        }


        $list['trip_status'] = $tripstatus;
        $list['trip_code'] = $trip_code;



        $trip_data = TripDetails::find()
          ->where(['status'=>'A'])
          ->andWhere(['vehicle_number'=>$username])
          ->asArray()
          ->orderBy(['trip_date_time'=>SORT_ASC])
          ->all(); 
          $det1=array();

        if(!empty($trip_data)){ //echo "<pre>"; print_r($trip_data); die;
        foreach ($trip_data as $key => $value) {

          $correct_value=0;

          $today = date("d-m-Y h:i:s A");
          
          $alert_date = date("d-m-Y h:i:s A", strtotime($value['trip_date_time']));

          //print_r($value['trip_date_time']);die;
          if($alert_date < $today)
          {
            //$today = date('Y-m-d h:i:s',strtotime($today));
            $alert_date = date("d-m-Y h:i:s A", strtotime($value['trip_date_time']."+4 hours"));
           //print_r($alert_date);die;
            if($alert_date > $today)
            {
            $correct_value=1;
            }
            else
            {
            $correct_value=0;
            } 
          }
          else if($alert_date > $today)
          {
          $correct_value=1;
          }
         /* else
          {
            $today = date('Y-m-d',strtotime($today_1));
            $alert_date = date("Y-m-d", strtotime($value['trip_date_time']));
          }*/

         /* $date='';
              if(!strpos('1970', $model->trip_date_time) && $model->trip_date_time!="")
              {   
              $date = date('d-m-Y h:i:s A', strtotime($model->trip_date_time."+4 hours"));
              }
               $date2=date('d-m-Y h:i:s A');
                if($date2>$date){
              }*/
         // echo $today.'-'.$alert_date; die;
          if($correct_value==1){
          $det['trip_id'] = $value['id'];
          $det['trip_code'] = $value['trip_title'];
            if($value['trip_type']=="home_to_airport"){
              $triptype = "Home to Airport";
              $det['address_type'] = "home";
              $det['address_mode'] = "airport";
            }
            else if($value['trip_type']=="office_to_airport"){
              $triptype = "Office to Airport";
               $det['address_type'] = "office";
               $det['address_mode'] = "airport";
            }
            else if($value['trip_type']=="airport_to_home"){
              $triptype = "Airport to Home";
              $det['address_type'] = "home";
               $det['address_mode'] = "airport";
            }
            else if($value['trip_type']=="airport_to_office"){
              $triptype = "Airport to Office";
              $det['address_type'] = "office";
              $det['address_mode'] = "airport";
            }
            else if($value['trip_type']=="home_to_general_address"){
              $triptype = "Home to General Address";
              $det['address_type'] = "home";
              $det['address_mode'] = "general";
            }
            else if($value['trip_type']=="office_to_general_address"){
              $triptype = "Office to General Address";
              $det['address_type'] = "office";
              $det['address_mode'] = "general";
            }
            else if($value['trip_type']=="general_address_to_home"){
              $triptype = "General Address to Home";
              $det['address_type'] = "home";
              $det['address_mode'] = "general";
            }
            else if($value['trip_type']=="general_address_to_office"){
              $triptype = "General Address to Office";
              $det['address_type'] = "office";
              $det['address_mode'] = "general";
            }else{
              $triptype = $value['trip_type'];
            }

           $det['trip_type'] = ucfirst($triptype);
           $det['pickup_type'] = ucfirst($value['pickup_type']);
           $det['flight_number'] = $value['flight_number'];

           $det['trip_date_time']=date('d-m-Y h:i:s A',strtotime($value['trip_date_time']));

           $det['vehicle_number'] = $value['vehicle_number'];
           $det['vehicle_name'] = $value['vehicle_name'];
           $det['driver_name'] = ucfirst($driver_name);
           $det['vehicle_type'] = ucfirst($value['vehicle_type']);
           $det['remarks'] = $value['remarks'];
           
           $det['trip_created_date'] =date('d-m-Y h:i:s A',strtotime($value['created_at']));

           $det['trip_modified_date'] =date('d-m-Y h:i:s A',strtotime($value['updated_at']));

           $det['status'] = $value['status'];
           $det['customer_company_name'] ='';

          if(array_key_exists($value['customer_name'], $comp_Arr))
          {
          $det['customer_company_name'] = $comp_Arr[$value['customer_name']];
          }
          $det['trip_uploadedimage'] = "";
          if($value['image_upload']!="" && $value['image_upload']!=NULL){
          $det['trip_uploadedimage'] = Url::home(true).'backend/web/'.$value['image_upload'];
          }

          $det['customer_name'] = $det['customer_personal_address'] = $det['customer_office_address'] = $det['customer_personal_no'] = $det['customer_office_no'] = '';

          if(array_key_exists($value['trip_customer1'], $multicustomAr)){

              $det['customer_name'] = $multicustomAr[$value['trip_customer1']]['contact_person'];
              $det['customer_personal_address'] = $multicustomAr[$value['trip_customer1']]['personal_address'];
              $det['customer_office_address'] = $multicustomAr[$value['trip_customer1']]['company_address'];
              $det['customer_personal_no'] = $multicustomAr[$value['trip_customer1']]['personal_contact_no'];
              $det['customer_office_no'] = $multicustomAr[$value['trip_customer1']]['company_contact_no'];
          }

        $det['customer_name2'] = $det['customer_personal_address2'] = $det['customer_office_address2'] = $det['customer_personal_no2'] = $det['customer_office_no2'] = '';

        if(array_key_exists($value['trip_customer2'], $multicustomAr)){

              $det['customer_name2'] = $multicustomAr[$value['trip_customer2']]['contact_person'];
              $det['customer_personal_address2'] = $multicustomAr[$value['trip_customer2']]['personal_address'];
              $det['customer_office_address2'] = $multicustomAr[$value['trip_customer2']]['company_address'];
              $det['customer_personal_no2'] = $multicustomAr[$value['trip_customer2']]['personal_contact_no'];
              $det['customer_office_no2'] = $multicustomAr[$value['trip_customer2']]['company_contact_no'];
          }
          $det['general_address'] = "";
          if($value['pickup_type']=='general'){
            $det['general_address'] = $value['general_address'];
          }
          // $det['customer_name'] ='';
          //  if(array_key_exists($value['customer_name'], $cust_Arr))
          // {
          //   $det['customer_name'] = ucfirst($cust_Arr[$value['customer_name']]);
          // }
          // $det['customer_personal_address'] ='';
          // if(array_key_exists($value['customer_name'], $cust_PersAdd_Arr))
          // {
          //   $det['customer_personal_address'] = $cust_PersAdd_Arr[$value['customer_name']];
          // }
          // $det['customer_office_address'] =''; 
          // if(array_key_exists($value['customer_name'], $cust_Address_Arr))
          // {
          //   $det['customer_office_address'] = $cust_Address_Arr[$value['customer_name']];
          // }

          // $det['customer_personal_no'] ='';
          // if(array_key_exists($value['customer_name'], $cust_per_cont_Arr))
          // {
          //   $det['customer_personal_no'] = $cust_per_cont_Arr[$value['customer_name']];
          // }

          // $det['customer_office_no'] ='';
          // if(array_key_exists($value['customer_name'], $cust_contact_Arr))
          // {
          //   $det['customer_office_no'] = $cust_contact_Arr[$value['customer_name']];
          // }
 
          $det1[]=$det;
        }
        }
        $list['status']='success';
        $list['message']='success';
        $list['trip_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Trip List not Available';
        $list['trip_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='session_close';
    }
  }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['trip_list']=array();
  }
    
  }
    
}else{
        $list['status']='error';
        $list['message']='Invalid Authorization';
}
      $response['Output'][] = $list;
      $log_model=AllenApiLog::findOne($log_id);
      if($log_model){
      $log_model->response=json_encode($response);
      $log_model->save();
      }

    return json_encode($response);
}

/******* Completed Trip List **********/
  public function actionTripListClose()
  {
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $log_model=new AllenApiLog();
    $log_model->event='trip-list-closed'; 
    $log_model->data=$postd;
    $log_id='';
    if($log_model->save()){
      $log_id=$log_model->autoid;
    }
    $list['status'] = 'error';
    $list['message'] = 'Invalid Authorization Request!';
    if($user_data_role=$this->authorization()){
      $field_check=array('login_key','login_name','api_method');
      $is_error = '';
      foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
      } 
      if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
      }else{
        $mod = new TripDetails();
        $list = $mod->ColseTripDetails($requestInput);
      }
    }
    $response['Output'][] = $list;
    $log_model=AllenApiLog::findOne($log_id);
    if($log_model){
      $log_model->response=json_encode($response);
      $log_model->save();
    }
    return json_encode($response);
  }

  /******* Trip Expenses **********/
  public function actionTripExpenses()
  {
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $post1['post']=$_POST;
    $post1['files']=$_FILES;
    $log_model=new AllenApiLog();
    $log_model->event='trip-expences';  
    $log_model->data=json_encode($post1);
    $log_id='';
    if($log_model->save()){
      $log_id=$log_model->autoid;
    }
    $list['status'] = 'error';
    $list['message'] = 'Invalid Authorization Request!';
    if($user_data_role=$this->authorization()){
      $field_check=array('api_method','trip_id');
      $is_error = '';
      foreach ($field_check as $one_key) {
        //echo"<pre>";print_r($field_check);die;
        $key_val =isset($_POST[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
      } 
      if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
      }else{
        //$mod = new TripDetails();
       // $list = $mod->ExpenseEdit($post1['post'],$post1['files']);


         $api_method = $tripid = $expenses_1 = $expenses_2 = $expenses_3 = $expenses_1_file = $expenses_2_file = $expenses_3_file = "";
        $exp1amt = $exp2amt = $exp3amt = "0";
        if(array_key_exists('api_method', $_POST)){
            $api_method = $_POST['api_method'];
        }if(array_key_exists('expenses_1_amt', $_POST)){
            if($_POST['expenses_1_amt']!=""){
                $exp1amt = $_POST['expenses_1_amt'];
            }
        }if(array_key_exists('expenses_2_amt', $_POST)){
            if($_POST['expenses_2_amt']!=""){
                $exp2amt = $_POST['expenses_2_amt'];
            }
        }if(array_key_exists('expenses_3_amt', $_POST)){
            if($_POST['expenses_3_amt']!=""){
                $exp3amt = $_POST['expenses_3_amt'];
            }
        }if(array_key_exists('expenses_1', $_POST)){
            if($_POST['expenses_1']!=""){
                $expenses_1 = $_POST['expenses_1'];
            }
        }if(array_key_exists('expenses_2', $_POST)){
            if($_POST['expenses_2']!=""){
                $expenses_2 = $_POST['expenses_2'];
            }
        }if(array_key_exists('expenses_3', $_POST)){
            if($_POST['expenses_3']!=""){
                $expenses_3 = $_POST['expenses_3'];
            }
         }/*if(array_key_exists('expenses_1_file', $_POST)){
            if($_POST['expenses_1_file']!=""){
                $expenses_3 = $_POST['expenses_1_file'];
            }
        }if(array_key_exists('expenses_2_file', $_POST)){
            if($_POST['expenses_2_file']!=""){
                $expenses_3 = $_POST['expenses_2_file'];
            }
        }if(array_key_exists('expenses_3_file', $_POST)){
            if($_POST['expenses_3_file']!=""){
                $expenses_3 = $_POST['expenses_3_file'];
            }           
        }*/
        if(array_key_exists('trip_id', $_POST)){
            $tripid = $_POST['trip_id'];
        }


        $list['status'] = 'error';
        $list['message'] = 'Invalid Api Method';
        if($api_method=='edit_expense'){
            $list['message'] = 'Trip Not Found';
            $trip = AllenTripTrack::find()->where(['trip_id'=>$tripid])->one();
            if($trip){
                $list['message']='Trip Not Closed';
                if($trip->trip_status=='F'){
                    $list['message']='Trip Finished Already';
                }
                if($trip->trip_status=='C'){
                    $trip->trip_status='F';
                    if($expenses_1!=""){
                        $trip->expenses_1=$expenses_1;
                    }if($expenses_2!=""){
                        $trip->expenses_2=$expenses_2;
                    }if($expenses_3!=""){
                        $trip->expenses_3=$expenses_3;
                    }
                    /*
                    if($expenses_1_file!=""){
                        $trip->expenses_1_file=$expenses_1_file; 
                    }if($expenses_2_file!=""){
                        $trip->expenses_2_file=$expenses_2_file;
                    }if($expenses_3_file!=""){
                        $trip->expenses_3_file=$expenses_3_file;           
                    }*/
                    if($exp1amt!=""){
                        $trip->expenses_1_amt=$exp1amt;
                    }if($exp2amt!=""){
                        $trip->expenses_2_amt=$exp2amt;
                    }if($exp3amt!=""){
                        $trip->expenses_3_amt=$exp3amt;
                    }

            if(isset($_FILES['expenses_1_file']['name'])!='')
                {
                    $uploads_dir = 'backend/web/uploads/trip_expenses/';         
                       $tmp_name =$_FILES["expenses_1_file"]["tmp_name"];
                        $file_name = rand().$_FILES["expenses_1_file"]["name"];
                     $uploads_dir = 'backend/web/uploads/trip_expenses/'.$file_name;
                     $uploads_dir1 = 'trip_expenses/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $trip->expenses_1_file=$uploads_dir1;
                }
           if(isset($_FILES['expenses_2_file']['name'])!='')
                {
                    $uploads_dir = 'backend/web/uploads/trip_expenses/';         
                       $tmp_name =$_FILES["expenses_2_file"]["tmp_name"];
                        $file_name = rand().$_FILES["expenses_2_file"]["name"];
                     $uploads_dir = 'backend/web/uploads/trip_expenses/'.$file_name;
                     $uploads_dir1 = 'trip_expenses/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $trip->expenses_2_file=$uploads_dir1;
                }
              if(isset($_FILES['expenses_3_file']['name'])!='')
                {
                    $uploads_dir = 'backend/web/uploads/trip_expenses/';         
                       $tmp_name =$_FILES["expenses_3_file"]["tmp_name"];
                        $file_name = rand().$_FILES["expenses_3_file"]["name"];
                     $uploads_dir = 'backend/web/uploads/trip_expenses/'.$file_name;
                     $uploads_dir1 = 'trip_expenses/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $trip->expenses_3_file=$uploads_dir1;
                }   

                    if($trip->save()){
                        $tpdet = TripDetails::findOne($tripid);
                        if($tpdet){
                            $tpdet->trip_current_status='F';
                            $tpdet->save();
                        }
                        $list['status'] = 'success';
                        $list['message'] = 'Trip Finished Successfully';
                    }
                }
            }
        }

             
      }
    }
    $response['Output'][] = $list;
    $log_model=AllenApiLog::findOne($log_id);
    if($log_model){
      $log_model->response=json_encode($response);
      $log_model->save();
    }
    return json_encode($response);
  }



 /******          trip-ride               ****************/
public function actionTripRide()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 

  $log_model=new AllenApiLog();
  $log_model->event='trip-ride'; 
  $log_model->data=$postd;
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
   
    $trip_status = $requestInput['trip_status']; //echo $trip_status; die;
    if($trip_status=="S"){
      $field_check=array('login_key','login_name','trip_code','trip_status','enter_starting_km');
    }if($trip_status=="C"){  
    $field_check=array('login_key','login_name','trip_code','trip_status','enter_close_km');
    }
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
      $validation = false;
      $login_key = $requestInput['login_key'];
      $username  = $requestInput['login_name'];
      $trip_code   = $requestInput['trip_code'];
     // $trip_id   = $requestInput['trip_id'];
     // $trip_code = $requestInput['trip_title'];
      $trip_status = $requestInput['trip_status'];
      $customer_signature='';
      if(array_key_exists('customer_signature', $requestInput)){
        $customer_signature = $requestInput['customer_signature'];
      }
      if($login_key!="" && $login_key=="T")
      { 
    if($usercheck = $this->sessioncheck($username))
    { 
          $user_data_role = Triplogin::find()
          ->where(['username'=>$username])->asArray()
          ->one();
          $driver_name='';
          if($user_data_role){ 
            $driver_name = $user_data_role['first_name'].'  '.$user_data_role['last_name'];
          }
         

          $modeldetails = TripDetails::find()->where(['trip_title'=>$trip_code])
         // ->andWhere(['status'=>"A"])
          ->one();
          if(!empty($modeldetails)){
          $trip_data = AllenTripTrack::find()->where(['trip_id'=>$modeldetails->id])
          ->andWhere(['vehicle_number'=>$username])
          ->andWhere(['not',['trip_status'=>'C']])
          ->one();
         // echo "<pre>"; print_r($username); die;
          // echo "<pre>"; print_r($modeldetails); die;
        if(empty($trip_data))
        {
          $trip_data = new AllenTripTrack();
            if($trip_status=="S")
            {
              $enter_starting_km = $requestInput['enter_starting_km']; 
              $trip_data->trip_start_time = date('Y-m-d H:i:s');
              $trip_data->enter_starting_km = $enter_starting_km;
              
                    if(!empty($modeldetails))
                    { 
                      $modeldetails->trip_current_status="S";
                      $modeldetails->save();
                    }

              $trip = AllenTripTrack::find() 
              ->where(['vehicle_number'=>$username])
              ->andWhere(['trip_status'=>'S'])
              ->andWhere(['id'=>$modeldetails->id])
              ->one();
              
            if(!empty($trip))
            {
                $validation=true;
                $msg = "This Trip Already Started";
            } 
            }
        }  
          $trip_data->trip_id = $modeldetails->id;
          $trip_data->trip_status = $trip_status;
          $trip_data->vehicle_number = $username;
          $trip_data->driver_name = $driver_name;

         if($trip_status=="C")
         {
              $trip = AllenTripTrack::find() 
              ->where(['vehicle_number'=>$username])
              ->andWhere(['trip_id'=>$modeldetails->id])
              ->andWhere(['trip_status'=>'C'])
              ->one();
              
            if(!empty($trip))
            {
                $validation=true;
                $msg = "This Trip Already Closed";
            } 
              $enter_close_km = $requestInput['enter_close_km'];
              if($enter_close_km<=$trip_data->enter_starting_km)
              {
                $validation=true;
                $msg = "Closing Km should Greater than Starting Km...!!";
              }
          $trip_data->trip_end_time = date('Y-m-d H:i:s');
          $trip_data->enter_close_km=$enter_close_km;
           // echo "<pre>"; print_r($modeldetails); die;
       
        
          if(!empty($modeldetails))
          {
             if($customer_signature!=""){
                  define('UPLOAD_DIR', 'backend/web/uploads/customer_signature/');
                  $img = $customer_signature;
                  $img = str_replace('data:image/png;base64,', '', $img);
                  $img = str_replace(' ', '+', $img);
                  $data = base64_decode($img);
                  $file = UPLOAD_DIR .$modeldetails->trip_title.'_'.date('dmYHis').'_.png';
                  $success = file_put_contents($file, $data); 
                  $trip_data->digital_signature = $file;
              }

            $modeldetails->status="I";
            $modeldetails->trip_current_status="C";
            $modeldetails->save();
          }
        }
          if(isset($requestInput['expenses_1']) && isset($requestInput['expenses_1_amt']))
          {
            $trip_data->expenses_1 = $requestInput['expenses_1'];
            $trip_data->expenses_1_amt = $requestInput['expenses_1_amt'];
          }
          if(isset($requestInput['expenses_2']) && isset($requestInput['expenses_2_amt']))
          {
            $trip_data->expenses_2 = $requestInput['expenses_2'];
            $trip_data->expenses_2_amt = $requestInput['expenses_2_amt'];
          }
          if(isset($requestInput['expenses_3']) && isset($requestInput['expenses_3_amt']))
          {
            $trip_data->expenses_3 = $requestInput['expenses_3'];
            $trip_data->expenses_3_amt = $requestInput['expenses_3_amt'];
          }
          if($validation==false)
        {
          if($trip_data->save())
          {

            $trip_data1 = ArrayHelper::toArray($trip_data);
            $triplog = new AllenTripTrack();
            $triplogsave = $triplog->logsave($trip_data1);  //echo "<pre>"; print_r($triplogsave); die;

            $list['status']='success';
            $list['message']='success';
            $list['trip_id']=$trip_data->id;
          }else
          {
           $list['status'] = 'error';
           $list['message'] = "problem in saving data";
          }
        }else
        {
           $list['status'] = 'error';
           $list['message'] = $msg;
        }
          
     }else
          {
           $list['status'] = 'error';
           $list['message'] = "problem in saving data";
          }
      }else{
            $list['status']='error';
            $list['message']='session_close';
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['trip_list']=array();
    }
  }
    
}else{
        $list['status']='error';
        $list['message']='Invalid Authorization';
}
      $response['Output'][] = $list;
      $log_model=AllenApiLog::findOne($log_id);
      if($log_model){
      $log_model->response=json_encode($response);
      $log_model->save();
      }

    return json_encode($response);
}




 /******          trip-details             ****************/
public function actionTripDetails()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 

  $log_model=new AllenApiLog();
  $log_model->event='trip-list'; 
  $log_model->data=$postd;
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
   
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key','login_name','trip_code');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
      $login_key = $requestInput['login_key'];
      $username = $requestInput['login_name'];
      $trip_code = $requestInput['trip_code'];
      if($login_key!="" && $login_key=="T")
    {
  if($usercheck = $this->sessioncheck($username))
  {
      $customer_data = CustomerDetails::find()->asArray()->all(); 
      $multicustomAr = ArrayHelper::index($customer_data,'id');
      $comp_Arr = ArrayHelper::map($customer_data,'id','company_name');
      $cust_Arr = ArrayHelper::map($customer_data,'id','contact_person');
      $cust_contact_Arr = ArrayHelper::map($customer_data,'id','company_contact_no');
      $cust_per_cont_Arr = ArrayHelper::map($customer_data,'id','personal_contact_no');
      $cust_Address_Arr = ArrayHelper::map($customer_data,'id','company_address');
      $cust_PersAdd_Arr = ArrayHelper::map($customer_data,'id','personal_address');

      $vehicle_data = VehicleMaster::find()->asArray()->all();
      $vehi_name_Arr = ArrayHelper::map($vehicle_data,'id','vehicle_name');
      $vehi_no_Arr = ArrayHelper::map($vehicle_data,'id','reg_no');

      $driver_data = DriverProfile::find()->asArray()->all(); 
      $driver_name_Arr = ArrayHelper::map($driver_data,'id','driver_name');
      $mobile_no_Arr = ArrayHelper::map($driver_data,'id','mobile_number');
        
          $user_data_role = Triplogin::find()
          ->where(['username'=>$username])->asArray()
          ->one();
          
          $driver_name='';
          if(!empty($user_data_role)){ 
            $driver_name = $user_data_role['first_name'].'  '.$user_data_role['last_name'];
         }

          $trip = TripDetails::find()
          ->where(['trip_title'=>$trip_code])
          ->andWhere(['vehicle_number'=>$username])
          ->asArray()->one();

          
        if(!empty($trip)){
          $triptrack = AllenTripTrack::find()->where(['trip_id'=>$trip['id']])->asArray()->one();
          
       
          $det['track_id'] =$det['trip_id'] = $det['trip_code']=$det['trip_current_status']='';


           $det['customer_company_name'] ='';
          if(array_key_exists($trip['customer_name'], $comp_Arr))
          {
            $det['customer_company_name'] = $comp_Arr[$trip['customer_name']];
          }
          $det['customer_name'] = $det['customer_personal_address'] = $det['customer_office_address'] = $det['customer_personal_no'] = $det['customer_office_no'] = '';
          if(array_key_exists($trip['trip_customer1'], $multicustomAr)){
              $det['customer_name'] = $multicustomAr[$trip['trip_customer1']]['contact_person'];
              $det['customer_personal_address'] = $multicustomAr[$trip['trip_customer1']]['personal_address'];
              $det['customer_office_address'] = $multicustomAr[$trip['trip_customer1']]['company_address'];
              $det['customer_personal_no'] = $multicustomAr[$trip['trip_customer1']]['personal_contact_no'];
              $det['customer_office_no'] = $multicustomAr[$trip['trip_customer1']]['company_contact_no'];
          }
          $det['customer_name2'] = $det['customer_personal_address2'] = $det['customer_office_address2'] = $det['customer_personal_no2'] = $det['customer_office_no2'] = '';
          if(array_key_exists($trip['trip_customer2'], $multicustomAr)){
              $det['customer_name2'] = $multicustomAr[$trip['trip_customer2']]['contact_person'];
              $det['customer_personal_address2'] = $multicustomAr[$trip['trip_customer2']]['personal_address'];
              $det['customer_office_address2'] = $multicustomAr[$trip['trip_customer2']]['company_address'];
              $det['customer_personal_no2'] = $multicustomAr[$trip['trip_customer2']]['personal_contact_no'];
              $det['customer_office_no2'] = $multicustomAr[$trip['trip_customer2']]['company_contact_no'];
          }

          $det['general_address'] = "";
          if($trip['pickup_type']=='general'){
            $det['general_address'] = $trip['general_address'];
          }


          /*$det['customer_name'] ='';
           if(array_key_exists($trip['customer_name'], $cust_Arr))
          {
            $det['customer_name'] = ucfirst($cust_Arr[$trip['customer_name']]);
          }
          $det['customer_personal_address'] ='';
          if(array_key_exists($trip['customer_name'], $cust_PersAdd_Arr))
          {
            $det['customer_personal_address'] = $cust_PersAdd_Arr[$trip['customer_name']];
          }
          $det['customer_office_address'] =''; 
          if(array_key_exists($trip['customer_name'], $cust_Address_Arr))
          {
            $det['customer_office_address'] = $cust_Address_Arr[$trip['customer_name']];
          }

          $det['customer_personal_no'] ='';
          if(array_key_exists($trip['customer_name'], $cust_per_cont_Arr))
          {
            $det['customer_personal_no'] = $cust_per_cont_Arr[$trip['customer_name']];
          }

          $det['customer_office_no'] ='';
          if(array_key_exists($trip['customer_name'], $cust_contact_Arr))
          {
            $det['customer_office_no'] = $cust_contact_Arr[$trip['customer_name']];
          }*/
 
          $det['trip_id']  = $trip['id'];
          $det['trip_code']  = $trip['trip_title'];

           if($trip['trip_type']=="home_to_airport"){
              $triptype = "Home to Airport";
              $det['address_type'] = "home";
              $det['address_mode'] = "airport";
            }
            else if($trip['trip_type']=="office_to_airport"){
              $triptype = "Office to Airport";
              $det['address_type'] = "office";
              $det['address_mode'] = "airport";
            }
            else if($trip['trip_type']=="airport_to_home"){
              $triptype = "Airport to Home";
              $det['address_type'] = "home";
              $det['address_mode'] = "airport";
            }
            else if($trip['trip_type']=="airport_to_office"){
              $triptype = "Airport to Office";
              $det['address_type'] = "office";
              $det['address_mode'] = "airport";
            }
            else if($trip['trip_type']=="home_to_general_address"){
              $triptype = "Home to General Address";
              $det['address_type'] = "home";
                $det['address_mode'] = "general";

            }
            else if($trip['trip_type']=="office_to_general_address"){
              $triptype = "Office to General Address";
              $det['address_type'] = "office";
                $det['address_mode'] = "general";
            }
            else if($trip['trip_type']=="general_address_to_home"){
              $triptype = "General Address to Home";
               $det['address_type'] = "home";
                $det['address_mode'] = "general";
            }
            else if($trip['trip_type']=="general_address_to_office"){
              $triptype = "General Address to Office";
               $det['address_type'] = "office";
                      $det['address_mode'] = "general";
            }else{
              $triptype = $value['trip_type'];
              $det['address_type'] = "";
                $det['address_mode'] = "";
            }  
         
          $det['trip_type']  = ucfirst($triptype);
          //$det['trip_type']  = ucfirst($trip['trip_type']);
          $det['pickup_type']  = ucfirst($trip['pickup_type']);
         
          $det['trip_uploadedimage'] = "";
          if($trip['image_upload']!="" && $trip['image_upload']!=NULL){
            $det['trip_uploadedimage'] = Url::home(true).'backend/web/'.$trip['image_upload'];
          }

         $det['track_id']=$det['trip_current_status']=$det['enter_starting_km']=$det['enter_close_km']=$det['driver_name']=$det['vehicle_number']=$det['digital_signature']=$det['trip_start_time']=$det['trip_end_time']='';
          $det['expenses_1'] =$det['expenses_2'] =$det['expenses_3'] = $det['trip_end_time'] ='';
          $det['expenses_1_amt'] =$det['expenses_2_amt'] =$det['expenses_3_amt'] =0;
      if(!empty($triptrack)){

          $det['track_id'] = $triptrack['id'];
          $det['trip_current_status']  = $triptrack['trip_status'];
          $det['enter_starting_km']  = $triptrack['enter_starting_km'];
          $det['enter_close_km']  = $triptrack['enter_close_km'];

         if($triptrack['expenses_1']!="")
          $det['expenses_1']  = ucfirst($triptrack['expenses_1']);
         if($triptrack['expenses_2']!="")
          $det['expenses_2']  = ucfirst($triptrack['expenses_2']);
         if($triptrack['expenses_3']!="")
          $det['expenses_3']  = ucfirst($triptrack['expenses_3']);
          
          $det['expenses_1_amt']  = $triptrack['expenses_1_amt'];
          $det['expenses_2_amt']  = $triptrack['expenses_2_amt'];
          $det['expenses_3_amt']  = $triptrack['expenses_3_amt'];
          $det['driver_name']     = ucfirst($triptrack['driver_name']);
          $det['vehicle_number']  = $triptrack['vehicle_number'];
          $det['digital_signature']  ="";
          if($triptrack['digital_signature']!=""){
          $det['digital_signature']  = Url::home(true).$triptrack['digital_signature'];
          }

          $det['trip_start_time'] = date('d-m-Y h:i:s A', strtotime($triptrack['trip_start_time']));
          if(!empty($triptrack['trip_end_time'])){
          $det['trip_end_time'] = date('d-m-Y h:i:s A', strtotime($triptrack['trip_end_time']));
          } 
      }
                $list['status']='success';
                $list['message']='success';
                $list['trip_list']=$det;
              //}
              }else{
                $list['status']='success';
                $list['message']='Trip Details not Available';
                $list['trip_list']=array();
              }
             
        }else
        {
          $list['status']='error';
          $list['message']='session_close';
        }   
     }else
     {
        $list['status']='error';
        $list['message']='Invalid User';
        $list['trip_list']=array();
      }
          }
            
        }else{
                $list['status']='error';
                $list['message']='Invalid Authorization';
        }
      $response['Output'][] = $list;
      $log_model=AllenApiLog::findOne($log_id);
      if($log_model){
      $log_model->response=json_encode($response);
      $log_model->save();
      }

    return json_encode($response);
}


}
