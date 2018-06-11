<?php
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/main.php'),
    require(__DIR__ . '/main-local.php'),
    require(__DIR__ . '/test.php'),
    [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => $_ENV['TEST_DB_DSN'],
                'username' => $_ENV['TEST_DB_USER'],
                'password' => $_ENV['TEST_DB_PASSWORD'],
                'charset' => 'utf8',
                'tablePrefix' => 'mops_',
            ],
        ],
    ]
);
