@extends('layouts.app')

@section('title', 'Page Title')

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
            <div class="col-xl-5">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header bg-info justify-content-between">
                        <h2>Interest Received</h2>
                        {{--<div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-customar"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-customar">
                                    <li class="dropdown-item"><a  href="#">Action</a></li>
                                    <li class="dropdown-item"><a  href="#">Another action</a></li>
                                    <li class="dropdown-item"><a  href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>--}}
                    </div>
                    <div class="card-body slim-scroll py-0 pt-0">
                        <table class="table ">
                            <tbody>

                            @foreach($profiles2 as $profile)
                                <tr class="{{'ir-'.$profile->id}}">
                                    <td >
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="{{'/profile/'.$profile->pid}}"><img class="rounded-circle w-45" src="{{($profile->avatar!='')?'/uploaded/tmb/tn_'.$profile->avatar:'/assets/img/user/u1.jpg'}}" alt="customer image"></a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="{{'/profile/'.$profile->pid}}"><h6 class="mt-0 text-muted font-weight-medium">{{$profile->fn.' '.$profile->ln}}</h6></a>
                                                <small class="text-secondary">{{Carbon\Carbon::createFromDate($profile->dob)->age.'yrs'}} | {{$profile->ft}} | {{$profile->dis}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <button class="btn btn-info btn-sm btn-square accept-interest" id="{{'ir-'.$profile->id}}" data-id="{{$profile->id}}">Accept</button>

                                        {{--<button class="ladda-button btn btn-info btn-sm btn-square btn-ladda accept-interest" id="{{'ir-'.$profile->id}}" data-id="{{$profile->id}}" data-style="contract">
                                            <span class="ladda-label" >Accept</span>
                                            <span class="ladda-spinner"></span>
                                        </button>--}}
                                    </td>
                                    <td class="text-dark d-none d-md-block"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-4">
                        <a href="{{'/account/interest-received'}}" class="btn-link py-3 text-uppercase">View All</a>
                    </div>
                </div>
            </div>

            <!-- ***********************************
            Interest Send by Member
            ************************************ -->
            <div class="col-xl-5">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header justify-content-between" style="background-color: pink">
                        <h2>Interest Send</h2>
                        {{--<div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-customar"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-customar">
                                    <li class="dropdown-item"><a  href="#">Action</a></li>
                                    <li class="dropdown-item"><a  href="#">Another action</a></li>
                                    <li class="dropdown-item"><a  href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>--}}
                    </div>
                    <div class="card-body slim-scroll py-0 pt-0">
                        <table class="table ">
                            <tbody>
                            @foreach($profiles as $isp)
                                <tr>
                                    <td >
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="{{'/profile/'.$isp->pid}}"><img class="rounded-circle w-45" src="{{($isp->avatar!='')?'/uploaded/tmb/tn_'.$isp->avatar:'/assets/img/user/u1.jpg'}}" alt="customer image"></a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="{{'/profile/'.$isp->pid}}"><h6 class="mt-0 text-muted font-weight-medium">{{$isp->fn.' '.$isp->ln}}</h6></a>
                                                <small class="text-secondary">{{Carbon\Carbon::createFromDate($isp->dob)->age}} | {{$isp->ft}} | {{$isp->dis}}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td >
                                        <button class="btn btn-danger btn-sm btn-square remind-interest" id="{{'remind-'.$isp->id}}" data-id="{{$isp->id}}" >Remind</button>

                                        {{--<button class="ladda-button btn btn-danger btn-sm btn-square btn-ladda remind-interest" id="{{'remind-'.$isp->id}}" data-id="{{$isp->id}}"  data-style="contract">
                                            <span class="ladda-label">Remind</span>
                                            <span class="ladda-spinner spinner-border-sm"></span>
                                        </button>--}}
                                    </td>
                                    <td class="text-dark d-none d-md-block"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-4">
                        <a href="{{'/account/interest-send'}}" class="btn-link py-3 text-uppercase">View All</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <!-- ***********************************
            Connected Profiles List
            ************************************ -->
            <div class="col-xl-10">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header bg-success justify-content-between ">
                        <h2>Connected Profiles</h2>
                        {{--<div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-customar"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-customar">
                                    <li class="dropdown-item"><a  href="#">Action</a></li>
                                    <li class="dropdown-item"><a  href="#">Another action</a></li>
                                    <li class="dropdown-item"><a  href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>--}}
                    </div>
                    <div class="card-body slim-scroll py-0 pt-0">
                        <table class="table card-table table-responsive table-responsive-large">
                            <thead>
                            <tr>
                                <th>Prospective {{($authUser->gender==1)?'Bride':'Groom'}}</th>
                                <th class="d-none d-md-table-cell">Career</th>
                                <th>Contact</th>
                                {{-- <th class="d-none d-md-table-cell">Order Cost</th>
                                 <th>Status</th>
                                 <th></th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            {{-- Under Testing below tr--}}
                            {{--<tr>
                                <td >
                                    <div class="media">
                                        <div class="media-image mr-3 rounded-circle">
                                            <a href="profile.html"><img class="rounded-circle w-45" src="/assets/img/user/u3.jpg" alt="customer image"></a>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <a href="profile.html"><h6 class="mt-0 text-dark font-weight-medium">Larissa Gebhardt</h6></a>
                                            <small>24yrs | 5'3" | Varanasi</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell pt-0"><div style="font-size: 0.96rem">MBA Finance, Working as Manager</div></td>
                                <td style="font-size: 0.96rem">
                                    <i class="mdi mdi-cellphone-basic mr-1" style="font-size: 1.2rem"></i>{{'9335333717'}}<br>
                                    <i class="mdi mdi-email-check-outline mr-1"></i>{{'dgkashi@gmail.com'}}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown show d-inline-block widget-dropdown">
                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false" data-display="static"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                            <li class="dropdown-item">
                                                <a href="#">View</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#">Remove</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>--}}

                            @foreach($profiles3 as $cop)
                                <tr>
                                    <td >
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="{{'/profile/'.$cop->pid}}"><img class="rounded-circle w-45" src="{{($cop->avatar!='')?'/uploaded/tmb/tn_'.$cop->avatar:'/assets/img/user/u1.jpg'}}" alt="customer image"></a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="{{'/profile/'.$cop->pid}}"><h5 class="mt-0 text-dark font-weight-medium">{{$cop->fn}}</h5></a>
                                                <small>{{Carbon\Carbon::createFromDate($cop->dob)->age}} | {{$cop->ft}} | {{$cop->dis}}</small>
                                            </div>
                                        </div>
                                    </td>
{{--                                    <td class="d-none d-md-table-cell"><div>MBA Finance, Working as Manager</div></td>--}}
                                    <td class="d-none d-md-table-cell"><div>{{$cop->edu.' '.$cop->occ}}</div></td>
                                    <td>
                                        @if($authUser->is_paid)
                                            <i class="mdi mdi-cellphone-basic mr-1" style="font-size: 1.2rem"></i><span>{{$cop->mobile}}</span><br>
                                            <i class="mdi mdi-email-check-outline mr-1"></i>{{$cop->email}}
                                        @else
                                            <i class="mdi mdi-cellphone-basic mr-1" style="font-size: 1.2rem"></i><span class="blurytext" title="Become verified member to see contacts">{{'5434678543'}}</span><br>
                                            <i class="mdi mdi-email-check-outline mr-1"></i><span class="blurytext" title="Become verified member to see contacts">{{'emailxxx@domain.com'}}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown show d-inline-block widget-dropdown">
                                            <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" data-display="static"></a>
                                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                                <li class="dropdown-item">
                                                    <a href="{{'/profile/'.$cop->pid}}">View</a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="javascript:0" class="hide-profile" data-id="{{$cop->id}}">Remove</a>

                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-4">
                        <a href="{{'/account/connected-profiles'}}" class="btn-link py-3 text-uppercase">View All</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <!-- ***********************************
            Shortlisted Profiles
            ************************************ -->
            <div class="col-xl-5">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header bg-primary justify-content-between">
                        <h2>Shortlisted Profiles</h2>
                        {{--<div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-customar"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-customar">
                                    <li class="dropdown-item"><a  href="#">Action</a></li>
                                    <li class="dropdown-item"><a  href="#">Another action</a></li>
                                    <li class="dropdown-item"><a  href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>--}}
                    </div>
                    <div class="card-body slim-scroll py-0 pt-0">
                        <table class="table ">
                            <tbody>
                            @foreach($profiles4 as $fav)
                                <tr>
                                    <td >
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="{{'/profile/'.$fav->pid}}"><img class="rounded-circle w-45" src="{{($fav->avatar!='')?'/uploaded/tmb/tn_'.$fav->avatar:'/assets/img/user/u1.jpg'}}" alt="customer image"></a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="{{'/profile/'.$fav->pid}}"><h6 class="mt-0 text-muted font-weight-medium">{{$fav->fn.' '.$fav->ln}}</h6></a>
                                                <small class="text-secondary">{{Carbon\Carbon::createFromDate($fav->dob)->age}} | {{$fav->ft}} | {{$fav->dis}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <a href="{{'/profile/'.$fav->pid}}" class="btn btn-primary btn-sm btn-square">Full Profile</a>

                                        {{--@if(in_array($fav->id,$connected))
                                            <button class="btn btn-success btn-sm btn-square" id="{{'fav-'.$fav->id}}" data-id="{{$fav->id}}" >Connected</button>
                                        @elseif(in_array($fav->id,$received))
                                            <button class="btn btn-primary btn-sm btn-square" id="{{'fav-'.$fav->id}}" data-id="{{$fav->id}}" >Accept</button>
                                        @elseif(in_array($fav->id,$send))
                                            <button class="btn btn-primary btn-sm btn-square" id="{{'fav-'.$fav->id}}" data-id="{{$fav->id}}" >Remind</button>
                                        @else
                                            <button class="btn btn-primary btn-sm btn-square" id="{{'fav-'.$fav->id}}" data-id="{{$fav->id}}" >Sent</button>
                                        @endif--}}


                                        {{--<button class="ladda-button btn btn-success btn-sm btn-square btn-ladda" data-style="contract">
                                            <span class="ladda-label">Connect</span>
                                            <span class="ladda-spinner spinner-border-sm"></span>
                                        </button>--}}
                                    </td>
                                    <td class="text-dark d-none d-md-block"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-4">
                        <a href="{{'/account/shortlisted-profiles'}}" class="btn-link py-3 text-uppercase">View All</a>
                    </div>
                </div>
            </div>

            <!-- ***********************************
            Hidden/Removed Profiles
            ************************************ -->
            <div class="col-xl-5">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header justify-content-between bg-danger">
                        <h2>Hidden Profiles</h2>
                        {{--<div>
                            <button class="text-black-50 mr-2 font-size-20">
                                <i class="mdi mdi-cached"></i>
                            </button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-customar"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-customar">
                                    <li class="dropdown-item"><a  href="#">Action</a></li>
                                    <li class="dropdown-item"><a  href="#">Another action</a></li>
                                    <li class="dropdown-item"><a  href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>--}}
                    </div>
                    <div class="card-body slim-scroll py-0 pt-0">
                        <table class="table ">
                            <tbody>
                            @foreach($profiles5 as $hip)
                                <tr>
                                    <td >
                                        <div class="media">
                                            <div class="media-image mr-3 rounded-circle">
                                                <a href="{{'/profile/'.$hip->pid}}"><img class="rounded-circle w-45" src="{{($hip->avatar!='')?'/uploaded/tmb/tn_'.$hip->avatar:'/assets/img/user/u1.jpg'}}" alt="customer image"></a>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <a href="{{'/profile/'.$hip->pid}}"><h6 class="mt-0 text-muted font-weight-medium">{{$hip->fn.' '.$hip->ln}}</h6></a>
                                                <small class="text-secondary">{{Carbon\Carbon::createFromDate($hip->dob)->age}} | {{$hip->ft}} | {{$hip->dis}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td >
                                        <a href="{{'/profile/'.$hip->pid}}" class="btn btn-dark btn-sm btn-square">Full Profile</a>

                                        {{--<button class="ladda-button btn btn-success btn-sm btn-square btn-ladda" data-style="contract">
                                            <span class="ladda-label">Connect</span>
                                            <span class="ladda-spinner spinner-border-sm"></span>
                                        </button>--}}
                                    </td>
                                    <td class="text-dark d-none d-md-block"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-4">
                        <a href="{{'/account/hided-profiles'}}" class="btn-link py-3 text-uppercase">View All</a>
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
    <script>
        /*======== 5. TOASTER ========*/
        var toaster = $('#toaster');
        function callToaster(positionClass, message) {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: positionClass,
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            toastr.success(message);
        }

    </script>

    <script>
        function AjaxOnCompleteDisableButton() {
            e.preventDefault();
        }
    </script>

    @include('request.last_online')
    @include('request.load_notification')

    @include('request.multi_connect_profile')
    @include('request.multi_remind_profile')
    @include('request.multi_hide_profile')
{{--    @include('request.multi_un_hide_profile')--}}
@endsection

