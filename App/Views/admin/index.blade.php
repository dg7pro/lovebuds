@extends('layouts.app')

@section('content')

    <!-- registration section -->
    <section class="main">
        <h2 class="large text-heading">
            Administrator Section
        </h2>

        <div class="admin">

            <div class="admin-box">
                <h5 class="admin-title">Users/Members</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="{{'/admin/list-users'}}" class="btn btn-blue">Users/Members </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">Photo Approval</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="{{'/admin/photo-approval'}}" class="btn btn-yellow">Approve Photos </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">Avatar Update</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="{{'/admin/make-avatar'}}" class="btn btn-green">Update Avatar </a>
            </div>
            <div class="admin-box"><h5 class="admin-title">Users/Members</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="/admin/list-group" class="btn btn-pink">Users/Members </a></div>
            <div class="admin-box">
                <h5 class="admin-title">Users/Members</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="/admin/list-group" class="btn btn-orange">Users/Members </a>
            </div>
        </div>



    </section>
    <!-- registration ends -->


@endsection


