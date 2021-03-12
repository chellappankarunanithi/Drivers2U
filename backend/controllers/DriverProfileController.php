<?php

namespace backend\controllers;

use Yii;
use backend\models\DriverProfile;
use backend\models\VehicleMaster;
use backend\models\GeneralConfiguration;
use backend\models\DriverProfileSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException; 
use yii\widgets\ActiveForm; 
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\helpers\Url;

/**
 * DriverProfileController implements the CRUD actions for DriverProfile model.
 */
class DriverProfileController extends Controller
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

    /**
     * Lists all DriverProfile models.
     * @return mixed
     */
    public function actionDriverManagement()
    {
        $searchModel = new DriverProfileSearch();
        $post = Yii::$app->request->post();
        //echo "<pre>"; print_r($post); die;
        $dataProvider = $searchModel->search($post,'0');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUnavailableDriverManagement()
    {
        $searchModel = new DriverProfileSearch();
         $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post,'1');

        return $this->render('unavailableindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DriverProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DriverProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DriverProfile();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) { //echo "<pre>"; print_r($_POST); die;
            if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
            }
             if($_POST['DriverProfile']['status']==0){
                $model->status = "Inactive";
            }else{
                $model->status = "Active";
            }    
            $model->available_status ="0";
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
            if($_FILES['DriverProfile']['error']['RationcardCopy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'RationcardCopy');
                  $image_name = 'uploads/RationcardCopy/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->RationcardCopy = $image_name;
            }
            /*if($_FILES['DriverProfile']['error']['VoteridCopy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'VoteridCopy');
                  $image_name = 'uploads/VoteridCopy/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->VoteridCopy = $image_name;
            }*/
            if($_FILES['DriverProfile']['error']['PoliceVerificationLetterCopy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'PoliceVerificationLetterCopy');
                  $image_name = 'uploads/PoliceVerificationLetterCopy/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->PoliceVerificationLetterCopy = $image_name;
            }

             $confiq = GeneralConfiguration::findOne(['config_key'=>'driverid']);
               $cust_id='1';
            if ($confiq) {
                $cust_id = $confiq->config_value;
            }
            $model->employee_id = "DRIV-D2U-0".$cust_id;
            if (array_key_exists('DOB', $_POST['DriverProfile'])) {
                if ($_POST['DriverProfile']['DOB']!="" && $_POST['DriverProfile']['DOB']!="00-00-0000") {
                    $model->DOB = date('Y-m-d', strtotime($_POST['DriverProfile']['DOB']));
                }
            }

            if (array_key_exists('PostAppliedFor', $_POST['DriverProfile'])) {
              $model->PostAppliedFor = $_POST['DriverProfile']['PostAppliedFor'];
           
            if ($_POST['DriverProfile']['PostAppliedFor']=="Parttime") {
            
                if (array_key_exists('workstart_time', $_POST['DriverProfile'])) {
                    if ($_POST['DriverProfile']['workstart_time']!="") {
                        $model->workstart_time = date('H:i:s', strtotime($_POST['DriverProfile']['workstart_time']));
                    }
                }
                if (array_key_exists('workend_time', $_POST['DriverProfile'])) {
                    if ($_POST['DriverProfile']['workend_time']!="") {
                        $model->workend_time = date('H:i:s', strtotime($_POST['DriverProfile']['workend_time']));
                    }
                }
            }
          }

            $model->BackgroundCheck = $_POST['DriverProfile']['BackgroundCheck'];
            $model->name = strtoupper($_POST['DriverProfile']['name']);
            $model->FatherName = strtoupper($_POST['DriverProfile']['FatherName']);
            $model->MotherName = strtoupper($_POST['DriverProfile']['MotherName']);
            $model->MaritalStatus = $_POST['DriverProfile']['MaritalStatus'];
            $model->Gender = $_POST['DriverProfile']['Gender'];
            if (array_key_exists('SpouseName', $_POST['DriverProfile']) && $_POST['DriverProfile']['SpouseName']) {
              $model->SpouseName = $_POST['DriverProfile']['SpouseName'];
            }
            $model->HouseDetails = $_POST['DriverProfile']['HouseDetails'];
            $model->Qualification = strtoupper($_POST['DriverProfile']['Qualification']);
            $model->PostAppliedFor = $_POST['DriverProfile']['PostAppliedFor'];
            $model->Experience = $_POST['DriverProfile']['Experience'];

            $model->created_at = date('Y-m-d H:i:s'); 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
             $model->user_id = $session['user_id'];
            if($model->save()){
              $confiq->config_value = $cust_id+1;
              $confiq->save(); 
            return $this->redirect(['driver-management']);
            }else { echo "<pre>"; print_r($model->getErrors()); die;
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
     * Updates an existing DriverProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        if (Yii::$app->request->post()) { //echo "<pre>"; print_r($_POST); die;

            
                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }

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
             if($_FILES['DriverProfile']['error']['RationcardCopy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'RationcardCopy');
                  $image_name = 'uploads/RationcardCopy/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->RationcardCopy = $image_name;
            }
           /* if($_FILES['DriverProfile']['error']['VoteridCopy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'VoteridCopy');
                  $image_name = 'uploads/VoteridCopy/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->VoteridCopy = $image_name;
            }*/
            if($_FILES['DriverProfile']['error']['PoliceVerificationLetterCopy']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->files = UploadedFile::getInstance($model, 'PoliceVerificationLetterCopy');
                  $image_name = 'uploads/PoliceVerificationLetterCopy/' . $model->files->basename . "." . $model->files->extension;
                  $model->files->saveAs($image_name);
                  $model->PoliceVerificationLetterCopy = $image_name;
            }

            if (array_key_exists('DOB', $_POST['DriverProfile'])) {
                if ($_POST['DriverProfile']['DOB']!="" && $_POST['DriverProfile']['DOB']!="00-00-0000") {
                    $model->DOB = date('Y-m-d', strtotime($_POST['DriverProfile']['DOB']));
                }
            }
           if (array_key_exists('PostAppliedFor', $_POST['DriverProfile'])) {
              $model->PostAppliedFor = $_POST['DriverProfile']['PostAppliedFor'];
           
            if ($_POST['DriverProfile']['PostAppliedFor']=="Parttime") {
            
                if (array_key_exists('workstart_time', $_POST['DriverProfile'])) {
                    if ($_POST['DriverProfile']['workstart_time']!="") {
                        $model->workstart_time = date('H:i:s', strtotime($_POST['DriverProfile']['workstart_time']));
                    }
                }
                if (array_key_exists('workend_time', $_POST['DriverProfile'])) {
                    if ($_POST['DriverProfile']['workend_time']!="") {
                        $model->workend_time = date('H:i:s', strtotime($_POST['DriverProfile']['workend_time']));
                    }
                }
            }
          }
             $model->available_status ="0"; 
            $model->BackgroundCheck = $_POST['DriverProfile']['BackgroundCheck'];
            $model->name = strtoupper($_POST['DriverProfile']['name']);
            $model->FatherName = strtoupper($_POST['DriverProfile']['FatherName']);
            $model->MotherName = strtoupper($_POST['DriverProfile']['MotherName']);
            $model->MaritalStatus = $_POST['DriverProfile']['MaritalStatus'];
            $model->Gender = $_POST['DriverProfile']['Gender'];
            if (array_key_exists('SpouseName', $_POST['DriverProfile']) && $_POST['DriverProfile']['SpouseName']) {
              $model->SpouseName = $_POST['DriverProfile']['SpouseName'];
            }
            $model->HouseDetails = $_POST['DriverProfile']['HouseDetails'];
            $model->Qualification = strtoupper($_POST['DriverProfile']['Qualification']);
            $model->PostAppliedFor = $_POST['DriverProfile']['PostAppliedFor'];
            $model->Experience = $_POST['DriverProfile']['Experience'];

            $model->created_at = date('Y-m-d H:i:s'); 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
             $model->user_id = $session['user_id'];

            if($model->save()){
            return $this->redirect(['driver-management']);    
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

    /**
     * Deletes an existing DriverProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['driver-management']);
    }
    public function actionResignation($id)
    {
        $model = $this->findModel($id);
        if($_POST){ //echo "asd"; die;
        if(!empty($model)){
          $vehi_model = VehicleMaster::find()->where(['driver_id'=>$id])->one();
          if(!empty($vehi_model)){
            $vehi_model->driver_id='';
            if($vehi_model->save()){

            }else{
              echo "<pre>"; print_r($vehi_model->getErrors()); die;
            }
          }
          $model->status ="Inactive";
          $model->vehicle_id ="";
          $model->available_status ="0";
          $model->resignation_reason =$_POST['DriverProfile']['resignation_reason'];
          if($model->save()){
           Yii::$app->session->setFlash('success', "Driver Resignation Updated Successfully.");
          }else{
            Yii::$app->session->setFlash('danger', "Driver Resignation Not Updated.");
          }
        }
        return $this->redirect(['driver-management']);
        }else{  //echo "112"; die;
        return $this->renderAjax('resign', [
            'model' => $this->findModel($id),
        ]); 
      }
    }

    /**
     * Finds the DriverProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DriverProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DriverProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





public function actionEmpid($id)
    {
        $model=DriverProfile::find()->where(['employee_id'=>$id])->one();
        if(count($model)>0){
            return  $model->employee_id;
        }else{
            
        }
    }

    public function actionExceldownload($troname='',$troclg='',$trophyyear='') { 
      require '../../vendor/autoload.php';
    $objPHPExcel = new Spreadsheet(); 
    $sheet = 0;
    // / ini_set('max_execution_time', 600);
    $objPHPExcel -> setActiveSheetIndex($sheet);
    
    /*$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(20);
    $objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(20);*/
    $all_post_key = array("Sl. No.","name","employee_id","mobile_number", "email", "address", "aadhar_no", "pancard_no",'profile_photo','created_at','vehicle_id');
    
    $r=0;
   
    $objPHPExcel -> getActiveSheet() -> setTitle("Registration_Details")
    -> setCellValue('A1', $all_post_key[$r])
    -> setCellValue('B1', 'Driver Name') 
    -> setCellValue('C1', 'Employee ID')
    -> setCellValue('D1', 'Mobile Number')
    -> setCellValue('E1', 'Email')
    -> setCellValue('F1', 'Address')
    -> setCellValue('G1', 'Aadhar Number')
    -> setCellValue('H1', 'Pancard Number')
    -> setCellValue('I1', 'Profile Photo')
    //-> setCellValue('J1', 'Licence Copy') 
    -> setCellValue('J1', 'Date of Joining')
    -> setCellValue('K1', 'Assigned Vehicle');
 
    $un_send_data = DriverProfile::find()->where(['status'=>'Active'])-> all();
    
    $vehi = VehicleMaster::find()->where(['status'=>'Active'])->all();
    $assign= ArrayHelper::map($vehi,'id','reg_no');  
    $row = 2;
    $slno=1;      
    foreach($un_send_data as $one_data){
      $r_a=65;$r_a1=64;     
      foreach($all_post_key as $one_field){
        $cell_char=chr($r_a);
        if($r_a1>=65){
          $cell_char=chr($r_a1).chr($r_a);
        }
        if($one_field=='Sl. No.'){
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $slno);
        
        }else{
          if($one_field=='vehicle_id'){
            $vehicle_name='';
          if(array_key_exists($one_data->vehicle_id, $assign)){
            $vehicle_name = $assign[$one_data->vehicle_id];
          }
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $vehicle_name);
          }
          else if($one_field=='created_at'){
            $joindate = date('d-m-Y', strtotime($one_data->created_at));
           $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $joindate);
          }
          else if($one_field=='profile_photo'){
           $base = Url::home(true);
           $base1= str_replace('index.php', '', $base);
         $licence =  $base1.$one_data->profile_photo;

       //  $licence =  'http://allentrans.istrides.in/backend/web/'.$one_data->profile_photo;
        // $licence =  'http://hirephpcoder.com/dev/allen_transport/backend/web/'.$one_data->profile_photo;

         $objPHPExcel->setActiveSheetIndex(0)->getCell($cell_char.$row)->getHyperlink()->setUrl($licence);
         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_char.$row, "Driver Photo Link");
         $objPHPExcel->getActiveSheet()->getStyle($cell_char . $row)->getFont()->getColor()->applyFromArray(['rgb' => '#428bca']);  
          }
         /* else if($one_field=='licence_copy'){
         $licence =  'http://192.168.1.54/2019/allen_transport/backend/web/'.$one_data->licence_copy; 
         $objPHPExcel->setActiveSheetIndex(0)->getCell($cell_char.$row)->getHyperlink()->setUrl($licence);
         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_char.$row, "Licence Link");
          }*/
        /* else if($one_field=='aadhar_copy'){ 
          if($one_data->aadhar_copy!=""){
         $aadhar =  'http://192.168.1.54/2019/allen_transport/backend/web/'.$one_data->aadhar_copy;
         $title = "Aadhar Card Link";
        }else{
          $aadhar='http://192.168.1.54/2019/allen_transport/backend/web/index.php';
          $title = '-';
        }*/
         /*$objPHPExcel->setActiveSheetIndex(0)->getCell($cell_char.$row)->getHyperlink()->setUrl($aadhar);
         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_char.$row, $title);
          }
         else if($one_field=='pancard_copy'){
         $licence =  'http://192.168.1.54/2019/allen_transport/backend/web/'.$one_data->pancard_copy;
         $objPHPExcel->setActiveSheetIndex(0)->getCell($cell_char.$row)->getHyperlink()->setUrl($licence);
         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_char.$row, "Pancard Link");
          }*/
          else{
          $objPHPExcel -> getActiveSheet() -> setCellValue($cell_char . $row, $one_data->$one_field);
        }
        }
        if($r_a>=90){
          $r_a=64;
          $r_a1++;          
        }
        $r_a++;
      }
      $slno++;      
      $row++;
    }
 //$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      /*  $letters = range('A','Z');
        $count =0;
        $cell_name="";
        foreach($all_post_key as $tittle)
        {
         $cell_name = $letters[$count]."1";
         $count++;
         $value = $tittle;
         $objPHPExcel->getActiveSheet()->SetCellValue($cell_name, $value);
         // Make bold cells
         $objPHPExcel->getActiveSheet()->getStyle($cell_name)->getFont()->setBold(true);
        }*/
        
        $objWriter = new Xlsx($objPHPExcel); 

        $filename = "Driver_Details_".date("d-m-Y-His").".xlsx";
        header('Content-Disposition: attachment;filename='.$filename); 
         ob_end_clean();
        $objWriter->save('php://output');  
    
    
  } 



  public function actionPancard($id)
    {
    $modes=DriverProfile::find()->where(['id'=>$id])->one();
     $upl=$modes->pancard_copy;
     $baseUrl = Yii::$app->basePath;
     $files=$baseUrl.'/web/'.$upl;
     ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
  }


  public function actionAadhar($id)
    {
     $modes=DriverProfile::find()->where(['id'=>$id])->one();
     $upl=$modes->aadhar_copy; 
     $baseUrl = Yii::$app->basePath; 
     $files=$baseUrl.'/web/'.$upl;
     ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }


  public function actionProfile($id)
    {
      $modes=DriverProfile::find()->where(['id'=>$id])->one();
      $upl=$modes->profile_photo;
      $baseUrl = Yii::$app->basePath; 
      $files=$baseUrl.'/web/'.$upl; 
      ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }


  public function actionLicence($id)
    {
      
      $modes=DriverProfile::find()->where(['id'=>$id])->one();
      $upl=$modes->licence_copy;
      $baseUrl = Yii::$app->basePath; 
      $files=$baseUrl.'/web/'.$upl; 
      ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }

  public function actionPoliceverification($id)
    {
      
      $modes=DriverProfile::find()->where(['id'=>$id])->one();
      $upl=$modes->PoliceVerificationLetterCopy;
      $baseUrl = Yii::$app->basePath; 
      $files=$baseUrl.'/web/'.$upl; 
      ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }

  public function actionVoterid($id)
    {
      
      $modes=DriverProfile::find()->where(['id'=>$id])->one();
      $upl=$modes->VoteridCopy;
      $baseUrl = Yii::$app->basePath; 
      $files=$baseUrl.'/web/'.$upl; 
      ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }

  public function actionRationcard($id)
    { 
      $modes=DriverProfile::find()->where(['id'=>$id])->one();
      $upl=$modes->RationcardCopy;
      $baseUrl = Yii::$app->basePath; 
      $files=$baseUrl.'/web/'.$upl; 
      ini_set('max_execution_time', 5*60);
    return Yii::$app->response->sendFile($files); 
     
  }

}
