<?php

namespace backend\controllers;
error_reporting(E_ALL ^ E_NOTICE);
use Yii;
use common\models\User;
use backend\models\Userdetails;
use backend\models\UserdetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * UserdetailsController implements the CRUD actions for Userdetails model.
 */
class UserdetailsController extends Controller
{
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
     * Lists all Userdetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserdetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userdetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Userdetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userdetails();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                /* if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                } */
                Yii::$app->getSession()->setFlash('success', 'User details has been created successfully.');				
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
      
    }

    /**
     * Updates an existing Userdetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) { //echo "<pre>"; print_r($_POST); print_r($_FILES); die;
            if ($_FILES['Userdetails']['error']['profile_picture']==0) {
                  $file_name = preg_replace('/\s+/', '_', $_FILES['Userdetails']['name']['profile_picture']);
                $rand = rand(0,9999);
                $file_name = $rand.'_'.$file_name;
                $aa6 = "uploads/".$file_name;
                move_uploaded_file($_FILES['Userdetails']['tmp_name']['profile_picture'], $aa6);
                $model->profile_picture=$file_name; 
            }
            $existpassword = $model->password_hash;
            if(array_key_exists('password_hash', $_POST['Userdetails'])){
                if($_POST['Userdetails']['password_hash']!=""){ 
                      $model->auth_key  = Yii::$app->security->generateRandomString();
                      $model->password_hash  = Yii::$app->security->generatePasswordHash($_POST['Userdetails']['password_hash']);
                }else{
                    $model->password_hash = $existpassword;
                }
            }
            $model->save();
            Yii::$app->getSession()->setFlash('success', 'User details has been updated successfully.');
            return $this->redirect(['user-view/'.$id]);
        } else {
            // Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
        }
        return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Userdetails model.
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
     * Finds the Userdetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userdetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userdetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
