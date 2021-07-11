@extends('layouts.app')

@section('content')

    <div class="main">

        @include('layouts.partials.alert')

        <h1 class="large text-red">
            Account not active
        </h1>
        <p class="lead"><i class="fas fa-info-circle text-blue"> </i> You have not activated your account after registration</p>


        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Resend Activation Link</h4>
            <ul class="pl-3">
                <li> Click on <strong><u>Resend link</u></strong> button below to receive account activation link again</li>
                <li> Now check your registered email address</li>
                <li> Sometimes email goes into <strong><u>Promotions</u></strong> or <strong><u>Spam</u></strong> folder, please double check your email </li>
            </ul>
            <div id="msg" class="mt-3">
                <img src="/img/ring.svg" id="spinner-em" hidden>
                <span id="msg" class="text-success">Your Registered Email </span>
            </div>
            <form class="form-inline">
                <div class="form-group mb-4">
                    <label for="user-email" class="sr-only">Password</label>
                    <input type="email" class="form-control" id="user-email" placeholder="Ur Registered Email" style="width: 16rem !important;" value="{{$email}}" required>
                </div>
                <button type="submit" class="btn btn-blue mb-2 ml-2" id="resend-btn" onclick="initiateAccountActivationProcess()">Resend activation link</button>
            </form>
            <hr>
            <p class="mb-0">JuMatrimony Service ~ Always Free</p>
        </div>

    </div>

@endsection


@section('js')

    <script>

        $(document).ready(function() {

            $("form").submit(function(e){
                e.preventDefault();
            });
        });

        function initiateAccountActivationProcess()
        {
            var em = document.getElementById('user-email').value;
            console.log(em);
            $('#spinner-em').attr('hidden',false);
            $('#msg').attr("hidden");

            $.post("/AjaxRegistration/resendActivationEmail",{
                em:em

            },function (data, status) {
                console.log(data);
                setTimeout(function(){
                    $('#spinner-em').attr('hidden',true);
                    $('#msg').html(data).attr('hidden',false);
                }, 500);
                if(data=='<span class="text-success">Activation link send, please check your email</span>'){
                    $('#resend-btn').attr('disabled',true);
                }
            });
        }

    </script>
@endsection

