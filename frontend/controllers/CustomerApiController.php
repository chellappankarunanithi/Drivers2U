<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\ClientVehicleMap;
use backend\models\BunkMaster;
use backend\models\Coupon;
use backend\models\DriverProfile;
use backend\models\VehicleMaster;
use backend\models\SuperviserMaster;
use yii\web\UploadedFile;
use backend\models\ClientMaster;
use backend\models\CouponList;
use backend\models\AllenApiLog;
use backend\models\SuperviserClientMap;
use backend\models\Triplogin;
use backend\models\StkCountLoginLog;
use yii\db\Expression;
class CustomerApiController extends Controller
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
	$user_data_role = SuperviserMaster::find()
					->where(['authkey'=>$authorization])
					->one(); 

	if(!empty($user_data_role))
  {  
		return $user_data_role;
	}else
  {    
        $user_data_role_1 = BunkMaster::find()
          ->where(['authkey'=>$authorization])
          ->one(); 
    if(!empty($user_data_role_1))
    { 
        return $user_data_role_1;
    }else
    { 
        $user_data_role_2 = Triplogin::find()
          ->where(['authkey'=>$authorization])
          ->one(); 
          // echo "<pre>";print_r($user_data_role_2);die;
        if($user_data_role_2)
        { 
          return $user_data_role_2;
        }else
        {
          return false;
        }
    }
	}
}

