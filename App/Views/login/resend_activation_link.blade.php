@extends('layouts.app')

@section('content')

    <div class="main">

        @include('layouts.partials.alert')

        <h1 class="large text-red">
            Account not active
        </h1>
        <p class="lead"><i class="fas fa-info-circle text-blue"> </i> You have not activated your account after registration</p>


        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Resend Activation Link</h4>
            <ul>
                <li><i class="fas fa-angle-right"></i> Click on <strong><u>Resend link</u></strong> button below to receive account activation link again</li>
                <li><i class="fas fa-angle-right"></i> Now check your registered email address</li>
                <li><i class="fas fa-angle-right"></i> Sometimes email goes into <strong><u>Promotions</u></strong> or <strong><u>Spam</u></strong> folder, please double check your email </li>
                {{-- <li><i class="fas fa-angle-right"></i> Click <strong><u>Activate my Account</u></strong> button inside email </li>--}}
            </ul>


            {{--<p class="mb-0"></p>--}}

            <div id="msg" class="mt-3">
                <img src="/images/ring.svg" id="spinner-em" hidden>
                <span id="msg" class="text-success">Your Registered Email </span>
            </div>
            <form class="form-inline mt-3">
                <div class="form-group mb-2">
                    <label for="user-email" class="sr-only">Email</label>
                    <input type="email" class="form-control" id="user-email" value="{{$email}}" placeholder="Your email" style="width: 16rem !important;" required>
                </div>
                <input type="submit" id="resend-btn" onclick="initiateAccountActivationProcess()" class="btn btn-primary mb-2 ml-2" value="Resend activation link">
            </form>
            {{--<div id="msg" hidden> </div>--}}
            {{--<button onclick="initiateAccountActivationProcess()" id="user-email" value="{{$email}}" type="button" class="mb-1 mt-3 btn btn-primary">Resend activation link</button>--}}
            <hr>
            <p class="mb-0">Happy Learning - from RSLectures.com</p>
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

            $.post("/Ajax/resendActivationEmail",{
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

            /*$('#spinner-em').attr('hidden',false);
            $('#msg').attr("hidden");
            $.ajax({
                url:"/Ajax/resendActivationEmail",
                method:'POST',
                data:{em:em},
                success:function (data) {
                    console.log(data);
                    setTimeout(function(){
                        $('#spinner-em').attr('hidden',true);
                        $('#msg').html(data).attr('hidden',false);
                    }, 500);
                }
            });*/

        }




    </script>
@endsection

