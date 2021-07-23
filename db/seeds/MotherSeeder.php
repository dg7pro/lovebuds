<?php


use Phinx\Seed\AbstractSeed;

class MotherSeeder extends AbstractSeed
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
        $alpha = ['House Wife','Business/Entrepreneur','Service-Private','Service-Govt./PSU',
            'Army/Armed Forces','Civil Services','Teacher','Retired','Expired'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'status'=>$a]);
            $i++;
        }
        $posts = $this->table('mothers');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
