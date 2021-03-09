<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $rights
 */
class Userdetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username','mobile_number','user_level'], 'required'],
            [['password_hash'], 'string', 'min' => 6, 'max' => 20,'on'=>'create'],
            [['password_hash'], 'required'],
            [['username','first_name','last_name','city'], 'string', 'max' => 255],
            [['mobile_number'], 'number'],            
       		[['designation'], 'string', 'max' => 100],
            [['username'], 'unique'],
            //[['email'], 'unique'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Email',
            'first_name' => 'First Name', 
            'last_name' => 'Last Name', 
            //'dob' => 'Date of birth',
            'city' => 'City', 
            'password_hash' => 'Password',
            //'email' => 'Email',
            'mobile_number' => 'Mobile Number',
            'user_level' => 'User Type',
            'designation' => 'Designation',
           
        ];
    }



    /**
     * Signs user up.
     *
     * @retur User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->dob = date('Y-m-d', strtotime($this->dob));
        $user->username = $this->username;
        $user->city = $this->city;
        //$user->email = $this->email;
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();
		$user->mobile_number = $this->mobile_number;
		$user->user_level = $this->user_level;
		$user->designation = $this->designation;
        
        return $user->save() ? $user : null;
    }



    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {

        if ($this->isNewRecord) {
        }
      //  $this->dob = date('Y-m-d', strtotime($this->dob));
        if (parent::beforeSave($insert)) {
            // Place your custom code here
           return true;
        } else {
            return false;
        }
    }
    
    
     public function afterFind() {
         $this->dob = date('d-m-Y', strtotime($this->dob));
        parent::afterFind();
        
    }
}
