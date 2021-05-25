@extends('layouts.app')

@section('title', 'Ju Matrimony - Forgot Password')

@section('content')
    <!-- login section -->
    <section class="main">
        <!-- Alert -->
        <!-- <div class="alert alert-danger">
            Invalid Credentials
        </div> -->

        @include('layouts.partials.alert')

        <h3 class="large text-coco">
            Forgot Password ?
        </h3>
        <p class="lead"><i class="fas fa-envelope text-blue"> </i> Enter your email address</p>

        <form action="{{'/password/request-reset'}}" method="post" class="form full-ht">

            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" autofocus required>
            </div>

            <input type="submit" name="forgot-password-submit" value="Send Reset Link" class="btn btn-orange">
        </form>

    </section>
    <!-- login ends -->
@endsection
