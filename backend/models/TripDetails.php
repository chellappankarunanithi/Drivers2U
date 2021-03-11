<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_details".
 *
 * @property string $id
 * @property string $tripcode
 * @property string $CustomerId
 * @property string $DriverId
 * @property string $VehicleId
 * @property string $VehicleType
 * @property string $VehicleMade
 * @property string $VehicleNo
 * @property string $TripType
 * @property string $TripScheduleType
 * @property string $ChangeTrip
 * @property string $Changeof
 * @property string $ChangeReason
 * @property string $TripStartLoc
 * @property string $TripEndLoc
 * @property string $StartDateTime
 * @property string $EndDateTime
 * @property double $TripCost
 * @property string $Review
 * @property string $CommissionId
 * @property string $CommissionType
 * @property double $CommissionAmount
 * @property string $CreatedDate
 * @property string $UpdatedDate
 * @property string $UpdatedIpaddress
 */
class TripDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_details';
    }

    /**
     * {@inheritdoc}
     */
    public $CustomerName;
    public $CustomerContactNo;
    public $DriverName;
    public $DriverContactNo;
    public function rules()
    {
        return [
            [['CustomerId', 'VehicleType', 'VehicleNo', 'TripType','StartDateTime',], 'required'],
            [['ChangeTrip', 'ChangeReason', 'TripStartLoc', 'TripEndLoc', 'Review', 'UpdatedIpaddress'], 'safe'],
            [['StartDateTime', 'EndDateTime', 'CreatedDate', 'UpdatedDate'], 'safe'],
            [['TripCost', 'CommissionAmount'], 'number'],
            [['tripcode', 'VehicleType', 'VehicleMade', 'TripScheduleType'], 'safe'],
            [['CustomerId', 'DriverId', 'VehicleId', 'VehicleNo', 'TripType'], 'safe'],
            [['DriverId'],'required','on'=>['activate']],
            [['DriverId'],'required','on'=>['change-trip']],
            [['CommissionType','EndDateTime','TripHours','TripCost'],'required','on'=>['complete']],
            [['CancelFee','CancelReason','CancelFeeStatus'],'required','on'=>['cancel']],

            ['CommissionId', 'required', 'when' => function ($model) { 
              return $model->CommissionType == "Percentage"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#tripdetails-commissiontype').val()=='Percentage'; 
              }"
            ],
             ['CommissionValue', 'required', 'when' => function ($model) { 
              return $model->CommissionType == "Flat"; 
                }, 
              'whenClient' => "function (attribute, value) {   
                  return $('#tripdetails-commissiontype').val()=='Flat'; 
              }"
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tripcode' => 'Trip Code',
            'CustomerId' => 'Customer Name',
            'DriverId' => 'Driver Name',
            'VehicleId' => 'Vehicle ID',
            'VehicleType' => 'Vehicle Type',
            'VehicleMade' => 'Brand',
            'VehicleNo' => 'Vehicle No',
            'TripType' => 'Trip Type',
            'TripScheduleType' => 'Trip Schedule Type',
            'ChangeTrip' => 'Change Trip',
            'ChangeReason' => 'Change Reason',
            'TripStartLoc' => 'Trip Start Location',
            'TripEndLoc' => 'Trip End Location',
            'StartDateTime' => 'Start Date Time',
            'EndDateTime' => 'End Date Time',
            'TripCost' => 'Trip Cost',
            'Review' => 'Review',
            'CommissionId' => 'Commission value',
            'CommissionType' => 'Commission Type',
            'CommissionAmount' => 'Commission Amount',
            'CreatedDate' => 'Created Date',
            'UpdatedDate' => 'Updated Date',
            'UpdatedIpaddress' => 'Updated Ipaddress',
        ];
    }
     public function afterFind() { 
        if(isset($this->client->id)){   
            $this->CustomerName=$this->client->client_name.' - '.$this->client->company_name;   
            $this->CustomerContactNo=$this->client->mobile_no;   
        }else{
            $this->CustomerName="Not Set";  
            $this->CustomerContactNo="Not Set";  
        }

         if(isset($this->driver->id)){   
            $this->DriverName=$this->driver->name.' - '.$this->driver->employee_id;   
            $this->DriverContactNo=$this->driver->mobile_number;   
        }else{
            $this->DriverName="Not Set";  
            $this->DriverContactNo="Not Set";  
        }
    }
  
    public function getClient()
    {
        return $this->hasOne(ClientMaster::className(), ['id' => 'CustomerId']);
    }

    public function getDriver()
    {
        return $this->hasOne(DriverProfile::className(), ['id' => 'DriverId']);
    }
}
