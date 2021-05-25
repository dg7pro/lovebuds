@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
@endsection

@section('content')

    <!-- profiles section starts -->
    <section class="profiles">
        @foreach($profiles as $profile)
            <div class="profiles-card">

                <!-- Main Section -->
                <div class="main-card">
                    <div class="profile-sidebar">
                        {{--<a href=""><img class="profile-image" src="../img/pp1.jpg" alt=""></a>--}}
                        @if(!isset($profile['pics']))
                            <img src="{{'/img/'.($profile['gender']==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" class="profile-image" width="135px" alt="User Image1" />
                            {{--  <img class="profile-image" src="../img/pp1.jpg" width="135px" alt="">--}}
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
                        {{--                        <p class="profile-position">B.Tech, Software Developer</p>--}}
                        <p class="profile-position">{{$profile['edu']}}, {{$profile['occ']}}</p>
                        <p class="profile-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                            Perspiciatis inventore eos ipsam debitis.
                        </p>
                        <div>
                            <button class="btn btn-pink" data-toggle="modal" data-target="#exampleModal">Full Profile</button>
{{--                            <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contact</button>--}}
                            <button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact">View Contact</button>
                        </div>

                    </div>
                    <div class="profile-handler">
                        <a title="Share on whatsapp" class="share" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-share san"></i></a>
                        <a title="Shortlist and Like" class="shortlist" href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-heart san"></i></a>
                        <a title="Downlist and Hide" class="downlist" href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-arrow-circle-down san"></i></a>
                    </div>
                </div>
                <div class="ups-ab">
                    {{--<span><i class="fab fa-whatsapp"></i>  7565097233</span>
                    <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                    <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>--}}
                    <span>Contact Address visible to only registered users</span>

                    <div id="{{'ups-ab-overlay-'.$profile['id']}}" class="ups-ab-overlay">  <!--user profiles address bar-->
                        <div class="text ml-3"></div>
                    </div>
                </div>
            </div>
        @endforeach


    </section>
    <!-- profiles section ends -->

    @include('modal.signup-login')
    @include('modal.photoswipe')


@endsection

@section('js')

    <!-- photoswipe js code -->
    @include('searchJS.pswipeFunctions')

    <script>
        $(document).ready(function(){
            $(".contact").on("click", function(){
                var dataId = $(this).attr("data-id");
                //alert("The data-id of clicked item is: " + dataId);

                var cbtn = document.getElementById("contact-btn-"+dataId);
                var addr = document.getElementById("ups-ab-overlay-"+dataId);
                addr.style.width= 0;
                addr.style.left= 100;
                cbtn.setAttribute('disabled','disabled');
            });
        });

    </script>

    <script>

        //====================
        // For first time load
        //====================
        $(document).ready(function(){
            loadQuickSearchResults();
        });

        //=====================
        // New Profiles
        //=====================
        function loadQuickSearchResults(){

            //console.log(jsonString);
            console.log();



            // $.ajax({
            //     url: "/AjaxSearch/load-new-profiles",
            //     method: "POST",
            //     data:{
            //
            //     },
            //     success:function(data){
            //         $('#new-profiles').html(data);
            //
            //     }
            // });
        }

        /*$('.new-profiles').on('click', function(){
            loadQuickSearchResults();
            console.log('brides button clicked');
        });*/
    </script>




@endsection