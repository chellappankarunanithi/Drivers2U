<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coupon_list".
 *
 * @property integer $id
 * @property string $vehicle_id
 * @property string $bunk_id
 * @property string $supervisor_id
 * @property string $driver_id
 * @property string $coupon_number
 * @property string $amount
 * @property string $coupon_status
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_id
 * @property string $updated_ipaddress
 */
class CouponList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','vehicle_id', 'bunk_id', 'supervisor_id', 'driver_id', 'user_id','coupon_number', 'amount', 'coupon_status', 'updated_ipaddress'], 'safe'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_id' => 'Vehicle ID',
            'bunk_id' => 'Bunk ID',
            'supervisor_id' => 'Supervisor ID',
            'driver_id' => 'Driver ID',
            'coupon_number' => 'Coupon Number',
            'amount' => 'Amount',
            'coupon_status' => 'Coupon Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'updated_ipaddress' => 'Updated Ipaddress',
        ];
    }

    public function couponsave($models)
    {   
        $session = Yii::$app->session;
        $model = new CouponList();
        $model->vehicle_id =$models['vehicle_name'];
        $model->bunk_id =$models['vehicle_name'];
        $model->supervisor_id =$models['superviser_id']; 
        $model->coupon_number =$models['coupon_code'];
        $model->amount =$models['coupon_amount'];
        $model->coupon_status =$models['coupon_status'];
        $model->created_at =date('Y-m-d H:i:s'); 
        $model->user_id =$session['user_id'];
        $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
        if($model->save()){

        }else{
            echo "<pre>"; print_r($model->getErrors()); die;
        }



    }
     public function couponclose($models)
    {   
        $session = Yii::$app->session;
        $model = CouponList::find()->where(['coupon_number'=>$models['coupon_code']])->one();
        if($model){
        $model->vehicle_id =$models['vehicle_name'];
        $model->bunk_id =$models['vehicle_name'];
        $model->supervisor_id =$models['superviser_id']; 
        $model->coupon_number =$models['coupon_code'];
        $model->refuel_amount =$models['refuel_amount'];
        $model->coupon_status =$models['coupon_status'];
        $model->refuel_date =date('Y-m-d H:i:s'); 
        $model->user_id =$session['user_id'];
        $model->updated_ipaddress =$_SERVER['REMOTE_ADDR'];
        if($model->save()){

        }else{
            echo "<pre>"; print_r($model->getErrors()); die;
        }
    }


    }
}
