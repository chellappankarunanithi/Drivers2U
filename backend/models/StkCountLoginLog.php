<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stk_count_login_log".
 *
 * @property string $id
 * @property string $login_username
 * @property string $allow_status
 * @property string $login_time
 * @property string $logout_time
 * @property string $created_at
 * @property string $updated_at
 */
class StkCountLoginLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stk_count_login_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allow_status'], 'string'],
            [['login_time', 'logout_time', 'created_at', 'updated_at'], 'safe'],
            [['login_username'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login_username' => 'Login Username',
            'allow_status' => 'Allow Status',
            'login_time' => 'Login Time',
            'logout_time' => 'Logout Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
