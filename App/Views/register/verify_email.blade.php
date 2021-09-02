@extends('layouts.app')

@section('content')

    <section class="main">
        <h3>Email Verification</h3>
        <p class="lead"><i class="fa fa-envelope text-green"> </i> Please check your email for verification link</p>

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Important!</h4>
            <ul class="ml-3">
                <li> Email verification link has been send to your registered email address</li>
                <li> It help us ensure that you are the <strong><u>real owner</u></strong> of that email id </li>
                <li> Sometimes email goes into <strong><u>Promotions</u></strong> or <strong><u>Spam</u></strong> folder, please double check your email </li>
            </ul>
            <hr>
            <p class="mb-0">~Team JuMatrimony</p>
        </div>



        <div id="first_message"></div>
        <div id="second_message"></div>

    </section>

@endsection

@section('js')

    <script>
        $(document).ready(function () {

            $sender = '<img src="/img/sender.gif" alt="sender" height="50px" width="auto">Sending...';
            $msg = '<div class="alert alert-warning" role="alert">Message has been successfully send to your email, you will receive it within few seconds</div>';
            $msg2 = '<div class="alert alert-warning" role="alert">Due to huge traffic, sometime it may take a while, but definitely you will receive the email </div>';

            setTimeout(function(){
                $('#first_message').html($sender);
            }, 10000);
            setTimeout(function(){
                $('#first_message').html($msg);
            }, 25000);
            setTimeout(function(){
                $('#second_message').html($msg2);
            }, 50000);


        });
    </script>

@endsection