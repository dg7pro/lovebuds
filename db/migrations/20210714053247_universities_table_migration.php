<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UniversitiesTableMigration extends AbstractMigration
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
        $tbl = $this->table('universities',['id' => false, 'primary_key' => ['id'], 'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('id', 'smallinteger', ['signed'=>false,'identity'=>true])
            ->addColumn('rank','integer', ['limit'=>3,'null'=>false])
            ->addColumn('name','string', ['limit'=>100,'null'=>true])
            ->addColumn('location','string', ['limit'=>20,'null'=>true])
            ->addIndex(['id'])
            ->create();


    }
}
