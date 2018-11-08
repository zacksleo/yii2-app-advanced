<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170406_084754_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'avatar' => $this->string()->comment('头像'),
            'phone' => $this->string(15)->notNull()->comment('手机号'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
            'union_id' => $this->string()->notNull()->comment('UnionID'),
        ]);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
        return true;
    }
}
