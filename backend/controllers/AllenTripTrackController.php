<?php

namespace backend\controllers;

use Yii;
use backend\models\AllenTripTrack;
use backend\models\AllenTripTrackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\VehicleMaster;
use backend\models\TripDetailsSearch;
use yii\helpers\ArrayHelper;
/**
 * AllenTripTrackController implements the CRUD actions for AllenTripTrack model.
 */
class AllenTripTrackController extends Controller
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
     * Lists all AllenTripTrack models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AllenTripTrackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AllenTripTrack model.
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

    public function actionTripreport()
    {

         $model = new AllenTripTrack();

         $VehicleMaster = new VehicleMaster();
         $users =   ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->asArray()->all(),'vehicle_name','vehicle_name'); 
         $user =   ArrayHelper::map(VehicleMaster::find()->where(['status'=>'Active'])->asArray()->all(),'reg_no','reg_no');


         if($_POST)
         {
           //print_r($_GET);die;
            if(isset($_POST['SearchName']) && $_POST['SearchName'] == 'search')
            {
                 $searchModel = new TripDetailsSearch();
                 $dataProvider = $searchModel->tripsearch($_POST);
                // print_r($dataProvider->getModels());die;
                  return $this->render('_tripreport', [
                'model' => $model,
                'VehicleMaster' => $VehicleMaster,
                'users' => $users,
                'user' => $user,
                'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
                ]);
            }
            else if(isset($_POST['ReportName']) && $_POST['ReportName'] == 'report')
            {
                 $searchModel = new TripDetailsSearch();
                 $searchModel->tripreport($_POST);
                
            }
            /*else
            {
                
            }*/
            
         }
         else 
         {
            $searchModel = new TripDetailsSearch();
            $dataProvider = $searchModel->tripsearch($_GET='');

                 return $this->render('_tripreport', [
                'model' => $model,
                'VehicleMaster' => $VehicleMaster,
                'users' => $users,
                'user' => $user,
                'searchModel' => $searchModel,
               'dataProvider' => $dataProvider,
            ]);
            
         }
       
    }

    /**
     * Creates a new AllenTripTrack model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AllenTripTrack();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AllenTripTrack model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AllenTripTrack model.
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
     * Finds the AllenTripTrack model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AllenTripTrack the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AllenTripTrack::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
