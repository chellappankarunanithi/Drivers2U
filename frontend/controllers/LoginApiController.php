<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\InvoiceAccessoriesGrouping;
use yii\helpers\ArrayHelper;
use backend\models\CategoryManagement;
use backend\models\BunkMaster;
use backend\models\Coupon;
use backend\models\DriverProfile;
use backend\models\VehicleMaster;
use backend\models\AllenApiLog;
use backend\models\SuperviserMaster;
use backend\models\Triplogin;
use backend\models\VehicleMasterSearch;
use backend\models\StkCountLoginLog;
use backend\models\AllenOtpLog;
use yii\web\UploadedFile;
use backend\models\ClientMaster;
use backend\models\TripDetails;
use yii\db\Expression; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\db\Query;
class LoginApiController extends Controller
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
    public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
} 

public function actionLogin()
{ 
  $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
//log table
  $log_model=new AllenApiLog();
  $log_model->event='allen-login';
  //$log_model->event_key='crm_app';
  $log_model->data=$postd;
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
  
  $list['status'] = 'error';
  $list['message'] = 'Nill';
    
    $field_check=array('username','password');
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
    $super_data = SuperviserMaster::find()
          ->where(['user_name'=>$requestInput['username']])
          ->andWhere(['status'=>'Active'])
          ->one();   
    $bunk_data = BunkMaster::find()
          ->where(['user_name'=>$requestInput['username']])
          ->andWhere(['status'=>'Active'])
          ->one(); 
    $trip_data = Triplogin::find()
          ->where(['username'=>$requestInput['username']])
          ->andWhere(['status'=>'A'])
          ->one();  


    $loginkey='';
    $login_status="S";
    $branch_id='';
    $list['login_key'] = "";
    if(!empty($super_data)){ 
      $password=$requestInput['password'];
       $haspassword=$super_data->password;

      if(Yii::$app->security->validatePassword($password,$haspassword)){

 
        $list['status'] = "success";
        $list['message'] = "Logged In successfully"; 
        $list['login_key'] = "S";
        $list['login_name']= $requestInput['username'];
        $list['login_id']= $super_data->id; 
        $list['employee_id']= $super_data->employee_id; 
        $list['authkey']= $super_data->authkey; 
        $list['superviser_name']= $super_data->name; 
        $list['login_unique_key']= 'superviser';
        

        $loginkey="S";
      }else{
        $list['message'] = 'Invalid Login';
        $login_status="F";
      }
    }else if(!empty($bunk_data)){  
      $password=$requestInput['password'];
       $haspassword=$bunk_data->password;
      if(Yii::$app->security->validatePassword($password,$haspassword)){ 
 
        

        $list['status'] = "success";
        $list['message'] = "Logged In successfully"; 
        $list['login_key'] = "B";
        $list['login_name']= $requestInput['username'];
        $list['login_id']= $bunk_data->id;
        $list['employee_id']= $bunk_data->manager_name; 
        $list['authkey']= $bunk_data->authkey;
        $list['agency_name']= $bunk_data->bunk_agency_name; 
        $list['login_unique_key']= 'branch';
        
 

        $loginkey="B";
      }else{
        $list['message'] = 'Invalid Login';
        $login_status="F";
      }
   
        }else if(!empty($trip_data)){ 

       //echo "<pre>";   print_r($trip_data);die;
       $password=$requestInput['password'];
       $haspassword=$trip_data->password;

       
       $login_log=StkCountLoginLog::find()->where(['login_username'=>$requestInput['username']])->andWhere(['allow_status'=>'blocked'])->count();
       if($login_log==0){
      if(Yii::$app->security->validatePassword($password,$haspassword)){
          $lgin_log=new StkCountLoginLog();
          $lgin_log->login_username=$requestInput['username'];
          $lgin_log->allow_status='blocked';
          $lgin_log->login_time=date('Y-m-d H:i:s');
          $lgin_log->save();
            
          $trip = TripDetails::find()->where(['status'=>"A"])
          ->andWhere(['vehicle_number'=>$requestInput['username']])
          ->andWhere(['trip_current_status'=>'S'])
          ->asArray()->one();
          $tripstatus='';
          $trip_code='';
        if(!empty($trip)){
          $tripstatus ="IN_TRIP";
          $trip_code = $trip['trip_title'];

        }

       
        $list['status'] = "success";
        $list['message'] = "Logged In successfully";

          //OTP

    $mobile_number = $trip_data->contact_no;
    //$mobile_number = "8760776740";
    $vehicle_no    = $requestInput['username'];
    $status        = "login_send";
    $device_id="";
    if(isset($requestInput['device_id'])){
    $device_id     = $requestInput['device_id'];
    }
    if($status="login_send")
    {
      $ff = $this->randomnumber(4);
    // $ff = '5555';
      $stklog= new AllenOtpLog(); 
      $stklog->mobile_number = $mobile_number;
      $stklog->vehicle_number= $vehicle_no;
      $stklog->mobile_model  = $device_id;
      $stklog->otp_number    = $ff;
      $stklog->created_at    = date('Y-m-d H:i:s');
      if($stklog->save())
      {
      $sms = 'DO NOT SHARE: '.$stklog->otp_number.' is the ACCOUNT PASSWORD for your allen account. Keep this OTP to yourself for account safety.'; 
    $sms_url = "http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp";
    $mobilenumber="";
    
  if($mobile_number!="" && is_numeric($mobile_number) && strlen($mobile_number)=="10"){
      
     $mobilenumber = "91".$mobile_number;


//print_r($mobilenumber);die;
     $sms=urlencode($sms);
    $url = $sms_url."?username=allentrans&password=1031377235&sendername=ALLENT&mobileno=".$mobilenumber."&message=".$sms;
    //echo $url; die;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $d_ret = curl_exec($ch);
        curl_close($ch);
     //////// echo $d_ret; die;
          if($d_ret=="no"){ 
             $list['otp_status']='error';
             $list['otp_message']='Invalid Mobile Number.';
          }else if($d_ret=='DND'){
             $list['otp_status']='error';
             $list['otp_message']='Invalid message.';
          }else{
             $list['otp_status']='success';
             /*$list['otp_number']=$stklog->otp_number;*/
             $list['otp_message']='OTP Generated Successfully';       
            } 
        }else{ 
             $list['otp_status']='error';
             $list['otp_message']='Invalid Mobile Number.';
        }
 
      }
    } 


      //OTP
        $list['login_key'] = "T";
        $list['login_name']= $requestInput['username'];
        $list['login_id']= $trip_data->id;
        $list['authkey']= $trip_data->authkey; 
        $list['driver_name']= $trip_data->first_name.' '.$trip_data->last_name; 
        if($trip_data->contact_no!="" && $trip_data->contact_no!=NULL){
        $list['contact_number']= $trip_data->contact_no; 
        }else{
        $list['contact_number']= $trip->driver_contact; 
          
        }
        $list['login_unique_key']= 'trip_vehicle';
        $list['trip_status']= $tripstatus;
        $list['trip_code']= $trip_code;
     
         $loginkey="T";
        }else{
          $list['message'] = 'Invalid Login';
          $login_status="F";
        }
    }else{
         $list['message'] = 'This username already in working';
    }
    }else{
          $list['message'] = 'Invalid Login';
          $login_status="F";
        }
  }
        $response['Output'][] = $list;
       //  return json_encode($response);
       $log_model=AllenApiLog::findOne($log_id);
       if($log_model){
        $log_model->response=json_encode($response);
         $log_model->save();
       }
  
        return json_encode($response);
  }

  public function actionTripLogin()
{ 
  $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
//log table
  $log_model=new AllenApiLog();
  $log_model->event='allen-trip-login';
  //$log_model->event_key='crm_app';
  $log_model->data=$postd;
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
  
  $list['status'] = 'error';
  $list['message'] = 'Nill';
    
    $field_check=array('username','password');
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
    $super_data = Triplogin::find()
          ->where(['username'=>$requestInput['username']])
          ->andWhere(['status'=>'A'])
          ->one();   
    
 //echo "<pre>";   print_r($super_data);die;
    $loginkey='';
    $login_status="S";
    $branch_id='';
    $list['login_key'] = "";
    if(!empty($super_data)){ 
      $password=$requestInput['password'];
       $haspassword=$super_data->password;

       
       $login_log=StkCountLoginLog::find()->where(['login_username'=>$requestInput['username']])->andWhere(['allow_status'=>'blocked'])->count();
       if($login_log==0){
      if(Yii::$app->security->validatePassword($password,$haspassword)){
          $lgin_log=new StkCountLoginLog();
          $lgin_log->login_username=$requestInput['username'];
          $lgin_log->allow_status='blocked';
          $lgin_log->login_time=date('Y-m-d H:i:s');
          $lgin_log->save();
        $list['status'] = "success";
        $list['message'] = "Logged In successfully"; 
        $list['login_key'] = "T";
        $list['login_name']= $requestInput['username'];
        $list['login_id']= $super_data->id;
        $list['authkey']= $super_data->authkey; 
        $list['driver_name']= $super_data->first_name.' '.$super_data->last_name; 
        $list['login_unique_key']= 'trip_vehicle';
      
        $loginkey="T";
        }else{
          $list['message'] = 'Invalid Login';
          $login_status="F";
        }
    }else{
         $list['message'] = 'This username already in working';
    }
    }else{
          $list['message'] = 'Invalid Login';
          $login_status="F";
        }
  }
        $response['Output'][] = $list;
       //  return json_encode($response);
       $log_model=AllenApiLog::findOne($log_id);
       if($log_model){
        $log_model->response=json_encode($response);
         $log_model->save();
       }
  
        return json_encode($response);
  }


  public function actionTripLogout(){
  $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true);
  $list['status'] = 'error';
  $field_check=array('username');
  $is_error = '';
  $log_model=new AllenApiLog();
    $log_model->event='trip-logout';
    $log_model->data=$postd;
    $log_model->created_at=date("Y-m-d H:i:s");
    $log_model->save();
  
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
    $username=$requestInput['username'];
    $stklog=StkCountLoginLog::find()->where(['login_username'=>$username])->andWhere(['allow_status'=>'blocked'])->one();
    if($stklog){
      $stklog->allow_status='released';
      $stklog->logout_time=date('Y-m-d H:i:s');
      $stklog->save();
    }
      $list['message']='Logged Out Successfully';
      $list['status']='success';
  }
  
   $response= $list;
     
  return json_encode($response);


}

