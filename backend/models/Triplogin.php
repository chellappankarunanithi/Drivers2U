<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "triplogin".
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $contact_no
 * @property string $email
 * @property string $profile_photo
 * @property string $username
 * @property string $password
 * @property string $authkey
 * @property string $vehicle_number
 * @property string $driver_name
 * @property string $created_at
 * @property string $updated_ipaddress
 * @property string $updated_at
 * @property string $user_id
 */
class Triplogin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public static function tableName()
    {
        return 'triplogin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['first_name','contact_no', 'last_name', 'username', 'password', 'authkey', 'updated_ipaddress'], 'required'],
            [[  'driver_name', 'user_id'], 'safe'],
            [['username','vehicle_number'], 'unique'],
            [['contact_no'], 'number'],
            [['email'], 'email'],
            [['profile_photo'], 'file','extensions'=>'jpg,png'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'contact_no' => 'Contact No',
            'email' => 'Email',
            'profile_photo' => 'Profile Photo',
            'username' => 'Username',
            'password' => 'Password',
            'authkey' => 'Authkey',
            'vehicle_number' => 'Vehicle Number',
            'driver_name' => 'Driver Name',
            'created_at' => 'Created At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
        ];
    }
}
