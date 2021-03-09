<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "driver_profile".
 *
 * @property integer $id
 * @property string $name
 * @property string $employee_id
 * @property integer $mobile_number
 * @property string $email
 * @property string $address
 * @property string $profile_photo
 * @property string $licence_copy
 * @property integer $aadhar_no
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 * @property string $updated_ipaddress
 */
class DriverProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $files;
    public $profile_photos;
    public $licence_copys;
    public $aadhar_copys;
    public $RationcardCopys;
    public $PoliceVerificationLetterCopys;
    public $VoteridCopys;
    public static function tableName()
    {
        return 'driver_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FatherName','MotherName','DOB','Gender','MaritalStatus','Experience','Qualification','PostAppliedFor','HouseDetails','mobile_number','name','aadhar_no','address'], 'required'],
            [['mobile_number', 'aadhar_no'], 'integer'], 
            [['created_at', 'modified_at','name', 'employee_id', 'updated_ipaddress','address', 'status','email'], 'safe'],
            [['email'], 'email'],
             [['aadhar_copy','RationcardCopy','licence_copy','PoliceVerificationLetterCopy','profile_photo'], 'file',  'extensions' => 'jpeg,jpg,png,pdf'],
           // [['employee_id'], 'unique', 'on' => 'update'],
           // [['employee_id'], 'unique'],
           /* [['employee_id'], 'unique', 'on'=>'create', 'when' => function($model){
             return $model->isAttributeChanged('employee_id');
            }],*/
            /*[['employee_id'], 'unique', 'on'=>'update', 'when' => function($model){
             return $model->isAttributeChanged('employee_id');
            }],*/
            ['workstart_time', 'required', 'when' => function ($model) { 
              return $model->PostAppliedFor == "Parttime"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-postappliedfor').val() == 'Parttime'; 
              }"
            ],

            ['workend_time', 'required', 'when' => function ($model) { 
              return $model->PostAppliedFor == "Parttime"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-postappliedfor').val() == 'Parttime'; 
              }"
            ],

            ['SpouseName', 'required', 'when' => function ($model) { 
              return $model->MaritalStatus == "Married"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-maritalstatus').val() == 'Married'; 
              }"
            ],

            ['profile_photo', 'required', 'when' => function ($model) { 
              return $model->profile_photos == ""; 
            }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-profile_photos').val() == ''; 
              }"
            ],

            ['licence_copy', 'required', 'when' => function ($model) { 
              return $model->licence_copys == ""; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-licence_copys').val() == ''; 
              }"
            ],
            ['aadhar_copy', 'required', 'when' => function ($model) { 
              return $model->aadhar_copys == ""; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-aadhar_copys').val() == ''; 
              }"
            ],


            ['RationcardCopy', 'required', 'when' => function ($model) { 
              return $model->RationcardCopys == ""; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-rationcardcopys').val() == ''; 
              }"
            ],

             

            ['PoliceVerificationLetterCopy', 'required', 'when' => function ($model) { 
              return $model->PoliceVerificationLetterCopys == ""; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#driverprofile-policeverificationlettercopys').val() == ''; 
              }"
            ],

        ];
    }

    /* public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['login'] = [['employee_id'], 'safe'];//Scenario Values Only Accepted
    return $scenarios;
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'employee_id' => 'Driver ID',
            'FatherName' => "Father's Name",
            'MotherName' => "Mother's Name",
            'employee_id' => 'Driver ID',
            'mobile_number' => 'Mobile Number',
            'email' => 'Email ID',
            'address' => 'Address',
            'profile_photo' => 'Profile Photo',
            'licence_copy' => 'Licence Copy',
            'RationcardCopy' => 'Ration Card / Voter ID Copy',
            'aadhar_no' => 'Aadhaar No',
            'status' => 'Status',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'workstart_time' => 'Working Hours Start time',
            'workend_time' => 'Working Hours End time',
        ];
    }
}
