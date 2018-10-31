<?php
return [
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'request' => [
        'baseUrl' => '/admin',
        'csrfParam' => '_csrf-backend',
        'cookieValidationKey' => 'DummyValidationKey',
        'csrfCookie' => [
            'httpOnly' => true,
            'path' => '/admin',
        ],
    ],
    'user' => [
        'identityClass' => 'zacksleo\yii2\backend\models\Admin',
        'enableAutoLogin' => true,
        'loginUrl' => ['site/login'],
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
    ],
    'session' => [
        // this is the name of the session cookie used for login on the backend
        'name' => 'advanced-backend',
        'cookieParams' => [
            'path' => '/admin'
        ]
    ],
    'i18n' => [
        'translations' => [
            'zacksleo/yii2/backend/*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@vendor/zacksleo/yii2-backend/src/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'zacksleo/yii2/backend/backend' => 'backend.php',
                ],
            ],
            'extensions/yii2-settings/*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@vendor/pheme/yii2-settings/messages',
                'fileMap' => [
                    'extensions/yii2-settings/settings' => 'settings.php',
                ],
            ],
            'rbac-admin' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@mdm/admin/messages',
            ],
        ],
    ],
    'settings' => [
        'class' => 'pheme\settings\components\Settings',
    ],
    'authManager' => [
        'class' => 'yii\rbac\PhpManager',
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
];
