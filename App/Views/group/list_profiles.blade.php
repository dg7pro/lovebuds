@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
   {{-- <link rel="stylesheet" href="/css/select2.min.css">--}}
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
                       {{-- <img src="{{'/img/pp1.jpg'}}" alt="">--}}
                        @if(!isset($profile['pics']))

                            <img src="{{$profile['gender']==1?'/img/avatar_groom.jpg':'/img/avatar_bride.jpg'}}"  width="135px" height="auto" alt="" class="profile-sqr-image mb-3">

                        @else
                            <div id="gallery{{$profile['id']}}" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
                                @foreach($profile['pics'] as $pic)
                                    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                    <a href="/uploads/pics/{{ $pic['fn'] }}" data-id="{{$profile['id']}}" class="ju-album2" data-caption="{{$profile['first_name'] . $profile['last_name']}}" data-width="600" data-height="800" itemprop="contentUrl">
                                        <img src="/uploads/tmb/tn_{{$pic['fn']}}" alt="thumbnail" width="135px" class="profile-sqr-image"{{$pic['pp']!=1?'hidden':''}}>
                                    </a>
                                </figure>
                                @endforeach
                            </div>
                        @endif


                    </div>
                    <div class="mcard-main">
                        <h4>{{$profile['first_name']}}</h4>
{{--                        <p>B.Tech, Software Developer</p>--}}
                        <p>{{$profile['edu'].', '.$profile['occ']}}</p>
                        <p>{{\Carbon\Carbon::parse($profile['dob'])->age.' yrs, '. $profile['ht'].', '}}
                            {{$profile['religion'].', '.$profile['lang'].', '.$profile['mstatus'].', '}}<em>{{ $profile['caste'].', '.$profile['manglik'].', Income: '.$profile['income'] }}</em>
                                {{ 'Location: '.$profile['district'].', '.$profile['state'].', '.$profile['country'] }}
                        </p>
                        <p> <i class="fab fa-whatsapp text-dark"></i> {{$profile['whatsapp']}} <i class="fas fa-phone text-dark fa-rotate-90 ml-3"></i>  {{$profile['mobile']}}</p>
                        <div>
                            <a class="btn btn-pink" href="/profile/{{$profile['pid']}}" type="button">Profile</a>
                           {{-- <button id="contact-btn-1" data-id=1 class="btn btn-orange contact">Contact</button>--}}
                            <a href="https://wa.me/91{{$profile['mobile']}}?text=Hi I am interested, here is my profile: https://www.jumatrimony.com/profile/{{$authUser->pid}}" target="_blank" id="interest-btn-{{$profile['id']}}" class="btn btn-orange" role="button">
                                <i class="fab fa-whatsapp text-dark"> </i> Interest</a>
                        </div>
                    </div>
                </div>
            @endforeach

                {{-- Kept for reference--}}
            {{--<div class="mcard">
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
            </div>--}}

                {{-- Kept for reference--}}
            {{--<div class="mcard">
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
            </div>--}}


        </div>

    </section>
    <!-- groups section ends -->
    <!-- profiles section ends -->

    @include('modal.photoswipe')

@endsection

@section('js')
    @include('searchJS.pswipeFunctions')
@endsection