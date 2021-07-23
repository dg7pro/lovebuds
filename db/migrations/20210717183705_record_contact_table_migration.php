<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RecordContactTableMigration extends AbstractMigration
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
        $users = $this->table('record_contact',['id' => false, 'primary_key' => ['user_id','other_id'], 'collation'=>'utf8mb4_unicode_ci']);
        $users->addColumn('user_id','integer',['signed'=>false, 'null'=>false])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('other_id','integer',['signed'=>false, 'null'=>false])
            ->addForeignKey('other_id', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('created_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->create();

    }
}
