@extends('layouts.app')

@section('content')

    <!-- registration section -->
    <section class="main">
        <h2 class="large text-heading">
            Administrator Dashboard
        </h2>

        <div class="admin">

            <div class="admin-box">
                <h5 class="admin-title">Users/Members</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="{{'/admin/list-users'}}" class="btn btn-blue">Users/Members </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">Users/Members</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="/admin/list-group" class="btn btn-yellow">Users/Members </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">Users/Members</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="/admin/list-group" class="btn btn-green">Users/Members </a>
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


