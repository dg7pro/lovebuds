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

    $sql1 = "SELECT * FROM images WHERE user_id=? AND img_id=?";
    $stmt = $pdo->prepare($sql1);
    $stmt->execute([$userId,$iid]);
    $row = $stmt->fetch();

    if($row->pp == 0){
        $sql = "DELETE FROM images WHERE user_id=? AND img_id=? AND filename=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId,$iid,$fn]);

        // JU===========================================
        // To be commented when image has to be
        // deleted by admin coz letting user delete
        // image from server can be risky in some cases
        // =============================================

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

        $msg = "Image deleted successfully";            // Ajax Message returned back
        $ds = 1;                                        // Delete Status either 0 or 1

    }else{
        $msg = "Image Could not be deleted";
        $ds = 0;
    }

    $sql2 = "SELECT * FROM images WHERE user_id=?";
    $stmt = $pdo->prepare($sql2);
    $stmt->execute([$userId]);
    $ic = $stmt->rowCount();                            // Image Count: number of images left


    $idata = ['msg'=>$msg,'ds'=>$ds,'iid'=>$iid,'ic'=>$ic];
    echo json_encode($idata);
}

