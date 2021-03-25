@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <h3 class="text-muted mb-5">{{$authUser->name}}</h3>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-3">
                <div class="card card-default" data-scroll-height="500">
                    <div class="card-header justify-content-between align-items-center card-header-border-bottom">
                        <h2>Latest Notifications</h2>
                        <div>
                            <button class="text-black-50 mr-2 font-size-20"><i class="mdi mdi-cached"></i></button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-notification">
                                    <li class="dropdown-item"><a href="#">Action</a></li>
                                    <li class="dropdown-item"><a href="#">Another action</a></li>
                                    <li class="dropdown-item"><a href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="card-body slim-scroll">
                        @foreach($notifications as $notice)
                            <div class="media py-3 align-items-center justify-content-between">
                                <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-{{$notice->color}} text-white">
                                    <i class="{{'mdi '.$notice->icon}} font-size-20"></i>
                                </div>
                                <div class="media-body pr-3 ">
                                    <a class="mt-0 mb-1 font-size-15 text-dark" href="#">{{$notice->sub}}</a>
{{--                                    <p ><a class="mt-0 mb-1 text-primary" href="{{'/profile/'.$notice->pid}}">{{$notice->pid}}</a>{{' '.$notice->msg}}</p>--}}
                                    <p><a class="mt-0 mb-1 text-primary" href="{{$notice->url}}">{{' '.$notice->msg}}</a></p>
                                </div>
                                <span class=" font-size-12 d-inline-block"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                            </div>
                        @endforeach

                    </div>
                    <div class="mt-3"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('app-script')

@endsection
