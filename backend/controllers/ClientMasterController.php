<?php

namespace backend\controllers;

use Yii;
use backend\models\ClientMaster;
use backend\models\SuperviserClientMap;
use backend\models\GeneralConfiguration;
use backend\models\ClientMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
/**
 * ClientMasterController implements the CRUD actions for ClientMaster model.
 */
class ClientMasterController extends Controller
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
                    'delete' => ['post'],
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
     * Lists all ClientMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientMasterSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post); 

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientMaster model.
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
     * Creates a new ClientMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClientMaster();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {
                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }

            if ($formTokenValue = Yii::$app->request->post('ClientMaster')['hidden_Input']){
                $sessionTokenValue =  $session['hidden_token'];
                if ($formTokenValue == $sessionTokenValue ){           
                    $confiq = GeneralConfiguration::findOne(['config_key'=>'customerid']);
                       $cust_id='1';
                    if ($confiq) {
                        $cust_id = $confiq->config_value;
                    }
                    $model->company_name = "CUST-D2U-0".$cust_id;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->status = $_POST['ClientMaster']['status'];
                    $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
                    $model->user_id = $session['user_id'];
                     if($_POST['ClientMaster']['status']==0){
                        $model->status = "Inactive";
                    }else{
                        $model->status = "Register";
                    }
                    if($model->save()){
                        Yii::$app->session->remove('hidden_token');
                        $confiq->config_value = $cust_id+1;
                        $confiq->save();
                        return $this->redirect(['customer-otp/'.$model->id]);
                    }else{ echo "<pre>"; print_r($model->getErrors()); die;
                         return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }
            }
            return $this->redirect(['index']);
        } else {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return $this->render('create', [
                'model' => $model,
                'token_name' => $formTokenName,
            ]);
        }
    }


     public function actionCustomerOtp($id="")
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        if ($_POST) { //echo "<pre>"; print_r($_POST); die;

        } else {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return $this->render('otpverification', [
                'model' => $model,
                'token_name' => $formTokenName,
            ]);
        }
    }

    #on running customer add
    public function actionCustomerTripCreate($id="")
    {
        $model = new ClientMaster();
        $session = Yii::$app->session;
            $savedId = '';   
        if ($model->load(Yii::$app->request->post())) { 
                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($formTokenValue = Yii::$app->request->post('ClientMaster')['hidden_Input'])
            {
                $sessionTokenValue =  $session['hidden_token'];
                if ($formTokenValue == $sessionTokenValue ){
                    $confiq = GeneralConfiguration::findOne(['config_key'=>'customerid']);
                    $cust_id='1';
                    if ($confiq) {
                        $cust_id = $confiq->config_value;
                    }
                    $model->company_name = "CUST-D2U-0".$cust_id;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->status = "Register";
                    $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
                    $model->user_id = $session['user_id'];
                  
                    if($model->save()){
                        $savedId = $model->id;
                        $confiq->config_value = $cust_id+1;
                        $confiq->save();
                        Yii::$app->session->remove('hidden_token');
                        if($id=="08"){
                            return $this->redirect(['customer-otp/'.$model->id.'/08']);
                        }else{
                            return $this->redirect(['customer-otp/'.$model->id.'/09']);
                        }
                        //return $this->redirect(['/trip-c/'.$model->id.'/09']);
                    }else{ echo "<pre>"; print_r($model->getErrors()); die;
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }else{

                    $models = ClientMaster::find()->orderBy(['id'=>SORT_DESC])->asArray()->one();
                    if(!empty($models)){
                        $savedId = $models['id'];
                    }
                    if($id=="08"){
                            return $this->redirect(['customer-otp/'.$savedId.'/08']);
                        }else{
                            return $this->redirect(['customer-otp/'.$savedId.'/09']);
                        }
                   // return $this->redirect(['/trip-c/'.$savedId.'/09']);
                }
            }else{
                $models = ClientMaster::find()->orderBy(['id'=>SORT_DESC])->asArray()->one();
                    if(!empty($models)){
                        $savedId = $models['id'];
                    }
                        if($id=="08"){
                            return $this->redirect(['customer-otp/'.$savedId.'/08']);
                        }else{
                            return $this->redirect(['customer-otp/'.$savedId.'/09']);
                        }
               // return $this->redirect(['/trip-c/'.$savedId.'/09']);
            }
        } else {

            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            // echo "string";die;
            return $this->render('create', [
                'model' => $model, 'token_name' => $formTokenName,
            ]);
        }
    }

    
    /**
     * Updates an existing ClientMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {  //echo "<pre>"; print_r($_POST); die;

            if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($formTokenValue = Yii::$app->request->post('ClientMaster')['hidden_Input']){
                $sessionTokenValue =  $session['hidden_token'];
                if ($formTokenValue == $sessionTokenValue ){
                    $model->status = $_POST['ClientMaster']['status'];
                
                    $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
                    $model->user_id = $session['user_id'];
                     if($_POST['ClientMaster']['status']==0){
                        $model->status = "Inactive";
                    }else{
                        $model->status = "Active";
                    } 
                    if($model->save()){ 
                        return $this->redirect(['index']);    
                    }else{
                        return $this->render('update', [
                        'model' => $model,
                    ]);
                    }
                }
            }
            return $this->redirect(['index']); 
        } else {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return $this->render('update', [
                'model' => $model,
                'token_name' => $formTokenName,
            ]);
        }
    }

    /**
     * Deletes an existing ClientMaster model.
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
     * Finds the ClientMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
