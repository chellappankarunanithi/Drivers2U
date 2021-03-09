<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "integrated_function_menu_mapping".
 *
 * @property int $autoId
 * @property string $url
 * @property int $groupId
 * @property int $menuId
 * @property string $createdAt
 * @property string $updatedAt
 */
class IntegratedFunctionMenuMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integrated_function_menu_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'menuId'], 'required'],
            [['url'], 'string'],
            [['groupId', 'menuId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoId' => 'Auto ID',
            'url' => 'Url',
            'groupId' => 'Group ID',
            'menuId' => 'Menu ID',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
