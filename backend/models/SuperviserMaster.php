<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "superviser_master".
 *
 * @property int $id
 * @property string $name
 * @property string $employee_id
 * @property string $mobile_no
 * @property string $email_id
 * @property string $address
 * @property string $aadhar_no
 * @property string $user_name
 * @property string $password
 * @property string $authkey
 * @property string $profile_photo
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 * @property string $updated_ipaddress
 * @property int $user_id
 */
class SuperviserMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'superviser_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'password', 'authkey', 'status'], 'string'],
            [['aadhar_no', 'user_id'], 'integer'],
            [['created_at'], 'required'],
            [['created_at', 'modified_at'], 'safe'],
            [['name', 'employee_id', 'mobile_no', 'profile_photo', 'updated_ipaddress'], 'string', 'max' => 255],
            [['email_id', 'user_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'employee_id' => 'Employee ID',
            'mobile_no' => 'Mobile No',
            'email_id' => 'Email ID',
            'address' => 'Address',
            'aadhar_no' => 'Aadhar No',
            'user_name' => 'User Name',
            'password' => 'Password',
            'authkey' => 'Authkey',
            'profile_photo' => 'Profile Photo',
            'status' => 'Status',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'user_id' => 'User ID',
        ];
    }
}
