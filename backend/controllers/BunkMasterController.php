<?php

namespace backend\controllers;

use Yii;
use backend\models\BunkMaster;
use backend\models\BunkMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException; 
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * BunkMasterController implements the CRUD actions for BunkMaster model.
 */
class BunkMasterController extends Controller
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
     * Lists all BunkMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BunkMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BunkMaster model.
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
     * Creates a new BunkMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BunkMaster();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {

            if(Yii::$app->request->isAjax){

                  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
             }

            if(isset($_POST['BunkMaster']['password']) && $_POST['BunkMaster']['password']!=""){
            $model->password = Yii::$app->security->generatePasswordHash($_POST['BunkMaster']['password']);
            $model->authkey = Yii::$app->security->generateRandomString();
            }
            $model->created_at = date('Y-m-d H:i:s'); 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
             $model->user_id = $session['user_id'];
              if($_POST['BunkMaster']['status']==0){
                $model->status = "Inactive";
            }else{
                $model->status = "Active";
            } 
            if($model->save()){
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
     * Updates an existing BunkMaster model.
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
                 $f =  ActiveForm::validate($model);
                 if(!empty($f)){
                    return $f;
                 }
            }
            if(isset($_POST['BunkMaster']['password']) && $_POST['BunkMaster']['password']!=""){
            $model->password = Yii::$app->security->generatePasswordHash($_POST['BunkMaster']['password']);
            $model->authkey = Yii::$app->security->generateRandomString();
            }
            $model->mobile_no = $_POST['BunkMaster']['mobile_no']; 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
            $model->user_id = $session['user_id'];
             if($_POST['BunkMaster']['status']==0){
                $model->status = "Inactive";
            }else{
                $model->status = "Active";
            } 

            if($model->save()){
            return $this->redirect(['index']);    
            }else { 
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
     * Deletes an existing BunkMaster model.
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
     * Finds the BunkMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BunkMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BunkMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
