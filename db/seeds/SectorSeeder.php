<?php


use Phinx\Seed\AbstractSeed;

class SectorSeeder extends AbstractSeed
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
        $alpha = ['Private Sector','Govt./Public Sector','Civil Services',
            'Defence','Business/Self Employed','Not Working'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'name'=>$a]);
            $i++;
        }
        $posts = $this->table('sectors');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
