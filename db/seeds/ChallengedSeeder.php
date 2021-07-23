<?php


use Phinx\Seed\AbstractSeed;

class ChallengedSeeder extends AbstractSeed
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
        $alpha = [
            'None',
            'Physically - From birth',
            'Physically - Due to accident',
            'Mentally - From birth',
            'Mentally - Due to accident'
        ];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'status'=>$a]);
            $i++;
        }
        $posts = $this->table('challenged');

        //$posts->truncate();

        $posts->insert($data)
            ->saveData();

    }
}
