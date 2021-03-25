@extends('layouts.app')

@section('title', 'Page Title')

{{--@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection--}}

@section('page-css')
    <link href="/assets/plugins/ladda/ladda.min.css" rel="stylesheet" />
    <style>
        .blurytext {
            color: transparent;
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
    </style>
@endsection

@section('content')

    <div class="content">
        <div class="row justify-content-center">
            <!-- ***********************************
            Interest Received by Member
            ************************************ -->
            <div class="col-lg-6">
                <div class="card card-default">
                    <div class="card-header bg-success card-header-border-bottom">
                        <h2>Referral Program </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">List groups are a flexible and powerful component for displaying a series of content. Modify and extend them to support just about any content within. Read bootstrap documentaion for <a href="https://getbootstrap.com/docs/4.4/components/list-group/" target="_blank"> more details.</a></p>
                        <form class="form-inline justify-content-center" action="{{'/referral/join'}}" method="POST">
                            <button type="submit" name="verify-mobile-submit" class="btn btn-success mt-3 mb-3">Join Referral Program</button>
                        </form>
                    </div>
                </div>
            </div>




        </div>



    </div>

@endsection

@section('page-script')
    <script src="/assets/plugins/ladda/spin.min.js"></script>
    <script src="/assets/plugins/ladda/ladda.min.js"></script>
@endsection

@section('app-script')
    {{--@include('scripts.load_notification')
    @include('scripts.load_connected_profiles')--}}
@endsection

