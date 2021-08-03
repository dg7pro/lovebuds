@extends('layouts.app')

@section('content')

    <section class="main">
        <h2 class="text-blue mb-3">Manage Album</h2>
        <p class="lead">
            <i class="fas fa-images text-blue"></i>
            {{ucfirst($authUser->first_name)}} you can manage your photos here: change avatar, delete, upload new etc
        </p>
        <div>
            @foreach($images as $image)
                <div id="{{'my-pic-'.$image->img_id}}">
                    <div class="media d-flex mt-4 mb-4">
                        <div class="media-image align-self-center mr-3 rounded">
                            <a href="#"><img src="{{'/uploaded/pics/'.$image->filename}}" alt="customer image" width="145px" height="auto"></a>
                        </div>
                        <div class="media-body align-self-center">

                            @if($image->approved==1)
                                <h6 class="mb-3 text-success font-weight-medium"> Approved</h6>
                                <p class="d-none d-md-block">Only approved images are visible to others, this is done for moderation.</p>
                                <p class="mb-0 mt-1">
                                    <button class="btn btn-sm btn-green chgAvt {{$image->pp==1?'disabled':''}}" id="{{'chgAvt-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}" {{$image->pp==1?'disabled':''}}>Make Avatar</button>
                                    <button class="btn btn-coco btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>
                                </p>
                            @elseif($image->approved==2)
                                <h6 class="mb-3 text-danger font-weight-medium"> Rejected</h6>
                                <p class="d-none d-md-block">This photo has not been approved by moderation, delete & upload new one.</p>
                                <p class="mb-0 mt-1">
                                    <button class="btn btn-sm btn-green chgAvt disabled" id="{{'chgAvt-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}" {{$image->pp==1?'disabled':''}} disabled>Make Avatar</button>
                                    <button class="btn btn-coco btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Delete</button>
                                </p>
                            @else
                                <h6 class="mb-3 text-info font-weight-medium"> Pending Approval</h6>
                                <p class="d-none d-md-block">This photo is under process of approval by our team.</p>
                                <p class="mb-0 mt-1">
                                    <button class="btn btn-sm btn-primary chgAvt disabled" disabled>Make Avatar</button>
                                    <button class="btn btn-danger btn-sm delImage disabled" disabled>Delete</button>
                                </p>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            <a href="{{'/account/dashboard'}}" class="btn btn-sm btn-yellow"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Dashboard</a>
            <a href="{{'/account/my-album'}}" class="btn btn-sm btn-pink">Upload Page</a>
            {{--<a href="{{'/account/dashboard'}}" class="btn btn-sm btn-yellow">Go to Dashboard</a>--}}
        </div>

    </section>

@endsection

@section('js')

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

                var fn = $(this).val();
                var iid = $(this).data('id');

                console.log('delete clicked 1');
                console.log(fn);
                console.log(iid);

                $.confirm({
                    title: 'Delete Image Permanently',
                    content: 'You can upload the new one afterwards',
                    icon: 'fa fa-heart',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Delete',
                            btnClass: 'btn-red',
                            action: function () {
                                $.ajax({
                                    url: "/AjaxActivity/delete-image",
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
                                        setTimeout(function () {
                                            toastr.success(data.msg);
                                        }, 500);
                                    }
                                });
                            }
                        },
                        cancel: function () {
                        },
                    }

                });
            });
        });

        // Deprecated
        $(document).ready(function () {
            $('.delImagenbnb').on('click', function () {

                var r = window.confirm("Are you sure?");

                if(r == true) {

                    var fn = $(this).val();
                    var iid = $(this).data('id');

                    console.log('delete clicked 1');
                    console.log(fn);
                    console.log(iid);

                    $.ajax({
                        url: "/AjaxActivity/delete-image",
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
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                        }
                    });
                }
            });
        });

        $(document).ready(function () {
            $('.chgAvt').on('click', function () {

                var fn = $(this).val();             // filename
                var iid = $(this).data('id');       // image id
                console.log('avatar clicked');
                console.log(fn);
                console.log(iid);

                $.confirm({
                    title: 'Change Avatar',
                    content: 'Are you sure to change your avatar',
                    icon: 'fa fa-heart',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'confirm': {
                            text: 'Change',
                            btnClass: 'btn-blue',
                            action: function(){
                                $.ajax({
                                    url: "/AjaxActivity/change-avatar",
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
                                        setTimeout(function(){
                                            toastr.success(data.msg);
                                        }, 500);

                                    }
                                });
                            }
                        },
                        cancel: function(){},
                    }
                });

            });
        });

        // Deprecated
        $(document).ready(function () {
            $('.chgAvtnbnb').on('click', function () {

                var r = window.confirm("Are you sure?");

                if(r == true) {

                    var fn = $(this).val();             // filename
                    var iid = $(this).data('id');       // image id

                    console.log('avatar clicked');
                    console.log(fn);
                    console.log(iid);

                    $.ajax({
                        url: "/AjaxActivity/change-avatar",
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
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                        }
                    });
                }
            });
        });

    </script>

@endsection
