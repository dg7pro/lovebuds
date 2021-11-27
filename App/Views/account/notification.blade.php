@extends('layouts.app')

@section('content')

    <!-- login section -->
    <section class="main">

        <h1 class="large text-green">
            Notifications
        </h1>
        <p class="lead"><i class="fas fa-bell text-blue mb-3"> </i> Your recent alerts and notifications</p>
        <div id="records_content">

        </div>

    </section>
    <!-- login ends -->

@endsection

@section('js')


    @include('request.dashboard.notification')
    <script>
        $(document).ready(function(){
            loadNotifications();
            console.log('loaded notification for the first time');
        });
    </script>

@endsection