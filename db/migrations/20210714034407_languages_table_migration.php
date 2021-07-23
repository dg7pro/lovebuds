<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class LanguagesTableMigration extends AbstractMigration
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
        $tbl = $this->table('languages',['id' => false, 'primary_key' => ['value'],'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('value', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false])
            ->addColumn('text', 'string', ['limit'=>20, 'null'=>false])
            ->addIndex(['value'])
            ->create();

    }
}
