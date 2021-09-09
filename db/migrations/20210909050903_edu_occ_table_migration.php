<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class EduOccTableMigration extends AbstractMigration
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
        $tbl = $this->table('edu_occ',['id' => false, 'primary_key' => ['education_id', 'occupation_id'], 'collation'=>'utf8mb4_unicode_ci']);
        $tbl->addColumn('education_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>false])
            ->addColumn('occupation_id','integer',['limit'=>MysqlAdapter::INT_TINY, 'signed'=>false, 'null'=>false])
            ->addForeignKey('education_id', 'educations', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->addForeignKey('occupation_id', 'occupations', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
            ->create();

    }
}
