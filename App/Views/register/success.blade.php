@extends('layouts.app')

@section('content')

    <section class="main">
        <h3>Account Created Successfully</h3>
        <p class="lead"><i class="fa fa-envelope text-green"> </i> Please check your email for account activation link</p>

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Important!</h4>
            <ul class="ml-3">
                <li> Account Activation link has been send to your registered email address</li>
                <li> Click on <strong><u>Activate my Account</u></strong> button to activate your account </li>
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








    <!--Start of Tawk.to Script-->
    {{--<script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/610665ce649e0a0a5cceec12/1fc0frd2m';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>--}}
    <!--End of Tawk.to Script-->

@endsection