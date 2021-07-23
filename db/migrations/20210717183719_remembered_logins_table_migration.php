<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RememberedLoginsTableMigration extends AbstractMigration
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
        $users = $this->table('remembered_logins',['id' => false, 'primary_key' => ['token_hash'], 'collation'=>'utf8mb4_unicode_ci']);
        $users->addColumn('token_hash','string',['limit'=>64, 'null'=>false])
            ->addColumn('user_id','integer',['signed'=>false, 'null'=>false])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addColumn('expires_at','datetime',['null'=>false])
            ->create();

    }
}
