@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Aadhaar Verification
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Aadhaar Verification</li>
                    </ol>
                </nav>
            </div>
        </div>


        <div class="table-responsive" id="dynamic_content">
            <label>Pending Aadhaar Verification</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>age</th>
                    <th>image</th>
                    <th>action</th>
                    <th>mobile</th>
                    <th>mv</th>
                    <th>aadhaar</th>
                </tr>

                @foreach($cards as $card)
                <tr>
                    <td>{{$card['id']}}</td>
                    <td>{{$card['fn']}}</td>
                    <td>{{$card['dob']}}</td>
                    {{--  <td><a class="btn btn-pink btn-sm" role="button" data-toggle="modal" data-target="#aadhaarModal">View</a></td>--}}
                    <td><button onclick="changeImages('{{$card['ids'][0]}}', '{{$card['ids'][1]}}')" type="button" class="btn btn-sm btn-pink">View</button></td>
                    {{--                    <td><a href="" class="btn btn-yellow btn-sm" role="button">Ok</a></td>--}}
                    <td>
                        @if($card['dealt']==true)
                            <button type="button" class="mb-1 btn btn-sm btn-yellow disabled" value="" data-id="">Ok</button>
                        @else
                            <button type="button" id="{{'verify-'.$card['img_id']}}" class="mb-1 btn btn-sm btn-yellow verify-aadhaar" value="{{$card['img_id']}}" data-id="{{$card['id']}}">Ok</button>
                        @endif
                    </td>
                    <td>{{$card['mb']}}</td>
                    <td>{{$card['mv']}}</td>
                    <td>{{$card['aadhar']}}</td>

                </tr>
                @endforeach

            </table>
        </div>

    </section>
    <!-- users section ends -->

    @include('modal.aadhaar-ids')

@endsection

@section('js')
    <script>
        function changeImages(front,back){
            // console.log('Loading images...');
            // console.log(front);
            // console.log(back);

            document.getElementById("front-img").src="/uploads/aadhaar/"+front;
            document.getElementById("back-img").src="/uploads/aadhaar/"+back;
            $('#aadhaarModal').modal("show");
        }

        $(document).ready(function () {
            $('.verify-aadhaar').on('click', function () {

                var imgId = $(this).val();
                var usrId = $(this).data('id');
                var code = "verify-aadhaar";

                console.log('verify aadhaar clicked');
                console.log(imgId);
                console.log(usrId);

                $.ajax({
                    url: "/adjax/verifyAadhaar",
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
                            $('#verify-'+data.iid).attr('disabled','disabled');
                            //$('#reject-'+data.iid).removeAttr('disabled','disabled');
                        }
                    }
                });

            });
        });



    </script>

@endsection
