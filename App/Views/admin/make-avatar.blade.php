@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Change Avatar
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Make Avatar</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($images==null)
            <span>No record found...</span>
        @endif


        <div class="row">
            @foreach($images as $image)
                <div class="col-md-2 col-xl-2" id="{{'my-pic-'.$image->img_id}}">
                    <div class="card mb-4">
                        <img class="card-img-top img-responsive" src="{{'/uploaded/pics/'.$image->filename}}">
                        <div class="card-body">
                            <p class="mb-2"><span class="badge {{$image->approved==1?'badge-success':'badge-dark'}} text-wrap">{{'User Id: '.$image->user_id}}</span></p>

                            @if($image->approved == 1)
                                <button type="button" id="{{'avatar-'.$image->img_id}}" class="mb-1 btn btn-sm btn-green make-avatar" value="{{$image->img_id}}" data-id="{{$image->user_id}}">Avatar</button>
                            @else
                                <button type="button" id="{{'avatar-'.$image->img_id}}" class="mb-1 btn btn-sm btn-green make-avatar" value="{{$image->img_id}}" data-id="{{$image->user_id}}" disabled>Avatar</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- users section ends -->
@endsection

@section('js')
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


    </script>

@endsection

