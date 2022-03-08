@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Send Bulk Email/SMS
        </h3>

        @include('layouts.partials.alert')

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bulk Messaging</li>
                    </ol>
                </nav>
            </div>
        </div>


        <div class="table-responsive mt-5" id="dynamic_content">
            <h5 class="text-primary">Send Bulk Email:</h5>
            <form action="{{'/admin/send-photo-upload-message'}}" method="post">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Select</th>

                    </tr>
                    @foreach($nonPhotoUsers as $user)
                        <tr>
                            <td>{{$user['id']}}</td>
                            <td>{{$user['first_name']}}</td>
                            <td>{{$user['email']}}</td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="email_list[]" value="{{$user['id']}}" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Send Email
                                    </label>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </table>
                <button type="submit" class="btn btn-green">Send Message</button>
            </form>
        </div>



    </section>
    <!-- users section ends -->


@endsection

@section('js')


@endsection
