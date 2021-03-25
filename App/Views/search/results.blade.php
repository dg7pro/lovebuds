@extends('layouts.app')

@section('title', 'Page Title')

@section('app-css')
    <!-- Core CSS file -->
    <link rel="stylesheet" href="/pswipe/photoswipe.css">

    <!-- Skin CSS file (styling of UI - buttons, caption, etc.)
         In the folder of skin CSS file there are also:
         - .png and .svg icons sprite,
         - preloader.gif (for browsers that do not support CSS animations) -->
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">

    <style>
        .xyz{
            margin: 0;
        }
    </style>
@endsection

@section('content')

    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Search Results</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <span class="mdi mdi-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            App
                        </li>
                        <li class="breadcrumb-item" aria-current="page">search results</li>
                    </ol>
                </nav>
            </div>

        </div>

        <div class="row">
            @foreach($profiles as $profile)
                <div class="col-lg-6 col-xl-4">
                    <div class="card card-default p-4">
                        <div class="media text-secondary">
                            {{--<img src="/assets/img/user/u-xl-1.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">--}}
                            {{--<img src="https://via.placeholder.com/100x100.jpg?text=JU" class="mr-3 img-fluid rounded" alt="Avatar Image">--}}
                            @if(!isset($profile['pics']))
                                <img src="{{'/images/'.($profile['gender']==1?'avatar_groom.jpg':'avatar_bride.jpg')}}" width="100px" class="mr-3 img-fluid rounded" alt="User Image" />
                            @else
                            <!-- Galley wrapper that contains all items -->
                                <div id="{{'gallery'.$profile['id']}}" class="gallery" itemscope itemtype="http://schema.org/ImageGallery">
                                @foreach($profile['pics'] as $pic)
                                    {{--<img src="{{'uploaded/tmb/tn_'.$pic['fn']}}" alt="..." width="50px" class="rounded">--}}

                                    <!-- Use figure for a more semantic html -->
                                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="xyz">
                                            <!-- Link to the big image, not mandatory, but usefull when there is no JS -->
                                            <a href="{{'/uploaded/pics/'.$pic['fn']}}" data-id="{{$profile['id']}}" class="ju-album"  data-caption="Sea side, south shore<br><em class='text-muted'>© Dominik Schröder</em>" data-width="600" data-height="800" itemprop="contentUrl">
                                                <!-- Thumbnail -->
                                                <img src="{{'/uploaded/tmb/tn_'.$pic['fn']}}" alt="..." width="100px" class="mr-3 img-fluid rounded" {{($pic['pp']!=1)?'hidden':''}}>
                                            </a>
                                        </figure>
                                    @endforeach
                                </div>
                            @endif
                            <div class="media-body">
                                {{--<a href="{{'profile.php?pid='.$profile['pid']}}">
                                    <h5 class="mt-0 mb-2 text-info">{{$profile['first_name']}}
                                     <span class="mr-2 badge badge-secondary">{{$profile['pid']}}</span>
                                </h5>
                                </a>--}}
                                <a href="javascript:0" onclick="getUserProfileInfo({{$profile['id']}})" class="media text-secondary">
                                    <h5 class="mt-0 mb-2 text-info">{{$profile['first_name']}}
                                        <span class="mr-2 badge badge-secondary">{{$profile['pid']}}</span>
                                    </h5>
                                </a>
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-1">
                                        <i class="mdi mdi-map mr-1"></i>
                                        <span>Age: {{\Carbon\Carbon::parse($profile['dob'])->age}}</span>
                                    </li>
                                    <li class="d-flex mb-1">
                                        <i class="mdi mdi-book-open-page-variant mr-1"></i>
                                        <span>Education: {{$profile['edu']}}</span>
                                    </li>
                                    <li class="d-flex mb-1">
                                        <i class="mdi mdi-professional-hexagon mr-1"></i>
                                        <span>Work: {{$profile['occ']}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Contact Modal -->
        <div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-end border-bottom-0">
                        <button type="button" class="btn-edit-icon" data-dismiss="modal" aria-label="Close">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn-dots-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <button type="button" class="btn-close-icon" data-dismiss="modal" aria-label="Close">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <div class="profile-content-left px-4">
                                    <div class="card text-center widget-profile px-0 border-0">
                                        <div class="card-img mx-auto rounded-circle">
                                            <img id="userAvatar" src="" alt="user image" width="100px">
                                        </div>
                                        <div class="card-body">
                                            <h4 class="py-2 text-dark" id="pop-fn"></h4>
                                            {{--<p><a href="#" id="full-profile" class="text-info">~ full profile ~</a></p>--}}
                                            {{--<a class="btn btn-primary btn-pill btn-lg my-4" href="#">Follow</a>--}}
                                            <input type="button" class="btn btn-primary btn-pill btn-lg my-4" id="sendInterest" value="Initiate">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between ">
                                        <div class="text-center pb-4">
                                            <p class="social-button">
                                                <a href="javascript:0" id="like-profile" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                                                    <i class="mdi mdi-thumb-up"></i>
                                                </a>
                                            </p>
                                            <p>Like</p>
                                        </div>
                                        <div class="text-center pb-4">
                                            <p class="social-button">
                                                <a href="javascript:0" id="fav-profile" class="mb-1 btn btn-outline btn-google-plus rounded-circle">
                                                    <i class="mdi mdi-heart"></i>
                                                </a>
                                            </p>
                                            <p>Shortlist</p>
                                        </div>
                                        {{--<div class="text-center pb-4">
                                            <p class="social-button">
                                                <a href="javascript:0" id="hide-profile" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                                                    <i class="mdi mdi-eye-off"></i>
                                                </a>
                                            </p>
                                            <p>Hide</p>
                                        </div>--}}
                                        <div class="text-center pb-4">
                                            <p class="social-button">
                                                <a href="#" id="full-view" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                                                    <i class="mdi mdi-fullscreen"></i>
                                                </a>
                                            </p>
                                            <p>View</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contact-info px-4">
                                    <h4 class="text-dark mb-1">Basic Information:</h4>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                                    <p id="pop-dob">Nov 15, 1990</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Education</p>
                                    <p id="pop-edu">Lorem, ipsum dolor</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Occupation</p>
                                    <p id="pop-occ">Lorem, ipsum dolor</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Others:</p>
                                    <p id="pop-inf">Lorem, ipsum dolor</p>



                                </div>
                            </div>
                            {{--<div class="col-md-4">
                                <div class="contact-info px-4">
                                    <h4 class="text-dark mb-1">Contact Details</h4>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                                    <p>Albrecht.straub@gmail.com</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
                                    <p>+99 9539 2641 31</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                                    <p>Nov 15, 1990</p>
                                    <p class="text-dark font-weight-medium pt-4 mb-2">Event</p>
                                    <p>Lorem, ipsum dolor</p>
                                </div>
                            </div>--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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

@section('app-script')

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

    <script>
        /*======== 5. TOASTER ========*/
        var toaster = $('#toaster');
        function callToaster(positionClass, message) {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: positionClass,
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            toastr.success(message);
        }
    </script>

    <script>
        function getUserProfileInfo(other_id){
            console.log(other_id);
            $.post("/ajax/profile-description",{other_id:other_id},function (data, status) {
                console.log(data);
                var user = JSON.parse(data);
                $('#sendInterest').data('id',user.id).data('flag',user.flag);  // not visible
                $('#pop-fn').html(user.first_name +' '+ user.last_name);
                $('#full-profile').attr('href','/profile/'+user.pid);
                $('#like-profile').attr('onclick','likeProfile('+user.id+')');
                $('#fav-profile').attr('onclick','favProfile('+user.id+')');
                //$('#hide-profile').attr('onclick','hideProfile('+user.id+')');
                $('#full-view').attr('href','/profile/'+user.pid);
                $('#userAvatar').attr('src','/uploaded/tmb/tn_'+user.avatar);

                if(user.flag==9){
                    $('#sendInterest').prop('value','Connected').attr('disabled','disabled');
                }else if(user.flag==8){
                    $('#sendInterest').prop('value','Accept').removeAttr('disabled');
                }else if(user.flag==7){
                    $('#sendInterest').prop('value','Sent').attr('disabled','disabled');
                }else{
                    $('#sendInterest').prop('value','Initiate').removeAttr('disabled');
                }

                (user.like)?$('#like-profile').addClass('disabled'):$('#like-profile').removeClass('disabled');
                (user.fav)?$('#fav-profile').addClass('disabled'):$('#fav-profile').removeClass('disabled');
                (user.hide)?$('#hide-profile').addClass('disabled'):$('#hide-profile').removeClass('disabled');


                $('#pop-dob').html(user.iso + ' '+ user.age);
                $('#pop-edu').html(user.edu);
                $('#pop-occ').html(user.occ);
                $('#pop-inf').html(user.rel+', '+user.lag);

            });
            $('#modal-contact').modal("show");
        }
    </script>

    @include('request.connect_profile')
    @include('request.like_profile')
    @include('request.short_profile')
    @include('request.hide_profile')
@endsection




