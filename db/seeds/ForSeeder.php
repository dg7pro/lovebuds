<?php


use Phinx\Seed\AbstractSeed;

class ForSeeder extends AbstractSeed
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
        $alpha = ['Self','Son','Daughter','Brother','Sister','Friend','Relative'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'name'=>$a]);
            $i++;
        }
        $posts = $this->table('fors');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();


    }
}
