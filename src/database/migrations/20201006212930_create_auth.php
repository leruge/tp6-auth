<?php

use think\migration\Migrator;
use Phinx\Db\Adapter\AdapterFactory;

class CreateAuth extends Migrator
{
    public function change()
    {
        $this->table('auth_rule', ['comment' => '权限', 'collation' => 'utf8mb4_bin'])
            ->addColumn('pid', 'integer', ['default' => 0, 'comment' => '上级ID'])
            ->addColumn('name', 'string', ['comment' => '权限规则'])
            ->addColumn('title', 'string', ['comment' => '权限规则中文'])
            ->addColumn('icon', 'string', ['comment' => '菜单图标'])
            ->addColumn('sort', 'integer', ['comment' => '菜单图标', 'default' => 9])
            ->addColumn('is_show', 'integer', ['comment' => '1显示；2隐藏', 'default' => 1])
            ->addColumn('create_time', 'integer', ['null' => true])
            ->addColumn('update_time', 'integer', ['null' => true])
            ->addColumn('delete_time', 'integer', ['null' => true])
            ->create();

        $this->table('auth_group_access', ['comment' => '权限-角色关系', 'collation' => 'utf8mb4_bin'])
            ->addColumn('uid', 'integer', ['comment' => '用户ID'])
            ->addColumn('group_id', 'integer', ['comment' => '分组ID'])
            ->addColumn('create_time', 'integer', ['null' => true])
            ->addColumn('update_time', 'integer', ['null' => true])
            ->addColumn('delete_time', 'integer', ['null' => true])
            ->create();

        $this->table('auth_group', ['comment' => '权限分组', 'collation' => 'utf8mb4_bin'])
            ->addColumn('title', 'string', ['comment' => '分组名称'])
            ->addColumn('rules', 'string', ['comment' => '权限，使用逗号分隔'])
            ->addColumn('create_time', 'integer', ['null' => true])
            ->addColumn('update_time', 'integer', ['null' => true])
            ->addColumn('delete_time', 'integer', ['null' => true])
            ->create();
    }
}
