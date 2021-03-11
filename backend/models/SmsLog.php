<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sms_log".
 *
 * @property string $logId
 * @property string $tripId
 * @property string $customerId
 * @property string $event
 * @property string $messageContent
 * @property string $driverId
 * @property string $status
 * @property string $timestamp
 */
class SmsLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tripId', 'customerId', 'driverId'], 'integer'],
            [['messageContent'], 'string'],
            [['timestamp'], 'safe'],
            [['event', 'status'], 'string', 'max' => 150],
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
            'event' => 'Event',
            'messageContent' => 'Message Content',
            'driverId' => 'Driver ID',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }

    public function smsfunction($phone, $sms_message="",$requestInput=array()) {
        $phone = "6380744151";
        $sms_message = "Dear Chellappan, you are welcome to the aFynder family as a Shoppee.";
        if($phone!="" && $sms_message!=""){

            $tripId = $customerId = $event = $driverId = "";

            if(!empty($requestInput)){
                if(array_key_exists('tripId', $requestInput)){
                    $tripId = $requestInput['tripId'];
                }if(array_key_exists('customerId', $requestInput)){
                    $customerId = $requestInput['customerId'];
                }if(array_key_exists('driverId', $requestInput)){
                    $driverId = $requestInput['driverId'];
                }if(array_key_exists('event', $requestInput)){
                    $event = $requestInput['event'];
                }
            }
 
            $newLog = new SmsLog();
            $newLog->tripId = $tripId;
            $newLog->customerId = $customerId;
            $newLog->event = $event;
            $newLog->contactNumber = $phone;
            $newLog->messageContent = $sms_message;
            $newLog->driverId = $driverId;
            $newLog->timestamp = date('Y-m-d H:i:s');

            $sms_message = str_replace("&", " and " , $sms_message);
            // $sms_message = str_replace("'", " " , $sms_message);
            $sms_message = str_replace("`", " " , $sms_message);
            //$sms_message = str_replace("?", " " , $sms_message);
            $sms_message = urlencode($sms_message);
            $phone  = "91".substr($phone,(strlen($phone)-10),strlen($phone));
            
            
            // $url="http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?username=e34&password=2342&sendername=23423&mobileno=".$phone."&message=".$sms_message;

            $url="https://api.mylogin.co.in/api/v2/SendSMS?SenderId=FYNDER&Is_Unicode=true&Is_Flash=false&ApiKey=yakcv2Xh%2F5UCgR2FQDShF4zDodTtcOR7%2FB%2B9hs%2BOx48%3D&ClientId=b3afea27-8dd9-44cd-8b54-fde56692f09a&MobileNumbers=".$phone."&Message=".$sms_message;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $status ='error';
            if ($err) {
                $response=false;
            } else {
                $response=true;
                $status ='success';
            }
            $newLog->status = $status;
            if($newLog->save()){

            }else{
                echo "<pre>"; print_r($newLog->getErrors()); die;
            }

        return  $response;
        }      
    }
}
