<?php

use yii\db\Migration;

/**
 * 管理后台菜单, 插入插入初始化数据
 */
class m170412_015531_insert_admin_menu extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%admin_menu}}',
            ['id', 'name', 'parent', 'route', 'order'],
            [
                [1, '控制台', null, null, 1],
                [2, '系统维护', null, null, 11],
                [3, '用户', 1, null, 9],
                [4, '管理员', 1, null, 10],
                [5, '核心组件', 2, null, 1],
                [6, '对照', 5, '/lookup/default/index', 1],
                [7, '菜单', 5, '/admin/menu/index', 2],
                [8, '用户列表', 4, '/admin/user/index', 1],
                [9, '角色列表', 4, '/admin/role/index', 2],
            ]
        );
        return true;
    }

    public function down()
    {
        $this->delete('{{%admin_menu}}', [
            'between', 'id', 1, 9
        ]);
        return true;
    }
}
