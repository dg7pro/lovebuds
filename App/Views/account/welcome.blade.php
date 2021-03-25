@extends('layouts.app')

@section('title', 'Page Title')

@section('page-css')

@endsection

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-12">
                @include('layouts.partials.flash')
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- User activity statistics -->
                <div class="card card-default" id="user-activity">
                    <div class="row no-gutters">
                        <div class="col-xl-8">
                            <div class="border-right">
                                <div class="card-header justify-content-between py-5">
                                    <h2>Welcome:<span class="text-info ml-1">{{ucfirst($authUser->first_name).' '.ucfirst($authUser->last_name)}}</span></h2>

                                </div>
                                <ul class="nav nav-tabs nav-style-border justify-content-between justify-content-xl-start border-bottom" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active pb-md-0" data-toggle="tab" href="#iSend" role="tab" aria-controls="iSend" aria-selected="true">
                                            <span class="type-name">Send</span>
                                            <h4 class="d-inline-block mr-2 mb-3">{{count($isToProfiles)}}</h4>
                                            <span style="color: tomato">Interest
                                          <i class="mdi mdi-telegram"></i>
                                        </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pb-md-0" data-toggle="tab" href="#iReceived" role="tab" aria-controls="iReceived" aria-selected="false">
                                            <span class="type-name">Received</span>
                                            <h4 class="d-inline-block mr-2 mb-3">{{count($irFromProfiles)}}</h4>
                                            <span class="text-primary">Interest
                                          <i class="mdi mdi-telegram mdi-rotate-180"></i>
                                        </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pb-md-0" data-toggle="tab" href="#Connected" role="tab" aria-controls="Connected" aria-selected="false">
                                            <span class="type-name">Connected</span>
                                            <h4 class="d-inline-block mr-2 mb-3">{{count($cProfiles)}}</h4>
                                            <span class="text-success ">Profiles
                                          <i class="mdi mdi-swap-horizontal-bold"></i>
                                        </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link pb-md-0" data-toggle="tab" href="#Shortlisted" role="tab" aria-controls="Shortlisted" aria-selected="false">
                                            <span class="type-name">Shortlisted</span>
                                            <h4 class="d-inline-block mr-2 mb-3">{{count($sProfiles)}}</h4>
                                            <span class="text-warning ">Profiles
                                          <i class="mdi mdi-star"></i>
                                        </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane pt-3 fade show active" id="iSend" role="tabpanel" aria-labelledby="home2-tab">
                                            @foreach($isToProfiles as $isp)
                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                                        <a href="{{'/profile/'.$isp->pid}}"><img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$isp->avatar}}" alt="customer image"></a>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <h6><a class="mt-0 mb-1 text-primary" href="{{'/profile/'.$isp->pid}}">{{$isp->fn}}</a></h6>
                                                        <p>{{Carbon\Carbon::createFromDate($isp->dob)->age.'yrs'}}, {{$isp->edu}}, {{$isp->occ}}</p>
                                                        {{--<p>{{ 'You have send interest: '.Carbon\Carbon::createFromTimeStamp(strtotime($isp->created_at))->diffForHumans()}}</p>--}}
                                                    </div>
                                                    <div class="dropdown show d-inline-block widget-dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false" data-display="static"></a>
                                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                                            <li class="dropdown-item">
                                                                <a href="{{'/profile/'.$isp->pid}}">View</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="#">Remove</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane pt-3 fade" id="iReceived" role="tabpanel" aria-labelledby="profile2-tab">
                                            @foreach($irFromProfiles as $irp)
                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                                        {{--<i class="mdi mdi-cart-outline font-size-20"></i>--}}
                                                        <a href="{{'/profile/'.$irp->pid}}"><img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$irp->avatar}}" alt="customer image"></a>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <h6><a class="mt-0 mb-1 text-primary" href="{{'/profile/'.$irp->pid}}">{{$irp->fn}}</a></h6>
                                                        <p>{{Carbon\Carbon::createFromDate($irp->dob)->age.'yrs'}}, {{$irp->edu}}, {{$irp->occ}}</p>
                                                        {{--<p >{{ 'Has send you the interest: '.Carbon\Carbon::createFromTimeStamp(strtotime($irp->created_at))->diffForHumans()}}</p>--}}
                                                    </div>
                                                    {{--<span class=" font-size-12 d-inline-block">20th Oct 2019<i class="mdi mdi-clock-outline ml-2"></i> 10 AM</span>--}}
                                                    <div class="dropdown show d-inline-block widget-dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false" data-display="static"></a>
                                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                                            <li class="dropdown-item">
                                                                <a href="{{'/profile/'.$irp->pid}}">View</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="#">Remove</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane pt-3 fade" id="Connected" role="tabpanel" aria-labelledby="contact2-tab">
                                            @foreach($cProfiles as $cop)
                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                                        {{--<i class="mdi mdi-cart-outline font-size-20"></i>--}}
                                                        <a href="{{'/profile/'.$cop->pid}}"><img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$cop->avatar}}" alt="customer image"></a>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <h6><a class="mt-0 mb-1 text-primary" href="{{'/profile/'.$cop->pid}}">{{$cop->fn}}</a></h6>
                                                        <p>{{Carbon\Carbon::createFromDate($cop->dob)->age.'yrs'}}, {{$cop->edu}}, {{$cop->occ}}</p>
                                                        {{--<p >{{ 'Connected: '.Carbon\Carbon::createFromTimeStamp(strtotime($cop->updated_at))->diffForHumans().'. You can see the contact no. of this member'}}</p>--}}
                                                    </div>
                                                    {{--<span class=" font-size-12 d-inline-block">20th Oct 2019<i class="mdi mdi-clock-outline ml-2"></i> 10 AM</span>--}}
                                                    <div class="dropdown show d-inline-block widget-dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false" data-display="static"></a>
                                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                                            <li class="dropdown-item">
                                                                <a href="{{'/profile/'.$cop->pid}}">View</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="#">Remove</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane pt-3 fade" id="Shortlisted" role="tabpanel" aria-labelledby="contact2-tab">
                                            @foreach($sProfiles as $fav)
                                                <div class="media py-3 align-items-center justify-content-between">
                                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                                        {{--<i class="mdi mdi-cart-outline font-size-20"></i>--}}
                                                        <a href="{{'/profile/'.$fav->pid}}"><img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$fav->avatar}}" alt="customer image"></a>
                                                    </div>
                                                    <div class="media-body pr-3">
                                                        <h6><a class="mt-0 mb-1 text-primary" href="{{'/profile/'.$fav->pid}}">{{$fav->fn}}</a></h6>
                                                        <p>{{Carbon\Carbon::createFromDate($fav->dob)->age.'yrs'}}, {{$fav->edu}}, {{$fav->occ}}</p>
                                                        {{--<p >{{ 'Shortlisted: '.Carbon\Carbon::createFromTimeStamp(strtotime($fav->created_at))->diffForHumans()}}</p>--}}
                                                    </div>
                                                    {{--<span class=" font-size-12 d-inline-block">20th Oct 2019<i class="mdi mdi-clock-outline ml-2"></i> 10 AM</span>--}}
                                                    <div class="dropdown show d-inline-block widget-dropdown">
                                                        <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-recent-order5" data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false" data-display="static"></a>
                                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order5">
                                                            <li class="dropdown-item">
                                                                <a href="{{'/profile/'.$fav->pid}}">View</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="#">Remove</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex flex-wrap bg-white border-top">
                                    <a href="{{'/Account/stats'}}" class="text-uppercase py-3">Statical Dashboard</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div data-scroll-height="642">
                                <div class="card-header pt-5 flex-column align-items-start">
                                    <h4 class="text-muted mb-1">{{ucfirst($authUser->first_name).' '.ucfirst($authUser->last_name)}}</h4>
                                    <div class="mb-3">
                                        <p class="my-2">Profile Id: {{$authUser->pid}}</p>
                                        <a href="{{'/Profile/'.$authUser->pid}}"><h6 class="text-info">View Profile<i class="mdi mdi-link-variant ml-1"></i></h6></a>
                                    </div>
                                </div>
                                <div class="border-bottom"></div>
                                <div class="card-body">

                                    <div class="img-responsive img-thumbnail rounded" style="width: min-content">
                                        @if($image!=null)
                                            <img src="{{'/uploaded/pics/'.$image->filename}}" class="img-circle" alt="User Image" width="225px" height="auto"/>
                                        @else
                                            <img src="{{'/images/'.($authUser->gender==1?'groom-grayscale.jpg':'bride-grayscale.jpg')}}" alt="User Image" width="225px" height="auto"/>
                                        @endif

                                        <a href="{{'/Account/my-album'}}">
                                            <h6 class="text-muted text-center mt-2 mb-1">
                                                <i class="mdi mdi-camera-iris ml-1"></i>
                                                Update Album
                                            </h6></a>
                                    </div>
                                </div>
                                <div class="card-footer d-flex flex-wrap bg-white border-top">
                                    <a href="{{'/Account/my-profile'}}" class="text-uppercase py-3">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <!-- ***********************************
            Recommended Profiles
            ************************************ -->
            <div class="col-xl-4 mb-5">
                <h4 class="mb-2 mt-1">{{empty($rProfiles)?'':'Recommended Profiles'}}</h4>
                <div class="list-group">
                    @foreach($rProfiles as $rep)
                        <a href="{{'/profile/'.$rep->pid}}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <div class="media py-1 align-items-center justify-content-between">
                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                        <img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$rep->avatar}}" alt="customer image">
                                    </div>
                                    <div class="media-body pr-2">
                                        <h6 class="mb-1" >{{$rep->fn}}</h6>
                                        <p style="font-size: unset" >{{Carbon\Carbon::createFromDate($rep->dob)->age.'yrs'}}, {{' '.$rep->ft}}, {{$rep->rel}}, {{$rep->com}},
                                            {{$rep->occ}}</p>
                                    </div>
                                    <div class="d-flex ml-2">
                                        <button type="button" class="btn btn-google-plus btn-square">
                                            <i class="mdi mdi-telegram"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- ***********************************
            New Members
            ************************************ -->
            <div class="col-xl-4 mb-5">
                <h4 class="mb-2 mt-1">{{empty($nProfiles)?'':'New Members'}}</h4>
                <div class="list-group">

                    @foreach($nProfiles as $nep)
                        <a href="{{'/profile/'.$nep->pid}}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <div class="media py-1 align-items-center justify-content-between">
                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                        {{--<i class="mdi mdi-cart-outline font-size-20"></i>--}}
                                        <img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$nep->avatar}}" alt="customer image">
                                    </div>
                                    <div class="media-body pr-2">
                                        <h6 class="mb-1" >{{$nep->fn}}</h6>
                                        <p style="font-size: unset" >{{Carbon\Carbon::createFromDate($nep->dob)->age.'yrs'}}, {{$nep->ft}}, {{$nep->rel}}, {{$nep->com}},
                                            {{$nep->occ}}</p>
                                    </div>
                                    <div class="d-flex ml-2">
                                        {{--<button type="button" class="mb-1 btn btn-sm btn-outline-danger">Danger</button>--}}
                                        <button type="button" class="btn btn-vimeo btn-square">
                                            <i class="mdi mdi-telegram"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- ***********************************
            Recent Profile 3
            ************************************ -->
            <div class="col-xl-4 mb-5">
                <h4 class="mb-2 mt-1">{{empty($vProfiles)?'':'Recent Visitors'}}</h4>
                <div class="list-group">
                    @foreach($vProfiles as $pvs)
                        <a href="{{'/profile/'.$pvs->pid}}" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <div class="media py-1 align-items-center justify-content-between">
                                    <div class="d-flex rounded-circle align-items-center justify-content-center mr-3">
                                        {{--<i class="mdi mdi-cart-outline font-size-20"></i>--}}
                                        <img class="rounded-circle w-45" src="{{'/uploaded/tmb/tn_'.$pvs->avatar}}" alt="customer image">
                                    </div>
                                    <div class="media-body pr-2">
                                        <h6 class="mb-1" >{{$pvs->fn}}</h6>
                                        <p style="font-size: unset" >{{Carbon\Carbon::createFromDate($pvs->dob)->age.'yrs'}}, {{$pvs->ft}}, {{$pvs->rel}}, {{$pvs->com}},
                                            {{$pvs->occ}}</p>
                                    </div>
                                    <div class="d-flex ml-2">
                                        {{--<button type="button" class="mb-1 btn btn-sm btn-outline-danger">Danger</button>--}}
                                        <button type="button" class="btn btn-twitter btn-square">
                                            <i class="mdi mdi-telegram"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>


        </div>
    </div>

@endsection

@section('page-script')

@endsection

@section('app-script')

    {{--Welcome page is already auth protected--}}
    @include('request.last_online')
{{--    @include('request.load_notification')--}}

    @if(empty($authUser->short_array))
        @include('request.add_random_shortlist')
    @endif

@endsection

