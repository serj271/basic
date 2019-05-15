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
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
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
}

return $config;
