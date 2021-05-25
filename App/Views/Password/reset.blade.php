@extends('layouts.app')

@section('title', 'Ju Matrimony - Forgot Password')

@section('content')
    <!-- login section -->
    <section class="main">

        @include('layouts.partials.alert')

        <h3 class="large text-coco">
            Reset Password ?
        </h3>
        <p class="lead"><i class="fas fa-unlock-alt text-green"> </i> Enter new password</p>

        <form action="{{'/password/reset-password'}}" method="POST" class="form full-ht">

            <input type="hidden" name="token" value="{{ $token }}" />

            <div class="form-group">
                <input type="password" id="password" name="password"  placeholder="New password" required>
            </div>

            <div class="form-group">
                <input type="password" id="cPassword" name="confirm_password" placeholder="Confirm password">
            </div>

            <input type="submit" name="reset-password-submit" value="Reset Password" class="btn btn-orange">
        </form>

    </section>
    <!-- login ends -->

@endsection

@section('js')
    <script>
        var password = document.getElementById("password")
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


@endsection