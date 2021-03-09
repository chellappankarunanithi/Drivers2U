<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer_details".
 *
 * @property string $id
 * @property string $company_name
 * @property string $contact_person
 * @property string $contact_person_designation
 * @property string $company_contact_no
 * @property string $company_email
 * @property string $company_address
 * @property string $personal_contact_no
 * @property string $personal_email
 * @property string $personal_address
 * @property string $company_pincode
 * @property string $personal_pincode
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_ipaddress
 */
class CustomerDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $clientname;
    public static function tableName()
    {
        return 'customer_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_contact_no', 'personal_contact_no'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_name', 'contact_person', 'contact_person_designation', 'updated_ipaddress','company_contact_no', 'personal_contact_no', 'company_address','personal_address'], 'required'],
           
            [['company_email', 'personal_email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clientname' => 'Company Name',
            'contact_person' => 'Contact Person',
            'contact_person_designation' => 'Contact Person Designation',
            'company_contact_no' => 'Company Contact No',
            'company_email' => 'Company Email',
            'company_address' => 'Company Address',
            'personal_contact_no' => 'Personal Contact No',
            'personal_email' => 'Personal Email',
            'personal_address' => 'Personal Address',
            'company_pincode' => 'Company Pincode',
            'personal_pincode' => 'Personal Pincode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_ipaddress' => 'Updated Ipaddress',
        ];
    }


     public function afterFind() {
 
    if(isset($this->client->id)){   
        $this->clientname=$this->client->company_name;   
    }else{
        $this->clientname="<a>Not Set </a>";  
    }
}
  
    public function getClient()
    {
        return $this->hasOne(ClientMaster::className(), ['id' => 'company_name'])->orderBy(['client_master.company_name' => SORT_ASC]);
    }
}
