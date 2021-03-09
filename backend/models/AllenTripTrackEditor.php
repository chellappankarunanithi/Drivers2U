<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "allen_trip_track".
 *
 * @property string $id
 * @property string $trip_id
 * @property string $customer_id
 * @property string $trip_start_time
 * @property string $trip_end_time
 * @property string $enter_starting_km
 * @property string $enter_close_km
 * @property string $start_trip
 * @property string $close_trip
 * @property string $expenses_1
 * @property string $expenses_2
 * @property string $expenses_3
 * @property double $expenses_1_amt
 * @property double $expenses_2_amt
 * @property double $expenses_3_amt
 * @property string $digital_signature
 * @property string $status
 * @property string $trip_status "D"="DEFAULT","S"="START","H"="HOLD","R"="RESTART","C"="CLOSE"
 * @property string $created_at
 * @property string $modified_at
 * @property string $updated_ipaddress
 * @property string $device_name
 * @property string $driver_name
 * @property string $vehicle_number
 */
class AllenTripTrackEditor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allen_trip_track_editor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trip_start_time', 'trip_end_time', 'enter_starting_km', 'enter_close_km'], 'safe'],
            [['trip_start_time', 'trip_end_time', 'created_at', 'modified_at'], 'safe'],
            [['enter_starting_km', 'enter_close_km'], 'integer'],
            [['expenses_1_amt', 'expenses_2_amt', 'expenses_3_amt'], 'number'],
            [['digital_signature', 'status', 'trip_status'], 'string'],
            [['trip_id', 'customer_id', 'start_trip', 'close_trip', 'driver_name', 'vehicle_number'], 'safe'],
            [['expenses_1', 'expenses_2', 'expenses_3','expenses_1_file','expenses_2_file','expenses_3_file', 'updated_ipaddress', 'device_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trip_id' => 'Trip ID',
            'customer_id' => 'Customer ID',
            'trip_start_time' => 'Trip Start Time',
            'trip_end_time' => 'Trip End Time',
            'enter_starting_km' => 'Enter Starting Km',
            'enter_close_km' => 'Enter Close Km',
            'start_trip' => 'Start Trip',
            'close_trip' => 'Close Trip',
            'expenses_1' => 'Expenses 1',
            'expenses_2' => 'Expenses 2',
            'expenses_3' => 'Expenses 3',
            'expenses_1_file' => 'Expenses 1 File',
            'expenses_2_file' => 'Expenses 2 File',
            'expenses_3_file' => 'Expenses 3 File',
            'expenses_1_amt' => 'Expenses 1 Amt',
            'expenses_2_amt' => 'Expenses 2 Amt',
            'expenses_3_amt' => 'Expenses 3 Amt',
            'digital_signature' => 'Digital Signature',
            'status' => 'Status',
            'trip_status' => 'Trip Status',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'device_name' => 'Device Name',
            'driver_name' => 'Driver Name',
            'vehicle_number' => 'Vehicle Number',
        ];
    }


    public function logsave($input=array())
    {

        $track_id="";
        $trip_id="";
        $customer_id="";
        $trip_start_time="";
        $trip_end_time="";
        $enter_starting_km="0";
        $enter_close_km="0";
        $start_trip="";
        $close_trip="";
        $expenses_1="";
        $expenses_2="";
        $expenses_3="";
        $expenses_1_file="";
        $expenses_2_file="";
        $expenses_3_file="";
        $expenses_1_amt="0";
        $expenses_2_amt="0";
        $expenses_3_amt="0";
        $digital_signature="";
        $status="";
        $trip_status="";
        $created_at="";
        $modified_at="";
        $updated_ipaddress="";
        $device_name="";
        $driver_name="";
        $vehicle_number=""; 

        if(array_key_exists('id', $input) && $input['id']!="" )
        {
            $track_id = $input['id'];
        }
         if(array_key_exists('trip_id', $input) && $input['trip_id']!="" )
        {
            $trip_id = $input['trip_id'];
        }
         if(array_key_exists('customer_id', $input) && $input['customer_id']!="" )
        {
            $customer_id = $input['customer_id'];
        }
         if(array_key_exists('trip_start_time', $input) && $input['trip_start_time']!="" )
        {
            $trip_start_time = $input['trip_start_time'];
        }
         if(array_key_exists('trip_end_time', $input) && $input['trip_end_time']!="" )
        {
            $trip_end_time = $input['trip_end_time'];
        }
         if(array_key_exists('enter_starting_km', $input) && $input['enter_starting_km']!="" )
        {
            $enter_starting_km = $input['enter_starting_km'];
        }
         if(array_key_exists('enter_close_km', $input) && $input['enter_close_km']!="" )
        {
            $enter_close_km = $input['enter_close_km'];
        }
         if(array_key_exists('start_trip', $input) && $input['start_trip']!="" )
        {
            $start_trip = $input['start_trip'];
        }
         if(array_key_exists('close_trip', $input) && $input['close_trip']!="" )
        {
            $close_trip = $input['close_trip'];
        }
         if(array_key_exists('id', $input) && $input['id']!="" )
        {
            $track_id = $input['id'];
        }
         if(array_key_exists('expenses_1', $input) && $input['expenses_1']!="" )
        {
            $expenses_1 = $input['expenses_1'];
        }
         if(array_key_exists('expenses_2', $input) && $input['expenses_2']!="" )
        {
            $expenses_2 = $input['expenses_2'];
        }
         if(array_key_exists('expenses_3', $input) && $input['expenses_3']!="" )
        {
            $expenses_3 = $input['expenses_3'];
        }
        if(array_key_exists('expenses_1_file', $input) && $input['expenses_1_file']!="" )
        {
            $expenses_1_file = $input['expenses_1_file'];
        }
        if(array_key_exists('expenses_2_file', $input) && $input['expenses_2_file']!="" )
        {
            $expenses_2_file = $input['expenses_2_file'];
        }
        if(array_key_exists('expenses_3_file', $input) && $input['expenses_3_file']!="" )
        {
            $expenses_1_file = $input['expenses_3_file'];
        }
         if(array_key_exists('expenses_1_amt', $input) && $input['expenses_1_amt']!="" )
        {
            $expenses_1_amt = $input['expenses_1_amt'];
        }
         if(array_key_exists('expenses_2_amt', $input) && $input['expenses_2_amt']!="" )
        {
            $expenses_2_amt = $input['expenses_2_amt'];
        }
         if(array_key_exists('expenses_3_amt', $input) && $input['expenses_3_amt']!="" )
        {
            $track_id = $input['expenses_3_amt'];
        }
         if(array_key_exists('digital_signature', $input) && $input['digital_signature']!="" )
        {
            $digital_signature = $input['digital_signature'];
        }
         if(array_key_exists('status', $input) && $input['status']!="" )
        {
            $status = $input['status'];
        }
         if(array_key_exists('trip_status', $input) && $input['trip_status']!="" )
        {
            $trip_status = $input['trip_status'];
        }
         if(array_key_exists('created_at', $input) && $input['created_at']!="" )
        {
            $created_at = $input['created_at'];
        }
         if(array_key_exists('modified_at', $input) && $input['modified_at']!="" )
        {
            $modified_at = $input['modified_at'];
        } 
         if(array_key_exists('updated_ipaddress', $input) && $input['updated_ipaddress']!="" )
        {
            $updated_ipaddress = $input['updated_ipaddress'];
        } 
         if(array_key_exists('device_name', $input) && $input['device_name']!="" )
        {
            $device_name = $input['device_name'];
        }
         if(array_key_exists('driver_name', $input) && $input['driver_name']!="" )
        {
            $driver_name = $input['driver_name'];
        } 
        if(array_key_exists('vehicle_number', $input) && $input['vehicle_number']!="" )
        {
            $vehicle_number = $input['vehicle_number'];
        }

      
        $model = new AllenTripTrackLog();

        $model->trip_track_id  = $track_id;
        $model->trip_id  = $trip_id;
        $model->customer_id  = $customer_id;
        $model->trip_start_time  = $trip_start_time;
        $model->trip_end_time  = $trip_end_time;
        $model->enter_starting_km  = $enter_starting_km;
        $model->enter_close_km  = $enter_close_km;
        $model->start_trip  = $start_trip;
        $model->close_trip  = $close_trip;
        $model->expenses_1  = $expenses_1;
        $model->expenses_2  = $expenses_2;
        $model->expenses_3  = $expenses_3;
        $model->expenses_1_file = $expenses_1_file;
        $model->expenses_2_file = $expenses_2_file;
        $model->expenses_3_file = $expenses_3_file;
        $model->expenses_1_amt  = $expenses_1_amt;
        $model->expenses_2_amt  = $expenses_2_amt;
        $model->expenses_3_amt  = $expenses_3_amt;
        $model->digital_signature  = $digital_signature;
        $model->status  = $status;
        $model->trip_status  = $trip_status;
        $model->created_at  = $created_at;
        $model->modified_at  = date('Y-m-d H:i:s');
        $model->updated_ipaddress  = $updated_ipaddress;
        $model->device_name  = $device_name;
        $model->driver_name  = $driver_name;
        $model->vehicle_number  = $vehicle_number;
        if($model->save())
        {
            return "success";
        }else{  
            //echo "<pre>"; print_r($model->getErrors()); die;
            return "failure";
        }
   


    }
}
