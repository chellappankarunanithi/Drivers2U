<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vehicledriver_assignlog".
 *
 * @property string $id
 * @property string $vehicle_id
 * @property string $driver_id
 * @property string $driver_status
 * @property string $vehicle_status
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 * @property string $user_id
 * @property string $updated_ipaddress
 */
class VehicledriverAssignlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicledriver_assignlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicle_id', 'driver_id', 'user_id','created_at', 'modified_at','driver_status', 'vehicle_status', 'status','updated_ipaddress'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_id' => 'Vehicle ID',
            'driver_id' => 'Driver ID',
            'driver_status' => 'Driver Status',
            'vehicle_status' => 'Vehicle Status',
            'status' => 'Status',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'user_id' => 'User ID',
            'updated_ipaddress' => 'Updated Ipaddress',
        ];
    }
}
