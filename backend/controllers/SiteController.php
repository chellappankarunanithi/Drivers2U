<?php
namespace backend\controllers; 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\User;
 

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    { 
        return $this->render('index');
    }

    public function actionLogin()
    {
        $session = Yii::$app->session;
    	$this->layout='loginLayout';
       // if (!\Yii::$app->user->isGuest) {
 
        if (array_key_exists('user_id', $session) && $session['user_id']!="") {
            return $this->goHome();
        }

        $model = new LoginForm();
		 
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $username = $_REQUEST['LoginForm']['username'];
            $user_data = User::find()->where(['username' => $username])->one();
            return $this->goHome(); //goBack changed as goHome
        } else { 
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $session = Yii::$app->session;
        $session->destroy();


        return $this->goHome();
    }

    
}
