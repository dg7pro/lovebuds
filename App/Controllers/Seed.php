<?php


namespace App\Controllers;



use App\Models\User;

class Seed extends Administered
{

    public function usersTableAction(){

        $result = User::seedUsersTable(500);

        if($result){
            echo "Users table seeded successfully";
        }

    }


}