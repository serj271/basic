<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'timeZone' => 'Asia/Yekaterinburg',
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [
			 'class' => 'yii\rbac\DbManager',
		],
        'log' => [
            'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'logFile' => '@app/runtime/logs/'.date("Y").'/'.date("m").'/'.date("d").'.log',
					'levels' => ['error', 'warning', 'info'],
					'logVars' => [], // don't log global vars
				],
			],
        ],
        'db' => $db,
		'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
			'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'session' => [ // for use session in console application
            'class' => 'yii\web\Session'
        ],
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
				[
					'class' => 'app\components\JsonUrlRule',					
				],
			]
		]
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'mg_migration',
            'templateFile' => '@app/migrations/templates/mg.php'
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
	$config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1','192.168.1.3','192.168.1.11','192.168.1.10','192.168.1.2'],
    ];
}

return $config;
