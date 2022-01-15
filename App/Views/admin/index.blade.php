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
            <div class="admin-box"><h5 class="admin-title">Site Settings</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="{{'/admin/site-settings'}}" class="btn btn-pink">Admin Settings </a></div>
            <div class="admin-box">
                <h5 class="admin-title">Users Types</h5>
                <p class="admin-text">Complete List and Management of different Courses or Groups</p>
                <a href="{{'/admin/list-user-types'}}" class="btn btn-orange">Users/Members </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">Cleaner</h5>
                <p class="admin-text">Clean the database by deleting useless notifications & images</p>
                <a href="{{'/admin/site-cleaner'}}" class="btn btn-blue">Clean Database </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">User Verification</h5>
                <p class="admin-text">Match user name and age with details given on aadhaar card </p>
                <a href="{{'/admin/verify-aadhaar'}}" class="btn btn-green">Verify Users </a>
            </div>
            <div class="admin-box">
                <h5 class="admin-title">Message App</h5>
                <p class="admin-text">Send bulk email and messages to the users</p>
                <a href="{{'/admin/bulk-message'}}" class="btn btn-yellow">Email Users </a>
            </div>

            <div class="admin-box"><h5 class="admin-title">Group Settings</h5>
                <p class="admin-text">Complete List and Management of different Groups</p>
                <a href="{{'/admin/groupsManager'}}" class="btn btn-pink">Group Settings </a>
            </div>

            <div class="admin-box">
                <h5 class="admin-title">Order Details</h5>
                <p class="admin-text">View list of orders and payments details</p>
                <a href="{{'/admin/order-details'}}" class="btn btn-blue">View Orders </a>
            </div>

            <div class="admin-box">
                <h5 class="admin-title">Offers Management</h5>
                <p class="admin-text">View add and edit Offers for the users to portal</p>
                <a href="{{'/admin/offers-manager'}}" class="btn btn-orange">Offers Manager </a>
            </div>

            <div class="admin-box">
                <h5 class="admin-title">Whatsapp Users</h5>
                <p class="admin-text">Whatsapp users on different occasions & events</p>
                <a href="{{'/admin/whatsapp-users'}}" class="btn btn-yellow">Whatsapp Users </a>
            </div>

            <div class="admin-box">
                <h5 class="admin-title">Whatsapp Clients</h5>
                <p class="admin-text">Whatsapp new unregistered probable clients</p>
                <a href="{{'/admin/input-add-number'}}" class="btn btn-pink">Add</a>
                <a href="{{'/admin/whatsapp-clients'}}" class="btn btn-pink">Send Msg </a>
            </div>

            <div class="admin-box">
                <h5 class="admin-title">Pro Membership</h5>
                <p class="admin-text">Manage, view and handle Pro members</p>
                <a href="{{'/admin/pro-users'}}" class="btn btn-blue">Pro Users</a>
            </div>
        </div>



    </section>
    <!-- registration ends -->


@endsection


