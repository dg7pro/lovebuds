<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CommunityStateTableMigration extends AbstractMigration
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
        $tbl = $this->table('community_state',['id' => false, 'primary_key' => ['community_id', 'state_id'], 'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('community_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>false])
            ->addColumn('state_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>false])
            ->addForeignKey('community_id', 'communities', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('state_id', 'states', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->create();

    }
}
