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
                        <li class="breadcrumb-item active" aria-current="page">Make Avatar</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Make Avatar</h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">SElect the new avatar image for the user as the avatar image was disapproved.</p>

                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-2 col-xl-2" id="{{'my-pic-'.$image->img_id}}">
                                    <div class="card mb-4">
                                        <img class="card-img-top img-responsive" src="{{'/uploaded/pics/'.$image->filename}}">
                                        <div class="card-body">
                                            <p class="mb-2"><span class="badge {{$image->approved==1?'badge-success':'badge-dark'}} text-wrap">{{'User Id: '.$image->user_id}}</span></p>

                                            @if($image->approved == 1)
                                                <button type="button" id="{{'clear-'.$image->img_id}}" class="mb-1 btn btn-sm btn-outline-danger clear-photo" value="{{$image->img_id}}" data-id="{{$image->user_id}}" data-gen="{{$image->gender}}">Clear</button>
                                                <button type="button" id="{{'avatar-'.$image->img_id}}" class="mb-1 btn btn-sm btn-outline-success make-avatar" value="{{$image->img_id}}" data-id="{{$image->user_id}}">Avatar</button>
                                            @else
                                                <button type="button" id="{{'clear-'.$image->img_id}}" class="mb-1 btn btn-sm btn-outline-danger clear-photo" value="{{$image->img_id}}" data-id="{{$image->user_id}}" disabled>Clear</button>
                                                <button type="button" id="{{'avatar-'.$image->img_id}}" class="mb-1 btn btn-sm btn-outline-success make-avatar" value="{{$image->img_id}}" data-id="{{$image->user_id}}" disabled>Avatar</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--@include('account-approval.basic-info')--}}


@endsection

@section('app-script')
    <script>
        // JU===============================================
        // Make avatar
        // =================================================
        $(document).ready(function () {
            $('.make-avatar').on('click', function () {

                var imgId = $(this).val();
                var usrId = $(this).data('id');
                var code = "set-avatar";

                console.log('avatar btn clicked');
                console.log(imgId);
                console.log(usrId);


                $.ajax({
                    url: "/adjax/changeAvatar",
                    method: 'post',
                    data: {
                        code:code,
                        iid:imgId,
                        uid:usrId,

                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(data.msg);
                        console.log(data.iid);
                        console.log(status);
                        if(data.pas === 1){
                            $('#avatar-'+data.iid).attr('disabled','disabled');
                            $('#clear-'+data.iid).attr('disabled','disabled');
                        }
                    }
                });
            });
        });

        // JU===============================================
        // Reject Photo
        // =================================================
        $(document).ready(function () {
            $('.clear-photo').on('click', function () {

                var imgId = $(this).val();
                var usrId = $(this).data('id');
                var usrGen = $(this).data('gen');
                var code = "clear-avatar";

                console.log('clear btn clicked');
                console.log(imgId);
                console.log(usrId);
                console.log(usrGen);

                $.ajax({
                    url: "ajax/moderate_photo.php",
                    method: 'post',
                    data: {
                        code:code,
                        iid:imgId,
                        uid:usrId,
                        gen:usrGen
                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(data.msg);
                        console.log(data.iid);
                        console.log(status);
                        if(data.pas === 1){
                            $('#clear-'+data.iid).attr('disabled','disabled');
                            $('#avatar-'+data.iid).attr('disabled','disabled');
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

