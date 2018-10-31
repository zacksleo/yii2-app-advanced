<?php
return [
    'admin' => [
        'class' => 'mdm\admin\Module',
        'mainLayout' => '@vendor/zacksleo/yii2-backend/src/views/layouts/layout.php',
        'layout' => 'left-menu',
        'controllerMap' => [
            'assignment' => [
                'class' => 'mdm\admin\controllers\AssignmentController',
                'userClassName' => 'zacksleo\yii2\backend\models\Admin',
                'idField' => 'id',
            ]
        ],
        'menus' => [
            'assignment' => [
                'label' => '分配',
            ],
            //'route' => true
        ]
    ],
];
