@extends('layouts.app')

@section('title', 'Ju Matrimony - Forgot Password')

@section('content')
    <!-- login section -->
    <section class="main">

        @include('layouts.partials.alert')

        <h3 class="large text-coco">
            Forgot Password ?
        </h3>
        <p class="lead"><i class="fas fa-envelope text-blue"> </i> Enter your email address</p>

        <form action="{{'/password/request-reset'}}" method="post" class="form full-ht">

            <div>
                <input type="hidden" name="token" value="{{$_SESSION['csrf_token']}}" />
                {{--<input type="hidden" name="token" value="65f575dd7ba89dbd08a02a86bf990514eb8182254f9af1299d75cd1f92a7ec1" />--}}
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" autofocus required>
            </div>

            <input type="submit" name="forgot-password-submit" value="Send Reset Link" class="btn btn-orange">
        </form>

    </section>
    <!-- login ends -->
@endsection
