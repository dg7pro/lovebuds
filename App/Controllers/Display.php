<?php

namespace App\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\UserVariables;
use Core\Controller;

class Display extends Controller
{
    public function createAction(){

        $result = Member::seedMembersTable();
        if($result){
            echo "Members table seeded";
        }
    }

    public function search(){

        $mem = new Member();
        $members = $mem->getMembers(2);
        var_dump($members);
    }

    public function test(){
       /* $result = UserVariables::getStates(6);
        var_dump($result);*/

        $mem = new Member();
        $result =$mem->getDummyDist(6);

//        $mem = new Member();
//        $result = $mem->getMembers(2,2,6);
        var_dump($result);
    }

    public function dummyMembers(){

        $mem = new Member();
        $result = $mem->getMembers(1,1,6);
        var_dump($result);
    }

    public function testa(){

       /* $mem = new Member();
        $result = $mem->getDummyMs();*/

        //$result = UserVariables::getIncomes();
        $result = UserVariables::getEduOcc();
        var_dump($result);

    }

}