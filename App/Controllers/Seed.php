<?php


namespace App\Controllers;

use App\Models\User;
use Faker;

class Seed extends Administered
{
    // TODO

    public function usersTableAction(){

        $result = User::seedUsersTable(500);

        if($result){
            echo "Users table seeded successfully";
        }

    }


}