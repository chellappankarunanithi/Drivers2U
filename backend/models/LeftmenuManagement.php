<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "leftmenu_management".
 *
 * @property int $menuId
 * @property string $menuTpe
 * @property string $Name
 * @property string $userUrl
 * @property int $groupId
 * @property string $groupCode
 * @property int $sortOrder
 * @property string $faIcon
 * @property string $activeStatus
 * @property string $createdAt
 * @property string $updatedAt
 */
class LeftmenuManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leftmenu_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menuTpe', 'Name', 'faIcon'], 'required'],
            [['menuTpe', 'activeStatus'], 'string'],
            [['groupId', 'sortOrder'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['Name', 'userUrl', 'groupCode', 'faIcon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menuId' => 'Menu ID',
            'menuTpe' => 'Menu Type',
            'Name' => 'Name',
            'userUrl' => 'User Url',
            'groupId' => 'Group',
            'groupCode' => 'Group Code',
            'sortOrder' => 'Sort Order',
            'faIcon' => 'Fa Icon',
            'activeStatus' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
