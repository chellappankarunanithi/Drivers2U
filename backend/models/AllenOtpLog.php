<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "allen_otp_log".
 *
 * @property string $id
 * @property string $mobile_number
 * @property string $vehicle_number
 * @property string $mobile_model
 * @property string $otp_number
 * @property string $created_at
 * @property string $modified_at
 */
class AllenOtpLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allen_otp_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id'], 'required'],
            [['id', 'otp_number'], 'safe'],
            [['created_at', 'modified_at'], 'safe'],
            [['mobile_number', 'vehicle_number'], 'safe'],
            [['mobile_model'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile_number' => 'Mobile Number',
            'vehicle_number' => 'Vehicle Number',
            'mobile_model' => 'Mobile Model',
            'otp_number' => 'Otp Number',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
}
