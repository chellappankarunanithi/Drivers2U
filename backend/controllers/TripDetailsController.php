<?php

namespace backend\controllers;

use Yii;
use backend\models\TripDetails;
use backend\models\TripDetailsSearch;
use backend\models\ClientMaster;
use backend\models\DriverProfile;
use backend\models\AllenOtpLog;
use backend\models\CommissionMaster;
use backend\models\CancelTripLog;
use backend\models\TripLog;
use backend\models\SmsLog;
use backend\models\GeneralConfiguration;
use backend\models\VehicleMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TripDetailsController implements the CRUD actions for TripDetails model.
 */
class TripDetailsController extends Controller
{
    /**
     * {@inheritdoc}
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

    /**
     * Lists all TripDetails models.
     * @return mixed
     */
    public function actionTripIndex()
    {
        $searchModel = new TripDetailsSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TripDetails model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

 
    
    /**
     * Creates a new TripDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TripDetails();

        if ($model->load(Yii::$app->request->post())) {  
            if (array_key_exists('StartDateTime', $_POST['TripDetails'])) {
                    if ($_POST['TripDetails']['StartDateTime']!="") {
                        $model->StartDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['StartDateTime']));
                    }
                }
                if (array_key_exists('EndDateTime', $_POST['TripDetails'])) {
                    if ($_POST['TripDetails']['EndDateTime']!="") {
                        $model->EndDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['EndDateTime']));
                    }
                }
            $model->TripLocationType = $_POST['TripDetails']['TripLocationType'];
            $model->UpdatedIpaddress = $_SERVER['REMOTE_ADDR'];
            $model->TripStatus = 'Booked';
            $confiq = GeneralConfiguration::findOne(['config_key'=>'tripid']);
               $cust_id='1';
            if ($confiq) {
                $cust_id = $confiq->config_value;
            }
            $model->tripcode = "TRIP-D2U-0".$cust_id;

            if($model->save()){

                    if (array_key_exists('DriverId', $_POST['TripDetails'])) {
                        if ($_POST['TripDetails']['DriverId']!="") {
                          $drivermodel = DriverProfile::find()->where(['id'=>$_POST['TripDetails']['DriverId']])->one();
                          if ($drivermodel) {
                            $drivermodel->available_status= "1";
                            $drivermodel->save();
                          }
                        }
                      }

                    ## Vehicle Details save
                    $vehiclemaster = VehicleMaster::find()->where(['client_id'=>$model->CustomerId])
                    ->andWhere(['reg_no'=>$model->VehicleNo])->one();
                    if (empty($vehiclemaster)) {
                        $vehiclemaster = new VehicleMaster();
                    }
                    $vehiclemaster->vehicle_name = $model->VehicleType;
                    $vehiclemaster->vehicle_uniqe_name = $model->VehicleMade;
                    $vehiclemaster->reg_no = $model->VehicleNo;
                    $vehiclemaster->client_id = $model->CustomerId;
                    $vehiclemaster->save();

                $confiq->config_value = $cust_id+1;
                $confiq->save(); 
                $requestInput = array();
                $requestInput['tripId'] = $model->id;
                $requestInput['tripStatus'] = $model->TripStatus;
                $requestInput['apiMethod'] = 'Create'; 
                $callFun = new TripLog();
                $response = $callFun->tripLog($requestInput);

                return $this->redirect(['trip-index']);
            }else{ echo "<pre>"; print_r($model->getErrors()); die;
                return $this->render('create', [
                    'model' => $model,
                ]); 
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TripDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) { //echo "<pre>"; print_r($_POST); die;
             if (array_key_exists('StartDateTime', $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['StartDateTime']!="") {
                    $model->StartDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['StartDateTime']));
                }
            }
            if (array_key_exists('EndDateTime', $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['EndDateTime']!="") {
                    $model->EndDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['EndDateTime']));
                }
            }
            $model->TripStatus = 'Booked';
            $model->TripLocationType = $_POST['TripDetails']['TripLocationType'];
            $model->UpdatedIpaddress = $_SERVER['REMOTE_ADDR'];

            
            if ($model->save()) {
                    if (array_key_exists('DriverId', $_POST['TripDetails'])) {
                        if ($_POST['TripDetails']['DriverId']!="") {
                          $drivermodel = DriverProfile::find()->where(['id'=>$_POST['TripDetails']['DriverId']])->one();
                          if ($drivermodel) {
                            $drivermodel->available_status= "1";
                            $drivermodel->save();
                          }
                        }
                      }

                     $vehiclemaster = VehicleMaster::find()->where(['client_id'=>$model->CustomerId])
                    ->andWhere(['reg_no'=>$model->VehicleNo])->one();
                    if (empty($vehiclemaster)) {
                        $vehiclemaster = new VehicleMaster();
                    }
                    $vehiclemaster->vehicle_name = $model->VehicleType;
                    $vehiclemaster->vehicle_uniqe_name = $model->VehicleMade;
                    $vehiclemaster->reg_no = $model->VehicleNo;
                    $vehiclemaster->client_id = $model->CustomerId;
                    $vehiclemaster->save();

                    $requestInput = array();
                    $requestInput['tripId'] = $model->id;
                    $requestInput['tripStatus'] = $model->TripStatus;
                    $requestInput['apiMethod'] = 'Update'; 
                    $callFun = new TripLog();
                    $response = $callFun->tripLog($requestInput);
                return $this->redirect(['trip-index']); 
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
         return $this->render('update', [
            'model' => $model,
        ]);
    } 


    ## change trip
    public function actionChangeTrip($id)
    {
        $model = $this->findModel($id);
        $model->scenario = "change-trip";
        if ($model->load(Yii::$app->request->post())) { //echo "<pre>"; print_r($_POST); die;
             if (array_key_exists('StartDateTime', $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['StartDateTime']!="") {
                    $model->StartDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['StartDateTime']));
                }
            }
            if (array_key_exists('EndDateTime', $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['EndDateTime']!="") {
                    $model->EndDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['EndDateTime']));
                }
            }
            $model->TripLocationType = $_POST['TripDetails']['TripLocationType'];
            $model->TripStatus = 'Activated';
            $model->ChangeTrip = 'Yes'; 
            $model->ChangeDate = date('Y-m-d H:i:s');
            $model->TripStatus = 'Activated';

            $model->UpdatedIpaddress = $_SERVER['REMOTE_ADDR'];

            
            if ($model->save()) {
                    if (array_key_exists('DriverId', $_POST['TripDetails'])) {
                        if ($_POST['TripDetails']['DriverId']!="") {
                          $drivermodel = DriverProfile::find()->where(['id'=>$_POST['TripDetails']['DriverId']])->one();
                          if ($drivermodel) {
                            $drivermodel->available_status= "1";
                            $drivermodel->save();
                          }
                        }
                      }

                     $vehiclemaster = VehicleMaster::find()->where(['client_id'=>$model->CustomerId])
                    ->andWhere(['reg_no'=>$model->VehicleNo])->one();
                    if (empty($vehiclemaster)) {
                        $vehiclemaster = new VehicleMaster();
                    }
                    $vehiclemaster->vehicle_name = $model->VehicleType;
                    $vehiclemaster->vehicle_uniqe_name = $model->VehicleMade;
                    $vehiclemaster->reg_no = $model->VehicleNo;
                    $vehiclemaster->client_id = $model->CustomerId;
                    $vehiclemaster->save();

                    $requestInput = array();
                    $requestInput['tripId'] = $model->id;
                    $requestInput['tripStatus'] = $model->TripStatus;
                    $requestInput['apiMethod'] = 'ChangeTrip';

                    $callFun = new TripLog();
                    $response = $callFun->tripLog($requestInput);


                    ##Trip Change SMS  
                        $customercontact="";
                        $drivercontact="";
                        $customer = ClientMaster::findOne($model->CustomerId);
                        if (!empty($customer)) {
                          $customercontact = $customer->mobile_no;
                        }
                        if (!empty($drivermodel)) {
                          $drivercontact = $drivermodel->mobile_number;
                        } 
                        $requestInput = array();
                        $requestInput['tripId'] = $model->id;
                        $requestInput['customerId'] = $model->CustomerId;
                        $requestInput['driverId'] = $model->DriverId;
                        $requestInput['event'] = "Change Trip";
                        $callFun = new SmsLog();
                        $smscontent="";
                        if($customercontact!=""){
                        //  $response = $callFun->smsfunction($customercontact,$smscontent,$requestInput);
                        }
                        if($drivercontact!=""){
                        //  $response = $callFun->smsfunction($drivercontact,$smscontent,$requestInput);
                        }


                return $this->redirect(['trip-index']); 
            }else{
                return $this->render('_changetrip', [
                    'model' => $model,
                ]);
            }
        }
         return $this->render('_changetrip', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TripDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


     public function actionGetCustomer()
    {
        if ($_POST) {
            $model = ClientMaster::find()->where(['id'=>$_POST['CustomerId']])->asArray()->one();
            if (!empty($model)) {
                return json_encode($model);
            }
        }
    }
      public function actionGetDriver()
    {
        if ($_POST) {
            $model = DriverProfile::find()->where(['id'=>$_POST['driverid']])->andWhere(['available_status'=>"0"])->asArray()->one();
            if (!empty($model)) {
                return json_encode($model);
            }
        }
    }
      public function actionGetVehicle()
    {
        if ($_POST) {
            $model = VehicleMaster::find()->where(['id'=>$_POST['vehicleid']])->asArray()->one();
            if (!empty($model)) {
                return json_encode($model);
            }
        }
    }
    /**
     * Finds the TripDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TripDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TripDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


      public function actionCreateIndex()
    {
        $searchModel = new TripDetailsSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post,"Booked");

        return $this->render('createindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionActiveIndex()
    {
        $searchModel = new TripDetailsSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post,"Activated");

        return $this->render('activeindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCancelIndex()
    {
        $searchModel = new TripDetailsSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post,"Cancelled");

        return $this->render('cancelindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCompleteIndex()
    {
        $searchModel = new TripDetailsSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post,"Completed");

        return $this->render('completeindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionOtpsave($id="")
    { 
        if (Yii::$app->request->post()) { //echo "<pre>"; print_r($_POST); die;
              $model = new AllenOtpLog();
              $model->mobile_number = $_POST['ClientMaster']['mobile_no'];
              $model->OtpFor = "Customer Registration";
              $model->CustomerId = $id;
              $model->otp_number = rand(9999,999);
              $model->status = "S";
              if($model->save()){  
                ## OTP SMS 
                              $customercontact="6380744151";
                              $customer = ClientMaster::findOne($id);
                              if (!empty($customer)) {
                              //  $customercontact = $customer->mobile_no;
                              } 
                              $requestInput = array(); 
                              $requestInput['customerId'] = $id;
                              $requestInput['event'] = "Register OTP";
                              $callFun = new SmsLog();
                              $smscontent="this is test sms";
                              if($customercontact!=""){ 
                                $response = $callFun->smsfunction($customercontact,$smscontent,$requestInput);
                                 
                              }
                return $model->otp_number;
              }else{
                return "0";
              }
        }else{ 
         
        }
    }

     public function actionOtpverification($id="")
    { 
        if (Yii::$app->request->post()) { // echo "<pre>"; print_r($_POST); die;
              $model = AllenOtpLog::find()->where(['otp_number'=>$_POST['otp_number']])->andWhere(['mobile_number'=>$_POST['ClientMaster']['mobile_no']])->andWhere(['status'=>'S'])->one();
              if (!empty($model)) {
                   $model->status = "A";
                if($model->save()){ 
                  $clientmodel = ClientMaster::find()->where(['id'=>$_POST['id']])->andWhere(['status'=>"Register"])->one();
                  if (!empty($clientmodel)) {
                    if ($_POST['otpfor']=="Activate") {
                      $clientmodel->status = "Active"; 
                    }
                    $clientmodel->save();

                 

                  }
                    return 1;
                }else{
                  echo "<pre>"; print_r($model->getErrors());
                }
              }else{
                return "invalid";
              }
        }else{ 
         
        }
    }

    public function actionActivate($id="")
    {
        $model = $this->findModel($id);
        $model->scenario="activate";
        if ($_POST) { 
                    
                      $model->TripStatus = "Activated"; 
                          if (array_key_exists('DriverId', $_POST['TripDetails'])) {
                            if ($_POST['TripDetails']['DriverId']!="") {
                                $model->DriverId = $_POST['TripDetails']['DriverId'];
                                $drivermodel = DriverProfile::find()->where(['id'=>$_POST['TripDetails']['DriverId']])->one();
                              if ($drivermodel) {
                                $drivermodel->available_status= "1";
                                $drivermodel->save();
                              }
                            }
                          } 
                  
                     
                    $model->save();

                    $requestInput = array();
                    $requestInput['tripId'] = $model->id;
                    $requestInput['tripStatus'] = $model->TripStatus;
                    $requestInput['apiMethod'] = 'Activate'; 
                    $callFun = new TripLog();
                    $response = $callFun->tripLog($requestInput); 
                    Yii::$app->getSession()->setFlash('success', 'Trip Activated Successfully.');
                    return $this->redirect(['trip-index']);
        }
            if ($model->TripStatus=="Activated") { // echo "as"; die;
                 return $this->render('response', [
                    'model' => $model,
                    'status' => $model->TripStatus,
                ]);   
            }else{
                return $this->render('_actionform', [
                    'model' => $model,
                ]);      
            }
    }

    public function actionComplete($id="")
    {
        $model = $this->findModel($id);
        $model->scenario="complete";
        if ($_POST) {  //echo "<pre>"; print_r($_POST); die;

                if (array_key_exists('TripCost', $_POST['TripDetails'])) {
                  if ($_POST['TripDetails']['TripCost']!="") {
                        $tripcost = $_POST['TripDetails']['TripCost'];
                  }
                }
                $commissionid="";
              if (array_key_exists('CommissionType', $_POST['TripDetails'])) {
                  if ($_POST['TripDetails']['CommissionType']=="Percentage") {  
                    if (array_key_exists("CommissionId", $_POST['TripDetails'])) {
                        if ($_POST['TripDetails']['CommissionId']!="") {
                          $commissionid = $_POST['TripDetails']['CommissionId'];
                          $commission = CommissionMaster::findOne($_POST['TripDetails']['CommissionId']);
                          if (!empty($commission)) {
                                $commissionpercentage = $commission->CommissionValue;
                                $admincommission = (($tripcost*$commissionpercentage)/100);
                                $drivercommisson = $tripcost-$admincommission;
                          }
                        }
                    }
                  }elseif ($_POST['TripDetails']['CommissionType']=="Flat") {  
                        if (array_key_exists("CommissionValue", $_POST['TripDetails'])) {
                          if ($_POST['TripDetails']['CommissionValue']!="") { 
                                $admincommission = $_POST['TripDetails']['CommissionValue'];
                                $drivercommisson = $tripcost-$admincommission;
                          }
                        }
                  }
                  $commissiontype = $_POST['TripDetails']['CommissionType'];
              } 
              if (array_key_exists("TripHours", $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['TripHours']!="") { 
                      $TripHours = $_POST['TripDetails']['TripHours'];
                }
              }

              
              $PreviousPending=0;
              $TotalAmountPaid=0;
              $CancelLogId="";
              if (array_key_exists("PreviousPending", $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['PreviousPending']!="") { 
                      $PreviousPending = $_POST['TripDetails']['PreviousPending'];
                }
              }
              if (array_key_exists("TotalAmountPaid", $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['TotalAmountPaid']!="") { 
                      $TotalAmountPaid = $_POST['TripDetails']['TotalAmountPaid'];
                }
              }
              if (array_key_exists("CancelLogId", $_POST['TripDetails'])) {
                if ($_POST['TripDetails']['CancelLogId']!="") { 
                      $CancelLogId = $_POST['TripDetails']['CancelLogId'];
                }
              }
                $model->CancelLogId = $CancelLogId;
              if ($CancelLogId!="") {
                $model->CancelFeeStatus = 'Yes';
              }

                if (array_key_exists('EndDateTime', $_POST['TripDetails'])) {
                    if ($_POST['TripDetails']['EndDateTime']!="") {
                        $model->EndDateTime = date('Y-m-d H:i:s', strtotime($_POST['TripDetails']['EndDateTime']));
                    }
                }

                $model->PreviousPending = $PreviousPending;
                $model->TotalAmountPaid = $TotalAmountPaid;
                $model->TripCost = $tripcost;
                $model->TripHours =  $TripHours;
                $model->CommissionType =  $commissiontype;
                $model->AdminCommission = $admincommission;
                $model->CommissionValue = $admincommission;
                $model->CommissionId = $commissionid;
                $model->DriverCommission = $drivercommisson;
                $model->TripStatus = "Completed";
                $model->TripCompleteDate = date('Y-m-d H:i:s');
                if($model->save()){
                  ## Cancel Payment Pending Log Close
                  $cancellog = CancelTripLog::find()->where(['id'=>$model->CancelLogId])->one();
                  if (!empty($cancellog)) {
                    $cancellog->PaymentStatus = "Yes";
                    $cancellog->save();
                  }

                  $drivermodel = DriverProfile::find()->where(['id'=>$model->DriverId])->one();
                  if (!empty($drivermodel)) {
                    $drivermodel->available_status = 1;
                    $drivermodel->save();
                  }

                  $requestInput = array();
                    $requestInput['tripId'] = $model->id;
                    $requestInput['tripStatus'] = $model->TripStatus;
                    $requestInput['apiMethod'] = 'Complete'; 
                    $callFun = new TripLog();
                    $response = $callFun->tripLog($requestInput);

##Trip Complete SMS  
                        $customercontact="";
                        $drivercontact="";
                        $customer = ClientMaster::findOne($model->CustomerId);
                        if (!empty($customer)) {
                          $customercontact = $customer->mobile_no;
                        }
                        if (!empty($drivermodel)) {
                          $drivercontact = $drivermodel->mobile_number;
                        } 
                        $requestInput = array();
                        $requestInput['tripId'] = $model->id;
                        $requestInput['customerId'] = $model->CustomerId;
                        $requestInput['driverId'] = $model->DriverId;
                        $requestInput['event'] = "Complete Trip";
                        $callFun = new SmsLog();
                        $smscontent="";
                        if($customercontact!=""){
                         // $response = $callFun->smsfunction($customercontact,$smscontent,$requestInput);
                        }
                        if($drivercontact!=""){
                         // $response = $callFun->smsfunction($drivercontact,$smscontent,$requestInput);
                        }

                  return $this->redirect(['complete/'.$id]);
                }else{
                  return $this->render('_completeform', [
                    'model' => $model,
                  ]);  
                }
          
        }else if ($model->TripStatus=="Completed") { // echo "as"; die;
                 return $this->render('response', [
                    'model' => $model,
                    'status' => $model->TripStatus,
                ]);   
            }else{
                return $this->render('_completeform', [
                    'model' => $model,
                ]);      
            }
    }
    public function actionCancel($id="")
    {
        $model = $this->findModel($id);
         $model->scenario="cancel";
         if ($_POST) {   //echo "<pre>"; print_r($_POST); die;
              $model->CancelFee = $_POST['TripDetails']['CancelFee'];
              $model->CancelReason = $_POST['TripDetails']['CancelReason'];
              $model->CancelFeeStatus = $_POST['TripDetails']['CancelFeeStatus'];
              $model->TripCancelDate = date('Y-m-d H:i:s');
              $model->TripStatus = "Cancelled";
              if ($model->save()) {
                    $requestInput = array();
                    $requestInput['tripId'] = $model->id;
                    $requestInput['tripStatus'] = $model->TripStatus;
                    $requestInput['apiMethod'] = 'Cancel'; 
                    $callFun = new TripLog();
                    $response = $callFun->tripLog($requestInput);



                    ##Trip Cancel SMS  
                        $customercontact="";
                        $drivercontact="";
                        $drivermodel = DriverProfile::findOne($model->DriverId);
                        if (!empty($drivermodel)) {
                          $drivercontact = $drivermodel->mobile_number;
                        }
                        $customer = ClientMaster::findOne($model->CustomerId);
                        if (!empty($customer)) {
                          $customercontact = $customer->mobile_no;
                        }
                        if (!empty($drivermodel)) {
                          $drivercontact = $drivermodel->mobile_number;
                        } 
                        $requestInput = array();
                        $requestInput['tripId'] = $model->id;
                        $requestInput['customerId'] = $model->CustomerId;
                        $requestInput['driverId'] = $model->DriverId;
                        $requestInput['event'] = "Cancel Trip";
                        $callFun = new SmsLog();
                        $smscontent="";
                        if($customercontact!=""){
                        //  $response = $callFun->smsfunction($customercontact,$smscontent,$requestInput);
                        }
                        if($drivercontact!=""){
                        //  $response = $callFun->smsfunction($drivercontact,$smscontent,$requestInput);
                        }



                  $cancellog =  CancelTripLog::find()->where(['TripId'=>$model->id])->andWhere(['PaymentStatus'=>'No'])->one();
                if (empty($cancellog)) {
                  $cancellog = new CancelTripLog();
                }
                $cancellog->DriverId = $model->DriverId;
                $cancellog->CustomerId = $model->CustomerId;
                $cancellog->TripId = $model->id;
                $cancellog->CancelFees = $_POST['TripDetails']['CancelFee'];
                $cancellog->CancelReason = $_POST['TripDetails']['CancelReason'];
                $cancellog->PaymentStatus = $_POST['TripDetails']['CancelFeeStatus'];
                $cancellog->UpdatedIpaddress = $_SERVER['REMOTE_ADDR'];
                if($cancellog->save()){
                    return $this->redirect(['cancel/'.$id]);
                }else{ echo "<pre>"; print_r($model->getErrors()); die;
                    return $this->render('_cancelform', [
                        'model' => $model,
                    ]);      
                }
              }else{ echo "<pre>"; print_r($model->getErrors()); die;
                return $this->render('_cancelform', [
                    'model' => $model,
                ]);      
            }


         }
            if ($model->TripStatus=="Cancelled") { // echo "as"; die; _cancelform
                 return $this->render('response', [
                    'model' => $model,
                    'status' => $model->TripStatus,
                ]);   
            }else{
                return $this->render('_cancelform', [
                    'model' => $model,
                ]);      
            }
    }

     public function actionCancelPayment($id="")
    {
        $model = CancelTripLog::find()->where(['TripId'=>$id])->andWhere(['PaymentStatus'=>"No"])->one();
        $model1 = $this->findModel($id); 
         if ($_POST) {    
              $model->CancelFees = $_POST['CancelTripLog']['CancelFees'];
              $model->PaymentStatus = $_POST['CancelTripLog']['PaymentStatus'];
               $model->UpdatedIpaddress = $_SERVER['REMOTE_ADDR'];
              if ($model->save()) {
                  
                  $model1->CancelFeeStatus = $_POST['CancelTripLog']['PaymentStatus'];  
                  $model1->PreviousPending = $_POST['CancelTripLog']['CancelFees']; 
                  $model1->save();
                    $requestInput = array();
                    $requestInput['tripId'] = $model1->id;
                    $requestInput['tripStatus'] = $model1->TripStatus;
                    $requestInput['apiMethod'] = 'cancelpaymentupdate'; 
                    $callFun = new TripLog();
                    $response = $callFun->tripLog($requestInput);
                  return $this->redirect(['cancel-index']);  
                 
              }else{ echo "<pre>"; print_r($model->getErrors()); die;
                return $this->render('cancel-index', [
                    'model' => $model,
                ]);      
            }


         }
            if ($model->PaymentStatus=="Yes") { 
                 return "Cancelled Fees is Already Paid.";  
            }else{
                return $this->renderAjax('_cancelpayview', [
                    'model' => $model,
                ]);      
            }
    }


    public function actionTripRating($id)
    { 
      $model = $this->findModel($id);
      if ($_POST) {
        $model->rating = $_POST['rating-stars-value'];
        $model->Review = $_POST['TripDetails']['Review'];
        $model->save();
        return $this->redirect(['trip-index']); 
      }else{
          /*if ($model->rating!="") {
            Yii::$app->getSession()->setFlash('success', 'Rating Completed Successfully.');
              return $this->redirect(['trip-index']); 
          }else{*/
            return $this->renderAjax('trip-rating', [
                'model' => $this->findModel($id),
            ]);

         // }
      }
    }

}
