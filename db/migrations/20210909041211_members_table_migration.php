<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class MembersTableMigration extends AbstractMigration
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
        $tbl = $this->table('members',['id' => false, 'primary_key' => ['id'], 'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('id','integer',['signed'=>false,'identity'=>true])

            ->addColumn('name', 'string', ['limit' => 30,'null'=>false])
            ->addColumn('gender','integer',['limit'=>1,'signed' => false,'null'=>false])
            ->addColumn('religion_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>false,'default'=>1])
            ->addColumn('community_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed' => false,'null'=>false,'default'=>6])
            ->addForeignKey('religion_id', 'religions', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('community_id', 'communities', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('img','string',['limit'=>255,'null'=>false])
            ->addIndex(['id'])
            ->create();
    }
}
