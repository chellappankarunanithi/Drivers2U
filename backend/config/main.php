<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
use yii\helpers\Url;


    
$baseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl());
 $server = $_SERVER['SERVER_NAME']; 
        if ($server=="192.168.1.114") {
            $url = '/2021/drives2u';
        }else{
            $url = '/drives2u';
        }
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','MyGlobalClass'],
    'modules' => [],
    'timeZone' => 'Asia/Kolkata',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
    'session' => [
            'name' => 'drives2usession',
            'timeout' => 1440,       
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'authTimeout' => 3600,
        ],
        'MyGlobalClass'=>[
            'class'=>'backend\components\MyGlobalClass'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'request'=>[

            'class' => 'common\components\Request',

            'web'=> '/backend/web',

            'adminUrl' => '/admin', 
            'baseUrl' => $url, 

        ],
       
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'home' => 'site/login',
                'index' => 'site/index',
                'customer-management' => 'client-master/index',
                'customer-c'          => 'client-master/create',
                'customer-trip-create/<id:\d+>'=> 'client-master/customer-trip-create',
                'customer-u/<id:\d+>' => 'client-master/update',
                'customer-v/<id:\d+>' => 'client-master/view',
                'customer-d/<id:\d+>' => 'client-master/delete', 
                'customer-otp/<id:\d+>/<data:\d+>' => 'client-master/customer-otp', 

                'commission-management' => 'commission-master/index',
                'commission-c'          => 'commission-master/create',
                'commission-u/<id:\d+>' => 'commission-master/update',
               // 'customer-v/<id:\d+>' => 'commission-master/view',
              //  'customer-d/<id:\d+>' => 'commission-master/delete',

                # Menu Management 
                # Jana
                # 04-03-2021 11:37 AM

                'menu-mng' => 'leftmenu-management/index',
                'menu-mng-c' => 'leftmenu-management/create',
                'menu-mng-u/<id:\d+>' => 'leftmenu-management/update',
                'menu-mng-e/<id:\d+>' => 'leftmenu-management/edit',
                'menu-mng-d/<id:\d+>' => 'leftmenu-management/delete',


                'driver-management' => 'driver-profile/driver-management',
                'unavailable-driver-management' => 'driver-profile/unavailable-driver-management',
               // 'driver-management' => 'driver-profile/index',
                'driver-c'          => 'driver-profile/create',
                'driver-u/<id:\d+>' => 'driver-profile/update',
                'driver-v/<id:\d+>' => 'driver-profile/view',
                'driver-d/<id:\d+>' => 'driver-profile/delete',
                'aadhar/<id:\d+>' => 'driver-profile/aadhar',
                'licence/<id:\d+>' => 'driver-profile/licence',
                'voterid/<id:\d+>' => 'driver-profile/voterid',
                'rationcard/<id:\d+>' => 'driver-profile/rationcard',
                'policeverification/<id:\d+>' => 'driver-profile/policeverification',
                'profile/<id:\d+>' => 'driver-profile/profile',


                'trip-index'    => 'trip-details/trip-index',
                'trip-c'          => 'trip-details/create',
                'trip-c/<id:\d+>/<data:\d+>' => 'trip-details/create',
                'trip-u/<id:\d+>' => 'trip-details/update',
                'trip-v/<id:\d+>' => 'trip-details/view',
                'trip-d/<id:\d+>' => 'trip-details/delete',
                'get-customer' => 'trip-details/get-customer',
                'get-driver' => 'trip-details/get-driver',
                'get-vehicle' => 'trip-details/get-vehicle',
                'create-index' => 'trip-details/create-index',
                'active-index' => 'trip-details/active-index',
                'complete-index' => 'trip-details/complete-index',
                'cancel-index' => 'trip-details/cancel-index',
                'activate/<id:\d+>' => 'trip-details/activate',
                'cancel/<id:\d+>' => 'trip-details/cancel',
                'cancel-payment/<id:\d+>' => 'trip-details/cancel-payment',
                'complete/<id:\d+>' => 'trip-details/complete',
                'otpsave/<id:\d+>' => 'trip-details/otpsave',
                'otpverification' => 'trip-details/otpverification',
                'response/<id:\d+>' => 'trip-details/response',
                'change-trip/<id:\d+>/<data:\d+>' => 'trip-details/change-trip',
                'change-trip/<id:\d+>' => 'trip-details/change-trip',
                'trip-rating/<id:\d+>' => 'trip-details/trip-rating',

                'card-list/<id:\d+>' => 'vehicle-master/index',

            ],
        ],
        
    ],
    'params' => $params,
];
