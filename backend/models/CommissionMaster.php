<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "commission_master".
 *
 * @property string $id
 * @property string $CommissionValue
 * @property string $Status
 * @property string $CreatedDate
 * @property string $UpdatedDate
 */
class CommissionMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $hidden_Input;
    public static function tableName()
    {
        return 'commission_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             
            [['CreatedDate', 'UpdatedDate'], 'safe'],
            [['CommissionValue','Status'], 'required'],
            [['CommissionValue'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'CommissionValue' => 'Commission Value %',
            'Status' => 'Status',
            'CreatedDate' => 'Created Date',
            'UpdatedDate' => 'Updated Date',
        ];
    }
}
