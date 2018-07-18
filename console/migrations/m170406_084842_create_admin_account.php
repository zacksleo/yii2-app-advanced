<?php

use yii\db\Migration;
use zacksleo\yii2\backend\models\Admin;

class m170406_084842_create_admin_account extends Migration
{
    public function up()
    {
        $password = Yii::$app->security->generateRandomString(10);
        $this->insert('{{%admin}}', [
            'auth_key' => Yii::$app->security->generateRandomString(),
            'avatar' => '',
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@domain.com',
            'password_hash' => Yii::$app->security->generatePasswordHash($password),
            'status' => Admin::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
        echo "Account Created:　admin/$password\n";
        return true;
    }

    public function down()
    {
        $this->delete('{{%admin}}', [
            'username' => 'admin',
        ]);
        return true;
    }
}
