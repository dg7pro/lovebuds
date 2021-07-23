<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NotificationsTableMigration extends AbstractMigration
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
        $users = $this->table('notifications',['id' => false, 'primary_key' => ['id'], 'collation'=>'utf8mb4_unicode_ci']);
        $users->addColumn('id','integer',['signed'=>false])
            ->addColumn('sender','integer',['signed'=>false, 'null'=>false])
            ->addForeignKey('sender', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('receiver','integer',['signed'=>false, 'null'=>false])
            ->addForeignKey('receiver', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('message','text',['null'=>false])
            ->addColumn('pid', 'string',['limit'=>20, 'null'=>false ])
            ->addColumn('status','boolean', ['null'=>false, 'default'=>0])
            ->addColumn('created_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->create();

    }
}
