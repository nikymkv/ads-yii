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
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'J7XQSEXQOH-Uf4xAFM3Y3xfrvLmju1xI',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
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
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // 'http://admin.ads-yii.loc/' => '/Admin/moderator/index',
                // 'GET http://admin.ads-yii.loc/login' => '/Admin/Auth/auth/get-login-form',
                // 'POST http://admin.ads-yii.loc/login' => '/Admin/Auth/auth/login',
                // 'POST http://admin.ads-yii.loc/logout' => '/Admin/Auth/auth/logout',

                // 'POST http://admin.ads-yii.loc/ads/<id:\d+>/moderate' => '/Admin/moderator/moderate',

                'GET http://<module:admin>.ads-yii.loc/' => '<module>/moderator/index',
                'GET http://<module:admin>.ads-yii.loc/login' => '<module>/Auth/auth/get-login-form',
                'POST http://<module:admin>.ads-yii.loc/login' => '<module>/Auth/auth/login',
                'POST http://<module:admin>.ads-yii.loc/logout' => '<module>/Auth/auth/logout',

                'POST http://<module:admin>.ads-yii.loc/ads/<id:\d+>/moderate' => '<module>/moderator/moderate',

                'GET /' => 'site/index',
                'GET <id:\d+>' => 'site/view',

                'GET /categories/stat' => 'site/categories-stat',

                'GET cities/by-location/<id:\d+>' => 'city/get-by-location-id',
                'GET subcategories/by-category/<id:\d+>' => 'category/get-by-parent-id',

                'POST ads/rate' => 'User/user-ad/rate',
                'GET ads/create' => 'User/user-ad/create',
                'POST ads/create' => 'User/user-ad/create',
                'GET ads/by-user/<id:\d+>' => 'site/get-ads-by-user',
                'GET ads/<id:\d+>/edit' => 'User/user-ad/edit',
                'POST ads/<id:\d+>/update' => 'User/user-ad/update',

                'GET account' => 'User/account/index',
                'GET account/settings' => 'User/account/get-settings',
                'POST account/settings' => 'User/account/save-settings',
                'POST account/settings/password' => 'User/account/save-password',

                'GET login' => '/User/Auth/login/get-login-form',
                'POST login' => '/User/Auth/login/login',
                'GET register' => '/User/Auth/register/get-register-form',
                'POST register' => '/User/Auth/register/register',
                'POST logout' => '/User/Auth/login/logout',


                '<module:gii>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],
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
