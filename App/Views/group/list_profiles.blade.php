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
    <!-- groups section starts -->
    <section class="pageset">
        <div class="container cardset">

            @foreach($profiles as $profile)
                <div class="mcard">
                    <div class="mcard-sidebar">
                        <img src="{{'/img/pp1.jpg'}}" alt="">
                    </div>
                    <div class="mcard-main">
                        <h4>{{$profile->first_name}}</h4>
                        <p>B.Tech, Software Developer</p>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                            Perspiciatis inventore eos ipsam debitis.
                        </p>
                        <div>
                            <button class="btn btn-pink">Profile</button>
                            <button id="contact-btn-1" data-id=1 class="btn btn-orange contact">Contact</button>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mcard">
                <div class="mcard-sidebar">
                    <img src="{{'/img/pp1.jpg'}}" alt="">
                </div>
                <div class="mcard-main">
                    <h4>Dhananjay Gupta</h4>
                    <p>B.Tech, Software Developer</p>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Perspiciatis inventore eos ipsam debitis.
                    </p>
                    <div>
                        <button class="btn btn-pink">Profile</button>
                        <button id="contact-btn-1" data-id=1 class="btn btn-orange contact">Contact</button>
                    </div>
                </div>
            </div>

            <div class="mcard">
                <div class="mcard-sidebar">
                    <img src="{{'/img/pp1.jpg'}}" alt="">
                </div>
                <div class="mcard-main">
                    <h4>Dhananjay Gupta</h4>
                    <p>B.Tech, Software Developer</p>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Perspiciatis inventore eos ipsam debitis.
                    </p>
                    <div>
                        <button class="btn btn-pink">Profile</button>
                        <button id="contact-btn-1" data-id=1 class="btn btn-orange contact">Contact</button>
                    </div>
                </div>
            </div>


        </div>

    </section>
    <!-- groups section ends -->
    <!-- profiles section ends -->



@endsection

@section('js')

@endsection