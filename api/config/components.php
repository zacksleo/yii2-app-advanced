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
        'enableAutoLogin' => false,
        'enableSession' => false,
        'loginUrl' => null,
        'identityCookie' => null,
    ],
];
