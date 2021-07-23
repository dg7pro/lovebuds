<?php


use Phinx\Seed\AbstractSeed;

class FamIncomeSeeder extends AbstractSeed
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
            'Rs. 1-2 lakh',
            'Rs. 2-3 lakh',
            'Rs. 3-4 lakh',
            'Rs. 4-5 lakh',
            'Rs. 5-7 lakh',
            'Rs. 7-10 lakh',
            'Rs. 10-15 lakh',
            'Rs. 15-20 lakh',
            'Rs. 15-20 lakh',
            'Rs. 20-25 lakh',
            'Rs. 25-35 lakh',
            'Rs. 35-50 lakh',
            'Rs. 50-70 lakh',
            'Rs. 70 lakh - 1 crore',
            'Rs. 1 crore & above'

        ];
        $i = 1;
        foreach($alpha as $a){
            array_push($data,['id'=>$i,'level'=>$a]);
            $i++;
        }
        $posts = $this->table('fam_incomes');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
