<?php


use Phinx\Seed\AbstractSeed;

class CommunitiesSeeder extends AbstractSeed
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

        $data = [
            ['id'=>1, 'name'=>'Assamese', 'text'=>'Assamese Speaking', 'serial'=>12,'active'=>1],
            ['id'=>2, 'name'=>'Bengali', 'text'=>'Bengali Speaking', 'serial'=>2,'active'=>1],
            ['id'=>3, 'name'=>'Bodo', 'text'=>'Bodo Speaking', 'serial'=>21,'active'=>1],
            ['id'=>4, 'name'=>'Dogri', 'text'=>'Dogri Speaking', 'serial'=>18,'active'=>1],
            ['id'=>5, 'name'=>'Gujarati', 'text'=>'Gujarati Speaking ', 'serial'=>6,'active'=>1],
            ['id'=>6, 'name'=>'Hindi', 'text'=>'Hindi Speaking', 'serial'=>1,'active'=>1],
            ['id'=>7, 'name'=>'Kannada', 'text'=>'Kannada Speaking', 'serial'=>8,'active'=>1],
            ['id'=>8, 'name'=>'Kashmiri', 'text'=>'Kashmiri Speaking', 'serial'=>15,'active'=>1],
            ['id'=>9, 'name'=>'Konkani', 'text'=>'Konkani Speaking', 'serial'=>19,'active'=>1],
            ['id'=>10, 'name'=>'Maithili', 'text'=>'Maithili Speaking', 'serial'=>13,'active'=>1],
            ['id'=>11, 'name'=>'Malayalam', 'text'=>'Malayalam Speaking', 'serial'=>10,'active'=>1],
            ['id'=>12, 'name'=>'Manipuri', 'text'=>'Manipuri Speaking', 'serial'=>20,'active'=>1],
            ['id'=>13, 'name'=>'Marathi', 'text'=>'Marathi Speaking', 'serial'=>3,'active'=>1],
            ['id'=>14, 'name'=>'Nepali', 'text'=>'Nepali Speaking', 'serial'=>16,'active'=>1],
            ['id'=>15, 'name'=>'Oriya', 'text'=>'Oriya Speaking', 'serial'=>9,'active'=>1],
            ['id'=>16, 'name'=>'Punjabi', 'text'=>'Punjabi Speaking', 'serial'=>11,'active'=>1],
            ['id'=>17, 'name'=>'Sanskrit', 'text'=>'Sanskrit Speaking', 'serial'=>22,'active'=>1],
            ['id'=>18, 'name'=>'Santhali', 'text'=>'Santhali Speaking', 'serial'=>14,'active'=>1],
            ['id'=>19, 'name'=>'Sindhi', 'text'=>'Sindhi Speaking', 'serial'=>17,'active'=>1],
            ['id'=>20, 'name'=>'Tamil', 'text'=>'Tamil Speaking', 'serial'=>5,'active'=>1],
            ['id'=>21, 'name'=>'Telugu', 'text'=>'Telugu Speaking', 'serial'=>4,'active'=>1],
            ['id'=>22, 'name'=>'Urdu', 'text'=>'Urdu Speaking', 'serial'=>7,'active'=>1],
            ['id'=>23, 'name'=>'Others', 'text'=>'Others Speaking', 'serial'=>23,'active'=>1],

        ];

        $posts = $this->table('communities');
        //$posts->truncate();
        $posts->insert($data)
            ->saveData();

    }
}
