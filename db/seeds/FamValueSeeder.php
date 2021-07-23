<?php


use Phinx\Seed\AbstractSeed;

class FamValueSeeder extends AbstractSeed
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
        $alpha = ['Orthodox','Conservative','Moderate','Liberal'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'name'=>$a]);
            $i++;
        }
        $posts = $this->table('fam_values');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();


    }
}
