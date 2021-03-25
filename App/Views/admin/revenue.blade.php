@extends('layouts.app')

@section('title', 'Page Title')

{{--@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection--}}

@section('app-css')
    <style>
        body.modal-open {
            overflow: auto
        }

        body.scrollable {
            overflow-y: auto
        }
    </style>


@endsection

@section('content')

    <div class="content">

        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin'}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Total Revenue</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header bg-info card-header-border-bottom">
                        <h2>Paid Members</h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-5">These members have paid but not uploaded KYC docs.
                            <span class="badge badge-secondary text-wrap">(Instruction: call the members and ask them to upload kyc docs like aadhar, pan or dl)</span></p>
                        </p>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Paid</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($paidMembers)>0)
                                @foreach($paidMembers as $pm)
                                    <tr>
                                        <td scope="row">{{$pm->id}}</td>
                                        <td>{{$pm->name}}</td>
                                        <td>{{$pm->mobile}}</td>
                                        <td>{{$pm->is_paid==1?'Paid':'Not paid' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td class="text-muted text-center" colspan="4">
                                        <span class="badge badge-danger text-wrap">No user in this table present right now</span>
                                    </td></tr>
                            @endif
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>




        </div>
    </div>


    {{--<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="//placehold.it/300x200" class="img-responsive">
                </div>
            </div>
        </div>
    </div>--}}

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <img class="img-responsive img-fluid" id="kycImage" src="//placehold.it/1000x600">
                    {{--                    Modal body text goes here.--}}
                </div>

            </div>
        </div>
    </div>




@endsection

@section('app-script')

    <script>
        $(document).ready(function(){
            readKYCDocsRecords();
        });

        //=================
        // Read Record
        //=================
        function readKYCDocsRecords() {
            var readrecord = "readrecord";
            $.ajax({
                url: "w-ajax/backend-kyc-docs-approval.php",
                type: "POST",
                data: {
                    readrecord:readrecord
                },
                success: function(data,status){
                    //console.log(data);
                    $('#records_content').html(data);
                }
            })
        }

        function approveKycDocs(imageId,userId){

            var iid = imageId;
            var uid = userId;
            var fn = $('#approve-'+imageId).val();

            console.log('approve button clicked');
            console.log(imageId);
            console.log(fn);
            console.log(userId);

            $.ajax({
                url: "ajax/approve-kyc-docs.php",
                method: 'post',
                data: {
                    uid:uid,
                    iid:iid,        // image id
                    fn:fn           // filename
                },
                dataType: "json",
                success: function (data, status) {
                    // console.log(data.msg);
                    // console.log(data.iid);
                    console.log(data);
                    console.log(status);
                    $('#approve-'+data.iid).attr('disabled','disabled');
                }
            });
        }

        // JU===============================================
        // Verify User who are paid and approved kyc
        // =================================================
        $(document).ready(function () {
            $('.verify-user').on('click', function () {

                var userId = $(this).val();
                var code = "verify-user";

                console.log('verify btn clicked');
                console.log(userId);

                $.ajax({
                    url: "ajax/verify-user.php",
                    method: 'post',
                    data: {
                        code:code,
                        uid:userId
                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(data.msg);
                        console.log(data.uid);
                        console.log(status);
                        if(data.vs === 1){
                            $('#verify-'+data.uid).attr('disabled','disabled');
                        }
                    }
                });
            });
        });

        function getKYCImage(file){
            console.log(file);
            var path = 'http://localhost/jumatrimony/uploaded/kyc/'+file;
            $('#kycImage').attr('src',path);
            $('#myModal').modal("show");

        }

    </script>

@endsection

