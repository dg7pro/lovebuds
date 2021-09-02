<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Aadhar;
use App\Slim\Slim;
use App\Slim\SlimStatus;
use Exception;

class Verification extends Authenticated
{

    /**
     * Aadhar Front
     * Handles Asynchronously image upload
     * process of the user
     */
    public function aadharFrontAction(){


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
            $output = Slim::saveFile($data, $name, 'uploads/aadhar/');

            // Saving Thumbnail
            if($output){

                $newImage = new Aadhar();
                $newImage->persistUserAadhar(Auth::getUser(), $output['name'],'front');

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
            $input = Slim::saveFile($data, $name,'uploads/aadhar/');

        }


        // User Images for display on My Album page
        $image = Aadhar::fetchUserAadharFront(Auth::getUser()->id);
        $num = ($image)?1:0;

        $album = '<img class="my-aadhars" src="/uploads/aadhar/'.$image['filename'].'">';



        //
        // Build response to client
        //
        $response = array(
            'status' => SlimStatus::SUCCESS,
            'album' => $album,
            'num' => $num,
            'tag' => 'front'
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


    /**
     * Aadhar Back
     * Handles Asynchronously image upload
     * process of the user
     */
    public function aadharBackAction(){


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
            $output = Slim::saveFile($data, $name, 'uploads/aadhar/');

            // Saving Thumbnail
            if($output){

                $newImage = new Aadhar();
                $newImage->persistUserAadhar(Auth::getUser(), $output['name'],'back');

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
            $input = Slim::saveFile($data, $name,'uploads/aadhar/');

        }


        // User Images for display on My Album page
        $image = Aadhar::fetchUserAadharBack(Auth::getUser()->id);
        $num = ($image)?1:0;

        $album = '<img class="my-aadhars" src="/uploads/aadhar/'.$image['filename'].'">';



        //
        // Build response to client
        //
        $response = array(
            'status' => SlimStatus::SUCCESS,
            'album' => $album,
            'num' => $num,
            'tag' => 'back'
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