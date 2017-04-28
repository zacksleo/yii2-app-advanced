<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170406_084804_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(125),
            'avatar' => $this->string()->comment('头像'),
            'username' => $this->string(20)->notNull()->comment('用户名'),
            'name' => $this->string(20)->notNull()->comment('姓名'),
            'email' => $this->string(64)->notNull()->comment('邮箱'),
            'password_hash' => $this->string(64)->notNull()->comment('密码'),
            'password_reset_token' => $this->string()->comment('重置密码Token'),
            'status' => $this->boolean()->notNull()->defaultValue(1)->comment('状态'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' COMMENT="管理员"');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%admin}}');
    }
}
