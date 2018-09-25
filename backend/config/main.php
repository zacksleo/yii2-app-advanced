<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Chongqing',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => require(__DIR__ . '/components.php'),
    'params' => $params,
    'layout' => 'layout',
    'layoutPath' => '@vendor/zacksleo/yii2-backend/src/views/layouts',
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'admin/*'
        ]
    ]
];
