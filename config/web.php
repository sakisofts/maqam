<?php

use yii\helpers\Url;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$pk = dirname(__DIR__) . '/config/keys/airtel_public.pem';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',
        [
            'class' => 'app\components\behaviors\AuthRedirectBehavior',
            'redirectController' => 'landing',
            'redirectAction' => 'login',
            'excludeControllers' => ['api', 'landing'],
        ],
        ],
    'name'=> 'sakisofts',
    'defaultRoute' => 'site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'L47DDQvcD21IPpEU6Cv1lMjpc6VXoH7U',
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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
        'httpclient' => [
            'class' => 'yii\httpclient\Client',
        ],
        'airtelMoney' => [
            'class' => 'app\components\payments\AirtelMoneyService',
//            'baseUrl' => 'https://openapi.airtel.africa',
            'baseUrl' => 'https://openapiuat.airtel.ug',
            'clientId' => '987c2bd9-a8a5-4027-9188-e7d4aa5dcd2e',
            'clientSecret' => '8ad6dba0-1ca2-49aa-8fcc-0e24a0238dad',
            'countryCode' => 'UG',
            'currencyCode' => 'Ugx',
            'pin' => '',
            'merchantName' => 'BW0GG0QZ',
        ],
        'airtelAuth' => [
            'class' => 'app\components\payments\AirtelAuth',
            'clientId' => '987c2bd9-a8a5-4027-9188-e7d4aa5dcd2e',
            'clientSecret' => '8ad6dba0-1ca2-49aa-8fcc-0e24a0238dad',
            'env' => 'staging', // or 'production'
        ],
        'transactionService' => [
            'class' => 'app\components\payments\TransactionService',
        ],
        'airtelApi' => [
            'class' => 'app\components\payments\AirtelApi',
//            'baseUrl' => 'https://openapiuat.airtel.africa/', // Change to production when live
            'baseUrl' => 'https://openapiuat.airtel.ug', // Change to production when live
            'clientId' => '987c2bd9-a8a5-4027-9188-e7d4aa5dcd2e',
            'clientSecret' => '8ad6dba0-1ca2-49aa-8fcc-0e24a0238dad',
            'countryCode' => 'UG',
            'currencyCode' => 'UGX',
            'publicKeyPath' => $pk,
            'env' => 'staging', // or 'production'
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
//                \yii\bootstrap5\BootstrapAsset::class => true,
            ]
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
