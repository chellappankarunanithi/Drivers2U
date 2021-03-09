<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers', 
   // 'defaultRoute' => 'site/index',
     'timeZone' => 'Asia/Kolkata',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Frontend',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
            ]
        ],
        'session' => [
            'name' => 'Swim987963frontend',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sdfafsdsd',
            'csrfParam' => '_frontendCSRF',
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
     
      'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [            	
                'login' => 'login-api/login',
                'trip-login' => 'login-api/trip-login',
                /*'trip-logout' => 'login-api/trip-logout',*/
                'coupon-report'   => 'login-api/coupon-report',
                'sms-send'        => 'login-api/sms-send',
                'otp-send'        => 'login-api/otp-send',
                'otp-verify'      => 'login-api/otp-verify',

                    /*******          customer-api            ********/

                'bunk-list'      => 'customer-api/bunk-list',
                'vehicle-list'   =>'customer-api/vehicle-list',
                'driver-list'    =>'customer-api/driver-list',
                'client-list'    =>'customer-api/client-list',
                'supervisor-list'=>'customer-api/supervisor-list',
                'coupon-list'    =>'customer-api/coupon-list',
                'refuel-list'    =>'customer-api/refuel-list',
                'coupon-generate'=>'customer-api/coupon-generate',
                'coupon-close'   =>'customer-api/coupon-close',
                'trip-logout' => 'customer-api/trip-logout',
                
//'news/<id:\w+>' => 'newslisting/index', 
                'trip-list'=>'trip-api/trip-list',
                'trip-list-close'=>'trip-api/trip-list-close',
                'trip-ride'=>'trip-api/trip-ride',
                'trip-details'=>'trip-api/trip-details',
                'trip-expenses'=>'trip-api/trip-expenses',

				
            ],  
        ],
        
    ],
    'params' => $params,
];
