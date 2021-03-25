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
                                    </td>
                                    <td class="text-dark d-none d-md-block"></td>
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

    @include('request.multi_connect_profile')
   {{-- @include('request.multi_remind_profile')
    @include('request.multi_hide_profile')--}}
    {{--    @include('request.multi_un_hide_profile')--}}
@endsection

