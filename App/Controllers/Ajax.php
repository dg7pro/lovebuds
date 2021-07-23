<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Notification;
use App\Models\RecordContact;
use Core\Controller;


/**
 * Class Ajax
 * @package App\Controllers
 */
class Ajax extends Controller
{

    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /**
     * @param $server
     * @param $headers
     * @return array
     */
    protected function checkRequest($server, $headers): array
    {

        $err = [];

        if(!empty($server['HTTP_X_REQUESTED_WITH']) &&
            strtolower($server['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            $err = array(
                'status' => 400,
                'message' => "Not a ajax request sorry!"
            );

        }

        /*if(!empty($_SERVER['HTTP_REFERER']) &&
            $_SERVER['HTTP_REFERER']!="https://www.jumatrimony.com/") {
            $err = array(
                'status' => 400,
                'message' => "Referrer is not our JUMatrimony"
            );
        }*/

        if (isset($headers['CsrfToken'])) {
            if ($headers['CsrfToken'] !== $_SESSION['csrf_token']) {

                $err = array(
                    'status' => 400,
                    'message' => "Wrong CSRF token"
                );
            }
        } else {
            $err = array(
                'status' => 400,
                'message' => "No CSRF token."
            );

        }
        return $err ;
    }

    /**
     * Just includes repeated
     * lines of code
     */
    protected function includeCheck(){

        header('Content-Type: application/json');
        $headers = apache_request_headers();

        $err = $this->checkRequest($_SERVER,$headers);
        if(!empty($err)){
            http_response_code(400);
            echo json_encode($err);
            exit();
        }
    }

    /**
     *  Fetch all unread notifications
     */
    public function unreadNotifications(){

        $this->includeCheck();

        if(isset($_POST['readrecord'])){

            $data = '';
            $results = Notification::fetchAll($_SESSION['user_id']);
            $num = count($results);

            if($num>0){
                foreach($results as $notify) {
                    $data .= '<div data-id="'.$notify->id.'" class="alert alert-info alert-dismissible fade show" role="alert">
                        '. $notify->message .'
                        <button type="button" class="close" data-dismiss="alert" onclick="marNotification('.$notify->id.')" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';

                }
            }else{
                $data .= '<div class="alert alert-light" role="alert">
                              -- No new notification found --
                            </div>';
                //$data .= '<a class="btn btn-pink" href="/account/thrash" role="button">Trash Box</a>';
            }
            echo json_encode($data);
            //echo $data;
        }
    }

    /**
     * Mark notifications read
     */
    public function marNotification(){

        $this->includeCheck();

        $msg ='';
        if(isset($_POST['aid'])){
            $result = Notification::markAsRead($_POST['aid']);
            if($result){
                $msg = 'Marked as read, will be automatically deleted in 30days ';
            }else{
                $msg = 'Some thing went wrong';
            }
        }

        $data = ['msg'=>$msg];
        echo json_encode($data);
    }

}