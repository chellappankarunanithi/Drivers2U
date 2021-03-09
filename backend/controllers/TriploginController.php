<?php

namespace backend\controllers;

use Yii;
use backend\models\Triplogin;
use backend\models\TriploginSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

/**
 * TriploginController implements the CRUD actions for Triplogin model.
 */
class TriploginController extends Controller
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
     * Lists all Triplogin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TriploginSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Triplogin model.
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
     * Creates a new Triplogin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Triplogin();

         $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {
             if(Yii::$app->request->isAjax){

                  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
             }
             
        if(isset($_POST['Triplogin']['vehicle_number']) && $_POST['Triplogin']['vehicle_number']!=""){
           $vehicle_number = str_replace(' ', '', $_POST['Triplogin']['vehicle_number']);
           $model->username = $vehicle_number;
           $newstring = substr($vehicle_number, -4);
           $model->password = Yii::$app->security->generatePasswordHash($newstring);
           $model->authkey = Yii::$app->security->generateRandomString();
           }
           //echo "<pre>"; print_r($_FILES); die;
           if($_FILES['Triplogin']['error']['profile_photo']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'profile_photo');
                  $image_name = 'uploads/triplogin_profile/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->profile_photo = $image_name;
            }
            $model->user_id = $session['user_id'];
            $model->vehicle_number = $vehicle_number;
            $model->created_at = date('Y-m-d H:i:s'); 
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
            if($_POST['Triplogin']['status']==0){
                $model->status = "I";
            }else{
                $model->status = "A";
            } 
             $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Triplogin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
          if (Yii::$app->request->post()) {
             if(Yii::$app->request->isAjax){ 
                  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
             } //echo "<pre>"; print_r($_POST); die;
           if(isset($_POST['Triplogin']['vehicle_number']) && $_POST['Triplogin']['vehicle_number']!=""){
           $vehicle_number = str_replace(' ', '', $_POST['Triplogin']['vehicle_number']);
           $model->username = $vehicle_number; 
           $newstring = substr($vehicle_number, -4);
           $model->password = Yii::$app->security->generatePasswordHash($newstring);
          // $model->authkey = Yii::$app->security->generateRandomString();
           }
           //echo "<pre>"; print_r($_FILES); die;
            if($_FILES['Triplogin']['error']['profile_photo']==0)
            {
                  $rand = rand(0, 999); // random number generation for unique image save
                  $model->file = UploadedFile::getInstance($model, 'profile_photo');
                  $image_name = 'uploads/triplogin_profile/' . $model->file->basename . "." . $model->file->extension;
                  $model->file->saveAs($image_name);
                  $model->profile_photo = $image_name;
            }
            $model->user_id = $session['user_id'];
            $model->vehicle_number = $vehicle_number;
            $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
            if($_POST['Triplogin']['status']==0){
                $model->status = "I";
            }else{
                $model->status = "A";
            } 
             $model->save();
            return $this->redirect(['index']);
        }
 
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Triplogin model.
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

    /**
     * Finds the Triplogin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Triplogin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Triplogin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
