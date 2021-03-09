<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vehicle_master".
 *
 * @property integer $id
 * @property string $vehicle_name
 * @property string $vehicle_uniqe_name
 * @property string $reg_no
 * @property string $fc_expire_date
 * @property string $status
 * @property string $user_id
 * @property string $updated_ipaddress
 * @property string $created_at
 * @property string $modified_at
 * @property string $engine_number
 * @property string $frame_number
 */
class OthersVehicleDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $driver_name;
    public $client_name;
    public $supervisorname;
    public $clientname;
    public $vehiclename;
    public $drivername;
    public $bunkagencyname;
    public $superviser_id;
    public $bunk_name;

    public $file;
    public $files;
    public static function tableName()
    {
        return 'others_vehicle_details';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['fc_expire_date', 'created_at', 'modified_at','vehicle_uniqe_name', 'updated_ipaddress', 'engine_number', 'frame_number','status','user_id'], 'safe'],
            [['reg_no','vehicle_name'], 'required'],
            [['driver_contact'], 'number'],
            [['reg_no'], 'unique'],
            
        ];
    }

       

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_name' => 'Vehicle Name',
            'vehicle_uniqe_name' => 'Vehicle Uniqe Name',
            'reg_no' => 'Reg No',
            'fc_expire_date' => 'Fc Expire Date',
            'status' => 'Status',
            'user_id' => 'User ID',
            'updated_ipaddress' => 'Updated Ipaddress',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'engine_number' => 'Engine Number',
            'frame_number' => 'Frame Number',
        ];
    }

    public function afterFind() {
    if(isset($this->driver->id)){   
        $this->driver_name=$this->driver->name;   
    }else{
        $this->driver_name="<a>Not Set </a>";  
    }
     if(isset($this->client->id)){   
        $this->client_name=$this->client->company_name;   
    }else{
        $this->client_name="<a>Not Set </a>";  
    }
    if(isset($this->client->id)){   
        $this->clientname=$this->client->company_name;   
    }else{
        $this->clientname="<a>Not Set </a>";  
    }
}
    public function getDriver()
    {
        return $this->hasOne(DriverProfile::className(), ['id' => 'driver_id']);
    }
    public function getClient()
    {
        return $this->hasOne(ClientMaster::className(), ['id' => 'client_id'])->orderBy(['company_name' => SORT_ASC]);
    }
}
