@extends('layouts.app')

@section('title', 'Page Title')

{{--@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection--}}

@section('app-css')


@endsection

@section('content')

    <div class="content">

        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin'}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Photo Approval</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Users Photo Approval</h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">These users need approval before their photo gets live.</p>

                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-2 col-xl-2" id="{{'my-pic-'.$image->img_id}}">
                                    <div class="card mb-4">
                                        <img class="card-img-top img-responsive" src="{{'/uploaded/pics/'.$image->filename}}">
                                        <div class="card-body">
                                            <p class="mb-2"><span class="{{$image->pp==1?'badge badge-primary text-wrap':''}} ">{{'User Id: '.$image->user_id}}</span></p>

                                            {{--                                            <button class="btn btn-sm btn-outline-primary chgAvt" id="{{'chgAvt-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}" {{$image->pp==1?'disabled':''}}>Change Avatar2</button>--}}

                                            <button type="button" id="{{'reject-'.$image->img_id}}" class="mb-1 btn btn-sm btn-outline-danger reject-photo" value="{{$image->img_id}}" data-id="{{$image->user_id}}">Rjct.</button>
                                            <button type="button" id="{{'approve-'.$image->img_id}}" class="mb-1 btn btn-sm btn-outline-success approve-photo" value="{{$image->img_id}}" data-id="{{$image->user_id}}">Appr.</button>
                                            {{--                                                <button type="button" id="{{'avatar-'.$image->img_id}}" class="mb-1 btn btn-sm btn-info make-avatar" value="{{$image->img_id}}" data-id="{{$image->user_id}}" {{$image->pp==1?'disabled':''}}>P</button>--}}

                                            {{--                                            <button class="btn btn-outline-info btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Approve</button>--}}
                                            {{--                                            <button class="btn btn-outline-warning btn-sm delImage" id="{{'delImage-'.$image->img_id}}" data-id="{{$image->img_id}}" data-name="{{$image->filename}}" value="{{$image->filename}}">Reject</button>--}}
                                        </div>
                                    </div>
                                </div>

                                {{--
                                                                <div class="col-md-2 col-xl-2" id="{{'my-pic-'.$image->img_id}}">

                                                                    <img class="img-responsive" src="{{'uploaded/pics/'.$image->filename}}" width="200px">
                                                                    <button type="button" class="mb-1 btn btn-sm btn-outline-info">Approve</button>
                                                                    <button type="button" class="mb-1 btn btn-sm btn-outline-warning">Reject</button>

                                                                </div>--}}
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    @include('account-approval.basic-info')--}}


@endsection

@section('app-script')
    <script>
        // JU===============================================
        // Approve Photo
        // =================================================
        $(document).ready(function () {
            $('.approve-photo').on('click', function () {

                var imgId = $(this).val();
                var usrId = $(this).data('id');
                var code = "approve-photo";

                console.log('approve btn clicked');
                console.log(imgId);
                console.log(usrId);

                $.ajax({
                    url: "/adjax/approvePhoto",
                    method: 'post',
                    data: {
                        code:code,
                        iid:imgId,
                        uid:usrId
                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(data.msg);
                        console.log(data.iid);
                        console.log(status);
                        if(data.pas === 1){
                            $('#approve-'+data.iid).attr('disabled','disabled');
                            $('#reject-'+data.iid).removeAttr('disabled','disabled');
                        }
                    }
                });
            });
        });

        // JU===============================================
        // Reject Photo
        // =================================================
        $(document).ready(function () {
            $('.reject-photo').on('click', function () {

                var imgId = $(this).val();
                var usrId = $(this).data('id');
                var code = "reject-photo";

                console.log('reject btn clicked');
                console.log(imgId);
                console.log(usrId);

                $.ajax({
                    url: "/adjax/rejectPhoto",
                    method: 'post',
                    data: {
                        code:code,
                        iid:imgId,
                        uid:usrId
                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(data.msg);
                        console.log(data.iid);
                        console.log(status);
                        if(data.pas === 1){
                            $('#reject-'+data.iid).attr('disabled','disabled');
                            $('#approve-'+data.iid).removeAttr('disabled','disabled');
                        }
                    }
                });
            });
        });

        // JU===============================================
        // Make Avatar
        // =================================================
        /*$(document).ready(function () {
            $('.make-avatar').on('click', function () {

                var imgId = $(this).val();
                var usrId = $(this).data('id');
                var code = "make-avatar";

                console.log('avatar btn clicked');
                console.log(imgId);
                console.log(usrId);

                $.ajax({
                    url: "ajax/moderate_photo.php",
                    method: 'post',
                    data: {
                        code:code,
                        iid:imgId,
                        uid:usrId
                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(data.msg);
                        console.log(data.iid);
                        console.log(status);
                        if(data.pas === 1){
                            $('#approve-'+data.iid).attr('disabled','disabled');
                        }
                    }
                });
            });
        });*/
    </script>

@endsection

