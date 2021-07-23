<?php


use Phinx\Seed\AbstractSeed;

class AlphabetSeeder extends AbstractSeed
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
        $alpha = ['Commonly Used','A','B','C','D','E','F','G','H','I','J','K','L',
            'M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['value'=>$i,'text'=>$a,'active'=>1]);
            $i++;
        }
        $posts = $this->table('alphabets');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
