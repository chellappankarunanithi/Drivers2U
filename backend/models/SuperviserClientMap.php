<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "superviser_client_map".
 *
 * @property string $id
 * @property string $superviser_name
 * @property string $client_name
 * @property string $created_at
 * @property string $modified_at
 * @property string $updated_ipaddress
 */
class SuperviserClientMap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'superviser_client_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'modified_at'], 'safe'],
            [['updated_ipaddress','superviser_name', 'client_name'], 'safe'],
           // [['updated_ipaddress'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'superviser_name' => 'Superviser Name',
            'client_name' => 'Client Name',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'updated_ipaddress' => 'Updated Ipaddress',
        ];
    }
}
