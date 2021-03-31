<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_master".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $client_name
 * @property integer $mobile_no
 * @property string $address
 * @property integer $pincode
 * @property string $email_id
 * @property string $website
 * @property string $created_at
 * @property string $modified_at
 * @property integer $user_id
 * @property string $updated_ipaddress
 */
class ClientMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hidden_Input;

    public static function tableName()
    {
        return 'client_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name','mobile_no', 'client_name','address', 'Landmark','pincode'], 'required'],
            [['mobile_no', 'pincode'], 'integer'], 
            [['created_at', 'modified_at','address','company_name', 'client_name', 'website', 'updated_ipaddress','email_id'], 'safe'],
           // [['company_name', 'client_name', 'website', 'updated_ipaddress'], 'string', 'max' => 255],
            [['mobile_no'], 'unique'],
            [['email_id'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Customer ID',
            'client_name' => 'Customer Name',
            'UserType' => 'Customer Type',
            'mobile_no' => 'Mobile No',
            'address' => 'Address',
            'pincode' => 'Pincode',
            'email_id' => 'Email ID',
            'website' => 'Website',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'user_id' => 'User ID',
            'updated_ipaddress' => 'Updated Ipaddress',
        ];
    }
public function afterFind() {
   
}
    
}
