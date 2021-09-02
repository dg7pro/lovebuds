@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Photos waiting for Approval
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Photo Approval</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            @foreach($images as $image)
                <div class="col-md-3 col-xl-3" id="{{'my-pic-'.$image->img_id}}">
                    <div class="card mb-4">
                        <img class="card-img-top img-responsive" src="{{'/uploads/pics/'.$image->filename}}">
                        <div class="card-body">
                            <p class="mb-2"><span class="{{$image->pp==1?'badge badge-primary text-wrap':''}} ">{{'User Id: '.$image->user_id}}</span></p>

                            <button type="button" id="{{'reject-'.$image->img_id}}" class="mb-1 btn btn-sm btn-yellow reject-photo" value="{{$image->img_id}}" data-id="{{$image->user_id}}">Rjct.</button>
                            <button type="button" id="{{'approve-'.$image->img_id}}" class="mb-1 btn btn-sm btn-green approve-photo" value="{{$image->img_id}}" data-id="{{$image->user_id}}">Appr.</button>

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

    </script>

@endsection

