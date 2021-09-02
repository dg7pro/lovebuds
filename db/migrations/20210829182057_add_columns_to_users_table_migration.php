<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddColumnsToUsersTableMigration extends AbstractMigration
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
        $tbl = $this->table('users');
        $tbl->addColumn('c_block','boolean', ['null'=>false, 'after'=>'one_way'])
            ->addColumn('credits','integer',['limit'=>MysqlAdapter::INT_SMALL, 'signed' => false, 'null'=>false, 'default'=>0, 'after'=>'c_block'])
            ->addColumn('aadhar','integer',['limit'=>MysqlAdapter::INT_BIG, 'signed' => false, 'null'=>true, 'after'=>'credits'])
            ->addColumn('otp','integer',['limit'=>MysqlAdapter::INT_MEDIUM, 'signed'=>false, 'null'=>true, 'after'=>'aadhar'])
            ->update();

    }
}
