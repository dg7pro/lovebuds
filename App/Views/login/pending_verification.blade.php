@extends('layouts.app')

@section('content')

    <div class="main">

        @include('layouts.partials.alert')

        <h1 class="large text-red">
            Account not active
        </h1>
        <p class="lead"><i class="fas fa-info-circle text-blue"> </i> Either verify your email or mobile to continue...</p>


        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Verify my Mobile</h5>
                        <p class="card-text">OTP will be send on your registered mobile: <span class="font-weight-bold text-blue">{{$user->mobile}}</span>
                            Verification is done to avoid fake and spam profiles</p>
                        {{--<a href="{{'/login/verifyThroughMobile'}}" class="btn btn-orange">Send OTP on mobile</a>--}}
                        <a href="{{'/sriganesh/throughMobile'}}" class="btn btn-orange">Send OTP on mobile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Verify my Email</h5>
                        <p class="card-text">Verification link will be send on your registered email: <span class="font-weight-bold text-blue">{{$user->email}}</span></p>
                        <a href="{{'/register/verify-email'}}" class="btn btn-pink">Send Verification Email</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection