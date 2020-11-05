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
	'language' => 'en',
	'timeZone' => 'Asia/Yekaterinburg',
//	'controllerNamespace' => 'app\controllers\json',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dgdgdgdf888###sdf@#FFFfffff&&&@@!MMKMMKlmkmklfdlgdlfkgklfd',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],
            /*'csrfParam' => '_basicCSRF', // Modified params
            'csrfCookie' => [
                'httpOnly' => true,
                'path' => '/backend',
            ],*/
   //         'enableCsrfValidation' => false,
		],
		'assetManager' => [
            'appendTimestamp' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
//			'defaultRoles' => ['guest'],
			'defaultRoles' => ['admin', 'BRAND', 'TALENT'], // 
		],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
       /*  'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
			'traceLevel' =>0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
//					'logVars' => [], // don't log global vars 
					'logFile' => '@app/runtime/logs/'.date("Y").'/'.date("m").'/'.date("d").'.log',
                ],
            ],
        ], */
		'log' => [
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning','info'],
					'logVars' => [], // don't log global vars 
                ],
               /*  'db' => [
                    'class' => 'yii\log\DbTarget',
                ], */
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
			'baseUrl' => '/basic/web',
			'scriptUrl'=>'/basic/web/index.php',
			'rules' => [
				[
					'pattern' => 'product',
					'route' => 'product/index',
					'suffix' => '/',
//					'normalizer' => false, // disable normalizer for this rule
				],				
				['class' => 'yii\rest\UrlRule', 'controller' => 'customers'],
//				'class' => 'yii\web\UrlRule',
				[
					'class' => 'app\components\NewsUrlRule',
				],
				[
					'pattern' => 'categories',
					'route' => 'product-categories/index',
					'suffix' => '/',
//					'normalizer' => false, // disable normalizer for this rule
				],
				[
					'pattern' => 'product-admin',
					'route' => 'product-admin/index',
					'suffix' => '/',
//					'normalizer' => false, // disable normalizer for this rule
				],	
				[
					'class' => 'app\components\CategoryUrlRule',					
				],
				[
					'class' => 'app\components\ProductUrlRule',					
				],
				[
					'class' => 'app\components\ProductAdminUrlRule',					
				],
                'json/<controller:[A-Za-z0-9 -_.]+>/<action:\w+>/<id:\d+>' => 'json/<controller>/<action>',
				
			/* 	[
					'pattern' => 'json/<controller:\w+>/<action>/<id:\d+>',
					'route' => 'json/<controller>/<action>',
//					'defaults' => ['controller' => 'user']
				], */
				/* [
					'class' => 'app\components\CustomerUrlRule',
				], */
				/* [
					'pattern' => 'news/items-list/<category:\w+>',
					'route' => 'news/items-list',
					'defaults' => ['category' => 'shopping']
				], */
				/* [
					'pattern' => 'product-categories/view/<category_id:\w+>',
					'route' => 'product-categories/view',
					'defaults' => ['category_id' => 0]
				],	 */			
//				'class'=>'yii\filters\AccessRule',
//				'<controller>/<year:\d{4}>/<action>' => ' <controller>/<action>',
//				'<view:(break)>' => 'site/page',
				/* '<controller:static>/<view:.*>' => '<controller>',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',*/
//				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//				'<path:\w+>/<controller:\w+>/<action:\w+>'=>'<path>/<controller>/<action>',
//				'json/<controller:[A-Za-z0-9 -_.]+>/<action:\w+>/<id:\d+>' => 'json/<controller>/<action>',
//				 'json/<view:\S+>' => 'site/page',
//				'news/<year:\d{4}/>' => ' news/items-list?year=<year>',
//				'news/<category:\w+>/items-list' => 'test-rules/items-list',
//				'debug/<controller>/<action>' => 'debug/<controller>/<action>',
			],			
        ],
		'view' => [
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],

		
        
    ],
//    'modules' => [
//        'debug' => [
//            'class' => 'yii\debug\Module',
            // uncomment and adjust the following to add your IP if you are not connecting from localhost.
//            'allowedIPs' => ['127.0.0.1', '::1','192.168.1.2'],
//        ],
        // ...
//    ],
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
        'allowedIPs' => ['127.0.0.1', '::1','192.168.1.3','192.168.1.11','192.168.1.10','192.168.1.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.1.3','192.168.1.10','192.168.1.2'],
    ];
}

return $config;
