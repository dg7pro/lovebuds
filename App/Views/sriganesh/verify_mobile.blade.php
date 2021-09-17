@extends('layouts.app')

@section('page_css')
    <style>

        .card {
            width: 350px;
            padding: 10px;
            border-radius: 20px;
            background: #fff;
            border: none;
            height: 420px;
            position: relative
        }

        body {
            background: #eee
        }

        .mobile-text {
            color: #989696b8;
            font-size: 15px
        }

        .form-control {
            margin-right: 12px
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #13ea61;
            outline: 0;
            box-shadow: none
        }

        .cursor {
            cursor: pointer
        }
    </style>
@endsection
@section('content')

    <section class="main">
        @include('layouts.partials.alert')
        @if($authUser)
            <div class="d-flex justify-content-center align-items-center mb-2">
                <button type="button" id="generate-persist" class="btn btn-lg btn-blue" onclick="startOtpVerification()">Request 4 digit OTP</button>
            </div>
        @endif
        <div class="d-flex justify-content-center align-items-center">

            <div class="card py-5 px-4">
                <h5 class="m-0">Mobile phone verification</h5>
                <span class="mobile-text">Enter the code we just send on your mobile phone <b class="text-green">{{'+91 '.$mobile}}</b></span>
                <form action="{{'/sriganesh/match-otp'}}" method="POST">
                    <div class="d-flex flex-row mt-5">
                        <input type="text" id="txt1" class="form-control" name="txt1" autofocus="" maxlength="1" onkeyup="move(event,' ','txt1','txt2')" required>
                        <input type="text" id="txt2" class="form-control" name="txt2" maxlength="1" onkeyup="move(event,'txt1','txt2','txt3')" required>
                        <input type="text" id="txt3" class="form-control" name="txt3" maxlength="1" onkeyup="move(event,'txt2','txt3','txt4')" required>
                        <input type="text" id="txt4" class="form-control" name="txt4" maxlength="1" onkeyup="move(event,'txt3','txt4',' ')" required>
                    </div>
                    <div class="text-center pr-2">
                        {{--                    <input type="submit" value="Register" class="btn btn-green">--}}
                        <input type="submit" class="btn btn-green btn-block mt-5 pr-2" name="submit-otp" value="Submit">
                    </div>
                </form>
                <div class="text-center mt-5">
                    <span class="d-block mobile-text">Don't receive the code?</span>
                    <span class="font-weight-bold text-primary cursor">Resend</span>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('js')

    <script>
        function move(e, p, c, n){
            console.log(e);
            var length = document.getElementById(c).value.length;
            var maxlength = document.getElementById(c).getAttribute("maxlength");
            //console.log(length);
            //console.log(maxlength);
            console.log(n);
            if(length == maxlength){
                if(n !== ' '){
                    document.getElementById(n).focus();
                }
            }
            if(e.key == 'Backspace'){
                if(p !== ' '){
                    document.getElementById(p).focus();
                }
            }
        }

        function startOtpVerification(){
            console.log('Raksha Bandan');

            $.ajax({

                url: "/AjaxActivity/generate-persist-otp",
                method: 'post',
                data: {},
                dataType:"json",
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                    if(data.flag){
                        $('#generate-persist').html('OTP Send...').attr('disabled','disabled');
                        $('#txt1').focus();

                    }

                    //$('#hide-profile').addClass('disabled');
                }
            });

        }

        $(document).ready(function () {


        });
    </script>

@endsection