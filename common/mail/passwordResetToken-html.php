<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    亲爱的 <?= Html::encode($user->username) ?>,
    点击下面的链接完成注册:

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
