@extends('layouts.app')

@section('page_css')
    <style>
        .others {color:black}
    </style>
@endsection

@section('content')

    <!-- registration section -->
    <section class="main">
        <h1 class="large text-heading">
            Sign Up
        </h1>
        <p class="lead"><i class="fas fa-user"> </i> Create Your Account</p>

        <form action="{{'/register/create'}}" class="form" method="post" autocomplete="off">
            <div class="form-group inputWithIcon">
                <select id="cFor" name="cFor" required>
                    <option value='' style="color:gray">Creating profile for</option>
                    @foreach($fors as $for)
                        <option class="others" value="{{$for->id}}">{{$for->name}}</option>
                    @endforeach
                </select>
                <i id="cfor_ok" class="fas fa-check-circle text-green" hidden></i>
            </div>

            <div id="genderDiv">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="male" name="gender" value="1" class="custom-control-input" required>
                    <label class="custom-control-label" for="male">Male</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="female" name="gender" value="2" class="custom-control-input" required>
                    <label class="custom-control-label" for="female">Female</label>
                </div>
            </div>

            <div class="form-group inputWithIcon">
               {{-- <label for="email" style="margin-bottom: 0; padding-left: 0.25rem">Email:
                    <span id="email_msg" class="text-red"></span>
                </label>--}}
                <input type="email" id="email" name="email" placeholder="Email Address" required autocomplete="off" >
                <i id="email_ok" class="fas fa-check-circle text-green" hidden=""></i>
                <i id="email_not_ok" class="fas fa-times-circle text-red" hidden></i>

               {{-- <small id="email_msg" class="text-red" hidden></small>--}}
            </div>
            <div class="form-group inputWithIcon">
                {{--<label for="mobile" style="margin-bottom: 0; padding-left: 0.25rem">Mobile:
                    <span id="mb_msg" class="form-text"></span>
                </label>--}}
                <input type="text" id="mobile" name="mobile" placeholder="Mobile no (10 digits)" required autocomplete="off">
                <i id="mb_ok" class="fas fa-check-circle text-green" hidden=""></i>
                <i id="mb_not_ok" class="fas fa-times-circle text-red" hidden></i>
                <small class="form-text">
                    Primary contact no, OTP will be send on this number
                </small>
            </div>
            <div class="form-group inputWithIcon">
                {{--<label for="newPassword" style="margin-bottom: 0; padding-left: 0.25rem">Password:
                    <span id="pw_msg" class="form-text"></span>
                </label>--}}
                <input type="password" id="newPassword" name="password" placeholder="New Password" minlength="6" required autocomplete="new-password">
                <i id="pw_ok" class="fas fa-check-circle text-green" hidden=""></i>
                <i id="pw_not_ok" class="fas fa-times-circle text-red" hidden></i>
            </div>

            <div class="form-group inputWithIcon">
               {{-- <label for="cPassword" style="margin-bottom: 0; padding-left: 0.25rem">Confirm Password:
                    <span id="cpw_msg" class="form-text"></span>
                </label>--}}
                <input type="password" id="cPassword" name="cPassword" placeholder="Retype Password" minlength="6" required >
                {{--<i id="cpw_not_ok" class="fas fa-times-circle text-red" hidden ></i>--}}
                <i id="cpw_ok" class="fas fa-check-circle text-green" hidden ></i>

            </div>

            <input type="submit" value="Register" class="btn btn-green">
        </form>
        <p class="may-2">Already have an account? <a href="login.html">Sign In</a></p>

    </section>
    <!-- registration ends -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#cFor').on('blur', function () {
                if ($('#newPassword').val() === '') {
                    $('#cfor_ok').attr('hidden',false);
                } else
                    $('#cfor_ok').attr('hidden',true);
            });

            $('#newPassword, #cPassword').on('keyup', function () {
                if ($('#newPassword').val() === $('#cPassword').val()) {
                    //$('#message').html('Matching').css('color', 'green');
                    //$('#cpw_not_ok').attr('hidden',true);
                    $('#cpw_ok').attr('hidden',false);
                } else
                    //$('#message').html('Not Matching').css('color', 'red');
                    $('#cpw_ok').attr('hidden',true);
                    //$('#cpw_not_ok').attr('hidden',false);
            });
        });
    </script>
    <script>
        var password = document.getElementById("newPassword")
            , confirm_password = document.getElementById("cPassword");

        function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>

    <script>
        $(document).ready(function() {
            $('#cFor').css('color','gray');
            $('#cFor').change(function() {
                var current = $('#cFor').val();
                if (current != 'null') {
                    $('#cFor').css('color','black');
                } else {
                    $('#cFor').css('color','gray');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){

            // ==================================
            // Getting Gender
            // Toggle Block to select gender
            // ==================================
            $('#cFor').change(function(){
                var cfor = $(this).children("option:selected").val();
                //alert("You have selected  - " + cfor);
                //console.log(cfor);
                $.ajax({
                    url:"/Ajax/selectGender",
                    method:'POST',
                    data:{cfor:cfor},
                    dataType:"json",
                    success:function (data) {
                        console.log(data);
                        if(data.gender==='ambiguous'){
                            $('#genderDiv').show('slow');
                            $('input[name=gender]').attr('checked', false);
                        }
                        else{

                            $('input[name=gender][value='+data.val+']').attr('checked', true);
                            $('#genderDiv').hide('slow');
                        }

                    }
                });
            });

        });
    </script>

    @include('request.check_email')
    @include('request.check_mobile')
    @include('request.check_password')
{{--    @include('request.check_confirm_password')--}}


@endsection