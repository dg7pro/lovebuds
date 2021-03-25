<?php

require_once '../app.php';
require_once('slim.php');

try {
    $images = Slim::getImages();
}
catch (Exception $e) {
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'Unknown'
    ));
    return;
}

if ($images === false) {
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No data posted'
    ));
    return;
}

$image = array_shift($images);

if (!isset($image)) {
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No images found'
    ));
    return;
}

if (!isset($image['output']['data']) && !isset($image['input']['data'])) {

    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No image data'
    ));
    return;
}

if (isset($image['output']['data'])) {

    $txt = md5($_SESSION['pid']);
    $name = $txt.'.jpg';

    // get the crop data for the output image
    $data = $image['output']['data'];

    // If you want to store the file in another directory pass the directory name as the third parameter.
    // $output = Slim::saveFile($data, $name, 'my-directory/');

    // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
    // $output = Slim::saveFile($data, $name, 'tmp/', false);

    // Default call for saving the output data
    $output = Slim::saveFile($data, $name,'../uploaded/kyc/');

    if($output){
        $userId = $_SESSION['id'];
        $nm = $output['name'];
        $tn = 'kyc_'.$nm;
        //$img_id = $image['meta']->picId;
        $img_id = random_token(5);


        //==============================
        // Making first image as avatar
        // Then inserting into database
        //==============================
        /*$sqlCheck = "SELECT * FROM images WHERE user_id=?";
        $stmt = $pdo->prepare($sqlCheck);
        $stmt->execute([$userId]);
        $x=$stmt->rowCount();*/

        $sql = "INSERT INTO kycs (user_id,img_id,filename) VALUES (?,?,?)";
        $stmt = $pdo->prepare($sql);
        $result=$stmt->execute([$userId,$img_id,$nm]);


        if (!$result) {
            //$_SESSION['msg']="Error: " . $sql . "<br>" . $stmt->errorInfo();
            var_dump($stmt->errorInfo());
        } else {
            $_SESSION['msg']="New record created successfully";
        }
    }

}

// if we've received input data (do the same as above but for input data)
if (isset($image['input']['data'])) {

    // get the name of the file
    //$name = $image['input']['name'];
    $name = $_SESSION['pid'].'.jpg';

    // get the crop data for the output image
    $data = $image['input']['data'];

    // If you want to store the file in another directory pass the directory name as the third parameter.
    // $input = Slim::saveFile($data, $name, 'my-directory/');

    // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
    // $input = Slim::saveFile($data, $name, 'tmp/', false);

    // Default call for saving the input data
    $input = Slim::saveFile($data, $name,'../uploaded/kyc/');

}

$userId=$_SESSION['id'];
$sql = "SELECT * FROM kycs WHERE user_id=? AND linked = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$num = $stmt->rowCount();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
$album = '';
foreach($images as $image){

    $album .= '<div class="col-md-4 col-xl-4" id="my-pic-'.$image['img_id'].'">
                    <div class="card mb-4">
                        <img class="card-img-top" src="uploaded/kyc/'.$image['filename'].'">
                        <div class="card-body">                       
                            <button class="btn btn-outline-danger btn-sm delImage" id="delImage-'.$image['img_id'].'" onclick="deleteImage('.$image['img_id'].')" data-id="'.$image['img_id'].'" data-name="'.$image['filename'].'" value="'.$image['filename'].'">Delete</button>
                        </div>                       
                    </div>
                </div>';
}


//
// Build response to client
//
$response = array(
    'status' => SlimStatus::SUCCESS,
    'num'=>$num,
    'album'=>$album
);

if (isset($output) && isset($input)) {

    $response['output'] = array(
        'file' => $output['name'],
        'path' => $output['path']
    );

    $response['input'] = array(
        'file' => $input['name'],
        'path' => $input['path']
    );

}
else {
    $response['file'] = isset($output) ? $output['name'] : $input['name'];
    $response['path'] = isset($output) ? $output['path'] : $input['path'];
}

// Return results as JSON String
Slim::outputJSON($response);
