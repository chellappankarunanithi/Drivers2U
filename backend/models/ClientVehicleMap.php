<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_vehicle_map".
 *
 * @property int $id
 * @property string $vehicle_id
 * @property string $client_id
 * @property string $vehicle_status
 * @property string $assign_date
 * @property string $remove_date
 * @property string $created_at
 * @property string $updated_ipaddress
 * @property string $user_id
 * @property string $updated_at
 */
class ClientVehicleMap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_vehicle_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_status'], 'required'],
             
            [['vehicle_id', 'client_id', 'user_id','assign_date', 'remove_date', 'created_at','vehicle_status', 'updated_at'], 'safe'],
            //[['vehicle_id', 'client_id', 'user_id'], 'string', 'max' => 100],
            [['updated_ipaddress'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_id' => 'Vehicle ID',
            'client_id' => 'Client ID',
            'vehicle_status' => 'Vehicle Status',
            'assign_date' => 'Assign Date',
            'remove_date' => 'Remove Date',
            'created_at' => 'Created At',
            'updated_ipaddress' => 'Updated Ipaddress',
            'user_id' => 'User ID',
            'updated_at' => 'Updated At',
        ];
    }
}
