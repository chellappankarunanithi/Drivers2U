<?php

namespace backend\controllers;

use Yii;
use backend\models\OthersVehicleDetails;
use backend\models\DriverProfile;
use backend\models\ClientMaster;
use backend\models\BunkMaster;
use backend\models\ClientVehicleMap;
use backend\models\VehicledriverAssignlog;
use backend\models\OthersVehicleDetailsSearch;
use backend\models\Coupon;
use backend\models\SuperviserMaster;
use backend\models\SuperviserClientMap;
use yii\web\Controller;
use yii\web\NotFoundHttpException; 
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\helpers\Url;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * OthersVehicleDetailsController implements the CRUD actions for OthersVehicleDetails model.
 */
class OthersVehicleDetailsController extends Controller
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
          'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],

                // ...
            ],
        ],


        ];
    }

    /**
     * Lists all OthersVehicleDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OthersVehicleDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OthersVehicleDetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionClientdetails($id)
    { 
        $ClientMaster=array();
        $clientmap = ClientVehicleMap::find()->where(['vehicle_id'=>$id])->andWhere(['vehicle_status'=>'A'])->asArray()->all();
        if(!empty($clientmap)){
          $ids= ArrayHelper::map($clientmap,'client_id','client_id'); 
        $ClientMaster = ClientMaster::find()->where(['IN','id',$ids])->asArray()->all();
        }
        return $this->renderAjax('clientdetails', [
            'model' => $this->findModel($id),
            'ClientMaster'=>$ClientMaster,
        ]);
    }

     public function actionSuperviserdetails($id)
    { 
        $ClientMaster=array();
       // $model = $this->findModel($id);
        $clientmap = SuperviserClientMap::find()->where(['client_name'=>$id])->asArray()->all();
        if(!empty($clientmap)){
          $ids= ArrayHelper::map($clientmap,'superviser_name','superviser_name'); 
        $ClientMaster = SuperviserMaster::find()->where(['IN','id',$ids])->asArray()->all();
        }
       // echo "hai"; die;
        return $this->renderAjax('superviserdetails', [
            'model' => $clientmap,
            'ClientMaster'=>$ClientMaster,
        ]);
    }
    /**
     * Creates a new VehicleMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OthersVehicleDetails();
        $session = Yii::$app->session;

        if ($model->load(Yii::$app->request->post())) {  // echo "<pre>"; print_r($_POST); die;
           if(Yii::$app->request->isAjax){   
                  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
             } 

            $model->created_at = date('Y-m-d H:i:s');
            $model->vehicle_name = strtoupper($_POST['OthersVehicleDetails']['vehicle_name']);
            $model->reg_no = strtoupper(trim($_POST['OthersVehicleDetails']['reg_no']));
            //$model->driver_id = $_POST['OthersVehicleDetails']['driver_id'];
            //  $cl = implode(',', $_POST['VehicleMaster']['client_id']);
            $cl='';
             if($_POST['OthersVehicleDetails']['client_id']!=""){
             $cl = implode(',', $_POST['OthersVehicleDetails']['client_id']);
             }
            $model->client_id = $cl;
            //$model->client_id = $_POST['VehicleMaster']['client_id'];
            $model->user_id = $session['user_id'];
            if($_POST['OthersVehicleDetails']['status']==0){
                $model->status = "Inactive";
            }else{
                $model->status = "Active";
            } 

            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
          $model->fc_expire_date = date('Y-m-d',strtotime($_POST['OthersVehicleDetails']['fc_expire_date']));
          $model->ins_expired_date = date('Y-m-d',strtotime($_POST['OthersVehicleDetails']['ins_expired_date']));
             if($_FILES['OthersVehicleDetails']['error']['insurance_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'insurance_copy');
                  $image_name = 'uploads/insurance_copy/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->insurance_copy = $image_name;
            }
            if($_FILES['OthersVehicleDetails']['error']['rc_book']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'rc_book');
                  $image_name = 'uploads/rc_book/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->rc_book = $image_name;
            }


             if($_FILES['OthersVehicleDetails']['error']['tax_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'tax_copy');
                  $image_name = 'uploads/tax_copy/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->tax_copy = $image_name;
            }
            
            if($model->save()){
              if(!empty($_POST['OthersVehicleDetails']['client_id'])){  //echo "<pre>"; print_r($_POST); die;
        $mapcl=ClientVehicleMap::find()->where(['vehicle_id'=>$model->id])->asArray()->all();
            $mapclAr=ArrayHelper::map($mapcl,'client_id','client_id');

            $postAr= $_POST['OthersVehicleDetails']['client_id'];     
               
        foreach ($_POST['OthersVehicleDetails']['client_id'] as $key => $value) {

          if(!array_key_exists($value, $mapclAr)){
            $ClientVehiclenew = new ClientVehicleMap(); 
            $ClientVehiclenew->assign_date = date("Y-m-d H:i:s"); 
            $ClientVehiclenew->client_id = $value;
            $ClientVehiclenew->vehicle_id = $model->id;
            $ClientVehiclenew->vehicle_status = "A";  
            $ClientVehiclenew->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
            $ClientVehiclenew->created_at = date("Y-m-d H:i:s");  
            if($ClientVehiclenew->save()){ //echo "asd"; die;
            }else{
              echo "<pre>"; print_r($ClientVehiclenew->getErrors()); die;
            }
          }else{

          }
        } //echo "<pre>"; print_r($postAr); 
        foreach ($mapclAr as $key => $value) {
         $ty=array_search($value, $cl);
           //echo "<pre>"; print_r($ty); die;
          if(!array_search($value, $_POST['OthersVehicleDetails']['client_id'])){ //echo "<pre>"; print_r($ty); 
            $ClientVehicle_1 = ClientVehicleMap::find()->where(['vehicle_id'=>$model->id])
            ->andWhere(['client_id'=>$value])->andWhere(['vehicle_status'=>'A'])
            ->one(); 
            if(!empty($ClientVehicle_1)){
            $ClientVehicle_1->remove_date = date("Y-m-d H:i:s");
            $ClientVehicle_1->client_id = $value;
            $ClientVehicle_1->vehicle_status = "I"; 
            $ClientVehicle_1->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
                if($ClientVehicle_1->save()){

                }else{
                  echo "<pre>"; print_r($ClientVehicle_1->getErrors());
                }
          }
        }
        }// die;
            
            }
           


              /*************vehile cliet ***************/
               $driverprofile = DriverProfile::find()->where(['id'=>$model->driver_id])->andWhere(['available_status'=>"0"])->one();
              $autoid = $model->getPrimaryKey();
              $models= OthersVehicleDetails::find()->where(['id'=>$autoid])->asArray()->one();
              if(!empty($driverprofile)){
                $driverprofile->available_status="1";
                $driverprofile->client_id=$models['client_id'];
                $driverprofile->vehicle_id=$models['id'];
                if($driverprofile->save()){
                  Yii::$app->session->setFlash('success', "Data Saved with a Driver.");
                }else{
                  Yii::$app->session->setFlash('danger', "Data Saved without Select Driver.");
                }
              } 
          //  return $this->redirect(['index']);

            return $this->redirect(['index']);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VehicleMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {
           if(Yii::$app->request->isAjax){ 
                  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
             } //echo "<pre>"; print_r($_POST); die;
             $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
             $model->vehicle_name = strtoupper($_POST['OthersVehicleDetails']['vehicle_name']);
             $model->reg_no = strtoupper(trim($_POST['OthersVehicleDetails']['reg_no']));
             $model->fc_expire_date = date('Y-m-d',strtotime($_POST['OthersVehicleDetails']['fc_expire_date']));
             $model->ins_expired_date = date('Y-m-d',strtotime($_POST['OthersVehicleDetails']['ins_expired_date']));
             $model->user_id = $session['user_id'];
             $model->driver_id = $_POST['OthersVehicleDetails']['driver_id'];
             $cl='';
             if($_POST['OthersVehicleDetails']['client_id']!=""){
             $cl = implode(',', $_POST['OthersVehicleDetails']['client_id']);
             }
             $model->client_id = $cl;
              if($_POST['OthersVehicleDetails']['status']==0){
                $model->status = "Inactive";
            }else{
                $model->status = "Active";
            } 
                if($_FILES['OthersVehicleDetails']['error']['insurance_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'insurance_copy');
                  $image_name = 'uploads/insurance_copy/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->insurance_copy = $image_name;
            }
            if($_FILES['OthersVehicleDetails']['error']['rc_book']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'rc_book');
                  $image_name = 'uploads/rc_book/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->rc_book = $image_name;
            }


             if($_FILES['OthersVehicleDetails']['error']['tax_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'tax_copy');
                  $image_name = 'uploads/tax_copy/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->tax_copy = $image_name;
            }

                if($model->save()){
      if(!empty($_POST['OthersVehicleDetails']['client_id'])){  //echo "<pre>"; print_r($_POST); die;
        $mapcl=ClientVehicleMap::find()->where(['vehicle_id'=>$model->id])->asArray()->all();
            $mapclAr=ArrayHelper::map($mapcl,'client_id','client_id');

            $postAr= $_POST['OthersVehicleDetails']['client_id'];     
               
        foreach ($_POST['OthersVehicleDetails']['client_id'] as $key => $value) {

          if(!array_key_exists($value, $mapclAr)){
            $ClientVehiclenew = new ClientVehicleMap(); 
            $ClientVehiclenew->assign_date = date("Y-m-d H:i:s"); 
            $ClientVehiclenew->client_id = $value;
            $ClientVehiclenew->vehicle_id = $model->id;
            $ClientVehiclenew->vehicle_status = "A";  
            $ClientVehiclenew->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
            $ClientVehiclenew->created_at = date("Y-m-d H:i:s");  
            if($ClientVehiclenew->save()){ //echo "asd"; die;
            }else{
              echo "<pre>"; print_r($ClientVehiclenew->getErrors()); die;
            }
          }else{

          }
        } //echo "<pre>"; print_r($postAr); 
        foreach ($mapclAr as $key => $value) {
         $ty=array_search($value, $postAr);
           //echo "<pre>"; print_r($ty); die;
          if(!in_array($value, $postAr)){ //echo "<pre>"; print_r($ty); 
            $ClientVehicle_1 = ClientVehicleMap::find()->where(['vehicle_id'=>$model->id])
            ->andWhere(['client_id'=>$value])->andWhere(['vehicle_status'=>'A'])->one(); 
            if(!empty($ClientVehicle_1)){
            $ClientVehicle_1->remove_date = date("Y-m-d H:i:s");
            $ClientVehicle_1->client_id = $value;
            $ClientVehicle_1->vehicle_status = "I"; 
            $ClientVehicle_1->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
                if($ClientVehicle_1->save()){

                }else{
                  echo "<pre>"; print_r($ClientVehicle_1->getErrors());
                }
              }
          }
        }// die;
            
            }
           
      

        $driverprofile = DriverProfile::find()->where(['id'=>$model->driver_id])->andWhere(['available_status'=>"0"])->one();
        $autoid = $model->getPrimaryKey();
        $models= OthersVehicleDetails::find()->where(['id'=>$autoid])->asArray()->one();
        if(!empty($driverprofile)){
          $driverprofile->available_status="1";
          $driverprofile->client_id=$models['client_id'];
          $driverprofile->vehicle_id=$models['id'];
          if($driverprofile->save()){
            Yii::$app->session->setFlash('success', "Data Saved with a Driver.");
          }else{
            Yii::$app->session->setFlash('danger', "Data Saved without Select Driver.");
          }
        } 
      return $this->redirect(['index']);
  }else{
      return $this->render('update', [
          'model' => $model,
      ]);
  }
      
  } else {
      return $this->render('update', [
          'model' => $model,
      ]);
  }
}
 public function actionVehicleCreate()
    {   
        $model = new OthersVehicleDetails();
        $session = Yii::$app->session;   //
        if ($model->load(Yii::$app->request->post())) { 
       // echo "<pre>"; print_r($_POST); die;
       
              
            $model->reg_no = strtoupper($_POST['OthersVehicleDetails']['reg_no']);
            $model->vehicle_name = strtoupper($_POST['OthersVehicleDetails']['vehicle_name']);
           // $model->driver_id = strtoupper($_POST['OthersVehicleDetails']['driver_name']);
           // $model->driver_contact = strtoupper($_POST['OthersVehicleDetails']['driver_contact']);
            $model->created_at = date('Y-m-d H:i:s'); 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
            $model->user_id = $session['user_id'];
            
            if($model->save()){ //echo "asd"; 
                $fetch_array[0]="Y";
                $fetch_array[1]=ArrayHelper::index(OthersVehicleDetails::find()->select(['id'=>'id','reg_no'=>'reg_no'])->asArray()->all(), 'id');
               // echo "<pre>"; print_r($fetch_array[1]); die;
                return json_encode($fetch_array);   
            }else{
               echo "<pre>"; print_r($model->getErrors());die;
                //echo "N";
                $fetch_array[0]="N";
                return json_encode($fetch_array);
            }
        } else {  //echo "<pre>"; print_r($model->getErrors()); die;
            return $this->renderAjax('createvehicle', [
                'model' => $model,
            ]);
        }
    }
     public function actionDriverCreate()
    {   
        $model = new DriverProfile();
        $session = Yii::$app->session;   //echo "<pre>"; print_r($_POST); die;
        if ($model->load(Yii::$app->request->post())) { 
       //   echo "<pre>"; print_r($_FILES); die;

           /* if(Yii::$app->request->isAjax){

                  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
             }*/
            if($_FILES['DriverProfile']['error']['licence_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'licence_copy');
                  $image_name = 'uploads/driver_licence/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->licence_copy = $image_name;
            }
            if($_FILES['DriverProfile']['error']['profile_photo']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'profile_photo');
                  $image_name = 'uploads/driver_profile/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->profile_photo = $image_name;
            }
            if($_FILES['DriverProfile']['error']['aadhar_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'aadhar_copy');
                  $image_name = 'uploads/driver_aadhar/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->aadhar_copy = $image_name;
            }
            if($_FILES['DriverProfile']['error']['pancard_copy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'pancard_copy');
                  $image_name = 'uploads/driver_pancard/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->pancard_copy = $image_name;
            }
            $model->name = strtoupper($_POST['DriverProfile']['name']);
            $model->pancard_no = strtoupper($_POST['DriverProfile']['pancard_no']);
            $model->created_at = date('Y-m-d H:i:s'); 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
             $model->user_id = $session['user_id'];
              if($_POST['DriverProfile']['status']==0){
                $model->status = "Inactive";
            }else{
                $model->status = "Active";
            } 
            if($model->save()){ //echo "asd"; 
                $fetch_array[0]="Y";
                $fetch_array[1]=ArrayHelper::index(DriverProfile::find()->select(['id'=>'id','name'=>'name'])->where(['available_status'=>"0"])->asArray()->all(), 'id');
               // echo "<pre>"; print_r($fetch_array[1]); die;
                return json_encode($fetch_array);   
            }else{
                print_r($model->getErrors());die;
                //echo "N";
                $fetch_array[0]="N";
                return json_encode($fetch_array);
            }
        } else {  //echo "<pre>"; print_r($model->getErrors()); die;
            return $this->renderAjax('createdriver', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing VehicleMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VehicleMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VehicleMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OthersVehicleDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
        public function actionAjaxfetch()
    {
        
        if(!empty($_POST['query']))
        {
            $VehicleMaster=OthersVehicleDetails::find()->select(['id'=>'id','vehicle_name'=>'vehicle_name'])->where(['status'=>'Active'])->andWhere(['LIKE','vehicle_name',$_POST['query']])->asArray()->all();
        
            if(!empty($VehicleMaster))
            {
                $fetch_array=array();
                foreach ($VehicleMaster as $key => $value) 
                {
                    $fetch_array[]=array('vehicle_name'=>$value['vehicle_name']);
                }
                return json_encode($fetch_array);
            }
        }
    }
     

    public function actionVehicleMapping()
    {

        $searchModel = new OthersVehicleDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'map');
        $session = Yii::$app->session;

        if ((Yii::$app->request->post())) { // echo "<pre>"; print_r($_POST); die;
            $driver_id = $_POST['OthersVehicleDetails']['driver_id'];
            $vehi_id = $_POST['getid'];
            $dri_id='';
        
          //  $driverprofile = DriverProfile::findOne($driver_id);
            $vehiclemaster = OthersVehicleDetails::findOne($vehi_id);
            if(!empty($vehiclemaster)){
                $dri_id = $vehiclemaster->driver_id;  
                if(!empty($dri_id)){  
                $driverprofile = DriverProfile::findOne($dri_id); 
                if(!empty($driverprofile)){
                    $driverprofile->available_status="0";

                    if($driverprofile->save()){
                    $vehiclemaster->driver_id = $driver_id;
                     $vehiclemaster->user_id = $session['user_id'];
                     $vehiclemaster->updated_ipaddress =$_SERVER['REMOTE_ADDR'];

                    if($vehiclemaster->save()){  
                        $driverpro = DriverProfile::findOne($vehiclemaster->driver_id);
                        if(!empty($driverpro)){
                            $driverpro->available_status="1";

                            if($driverpro->save()){
                                $log = new VehicledriverAssignlog();

                        $log->vehicle_id     = $vehiclemaster->id;
                        $log->driver_id      = $driverpro->id;
                        $log->driver_status  = $driverpro->available_status;
                        $log->vehicle_status = "0";
                        if($vehiclemaster->driver_id!=""){
                        $log->vehicle_status = "1";    
                         $log->assigned_date = date('Y-m-d H:i:s');
                        }else{
                         $log->removed_date = date('Y-m-d H:i:s');  
                        }
                        $log->created_at = date('Y-m-d H:i:s'); 
                        $log->user_id = $session['user_id'];  
                        $log->updated_ipaddress =$_SERVER['REMOTE_ADDR']; 
                        
                        if($log->save()){
                            return $this->redirect(['vehicle-mapping']);
                        }else{
                            echo "<pre>"; print_r($log->getErrors()); die;
                        } 
                        // return $this->redirect(['vehicle-mapping']);
                            }else{
                                echo "<pre>"; print_r($driverpro->getErrors()); die;
                            }
                        }else{
                            Yii::$app->session->setFlash('danger', "Driver Not Selected.");
                            return $this->redirect(['vehicle-mapping']);
                        }
                    }else{
                    echo "<pre>"; print_r($vehiclemaster->getErrors()); die;
                }
                }else{
                    echo "<pre>"; print_r($driverprofile->getErrors()); die;
                }
                }else{
                       Yii::$app->session->setFlash('danger', "Driver Not Selected.");
                            return $this->redirect(['vehicle-mapping']);
                }
            }else{   
                $vehiclemaster = OthersVehicleDetails::findOne($vehi_id);
                 $vehiclemaster->driver_id = $driver_id;  
                 $vehiclemaster->user_id = $session['user_id'];
                 $vehiclemaster->updated_ipaddress =$_SERVER['REMOTE_ADDR'];

                 if($vehiclemaster->save()){  
                    $driverprofile = DriverProfile::findOne($vehiclemaster->driver_id);

                if(!empty($driverprofile)){
                    $driverprofile->available_status="1";
                    if($driverprofile->save()){
                        $log = new VehicledriverAssignlog();

                        $log->vehicle_id     = $vehiclemaster->id;
                        $log->driver_id      = $driverprofile->id;
                        $log->driver_status  = $driverprofile->available_status;
                        $log->vehicle_status = "0";
                        if($vehiclemaster->driver_id!=""){
                        $log->vehicle_status = "1";    
                         $log->assigned_date = date('Y-m-d H:i:s');
                        }else{
                         $log->removed_date = date('Y-m-d H:i:s');  
                        }
                        $log->created_at = date('Y-m-d H:i:s'); 
                        $log->user_id = $session['user_id'];  
                        $log->updated_ipaddress =$_SERVER['REMOTE_ADDR']; 
                        
                        if($log->save()){
                            return $this->redirect(['vehicle-mapping']);
                        }else{
                            echo "<pre>"; print_r($log->getErrors()); die;
                        }
                    }else{
                        echo "<pre>"; print_r($driverprofile->getErrors()); die;
                    }
                }else{
                    Yii::$app->session->setFlash('danger', "Driver Not Selected.");
                     return $this->redirect(['vehicle-mapping']);
                }

                 }else{
                    echo "<pre>"; print_r($driverprofile->getErrors()); die;
                 }
            }

            }else{
               Yii::$app->session->setFlash('danger', "Driver Not Selected.");
                            return $this->redirect(['vehicle-mapping']);
            }

        }else{
        return $this->render('vehicle-map', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    }

    public function actionAssign($id)
    {
        return $this->renderAjax('driver-list', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionClient($id)
    { 
        $vehiclient = ClientVehicleMap::find()->where(['vehicle_id'=>$id])->asArray()->all();
        return $this->renderAjax('client-list', [
            'model' => $this->findModel($id),
            'vehiclient'=>$vehiclient,
        ]);
    }

    public function actionRemove($id)
    {

      // echo $id; die;
        $session = Yii::$app->session;
         $vehiclemaster = OthersVehicleDetails::findOne($id);
            if(!empty($vehiclemaster)){ 
                $dri_id = $vehiclemaster->driver_id;  
                $driverprofile = DriverProfile::findOne($dri_id);  
             // / echo "<pre>"; print_r($driverprofile); die;
                if(!empty($driverprofile)){
                    $driverprofile->available_status="0";
                    if($driverprofile->save()){
                    $vehiclemaster->driver_id ="";
                    if($vehiclemaster->save()){  

                        $log = new VehicledriverAssignlog();

                        $log->vehicle_id     = $vehiclemaster->id;
                        $log->driver_id      = $driverprofile->id;
                        $log->driver_status  = $driverprofile->available_status;
                        $log->vehicle_status = "0";
                        if($vehiclemaster->driver_id!=""){
                        $log->vehicle_status = "1";    
                         $log->assigned_date = date('Y-m-d H:i:s');
                        }else{
                         $log->removed_date = date('Y-m-d H:i:s');  
                        }
                        $log->created_at = date('Y-m-d H:i:s'); 
                        $log->user_id = $session['user_id'];  
                        $log->updated_ipaddress =$_SERVER['REMOTE_ADDR']; 
                        
                        if($log->save()){
                            return $this->redirect(['vehicle-mapping']);
                        }else{
                            echo "<pre>"; print_r($log->getErrors()); die;
                        } 

                        Yii::$app->session->setFlash('success', "Driver Removed from Vehicle allotment.");
                            return $this->redirect(['vehicle-mapping']);
                    }else{ echo "<pre>"; print_r($driverprofile->getErrors()); die;
                        Yii::$app->session->setFlash('danger', "Driver allotment  Failed.");
                            return $this->redirect(['vehicle-mapping']);
                    }
                    }else{  echo "<pre>"; print_r($driverprofile->getErrors()); die;
                        Yii::$app->session->setFlash('danger', "Driver allotment  Failed.");
                            return $this->redirect(['vehicle-mapping']);
                    }
            }
                }
       /* return $this->renderAjax('driver-list', [
            'model' => $this->findModel($id),
        ]);*/
    }


     public function actionRemoveclient($id,$client_id)
    {   //echo $client_id; die;
        $session = Yii::$app->session; 
         $vehiclemaster = OthersVehicleDetails::findOne($id); 
            if(!empty($vehiclemaster)){ 
                
                    $cli = explode(',',$vehiclemaster->client_id);
                    $rt=array();
                    foreach ($cli as $key => $value) {
                      if($client_id!=$value){
                        $rt[]=$value;
                      }
                    }
                    $client =implode(',', $rt);
                    $vehiclemaster->client_id = $client; 
                    if($vehiclemaster->save()){   
                        $log = new VehicledriverAssignlog(); 
                        $log->vehicle_id     = $vehiclemaster->id;  
                        $log->client_remove_date = date('Y-m-d H:i:s');  
                        $log->created_at = date('Y-m-d H:i:s'); 
                        $log->user_id = $session['user_id'];  
                        $log->updated_ipaddress =$_SERVER['REMOTE_ADDR']; 
                        
                        if($log->save()){

                      $ClientVehicle_1 = ClientVehicleMap::find()->where(['vehicle_id'=>$vehiclemaster->id])
                        ->andWhere(['client_id'=>$client_id])->one(); 
                        if(!empty($ClientVehicle_1)){
                        $ClientVehicle_1->remove_date = date("Y-m-d H:i:s");
                        $ClientVehicle_1->client_id = $client_id;
                        $ClientVehicle_1->vehicle_status = "I"; 
                        $ClientVehicle_1->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
                            if($ClientVehicle_1->save()){

                            }else{
                              echo "<pre>"; print_r($ClientVehicle_1->getErrors());
                            }
                          }



                           Yii::$app->session->setFlash('success', "Client Removed from Vehicle allotment.");
                            return $this->redirect(['client-mapping']);
                        }else{
                            echo "<pre>"; print_r($log->getErrors()); die;
                        }  
                            return $this->redirect(['client-mapping']);
                    }else{ echo "<pre>"; print_r($driverprofile->getErrors()); die;
                        Yii::$app->session->setFlash('danger', "Client allotment  Failed.");
                            return $this->redirect(['client-mapping']);
                    }
                     
            
                }
       
    }



    public function actionClientMapping()
    {

        $searchModel = new OthersVehicleDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'map');
        $session = Yii::$app->session;

        if ((Yii::$app->request->post())) { //echo "<pre>"; print_r($_POST); die;
            $client_id = implode(',' ,$_POST['OthersVehicleDetails']['client_id']);
            $vehi_id = $_POST['getid'];
            $dri_id=''; 
            $vehiclemaster = OthersVehicleDetails::findOne($vehi_id);
            
            if(!empty($vehiclemaster)){
              //  $client = $vehiclemaster->client_id;  
                if(!empty($client_id)){   
                    $vehiclemaster->client_id = $client_id;
                     $vehiclemaster->user_id = $session['user_id'];
                     $vehiclemaster->updated_ipaddress =$_SERVER['REMOTE_ADDR'];

                    if($vehiclemaster->save()){  //echo $vehiclemaster->client_id; die;   

            if(!empty($_POST['OthersVehicleDetails']['client_id'])){  
            $mapcl=ClientVehicleMap::find()->where(['vehicle_id'=>$vehi_id])->asArray()->all();
            $mapclAr=ArrayHelper::map($mapcl,'client_id','client_id');

            $postAr= $_POST['OthersVehicleDetails']['client_id'];     
               
        foreach ($_POST['OthersVehicleDetails']['client_id'] as $key => $value) {
          if(!empty($mapcl)){
          if(!array_key_exists($value, $mapclAr)){
            $ClientVehiclenew = new ClientVehicleMap(); 
            $ClientVehiclenew->assign_date = date("Y-m-d H:i:s"); 
            $ClientVehiclenew->client_id = $value;
            $ClientVehiclenew->vehicle_id = $vehiclemaster->id;
            $ClientVehiclenew->vehicle_status = "A";  
            $ClientVehiclenew->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
            $ClientVehiclenew->created_at = date("Y-m-d H:i:s");  
                if($ClientVehiclenew->save()){ 
                  Yii::$app->session->setFlash('success', "Client Assigned for Selected Vehicle.");
                }else{
                  echo "<pre>"; print_r($ClientVehiclenew->getErrors()); die;
                }
            }else{ 
            }
          }else{ 
             $ClientVehiclenew = new ClientVehicleMap(); 
            $ClientVehiclenew->assign_date = date("Y-m-d H:i:s"); 
            $ClientVehiclenew->client_id = $value;
            $ClientVehiclenew->vehicle_id = $vehi_id;
            $ClientVehiclenew->vehicle_status = "A";  
            $ClientVehiclenew->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
            $ClientVehiclenew->created_at = date("Y-m-d H:i:s");  
                if($ClientVehiclenew->save()){ 
                  Yii::$app->session->setFlash('success', "Client Assigned for Selected Vehicle.");
                }else{
                  echo "<pre>"; print_r($ClientVehiclenew->getErrors()); die;
                }
          } 
        }

        foreach ($mapclAr as $key => $value) {
         $ty=array_search($value, $postAr);
           //echo "<pre>"; print_r($ty); die;
          if(in_array($value, $postAr)){ //echo "<pre>"; print_r($ty); 
            $ClientVehicle_1 = ClientVehicleMap::find()->where(['vehicle_id'=>$vehiclemaster->id])
            ->andWhere(['client_id'=>$value])->one(); 
            if(!empty($ClientVehicle_1)){
            $ClientVehicle_1->remove_date = date("Y-m-d H:i:s");
            $ClientVehicle_1->client_id = $value;
            $ClientVehicle_1->vehicle_status = "A"; 
            $ClientVehicle_1->updated_ipaddress = $_SERVER['REMOTE_ADDR'];
                if($ClientVehicle_1->save()){
                  Yii::$app->session->setFlash('success', "Client Assigned for Selected Vehicle.");

                }else{
                  echo "<pre>"; print_r($ClientVehicle_1->getErrors());
                }
              }
          }
        }   
            }  
                        $log = new VehicledriverAssignlog();
                        $log->vehicle_id     = $vehiclemaster->id; 
                        if($vehiclemaster->client_id!=""){ 
                         $log->client_assign_date = date('Y-m-d H:i:s');
                        }else{
                         $log->client_remove_date = date('Y-m-d H:i:s');  
                        }
                        $log->created_at = date('Y-m-d H:i:s'); 
                        $log->user_id = $session['user_id'];  
                        $log->updated_ipaddress =$_SERVER['REMOTE_ADDR']; 
                        
                        if($log->save()){
                            return $this->redirect(['client-mapping']);
                             Yii::$app->session->setFlash('success', "Client Assigned for Selected Vehicle.");
                        }else{
                            echo "<pre>"; print_r($log->getErrors()); die;
                        }  
                        }else{
                        echo "<pre>"; print_r($vehiclemaster->getErrors()); die;
                    }
                 
                 
            }else{   
                $vehiclemaster = OthersVehicleDetails::findOne($vehi_id);
                 $vehiclemaster->client_id = $client_id;  
                 $vehiclemaster->user_id = $session['user_id'];
                 $vehiclemaster->updated_ipaddress =$_SERVER['REMOTE_ADDR'];

                 if($vehiclemaster->save()){    
                        $log = new VehicledriverAssignlog(); 
                        $log->vehicle_id     = $vehiclemaster->id;  
                        if($vehiclemaster->client_id!=""){ 
                         $log->client_assign_date = date('Y-m-d H:i:s');
                        }else{
                         $log->client_remove_date = date('Y-m-d H:i:s');  
                        }
                        $log->created_at = date('Y-m-d H:i:s'); 
                        $log->user_id = $session['user_id'];  
                        $log->updated_ipaddress =$_SERVER['REMOTE_ADDR']; 
                        
                        if($log->save()){
                          Yii::$app->session->setFlash('success', "Client Assigned for Selected Vehicle.");
                            return $this->redirect(['client-mapping']);
                        }else{
                            echo "<pre>"; print_r($log->getErrors()); die;
                        }  
                 }else{
                    echo "<pre>"; print_r($vehiclemaster->getErrors()); die;
                 }
            }

            }else{
               Yii::$app->session->setFlash('danger', "Client Not Selected.");
                            return $this->redirect(['client-mapping']);
            }

        }else{
        return $this->render('client-map', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    }

    public function actionVehicleReport()
    {
        $searchModel = new OthersVehicleDetailsSearch();
        $dataProvider = $searchModel->vehiclereportsearch(Yii::$app->request->queryParams);

        return $this->render('vehicle-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionVehicleWiseReport(){
    
      $searchModel = new OthersVehicleDetailsSearch();
      $dataProvider = $searchModel->vehiclereportsearch(Yii::$app->request->queryParams);
      $session = Yii::$app->session;
     // echo "<pre>"; print_r($_GET); die;
    if(empty($_GET['fromdate']) && empty($_GET['todate']) && empty($_GET['reg_no']) && 
        empty($_GET['superviser']) && empty($_GET['client']) && empty($_GET['coupon_status'])){
      return $this->render('vehicle-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        }else{ 
   
     require '../../vendor/autoload.php';
    $objPHPExcel = new Spreadsheet(); 
    $sheet = 0;
    //set_time_limit(500); 
    ini_set('max_execution_time', 600);
    $objPHPExcel -> setActiveSheetIndex($sheet);
    /*$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(20);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(20);*/
    $all_post_key = array("Sl. No.", 'vehicle_no','supervisor','client','coupon_number','bunk_name','coupon_amount','refuel_amount','difference_amount', 'coupon_status','coupon_date','refuel_date','refuel_receipt');
    
    $r=0;
    $objPHPExcel -> getActiveSheet() -> setTitle("Allen Trans Vehicle Reports")          
    -> setCellValue('A1', $all_post_key[$r]) 
    -> setCellValue('B1', 'Vehicle No - Driver Name') 
    -> setCellValue('C1', 'Supervisor Name')
    -> setCellValue('D1', 'Client Name')
    -> setCellValue('E1', 'Coupon Code')
    -> setCellValue('F1', 'Bunk Name')
    -> setCellValue('G1', 'Coupon Amount')
    -> setCellValue('H1', 'Refuel Amount')
    -> setCellValue('I1', 'Amount Difference')
    -> setCellValue('J1', 'Coupon Status')
    -> setCellValue('K1', 'Coupon Date')
    -> setCellValue('L1', 'Refuel Date') 
    -> setCellValue('M1', 'Refuel Receipt');
  

    $query = new Query;
    $query  ->select(['*'])->from('coupon')->where(['not',['bunk_name'=>'']]);
    if($_GET['fromdate']!="" && $_GET['todate']!=""){
      $fromdate = date('Y-m-d 00:00:00', strtotime($_GET['fromdate']));
      $todate = date('Y-m-d 23:59:59', strtotime($_GET['todate'])); 
      $query ->andWhere(['BETWEEN','created_at',$fromdate,$todate]); 
    }

    if( $_GET['reg_no']!=""){ 
      $query ->andWhere(['vehicle_name'=>$_GET['reg_no']]); 
    }

    if( $_GET['superviser']!=""){ 
      $query ->andWhere(['superviser_id'=>$_GET['superviser']]);
    }

    if($_GET['client']!=""){ 
      $query ->andWhere(['client_name'=>$_GET['client']]);
    }

    if($_GET['coupon_status']!=""){ 
      $query ->andWhere(['coupon_status'=>$_GET['coupon_status']]);
    } 
    //$query ->limit(200);
    $command = $query->createCommand(); 
    $un_send_data = $command->queryAll();

    $vehicle_index=ArrayHelper::map($un_send_data,'vehicle_name','vehicle_name');
    $client_index=ArrayHelper::map($un_send_data,'client_name','client_name');
    $bunk_index=ArrayHelper::map($un_send_data,'bunk_name','bunk_name');
    $driver_index=ArrayHelper::map($un_send_data,'driver_name','driver_name');
    $superviser_index=ArrayHelper::map($un_send_data,'superviser_id','superviser_id');

    
    $VehicleMaster = OthersVehicleDetails::find()->where(['IN','id',$vehicle_index])->asArray()->all();
    
    $vehicle_name = ArrayHelper::map($VehicleMaster,'id','vehicle_name');
    $vehicle_id = ArrayHelper::map($VehicleMaster,'id','id');
    $vehicle_no = ArrayHelper::map($VehicleMaster,'id','reg_no');

    $BunkMaster = BunkMaster::find()->where(['IN','id',$bunk_index])->asArray()->all();
    $bunk_agency_name = ArrayHelper::map($BunkMaster,'id','bunk_agency_name');
    $bunk_name = ArrayHelper::map($BunkMaster,'id','bunk_company'); 


    $SuperviserMaster = SuperviserMaster::find()->where(['IN','id',$superviser_index])->asArray()->all();
    $superviser_name = ArrayHelper::map($SuperviserMaster,'id','name');
    $superviser_emp_id = ArrayHelper::map($SuperviserMaster,'id','employee_id'); 
   

    $ClientMaster = ClientMaster::find()->where(['IN','id',$client_index])->asArray()->all();
    $company_name = ArrayHelper::map($ClientMaster,'id','company_name');
    $client_name = ArrayHelper::map($ClientMaster,'id','client_name');
 
    $driverprofile = DriverProfile::find()->asArray()->all();
    $drivername = ArrayHelper::map($driverprofile,'id','name');
    $driverid = ArrayHelper::map($driverprofile,'id','employee_id');
    $licencecopy = ArrayHelper::map($driverprofile,'id','licence_copy');
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
            } //echo "<pre>"; print_r($one_data['driver_name']);
            if(array_key_exists($one_data['driver_name'], $drivername)) { 
              $driver_name = $drivername[$one_data['driver_name']];
            }
             $vehi = $vehi_no.' - '.$driver_name;
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $vehi_no);
        }

        else if($one_field=='supervisor'){  //echo "<pre>"; print_r($superviser_name); die;
          $su='';
             if (array_key_exists($one_data['superviser_id'], $superviser_name)) {
              $su_name = $superviser_name[$one_data['superviser_id']];
              $su_no = $superviser_emp_id[$one_data['superviser_id']];
              $su = $su_name.' - '.$su_no;
          }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $su);
        }

        else if($one_field=='client'){
            if (array_key_exists($one_data['client_name'], $company_name)) {
              $comp_name = $company_name[$one_data['client_name']];
          }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $comp_name);
        }

        else if($one_field=='coupon_number'){ 
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $one_data['coupon_code']);
        } 

        else if($one_field=='bunk_name'){
          $agency='';
            if (array_key_exists($one_data['bunk_name'], $bunk_agency_name)) {
              $agency_name = $bunk_agency_name[$one_data['bunk_name']];
              $bank_name = $bunk_name[$one_data['bunk_name']];  
              $agency = $agency_name.' - '.$bank_name;
            }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $agency);
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
          $diff = $one_data['coupon_amount'] - $one_data['refuel_amount'];
           $diff_amount = number_format($diff,2, '.', '');
          if($one_data['coupon_status']=="P"){
             $diff_amount = "Coupon Pending"; 
          } 

          
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $diff_amount);
        }
        else if($one_field=='coupon_status'){
          $stat = $one_data['coupon_status'];
          if($stat=="P"){
            $stat = "Pending";
           }else{
            $stat = "Closed";
           }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $stat);
          
        }
         else if($one_field=='coupon_date'){
          $coupon_date='';
          if($one_data['coupon_gen_date']!=""){ 
           $coupon_date = date('d-m-Y H:i:s', strtotime($one_data['coupon_gen_date']));
          }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $coupon_date);
         }

         else if($one_field=='refuel_date'){ 
          $refuel_date='';
          if($one_data['refuel_date']!=""){ 
           $refuel_date = date('d-m-Y H:i:s', strtotime($one_data['refuel_date']));
          }else{
            $refuel_date = "Not yet Completed";
          } 
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $refuel_date);
         } 

        
         else if($one_field=='refuel_receipt'){ // echo Url::home(true); die;
        //   =  'http://192.168.1.54/2019/allen_transport/backend/web'; 
          $refuel_receipt = Url::home(true);
           
          $name = '';
        //  $refuel_receipt =  'http://hirephpcoder.com/dev/allen_transport/backend/web'; 
          if($one_data['refuel_receipt']!=""){
  //    $refuel_receipt =  'http://hirephpcoder.com/dev/allen_transport/'.$one_data['refuel_receipt']; 
            $name = 'Receipt Link';
         //$refuel_receipt =  'http://192.168.1.54/2019/allen_transport/'.$one_data['refuel_receipt']; 
        // $refuel_receipt =  'http://allentrans.istrides.in/'.$one_data['refuel_receipt']; 
            $base = Url::home(true);
            $base1= str_replace('backend/web/index.php', '', $base);
            $refuel_receipt =  $base1.$one_data['refuel_receipt']; 
          }
          $objPHPExcel->setActiveSheetIndex(0)->getCell($cell_char . $row)->getHyperlink()->setUrl($refuel_receipt);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_char . $row, $name);
     $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->getFont()->getColor()->applyFromArray(['rgb' => '#428bca']);    
          }
        
        if($r_a>=90){
          $r_a=64;
          $r_a1++;          
        }
        $r_a++;
      }
      $slno++;      
      $row++;
    }  //die;
 
        $objWriter = new Xlsx($objPHPExcel); 
        $filename = "Vehicle_Reports_".date("d-m-Y-His").".xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');   
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_end_clean();
        $objWriter->save('php://output');  
      }  

    }


    public function actionCouponReport(){
      
      
       if(empty($_GET['fromdate']) && empty($_GET['todate']) && empty($_GET['reg_no']) && 
        empty($_GET['superviser']) && empty($_GET['client']) && empty($_GET['coupon_status'])){
          $searchModel = new OthersVehicleDetailsSearch();
      $dataProvider = $searchModel->reportsearch(Yii::$app->request->queryParams);
      $session = Yii::$app->session;
      return $this->render('coupon-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        }else{ 


   
     require '../../vendor/autoload.php';
    $objPHPExcel = new Spreadsheet(); 
    $sheet = 0;
    //set_time_limit(500); 
    ini_set('max_execution_time', 600);
    $objPHPExcel -> setActiveSheetIndex($sheet);
    /*$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(20);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(20);*/
    $all_post_key = array("Sl. No.", 'vehicle_no','supervisor','client','coupon_number','bunk_name','coupon_amount','refuel_amount','difference_amount','coupon_status');
    
    $r=0;
    $objPHPExcel -> getActiveSheet() -> setTitle("Allen Trans Vehicle Reports")          
    -> setCellValue('A1', $all_post_key[$r])
    -> setCellValue('B1', 'Vehicle No - Driver Name') 
    -> setCellValue('C1', 'Supervisor Name')
    -> setCellValue('D1', 'Client Name')
    -> setCellValue('E1', 'Coupon Code')
    -> setCellValue('F1', 'Bunk Name')
    -> setCellValue('G1', 'Coupon Amount')
    -> setCellValue('H1', 'Refuel Amount')
    -> setCellValue('I1', 'Amount Difference')
    -> setCellValue('J1', 'Coupon Status');
  

    $query = new Query;
    $query  ->select(['*,SUM(coupon_amount) as coupon_amount,SUM(refuel_amount) as refuel_amount,SUM(coupon_amount) as coupon_amount'])->from('coupon')->where(['not',['bunk_name'=>'']]);
    if($_GET['fromdate']!="" && $_GET['todate']!=""){
      $fromdate = date('Y-m-d 00:00:00', strtotime($_GET['fromdate']));
      $todate = date('Y-m-d 23:59:59', strtotime($_GET['todate'])); 
      $query ->andWhere(['BETWEEN','created_at',$fromdate,$todate]); 
    }

    if($_GET['reg_no']!=""){ 
      $query ->andWhere(['vehicle_name'=>$_GET['reg_no']]); 
      $query ->groupBy('vehicle_name'); 

    }

    if( $_GET['superviser']!=""){ 
      $query ->andWhere(['superviser_id'=>$_GET['superviser']]);
      $query ->groupBy('superviser_id'); 
    }

    if( $_GET['client']!=""){ 
      $query ->andWhere(['client_name'=>$_GET['client']]);
      $query ->groupBy('client_name');
    }

    if( $_GET['coupon_status']!=""){ 
      $query ->andWhere(['coupon_status'=>$_GET['coupon_status']]);
     // $query ->groupBy('coupon_status');
    } 
    //$query ->limit(200);
    $command = $query->createCommand(); 
    $un_send_data = $command->queryAll();
    //echo "<pre>"; print_r($un_send_data); die;
    $vehicle_index=ArrayHelper::map($un_send_data,'vehicle_name','vehicle_name');
    $client_index=ArrayHelper::map($un_send_data,'client_name','client_name');
    $bunk_index=ArrayHelper::map($un_send_data,'bunk_name','bunk_name');
    $driver_index=ArrayHelper::map($un_send_data,'driver_name','driver_name');
    $superviser_index=ArrayHelper::map($un_send_data,'superviser_id','superviser_id');

    
    $VehicleMaster = OthersVehicleDetails::find()->where(['IN','id',$vehicle_index])->asArray()->all();
    
    $vehicle_name = ArrayHelper::map($VehicleMaster,'id','vehicle_name');
    $vehicle_id = ArrayHelper::map($VehicleMaster,'id','id');
    $vehicle_no = ArrayHelper::map($VehicleMaster,'id','reg_no');

    $BunkMaster = BunkMaster::find()->where(['IN','id',$bunk_index])->asArray()->all();
    $bunk_agency_name = ArrayHelper::map($BunkMaster,'id','bunk_agency_name');
    $bunk_name = ArrayHelper::map($BunkMaster,'id','bunk_company'); 


    $SuperviserMaster = SuperviserMaster::find()->where(['IN','id',$superviser_index])->asArray()->all();
    $superviser_name = ArrayHelper::map($SuperviserMaster,'id','name');
    $superviser_emp_id = ArrayHelper::map($SuperviserMaster,'id','employee_id'); 
   

    $ClientMaster = ClientMaster::find()->where(['IN','id',$client_index])->asArray()->all();
    $company_name = ArrayHelper::map($ClientMaster,'id','company_name');
    $client_name = ArrayHelper::map($ClientMaster,'id','client_name');
 
    $driverprofile = DriverProfile::find()->asArray()->all();
    $drivername = ArrayHelper::map($driverprofile,'id','name');
    $driverid = ArrayHelper::map($driverprofile,'id','employee_id');
    $licencecopy = ArrayHelper::map($driverprofile,'id','licence_copy');
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

          if($_GET['reg_no']!=""){
          $vehi='';
          if(array_key_exists($one_data['vehicle_name'], $vehicle_id)) { 
              $vehi_no = $vehicle_no[$one_data['vehicle_name']];
            } //echo "<pre>"; print_r($one_data['driver_name']);
            if(array_key_exists($one_data['driver_name'], $drivername)) { 
              $driver_name = $drivername[$one_data['driver_name']];
            }
             $vehi = $vehi_no.' - '.$driver_name;
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $vehi_no);
        }
      }

        else if($one_field=='supervisor'){  
        if($_GET['superviser']!=""){  //echo "<pre>"; print_r($superviser_name); die;
          $su='';
             if (array_key_exists($one_data['superviser_id'], $superviser_name)) {
              $su_name = $superviser_name[$one_data['superviser_id']];
              $su_no = $superviser_emp_id[$one_data['superviser_id']];
              $su = $su_name.' - '.$su_no;
          }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $su);
        }
        }

        else if($one_field=='client'){  
          if($_GET['client']!=""){
            if (array_key_exists($one_data['client_name'], $company_name)) {
              $comp_name = $company_name[$one_data['client_name']];
          }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $comp_name);
        } 
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
          
          $diff = $one_data['coupon_amount'] - $one_data['refuel_amount'];
          $diff_amount = number_format($diff,2, '.', '');  
          if($one_data['coupon_status']=="P"){ //die;
            $diff_amount = "Coupon Pending";
          }else{
          }

           
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $diff_amount);
        }else if($one_field=='coupon_status'){
           if($one_data['coupon_status']=="P"){ //die;
            $status = "Pending";
            }else{
              $status = " Closed";
            }
           $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $status);
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
 
        $objWriter = new Xlsx($objPHPExcel); 
        $filename = "Coupon_Price_Details_".date("d-m-Y-His").".xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename); 
        header('Cache-Control: max-age=0');   
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_end_clean();
        $objWriter->save('php://output');  
      
      
         }
  }

   public function actionClosedCoupon()
    {
        $searchModel = new VehicleMasterSearch();
        $dataProvider = $searchModel->closedsearch(Yii::$app->request->queryParams);

        return $this->render('closed-coupon', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


  public function actionDowndata($id)
    {
      
      $modes=Coupon::find()->where(['id'=>$id])->one();
    $upl=$modes->refuel_receipt;
     $baseUrl = Yii::$app->basePath; //echo $baseUrl; die;
     $baseUrl= str_replace('\backend', '', $baseUrl);
     $baseUrl= str_replace('/backend', '', $baseUrl);
     $files=$baseUrl.'/'.$upl;
      
     ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }
}
