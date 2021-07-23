<?php


use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
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
            'Administration',
            'Advertising, Media & Entertainment',
            'Agricultural',
            'Architecture',
            'Airlines & Aviation',
            'Armed Forces',
            'Banking & Finance',
            'BPO & Customer Services',
            'Civil Services',
            'Corporate Management Professionals',
            'Doctor',
            'Education & Training',
            'Engineering',
            'Hospitality',
            'Law Enforcement',
            'Legal',
            'Medical & HealthCare',
            'Merchant Navy',
            'Not Working',
            'Others',
            'Science & Research',
            'Software & IT',
            'Top Management'

        ];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'name'=>$a]);
            $i++;
        }
        $posts = $this->table('categories');

        //$posts->truncate();

        $posts->insert($data)
            ->saveData();

    }
}
