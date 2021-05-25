@extends('layouts.app')


@section('page_css')

    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">

@endsection


@section('content')

    <!-- userprofile (up) section starts -->
    <section class="profile">

        <div class="up-card">

            <!-- Main Section -->
            <div class="up-header">
                <div class="up-sidebar">
                    {{--<a href=""><img class="up-image" src="../img/pp1.jpg" alt=""></a>--}}
                    @if(empty($images))
                        <img class="up-image" src="{{'/img/'.($profile->gender==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" alt="user image">
                    @else
                    <!-- Galley wrapper that contains all items -->
                        <div id="gallery" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
                            <!-- Use figure for a more semantic html -->
                            @foreach($images as $image)
                                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                    <!-- Link to the big image, not mandatory, but usefull when there is no JS -->
                                    <a href="{{'/uploaded/pics/'.$image->filename}}" data-id="{{$profile->id}}" class="ju-album"
                                       data-caption="Sea side, south shore<br><em class='text-muted'>© Dominik Schröder</em>"
                                       data-width="600" data-height="800" itemprop="contentUrl">
                                        <!-- Thumbnail -->
                                        <img class="up-image" src="{{'/uploaded/tmb/tn_'.$image->filename}}" alt="user image 2" {{$image->pp!=1?'hidden':''}}>
                                    </a>
                                </figure>
                            @endforeach
                        </div>
                    @endif
                    <p class="up-bio">27 yrs, 5'7"<br>Varanasi</p>

                </div>

                <div class="up-main">
                    <h2 class="profile-name">{{ucfirst($authUser->first_name).' '.ucfirst($authUser->last_name)}}</h2>
                    <p class="profile-position">B.Tech, Software Developer</p>
                    <p class="profile-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Perspiciatis inventore eos ipsam debitis.
                    </p>
                    <div>
                        <button class="btn btn-pink">Album</button>
                        <button id="contact-btn" class="btn btn-orange">Contact</button>
                    </div>
                </div>
            </div>

            <!-- Handler Bar -->
            <div class="up-neck">
                <div class="up-handler">
                    <a title="Share on whatsapp" class="handle" href="#"><i class="fas fa-share sun"></i></a>
                    <a title="Shortlist and Like" class="handle" href="#"><i class="fas fa-heart sun"></i></a>
                    <a title="Downlist and Hide" class="handle" href="#"><i class="fas fa-arrow-circle-down sun"></i></a>
                </div>

                <!-- Address Bar -->
                <div class="up-address">
                    <span><i class="fab fa-whatsapp"></i>  7565097233</span>
                    <span><i class="fas fa-phone-alt"></i>  7565097233</span>
                    <span><i class="far fa-envelope"></i> dg7proj@gmail.com</span>

                    <div id="contact-address-overlay" class="address-overlay">
                        <div class="text">Contact Address</div>
                    </div>
                </div>



            </div>

            <div class="up-body">
                <h4>About Him</h4>
                <div class="resume-content">

                    <div class="resume-body">
                        <h5 class="text-primary"><i class="fa fa-user mr-2"></i>Basic Infomation:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Name</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{$profile->first_name.' '.$profile->last_name}}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Gender</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{$profile->gender==1?'Male':'Female'}}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Birthday</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{$profile->dob}}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Marital Status</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{($profile->mstatus)?$profile->mstatus:'Not Provided'}}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Height</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{($profile->ht)?$profile->ht:'Not Provided'}}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Complexion</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Wheatish</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Religion</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{($profile->religion)?$profile->religion:'Not Provided'}}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Mother Tongue</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{{($profile->lang)?$profile->lang:'Not Provided'}}</span>
                            </div>

                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-success"><i class="fa fa-graduation-cap mr-2"></i>Education & Career:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Highest Education</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">BE/B.Tech</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Degree</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Not Provided</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">University</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Not Provided</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Other Degrees</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Not Provided</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Occupation</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Sports Person</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Working In</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Not Provided</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Annual Income</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Not Provided</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Sector</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Not Provided</span>
                            </div>
                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-info"><i class="fa fa-users mr-2"></i>Family Details:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Father</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Service-Govt./PSU</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Mother</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Teacher</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Brother</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">2 of which married 1</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Sister</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">3 of which married 2</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Origin</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Indian UP</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Status</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Upper Middle</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Income</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Rs. 20-25 lakh</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Type</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Nuclear Family</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Values</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Liberal</span>
                            </div>

                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-warning"><i class="fa fa-heart mr-2"></i>Lifestyle & Others:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Diet</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Vegetarian</span>
                            </div>

                            <div class="bio">
                                <span class="bio-field">Smoke</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">No</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Drink</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">No</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Body Type</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Average</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Weight</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">59kg</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Blood</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">B+</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Hiv+</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">No</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Thalassemia</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">No</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Challenged</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">No</span>
                            </div>
                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-danger"><i class="fa fa-star mr-2"></i>Horoscope/Kundli/Astro:</h5>

                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Manglik Status</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Manglik</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Rashi(Moon sign)</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Sagitarus</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Sun Sign</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Leo</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Nakshatra</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Aswain</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Birth Details</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">17-Dec-1982 10:20pm Varanasi</span>
                            </div>

                        </div>
                    </div>

                </div>




            </div>

        </div>
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

@endsection

@section('js')
    <!-- custom js code -->
    <script>
        var btn1 = document.getElementById("contact-btn");
        var addr = document.getElementById("contact-address-overlay")

        // When the user clicks the button, open the modal
        btn1.onclick = function() {
            addr.style.width= 0;
            addr.style.left= 100;
            btn1.setAttribute('disabled','disabled');
        }
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
                $('#gallery').find('figure').each(function() {
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

