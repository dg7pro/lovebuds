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
            Connected Profiles List
            ************************************ -->
            <div class="col-xl-10">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header bg-success justify-content-between ">
                        <h2>Connected Profiles</h2>

                    </div>
                    <div class="card-body slim-scroll py-0 pt-0">
                        <table class="table card-table table-responsive table-responsive-large">
                            <thead>
                            <tr>
                                <th>Prospective {{($authUser->gender==1)?'Bride':'Groom'}}</th>
                                <th class="d-none d-md-table-cell">Career</th>
                                <th>Contact</th>

                            </tr>
                            </thead>
                            <tbody>

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
                        <a href="{{'/account/stats'}}" class="btn-link py-3 text-uppercase">Stats Page</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('page-script')

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

    @include('request.multi_hide_profile')

@endsection

