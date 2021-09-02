@extends('layouts.app')

{{--@section('page_og')
    <meta name="description" content="JU free matrimonial services shaadi, jeevansathi for Indians Bharati">
    <meta property="og:title" content="Profile Page jumatrimony.com free matrimonial services" />
    <meta property="og:url" content="http://www.jumatrimony.com/profile/{{$profile->pid}}" />
    <meta property="og:description" content="JU free matrimonial services shaadi, jeevansathi for Indians Bharati">
    <meta property="og:image" content="http://jumatrimony.com/uploaded/tmb/{{'tn_'.$profile->avatar}}">
@endsection--}}

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
                   {{-- <p class="up-bio">27 yrs, 5'7"<br>Varanasi</p>--}}
                    <p class="up-bio">{{\Carbon\Carbon::parse($profile->dob)->age.' yrs, '.$profile->ht}}<br>{{$profile->district}}</p>
                </div>

                <div class="up-main">
                    <h2 class="profile-name">{{ucfirst($profile->first_name)}}</h2>
                    <p class="profile-position">{{$profile->edu.', '.$profile->occ}}</p>
                   {{-- <p class="profile-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        Perspiciatis inventore eos ipsam debitis.
                    </p>--}}
                    <p class="profile-body">{{$profile->religion.', '.$profile->lang.', '.$profile->mstatus.', '.$profile->caste.', '.$profile->manglik.', Income: '.$profile->income.'/annum, Location: '.$profile->district.', '.$profile->state.', '.$profile->country}}
                    </p>
                    <div>
                        @if($authUser)
                            <a href="https://wa.me/{{'91'.$profile->whatsapp}}?text=Hi I am interested, here is my profile: http://www.jumatrimony.com/profile/{{$profile->pid}}"
                               target="_blank" class="btn btn-pink" role="button" onclick="recordWhatsappInterest({{$profile->id}}); return true;"><i class="fab fa-whatsapp text-dark"> </i> Interest</a>
                            <button id="contact-btn" class="btn btn-orange contact" onclick="viewContactAdd({{$profile->id}})">Contact</button>
                        @else
                            <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#exampleModal"><i class="fab fa-whatsapp text-dark"> </i> Interest</button>
                            <button type="button" class="btn btn-orange" data-toggle="modal" data-target="#exampleModal">Contact</button>
                        @endif

                    </div>
                </div>
                <!-- Handler Bar -->
                <div class="up-handler">
                    <a title="Share on whatsapp" class="handle" href="https://wa.me/?text=This profile seems to be the perfect match - http://www.jumatrimony.com/profile/{{$profile->pid}}" target="_blank"><i class="fas fa-share sun"></i></a>
                    <a title="Shortlist and Like" class="handle"  href="javascript:void(0)" onclick="shortlistProfile({{$profile->id}})"><i class="fas fa-heart sun"></i></a>
                    <a title="Downlist and Hide" class="handle" href="javascript:void(0)"  onclick="hidelistProfile({{$profile->id}})"><i class="fas fa-arrow-circle-down sun"></i></a>
                </div>

            </div>

            <div class="up-neck">
                <!-- Address Bar -->
                <div class="up-address">
                    <div id="load_contact">
                        <span><i class="fab fa-whatsapp"></i>  {{$profile->whatsapp}}</span>
                        <span><i class="fas fa-phone-alt"></i>  {{$profile->mobile}}</span>
                        <span><i class="far fa-envelope"></i> {{$profile->email}}</span>
                    </div>
                    <div id="contact-address-overlay" class="address-overlay">
                        <div class="text">Contact Address</div>
                    </div>
                </div>
            </div>

            <div class="up-body">
                <h4>{{$profile->gender==1?'About Him':'About Her'}}</h4>
                <div class="resume-content">

                    <div class="resume-body">
                        <h5 class="text-primary"><i class="fa fa-user mr-2"></i>Basic Infomation:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Name</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! $profile->first_name.' '.$profile->last_name !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Gender</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! $profile->gender==1?'Male':'Female' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Birthday</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! $profile->dob !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Marital Status</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->mstatus)?$profile->mstatus:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Height</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->ht)?$profile->ht:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Complexion</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->complexion)?$profile->complexion:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Religion</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->religion)?$profile->religion:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Mother Tongue</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->lang)?$profile->lang:'<i>no info</i>' !!}</span>
                            </div>

                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-success"><i class="fa fa-graduation-cap mr-2"></i>Education & Career:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Highest Education</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->edu)?$profile->edu:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Degree</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->deg)?$profile->deg:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">University</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->university)?$profile->university:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Other Degrees</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->other_deg)?$profile->other_deg:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Occupation</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->occ)?$profile->occ:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Working In</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->working_in)?$profile->working_in:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Annual Income</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->income)?$profile->income.' / yr':'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Sector</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->sector)?$profile->sector:'<i>no info</i>'!!}</span>
                            </div>
                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-info"><i class="fa fa-users mr-2"></i>Family Details:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Father</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->father_name)?$profile->father_name:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Work as</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->faa)?$profile->faa:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Mother</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->mother_name)?$profile->mother_name:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Work as</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->maa)?$profile->maa:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Brother</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->bros && $profile->mbros!='')?$profile->bros.' of which married '.$profile->mbros:'<i>no info</i>'!!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Sister</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->sis && $profile->msis!='')?$profile->sis.' of which married '.$profile->msis:'<i>no info</i>'!!}</span>
                            </div>
                            {{--<div class="bio">
                                <span class="bio-field">Origin</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">Indian UP</span>
                            </div>--}}
                            <div class="bio">
                                <span class="bio-field">Family Status</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->fama)?$profile->fama:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Income</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->fami)?$profile->fami.' / yr':'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Type</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->famt)?$profile->famt:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Family Values</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->famv)?$profile->famv:'<i>no info</i>' !!}</span>
                            </div>

                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-warning"><i class="fa fa-heart mr-2"></i>Lifestyle & Others:</h5>
                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Diet</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->diet)?$profile->diet:'<i>no info</i>' !!}</span>
                            </div>

                            <div class="bio">
                                <span class="bio-field">Smoke</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->smoke)?$profile->smoke:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Drink</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->drink)?$profile->drink:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Body Type</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->body)?$profile->body:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Weight</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->weight_id)?$profile->weight_id.' kgs':'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Blood</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->bg)?$profile->bg:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Hiv+</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->hiv)?($profile->hiv==1?'Yes':'No'):'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Thalassemia</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->thal)?$profile->thal:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Challenged</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->chal)?$profile->chal:'<i>no info</i>' !!}</span>
                            </div>
                        </div>
                    </div>

                    <div  class="resume-body">
                        <h5 class="text-danger"><i class="fa fa-star mr-2"></i>Kundli/Astro:</h5>

                        <div class="bio-group">
                            <div class="bio">
                                <span class="bio-field">Manglik Status</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->manglik)?$profile->manglik:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Rashi(Moon sign)</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->rashi)?$profile->rashi:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Sun Sign</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->sun)?$profile->sun:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Nakshatra</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->nak)?$profile->nak:'<i>no info</i>' !!}</span>
                            </div>
                            <div class="bio">
                                <span class="bio-field">Birth Details</span>
                                <span class="bio-colon">:</span>
                                <span class="bio-value">{!! ($profile->kundli_details)? $profile->kundli_details : '<i>no info</i>' !!}</span>
                            </div>

                        </div>
                    </div>

                </div>




            </div>

        </div>
    </section>
    <!-- profiles section ends -->

    @include('modal.signup-login')
    @include('modal.photoswipe')

