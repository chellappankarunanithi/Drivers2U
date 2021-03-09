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
class VehicleMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
  
    public static function tableName()
    {
        return 'vehicle_master';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['fc_expire_date', 'created_at', 'modified_at','vehicle_uniqe_name', 'updated_ipaddress', 'engine_number', 'frame_number','status','user_id'], 'safe'],
            [['fc_expire_date','reg_no','vehicle_name','ins_expired_date'], 'safe'], 
            
        ];
    }

       

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_name' => 'Vehicle Type',
            'vehicle_uniqe_name' => 'Vehicle Made',
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

 
}
