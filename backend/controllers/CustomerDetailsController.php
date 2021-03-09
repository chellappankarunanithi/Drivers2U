<?php

namespace backend\controllers;

use Yii;
use backend\models\CustomerDetails;
use backend\models\CustomerDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerDetailsController implements the CRUD actions for CustomerDetails model.
 */
class CustomerDetailsController extends Controller
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
     * Lists all CustomerDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerDetails model.
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
     * Creates a new CustomerDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomerDetails();

        if ($model->load(Yii::$app->request->post())) {
                
            $model->updated_ipaddress = $_SERVER['REMOTE_ADDR'];    
            if($model->save()){
                return $this->redirect(['index']);
            }else{
                echo "<pre>"; print_r($model->getErrors()); die;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CustomerDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
                
            $model->updated_ipaddress = $_SERVER['REMOTE_ADDR'] ;    
            if($model->save()){
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerDetails model.
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
     * Finds the CustomerDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CustomerDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionContactPersons($id)
    {
        $scua = CustomerDetails::find()->where(['company_name'=>$id])->asArray()->all();   
        $cont =  "<option value=''>Select..</option>";
        foreach ($scua as $key => $value) {
           $cont .= "<option value='".$value['id']."'>".$value['contact_person']."</option>";
        }
        return $cont;
    }
    public function actionContactPersons2($id)
    {
        $scuaa = CustomerDetails::find()->where(['id'=>$id])->asArray()->one();   
         if(!empty($scuaa)){
            $scua = CustomerDetails::find()->where(['company_name'=>$scuaa['company_name']])->asArray()->all();

            echo "<option value=''>Select..</option>";
            foreach ($scua as $key => $value) {
                if($value['id']!=$id){
                    echo "<option value='".$value['id']."'>".$value['contact_person']."</option>";
                }
            }

        }
    }
}