/******          bunk-list               ****************/
public function actionBunkList()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key');
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
      if($login_key!="")
      {
        $bunk_data = BunkMaster::find() 
          ->where(['status'=>'Active'])
          ->asArray()
          ->all(); 
        if(!empty($bunk_data)){
        foreach ($bunk_data as $key => $value) {
          $det['id'] = $value['id'];
          $det['manager_name'] = ucwords($value['manager_name']);
          $det['bunk_agency_name'] = ucwords($value['bunk_agency_name']);
          $det['bunk_company'] = ucwords($value['bunk_company']);
          $det['status'] = $value['status'];
          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['bunk_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Bunk List not Available';
        $list['bunk_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['bunk_list']=array();
    }
  }
    $response['Output'][] = $list;
        
         return json_encode($response);
}
}


/******          vehicle-list               ****************/
public function actionVehicleList()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 

  $log_model=new AllenApiLog();
	$log_model->event='vehicle-list';
	//$log_model->event_key='crm_app';
	$log_model->data=$postd;
	$log_id='';
	if($log_model->save()){
		$log_id=$log_model->autoid;
	}
 

  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key','client_id');
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
      if($login_key!="")
      {

        $DriverProfiles = DriverProfile::find()->where(['status'=>'Active'])
        ->andWhere(['available_status'=>'1'])->asArray()->all(); 

        $driver_name = ArrayHelper::map($DriverProfiles,'id','name');
        $emp_id = ArrayHelper::map($DriverProfiles,'id','employee_id');

        $clientmap = ClientVehicleMap::find()->where(['client_id'=>$requestInput['client_id']])
        ->andWhere(['vehicle_status'=>'A'])->asArray()->all();
        $vehi_ids = ArrayHelper::map($clientmap,'vehicle_id','vehicle_id');
        //echo "<>";
        $validate_vehicle = Coupon::find()->andWhere(['coupon_status'=>'P'])->asArray()->all();
        $pending_ids = ArrayHelper::map($validate_vehicle,'vehicle_name','vehicle_name');

        $VehicleMaster = VehicleMaster::find()->where(['status'=>'Active'])
        ->andWhere(['IN','id',$vehi_ids])
        ->andWhere(['NOT IN','id',$pending_ids])
        ->andWhere(['not',['driver_id'=>'']])->asArray()->all(); 

        if(!empty($VehicleMaster)){
        foreach ($VehicleMaster as $key => $value) {
          $det['id'] = $value['id'];
          $det['vehicle_name'] = $value['vehicle_name'];
          $det['register_number'] = $value['reg_no'];
          $det['driver_id'] = $value['driver_id'];
          $det['driver_name']="";
          if (isset($driver_name[$value['driver_id']])) {
             $det['driver_name'] = ucwords($driver_name[$value['driver_id']]);
          }
          $det['employee_id'] = "";
           if (isset($emp_id[$value['driver_id']])) {
            $det['employee_id'] = $emp_id[$value['driver_id']];
          } 
          $det['status'] = $value['status'];
          $det1[]=$det;

        }

        $list['status']='success';
        $list['message']='success';
        $list['vehicle_list']=$det1;

      }else{

        $list['status']='success';
        $list['message']='Vehicle List not Available';
        $list['vehicle_list']=array();

      }
    }else{

        $list['status']='error';
        $list['message']='Invalid User';
        $list['vehicle_list']=array();

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
}


/******          driver-list               ****************/
public function actionDriverList()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
 $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key','driver_status');
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
      $driver_status = $requestInput['driver_status'];
      if($login_key!="")
      { 
        if($driver_status=="A"){
          $driver_status = '0';
        }else if($driver_status=="UA"){
          $driver_status = '1';
        }
        $DriverProfile = DriverProfile::find() 
          ->where(['status'=>'Active'])
          ->andWhere(['available_status'=>$driver_status])
          ->asArray()
          ->all(); 
         
        /*else{
           $DriverProfile = DriverProfile::find() 
          ->where(['status'=>'Active'])
          //->andWhere(['available_status'=>'1'])
          ->asArray()
          ->all();
        }*/


        if(!empty($DriverProfile)){
        foreach ($DriverProfile as $key => $value) {
          $det['id'] = $value['id'];
          $det['name'] = ucwords($value['name']);
          $det['employee_id'] = $value['employee_id'];
          $det['aadhar_no'] = $value['aadhar_no'];
          $det['available_status'] = $value['available_status'];
          $det['status'] = $value['status'];
          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['driver_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Driver List not Available';
        $list['driver_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['driver_list']=array();
    }
  }
    $response['Output'][] = $list;
        
         return json_encode($response);
}
}


/******          client-list               ****************/
public function actionClientList()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
   $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){ 

    $field_check=array('client_status','user_id');
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
      $client_status = $requestInput['client_status'];
      $user_id = $requestInput['user_id'];

      if($user_id!="")
      { 

        $ClientSupervisor = SuperviserClientMap::find()->where(['superviser_name'=>$user_id])
        ->asArray()->all();
        $supervisor_Arr = ArrayHelper::map($ClientSupervisor,'client_name','client_name');
        if($client_status=="A"){
        $ClientMaster = ClientMaster::find() 
          ->where(['status'=>'Active'])
          ->andWhere(['IN','id',$supervisor_Arr])
          ->asArray()
          ->all(); 
        }else{
           $ClientMaster = ClientMaster::find()
           ->where(['IN','id',$supervisor_Arr])
           //->andWhere(['superviser_name'=>$user_id])
          ->asArray()
          ->all();
        }
        $supervisor = SuperviserMaster::find()->where(['status'=>'Active'])->asArray()->all();
        $supervisor_name = ArrayHelper::map($supervisor,'id','name');
        $employee_id = ArrayHelper::map($supervisor,'id','employee_id');
        
        if(!empty($ClientMaster)){
        foreach ($ClientMaster as $key => $value) {
          $det['id'] = $value['id'];
          $det['company_name'] = ucwords($value['company_name']);
          $det['contact_person_name'] = ucwords($value['client_name']);
          $det['mobile_no'] = $value['mobile_no'];
          $det['supervisor_id'] = $value['superviser_name'];
          $det['superviser_name']='';
          if(isset($supervisor_name[$value['superviser_name']])){
          $det['superviser_name']=ucwords($supervisor_name[$value['superviser_name']]);
          }

          $det['employee_id']='';
          if(isset($employee_id[$value['superviser_name']])){
          $det['employee_id']=$employee_id[$value['superviser_name']];
          }
          $det['status'] = $value['status'];
          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['client_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Client List not Available';
        $list['client_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['client_list']=array();
    }
  }
    $response['Output'][] = $list;
        
         return json_encode($response);
}
}

/******          supervisor-list               ****************/
public function actionSupervisorList()
{ // echo "asd"; die;
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';

  if($user_data_role=$this->authorization()){ 
    
    $field_check=array('login_key');
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
      if($login_key!="")
      {
        $SuperviserMaster = SuperviserMaster::find() 
          ->where(['status'=>'Active'])
          ->asArray()
          ->all(); 
        if(!empty($SuperviserMaster)){
        foreach ($SuperviserMaster as $key => $value) {
          $det['id'] = $value['id'];
          $det['name'] = ucfirst($value['name']);
          $det['employee_id'] = $value['employee_id'];
          $det['status'] = $value['status'];
          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['supervisor_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Supervisor List not Available';
        $list['supervisor_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['supervisor_list']=array();
    }
  }
}
    $response['Output'][] = $list;
        
         return json_encode($response);

}


/******          coupon-generate               ****************/
public function actionCouponGenerate()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
//log table
	$log_model=new AllenApiLog();
	$log_model->event='coupon-generate';
	//$log_model->event_key='crm_app';
	$log_model->data=$postd;
	$log_id='';
	if($log_model->save()){
		$log_id=$log_model->autoid;
	}
	
 $det=array();
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key','client_id','login_id','vehicle_id','bunk_id','coupon_amount','coupon_number');
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
      $login_key     = $requestInput['login_key']; 
      $client_id     = $requestInput['client_id'];
      $login_id      = $requestInput['login_id'];
      $vehicle_id    = $requestInput['vehicle_id'];
      $bunk_id       = $requestInput['bunk_id'];
      $coupon_amount = $requestInput['coupon_amount']; 
      $coupon_number = $requestInput['coupon_number']; 
      $description = ''; 
      if(isset($requestInput['description']) && $requestInput['description']!=""){
       $description = $requestInput['description'];
      }

      if($login_key!="")
      {
        $reg_no="";
        $VehicleMaster = VehicleMaster::find()->where(['id'=>$vehicle_id])->asArray()->one();
        if($VehicleMaster){
          $reg_no = $VehicleMaster['reg_no'];
          $driver_name = $VehicleMaster['driver_id'];
        }
        $validate_vehicle = Coupon::find()->where(['vehicle_name'=>$vehicle_id])->andWhere(['coupon_status'=>'P'])->asArray()->one();
        if(empty($validate_vehicle)){  
        $validate = Coupon::find()->where(['coupon_code'=>$coupon_number])->asArray()->one();

        if(empty($validate)){
 
        $model = new Coupon();  
          $model->superviser_id = $login_id;
          $model->client_name     = $client_id;
          $model->vehicle_name    = $vehicle_id;
          $model->driver_name    = $driver_name;
          $model->bunk_name       = $bunk_id;
          $model->coupon_amount = $coupon_amount;
          $model->description = $description;

          $rand = rand(0,9999);

         // $model->coupon_code = $rand.'-'.$login_id.'-'.date('dmYHis').'-'.$reg_no;
          $model->coupon_code = $coupon_number;
          $model->created_at = date('Y-m-d H:i:s');
          $model->coupon_gen_date = date('Y-m-d H:i:s');
          
         if($model->save()){
          $models = Coupon::find()->where(['id'=>$model->getPrimaryKey()])->asArray()->one();
        $det['id'] = $models['id'];
        $det['coupon_code'] = $models['coupon_code'];
        $det['superviser_id'] = $models['superviser_id'];
        $det['description'] = $models['description'];
        $det['bunk_name'] = $models['bunk_name'];
        $det['vehicle_name'] = $models['vehicle_name'];
        $det['client_name'] = $models['client_name'];
        $det['coupon_amount'] = $models['coupon_amount'];
        $det['coupon_gen_date'] = date('d-m-Y H:i:s', strtotime($models['coupon_gen_date']));
        $det['created_at'] = date('d-m-Y H:i:s', strtotime($models['created_at']));
        $det['coupon_status'] = $models['coupon_status'];
        $CouponList = new CouponList();
        $coupon_list = $CouponList->couponsave($models);
        $list['status']='success';
        $list['message']='Coupon Generated Successfully';
        $list['coupon_list']=$det;
        
      }else{ // echo "<pre>"; print_r($model->getErrors()); die;
        $list['status']='error';
        $list['message']='Coupon Generated Failed';
        $list['coupon_list']=(object)$det;
      }
    }else{
        $list['status']='error';
        $list['message']='Coupon Number Already Exist.';
        $list['coupon_list']=(object)$det;
    }
  }
    else{
        $list['status']='error';
        $list['message']='Previous Coupon pending for this Vehicle.';
        $list['coupon_list']=(object) $det;
    }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['coupon_list']=(object)$det;
    }
  }
}else{
		    $list['status']='error';
        $list['message']='Invalid Authorization Request!';
        $list['coupon_list']=(object)$det;
}
    $response['Output'][] = $list;
        
       	$log_model=AllenApiLog::findOne($log_id);
		 if($log_model){
		 	$log_model->response=json_encode($response);
			 $log_model->save();
		 }
	
        return json_encode($response);
		
	 
}
 
/******          coupon-close               ****************/
public function actionCouponClose()
{
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 


  $log_model=new AllenApiLog();
	$log_model->event='coupon-close';
	//$log_model->event_key='crm_app';
	$log_model->data=$postd;
	$log_id='';
	if($log_model->save()){
		$log_id=$log_model->autoid;
	}
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){
    
    $field_check=array('login_key','coupon_id','refuel_amount','refuel_receipt');
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
      $login_key     = $requestInput['login_key']; 
      $coupon_id     = $requestInput['coupon_id']; 
      $refuel_amount = $requestInput['refuel_amount']; 
      $refuel_receipt= $requestInput['refuel_receipt']; 

      if($login_key!="")
      {
        $model = Coupon::findOne($coupon_id);
  
          $model->refuel_amount = $refuel_amount; 
          $model->coupon_status = "C";
          $model->refuel_date = date('Y-m-d H:i:s');
          $model->coupon_close_date = date('Y-m-d H:i:s');
          /****   file upload   ******/ 
          define('UPLOAD_DIR', 'backend/web/uploads/bunk_receipt/');
      $img = $refuel_receipt;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      $file = UPLOAD_DIR .$model->coupon_code.'_'.date('dmYHis').'_.png';
      $success = file_put_contents($file, $data);
      //print $success ? $file : 'Unable to save the file.';
      $model->refuel_receipt = $file;

          /****   file upload   ******/ 

         if($model->save()){
          $models = Coupon::find()->where(['id'=>$model->getPrimaryKey()])->asArray()->one();
        $det['id'] = $models['id'];
        $det['coupon_code'] = $models['coupon_code'];
        $det['superviser_id'] = $models['superviser_id'];
        $det['description'] = $models['description'];
        $det['bunk_name'] = $models['bunk_name'];
        $det['vehicle_name'] = $models['vehicle_name'];
        $det['client_name'] = $models['client_name'];
        $det['coupon_amount'] = $models['coupon_amount'];
        $det['coupon_gen_date'] = date('d-m-Y H:i:s', strtotime($models['coupon_gen_date']));
        $det['created_at'] = date('d-m-Y H:i:s', strtotime($models['created_at']));
        $det['coupon_status'] = $models['coupon_status'];
        $det['refuel_amount'] = $models['refuel_amount'];
        $det['refuel_date'] = $models['refuel_date'];
        $det['coupon_close_date'] = $models['coupon_close_date'];
        $det['refuel_receipt'] = Url::home(true).$file;
        $CouponList = new CouponList();
        $coupon_list = $CouponList->couponclose($models);

        $list['status']='success';
        $list['message']='Coupon Closed Successfully';
        $list['coupon_list']=$det;
      }else{ //echo "<pre>"; print_r($model->getErrors()); die;
        $list['status']='error';
        $list['message']='Coupon Not closed';
        $list['coupon_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['coupon_list']=array();
    }
  }
       
}else{
		$list['status']='error';
        $list['message']='Invalid Authorization Request!';
        $list['coupon_list']=array();
}
    $response['Output'][] = $list;

    $log_model=AllenApiLog::findOne($log_id);
		 if($log_model){
		 	$log_model->response=json_encode($response);
			 $log_model->save();
		 } 
        return json_encode($response);
	
}

/******          coupon-list               ****************/
public function actionCouponList()
{ // echo "asd"; die;
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 


  $log_model=new AllenApiLog();
	$log_model->event='coupon-list';
	//$log_model->event_key='crm_app';
	$log_model->data=$postd;
	$log_id='';
	if($log_model->save()){
		$log_id=$log_model->autoid;
	}
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';

  if($user_data_role=$this->authorization()){ 
    
    $field_check=array('login_key','login_id','coupon_status');
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
      $coupon_status = $requestInput['coupon_status'];
      $login_id = $requestInput['login_id'];
      $search_key ='';
      

      if($login_key=="S")
      {
        $SuperviserMaster = SuperviserMaster::find()->where(['status'=>'Active'])->asArray() ->all(); 
        $supervisor_name  = ArrayHelper::map($SuperviserMaster,'id','name');
        $supervisor_code  = ArrayHelper::map($SuperviserMaster,'id','employee_id');
        $supervisor_no    = ArrayHelper::map($SuperviserMaster,'id','mobile_no');

        $DriverProfile    = DriverProfile::find()->where(['status'=>'Active'])->asArray() ->all();
        $driver_name      = ArrayHelper::map($DriverProfile,'id','name');
        $driver_code      = ArrayHelper::map($DriverProfile,'id','employee_id');
        $mobile_no        = ArrayHelper::map($DriverProfile,'id','mobile_number');

        $ClientMaster     = ClientMaster::find()->where(['status'=>'Active'])->asArray() ->all(); 
        $company_name     = ArrayHelper::map($ClientMaster,'id','company_name');
        $client_name      = ArrayHelper::map($ClientMaster,'id','client_name');

        $VehicleMaster    = VehicleMaster::find()->where(['status'=>'Active'])->asArray() ->all();
        $vehicle_id       = ArrayHelper::map($VehicleMaster,'id','id');
        $driver_vehicle_id= ArrayHelper::map($VehicleMaster,'id','driver_id');
        $vehicle_name     = ArrayHelper::map($VehicleMaster,'id','vehicle_name');
        $vehicle_number   = ArrayHelper::map($VehicleMaster,'id','reg_no');

        $BunkMaster       = BunkMaster::find()->where(['status'=>'Active'])->asArray() ->all();
        $agency_name      = ArrayHelper::map($BunkMaster,'id','bunk_agency_name');
        $manager_name     = ArrayHelper::map($BunkMaster,'id','manager_name');
        $bunk_company     = ArrayHelper::map($BunkMaster,'id','bunk_company');
        $bunk_mobile     = ArrayHelper::map($BunkMaster,'id','mobile_no');
          

        /************************* pagination   ************************/
        $page = 1;
        $start = 10;
        $limit = 10;
        if (isset($requestInput['page']) && $requestInput['page'] != "") {
          $page = $requestInput['page'];
          if (!is_numeric($page)) {
            $page = 1;
          }
          $start = $page * $limit;
        }

        /************************* pagination   ************************/

        if(isset($requestInput['search_key']) && $requestInput['search_key']!=""){
        $search_key = $requestInput['search_key'];
     
        $prod_ids=array();
        $product=VehicleMaster::find()->where(['LIKE','reg_no',$search_key.'%',false])->asArray()->all();
        if(!empty($product)){
        $prod_ids=ArrayHelper::map($prod_idd,'id','id');
        }  

        if ($coupon_status=="P") {
          $coupon_status="P";
        }else if($coupon_status=="C"){
          $coupon_status="C";
        }
         $model = Coupon::find()->where(['coupon_status'=>$coupon_status])
         ->andWhere(['superviser_id'=>$login_id])
         ->andWhere(['IN','vehicle_id',$prod_ids])
         ->asArray()->orderBy(['id'=>SORT_DESC])->all();
        
      }else{

        if ($coupon_status=="P") {
          $coupon_status="P";
        }else if($coupon_status=="C"){
          $coupon_status="C";
        }
         $model = Coupon::find()->where(['coupon_status'=>$coupon_status])
         ->andWhere(['superviser_id'=>$login_id])
         ->asArray()->orderBy(['id'=>SORT_DESC])->all();
      }
 
      // echo "<pre>";
      // print_r($model); die;
        if(!empty($model)){
        foreach ($model as $key => $c1) {
          $det['id'] = $c1['id'];
          $det['coupon_code'] = $c1['coupon_code'];
          $det['superviser_id'] = $c1['superviser_id'];
          $det['client_id'] = $c1['client_name'];
          $det['bunk_id'] = $c1['bunk_name'];
          $det['vehicle_id'] = $c1['vehicle_name'];
          $det['coupon_amount'] = $c1['coupon_amount'];

          $det['coupon_gen_date'] = date('d-m-Y', strtotime($c1['coupon_gen_date']))." ".date('h:i A', strtotime($c1['coupon_gen_date']));
          $det['created_at'] = date('d-m-Y H:i:s', strtotime($c1['created_at']));

           $det['vehicle_name']='';
          if(isset($vehicle_name[$c1['vehicle_name']])){
            $det['vehicle_name']=$vehicle_name[$c1['vehicle_name']];
          }
          $det['vehicle_number']='';
          if(isset($vehicle_number[$c1['vehicle_name']])){
            $det['vehicle_number']=$vehicle_number[$c1['vehicle_name']];
          }

          $det['driver_name']='';
          $det['driver_code']='';
          $det['driver_mobile_no']='';
          if(isset($vehicle_id[$c1['vehicle_name']])){

            if(isset($driver_name[$driver_vehicle_id[$c1['vehicle_name']]])){
               $det['driver_name']=ucwords($driver_name[$driver_vehicle_id[$c1['vehicle_name']]]);
            }
           if(isset($driver_code[$driver_vehicle_id[$c1['vehicle_name']]])){
               $det['driver_code']=$driver_code[$driver_vehicle_id[$c1['vehicle_name']]];
            }
            if(isset($mobile_no[$driver_vehicle_id[$c1['vehicle_name']]])){
               $det['driver_mobile_no']=$mobile_no[$driver_vehicle_id[$c1['vehicle_name']]];
            }
          } 
         
 
          $det['contact_person_name']='';
          if(isset($client_name[$c1['client_name']])){
            $det['contact_person_name']=ucwords($client_name[$c1['client_name']]);
          }

           $det['client_company_name']='';
          if(isset($company_name[$c1['client_name']])){
            $det['client_company_name']=$company_name[$c1['client_name']];
          }
  
          $det['superviser_name'] ='';
          if(isset($supervisor_name[$c1['superviser_id']])){
            $det['superviser_name']=ucwords($supervisor_name[$c1['superviser_id']]);
          }
          $det['supervisor_code'] ='';
          if(isset($supervisor_code[$c1['superviser_id']])){
            $det['supervisor_code']=$supervisor_code[$c1['superviser_id']];
          }
          $det['supervisor_contact'] ='';
          if(isset($supervisor_no [$c1['superviser_id']])){
            $det['supervisor_contact']=$supervisor_no[$c1['superviser_id']];
          }


           $det['bunk_agency_name'] ='';
          if(isset($agency_name[$c1['bunk_name']])){
            $det['bunk_agency_name']=ucwords($agency_name[$c1['bunk_name']]);
          }

           $det['bunk_company_name'] ='';
          if(isset($bunk_company[$c1['bunk_name']])){
            $det['bunk_company_name']=$bunk_company[$c1['bunk_name']];
          }

           $det['manager_name'] ='';
          if(isset($manager_name[$c1['bunk_name']])){
            $det['manager_name']=ucwords($manager_name[$c1['bunk_name']]);
          }

           $det['bunk_contact'] ='';
          if(isset($bunk_mobile[$c1['bunk_name']])){
            $det['bunk_contact']=$bunk_mobile[$c1['bunk_name']];
          }

          $det['coupon_status'] = $c1['coupon_status'];

          $det['refuel_date'] = '';
          if($c1['refuel_date']!=""){
          $det['refuel_date'] = date('d-m-Y', strtotime($c1['refuel_date']))." ".date('h:i A', strtotime($c1['refuel_date']));
          }
          $det['coupon_close_date'] = '';
          if($c1['coupon_close_date']!=""){
         $det['coupon_close_date'] = date('d-m-Y', strtotime($c1['coupon_close_date']))." ".date('h:i A', strtotime($c1['coupon_close_date']));
          }

          $det['refuel_receipt'] = '';
          if($c1['refuel_receipt']!=""){
          $det['refuel_receipt'] = Url::home(true).$c1['refuel_receipt'];
          }


          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['coupon_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Coupon List not Available';
        $list['coupon_list']=(object) $det1;
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['coupon_list']= (object) $det1;
    }
  }
}else{
		$list['status']='error';
        $list['message']='Invalid Authorization Request!';
        $list['coupon_list']=(object) $det1;
}
		$response['Output'][] = $list;
		$log_model=AllenApiLog::findOne($log_id);
		if($log_model){
			$log_model->response=json_encode($response);
		 $log_model->save();
		}

		return json_encode($response);

}


/******          refuel-list               ****************/
public function actionRefuelList()
{ // echo "asd"; die;
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $log_model=new AllenApiLog();
  $log_model->event='refuel-list';
  //$log_model->event_key='crm_app';
  $log_model->data=$postd;
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }


  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';

  if($user_data_role=$this->authorization()){ 
    
    $field_check=array('login_key','login_id','coupon_status');
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
      $coupon_status = $requestInput['coupon_status'];
      $login_id = $requestInput['login_id'];
      
      if($login_key=="B")
      {
        $SuperviserMaster = SuperviserMaster::find()->where(['status'=>'Active'])->asArray() ->all(); 
        $supervisor_name  = ArrayHelper::map($SuperviserMaster,'id','name');
        $supervisor_code  = ArrayHelper::map($SuperviserMaster,'id','employee_id');
        $supervisor_no    = ArrayHelper::map($SuperviserMaster,'id','mobile_no');

        $DriverProfile    = DriverProfile::find()->where(['status'=>'Active'])->asArray() ->all();
        $driver_name      = ArrayHelper::map($DriverProfile,'id','name');
        $driver_code      = ArrayHelper::map($DriverProfile,'id','employee_id');
        $mobile_no      = ArrayHelper::map($DriverProfile,'id','mobile_number');

        $ClientMaster     = ClientMaster::find()->where(['status'=>'Active'])->asArray() ->all(); 
        $company_name     = ArrayHelper::map($ClientMaster,'id','company_name');
        $client_name      = ArrayHelper::map($ClientMaster,'id','client_name');

        $VehicleMaster    = VehicleMaster::find()->where(['status'=>'Active'])->asArray() ->all();
        $vehicle_id       = ArrayHelper::map($VehicleMaster,'id','id');
        $vehicle_name     = ArrayHelper::map($VehicleMaster,'id','vehicle_name');
        $vehicle_number   = ArrayHelper::map($VehicleMaster,'id','reg_no');

        $BunkMaster       = BunkMaster::find()->where(['status'=>'Active'])->asArray() ->all();
        $agency_name      = ArrayHelper::map($BunkMaster,'id','bunk_agency_name');
        $manager_name     = ArrayHelper::map($BunkMaster,'id','manager_name');
        $bunk_company     = ArrayHelper::map($BunkMaster,'id','bunk_company');
        $bunk_mobile     = ArrayHelper::map($BunkMaster,'id','mobile_no');
          

        /************************* pagination   ************************/
        $page = 1;
        $start = 10;
        $limit = 10;
        if (isset($requestInput['page']) && $requestInput['page'] != "") {
          $page = $requestInput['page'];
          if (!is_numeric($page)) {
            $page = 1;
          }
          $start = $page * $limit;
        }

        /************************* pagination   ************************/

        if(isset($requestInput['search_key']) && $requestInput['search_key']!=""){
        $search_key = $requestInput['search_key'];
     
        $prod_ids=array();
        $product=VehicleMaster::find()->where(['LIKE','reg_no',$search_key.'%',false])->asArray()->all();
        if(!empty($product)){
        $prod_ids=ArrayHelper::map($prod_idd,'id','id');
        }  

        if ($coupon_status=="P") {
          $coupon_status="P";
        }else if($coupon_status=="C"){
          $coupon_status="C";
        }
         $model = Coupon::find()->where(['coupon_status'=>$coupon_status])
         ->andWhere(['bunk_name'=>$login_id])
         ->andWhere(['IN','vehicle_id',$prod_ids])
         ->asArray()->orderBy(['id'=>SORT_DESC])->all();
        
      }else{

        if ($coupon_status=="P") {
          $coupon_status="P";
        }else if($coupon_status=="C"){
          $coupon_status="C";
        }
         $model = Coupon::find()->where(['coupon_status'=>$coupon_status])
         ->andWhere(['bunk_name'=>$login_id])
         ->asArray()->orderBy(['id'=>SORT_DESC])->all();
      }


      
        if(!empty($model)){
        foreach ($model as $key => $c1) {
          $det['id'] = $c1['id'];
          $det['coupon_code'] = $c1['coupon_code'];
          $det['superviser_id'] = $c1['superviser_id'];
          $det['client_id'] = $c1['client_name'];
          $det['bunk_id'] = $c1['bunk_name'];
          $det['vehicle_id'] = $c1['vehicle_name'];
          $det['coupon_amount'] = $c1['coupon_amount'];

          $det['coupon_gen_date'] = date('d-m-Y', strtotime($c1['coupon_gen_date']))." ".date('h:i A', strtotime($c1['coupon_gen_date']));
          $det['created_at'] = date('d-m-Y H:i:s', strtotime($c1['created_at']));

           $det['vehicle_name']='';
          if(isset($vehicle_name[$c1['vehicle_name']])){
            $det['vehicle_name']=$vehicle_name[$c1['vehicle_name']];
          }
          $det['vehicle_number']='';
          if(isset($vehicle_number[$c1['vehicle_name']])){
            $det['vehicle_number']=$vehicle_number[$c1['vehicle_name']];
          }

          $det['driver_name']='';
          $det['driver_code']='';
          $det['driver_mobile_no']='';
 
          if(isset($vehicle_id[$c1['vehicle_name']])){
            if(isset($driver_name[$vehicle_id[$c1['vehicle_name']]])){
               $det['driver_name']=ucwords($driver_name[$vehicle_id[$c1['vehicle_name']]]);
            }
           if(isset($driver_code[$vehicle_id[$c1['vehicle_name']]])){
               $det['driver_code']=$driver_code[$vehicle_id[$c1['vehicle_name']]];
            }
            if(isset($mobile_no[$vehicle_id[$c1['vehicle_name']]])){
               $det['driver_mobile_no']=$mobile_no[$vehicle_id[$c1['vehicle_name']]];
            }
          } 
         
 
          $det['contact_person_name']='';
          if(isset($client_name[$c1['client_name']])){
            $det['contact_person_name']=ucwords($client_name[$c1['client_name']]);
          }

           $det['client_company_name']='';
          if(isset($company_name[$c1['client_name']])){
            $det['client_company_name']=$company_name[$c1['client_name']];
          }
  
          $det['superviser_name'] ='';
          if(isset($supervisor_name[$c1['superviser_id']])){
            $det['superviser_name']=ucwords($supervisor_name[$c1['superviser_id']]);
          }
          $det['supervisor_code'] ='';
          if(isset($supervisor_code[$c1['superviser_id']])){
            $det['supervisor_code']=$supervisor_code[$c1['superviser_id']];
          }

            $det['supervisor_contact'] ='';
          if(isset($supervisor_no [$c1['superviser_id']])){
            $det['supervisor_contact']=$supervisor_no[$c1['superviser_id']];
          }

           $det['bunk_agency_name'] ='';
          if(isset($agency_name[$c1['bunk_name']])){
            $det['bunk_agency_name']=ucwords($agency_name[$c1['bunk_name']]);
          }

           $det['bunk_company_name'] ='';
          if(isset($bunk_company[$c1['bunk_name']])){
            $det['bunk_company_name']=$bunk_company[$c1['bunk_name']];
          }

           $det['manager_name'] ='';
          if(isset($manager_name[$c1['bunk_name']])){
            $det['manager_name']=ucwords($manager_name[$c1['bunk_name']]);
          }

          $det['bunk_contact'] ='';
          if(isset($bunk_mobile[$c1['bunk_name']])){
            $det['bunk_contact']=$bunk_mobile[$c1['bunk_name']];
          }

          $det['coupon_status'] = $c1['coupon_status'];

          $det['refuel_date'] = '';
          if($c1['refuel_date']!=""){
          $det['refuel_date'] = date('d-m-Y', strtotime($c1['refuel_date']))." ".date('h:i A', strtotime($c1['refuel_date']));
          }
          $det['coupon_close_date'] = '';
          if($c1['coupon_close_date']!=""){
          $det['coupon_close_date'] = date('d-m-Y', strtotime($c1['coupon_close_date']))." ".date('h:i A', strtotime($c1['coupon_close_date']));
          }

          $det['refuel_receipt'] = '';
          if($c1['refuel_receipt']!=""){
          $det['refuel_receipt'] = Url::home(true).$c1['refuel_receipt'];
          }


          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['coupon_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Coupon List not Available';
        $list['coupon_list']=array();
      }
    }else{
        $list['status']='error';
        $list['message']='Invalid User';
        $list['coupon_list']=array();
    }
  }
}else{
		$list['status']='error';
        $list['message']='Invalid Authorization Request!';
        $list['coupon_list']=array();
}
    	

    	$response['Output'][] = $list;
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
    
  $log_id='';
  if($log_model->save()){
    $log_id=$log_model->autoid;
  }
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($user_data_role=$this->authorization()){ 
 
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
  }else{  
        $list['status']='error';
        $list['message']='Invalid Authorization Request!';
        
}
   //$response= $list;
    
   
$response['Output'][] = $list;
      $log_model=AllenApiLog::findOne($log_id);
      if($log_model){
      $log_model->response=json_encode($response);
      $log_model->save();
      }
    return json_encode($response);
 
}
}
