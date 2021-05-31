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

    /*public function aboutUsAction(){
        View::renderBlade('company.about-us');
    }

    public function tncAction(){
        View::renderBlade('company.tnc');
    }

    public function privacyPolicyAction(){
        View::renderBlade('company.privacy-policy');
    }

    public function refundPolicyAction(){
        View::renderBlade('company.refund-policy');
    }

    public function contactUsAction(){
        View::renderBlade('company.contact-us');
    }*/

}