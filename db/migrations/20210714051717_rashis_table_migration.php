<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class RashisTableMigration extends AbstractMigration
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
        $tbl = $this->table('rashis',['id' => false, 'primary_key' => ['id'], 'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('id', 'integer', ['limit'=>MysqlAdapter::INT_TINY,'signed'=>false])
            ->addColumn('svg','string', ['limit'=>15,'null'=>false])
            ->addColumn('unicode','string', ['limit'=>1,'null'=>false])
            ->addColumn('text','string', ['limit'=>11,'null'=>false])
            ->addColumn('time','string', ['limit'=>25,'null'=>false])
            ->addColumn('planet','string', ['limit'=>7,'null'=>false])
            ->addIndex(['id'])
            ->create();

    }
}
