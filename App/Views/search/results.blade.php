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
                            <button class="btn btn-pink">Profile</button>
                            <button id="{{'contact-btn-'.$profile['id']}}" data-id="{{$profile['id']}}" class="btn btn-orange contact">Contact</button>
                        </div>

                    </div>
                    <div class="profile-handler">
                        <a title="Share on whatsapp" class="share" href="#"><i class="fas fa-share san"></i></a>
                        <a title="Shortlist and Like" class="shortlist" href="#"><i class="fas fa-heart san"></i></a>
                        <a title="Downlist and Hide" class="downlist" href="#"><i class="fas fa-arrow-circle-down san"></i></a>
                    </div>
                </div>
                <div class="ups-ab">
                    <span><i class="fab fa-whatsapp"></i>  7565097233</span>
                    <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                    <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>

                    <div id="{{'ups-ab-overlay-'.$profile['id']}}" class="ups-ab-overlay">  <!--user profiles address bar-->
                        <div class="text">Contact Address</div>
                    </div>
                </div>
            </div>
        @endforeach


    </section>
    <!-- profiles section ends -->

    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <!-- Background of PhotoSwipe.
                 It's a separate element as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>
        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">
            <!-- Container that holds slides.
                      PhotoSwipe keeps only 3 of them in the DOM to save memory.
                      Don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <!--  Controls are self-explanatory. Order can be changed. -->
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End photoswipe -->

@endsection

@section('js')

    <!-- custom js code -->
    <script>

        $(document).ready(function(){
            $(".contact").on("click", function(){
                var dataId = $(this).attr("data-id");
                alert("The data-id of clicked item is: " + dataId);

                var cbtn = document.getElementById("contact-btn-"+dataId);
                var addr = document.getElementById("ups-ab-overlay-"+dataId);
                addr.style.width= 0;
                addr.style.left= 100;
                cbtn.setAttribute('disabled','disabled');
            });
        });

        // Animated element removal
        function cuteHide(el) {
            el.animate({opacity: '0'}, 150, function(){
                el.animate({height: '0px'}, 150, function(){
                    el.remove();
                });
            });
        }

        $('.downlist').on('click', function(){
            var el = $(this).closest('.profiles-card');
            cuteHide(el);
        });

    </script>

    <!-- Core JS file -->
    <script src="/pswipe/photoswipe.min.js"></script>

    <!-- UI JS file -->
    <script src="/pswipe/photoswipe-ui-default.min.js"></script>

    <script>
        'use strict';

        /* global jQuery, PhotoSwipe, PhotoSwipeUI_Default, console */

        (function($) {

            // Define click event on gallery item
            $('.ju-album').click(function(event) {

                // Init empty gallery array
                var container = [];
                var eid = $(this).data('id');

                // Prevent location change
                event.preventDefault();

                // Loop over gallery items and push it to the array
                $('#gallery'+eid).find('figure').each(function() {
                    var $link = $(this).find('a'),
                        item = {
                            src: $link.attr('href'),
                            w: $link.data('width'),
                            h: $link.data('height'),
                            title: $link.data('caption')
                        };

                    container.push(item);
                });

                // Prevent location change
                event.preventDefault();

                // Define object and gallery options
                var $pswp = $('.pswp')[0],
                    options = {
                        index: $(this).parent('figure').index(),
                        bgOpacity: 0.85,
                        showHideOpacity: true
                    };

                // Initialize PhotoSwipe
                var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                gallery.init();
            });

        }(jQuery));
    </script>

@endsection