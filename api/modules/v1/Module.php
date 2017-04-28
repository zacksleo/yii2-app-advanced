<?php

namespace api\modules\v1;

use yii;
use yii\web\Response;
use yii\base\Module as BaseModule;

/**
 * api module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->headers->add('x-author', 'lianluo.com');
        if (YII_DEBUG) {
            Yii::$app->response->headers->add('x-debug-tag', Yii::$app->log->targets['debug']->tag);
        }
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
        Yii::$app->request->parsers = [
            'application/json' => 'yii\web\JsonParser',
        ];
        //在API接口模块执行严格URL检查
        Yii::$app->urlManager->enableStrictParsing = true;
    }
}