function randomnumber($size = 4)
{
    $random_number='';
    $count=0;
    while ($count < $size ) 
        {
            $random_digit = mt_rand(0, 9);
            $random_number .= $random_digit;
            $count++;
        }
    return $random_number;  
}
 public function actionOtpSend(){
  $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true);
  $list['status'] = 'error';
  $field_check=array('mobile_number','vehicle_no','status','device_id');
  $is_error = ''; 
  $log_model=new AllenApiLog();
    $log_model->event='otp-send';
    $log_model->data=$postd;
    $log_model->created_at=date("Y-m-d H:i:s");
    $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
  
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
    $mobile_number = $requestInput['mobile_number'];
    $vehicle_no    = $requestInput['vehicle_no'];
    $status        = $requestInput['status'];
    $device_id     = $requestInput['device_id'];
    if($status="login_send")
    {
      $ff = $this->randomnumber(4);
    // $ff = '5555';
      $stklog= new AllenOtpLog(); 
      $stklog->mobile_number = $mobile_number;
      $stklog->vehicle_number= $vehicle_no;
      $stklog->mobile_model  = $device_id;
      $stklog->otp_number    = $ff;
      $stklog->created_at    = date('Y-m-d H:i:s');
      if($stklog->save())
      {
      $sms = 'DO NOT SHARE: '.$stklog->otp_number.' is the ACCOUNT PASSWORD for your allen account. Keep this OTP to yourself for account safety.'; 
    $sms_url = "http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp";
    $mobilenumber="";
    
  if($stklog->mobile_number!="" && is_numeric($stklog->mobile_number) && strlen($stklog->mobile_number)=="10"){
      
     $mobilenumber = "91".$stklog->mobile_number;

     $sms=urlencode($sms);
    $url = $sms_url."?username=allentrans&password=1031377235&sendername=ALLENT&mobileno=".$mobilenumber."&message=".$sms;
    //echo $url; die;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $d_ret = curl_exec($ch);
        curl_close($ch);
     //////// echo $d_ret; die;
          if($d_ret=="no"){ 
             $list['status']='error';
             $list['message']='Invalid Mobile Number.';
          }else if($d_ret=='DND'){
             $list['status']='error';
             $list['message']='Invalid message.';
          }else{
             $list['status']='success';
             $list['otp_number']=$stklog->otp_number;
             $list['message']='OTP Generated Successfully';       
            } 
        }else{ 
             $list['status']='error';
             $list['message']='Invalid Mobile Number.';
        }
 
      }else{ 
        $list['status'] = 'error';
        $list['message']='Something went Wrong';
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
public function actionOtpVerify(){
  $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true);
  $list['status'] = 'error';
  $field_check=array('mobile_number','vehicle_no','status','device_id','otp_number');
  $is_error = '';
  $log_model=new AllenApiLog();
    $log_model->event='otp-verify';
    $log_model->data=$postd;
    $log_model->created_at=date("Y-m-d H:i:s");
     if($log_model->save()){
    $log_id=$log_model->autoid;
  }
  
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
    $mobile_number = $requestInput['mobile_number'];
    $vehicle_no    = $requestInput['vehicle_no'];
    $status        = $requestInput['status'];
    $device_id     = $requestInput['device_id'];
    $otp_number     = $requestInput['otp_number'];
     if($status="login_verify")
    {
      $stklog= AllenOtpLog::find()->where(['otp_number'=>$otp_number])
      ->andWhere(['mobile_number'=>$mobile_number])
      ->andWhere(['vehicle_number'=>$vehicle_no])
      ->andWhere(['status'=>"S"])->one(); 

      if(!empty($stklog)){
        $stklog->status = "A";
        if($stklog->save()){
            $list['status']='success';
            $list['message']='OTP Verification Successfully';
        }else
        {
            $list['status']='error';
            $list['message']='OTP Verification Failed';
        }
        }else
        {  
            $list['status']='error';
            $list['message']='OTP Verification Failed';
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
 

    public function actionCouponReport(){
      
      
      /* if(empty($_GET['fromdate']) && empty($_GET['todate']) && empty($_GET['reg_no']) && 
        empty($_GET['superviser']) && empty($_GET['client']) && empty($_GET['coupon_status'])){*/
          $searchModel = new VehicleMasterSearch();
      $dataProvider = $searchModel->reportsearch(Yii::$app->request->queryParams);
      $session = Yii::$app->session; 
   
    require 'vendor/autoload.php';
    $objPHPExcel = new Spreadsheet(); 
    $sheet = 0;
    //set_time_limit(500); 
    ini_set('max_execution_time', 600);
    $objPHPExcel -> setActiveSheetIndex($sheet);
    /*$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(20);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(20);*/
    $all_post_key = array("Sl. No.", 'vehicle_no','refuel_amount','total_coupon','closed_coupon','pending_coupon','coupon_amount','difference_amount','pending_amount');
    
    $r=0;
    $objPHPExcel -> getActiveSheet() -> setTitle("Allen Trans Vehicle Reports")          
    -> setCellValue('A1', $all_post_key[$r])
    -> setCellValue('B1', 'Vehicle No') 
    -> setCellValue('C1', 'Refueled Coupon Amount')
    -> setCellValue('D1', 'Total Coupons')
    -> setCellValue('E1', 'Closed Coupons')
    -> setCellValue('F1', 'Pending Coupons')
    -> setCellValue('G1', 'Total Coupon Amount')
    -> setCellValue('H1', 'Refueled Difference Amount (Closed Coupons)')
    -> setCellValue('I1', 'Pending Coupon Amount');
  

    $from = date('Y-m-d 00:00:00', strtotime('first day of last month'));
    $to = date('Y-m-d 23:59:59', strtotime('last day of last month')); 

    $query = new Query;
    $query  ->select(['*,SUM(coupon_amount) as coupon_amount,SUM(refuel_amount) as refuel_amount, count(id) as total, count(IF( coupon_status = "C",1, NULL )) as closed_status, count(IF( coupon_status = "P",1, NULL )) as pending_status, SUM(IF( coupon_status = "P",coupon_amount, NULL )) as pending_amount, SUM(IF( coupon_status = "C",coupon_amount, NULL )) as closed_amount'])->from('coupon')->where(['not',['bunk_name'=>'']])->andWhere(['BETWEEN','created_at',$from,$to]);

     $query ->groupBy('vehicle_name');   
    $command = $query->createCommand(); 
    $un_send_data = $command->queryAll();
    
    $vehicle_index=ArrayHelper::map($un_send_data,'vehicle_name','vehicle_name'); 
    
    $VehicleMaster = VehicleMaster::find()->where(['IN','id',$vehicle_index])->asArray()->all();
    
    $vehicle_name = ArrayHelper::map($VehicleMaster,'id','vehicle_name');
    $vehicle_id = ArrayHelper::map($VehicleMaster,'id','id');
    $vehicle_no = ArrayHelper::map($VehicleMaster,'id','reg_no');  

  

    $row = 2;
    $slno=1;     
    $refuel_receipt='';   //echo "<pre>"; print_r($un_send_data); die;
    foreach($un_send_data as $one_data){ //echo $one_data['driver_name'].'---';
      $r_a=65;$r_a1=64;     
      foreach($all_post_key as $one_field){
        $cell_char=chr($r_a);
        if($r_a1>=65){
          $cell_char=chr($r_a1).chr($r_a);
        }
         $driver_name='';
        if($one_field=='Sl. No.'){
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $slno);
        }
       
        else if($one_field=='vehicle_no'){
          $vehi='';
          if(array_key_exists($one_data['vehicle_name'], $vehicle_id)) { 
              $vehi_no = $vehicle_no[$one_data['vehicle_name']];
            }  
             $vehi = $vehi_no;
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $vehi_no); 
       } 
       else if($one_field=='total_coupon'){
          
             
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $one_data['total']); 
       } 

       else if($one_field=='closed_coupon'){
          
             $vehi = count($un_send_data);
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $one_data['closed_status']); 
       }  

       else if($one_field=='pending_coupon'){
          
             $vehi = count($un_send_data);
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $one_data['pending_status']); 
       }  

        else if($one_field=='coupon_amount'){  
          $coupon_amount = number_format($one_data['coupon_amount'],2, '.', '');
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $coupon_amount);
        }

        else if($one_field=='refuel_amount'){
           $refuel_amount = number_format($one_data['refuel_amount'],2, '.', '');
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $refuel_amount);
        }

         else if($one_field=='difference_amount'){
          
          $diff = $one_data['closed_amount'] - $one_data['refuel_amount'];
          $diff_amount = number_format($diff,2, '.', '');  
          if($one_data['coupon_status']=="P"){ //die;
            $diff_amount = "Coupon Pending";
          }else{
          } 

          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $diff_amount);
        }else if($one_field=='pending_amount'){
           
           $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $one_data['pending_amount']);
        }

         
        
        if($r_a>=90){
          $r_a=64;
          $r_a1++;          
        }
        $r_a++;
      }
      $slno++;      
      $row++;
    } // die;
        $fromday = date('d-m-Y', strtotime('first day of last month'));
        $today = date('d-m-Y', strtotime('last day of last month')); 
        $objWriter = new Xlsx($objPHPExcel); 
        $filename = "Monthly_Coupon_Details_".$fromday.'_to_'.$today.".xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');   
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_end_clean();
        $objWriter->save('php://output');  
      
      
         }
  //}

 

}
