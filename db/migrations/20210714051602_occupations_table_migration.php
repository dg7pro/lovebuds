<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class OccupationsTableMigration extends AbstractMigration
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
        $tbl = $this->table('occupations',['id' => false, 'primary_key' => ['id'],'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('id', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'identity'=>true])
            ->addColumn('name', 'string', ['limit'=>50, 'null'=>false])
            ->addColumn('category_id', 'integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>false])
            ->addForeignKey('category_id', 'categories', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addIndex(['id'])
            ->create();

    }
}