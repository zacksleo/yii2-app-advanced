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
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/api/v1/') > -1) {
    $config['components']['urlManager']['rules'] =
        require(dirname(__FILE__) . './../modules/v1/config/rules.php');
}

return $config;
