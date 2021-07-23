<?php


use Phinx\Seed\AbstractSeed;

class ManglikSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            ['id'=>1, 'status'=>'Manglik', 'des'=>'Yes'],
            ['id'=>2, 'status'=>'Non Manglik', 'des'=>'No'],
            ['id'=>3, 'status'=>'Angshik Manglik', 'des'=>'Angshik']
        ];

        $posts = $this->table('mangliks');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
