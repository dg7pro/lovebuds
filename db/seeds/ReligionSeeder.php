<?php


use Phinx\Seed\AbstractSeed;

class ReligionSeeder extends AbstractSeed
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
            ['id'=>1, 'name'=>'Hindu', 'rank'=>1],
            ['id'=>2, 'name'=>'Muslim', 'rank'=>2],
            ['id'=>3, 'name'=>'Sikhs', 'rank'=>3],
            ['id'=>4, 'name'=>'Christian', 'rank'=>4],
            ['id'=>5, 'name'=>'Buddhist', 'rank'=>5],
            ['id'=>6, 'name'=>'Jain', 'rank'=>6],
            ['id'=>7, 'name'=>'Parsi', 'rank'=>7],
            ['id'=>8, 'name'=>'Jewish', 'rank'=>8],
            ['id'=>9, 'name'=>'Bahai', 'rank'=>9]

        ];

        $posts = $this->table('religions');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();


    }
}
