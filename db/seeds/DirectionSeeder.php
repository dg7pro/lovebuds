<?php


use Phinx\Seed\AbstractSeed;

class DirectionSeeder extends AbstractSeed
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
        $data = [];
        $alpha = ['East','North','Others','South','West'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['value'=>$i,'text'=>$a]);
            $i++;
        }
        $posts = $this->table('directions');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