@endsection

@section('js')

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

    <script>
        @if($authUser)
        $(document).ready(function(){
            recordProfileVisitor();
        });
        function recordProfileVisitor(){

            var uid = '{{$authUser->id}}';
            var pid = '{{$profile->id}}';

            // console.log(uid);
            // console.log(pid);
            $.ajax({

                url: "/AjaxActivity/recordVisitor",
                method: 'post',
                data: {
                    uid: uid,
                    pid: pid
                },
                dataType: "json",
                success: function (data, status) {
                    //console.log(data);
                    //console.log(status);
                    //$('#fav-profile').addClass('disabled');
                }
            });
        }
        @endif
    </script>

    <script>
        // Move profile either to shortlist or hide list
        function moveProfile(receiver,i){
            console.log(receiver);
            console.log(i);
            $.ajax({

                url: "/ajaxActivity/move-profile-to",
                method: 'post',
                data: {
                    receiver: receiver,
                    i:i
                },
                dataType: "json",
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                    setTimeout(function(){
                        toastr.success(data.msg);
                    }, 250);
                    //$('#hide-profile').addClass('disabled');
                }
            });
        }

        function shortlistProfile(id){
            console.log('trying to shortlist profile');
            //Confirm before shortlisting
            $.confirm({
                title: 'It will shortlist this profile',
                content: 'Shortlist favourites profile and then deal one by one',
                icon: 'fa fa-heart',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Shortlist',
                        btnClass: 'btn-blue',
                        action: function(){
                            moveProfile(id,2);
                        }
                    },
                    cancel: function(){},
                }
            });
        }

        function hidelistProfile(id){

            //Confirm before hiding
            $.confirm({
                title: 'It will hide this profile',
                content: 'If this profile don\'t match your criteria, you can hide it permanently',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Hide',
                        btnClass: 'btn-blue',
                        action: function(){
                            moveProfile(id,1);
                        }
                    },
                    cancel: function(){},
                }
            });
        }

        function viewContactAdd(id){
            console.log('contact clicked');
            console.log(id);
            //alert("The data-id of clicked item is: " + id);
            $.confirm({
                title: 'View Contact details ',
                content: 'The number of contacts viewed by you is counted and recorded to fight <strong>spam</strong>',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            $.ajax({

                                url: "/AjaxActivity/show-contact",
                                method: 'post',
                                data: {
                                    other_id:id
                                },
                                dataType: "json",
                                success: function (data, status) {
                                    console.log(data);
                                    console.log(status);
                                    setTimeout(function(){
                                        toastr.success(data.msg);
                                    }, 1000);
                                    //$('#hide-profile').addClass('disabled');
                                    if(data.cc){
                                        $('#load_contact').html(data.addr);
                                    }
                                }
                            });

                            var btn1 = document.getElementById("contact-btn");
                            var addr = document.getElementById("contact-address-overlay");
                            addr.style.width= 0;
                            addr.style.left= 100;
                            btn1.setAttribute('disabled','disabled');

                        }
                    },
                    cancel: function(){
                        $.alert('You clicked <strong>cancel</strong>. Thanx we can\'t continue.');
                    },

                }
            });

        }

        function recordWhatsappInterest(id){
            console.log('send whatsapp clicked');
            console.log(id);
            //alert("The data-id of clicked item is: " + id);

            $.ajax({
                url: "/AjaxActivity/show-contact",
                method: 'post',
                data: {
                    other_id:id
                },
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                }
            });

        }



    </script>

@endsection

