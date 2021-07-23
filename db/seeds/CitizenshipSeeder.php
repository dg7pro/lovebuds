<?php


use Phinx\Seed\AbstractSeed;

class CitizenshipSeeder extends AbstractSeed
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
            'Citizen',
            'Permanent Resident',
            'Work Permit',
            'Student Visa',
            'Temporary Visa'
        ];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'status'=>$a]);
            $i++;
        }
        $posts = $this->table('citizenship');

        //$posts->truncate();

        $posts->insert($data)
            ->saveData();

    }
}
