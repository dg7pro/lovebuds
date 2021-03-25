<?php

include_once '../app.php';
include_once '../checkAuth.php';

$pid = $_SESSION['pid'];

if(isset($_POST['fn'])){

    $fn = $_POST['fn'];
    $iid = $_POST['iid'];


//    $idata = ['fn'=>$fn,'iid'=>$iid];
//    echo json_encode($idata);


    //$sql =  $sql = "UPDATE images SET linked =0 WHERE profile_id ='".$pid."' AND filename='".$nm."'";
    $sql = "UPDATE images SET linked =0 WHERE profile_id =? AND filename=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pid,$fn]);

    // To be commented coz image has to be deleted by admin
    $img_path = '../uploaded/pics/';
    $tmb_path = '../uploaded/tmb/';

    // Delete Image
    $img_name = $img_path . $fn;
    if (file_exists($img_name)) {
        unlink($img_name);
    }

    // Delete thumbnail
    $tmb_name = $tmb_path .'tn_'. $fn;
    if (file_exists($tmb_name)) {
        unlink($tmb_name);
    }

    $msg = "Image deleted successfully";

    $idata = ['msg'=>$msg,'iid'=>$iid,'fn'=>$fn];
    echo json_encode($idata);

}

