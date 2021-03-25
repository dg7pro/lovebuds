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
                    <div class="card-header bg-info card-header-border-bottom">
                        <h2>Basic List </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">List groups are a flexible and powerful component for displaying a series of content. Modify and extend them to support just about any content within. Read bootstrap documentaion for <a href="https://getbootstrap.com/docs/4.4/components/list-group/" target="_blank"> more details.</a></p>
                        <ul class="list-group">
                            <li class="list-group-item text-dark">{{$authUser->gender==1?'Groom:':'Bride:'}} <b><i class="text-primary">{{$authUser->name}}</i></b></li>
                            <li class="list-group-item text-dark">Email:  <b><i class="text-primary">{{$authUser->email}}</i></b>
                                @if($authUser->ev)
{{--                                    <span class="mdi mdi-marker-check mdi-18px"></span>--}}
                                    <span class="mb-2 mr-2 badge badge-pill badge-sm badge-success">Verified</span>
                                @endif
                            </li>
                            <li class="list-group-item text-dark">Mobile:  <b><i class="text-primary">{{$authUser->mobile}}</i></b>
                                @if($authUser->mv)
                                    <span class="mb-2 mr-2 badge badge-pill badge-sm badge-success">Verified</span>
                                @else
                                    <a href="{{'/Account/send-otp-page'}}" role="button" class="ml-2 btn btn-sm btn-info">OTP Verify</a>
                                @endif
                            </li>
                            <li class="list-group-item text-dark">Membership:  <b><i class="text-primary">{{$authUser->is_paid?'Paid':'Free'}}</i></b></li>
                            {{--<li class="list-group-item text-dark">Verified:  <b><i class="text-primary">{{$authUser->is_verified?'Yes':'No'}}</i></b></li>--}}
                            <li class="list-group-item text-dark">Status:  <b><i class="text-primary">{{$authUser->is_active?'Active':'Blocked'}}</i></b></li>
                        </ul>
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

