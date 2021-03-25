<?php

include_once '../app.php';
include_once '../checkAuth.php';

$userId = $_SESSION['id'];

if(isset($_POST['fn']) && isset($_POST['iid'])) {

    $fn = $_POST['fn'];
    $iid = $_POST['iid'];

    $sql1 = "UPDATE images SET pp=0 WHERE user_id=?";                   // For all the images profile pic pp is set to 0
    $stmt = $pdo->prepare($sql1);
    $stmt->execute([$userId]);

    $sql2 = "UPDATE images SET pp=1 WHERE user_id=? AND img_id=? AND filename=?";
    $stmt = $pdo->prepare($sql2);
    $status = $stmt->execute([$userId,$iid,$fn]);

    if($status){
        $sql3 = "UPDATE profiles SET avatar=? WHERE user_id=?";         // Profiles table is simultaneously updated
        $stmt=$pdo->prepare($sql3);                                     // so that user when next time login avatar image
        $stmt->execute([$fn,$userId]);                                  // is put into session without difficulty
    }
    $_SESSION['avatar']=$fn;                                            // essential for avatar image in navbar

    $msg = "Avatar Changed successfully";
    $idata = ['msg'=>$msg,'iid'=>$iid];
    echo json_encode($idata);

}

