<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bunk_master".
 *
 * @property integer $id
 * @property string $bunk_agency_name
 * @property string $bunk_company
 * @property string $manager_name
 * @property string $mobile_no
 * @property string $email_id
 * @property string $address
 * @property string $user_name
 * @property string $password
 * @property string $authkey
 * @property string $created_at
 * @property string $modified_at
 * @property string $updated_ipaddress
 * @property string $status
 */
class BunkMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bunk_master';
    }

    /**
     * @inheritdoc
     */
      public function rules()
    {
        return [
            [['user_name'],'unique'],
           // [['mobile_no'], 'integer'], 
            [['created_at', 'modified_at'], 'safe'],
            [['mobile_no', 'latitude_longitude', 'manager_name','bunk_company','bunk_agency_name','user_name','password'], 'required'],
            [['password', 'updated_ipaddress','email_id','address', 'authkey', 'status','mobile_no'], 'safe'],
             
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bunk_agency_name' => 'Bunk Agency Name',
            'bunk_company' => 'Bunk Company',
            'manager_name' => 'Manager Name',
            'mobile_no' => 'Mobile No',
            'email_id' => 'Email ID',
            'address' => 'Address',
            'user_name' => 'User Name',
            'password' => 'Password',
            'authkey' => 'Authkey',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'status' => 'Status',
        ];
    }
}
