<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AadharsTableMigration extends AbstractMigration
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
        $users = $this->table('aadhars',['id' => false, 'primary_key' => ['user_id', 'img_id'], 'collation'=>'utf8mb4_unicode_ci']);
        $users->addColumn('user_id','integer',['signed'=>false])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('img_id','integer',['limit'=>6,'signed'=>false,'null'=>false])
            ->addColumn('filename','string',['limit'=>255, 'null'=>false])
            ->addColumn('tag','string',['limit'=>10, 'null'=>false])
            ->addColumn('dealt','boolean',['null'=>false,'default'=>0])
            ->addColumn('created_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at','timestamp',['null'=>false,'default'=>'CURRENT_TIMESTAMP'])
            ->create();

    }
}
