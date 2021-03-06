@extends('layouts.app')

@section('content')

    <!-- login section -->
    <section class="main">

        @include('layouts.partials.alert')

        <h1 class="large text-green">
            Sign In
        </h1>
        <p class="lead"><i class="fas fa-user"> </i> Sign Into Your Account</p>

        <form action="{{'/login/authenticate'}}" method="post" class="form">

            <div>
                <input type="hidden" name="token" value="{{$_SESSION['csrf_token']}}" />
            </div>
            <div class="form-group inputWithIcon">
                <input type="email" id="uid" name="uid" placeholder="Email Address" required>
                <i class="fas fa-check-circle text-green" hidden></i>
            </div>
            <div class="form-group inputWithIcon">
                <input type="password" id="password" name="password" placeholder="Password" minlength="8" required>
                <i class="fas fa-times-circle text-red" hidden></i>
            </div>
            <div class="form-group">
                <input type="checkbox" id="remember-me" value="remember_me" name="remember_me" checked>
                <label for="remember-me">Remember me</label>
            </div>

            <input type="submit" name="login-submit" value="Log In" class="btn btn-orange">
            <a href="{{'/password/forgot'}}">Forgot Password ?</a>
        </form>
        <p class="may-2">Don't have an account yet? <a href="{{'/register'}}">Sign Up</a></p>
    </section>
    <!-- login ends -->

@endsection