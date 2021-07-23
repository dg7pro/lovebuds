<?php


use App\Models\UserVariables;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
        $faker = Faker\Factory::create();
        $data = [];
        $myhobbies = [];
        $myinterests = [];
        $mycastes = [];
        $langs = [];

        for ($i = 0; $i < 100; $i++) {

            $gender = rand(1, 2);
            $genVal = $gender == 1 ? 'male':'female';
            // Password is fixed for seeding purpose
            $hashedPwd = password_hash('jum@2021', PASSWORD_DEFAULT);

            $data[] = [
                'pid'           => self::generateProfileId(7),
                'gender'        => $gender,
                'avatar'        => $gender == 1 ? 'avatar_groom.jpg' : 'avatar_bride.jpg',
                'for_id'          => rand(1, 7),
                'is_active'     => 1,
                'ev'            => 1,
                'mobile'        => $faker->phoneNumber,
                'whatsapp'      => $faker->phoneNumber,
                'password_hash' => $hashedPwd,
                'email'         => $faker->email,
                'first_name'    => $faker->firstName($gender = $genVal),
                'last_name'     => $faker->lastName,

                'dob'               => UserVariables::randomDate(1987 - 01 - 01, 2000 - 12 - 31),
                'height_id'         => rand(7,20),
                'marital_id'        => rand(1,5),
                'religion_id'       => rand(1,9),
                'community_id'      => rand(1,23),
                'caste_id'          => rand(1,538),
                'education_id'      => rand(1,53),
                'occupation_id'     => rand(1,98),
                'income_id'         => rand(1,15),
                'manglik_id'        => rand(1,3),
                'country_id'        => 188,
                'state'             => $faker->state,
                'district'          => $faker->city,
                'myhobbies'         => json_encode($myhobbies),
                'myinterests'       => json_encode($myinterests),
                'mycastes'          => json_encode($mycastes),
                'langs'             => json_encode($langs)
            ];
        }

        $this->table('users')->insert($data)->saveData();

    }

    public static function generateProfileId($size): string
    {

        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }

        $length = $size - 2;

        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $alpha_key . $key;

    }

    /*'dob'               => UserVariables::randomDate(1987 - 01 - 01, 2000 - 12 - 31),
                    'height_id'         => array_rand(UserVariables::heights()),
                    'marital_id'        => array_rand(UserVariables::maritals()),
                    'religion_id'       => array_rand(UserVariables::religions()),
                    'community_id'      => array_rand(UserVariables::communities()),
                    'caste_id'          => array_rand(UserVariables::castes()),
                    'education_id'      => array_rand(UserVariables::educations()),
                    'occupation_id'     => array_rand(UserVariables::occupations()),
                    'income_id'         => array_rand(UserVariables::incomes()),
                    'manglik_id'        => array_rand(UserVariables::mangliks()),*/

}
