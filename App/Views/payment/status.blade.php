@extends('layouts.app')

@section('page_css')


@endsection

@section('content')

    <!-- login section -->
    <section class="main">

        <div class="row">

            <div class="col-md-6 offset-md-3">
                @include('layouts.partials.alert')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card card-default m-2">
                    <div class="card-header justify-content-center">
                        <h3 class="text-{{$color}}" >Payment Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center" style="font-size: 3rem">
                            <span class="text-muted"><small><i class="fas fa-rupee-sign"></i></small> {{ $amount }}</span>
                        </div>
                        <div class="mt-3 mb-4 row justify-content-center">
                            <h5 class="text-muted text-center">Your Transaction<br>
                                <span class="text-{{$color}}">{{$message}}</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- login ends -->

@endsection

@section('js')




@endsection