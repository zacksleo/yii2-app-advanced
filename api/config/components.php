<?php
return [
    'request' => [
        'baseUrl' => '/api',
    ],
    'response' => [
        'format' => \yii\web\Response::FORMAT_JSON,
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'user' => [
        'identityClass' => 'common\models\User',
        'enableAutoLogin' => true,
        'loginUrl' => ['site/login'],
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true, 'path' => '/api'],
    ],
];
