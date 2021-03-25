@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="content">
        <!-- First Row  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#about" role="tab" aria-controls="home" aria-selected="true">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#terms" role="tab" aria-controls="home" aria-selected="true">Terms & Conditions</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="profile-tab" data-toggle="tab" href="#privacy" role="tab" aria-controls="profile" aria-selected="false">Privacy Policy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#refund" role="tab" aria-controls="contact" aria-selected="false">Cancellation</a>
                            </li>
                            {{--<li class="nav-item">
                                <a class="nav-link disabled" href="javascript:void(0)">Disabled</a>
                            </li>--}}
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="home" aria-selected="true">Contact Us</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent1">
                            {{--<div class="tab-pane pt-3 fade" id="about" role="tabpanel" aria-labelledby="home-tab">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                            </div>--}}

                            {{--Terms & Conditions--}}
                            @include('company.tabs.about-us')


                            {{--Terms & Conditions--}}
                            @include('company.tabs.tnc')

                            {{--Privacy Policy--}}
                            @include('company.tabs.privacy-policy')

                            {{--Refund & Cancellation Policy--}}
                            @include('company.tabs.refund-policy')

                            {{--Refund & Cancellation Policy--}}
                            @include('company.tabs.contact-us')
                            {{--<div class="tab-pane pt-3 fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

