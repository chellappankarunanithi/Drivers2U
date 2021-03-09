<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "general_configuration".
 *
 * @property int $id
 * @property string $config_key
 * @property string $config_value
 * @property string $order_value
 * @property string $created_at
 * @property string $modified_at
 */
class GeneralConfiguration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'general_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'modified_at'], 'safe'],
            [['config_key', 'config_value'], 'safe'],
            [['order_value'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'config_key' => 'Config Key',
            'config_value' => 'Config Value',
            'order_value' => 'Order Value',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        ];
    }
}
