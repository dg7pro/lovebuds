@extends('layouts.app')

@section('title', 'Page Title')

{{--@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection--}}

@section('page-css')

    <!-- PLUGINS CSS STYLE -->
    {{--    <link href="public/assets/plugins/nprogress/nprogress.css" rel="stylesheet" />--}}

    <!-- No Extra plugin used -->
    {{--    <link href="public/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />--}}

    {{--    <link href="public/assets/plugins/toastr/toastr.min.css" rel="stylesheet" />--}}




@endsection

@section('content')

    <div class="content">

        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin'}}">Home</a></li>
                        {{--<li class="breadcrumb-item active" aria-current="page">Data</li>--}}
                    </ol>
                </nav>
            </div>
        </div>


        <!-- First Row  -->
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="{{'/admin/new-account'}}">
                    <div class="media widget-media p-4 bg-white border">
                        <div class="icon rounded-circle mr-4 bg-primary">
                            <i class="mdi mdi-account-outline text-white "></i>
                        </div>
                        <div class="media-body align-self-center">
                            <h4 class="text-primary mb-2">{{$new}}</h4>
                            <p style="color: #8a909d">New Accounts</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="{{'/admin/photo-approval'}}">
                    <div class="media widget-media p-4 bg-white border">
                        <div class="icon rounded-circle bg-info mr-4">
                            <i class="mdi mdi-camera-image text-white "></i>
                        </div>
                        <div class="media-body align-self-center">
                            <h4 class="text-primary mb-2">{{$uap}}</h4>
                            <p>Photo Approval</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="{{'/admin/pending-kyc'}}">
                    <div class="media widget-media p-4 bg-white border">
                        <div class="icon rounded-circle mr-4 bg-danger">
                            <i class="mdi mdi-account-details text-white "></i>
                        </div>
                        <div class="media-body align-self-center">
                            <h4 class="text-primary mb-2">{{$uak}}</h4>
                            <p>Pending KYC</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="{{'/admin/total-revenue'}}">
                    <div class="media widget-media p-4 bg-white border">
                        <div class="icon bg-success rounded-circle mr-4">
                            <i class="mdi mdi-currency-inr text-white "></i>
                        </div>
                        <div class="media-body align-self-center">
                            <h4 class="text-primary mb-2">{{$total_revenue}}</h4>
                            <p>Total Revenue</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="{{'/admin/make-avatar'}}">
                    <div class="media widget-media p-4 bg-white border">
                        <div class="icon rounded-circle bg-warning mr-4">
                            <i class="mdi mdi-face-profile text-white "></i>
                        </div>
                        <div class="media-body align-self-center">
                            <h4 class="text-primary mb-2">{{$auc}}</h4>
                            <p>Avatar Update</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
@endsection

@section('page-script')
    {{--    <script src="public/assets/plugins/charts/Chart.min.js"></script>--}}
    {{--    <script src="public/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>--}}
    {{--    <script src="public/assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>--}}
@endsection

