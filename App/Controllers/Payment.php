<?php


namespace App\Controllers;


use App\Auth;
use App\Config;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Paytm;
use Core\Controller;
use Core\View;

/**
 * Class Payment - Checked but not commented
 * @package App\Controllers
 */
class Payment extends Controller
{
    /**
     * Shows new payment page
     */
    public function newAction(){

        $amount = 200;
        View::renderBlade('payment/new',['amount'=>$amount]);
    }


    /**
     *
     */
    public static function redirectPaymentAction(){

        if($_POST['ORDER_ID'] && $_POST['TXN_AMOUNT']) {

            $orderNo = $_POST['ORDER_ID'];
            $userId = $_SESSION['user_id'];
            $amount  = $_POST['TXN_AMOUNT'];
            $result = Order::save($orderNo,$userId,$amount);

            if(!$result){
                header('Location:/Payment/new');
                exit();
            }

            $checkSum = "";
            $paramList = array();

            $ORDER_ID = $_POST["ORDER_ID"];
            $CUST_ID = $_POST["CUST_ID"];
            $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
            $CHANNEL_ID = $_POST["CHANNEL_ID"];
            $TXN_AMOUNT = $_POST["TXN_AMOUNT"];

            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = "vMhSpe64889597446409";
            $paramList["ORDER_ID"] = $ORDER_ID;
            $paramList["CUST_ID"] = $CUST_ID;
            $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
            $paramList["CHANNEL_ID"] = $CHANNEL_ID;
            $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
            $paramList["WEBSITE"] = 'WEBSTAGING';

            $MSISDN = '9453351473';
            $EMAIL = 'dgkashi@gmail.com';

            $paramList["CALLBACK_URL"] = "http://matrimony.com/Payment/response-payment";
            //$paramList["CALLBACK_URL"] = "http://localhost/jumatrimony/paytm/pgResponse.php";
            $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
            $paramList["EMAIL"] = $EMAIL; //Email ID of customer
            $paramList["VERIFIED_BY"] = "EMAIL"; //
            $paramList["IS_USER_VERIFIED"] = "YES"; //


            //Here checksum string will return by getChecksumFromArray() function.
            $checkSum = Paytm::getChecksumFromArray($paramList, Config::PAYTM_MERCHANT_KEY);

            View::renderBlade('payment/redirect-page', ['paramList' => $paramList, 'checkSum' => $checkSum, 'paytmTxnUrl' => Config::PAYTM_TXN_URL]);

        }
    }


    /**
     *
     */
    public function responsePaymentAction(){

        /*Helpers::dnd($_POST);
        exit();*/

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = Paytm::verifychecksum_e($paramList, '3s&bKIISCD8L%!zE', $paytmChecksum); //will return TRUE or FALSE string.


        if($isValidChecksum == "TRUE") {

            //echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
            if ($_POST["STATUS"] == "TXN_SUCCESS") {

                $result = Order::updateOrderStatus($_POST);
                if($result){
                    User::updateUserPaidStatus(Auth::getUser()->id);
                }
                Notification::save('payment_successful',$_SESSION['user_id']);
                $this->redirect('/payment/success');

            }
            else {

                Order::updateOrderStatus($_POST);
                $this->redirect('/payment/failure');

            }

        }
        else {
            echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
        }

    }

    public static function success(){
        $rung = 'success';
        $message = 'Transaction status is success';
        View::renderBlade('payment/status',['message'=>$message,'rung'=>$rung]);

    }

    public static function failure(){
        $rung = 'danger';
        $message = 'Transaction status is failure';
        View::renderBlade('payment/status',['message'=>$message,'rung'=>$rung]);

    }

}