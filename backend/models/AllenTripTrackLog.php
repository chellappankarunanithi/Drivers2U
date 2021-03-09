<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "allen_trip_track_log".
 *
 * @property string $id
 * @property string $trip_track_id
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
class AllenTripTrackLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allen_trip_track_log';
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
            [['trip_track_id', 'trip_id', 'customer_id', 'start_trip', 'close_trip', 'driver_name', 'vehicle_number'], 'string', 'max' => 100],
            [['expenses_1', 'expenses_2', 'expenses_3', 'updated_ipaddress', 'device_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trip_track_id' => 'Trip Track ID',
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
}
