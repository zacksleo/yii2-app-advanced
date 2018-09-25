<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Chongqing',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => $_ENV['DB_DSN'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => $_ENV['DB_CHARSET'],
            'tablePrefix' => $_ENV['DB_TABLE_PREFIX'],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'formatter' => [
            'sizeFormatBase' => '1048576',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@vendor/zacksleo/yii2-backend/mail',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $_ENV['SMTP_HOST'],
                'username' => $_ENV['SMTP_USER'],
                'password' => $_ENV['SMTP_PASSWORD'],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'user' => 'user.php',
                        'doctor' => 'doctor.php',
                        'common' => 'common.php',
                    ],
                ],
                'zacksleo/yii2/backend/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/zacksleo/yii2-backend/src/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'backend' => 'backend.php',
                    ],
                ],
                'rbac-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@mdm/admin/messages',
                ],
            ],
        ],
    ],
];
