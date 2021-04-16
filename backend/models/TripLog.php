<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_log".
 *
 * @property string $logId
 * @property string $tripId
 * @property string $customerId
 * @property string $tripStatus
 * @property string $tripDetails
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $updatedIpAddress
 */
class TripLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tripId', 'customerId', 'tripStatus', 'tripDetails', 'createdAt', 'updatedAt', 'updatedIpAddress'], 'required'],
            [['tripId', 'customerId'], 'integer'],
            [['tripDetails'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['tripStatus'], 'string', 'max' => 100],
            [['updatedIpAddress'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'logId' => 'Log ID',
            'tripId' => 'Trip ID',
            'customerId' => 'Customer ID',
            'tripStatus' => 'Trip Status',
            'tripDetails' => 'Trip Details',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'updatedIpAddress' => 'Updated Ip Address',
        ];
    }

    function tripLog($input=array()){

        $requestInput = $input; 
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        $field_check=array('apiMethod','tripId','tripStatus');

        $is_error = '';
        foreach ($field_check as $one_key) {
            $key_val =isset($requestInput[$one_key]);
            if ($key_val == '') {
                $is_error = 'yes';
                $is_error_note = $one_key;
                break;
            }
        } 
        if ($is_error == "yes") {
            $list['status'] = 'error';
            $list['message'] = $is_error_note . ' is Mandatory.';
        }else{
            $apiMethod = $requestInput['apiMethod'];
            $tripId = $requestInput['tripId'];
            $tripStatus = $requestInput['tripStatus'];

            $list['message'] = 'Invalid Api method';
           // if($apiMethod=='tripLogSave'){
                $TripDetails = TripDetails::find()->where(['id'=>$tripId])->asArray()->one();
                $list['message'] = 'Trip not found';
                if(!empty($TripDetails)){
                    $newLog = new TripLog();
                    $newLog->tripId = $tripId;
                    $newLog->customerId = $TripDetails['CustomerId'];
                    $newLog->tripStatus = $tripStatus;
                    $newLog->apiMethod = $apiMethod;
                    $newLog->tripDetails = json_encode($TripDetails);
                    $newLog->createdAt = date('Y-m-d H:i:s');
                    $newLog->updatedAt = date('Y-m-d H:i:s');
                    $newLog->updatedIpAddress = $_SERVER['REMOTE_ADDR'];
                    if($newLog->save()){
                        $list['status'] = 'success';
                        $list['message'] = 'Log saved successfully';
                    }else{
                        echo "<pre>";print_r($newLog->getErrors());die;
                    }
                }
            //}
        }
        return $list;

        # For call this function
        /*$requestInput = array();
        $requestInput['tripId'] = $tripId;
        $requestInput['tripStatus'] = $tripStatus;
        $requestInput['apiMethod'] = $apiMethod;

        $callFun = new TripLog();
        $response = $callFun->tripLog($requestInput);*/
    }
}
