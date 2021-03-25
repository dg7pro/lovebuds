<?php

include_once '../app.php';
include_once '../checkAuth.php';

/*
 * ic: image count
 * ds: delete status
 * fn: filename

 * iid: image id
 * */

$userId = $_SESSION['id'];

if(isset($_POST['fn']) && isset($_POST['iid'])) {

    $fn = $_POST['fn'];                                 // File name of the image to be deleted
    $iid = $_POST['iid'];                               // Image Id: Unique number assigned during upload

    $sql = "DELETE FROM kycs WHERE user_id=? AND img_id=? AND filename=?";
    $stmt = $pdo->prepare($sql);
    $x = $stmt->execute([$userId,$iid,$fn]);

    $img_path = '../uploaded/kyc/';

    // Delete Image
    $img_name = $img_path . $fn;
    if (file_exists($img_name)) {
        unlink($img_name);
    }

    if($x){
        $msg = "Image deleted successfully";                // Ajax Message returned back
        $ds = 1;
    }else{
        $msg = "Image Could not be deleted";
        $ds = 0;
    }

    $sql2 = "SELECT * FROM kycs WHERE user_id=?";
    $stmt = $pdo->prepare($sql2);
    $stmt->execute([$userId]);
    $ic = $stmt->rowCount();                            // Image Count: number of images left

    $idata = ['msg'=>$msg,'ds'=>$ds,'iid'=>$iid,'ic'=>$ic];
    echo json_encode($idata);
}