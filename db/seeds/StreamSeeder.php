<?php


use Phinx\Seed\AbstractSeed;

class StreamSeeder extends AbstractSeed
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
            ['id'=>1, 'name'=>'Engineering/Design', 'sequence'=>1],
            ['id'=>2, 'name'=>'Computers', 'sequence'=>3],
            ['id'=>3, 'name'=>'Finance/Commerce', 'sequence'=>4],
            ['id'=>4, 'name'=>'Management', 'sequence'=>2],
            ['id'=>5, 'name'=>'Medicine', 'sequence'=>5],
            ['id'=>6, 'name'=>'Law', 'sequence'=>6],
            ['id'=>7, 'name'=>'Arts/Science', 'sequence'=>7],
            ['id'=>8, 'name'=>'Doctorate', 'sequence'=>8],
            ['id'=>9, 'name'=>'Non-Graduate', 'sequence'=>9],
            ['id'=>10, 'name'=>'Others', 'sequence'=>10]

        ];

        $posts = $this->table('streams');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();


    }
}
