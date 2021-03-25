@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <h3 class="text-muted mb-5">{{$authUser->name}}</h3>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <!-- Top Products -->
                <div class="card card-default">
                    <div class="card-header justify-content-between align-items-center card-header-border-bottom">
                        <h2>Your Profile Album</h2>
                        {{--<div>
                            <button class="text-black-50 mr-2 font-size-20"><i class="mdi mdi-cached"></i></button>
                            <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="#" role="button" id="dropdown-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-notification">
                                    <li class="dropdown-item"><a href="#">Action</a></li>
                                    <li class="dropdown-item"><a href="#">Another action</a></li>
                                    <li class="dropdown-item"><a href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>--}}
                    </div>

                    <div class="card-body py-0">
                        @foreach($images as $image)
                        <div id="{{'my-pic-'.$image->img_id}}">
                            <div class="media d-flex mt-4 mb-4">
                            <div class="media-image align-self-center mr-3 rounded">
                                <a href="#"><img src="{{'/uploaded/pics/'.$image->filename}}" alt="customer image" width="145px" height="auto"></a>
                            </div>
                            <div class="media-body align-self-center">
                                {{--<h6 class="mb-3 text-success font-weight-medium"> Approved</h6>
                                <p class="d-none d-md-block">Only approved images are visible to others, this is done for moderation.</p>
                                <p class="mb-0 mt-1">
                                    <button class="btn btn-sm btn-outline-primary chgAvt">Make Avatar</button>
--}}{{--                                    <button class="btn btn-outline-danger btn-sm delImage"  id="{{'delImage-'.$image->img_id}}" onclick="deleteImage({{$image->img_id}}); return false;" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>--}}{{--
                                    <button class="btn btn-outline-danger btn-sm delImage"  id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>
                                </p>--}}

                                @if($image->approved==1)
                                    <h6 class="mb-3 text-success font-weight-medium"> Approved</h6>
                                    <p class="d-none d-md-block">Only approved images are visible to others, this is done for moderation.</p>
                                    <p class="mb-0 mt-1">
                                        <button class="btn btn-sm btn-outline-primary chgAvt" id="{{'chgAvt-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}" {{$image->pp==1?'disabled':''}}>Make Avatar</button>
                                        <button class="btn btn-outline-danger btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>
                                    </p>
                                @elseif($image->approved==2)
                                    <h6 class="mb-3 text-danger font-weight-medium"> Rejected</h6>
                                    <p class="d-none d-md-block">This photo has not been approved by moderation, delete & upload new one.</p>
                                    <p class="mb-0 mt-1">
                                        <button class="btn btn-sm btn-outline-primary chgAvt disabled" id="{{'chgAvt-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}" {{$image->pp==1?'disabled':''}} disabled>Make Avatar</button>
                                        <button class="btn btn-outline-danger btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>
                                    </p>
                                @else
                                    <h6 class="mb-3 text-info font-weight-medium"> Pending Approval</h6>
                                    <p class="d-none d-md-block">This photo is under process of approval by our team.</p>
                                    <p class="mb-0 mt-1">
                                        <button class="btn btn-sm btn-outline-primary chgAvt disabled" disabled>Make Avatar</button>
                                        <button class="btn btn-outline-danger btn-sm delImage disabled" disabled>Delete</button>
                                    </p>
                                @endif

                            </div>
                            {{--<div class="media-body align-self-center">
                                    <a href="#"><h6 class="mb-3 text-dark font-weight-medium"> Coach Swagger</h6></a>
                                    <p class="float-md-right"><span class="text-dark mr-2">20</span>Sales</p>
                                    <p class="d-none d-md-block">Statement belting with double-turnlock hardware adds “swagger” to a simple.</p>
                                    <p class="mb-0">
                                        <del>$300</del>
                                        <span class="text-dark ml-3">$250</span>
                                    </p>
                                </div>--}}
                        </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
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
        // if(toaster.length != 0){
        //
        //     if (document.dir != "rtl") {
        //         callToaster("toast-top-right");
        //     } else {
        //         callToaster("toast-top-left");
        //     }
        //
        // }

    </script>


    <script>

        // JU===============================================
        // Handle deletion of Image (Non Ajax Load)
        // =================================================

        $(document).ready(function () {
            $('.delImage').on('click', function () {

                var r = window.confirm("Are you sure?");

                if(r == true) {

                    var fn = $(this).val();
                    var iid = $(this).data('id');

                    console.log('delete clicked 1');
                    console.log(fn);
                    console.log(iid);

                    $.ajax({
                        //url: "slim/delete-image.php",
                        url: "/ajax/delete-image",
                        method: 'post',
                        data: {
                            fn: fn,
                            iid: iid
                        },
                        dataType: "json",
                        success: function (data, status) {
                            console.log(data.msg);
                            console.log(data.iid);
                            console.log(data.ds);
                            console.log(status);

                            if (data.ds === 1) {
                                $('#my-pic-' + data.iid).hide('slow');
                            }

                            var message = data.msg;
                            if (toaster.length != 0) {
                                if (document.dir != "rtl") {
                                    callToaster("toast-top-right", message);
                                } else {
                                    callToaster("toast-top-left", message);
                                }
                            }

                        }
                    });
                }
            });
        });


        $(document).ready(function () {
            $('.chgAvt').on('click', function () {

                var r = window.confirm("Are you sure?");

                if(r == true) {

                    var fn = $(this).val();             // filename
                    var iid = $(this).data('id');       // image id

                    console.log('avatar clicked');
                    console.log(fn);
                    console.log(iid);

                    $.ajax({
                        url: "/ajax/change-avatar",
                        method: 'post',
                        data: {
                            iid: iid,
                            fn: fn
                        },
                        dataType: "json",
                        success: function (data, status) {
                            console.log(data.msg);
                            console.log(data.iid);
                            console.log(status);
                            $('.chgAvt').removeAttr('disabled');
                            $('#chgAvt-' + data.iid).attr('disabled', 'disabled');

                        }
                    });
                }
            });
        });



        /*function deleteImage(imageId){

            var iid = imageId;
            var fn = $('#delImage-'+imageId).val();

            console.log('delete clicked 7');
            console.log(fn);
            console.log(iid);

            $.ajax({
                // url: "slim/delete-image.php",
                url: "/ajax/delete-image",
                method: 'post',
                data: {
                    fn:fn,
                    iid:iid
                },
                dataType: "json",
                success: function (data, status) {
                    console.log(data.msg);
                    console.log(data.iid);
                    console.log(data.ds);
                    console.log(status);

                    if(data.ds === 1){
                        $('#my-pic-'+data.iid).hide('slow');
                    }

                    var message = data.msg;
                    if(toaster.length != 0){
                        if (document.dir != "rtl") {
                            callToaster("toast-top-right",message);
                        } else {
                            callToaster("toast-top-left",message);
                        }
                    }

                }
            });
        }*/


    </script>



@endsection
