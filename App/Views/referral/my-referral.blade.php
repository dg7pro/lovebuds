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
                        <!-- Target -->
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" id="foo" value="{{$url}}" placeholder="Right icon" aria-label="Right icon">
                                <div class="input-group-append">
                                    <span class="btn input-group-text ccb" data-clipboard-action="copy" data-clipboard-target="#foo">
                                        <i class="mdi mdi-clipboard-text"></i>
                                    </span>
                                </div>
                            </div>

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
    <!-- 2. Include library -->
    <script src="/js/clipboard.min.js"></script>

    <!-- 3. Instantiate clipboard -->
    <script>
        var clipboard = new ClipboardJS('.ccb');

        clipboard.on('success', function(e) {
            console.log(e);
        });

        clipboard.on('error', function(e) {
            console.log(e);
        });
    </script>
    {{--@include('scripts.load_notification')
    @include('scripts.load_connected_profiles')--}}
@endsection

