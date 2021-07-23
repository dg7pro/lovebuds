<?php


use Phinx\Seed\AbstractSeed;

class DegreeSeeder extends AbstractSeed
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
            'B.A',
            'B.Arch',
            'B.Com',
            'B.Des',
            'BE/B.Tech',
            'B.Ed',
            'B.IT',
            'B.Pharma',
            'B.Sc',
            'BAMS',
            'BBA',
            'BCA',
            'BDS',
            'BFA',
            'BHM',
            'BHMS',
            'BJMC',
            'BL/LLB',
            'BPT',
            'BVSc.',
            'BUMS',
            'MBBS',
            'Others'
        ];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'name'=>$a]);
            $i++;
        }
        $posts = $this->table('degrees');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
