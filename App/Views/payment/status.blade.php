@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="content">							<div class="row">

            <div class="col-md-6 offset-md-3">
                @include('layouts.partials.alert')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card card-default">
                    <div class="card-header justify-content-center">
                        <h2 class="text-info" >Order Status</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row justify-content-center" style="font-size: 3rem">
                            <i class="mdi mdi-currency-inr"></i> 200
                        </div>
                        <div class="mt-3 mb-4 row justify-content-center">
                            <h5 class="text-muted text-center">Your Transaction<br>
                                <span class="text-{{$rung}}">{{$message}}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



