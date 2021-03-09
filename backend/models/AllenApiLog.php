<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "allen_api_log".
 *
 * @property string $autoid
 * @property int $branch_id
 * @property string $event_key
 * @property string $data
 * @property string $event
 * @property string $response
 * @property string $created_at
 */
class AllenApiLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allen_api_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at','event','data', 'response','branch_id'], 'safe'], 
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'autoid' => 'Autoid',
            'branch_id' => 'Branch ID',
            'event_key' => 'Event Key',
            'data' => 'Data',
            'event' => 'Event',
            'response' => 'Response',
            'created_at' => 'Created At',
        ];
    }
}
