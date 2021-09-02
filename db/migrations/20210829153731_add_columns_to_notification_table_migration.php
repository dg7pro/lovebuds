<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddColumnsToNotificationTableMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $tbl = $this->table('notifications');
        $tbl->addColumn('type','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false, 'null'=>false, 'default'=>0, 'after'=>'pid'])
            ->addColumn('response','boolean', ['null'=>false, 'default'=>0, 'after'=>'type'])
            ->update();

    }
}
