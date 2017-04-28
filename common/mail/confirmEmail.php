<?php
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\User $user
 */

$confirmationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_confirmation_token]);
?>

亲爱的 <?= Html::encode($user->username) ?>,
点击下面的链接完成注册:

<?= Html::a(Html::encode($confirmationLink), $confirmationLink) ?>
