<?php

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'DummyValidationKey',
        ],
    ],
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1'],
    ];
}

return $config;
