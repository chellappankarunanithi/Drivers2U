<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property string $coupon_code
 * @property string $superviser_id
 * @property string $description
 * @property string $superviser_name
 * @property string $bunk_name
 * @property string $vehicle_name
 * @property string $client_name
 * @property integer $coupon_amount
 * @property string $coupon_gen_date
 * @property integer $refuel_amount
 * @property string $refuel_date
 * @property string $manager_signature
 * @property string $coupon_status
 * @property string $created_at
 * @property string $modified_at
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $vehiclename;
    public $clientname;
    public $supervisorname;
    public $drivername;
    public $bunkagencyname;
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['description'], 'string'],
            [['coupon_amount', 'refuel_amount'], 'integer'],
            [['coupon_gen_date', 'refuel_date', 'created_at', 'modified_at','coupon_amount', 'refuel_amount','description','coupon_code', 'superviser_name', 'bunk_name', 'vehicle_name', 'client_name', 'coupon_status','superviser_id','manager_signature','coupon_close_date'], 'safe'],
            [['coupon_code'], 'unique'],
          //  [['coupon_code', 'superviser_name', 'bunk_name', 'vehicle_name', 'client_name', 'coupon_status'], 'string', 'max' => 100],
          //  [['superviser_id'], 'string', 'max' => 50],
           // [['manager_signature'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coupon_code' => 'Coupon Code',
            'superviser_id' => 'Superviser ID',
            'description' => 'Description',
            'superviser_name' => 'Superviser Name',
            'bunk_name' => 'Bunk Name',
            'vehicle_name' => 'Vehicle Name',
            'client_name' => 'Client Name',
            'coupon_amount' => 'Coupon Amount',
            'coupon_gen_date' => 'Coupon Gen Date',
            'coupon_close_date' => 'Coupon Close Date',
            'refuel_amount' => 'Refuel Amount',
            'refuel_date' => 'Refuel Date',
            'manager_signature' => 'Manager Signature',
            'coupon_status' => 'Coupon Status',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
      public function afterFind() {
    if(isset($this->vehicle->id)){   
        $this->vehiclename=$this->vehicle->reg_no;   
    }else{
        $this->vehicle_name="<a>Not Set </a>";  
    } if(isset($this->client->id)){   
        $this->clientname=$this->client->company_name;   
    }else{
        $this->clientname="<a>Not Set </a>";  
    }
    if(isset($this->super->id)){   
        $this->supervisorname=$this->super->name;   
    }else{
        $this->supervisorname="<a>Not Set </a>";  
    }
    if(isset($this->driver->id)){   
        $this->drivername=$this->driver->name;   
    }else{
        $this->drivername="<a>Not Set </a>";  
    }
     if(isset($this->bunk->id)){   
        $this->bunkagencyname=$this->bunk->bunk_agency_name;   
    }else{
        $this->bunkagencyname="<a>Not Set </a>";  
    }
}
    public function getVehicle()
    {
        return $this->hasOne(VehicleMaster::className(), ['id' => 'vehicle_name']);
    }
    public function getClient()
    {
        return $this->hasOne(ClientMaster::className(), ['id' => 'client_name']);
    }
    public function getSuper()
    {
        return $this->hasOne(SuperviserMaster::className(), ['id' => 'superviser_id']);
    }
    public function getDriver()
    {
        return $this->hasOne(DriverProfile::className(), ['id' => 'driver_name']);
    }
    public function getBunk()
    {
        return $this->hasOne(BunkMaster::className(), ['id' => 'bunk_name']);
    }
}
