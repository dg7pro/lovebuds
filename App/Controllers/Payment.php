<?php

namespace App\Controllers;

use App\Auth;
use App\Flash;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Reference;
use App\Models\Setting;
use App\Models\User;
use App\Paytm;
use Core\Controller;
use Core\View;

class Payment extends Controller
{

    /**
     * This is Instant offer only for new users
     * Totally separate from Offer and Coupon System
     */
    public function instaOfferPageAction(){

        $this->requireLogin();
        //echo 'Insta offer page';

        // Intensely not to be redirected coz insta offer is always low
        /*if(Offer::isGoingOn()){
            $this->redirect('/payment/offer-page');
        }*/

        // Check if insta offer is applicable
        $user = Auth::getUser();
        if(!$user->isNew()){
            Flash::addMessage('Instant offer is only applicable within 24 hrs of Signup', Flash::WARNING);
            $this->redirect('/payment/pricing-plans');
        }

        $first_offer = Offer::getFirst();
        View::renderBlade('payment/offer_page',['offer'=>$first_offer]);
    }


    /**
     * Offers have priority over Coupon:
     * When offers are running no coupon is valid
     */
    public function offerPageAction(){

        //echo 'this page will show current offer';

        $this->requireLogin();

        if(!$this->isOfferOngoing()){

            $this->redirect('/payment/pricing-plans');
        }

        $current_offer = Offer::getCurrent();

        View::renderBlade('payment/offer_page',['offer'=>$current_offer]);

    }

    /**
     * Coupon system is for inter-offer periods for old users
     * If offer is running it will be redirected to Offers page
     */
    public function couponPageAction(){

        $this->requireLogin();

//        $setting = new Setting();
//        $is_offer = $setting->is_ongoing_current_offer();
//
//        if($is_offer){
//            $this->redirect('/payment/offer-page');
//        }

        //echo 'this page will show coupon';

        View::renderBlade('payment/coupon_page');

    }


    public function checkAction(){

        var_dump($_POST);
    }

    /**
     * Redirects to the PayTM
     * payment gateway
     */
    public function redirectPaymentAction(){

        // This page requires login
        $this->requireLogin();

        if($_POST['ORDER_ID'] && $_POST['TXN_AMOUNT']) {

            Order::save($_SESSION['user_id'],$_POST);

            $paramList = array();

            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = $_ENV['PAYTM_MERCHANT_ID'];
            $paramList["ORDER_ID"] = $_POST["ORDER_ID"];
            $paramList["CUST_ID"] = $_POST["CUST_ID"];
            $paramList["INDUSTRY_TYPE_ID"] = $_POST["INDUSTRY_TYPE_ID"];
            $paramList["CHANNEL_ID"] = $_POST["CHANNEL_ID"];
            $paramList["TXN_AMOUNT"] = $_POST["TXN_AMOUNT"];
            $paramList["WEBSITE"] = 'WEBSTAGING';

            $paramList["CALLBACK_URL"] = 'https://' . $_SERVER['HTTP_HOST'] . '/payment/response-payment';
            //$paramList["CALLBACK_URL"] = 'http://local.lovebuds.com/payment/response-payment';
            $paramList["MSISDN"] = Auth::getUser()->mobile; //Mobile number of customer
            $paramList["EMAIL"] = Auth::getUser()->email; //Email ID of customer
            $paramList["VERIFIED_BY"] = "EMAIL"; //
            $paramList["IS_USER_VERIFIED"] = "YES"; //

            //Here checksum string will return by getChecksumFromArray() function.
            $checkSum = Paytm::getChecksumFromArray($paramList, $_ENV['PAYTM_MERCHANT_KEY']);

            View::renderBlade('payment/redirect-page', ['paramList' => $paramList, 'checkSum' => $checkSum, 'paytmTxnUrl' => $_ENV['PAYTM_TXN_URL'] ]);

        }
    }

    /**
     * Response send by Paytm
     */
    public function responsePaymentAction(){

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = FALSE;

        $paramList = $_POST;
        $paytmChecksum = $_POST["CHECKSUMHASH"] ?? ""; //Sent by Paytm pg

        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = Paytm::verifychecksum_e($paramList,  $_ENV['PAYTM_MERCHANT_KEY'], $paytmChecksum); //will return TRUE or FALSE string.


        if($isValidChecksum == TRUE) {

            if ($_POST["STATUS"] == "TXN_SUCCESS") {

                $amount = $_POST['TXNAMOUNT'];
                $orderId = $_POST['ORDERID'];
                $reason = $_POST['RESPMSG'];

                //echo "Transaction Success";

                Order::updateOrderStatus($_POST);

                $currentOrder = Order::findByOrderId($_POST['ORDERID']);

                $user = User::findByID($currentOrder->user_id);
                //$user->becomePaid();
                if($user->becomePaid()){
                    $ref = new Reference();
                    $ref->setCommission($user->referral,$amount);
                }

                //var_dump($_POST);

                View::renderBlade('payment/_success',['amount'=>$amount,'order'=>$orderId,'reason'=>$reason]);
            }
            else {

                //echo "Transaction Failed";
                Order::updateOrderStatus($_POST);

                //var_dump($_POST);

                $amount = $_POST['TXNAMOUNT'];
                $orderId = $_POST['ORDERID'];
                $reason = $_POST['RESPMSG'];

                View::renderBlade('payment/_failure',['amount'=>$amount,'order'=>$orderId,'reason'=>$reason]);

            }
            //View::renderBlade('payment/status',['message'=>$message,'color'=>$color,'amount'=>$amount,'orderId'=>$orderId]);


        }
        else {
            echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
        }

    }

    public function pricingPlansAction(){

        $isOffer = static::isOfferOngoing();
        //$this->requireLogin();
        View::renderBlade('payment/pricing-plan',['isOffer'=>$isOffer]);


    }

    protected function isOfferOngoing(){
        $setting = new Setting();
        return $setting->is_ongoing_current_offer();
    }

    public function statusAction(){

        $amount = 200;
        $orderId = 'ORDS98130789815';
        $dueTo = 'Your payment has been declined by your bank. Please try again or use a different method to complete the payment.';
        //$message = 'Transaction vide order id: '. 'ORDS98130789815'.'<br>' .' failed';
        View::renderBlade('payment/_success',['amount'=>$amount,'order'=>$orderId,'reason'=>$dueTo]);


    }

}