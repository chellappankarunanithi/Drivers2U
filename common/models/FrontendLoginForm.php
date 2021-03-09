<?php
namespace common\models;

use Yii;
use yii\base\Model;
use  yii\web\Session;
use common\models\Frontend;
use common\models\SwimBaranch;
use common\models\SwimServiceCentre;
use common\models\SwimBranchServiceCentre;
/**
 * Login form
 */
class FrontendLoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $frontend = $this->getFrontend();					
            if (!$frontend || !$frontend->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $sessionfront = Yii::$app->session;
        unset($sessionfront['user_id']);
        unset($sessionfront['user_name']);
        unset($sessionfront['branch_id']);
		unset($sessionfront['branch_name']);
		unset($sessionfront['servicecenter_name']);
        $sessionfront->destroy();
    
        $username = $_REQUEST['FrontendLoginForm']['username'];
       $password = $_REQUEST['FrontendLoginForm']['password'];
        // $password = "admin123";
        
        if (true) {
            $user_data = Frontend::find()->where(['username' => $username])->one();
         
            if(count($user_data) > 0)
            {
            	$sessionfront['user_id']  = $user_data->id;
				$sessionfront['branch_id']  = $user_data->branch_id;
                $sessionfront['user_name']  = $user_data->username;
				$profiles = SwimBaranch::find()->select('branch_name')->where(['branch_autoid'=>$user_data->branch_id])->all();
				foreach($profiles as $result){
					$sessionfront['branch_name'] =$result->branch_name;
				}
				$profile1 = SwimBranchServiceCentre::find()->select('service_center_id')->where(['branch_id'=>$user_data->branch_id])->one();
                
				$profile2 = SwimServiceCentre::find()->select('service_center_name')->where(['center_autoid'=>$profile1->service_center_id])->all();

			 	foreach($profile2 as $result2){					
					$sessionfront['servicecenter_name']=$result2->service_center_name;
				}
                return Yii::$app->user->login($this->getFrontend(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            }else{
               // echo 'E';
               $this->addError($attribute, 'Incorrect username or password.');
            }
            

        } else {
        	unset($sessionfront['user_id']);
			unset($sessionfront['branch_id']);
			unset($sessionfront['user_name']);
            echo 'EE';
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getFrontend()
    {
        if ($this->_user === null) {
            $this->_user = Frontend::findByUsername($this->username);
        }

        return $this->_user;
    }
}
