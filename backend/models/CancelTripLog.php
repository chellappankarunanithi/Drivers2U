<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cancel_trip_log".
 *
 * @property string $id
 * @property string $TripId
 * @property string $CustomerId
 * @property string $DriverId
 * @property double $CancelFees
 * @property string $CancelReason
 * @property string $PaymentStatus
 * @property string $CreatedDate
 * @property string $UpdatedIpaddress
 * @property string $UpdatedDate
 */
class CancelTripLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cancel_trip_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CancelFees'], 'safe'],
            [['CancelReason'], 'safe'],
            [['CreatedDate', 'UpdatedDate'], 'safe'],
            [['TripId', 'CustomerId', 'DriverId', 'PaymentStatus'], 'safe'],
            [['UpdatedIpaddress'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'TripId' => 'Trip ID',
            'CustomerId' => 'Customer Name',
            'DriverId' => 'Driver Name',
            'CancelFees' => 'Cancel Fees',
            'CancelReason' => 'Cancel Reason',
            'PaymentStatus' => 'Payment Status',
            'CreatedDate' => 'Created Date',
            'UpdatedIpaddress' => 'Updated Ipaddress',
            'UpdatedDate' => 'Updated Date',
        ];
    }
}
