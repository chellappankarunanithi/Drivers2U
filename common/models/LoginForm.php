<?php
namespace common\models;

use Yii;
use yii\base\Model;
use  yii\web\Session;

/**
 * Login form
 */
class LoginForm extends Model
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
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
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
        $session = Yii::$app->session;
         unset($session['user_id']);
        unset($session['user_name']);
        $session->destroy();

        $username = $_REQUEST['LoginForm']['username'];
        if ($this->validate()) {  
            $user_data = User::find()->where(['username' => $username])->one();
            if(!empty($user_data)){
            $session['user_id']  = $user_data->id;
            $session['user_name']  = $user_data->username;	
            $session['first_name']  = $user_data->first_name;  
            $session['last_name']  = $user_data->last_name;  
            $session['sure_name']  = $user_data->first_name.' '.$user_data->last_name;  
            $session['contact_number']  = $user_data->mobile_number;  
			$session['user_logintype']  = 'T1';			
            $session['profile_picture']  = $user_data->profile_picture;         
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            }

        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
