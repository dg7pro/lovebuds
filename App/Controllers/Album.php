<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Image;
use App\Slim\SlimStatus;
use App\Slim\Slim;
use Exception;
use Intervention\Image\ImageManager;

/**
 * Class Album - Checked
 * @package App\Controllers
 */
class Album extends Authenticated
{

    /**
     * Handles Asynchronously image upload
     * process of the user
     */
    public function asyncAction(){


        //$images = Slim::getImages();

        // Get posted data, if something is wrong, exit
        try {
            $images = Slim::getImages();
        }
        catch (Exception $e) {

            // Possible solutions
            // ----------
            // Make sure you're running PHP version 5.6 or higher

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

        // Should always be one image (when posting async), so we'll use the first on in the array (if available)
        $image = array_shift($images);

        if (!isset($image)) {
            Slim::outputJSON(array(
                'status' => SlimStatus::FAILURE,
                'message' => 'No images found'
            ));
            return;
        }

        /*
         * If No FAILURE Status is there
         * Image Processing in continued...
         * */


        // if we've received output data save as file
        if (isset($image['output']['data'])) {

            // get the name of the file
            $name = $image['output']['name'];

            // get the crop data for the output image
            $data = $image['output']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $output = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $output = Slim::saveFile($data, $name, 'tmp/', false);

            // Default call for saving the output data
            $output = Slim::saveFile($data, $name, 'uploaded/pics/');

            // Saving Thumbnail
            if($output){

                $thumbnail = 'tn_'.$output['name'];
                $manager = new ImageManager();
                $width = $manager->make('uploaded/pics/'.$output['name'])->width();
                $img = $manager->make('uploaded/pics/'.$output['name'])
                    ->crop($width,$width,0,0)
                    ->resize(150,150);
                $img->save('uploaded/tmb/'.$thumbnail);

                Image::persistUserImage(Auth::getUser()->id, $output['name']);

            }

        }

        // if we've received input data (do the same as above but for input data)
        if (isset($image['input']['data'])) {

            // get the name of the file
            $name = $image['input']['name'];

            // get the crop data for the output image
            $data = $image['input']['data'];

            // If you want to store the file in another directory pass the directory name as the third parameter.
            // $input = Slim::saveFile($data, $name, 'my-directory/');

            // If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
            // $input = Slim::saveFile($data, $name, 'tmp/', false);

            // Default call for saving the input data
            $input = Slim::saveFile($data, $name,'uploaded/pics/');

        }


        // User Images for display on My Album page
        $images = Image::fetchUserImagesForDisplay(Auth::getUser()->id);
        $num = count($images);

        $album = '';
        foreach($images as $image){
            $album .= '<div class="col-md-4 col-xl-4" id="my-pic-'.$image['img_id'].'">
                    <div class="card mb-4">
                        <img class="card-img-top" src="/uploaded/pics/'.$image['filename'].'">
                        <div class="card-body">
                            <h5 class="card-title text-info">Under Processing</h5>
                            <p class="card-text pb-3">One or more of your photos is under process of approval by our team  </p>
                            <!--<button href="#" class="btn btn-sm btn-outline-primary chgAvt" id="chgAvt-'.$image['img_id'].'" onclick="changeAvatar('.$image['img_id'].')" data-id="'.$image['img_id'].'" data-name="'.$image['filename'].'" value="'.$image['filename'].'">Change Avatar</button>-->
                            <!-- <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>-->
                            <!--<button class="btn btn-outline-danger btn-sm delImage" id="delImage-'.$image['img_id'].'" onclick="deleteImage('.$image['img_id'].')" data-id="'.$image['img_id'].'" data-name="'.$image['filename'].'" value="'.$image['filename'].'">Delete</button>-->
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

    }

}