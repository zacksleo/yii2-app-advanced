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
    'backup' => [
        'class' => 'spanjeta\modules\backup\Module',
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => 'console_id', //this is important !
            ]);
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect('/console/default/login');
            }
        }
    ],
    'pages' => [
        'class' => 'bupy7\pages\Module',
        'tableName' => '{{%page}}',
        'imperaviLanguage' => 'zh_cn',
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => '_identity-backend', //this is important !
            ]);
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
            }
        }
    ],
    'lookup' => [
        'class' => 'zacksleo\yii2\lookup\Module',
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
    'user' => [
        'class' => 'dektrium\user\Module',
        'admins' => ['admin'],
        'enableFlashMessages' => false,
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => '_identity-backend',
            ]);
            if (Yii::$app->user->isGuest && Yii::$app->controller->id != 'user') {
                //return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
            }
        }
    ],
    'cms' => [
        'class' => 'zacksleo\yii2\cms\Module',
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => '_identity-backend',
            ]);
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
            }
        }
    ],
    'gallery' => [
        'class' => 'zacksleo\yii2\gallery\Module',
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => '_identity-backend',
            ]);
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
            }
        }
    ],
    'ad' => [
        'class' => 'zacksleo\yii2\ad\Module',
    ],
    'treemanager' => [
        'class' => '\kartik\tree\Module',
        'on beforeAction' => function () {
            Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'zacksleo\yii2\backend\models\Admin',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
                'idParam' => '_identity-backend',
            ]);
            if (Yii::$app->user->isGuest) {
                return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
            }
        }
    ],
    'ueditor' => [
        'class' => 'zacksleo\yii2\ueditor\Module'
    ]
];
