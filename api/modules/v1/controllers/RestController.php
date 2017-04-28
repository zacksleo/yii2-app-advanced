<?php

namespace api\modules\v1\controllers;

use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Class AuthController
 * @package app\modules\api\v1\controllers
 */
class RestController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'languages' => [
                    'zh-CN',
                    'zh-TW',
                    'en-US',
                ],
            ],
        ]);
    }
}
