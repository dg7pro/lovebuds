@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="content">							<div class="row">
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card card-default">
                    <div class="card-header justify-content-center bg-info">
                        <h2 class="text-dark" >Your Account is Active now</h2>
                    </div>
                    <div class="card-body pt-0 mt-5">
                        <div class="row justify-content-center" style="font-size: 3rem;">
                            <i class="mdi mdi-check-decagram"></i>
                        </div>
                        <div class="mt-3 mb-4 row justify-content-center">
                            <h4 class="text-muted text-center">
                                <span class="text-info ">You can now <a href="{{'/Login/index'}}">login to continue.</a> Happy surfing!</span>
{{--                                <span class="text-info ">Success! Your account is now active. You can now <a href="{{'/Login/index'}}">log in</a></span>--}}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection