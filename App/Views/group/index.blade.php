@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/css/select2.min.css">
    <style>
        .select2-container, .select2-selection--multiple{
            width: 100%!important;
            min-height: 70px!important;
        }

        .select2-container--default, .select2-selection--multiple{
            border-radius: 0!important;
        }

    </style>
@endsection

@section('content')

    <!-- userprofile (up) section starts -->
    <section class="main">
        <h2 class="large text-heading">Group Listing</h2>
        <p>List my profile in following groups</p>

        @include('layouts.partials.alert')

    </section>
    <!-- profiles section ends -->



@endsection

@section('js')

@endsection