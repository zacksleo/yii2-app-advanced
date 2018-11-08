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
    'backends' => [
        'class' => 'zacksleo\yii2\backend\Module',
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => '_identity-backend',
            ]);
            if (Yii::$app->user->isGuest && Yii::$app->controller->id != 'api') {
                return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
            }
        }
    ],
];
