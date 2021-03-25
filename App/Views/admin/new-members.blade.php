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
                        <li class="breadcrumb-item active" aria-current="page">New Members</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header bg-info card-header-border-bottom">
                        <h2>New Members</h2>
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
                                <th scope="col">Email</th>
                                <th scope="col">ev</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">mv</th>
                                <th scope="col">Active</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($newMembers)>0)
                                @foreach($newMembers as $nm)
                                    <tr>
                                        <td scope="row">{{$nm->id}}</td>
                                        <td>{{$nm->name}}</td>
                                        <td>{{$nm->email}}</td>
                                        <td>{{$nm->ev==1?'Yes':'No'}}</td>
                                        <td>{{$nm->mobile}}</td>
                                        <td>{{$nm->mv==1?'Yes':'No'}}</td>
                                        <td>{{$nm->is_active==1?'Active':'Not active' }}</td>
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


@endsection

