<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'timeZone' => 'Asia/Yekaterinburg',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dgdgdgdf888###sdf@#FFFfffff&&&@@!MMKMMKlmkmklfdlgdlfkgklfd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
//			'traceLevel' =>0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                ],
            ],
        ],
		'security' => [
			'passwordHashStrategy' => 'password_hash'
		],
        'db' => $db,
		'class' => 'yii\web\UrlManager',
        'urlManager' => [
			'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//			'baseUrl' => '/',

            'rules' => [
//				'class' => 'yii\web\UrlRule',
				[
				'class' => 'app\components\NewsUrlRule',
				'pattern' => 'news/<year:\d{4}>/items-list', 'route' => 'site/index'
				],				
//				'class'=>'yii\filters\AccessRule',
//				'<controller>/<year:\d{4}>/<action>' => ' <controller>/<action>',
//				'news/<year:\d{4}>/items-list' => ' news/items-list?year=<year>',
//				'news/<category:\w+>/items-list' => 'test-rules/items-list',
            ],
			
        ],
		
        
    ],
	/* 'modules' => [
		'manager' => [
			'class' => 'manager\Module',
		],
	], */
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.1.3','192.168.1.11'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.1.3'],
    ];
}

return $config;
