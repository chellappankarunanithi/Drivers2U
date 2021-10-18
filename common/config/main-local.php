<?php $server = $_SERVER['SERVER_NAME']; 
if ($server=="192.168.1.54") {
return [
    'components' => [ 
            'db' => [ 
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost;dbname=drivers2udb',
                    'username' => 'root',
                    'password' => '1st',
                    'charset' => 'utf8', 
            ], 
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
}else{
    return [
    'components' => [ 
            'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost;dbname=isofficial_drivers2u',
                    'username' => 'isofficial_drivers2u',
                    'password' => 'zwYdGyQmK',
                    'charset' => 'utf8', 
            ],
         
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];

}