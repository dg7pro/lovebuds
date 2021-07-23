<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class NakshatrasTableMigration extends AbstractMigration
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
        $tbl = $this->table('nakshatras',['id' => false, 'primary_key' => ['id'],'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('id', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false])
            ->addColumn('text','string', ['limit'=>100,'null'=>false])
            ->addColumn('pada1','string', ['limit'=>20,'null'=>true])
            ->addColumn('pada2','string', ['limit'=>20,'null'=>true])
            ->addColumn('pada3','string', ['limit'=>20,'null'=>true])
            ->addColumn('pada4','string', ['limit'=>20,'null'=>true])
            ->addColumn('lord','string', ['limit'=>20,'null'=>true])
            ->addColumn('deity','string', ['limit'=>20,'null'=>true])
            ->addIndex(['id'])
            ->create();

    }
}
