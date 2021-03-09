<?php

namespace backend\controllers;

use Yii;
use backend\models\LeftmenuManagement;
use backend\models\LeftmenuManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LeftmenuManagementController implements the CRUD actions for LeftmenuManagement model.
 */
class LeftmenuManagementController extends Controller
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
     * Lists all LeftmenuManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeftmenuManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeftmenuManagement model.
     * @param integer $id
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
     * Creates a new LeftmenuManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeftmenuManagement();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // echo "<pre>";print_r($_POST);die;
            if($model->menuTpe=='group'){
                $model->groupId = $model->menuId;
                $model->groupCode = 'Group - '.rand(1,20000);
                $model->groupMenuName = $model->Name;
            }elseif ($model->menuTpe=='submenu') {
                $oldMenu = LeftmenuManagement::findOne($model->groupId);
                if($oldMenu){
                    $model->groupCode = $oldMenu->groupCode;
                    $model->groupMenuName = $oldMenu->Name;
                }
            }
            $model->menuFor = $_POST['LeftmenuManagement']['menuFor'];
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'New Menu Added'); 
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LeftmenuManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->menuTpe=='group'){
                $model->groupId = $model->menuId;
                $model->groupCode = 'Group - '.rand(1,3);
                $model->groupMenuName = $model->Name;
            }elseif ($model->menuTpe=='submenu') {
                $oldMenu = LeftmenuManagement::findOne($model->groupId);
                if($oldMenu){
                    $model->groupCode = $oldMenu->groupCode;
                    $model->groupMenuName = $oldMenu->Name;
                }
            }                        
            $model->menuFor = $_POST['LeftmenuManagement']['menuFor'];
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'Menu Informations Changed'); 
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

     public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
                       
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'Menu Informations Changed'); 
            }
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LeftmenuManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $ar = array('I'=>'A','A'=>'I');
        if($model->activeStatus==""){
            $model->activeStatus = "A";
        }
        $model->activeStatus = $ar[$model->activeStatus];
        if($model->save()){
            if($model->activeStatus=="A"){
                $color = "success";
                $message = "Active";
            }else{
                $color = "danger";
                $message = "In-Active";
            }
            Yii::$app->getSession()->setFlash($color, 'Status updated as '.$message); 
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the LeftmenuManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeftmenuManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeftmenuManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*** Menu Order By alban Bensam on 19-12-2019 ***/
    public function actionMenuOrder()
    {
        $session = Yii::$app->session;

        $model=LeftmenuManagement::find()->all();

        $form_model=new LeftmenuManagement();

        if(Yii::$app->request->post())
        {
            
            if($_POST['MenuManagement']['menuId'])
            {
                $s_no=1;
                foreach ($_POST['MenuManagement']['menuId'] as $key => $value) {
                        
                    LeftmenuManagement::updateAll(['sortOrder'=>$s_no,'updatedAt'=>date('Y-m-d H:i:s')],['menuId'=>$value]);

                    $s_no++;
                    
                }
            }
            
            Yii::$app->getSession()->setFlash('success', 'Auth Menu Order Has Updated Successfully...');
            return $this->redirect(['menu-order']);
        }
        else
        {
            return $this->render('menu-order',[
                'model' => $model ,
                'form_model' => $form_model
            ]);
        }
        
    }

    public function actionMerchantMenuOrder()
    {
        $session = Yii::$app->session;

        $model=LeftmenuManagement::find()->all();

        $form_model=new LeftmenuManagement();

        if(Yii::$app->request->post())
        {
            
            if($_POST['MenuManagement']['menuId'])
            {
                $s_no=1;
                foreach ($_POST['MenuManagement']['menuId'] as $key => $value) {
                        
                    LeftmenuManagement::updateAll(['sortOrder'=>$s_no,'updatedAt'=>date('Y-m-d H:i:s')],['menuId'=>$value]);

                    $s_no++;
                    
                }
            }
            
            Yii::$app->getSession()->setFlash('success', 'Auth Menu Order Has Updated Successfully...');
            return $this->redirect(['/menu-order-merchant']);
        }
        else
        {
            return $this->render('menu-order-merchant',[
                'model' => $model ,
                'form_model' => $form_model
            ]);
        }
        
    }

    /*** Menu Order By alban Bensam on 15-12-2020 ***/
    public function actionSubmenuOrder($id)
    {
        $session = Yii::$app->session;

        $model=LeftmenuManagement::find()->where(['menuTpe'=>'submenu'])->andWhere(['groupId'=>$id])->andWhere(['activeStatus'=>'A'])->orderBy(['sortOrder'=>SORT_ASC])->all();
        $form_model=new LeftmenuManagement();
        if(Yii::$app->request->post())
        {
            if($_POST['MenuManagement']['menuId'])
            {
                $s_no=1;
                foreach ($_POST['MenuManagement']['menuId'] as $key => $value) {
                        
                    LeftmenuManagement::updateAll(['sortOrder'=>$s_no,'updatedAt'=>date('Y-m-d H:i:s')],['menuId'=>$value]);

                    $s_no++;
                    
                }
            }
            
            Yii::$app->getSession()->setFlash('success', 'Auth Sub Menu Order Has Updated Successfully...');
            return $this->redirect(['menu-order']);
        }
        else
        {
            return $this->render('sub-menu-order',[
                'model' => $model ,
                'form_model' => $form_model
            ]);   
        }
    }
    public function actionSubmenuOrderMerchant($id)
    {
        $session = Yii::$app->session;

        $model=LeftmenuManagement::find()->where(['menuTpe'=>'submenu'])->andWhere(['groupId'=>$id])->andWhere(['activeStatus'=>'A'])->orderBy(['sortOrder'=>SORT_ASC])->all();
        $form_model=new LeftmenuManagement();
        if(Yii::$app->request->post())
        {
            if($_POST['MenuManagement']['menuId'])
            {
                $s_no=1;
                foreach ($_POST['MenuManagement']['menuId'] as $key => $value) {
                        
                    LeftmenuManagement::updateAll(['sortOrder'=>$s_no,'updatedAt'=>date('Y-m-d H:i:s')],['menuId'=>$value]);

                    $s_no++;
                    
                }
            }
            
            Yii::$app->getSession()->setFlash('success', 'Auth Sub Menu Order Has Updated Successfully...');
            return $this->redirect(['/menu-order-merchant']);
        }
        else
        {
            return $this->render('sub-menu-order-merchant',[
                'model' => $model ,
                'form_model' => $form_model
            ]);   
        }
    }
}
