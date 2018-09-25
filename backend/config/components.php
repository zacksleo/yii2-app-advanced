<?php
return [
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'request' => [
        'baseUrl' => '/admin',
        'csrfParam' => '_csrf-backend',
        'cookieValidationKey' => 'SeCrEt_DeV_Key--DO-NOT-USE-IN-PRODUCTION!',
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
            '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@backend/messages',
                'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app' => 'app.php',
                    'error' => 'error.php',
                    'login' => 'login.php'
                ],
            ],
        ],
    ],
    'view' => [
        'theme' => [
            'pathMap' => [
                '@app/views' => '@app/themes/metronic/views',
                '@app/modules' => '@app/themes/metronic/modules',
            ]
        ]
    ],
    'settings' => [
        'class' => 'pheme\settings\components\Settings',
    ],
    'authManager' => [
        'class' => 'yii\rbac\PhpManager',
    ],
];
