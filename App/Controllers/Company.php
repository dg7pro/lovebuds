<?php


namespace App\Controllers;


use Core\Controller;
use Core\View;

/**
 * Class Company
 * @package App\Controllers
 */
class Company extends Controller
{

    /**
     * Show tabs page of Companies TnC
     */
    public function infoAction(){
        View::renderBlade('company.info');
    }

    /**
     * Show about us page
     */
    public function aboutUsAction(){
        View::renderBlade('company.about-us');
    }

    /**
     * Show T&C page
     */
    public function tncAction(){
        View::renderBlade('company.tnc');
    }

    /**
     * Show Privacy Policy page
     */
    public function privacyPolicyAction(){
        View::renderBlade('company.privacy-policy');
    }

    /**
     *  Show Refund Policy
     */
    public function refundPolicyAction(){
        View::renderBlade('company.refund-policy');
    }

    /**
     * Show Contact us page
     */
    public function contactUsAction(){
        View::renderBlade('company.contact-us');
    }

    /**
     * Show Disclaimer
     */
    public function disclaimerAction(){
        View::renderBlade('company.disclaimer');
    }

    /**
     * Help and how to use
     */
    public function helpAction(){
        View::renderBlade('company.help');
    }

    /**
     * Feedback form
     */
    public function feedbackAction(){

        header("Location: https://docs.google.com/forms/d/e/1FAIpQLSe09c_f_oaWJCRwUTqQTqW2roCXMKPKZOa7d2cejikACg46ow/viewform?usp=sf_link");
        exit();
    }

}