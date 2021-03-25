<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Kyc;
use App\Slim\Slim;
use App\Slim\SlimStatus;
use Exception;

/**
 * Class Verification
 * @package App\Controllers
 */
class Verification extends Authenticated
{

    /**
     * Handles Asynchronously kyc upload
     * process of the user
     */
    public function uploadAction(){

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

            $profile_id=Auth::getUser()->pid;
            $txt = md5($profile_id);
            $name = $txt.'.jpg';

            // get the crop data for the output image
            $data = $image['output']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $output = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $output = Slim::saveFile($data, $name, 'tmp/', false);

            // Default call for saving the output data
            $output = Slim::saveFile($data, $name,'uploaded/kyc/');

            if($output){
                Kyc::persistUserKyc(Auth::getUser()->id,$output['name']);
            }

        }

        // if we've received input data (do the same as above but for input data)
        if (isset($image['input']['data'])) {

            // get the name of the file
            //$name = $image['input']['name'];
            $name = Auth::getUser()->pid.'.jpg';

            // get the crop data for the output image
            $data = $image['input']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $input = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $input = Slim::saveFile($data, $name, 'tmp/', false);

            // Default call for saving the input data
            $input = Slim::saveFile($data, $name,'uploaded/kyc/');

        }

        // User Images for display on My Album page
        $images = Kyc::fetchUserKycsForDisplay(Auth::getUser()->id);
        $num = count($images);

        $album = '';
        foreach($images as $image){

            $album .= '<div class="col-md-4 col-xl-4" id="my-pic-'.$image['img_id'].'">
                    <div class="card mb-4">
                        <img class="card-img-top" src="/uploaded/kyc/'.$image['filename'].'">
                        <span class="bg-info text-center text-dark">Pending Approval</span>                     
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

    }

}