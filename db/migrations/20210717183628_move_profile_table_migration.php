<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class MoveProfileTableMigration extends AbstractMigration
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
        $users = $this->table('move_profile',['id' => false, 'primary_key' => ['sender', 'receiver', 'num'], 'collation'=>'utf8mb4_unicode_ci']);
        $users->addColumn('sender','integer',['signed'=>false])
            ->addColumn('receiver','integer',['signed'=>false])
            ->addColumn('num','integer', ['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false])
            ->addForeignKey('sender', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('receiver', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('created_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->create();

    }
}
