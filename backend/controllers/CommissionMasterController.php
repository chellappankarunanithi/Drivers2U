<?php

namespace backend\controllers;

use Yii;
use backend\models\CommissionMaster;
use backend\models\CommissionMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommissionMasterController implements the CRUD actions for CommissionMaster model.
 */
class CommissionMasterController extends Controller
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
     * Lists all CommissionMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommissionMasterSearch();
        $post = Yii::$app->request->post();
        $dataProvider = $searchModel->search($post);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CommissionMaster model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CommissionMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommissionMaster();        
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) {
            // echo "<prE>";print_r($_POST);die;
            if ($formTokenValue = Yii::$app->request->post('CommissionMaster')['hidden_Input']){
                $sessionTokenValue =  $session['hidden_token'];
                if ($formTokenValue == $sessionTokenValue ){
                    if($model->save()){
                        Yii::$app->session->remove('hidden_token');
                    }
                }
            }
            return $this->redirect(['index']);
        }else{
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            
            return $this->render('create', [
                'model' => $model, 'token_name' => $formTokenName,
            ]);            
        }

    }

    /**
     * Updates an existing CommissionMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($formTokenValue = Yii::$app->request->post('CommissionMaster')['hidden_Input']){
                $sessionTokenValue =  $session['hidden_token'];
                if ($formTokenValue == $sessionTokenValue ){
                    if($model->save()){
                        Yii::$app->session->remove('hidden_token');
                    }
                }
            }
            return $this->redirect(['index']);
        }else{
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            
            return $this->render('update', [
                'model' => $model, 'token_name' => $formTokenName,
            ]);            
        }
    }

    /**
     * Deletes an existing CommissionMaster model.
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
     * Finds the CommissionMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CommissionMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommissionMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
