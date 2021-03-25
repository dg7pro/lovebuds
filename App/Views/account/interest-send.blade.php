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
            Interest Send by Member
            ************************************ -->
            <div class="col-xl-5">
                <div class="card card-table-border-none"  data-scroll-height="580">
                    <div class="card-header justify-content-between" style="background-color: pink">
                        <h2>Interest Send</h2>

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
    @include('request.multi_remind_profile')

@endsection

