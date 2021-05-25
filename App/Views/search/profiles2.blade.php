@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
{{--    <style>--}}
{{--        #loader-icon {top: 60%;width:100%;height:100%;text-align:center;}--}}
{{--        .display-off{--}}
{{--            display: none;--}}
{{--        }--}}
{{--    </style>--}}
@endsection

@section('content')

    <section class="profiles-buttons">
        <div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="btn btn-pink nav-item" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                       role="tab" aria-controls="pills-home" aria-selected="true">
                        <i class="fas fa-user-circle text-white"></i>
                        New Profiles
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-yellow nav-item shortlisted-profiles" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                       role="tab" aria-controls="pills-profile" aria-selected="false">
                        <i class="fab fa-black-tie text-white"></i>
                        Shortlisted
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="btn btn-blue nav-item recent_visitor" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                       role="tab" aria-controls="pills-contact" aria-selected="false">
                        <i class="fas fa-graduation-cap text-white"></i>
                        Recent Visitor
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <div class="tab-content" id="pills-tabContent">

        <!-- My Profile -->
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

            <h4 class="text-center text-secondary">-- New Profiles --</h4>

            <section class="profiles" id="new-profiles">
               {{-- @foreach($new_profiles as $profile)
                    <div class="profiles-card">

                        <!-- Main Section -->
                        <div class="main-card">
                            <div class="profile-sidebar">

                                @if(!isset($profile['pics']))

                                    <img src="{{'/img/'.($profile['gender']==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" class="profile-image" width="135px" alt="User Image1" />

                                @else

                                <!-- Galley wrapper that contains all items -->
                                    <div id="{{'gallery'.$profile['id']}}" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
                                    @foreach($profile['pics'] as $pic)

                                        <!-- Use figure for a more semantic html -->
                                            <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                <!-- Link to the big image, not mandatory, but usefull when there is no JS -->
                                                <a href="{{'/uploaded/pics/'.$pic['fn']}}" data-id="{{$profile['id']}}" class="ju-album"  data-caption="Sea side, south shore<br><em class='text-muted'>© Dominik Schröder</em>" data-width="600" data-height="800" itemprop="contentUrl">
                                                    <!-- Thumbnail -->
                                                    <img src="{{'/uploaded/tmb/tn_'.$pic['fn']}}" alt="jgjt" width="135px" class="profile-image" {{($pic['pp']!=1)?'hidden':''}}>
                                                </a>
                                            </figure>
                                        @endforeach
                                    </div>


                                @endif
                                <p class="profile-bio">{{\Carbon\Carbon::parse($profile['dob'])->age}} yrs, {{$profile['ht']}}<br>{{$profile['town']}}</p>

                            </div>
                            <div class="profile-main">
                                <h2 class="profile-name">{{$profile['first_name']}}</h2>
                                <p class="profile-position">{{$profile['edu']}}, {{$profile['occ']}}</p>
                                <p class="profile-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis inventore eos ipsam debitis.
                                </p>
                                <div>
                                    <button class="btn btn-pink">Profile</button>
                                    @if($authUser)
                                        --}}{{--<button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact">Contact</button>--}}{{--
                                        <button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact" --}}{{--onclick="viewAddress({{$profile['id']}})"--}}{{-- --}}{{--{{in_array($profile['id'],$address_request_array)?'disabled':''}}--}}{{-->Contact</button>
                                    @else
                                        <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contactc</button>
                                    @endif
                                </div>

                            </div>
                            <div class="profile-handler">
                                <a title="Share on whatsapp" class="share" href="javascript:void(0)"><i class="fas fa-share san"></i></a>
                                <a title="Shortlist and Like" data-id="{{$profile['id']}}" class="shortlist" href="javascript:void(0)"><i class="fas fa-heart san"></i></a>
                                <a title="Downlist and Hide" data-id="{{$profile['id']}}" class="downlist" href="javascript:void(0)"><i class="fas fa-arrow-circle-down san"></i></a>
                            </div>
                        </div>
                        <div class="ups-ab">
                            <span><i class="fab fa-whatsapp"></i>  7565097233</span>
                            <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                            <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>

                            <div id="{{'ups-ab-overlay-'.$profile['id']}}" class="ups-ab-overlay">
                                <!--user profiles address bar-->
                                <div class="text">Contact Address</div>
                            </div>
                        </div>
                    </div>
                @endforeach--}}
            </section>

        </div>
        <!-- My Profile end -->

        <!-- My Album -->
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <h4 class="text-center text-secondary">-- Shortlisted Profiles --</h4>

            <section class="profiles" id="shortlisted-profiles">
                {{--@foreach($short_profiles as $profile)
                    <div class="profiles-card">

                        <!-- Main Section -->
                        <div class="main-card">
                            <div class="profile-sidebar">

                                @if(!isset($profile['pics']))

                                    <img src="{{'/img/'.($profile['gender']==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" class="profile-image" width="135px" alt="User Image1" />

                                @else

                                <!-- Galley wrapper that contains all items -->
                                    <div id="{{'gallery'.$profile['id']}}" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
                                    @foreach($profile['pics'] as $pic)

                                        <!-- Use figure for a more semantic html -->
                                            <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                <!-- Link to the big image, not mandatory, but usefull when there is no JS -->
                                                <a href="{{'/uploaded/pics/'.$pic['fn']}}" data-id="{{$profile['id']}}" class="ju-album"  data-caption="Sea side, south shore<br><em class='text-muted'>© Dominik Schröder</em>" data-width="600" data-height="800" itemprop="contentUrl">
                                                    <!-- Thumbnail -->
                                                    <img src="{{'/uploaded/tmb/tn_'.$pic['fn']}}" alt="jgjt" width="135px" class="profile-image" {{($pic['pp']!=1)?'hidden':''}}>
                                                </a>
                                            </figure>
                                        @endforeach
                                    </div>


                                @endif
                                <p class="profile-bio">{{\Carbon\Carbon::parse($profile['dob'])->age}} yrs, {{$profile['ht']}}<br>{{$profile['town']}}</p>

                            </div>
                            <div class="profile-main">
                                <h2 class="profile-name">{{$profile['first_name']}}</h2>
                                <p class="profile-position">{{$profile['edu']}}, {{$profile['occ']}}</p>
                                <p class="profile-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                    Perspiciatis inventore eos ipsam debitis.
                                </p>
                                <div>
                                    <button class="btn btn-pink">Profile</button>
                                    @if($authUser)
                                        --}}{{--<button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact">Contact</button>--}}{{--
                                        <button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact" --}}{{--onclick="viewAddress({{$profile['id']}})"--}}{{-- --}}{{--{{in_array($profile['id'],$address_request_array)?'disabled':''}}--}}{{-->Contact</button>
                                    @else
                                        <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contactc</button>
                                    @endif
                                </div>

                            </div>
                            <div class="profile-handler">
                                <a title="Share on whatsapp" class="share" href="javascript:void(0)"><i class="fas fa-share san"></i></a>
                                <a title="Shortlist and Like" data-id="{{$profile['id']}}" class="shortlist" href="javascript:void(0)"><i class="fas fa-heart san"></i></a>
                                <a title="Downlist and Hide" data-id="{{$profile['id']}}" class="downlist" href="javascript:void(0)"><i class="fas fa-arrow-circle-down san"></i></a>
                            </div>
                        </div>
                        <div class="ups-ab">
                            <span><i class="fab fa-whatsapp"></i>  7565097233</span>
                            <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                            <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>

                            <div id="{{'ups-ab-overlay-'.$profile['id']}}" class="ups-ab-overlay">
                                <!--user profiles address bar-->
                                <div class="text">Contact Address</div>
                            </div>
                        </div>
                    </div>
                @endforeach--}}
            </section>

        </div>
        <!-- My Album end -->

        <!-- Notifications -->
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <h4 class="text-center text-secondary">-- Recent profile visitors-- </h4>
{{--            <div id="loader-icon">--}}
{{--                <img src="/img/LoaderIcon.gif" alt="">--}}
{{--            <div>--}}
            <section class="profiles" id="recent-profile-visitor">

            </section>

        </div>
    </div>


    <!-- profiles section starts -->

    <!-- profiles section ends -->


    @include('modal.signup-login')
    @include('modal.photoswipe')




@endsection

@section('js')

    {{--@include('request.view_address')
    @include('request.view_photo')--}}

    @include('searchJS.pswipeFunctions')
    @include('searchJS.moveFunctions')

    <!-- custom js code -->
    <script>

        $(document).ready(function(){
            $(".contact").on("click", function(){
                console.log('fucked');
                var dataId = $(this).attr("data-id");
                //alert("The data-id of clicked item is: " + dataId);

                var cbtn = document.getElementById("contact-btn-"+dataId);
                var addr = document.getElementById("ups-ab-overlay-"+dataId);
                addr.style.width= 0;
                addr.style.left= 100;
                setTimeout(function(){
                    toastr.success('Contact number is visible now');
                }, 1000);

                cbtn.setAttribute('disabled','disabled');
            });
        });



        function fucked(id){
            console.log('contact clicked');
            console.log(id);
            alert("The data-id of clicked item is: " + id);

            $.ajax({
                url: "/ajax/show-contact",
                method: 'post',
                data: {
                    other_id:id
                },
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                    setTimeout(function(){
                        toastr.success(data);
                    }, 1000);
                    //$('#hide-profile').addClass('disabled');
                }
            });

            var cbtn = document.getElementById("contact-btn-"+id);
            var addr = document.getElementById("ups-ab-overlay-"+id);
            addr.style.width= 0;
            addr.style.left= 100;
            cbtn.setAttribute('disabled','disabled');
        }






    </script>

   @include('searchJS.loadFunctions')

@endsection