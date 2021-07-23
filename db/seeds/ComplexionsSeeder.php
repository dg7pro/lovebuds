<?php


use Phinx\Seed\AbstractSeed;

class ComplexionsSeeder extends AbstractSeed
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
        $alpha = ['Very Fair','Fair','Whitish','Whitish Brown','Dark'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'type'=>$a]);
            $i++;
        }
        $posts = $this->table('complexions');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();


    }
}
